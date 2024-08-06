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
        $request->validate(['nombre' => 'required|string|max:255']);
        Filial::create($request->all());
        return redirect()->route('filiales.index')->with('success', 'Filial creada exitosamente.');
    }

    public function edit(Filial $filial)
    {
        return view('filiales.edit', compact('filial'));
    }

    public function update(Request $request, Filial $filial)
    {
        $request->validate(['nombre' => 'required|string|max:255']);
        $filial->update($request->all());
        return redirect()->route('filiales.index')->with('success', 'Filial actualizada exitosamente.');
    }

    public function destroy(Filial $filial)
    {
        $filial->delete();
        return redirect()->route('filiales.index')->with('success', 'Filial eliminada exitosamente.');
    }
}