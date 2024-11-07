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
            'siglas' => 'required|string|max:255|regex:/^[\p{L}ñÑ\s]+$/',
        ], [
            'nombre.regex' => 'El nombre de la filial solo puede contener letras, espacios, puntos y comas.',
            'siglas.required' => 'Las siglas son obligatorias.',
            'siglas.max' => 'Las siglas no pueden tener más de 255 caracteres.',
            'siglas.regex' => 'Las siglas solo puede contener letras',
        ]);

            // Convertir en mayúsculas
            $data = $request->all();
            $data['nombre'] = mb_strtoupper($data['nombre'], 'UTF-8');

            $data['siglas'] = mb_strtoupper($data['siglas'], 'UTF-8');
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
            'siglas' => 'required|string|max:255|regex:/^[\p{L}ñÑ\s]+$/',
        ], [
            'nombre.regex' => 'El nombre de la filial solo puede contener letras, espacios, puntos y comas.',
            'siglas.required' => 'Las siglas son obligatorias.',
            'siglas.regex' => 'Las siglas solo puede contener letras sin espacios',
            'siglas.max' => 'Las siglas no pueden tener más de 255 caracteres.',
        ]);
        // Convertir en mayúsculas
        $data = $request->all();
        $data['nombre'] = mb_strtoupper($data['nombre'], 'UTF-8');

        $data['siglas'] = mb_strtoupper($data['siglas'], 'UTF-8');    

        $filial->update($data);
        return redirect()->route('filiales.index')->with('success', 'Filial actualizada exitosamente.');
    }

    // public function destroy(Filial $filial)
    // {
    //     $filial->delete();
    //     return redirect()->route('filiales.index')->with('success', 'Filial eliminada exitosamente.');
    // }
}