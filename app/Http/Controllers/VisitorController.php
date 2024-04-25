<?php

namespace App\Http\Controllers;

use App\Models\Visitor;

use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function showConsulForm()
    {
        return view('consult.index');
    }

    public function consulDate(Request $request)
    {
        $cedula = $request->input('cedula');

        $visitor = Visitor::where('cedula', $cedula)->first();

        if (!$visitor) {
            return view('register.visitorRegistrationForm.blade', [
                'showAll' => true,
                'cedula' => $cedula
            ]);
        }

        return view('register.visitorRegistrationForm.blade', [
            'showAll' => false,
            'visitor' => $visitor
        ]);
    }

    public function saveVisitor(Request $request)
    {
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
