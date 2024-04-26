<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function showConsulForm()
    {
        return view('consult.index');
    }

    public function showRegister()
    {
        $registros = Visitor::paginate(10);
        return view('register.showRegistration', compact('registros'));
    }

    public function consulDate(Request $request)
    {
        $cedula = $request->input('cedula');

        $visitor = Visitor::where('cedula', $cedula)->first();

        if (!$visitor) {
            return view('register.visitorRegistrationForm', [
                'showAll' => true,
                'cedula' => $cedula
            ]);
        }

        return view('register.visitorRegistrationForm', [
            'showAll' => false,
            'visitor' => $visitor
        ]);
    }
    public function saveVisitor(Request $request)
    {
        // Define las reglas de validación
        $rules = [
            'cedula' => 'required|digits_between:7,8',
            'nombre' => 'required|regex:/^[a-zA-Z\s]+$/',
            'apellido' => 'required|regex:/^[a-zA-Z\s]+$/',
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
        $visitor->cedula = $request->input('cedula');
        $visitor->nombre = $request->input('nombre');
        $visitor->apellido = $request->input('apellido');
        $visitor->filial = $request->input('Subsidiary');
        $visitor->gerencia = $request->input('Management');
        $visitor->razon_visita = $request->input('razon_visita');

        $visitor->save();

        return redirect()->route('show_ConsulForm')->with('success', 'Los datos se han enviado correctamente.');
    }
}
