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
            return view('register.registrationForm', [
                'showAll' => true,
            ]);
        }

        return view('register.registrationForm', [
            'showAll' => false
        ]);
    }
}
