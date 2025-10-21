<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Visitor;
use App\Models\Filial;
use App\Models\Gerencia;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VisitorsExport;

use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Carbon\Carbon;

class VisitorController extends Controller
{
    public function showConsulForm()
    {
        return view('consult.index');
    }

    public function showRegisterVisitor(Request $request)
    {
        $cedula = $request->input('cedula');
        $nacionalidad = $request->input('nacionalidad', '');

        // Obtener el último registro del visitante (si existe)
        $visitor = Visitor::where('nacionalidad', $nacionalidad)
            ->where('cedula', $cedula)
            ->latest()
            ->first();

        // Último nombre de empresa (si aplica)
        $lastCompanyName = null;
        if ($visitor) {
            $lastCompany = Visitor::where('nacionalidad', $nacionalidad)
                ->where('cedula', $cedula)
                ->where('clasificacion', 'empresa')
                ->latest()
                ->first();
            $lastCompanyName = $lastCompany->nombre_empresa ?? null;
        }

        // Obtener lista de empresas anteriores (distinct), normalizadas y en orden descendente por fecha
        $companies = Visitor::where('nacionalidad', $nacionalidad)
            ->where('cedula', $cedula)
            ->where('clasificacion', 'empresa')
            ->whereNotNull('nombre_empresa')
            ->where('nombre_empresa', '!=', '')
            ->distinct()
            ->pluck('nombre_empresa');

        $ultimaFicha = Visitor::where('cedula', $cedula)
            ->where('nacionalidad', $nacionalidad)
            ->where('tipo_carnet', 'ficha')
            ->whereNotNull('numero_carnet')
            ->orderByDesc('created_at')
            ->value('numero_carnet');


        $filials = Filial::all();

        // Aquí intentamos mantener gerencias para old input si aplica
        $oldFilialId = old('filial_id', $visitor ? $visitor->filial_id : null);
        $oldGerenciaId = old('gerencia_id', $visitor ? $visitor->gerencia_id : null);
        $gerencias = $oldFilialId ? Gerencia::where('filial_id', $oldFilialId)->get() : collect([]);

        return view('register.visitorRegistrationForm', [
            'showAll' => $visitor ? false : true,
            'visitor' => $visitor,
            'nacionalidad' => $nacionalidad,
            'cedula' => $cedula,
            'filials' => $filials,
            'gerencias' => $gerencias,
            'oldGerenciaId' => $oldGerenciaId,
            'lastCompanyName' => $lastCompanyName,
            'companies' => $companies, // <-- lista para el datalist
            'ultimaFicha' => $ultimaFicha, // 👈 se envía a la vista

        ]);
    }

