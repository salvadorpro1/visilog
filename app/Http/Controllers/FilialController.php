<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD
use App\Models\Filial; // Asegúrate de importar el modelo Filial
use App\Models\Gerencia; // Asegúrate de importar el modelo Gerencia
=======
use App\Models\Filial;
use App\Models\Gerencia;
>>>>>>> recuperacion-commit

class FilialController extends Controller
{
    public function index()
    {
<<<<<<< HEAD
        $filiales = Filial::with('gerencias')->get();
        return view('filiales.index', compact('filiales'));
    }
=======
        $filiales = Filial::all();
        return view('filiales.index', compact('filiales'));
    }
    
>>>>>>> recuperacion-commit

    public function create()
    {
        return view('filiales.create');
    }

    public function store(Request $request)
    {
<<<<<<< HEAD
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

=======
        $request->validate(['nombre' => 'required|string|max:255']);
>>>>>>> recuperacion-commit
        Filial::create($request->all());
        return redirect()->route('filiales.index')->with('success', 'Filial creada exitosamente.');
    }

<<<<<<< HEAD
    public function show(Filial $filial)
    {
        return view('filiales.show', compact('filial'));
    }

=======
>>>>>>> recuperacion-commit
    public function edit(Filial $filial)
    {
        return view('filiales.edit', compact('filial'));
    }

    public function update(Request $request, Filial $filial)
    {
<<<<<<< HEAD
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

=======
        $request->validate(['nombre' => 'required|string|max:255']);
>>>>>>> recuperacion-commit
        $filial->update($request->all());
        return redirect()->route('filiales.index')->with('success', 'Filial actualizada exitosamente.');
    }

    public function destroy(Filial $filial)
    {
        $filial->delete();
        return redirect()->route('filiales.index')->with('success', 'Filial eliminada exitosamente.');
    }
}