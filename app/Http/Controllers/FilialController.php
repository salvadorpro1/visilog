<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filial;
use App\Models\Gerencia;

class FilialController extends Controller
{
    public function index()
    {
        $filiales = Filial::all();
        return view('filiales.index', compact('filiales'));
    }
    

    public function create()
    {
        return view('filiales.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|regex:/^[\p{L}ñÑ\s.,]+$/u',
            'siglas' => 'required|string|max:10|regex:/^[A-ZÑ]+$/u',
        ], [
            'nombre.regex' => 'El nombre de la filial solo puede contener letras, espacios, puntos y comas.',
            'siglas.required' => 'Las siglas son obligatorias.',
            'siglas.regex' => 'Las siglas solo pueden contener letras mayúsculas.',
            'siglas.max' => 'Las siglas no pueden tener más de 10 caracteres.',
        ]);

            // Convertir en mayúsculas
            $data = $request->all();
            $data['nombre'] = strtoupper($data['nombre']);
            $data['siglas'] = strtoupper($data['siglas']);

            Filial::create($data);
            return redirect()->route('filiales.index')->with('success', 'Filial registrada exitosamente.');
    }

    public function edit(Filial $filial)
    {
        return view('filiales.edit', compact('filial'));
    }

    public function update(Request $request, Filial $filial)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|regex:/^[\p{L}ñÑ\s.,]+$/u',
            'siglas' => 'required|string|max:10|regex:/^[A-ZÑ]+$/u',
        ], [
            'nombre.regex' => 'El nombre de la filial solo puede contener letras, espacios, puntos y comas.',
            'siglas.required' => 'Las siglas son obligatorias.',
            'siglas.regex' => 'Las siglas solo pueden contener letras mayúsculas.',
            'siglas.max' => 'Las siglas no pueden tener más de 10 caracteres.',
        ]);
        // Convertir en mayúsculas
        $data = $request->all();
        $data['nombre'] = strtoupper($data['nombre']);
        $data['siglas'] = strtoupper($data['siglas']);
    

        $filial->update($data);
        return redirect()->route('filiales.index')->with('success', 'Filial actualizada exitosamente.');
    }

    // public function destroy(Filial $filial)
    // {
    //     $filial->delete();
    //     return redirect()->route('filiales.index')->with('success', 'Filial eliminada exitosamente.');
    // }
}