<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Dashboard extends Controller
{    
    public function showDashboard(Request $request)
    {
        // Obtener la fecha actual
        $fechaActual = now()->format('Y-m-d');
    
        // Definir valores predeterminados para $diadesde y $diahasta
        $diadesde = $fechaActual;
        $diahasta = $fechaActual;
    
        // Realizar las consultas de la base de datos con las fechas actuales
        $visitantesPorGerenciaFilial = Visitor::select('gerencia_id as gerencia', 'filial_id as filial', DB::raw('COUNT(*) as cantidad_visitantes'))
            ->whereBetween('created_at', [Carbon::parse($diadesde)->startOfDay(), Carbon::parse($diahasta)->endOfDay()])
            ->groupBy('gerencia_id', 'filial_id')
            ->get();
    
        $visitantesDiarios = Visitor::select(DB::raw('DATE(created_at) as fecha'), DB::raw('COUNT(*) as cantidad_visitantes'))
            ->whereBetween('created_at', [Carbon::parse($diadesde)->startOfDay(), Carbon::parse($diahasta)->endOfDay()])
            ->groupBy('fecha')
            ->get();
    
        $visitantesPorGerencia = Visitor::select('gerencia_id as gerencia', DB::raw('COUNT(*) as cantidad_visitantes'))
            ->whereBetween('created_at', [Carbon::parse($diadesde)->startOfDay(), Carbon::parse($diahasta)->endOfDay()])
            ->groupBy('gerencia_id')
            ->get();
    
        $visitantesPorFilial = Visitor::select('filial_id as filial', DB::raw('COUNT(*) as cantidad_visitantes'))
            ->whereBetween('created_at', [Carbon::parse($diadesde)->startOfDay(), Carbon::parse($diahasta)->endOfDay()])
            ->groupBy('filial_id')
            ->get();
    
        // Pasar los datos a la vista
        return view('dashboard.index', [
            'visitantesPorGerenciaFilial' => $visitantesPorGerenciaFilial,
            'visitantesDiarios' => $visitantesDiarios,
            'visitantesPorGerencia' => $visitantesPorGerencia,
            'visitantesPorFilial' => $visitantesPorFilial,
            'diadesde' => $diadesde,
            'diahasta' => $diahasta,
            'fechaMinima' => $this->getFechaMinima(),
        ]);
    }

    public function dashboard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'diadesde' => 'required|date',
            'diahasta' => 'required|date|after_or_equal:diadesde',
        ], [
            'diadesde.required' => 'La fecha de inicio es obligatoria.',
            'diadesde.date' => 'La fecha de inicio no es una fecha válida.',
            'diahasta.required' => 'La fecha de fin es obligatoria.',
            'diahasta.date' => 'La fecha de fin no es una fecha válida.',
            'diahasta.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }
    
        $diadesde = $request->input('diadesde');
        $diahasta = $request->input('diahasta');
    
        $visitantesPorGerenciaFilial = Visitor::select('gerencia_id as gerencia', 'filial_id as filial', DB::raw('COUNT(*) as cantidad_visitantes'))
            ->whereBetween('created_at', [Carbon::parse($diadesde)->startOfDay(), Carbon::parse($diahasta)->endOfDay()])
            ->groupBy('gerencia_id', 'filial_id')
            ->get();
    
        $visitantesDiarios = Visitor::select(DB::raw('DATE(created_at) as fecha'), DB::raw('COUNT(*) as cantidad_visitantes'))
            ->whereBetween('created_at', [Carbon::parse($diadesde)->startOfDay(), Carbon::parse($diahasta)->endOfDay()])
            ->groupBy('fecha')
            ->get();
    
        $visitantesPorGerencia = Visitor::select('gerencia_id as gerencia', DB::raw('COUNT(*) as cantidad_visitantes'))
            ->whereBetween('created_at', [Carbon::parse($diadesde)->startOfDay(), Carbon::parse($diahasta)->endOfDay()])
            ->groupBy('gerencia_id')
            ->get();
    
        $visitantesPorFilial = Visitor::select('filial_id as filial', DB::raw('COUNT(*) as cantidad_visitantes'))
            ->whereBetween('created_at', [Carbon::parse($diadesde)->startOfDay(), Carbon::parse($diahasta)->endOfDay()])
            ->groupBy('filial_id')
            ->get();
    
        return view('dashboard.index', [
            'visitantesPorGerenciaFilial' => $visitantesPorGerenciaFilial,
            'visitantesDiarios' => $visitantesDiarios,
            'visitantesPorGerencia' => $visitantesPorGerencia,
            'visitantesPorFilial' => $visitantesPorFilial,
            'diadesde' => $diadesde,
            'diahasta' => $diahasta,
            'fechaMinima' => $this->getFechaMinima(),
        ]);
    }

    private function getFechaMinima()
    {
        $fechaMinima = Visitor::orderBy('created_at')->value('created_at');
        return $fechaMinima ? Carbon::parse($fechaMinima)->format('Y-m-d') : Carbon::now()->format('Y-m-d');
    }
    }
