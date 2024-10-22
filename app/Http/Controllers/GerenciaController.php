<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gerencia;
use App\Models\Filial;

class GerenciaController extends Controller
{
    public function index()
    {
        $gerencias = Gerencia::with('filial')->get();
        return view('gerencias.index', compact('gerencias'));
    }

    public function create()
    {
        $filiales = Filial::all();
        return view('gerencias.create', compact('filiales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'filial_id' => 'required|exists:filiales,id',
        ], [
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'filial_id.exists' => 'La filial seleccionada no es válida.',
        ]);
        Gerencia::create($request->all());
        return redirect()->route('gerencias.index')->with('success', 'Gerencia creada exitosamente.');
    }

    public function edit(Gerencia $gerencia)
    {
        $filiales = Filial::all();
        return view('gerencias.edit', compact('gerencia', 'filiales'));
    }

    public function update(Request $request, Gerencia $gerencia)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'filial_id' => 'required|exists:filiales,id',
        ],[
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
        ]);
        $gerencia->update($request->all());
        return redirect()->route('gerencias.index')->with('success', 'Gerencia actualizada exitosamente.');
    }

    public function destroy(Gerencia $gerencia)
    {
        $gerencia->delete();
        return redirect()->route('gerencias.index')->with('success', 'Gerencia eliminada exitosamente.');
    }
}