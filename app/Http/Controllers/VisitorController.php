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

    public function showRegisterVisitor(Request $request)
    {
        $cedula = $request->input('cedula');
        $visitor = Visitor::where('cedula', $cedula)->first(); // Busca al visitante por la cédula

        if ($visitor) {
            // Si el visitante existe, mostramos solo algunos campos en modo de solo lectura
            return view('register.visitorRegistrationForm', [
                'showAll' => false,
                'visitor' => $visitor,
            ]);
        } else {
            // Si el visitante no existe, mostramos todos los campos en el formulario
            return view('register.visitorRegistrationForm', [
                'showAll' => true,
                'cedula' => $cedula,
            ]);
        }
    }

    public function showRegister()
    {
        $registros = Visitor::paginate(10);
        return view('register.showRegistration', compact('registros'));
    }

    public function consulDate(Request $request)
    {
        $rules = [
            'cedula' => 'required|digits_between:7,8',
        ];

        $messages = [
            'cedula.required' => 'La cédula es obligatoria.',
            'cedula.digits_between' => 'La cédula debe tener entre :min y :max dígitos.',
        ];

        $cedula = $request->input('cedula');

        $visitor = Visitor::where('cedula', $cedula)->first();
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            return $this->redirectToVisitorRegistrationForm($visitor, $cedula);
        }
    }

    private function redirectToVisitorRegistrationForm($visitor, $cedula)
    {
        // Define la variable $showAll basada en si el visitante existe o no
        $showAll = !$visitor;

        // Redirige a la vista 'show_register' con los parámetros adecuados
        return redirect()->route('show_register', [
            'showAll' => $showAll,
            'cedula' => $cedula,
            'visitor' => $visitor // Añade el visitante como parámetro si existe
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
        $visitor->filial = $request->input('filial');
        $visitor->gerencia = $request->input('gerencia');
        $visitor->razon_visita = $request->input('razon_visita');

        $visitor->save();

        return redirect()->route('show_ConsulForm')->with('success', 'Los datos se han enviado correctamente.');
    }
}
