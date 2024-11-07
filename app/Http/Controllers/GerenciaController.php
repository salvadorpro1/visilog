<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gerencia;
use App\Models\Filial;

class GerenciaController extends Controller
{
    public function index()
    {
        $gerencias = Gerencia::with('filial')->paginate(10); // Combina 'with' y 'paginate'
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
            'nombre' => 'required|string|max:255|regex:/^[\p{L}ñÑ\s.,]+$/u',
            'filial_id' => 'required|exists:filiales,id',
        ], [
            'nombre.regex' => 'El nombre de la direccion solo puede contener letras y espacios.',
            'filial_id.exists' => 'La filial seleccionada no es válida.',
            'filial_id.required'=> 'Necesita seleccionar una filial ',
        ]);
        $data = $request->all();
        $data['nombre'] = strtoupper($data['nombre']);
        Gerencia::create($data);
        return redirect()->route('gerencias.index')->with('success', 'Dirección registrada exitosamente.');
    }

    public function edit(Gerencia $gerencia)
    {
        $filiales = Filial::all();
        return view('gerencias.edit', compact('gerencia', 'filiales'));
    }

    public function update(Request $request, Gerencia $gerencia)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|regex:/^[\p{L}ñÑ\s.,]+$/u',
            'filial_id' => 'required|exists:filiales,id',
        ],[
            'nombre.regex' => 'El nombre de la direccion solo puede contener letras y espacios.',
            'filial_id.required'=> 'Necesita seleccionar una filial ',
            'filial_id.exists' => 'La filial seleccionada no es válida.',

        ]);
            // Convertir el nombre a mayúsculas
        $data = $request->all();
        $data['nombre'] = strtoupper($data['nombre']);

        $gerencia->update($data);
        
        return redirect()->route('gerencias.index')->with('success', 'Dirección actualizada exitosamente.');
    }

    public function destroy(Gerencia $gerencia)
    {
        $gerencia->delete();
        return redirect()->route('gerencias.index')->with('success', 'Dirección eliminada exitosamente.');
    }
}