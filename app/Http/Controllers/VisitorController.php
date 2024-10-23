<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Visitor;
use App\Models\Filial;
use App\Models\Gerencia;

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
    
        if ($visitor) {
            return view('register.visitorRegistrationForm', [
                'showAll' => false,
                'visitor' => $visitor,
                'nacionalidad' => $visitor->nacionalidad,
                'cedula' => $visitor->cedula,
                'filials' => $filials,
                'gerencias' => $gerencias
            ]);
        } else {
            return view('register.visitorRegistrationForm', [
                'showAll' => true,
                'nacionalidad' => $nacionalidad,
                'cedula' => $cedula,
                'filials' => $filials,
                'gerencias' => $gerencias
            ]);
        }
    }
    
    public function getGerenciasByFilial($filial_id)
    {
        $gerencias = Gerencia::where('filial_id', $filial_id)->get();
        
        // Imprimir para debugging
        \Log::info($gerencias);
    
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
    
        $registros = $query->paginate(10);
    
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
        $cedula = $request->input('cedula');
        $nacionalidad = $request->input('nacionalidad');
    
        // Obtener el visitante de la base de datos
        $visitor = Visitor::where('cedula', $cedula)->where('nacionalidad', $nacionalidad)->first();
    
        // Comprobar si el visitante existe
        if (!$visitor) {
            return redirect()->back()->withErrors(['error' => 'Visitante no encontrado.'])->withInput();
        }
    
        // Validar los datos
        $rules = [
            'nacionalidad' => 'required|in:V,E',
            'cedula' => 'required|digits_between:7,8',
            'nombre' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/',
            'apellido' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/',
            'filial_id' => 'required|exists:filiales,id',
            'gerencia_id' => 'required|exists:gerencias,id',
            'razon_visita' => 'required|max:255',
            'foto' => 'required',
        ];
    
        // Mensajes de error personalizados
        $messages = [
            'nacionalidad.required' => 'La nacionalidad es obligatoria.',
            'cedula.required' => 'La cédula es obligatoria.',
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'filial_id.required' => 'La filial es obligatoria.',
            'gerencia_id.required' => 'La gerencia es obligatoria.',
            'razon_visita.required' => 'La razón de visita es obligatoria.',
            'foto.required' => 'La foto es obligatoria.',
        ];
    
        // Validar datos recibidos
        $validator = Validator::make($request->all(), $rules, $messages);
    
        // Comparar datos con los de la base de datos
if ($validator->fails() || 
        !$visitor || // Si el visitante no se encuentra
        $request->input('nombre') !== $visitor->nombre || 
        $request->input('apellido') !== $visitor->apellido ||
        $request->input('foto') !== $visitor->foto || // Para la foto
        $request->input('nacionalidad') !== $visitor->nacionalidad // Para la nacionalidad
    ) {
        return redirect()->back()->withErrors(['error' => 'Los datos proporcionados no coinciden con los registrados.'])->withInput();
    }
    
        // Si se pasa la validación, procesar la foto
        $foto = $request->input('foto');
        if (strpos($foto, 'data:image') === 0) {
            $data = explode(',', $foto);
            $imageData = base64_decode($data[1]);
            $fileName = 'visitor_' . Str::random(10) . '.png';
            Storage::disk('local')->put('visitors/' . $fileName, $imageData);
        } else {
            $fileName = $foto;
        }
    
        // Guardar los cambios
        $visitor->filial_id = $request->input('filial_id');
        $visitor->gerencia_id = $request->input('gerencia_id');
        $visitor->razon_visita = $request->input('razon_visita');
        $visitor->user_id = auth()->id();
        $visitor->foto = $fileName;
        
        $visitor->save();
    
        $user = Auth::user();
        return redirect()->route($user->role == 'operador' ? 'show_consult' : 'show_Dashboard')
                         ->with('success', 'Los datos se han enviado correctamente.');
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
            'gerencia_id.integer' => 'La gerencia debe ser un valor numérico.',
            'diadesde.required' => 'La fecha de inicio es obligatoria.',
            'diadesde.date' => 'La fecha de inicio debe ser una fecha válida.',
            'diahasta.required' => 'La fecha de fin es obligatoria.',
            'diahasta.date' => 'La fecha de fin debe ser una fecha válida.',
            'diahasta.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $validated = $validator->validated();
        $filialId = $validated['filial_id'];
        $gerenciaId = $validated['gerencia_id'];
        $diadesde = $validated['diadesde'];
        $diahasta = $validated['diahasta'];
    
        // Consulta principal
        $visitorQuery = Visitor::query()
            ->where('filial_id', $filialId) // Aplicar filtro por filial siempre
            ->whereBetween('created_at', [Carbon::parse($diadesde)->startOfDay(), Carbon::parse($diahasta)->endOfDay()]);
    
        // Si la gerencia no es nula, aplicamos el filtro de gerencia
        if (!is_null($gerenciaId)) {
            $visitorQuery->where('gerencia_id', $gerenciaId);
        }
    
        // Paginación y total
        $visitors = $visitorQuery->paginate(10)->appends($request->all());
        $visitorCount = $visitors->total();
    
        // Obtener las gerencias correspondientes a la filial seleccionada
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
            'gerencias' => $gerencias, // Pasar las gerencias a la vista
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


}
