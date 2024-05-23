<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;


use App\Models\Visitor;
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
        $nacionalidad = $request->input('nacionalidad', ''); // Default to empty string if not present
        $visitor = Visitor::where('cedula', $cedula)->where('nacionalidad', $nacionalidad)->first();
    
        if ($visitor) {
            return view('register.visitorRegistrationForm', [
                'showAll' => false,
                'visitor' => $visitor,
                'nacionalidad' => $visitor->nacionalidad,
                'cedula' => $visitor->cedula,
            ]);
        } else {
            return view('register.visitorRegistrationForm', [
                'showAll' => true,
                'nacionalidad' => $nacionalidad,
                'cedula' => $cedula,
            ]);
        }
    }

    public function showRegister()
    {
        $registros = Visitor::paginate(10);
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
            'nacionalidad' => 'required',
            'cedula' => 'required|digits_between:7,8',
        ];
    
        $messages = [
            'nacionalidad.required' => 'La nacionalidad es obligatoria.',
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
        // Define las reglas de validación
        $rules = [
            'cedula' => 'required|digits_between:7,8',
            'nombre' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/',
            'apellido' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/',
            'filial' => 'required',
            'gerencia' => 'required',
            'razon_visita' => 'required|max:255',
        ];

        // Define los mensajes de error personalizados
        $messages = [
            'cedula.required' => 'La cédula es obligatoria.',
            'cedula.digits_between' => 'La cédula debe tener entre :min y :max dígitos.',
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios.',
            'filial.required' => 'La filial es obligatoria.',
            'gerencia.required' => 'La gerencia es obligatoria.',
            'razon_visita.required' => 'La razón de visita es obligatoria.',
            'razon_visita.max' => 'La razón de visita no puede tener más de :max caracteres.',
        ];

        // Valida los datos
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si la validación falla, redirige de vuelta con los errores
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Si la validación es exitosa, guarda los datos del visitante
        $visitor = new Visitor();
        $visitor->nacionalidad = $request->input('nacionalidad');
        $visitor->cedula = $request->input('cedula');
        $visitor->nombre = $request->input('nombre');
        $visitor->apellido = $request->input('apellido');
        $visitor->filial = $request->input('filial');
        $visitor->gerencia = $request->input('gerencia');
        $visitor->razon_visita = $request->input('razon_visita');

        $visitor->save();

        return redirect()->route('show_ConsulForm')->with('success', 'Los datos se han enviado correctamente.');
    }

    public function truncateText($text, $length = 50, $ending = '...')
    {
        return Str::limit($text, $length, $ending);
    }

    public function showAccount()
    {
        return view('account.index');
    }


    public function accountConsul(Request $request)
    {
        $validated = $request->validate([
            'filial' => 'required|string',
            'gerencia' => 'required|string',
            'diadesde' => 'required|date',
            'diahasta' => 'required|date|after_or_equal:diadesde',
        ]);

        // Obtener los datos validados
        $filial = $validated['filial'];
        $gerencia = $validated['gerencia'];
        $diadesde = $validated['diadesde'];
        $diahasta = $validated['diahasta'];

        // Realizar la consulta a la base de datos
        $visitorQuery = Visitor::where('filial', $filial)
            ->where('gerencia', $gerencia)
            ->whereBetween('created_at', [Carbon::parse($diadesde)->startOfDay(), Carbon::parse($diahasta)->endOfDay()]);

        // Obtener el conteo total de visitantes
        $visitorCount = $visitorQuery->count();

        // Obtener los visitantes paginados
        $visitors = $visitorQuery->paginate(10);

        // Retornar los resultados a la misma vista
        return view('account.index', [
            'visitors' => $visitors,
            'visitorCount' => $visitorCount,
            'filial' => $filial,
            'gerencia' => $gerencia,
            'diadesde' => $diadesde,
            'diahasta' => $diahasta
        ]);
    }
}
