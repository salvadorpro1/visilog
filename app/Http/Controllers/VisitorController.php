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
        $visitor = Visitor::where('cedula', $cedula)->where('nacionalidad', $nacionalidad)->first();
    
        $filials = Filial::all();
        $gerencias = Gerencia::all();
    
        $oldFilialId = old('filial_id', $visitor ? $visitor->filial_id : null);
        $oldGerenciaId = old('gerencia_id', $visitor ? $visitor->gerencia_id : null);

        $gerencias = $oldFilialId ? Gerencia::where('filial_id', $oldFilialId)->get() : collect([]);

        if ($visitor) {
            return view('register.visitorRegistrationForm', [
                'showAll' => false,
                'visitor' => $visitor,
                'nacionalidad' => $visitor->nacionalidad,
                'cedula' => $visitor->cedula,
                'filials' => $filials,
                'gerencias' => $gerencias,
                'oldGerenciaId' => $oldGerenciaId, // Pasar el valor antiguo de gerencia

            ]);
        } else {
            return view('register.visitorRegistrationForm', [
                'showAll' => true,
                'nacionalidad' => $nacionalidad,
                'cedula' => $cedula,
                'filials' => $filials,
                'gerencias' => $gerencias,
                'oldGerenciaId' => $oldGerenciaId, // Pasar el valor antiguo de gerencia

            ]);
        }
    }
    
    public function getGerenciasByFilial($filial_id)
    {
        $gerencias = Gerencia::where('filial_id', $filial_id)->get();    
        return response()->json($gerencias);
    }

    public function showRegister(Request $request)
    {
        $query = Visitor::query();
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nombre', 'like', '%' . $search . '%')
                  ->orWhere('cedula', 'like', '%' . $search . '%');
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
            'cedula' => 'required|digits_between:7,8',
        ];
    
        $messages = [
            'nacionalidad.required' => 'La nacionalidad es obligatoria.',
            'nacionalidad.in' => 'La nacionalidad debe ser "V" o "E".',
            'cedula.required' => 'La cédula es obligatoria.',
            'cedula.digits_between' => 'La cédula debe tener entre :min y :max dígitos.',
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
                            ->first();
    
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
    
    public function saveVisitor(Request $request)
    {
        // Determinar si el visitante ya existe en la vista
        $visitorExists = $request->input('showAll') === 'false';
    
        // Si el visitante existe, obtenerlo de la base de datos
        $existingVisitor = $visitorExists ? Visitor::where('cedula', $request->input('cedula'))->first() : null;
    
        // Verificar que los campos inmutables coincidan con el registro existente en la base de datos
        if ($visitorExists && $existingVisitor) {
            // Validar que los datos inmutables no hayan cambiado, incluyendo la cédula
            if (
                $request->input('nacionalidad') !== $existingVisitor->nacionalidad ||
                $request->input('nombre') !== $existingVisitor->nombre ||
                $request->input('apellido') !== $existingVisitor->apellido
            ) {
                return redirect()->back()->withErrors([
                    'cedula' => 'No es posible modificar la cédula, nacionalidad, nombre o apellido del visitante existente.'
                ])->withInput();
            }
        }
    
        // Verificar si la cédula ya existe en la base de datos cuando $visitorExists es false
        if (!$visitorExists) {
            $existingVisitor = Visitor::where('cedula', $request->input('cedula'))->first();
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
            'filial_id' => 'required|exists:filiales,id',
            'gerencia_id' => 'required|exists:gerencias,id',
            'razon_visita' => 'required|max:255',
            'cedula' => 'required|digits_between:7,8',
            'numero_carnet' => 'required',
            'clasificacion' => 'required|in:empresa,persona',
            'telefono' => 'required|digits:11',
            'nombre_empresa' => 'required_if:clasificacion,empresa',
            'nombre' => 'required|regex:/^[\p{L}ñÑ\s]+$/u',
            'apellido' => 'required|regex:/^[\p{L}ñÑ\s]+$/u',
            'nacionalidad' => 'required|in:V,E'
        ];

        $messages = [
            'filial_id.required' => 'La filial es requerido.',
            'filial_id.exists' => 'La filial seleccionada no es válida.',
            'gerencia_id.required' => 'La dirección es requerido.',
            'gerencia_id.exists' => 'La dirección seleccionada no es válida.',
        ];

    
        if (!$visitorExists && (!$request->has('no_foto') || $request->input('no_foto') != 'on')) {
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
        if ($request->input('foto')) {
            $foto = $request->input('foto');
            if (strpos($foto, 'data:image') === 0) {
                $data = explode(',', $foto);
                $imageData = base64_decode($data[1]);
                $fileName = 'visitor_' . Str::random(10) . '.png';
                Storage::disk('local')->put('visitors/' . $fileName, $imageData);
            } else {
                $fileName = $foto;
            }
        }
    
        // Crear un nuevo registro de visitante
        $visitor = new Visitor();
        $visitor->nacionalidad = $request->input('nacionalidad');
        $visitor->cedula = $request->input('cedula');
        $visitor->nombre = $request->input('nombre');
        $visitor->apellido = $request->input('apellido');
        $visitor->filial_id = $request->input('filial_id');
        $visitor->gerencia_id = $request->input('gerencia_id');
        $visitor->razon_visita = $request->input('razon_visita');
        $visitor->telefono = $request->input('telefono');
        $visitor->numero_carnet = $request->input('numero_carnet');
        $visitor->clasificacion = $request->input('clasificacion');
        $visitor->nombre_empresa = $request->input('clasificacion') === 'empresa' ? $request->input('nombre_empresa') : '';
        $visitor->user_id = auth()->id();
    
        // Asignar foto si se envía, de lo contrario dejar en null o vacío
        if (!$request->has('no_foto') || $request->input('no_foto') != 'on') {
            $visitor->foto = $fileName;
        } else {
            $visitor->foto = '';
        }
    
        $visitor->save();
    
        // Redireccionar con mensaje de éxito según el rol del usuario
        $user = Auth::user();
        if ($user->role == 'operador') {
            return redirect()->route('show_consult')->with('success', 'Los datos se han enviado correctamente.');
        } elseif ($user->role == 'administrador') {
            return redirect()->route('show_Dashboard')->with('success', 'Los datos se han enviado correctamente.');
        }
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
    
        // Verifica que se haya seleccionado Filial y las fechas
        if ($filial_id && $diadesde && $diahasta) {
            // Consulta base para los visitantes por filial y fechas
            $visitorQuery = Visitor::query()
                ->where('filial_id', $filial_id)  // Aplicar filtro por filial
                ->whereBetween('created_at', [Carbon::parse($diadesde)->startOfDay(), Carbon::parse($diahasta)->endOfDay()]);
    
            // Si se ha seleccionado una gerencia específica, agregarla a la consulta
            if ($gerencia_id && $gerencia_id !== 'Todas') {
                $visitorQuery->where('gerencia_id', $gerencia_id);
            } else {
                // Si es "Todas las gerencias", filtrar solo las gerencias que pertenecen a la filial seleccionada
                $gerenciasIds = Gerencia::where('filial_id', $filial_id)->pluck('id');
                $visitorQuery->whereIn('gerencia_id', $gerenciasIds);
            }
    
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
                'gerencias' => Gerencia::where('filial_id', $filial_id)->get(), // Solo gerencias de la filial seleccionada
                'fechaMinima' => $this->getFechaMinima(),
            ]);
        } else {
            // Si no se ha seleccionado Filial o fechas
            return view('account.index', [
                'filials' => Filial::all(),
                'gerencias' => collect(), // Enviar una colección vacía si no hay selección
                'fechaMinima' => $this->getFechaMinima(),
            ]);
        }
    }
    
    public function accountConsul(Request $request)
    {
        // Validación de datos
        $rules = [
            'filial_id' => 'required|integer',
            'gerencia_id' => 'nullable|integer',
            'diadesde' => 'required|date',
            'diahasta' => 'required|date|after_or_equal:diadesde',
        ];
    
        $messages = [
            'filial_id.required' => 'La filial es obligatoria.',
            'filial_id.integer' => 'La filial debe ser un valor numérico.',
            'gerencia_id.integer' => 'La Dirección debe ser un valor numérico.',
            'diadesde.required' => 'La fecha de inicio es obligatoria.',
            'diahasta.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
        ];
    
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $filialId = $request->input('filial_id');
            // Cargar gerencias basadas en el último valor de filial_id para recarga
            $gerencias = !empty($filialId) ? Gerencia::where('filial_id', $filialId)->get() : [];
    
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->all())
                ->with([
                    'filials' => Filial::all(),
                    'gerencias' => $gerencias,
                ]);
        }
    
        // Procedimiento de consulta y variables para la vista
        $validated = $validator->validated();
        $filialId = $validated['filial_id'];
        $gerenciaId = $validated['gerencia_id'];
        $diadesde = $validated['diadesde'];
        $diahasta = $validated['diahasta'];
    
        $visitorQuery = Visitor::query()
            ->where('filial_id', $filialId)
            ->whereBetween('created_at', [Carbon::parse($diadesde)->startOfDay(), Carbon::parse($diahasta)->endOfDay()]);
    
        if (!is_null($gerenciaId)) {
            $visitorQuery->where('gerencia_id', $gerenciaId);
        }
    
        $visitors = $visitorQuery->paginate(10)->appends($request->all());
        $visitorCount = $visitors->total();
        $gerencias = Gerencia::where('filial_id', $filialId)->get();
    
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
        ]);
    }
    

    // Método auxiliar para obtener la fecha mínima
    private function getFechaMinima()
    {
        return Visitor::min('created_at');
    }

    public function getGerencias($filialId)
    {
    $gerencias = Gerencia::where('filial_id', $filialId)->get();
    return response()->json($gerencias);
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