    public function saveVisitor(Request $request)
    {
        // Determinar si el visitante ya existe en la vista
        $visitorExists = $request->input('showAll') === 'false';

        // Si el visitante existe, obtenerlo de la base de datos
        $existingVisitor = $visitorExists
            ? Visitor::where('cedula', $request->input('cedula'))
                ->where('nacionalidad', $request->input('nacionalidad'))
                ->first()
            : null;
        // Verificar que los campos inmutables coincidan con el registro existente en la base de datos
        if ($visitorExists && $existingVisitor) {
            $inputNombre = strtolower(trim($request->input('nombre')));
            $inputApellido = strtolower(trim($request->input('apellido')));
            $inputNacionalidad = trim($request->input('nacionalidad'));

            if (
                $inputNacionalidad !== $existingVisitor->nacionalidad ||
                $inputNombre !== $existingVisitor->nombre ||
                $inputApellido !== $existingVisitor->apellido
            ) {
                return redirect()->back()->withErrors([
                    'cedula' => 'No es posible modificar la cédula, nacionalidad, nombre o apellido del visitante existente.'
                ])->withInput();
            }
        }


        // Verificar si la combinación nacionalidad + cédula ya existe en la base de datos cuando $visitorExists es false
        if (!$visitorExists) {
            $nacionalidad = $request->input('nacionalidad');
            $cedula = $request->input('cedula');

            $existingVisitor = Visitor::where('nacionalidad', $nacionalidad)
                ->where('cedula', $cedula)
                ->first();

            if ($existingVisitor) {
                return redirect()->back()->withErrors([
                    'cedula' => 'Este visitante ya existe en el sistema, vuelva a consultar.'
                ])->withInput();
            }
        }


        if ($visitorExists) {
            // Verifica que se haya encontrado un visitante existente antes de acceder a su cedula
            if ($existingVisitor) {
                $originalCedula = $existingVisitor->cedula;

                if ($request->input('cedula') !== $originalCedula) {
                    return redirect()->back()->withErrors([
                        'cedula' => 'No es posible modificar la cédula del visitante existente.'
                    ])->withInput();
                }
            } else {
                // Si no se encontró el visitante, podrías redirigir con un error
                return redirect()->back()->withErrors([
                    'cedula' => 'No es posible modificar la cédula, nacionalidad, nombre o apellido del visitante existente.'
                ])->withInput();
            }
        }

        // Reglas de validación
        $rules = [
            'tipo_carnet' => 'required|in:visitante,ficha',
            'filial_id' => 'required|exists:filiales,id',
            'gerencia_id' => 'required|exists:gerencias,id',
            'razon_visita' => 'required|max:255',
            'cedula' => 'required',
            'numero_carnet' => 'required',
            'clasificacion' => 'required|in:empresa,persona',
            'telefono' => 'required|digits:11',
            'nombre_empresa' => 'required_if:clasificacion,empresa',
            'nombre' => 'required|regex:/^[\p{L}ñÑ\s]+$/u',
            'apellido' => 'required|regex:/^[\p{L}ñÑ\s]+$/u',
            'nacionalidad' => 'required|in:V,E',
        ];

        $nacionalidad = $request->input('nacionalidad');
        if ($nacionalidad === 'V') {
            $rules['cedula'] .= '|digits_between:4,8';
        } elseif ($nacionalidad === 'E') {
            $rules['cedula'] .= '|digits_between:6,20';
        }
        $messages = [
            'filial_id.required' => 'La filial es requerida.',
            'filial_id.exists' => 'La filial seleccionada no es válida.',
            'gerencia_id.required' => 'La dirección es requerida.',
            'gerencia_id.exists' => 'La dirección seleccionada no es válida.',
            'razon_visita.required' => 'el motivo de visita es requerido.',
            'razon_visita.max' => 'el motivo de visita no puede tener más de 255 caracteres.',
            'foto.required' => 'La foto es requerida.',
            'cedula.required' => 'La cédula es requerida.',
            'cedula.digits_between' => 'La cédula debe tener entre :min y :max dígitos según la nacionalidad.',
            'tipo_carnet.required' => 'El tipo de carnet es requerido.',
            'tipo_carnet.in' => 'El tipo de carnet debe ser visitante o Ficha.',
            'numero_carnet.required' => 'El número de carnet es requerido.',
            'clasificacion.required' => 'La clasificación es requerida.',
            'clasificacion.in' => 'La clasificación debe ser empresa o persona.',
            'telefono.required' => 'El teléfono es requerido.',
            'telefono.digits' => 'El teléfono debe tener exactamente 11 dígitos.',
            'nombre_empresa.required_if' => 'El nombre de la empresa es requerido cuando la clasificación es empresa.',
            'nombre.required' => 'El nombre es requerido.',
            'nombre.regex' => 'El nombre solo debe contener letras y espacios.',
            'apellido.required' => 'El apellido es requerido.',
            'apellido.regex' => 'El apellido solo debe contener letras y espacios.',
            'nacionalidad.required' => 'La nacionalidad es requerida.',
            'nacionalidad.in' => 'La nacionalidad debe ser V o E.'
        ];

        if (!$request->has('no_foto') || $request->input('no_foto') != 'on') {
            $rules['foto'] = 'required';
        }

        // Validar la entrada
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $filialId = $request->input('filial_id');
            $gerencias = [];

            // Cargar gerencias si hay una filial seleccionada
            if ($filialId) {
                $gerencias = Gerencia::where('filial_id', $filialId)->get();
            }

            return redirect()->back()->withErrors($validator)->withInput($request->all())->with([
                'filials' => Filial::all(),
                'gerencias' => $gerencias,
                'visitor' => $existingVisitor ?? null,
            ]);
        }

