<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filial; // Asegúrate de importar el modelo Filial
use App\Models\Gerencia; // Asegúrate de importar el modelo Gerencia

class FilialController extends Controller
{
    public function index()
    {
        $filiales = Filial::with('gerencias')->get();
        return view('filiales.index', compact('filiales'));
    }

    public function create()
    {
        return view('filiales.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Filial::create($request->all());
        return redirect()->route('filiales.index')->with('success', 'Filial creada exitosamente.');
    }

    public function show(Filial $filial)
    {
        return view('filiales.show', compact('filial'));
    }

    public function edit(Filial $filial)
    {
        return view('filiales.edit', compact('filial'));
    }

    public function update(Request $request, Filial $filial)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $filial->update($request->all());
        return redirect()->route('filiales.index')->with('success', 'Filial actualizada exitosamente.');
    }

    public function destroy(Filial $filial)
    {
        $filial->delete();
        return redirect()->route('filiales.index')->with('success', 'Filial eliminada exitosamente.');
    }
}