        // Procesamiento de imagen de la foto si se envía
        $fileName = null;
        if ($request->filled('foto')) {
            $foto = $request->input('foto');
            // Verificar que la cadena tenga formato base64
            if (strpos($foto, 'data:image') === 0) {
                $data = explode(',', $foto);
                if (isset($data[1])) {
                    $imageData = base64_decode($data[1]);
                    $fileName = 'visitor_' . Str::random(10) . '.png';
                    Storage::disk('local')->put('visitors/' . $fileName, $imageData);
                }
            } else {
                // Si no es base64, se asume que es un nombre o ruta ya guardada
                $fileName = $foto;
            }
        }

        // Crear un nuevo registro de visitante
        $visitor = new Visitor();
        $visitor->nacionalidad = $request->input('nacionalidad');
        $visitor->cedula = $request->input('cedula');
        $visitor->nombre = strtolower($request->input('nombre'));
        $visitor->apellido = strtolower($request->input('apellido'));
        $visitor->filial_id = $request->input('filial_id');
        $visitor->gerencia_id = $request->input('gerencia_id');
        $visitor->razon_visita = $request->input('razon_visita');
        $visitor->telefono = $request->input('telefono');
        $visitor->tipo_carnet = $request->input('tipo_carnet');
        $visitor->numero_carnet = $request->input('numero_carnet');
        $visitor->clasificacion = $request->input('clasificacion');
        $nombreEmpresaInput = $request->input('nombre_empresa');
        $nombreEmpresaNormalized = $nombreEmpresaInput ? trim(mb_strtolower($nombreEmpresaInput)) : '';

        $visitor->nombre_empresa = $visitor->clasificacion === 'empresa'
            ? $nombreEmpresaNormalized
            : '';

        $visitor->user_id = auth()->id();

        // Asignar la foto (puede quedar null si no se capturó)
        if (!$request->has('no_foto') || $request->input('no_foto') != 'on') {
            $visitor->foto = $fileName;
        } else {
            $visitor->foto = '';
        }

        $visitor->save();

        if ($visitor->foto) {
            // Actualiza todos los registros con la misma cédula y nacionalidad
            // que tengan la foto vacía o nula
            Visitor::where('cedula', $visitor->cedula)
                ->where('nacionalidad', $visitor->nacionalidad) // <-- aquí añadimos la condición
                ->where(function ($query) {
                    $query->whereNull('foto')
                        ->orWhere('foto', ''); // Incluye campos vacíos
                })
                ->update(['foto' => $visitor->foto]);
        }

        // Redirección según el rol del usuario
        $user = Auth::user();
        if ($user->role == 'operador') {
            return redirect()->route('show_consult')->with('success', 'Los datos se han enviado correctamente.');
        } elseif ($user->role == 'administrador') {
            return redirect()->route('show_Dashboard')->with('success', 'Los datos se han enviado correctamente.');
        }
    }

    public function getGerenciasByFilial($filial_id)
    {
        // Obtener el valor de show_deleted (por defecto 'off')
        $showDeleted = request('show_deleted', 'off');

        // Iniciar la consulta para obtener las gerencias por filial_id
        $query = Gerencia::where('filial_id', $filial_id);

        // Si show_deleted es 'on', incluir las direcciones eliminadas
        if ($showDeleted === 'on') {
            $query->withTrashed(); // Incluir las gerencias eliminadas
        }

        // Obtener las gerencias
        $gerencias = $query->get();

        // Marcar si una gerencia está eliminada
        foreach ($gerencias as $gerencia) {
            $gerencia->is_deleted = $gerencia->trashed(); // Esto agrega el campo 'is_deleted'
        }

        // Devolver las gerencias como una respuesta JSON
        return response()->json($gerencias);
    }

    public function showRegister(Request $request)
    {
        $query = Visitor::query();

        if ($request->has('search') && $request->input('search') != '') {
            $search = strtolower($request->input('search'));

            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(nombre) LIKE ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(cedula) LIKE ?', ['%' . $search . '%']);
            });
        }

        $registros = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('register.showRegistration', compact('registros'));
    }


    public function showRegisterDetail($id)
    {
        $persona = Visitor::where('id', $id)->first();
        return view('register.showRegistrationDetail', ['persona' => $persona]);
    }

    public function consulDate(Request $request)
    {
        $rules = [
            'nacionalidad' => 'required|in:V,E',
            'cedula' => 'required',
        ];
        $nacionalidad = $request->input('nacionalidad');
        if ($nacionalidad === 'V') {
            $rules['cedula'] .= '|digits_between:4,8';
        } elseif ($nacionalidad === 'E') {
            $rules['cedula'] .= '|digits_between:6,20';
        }
        $messages = [
            'nacionalidad.required' => 'La nacionalidad es obligatoria.',
            'nacionalidad.in' => 'La nacionalidad debe ser "V" o "E".',
            'cedula.required' => 'La cédula es obligatoria.',
            'cedula.digits_between' => 'La cédula debe tener entre :min y :max dígitos según la nacionalidad.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $nacionalidad = $request->input('nacionalidad');
        $cedula = $request->input('cedula');

        // Buscar al visitante con la combinación de nacionalidad y cédula
        $visitor = Visitor::where('nacionalidad', $nacionalidad)
            ->where('cedula', $cedula)
            ->latest()  // Ordena por 'created_at' DESC
            ->first();  // Obtiene el último registrado


        // Redirigir al formulario de registro del visitante con los datos encontrados o sin ellos
        return $this->redirectToVisitorRegistrationForm($visitor, $nacionalidad, $cedula);
    }

    private function redirectToVisitorRegistrationForm($visitor, $nacionalidad, $cedula)
    {
        $showAll = !$visitor;

        return redirect()->route('show_register', [
            'showAll' => $showAll,
            'nacionalidad' => $nacionalidad,
            'cedula' => $cedula,
            'visitor' => $visitor,
        ]);
    }

    public function getVisitorPhoto($filename)
    {
        // Verifica si el archivo existe en el disco local
        if (Storage::disk('local')->exists('visitors/' . $filename)) {
            // Devuelve el archivo como una respuesta
            $file = Storage::disk('local')->get('visitors/' . $filename);
            $type = Storage::disk('local')->mimeType('visitors/' . $filename);

            return response($file, 200)->header('Content-Type', $type);
        } else {
            abort(404, 'Imagen no encontrada');
        }
    }

    public function truncateText($text, $length = 50, $ending = '...')
    {
        return Str::limit($text, $length, $ending);
    }

    public function showAccount(Request $request)
    {
        $filial_id = $request->input('filial_id');
        $gerencia_id = $request->input('gerencia_id');
        $diadesde = $request->input('diadesde');
        $diahasta = $request->input('diahasta');
        $showDeleted = $request->input('show_deleted', 'off');  // Valor por defecto 'off'

        // Verifica que se haya seleccionado Filial y las fechas
        if ($filial_id && $diadesde && $diahasta) {
            // Consulta base para los visitantes por filial y fechas
            $visitorQuery = Visitor::query()
                ->where('filial_id', $filial_id)
                ->whereBetween('created_at', [Carbon::parse($diadesde)->startOfDay(), Carbon::parse($diahasta)->endOfDay()]);

            // Si se ha seleccionado una gerencia específica, agregarla a la consulta
            if ($gerencia_id && $gerencia_id !== 'Todas') {
                $visitorQuery->where('gerencia_id', $gerencia_id);
            } else {
                // Si es "Todas las gerencias", filtrar solo las gerencias que pertenecen a la filial seleccionada
                $gerenciasIds = Gerencia::where('filial_id', $filial_id)->pluck('id');
                $visitorQuery->whereIn('gerencia_id', $gerenciasIds);
            }

            // Manejar el estado de 'show_deleted'
            $gerenciasQuery = Gerencia::where('filial_id', $filial_id);
            if ($showDeleted === 'on') {
                $gerenciasQuery->withTrashed(); // Incluir gerencias eliminadas si el checkbox está marcado
            }

            $gerencias = $gerenciasQuery->get();

            // Obtener los visitantes paginados y el total
            $visitors = $visitorQuery->paginate(10)->appends($request->all());
            $visitorCount = $visitors->total();

            return view('account.index', [
                'visitors' => $visitors,
                'visitorCount' => $visitorCount,
                'filial' => Filial::find($filial_id)->nombre,
                'gerencia' => $gerencia_id ? Gerencia::find($gerencia_id)->nombre : 'Todas',
                'diadesde' => $diadesde,
                'diahasta' => $diahasta,
                'filials' => Filial::all(),
                'gerencias' => $gerencias, // Usar las gerencias con o sin eliminadas
                'fechaMinima' => $this->getFechaMinima(),
                'showDeleted' => $showDeleted, // Pasar la variable a la vista
            ]);
        } else {
            // Si no se ha seleccionado Filial o fechas
            return view('account.index', [
                'filials' => Filial::all(),
                'gerencias' => collect(), // Enviar una colección vacía si no hay selección
                'fechaMinima' => $this->getFechaMinima(),
                'showDeleted' => $showDeleted, // Pasar la variable a la vista
            ]);
        }
    }

    public function accountConsul(Request $request)
    {

        // Captura el valor de show_deleted desde el request, por defecto 'off' si no está marcado
        $showDeleted = $request->input('show_deleted', 'off');

        // Validación de datos
        $rules = [
            'filial_id' => 'required|integer',
            'gerencia_id' => 'nullable|integer',
            'diadesde' => 'required|date',
            'diahasta' => 'required|date|after_or_equal:diadesde',
        ];

        // Mensajes personalizados para cada error
        $messages = [
            'filial_id.required' => 'La selección de filial es obligatoria.',
            'filial_id.integer' => 'La filial debe ser un valor numérico válido.',
            'gerencia_id.integer' => 'La gerencia debe ser un valor numérico válido.',
            'diadesde.required' => 'La fecha de inicio es obligatoria.',
            'diadesde.date' => 'La fecha de inicio no es válida.',
            'diahasta.required' => 'La fecha de fin es obligatoria.',
            'diahasta.date' => 'La fecha de fin no es válida.',
            'diahasta.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
        ];

        // Crear validador con reglas y mensajes
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // Si la validación falla, obtener las gerencias para la filial seleccionada
            $filialId = $request->input('filial_id');
            $gerencias = !empty($filialId) ? Gerencia::where('filial_id', $filialId)->get() : [];

            // Redirigir de nuevo con los errores de validación y los datos necesarios
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->all())
                ->with([
                    'filials' => Filial::all(),
                    'gerencias' => $gerencias,
                    'showDeleted' => $showDeleted, // Aseguramos que el checkbox se mantenga
                ]);
        }

        // Procedimiento de consulta
        $filialId = $request->input('filial_id');
        $gerenciaId = $request->input('gerencia_id');
        $diadesde = $request->input('diadesde');
        $diahasta = $request->input('diahasta');

        // Crear la consulta de visitantes
        $visitorQuery = Visitor::query()
            ->where('filial_id', $filialId)
            ->whereBetween('created_at', [Carbon::parse($diadesde)->startOfDay(), Carbon::parse($diahasta)->endOfDay()]);

        // Si se ha seleccionado una gerencia específica, agregarla a la consulta
        if (!is_null($gerenciaId)) {
            $visitorQuery->where('gerencia_id', $gerenciaId);
        }


        // Obtener los visitantes paginados
        $visitors = $visitorQuery->paginate(10)->appends($request->all());
        $visitorCount = $visitors->total();

        // Obtener las gerencias para la filial seleccionada
        $gerencias = Gerencia::where('filial_id', $filialId)->get();

        // Devolver la vista con los datos necesarios
        return view('account.index', [
            'visitors' => $visitors,
            'visitorCount' => $visitorCount,
            'filial_id' => $filialId,
            'gerencia_id' => $gerenciaId,
            'diadesde' => $diadesde,
            'diahasta' => $diahasta,
            'fechaMinima' => $this->getFechaMinima(),
            'filials' => Filial::all(),
            'gerencias' => $gerencias,
            'showDeleted' => $showDeleted,
        ]);
    }

    // Método auxiliar para obtener la fecha mínima
    private function getFechaMinima()
    {
        return Visitor::min('created_at');
    }

    public function downloadReport(Request $request)
    {
        $filial_id = $request->input('filial_id');
        $gerencia_id = $request->input('gerencia_id');
        $diadesde = $request->input('diadesde');
        $diahasta = $request->input('diahasta');

        return Excel::download(new VisitorsExport($filial_id, $gerencia_id, $diadesde, $diahasta), 'reporte_visitantes.xlsx');
    }

}
