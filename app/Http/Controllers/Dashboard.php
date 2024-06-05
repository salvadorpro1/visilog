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
        $fechaMinima = Visitor::orderBy('created_at')->value('created_at');
    
        if (!$fechaMinima) {
            $fechaMinima = Carbon::now()->format('Y-m-d');
        }
        // Definir valores predeterminados para $diadesde y $diahasta
        $diadesde = now()->startOfMonth()->format('Y-m-d');
        $diahasta = now()->endOfMonth()->format('Y-m-d');
    
        // Realizar la consulta inicial para mostrar datos por defecto en la vista
        $visitantesPorGerenciaFilial = Visitor::select('gerencia', 'filial', DB::raw('COUNT(*) as cantidad_visitantes'))
            ->whereBetween('created_at', [Carbon::parse($diadesde)->startOfDay(), Carbon::parse($diahasta)->endOfDay()])
            ->groupBy('gerencia', 'filial')
            ->get();
    
        $visitantesDiarios = Visitor::select(DB::raw('DATE(created_at) as fecha'), DB::raw('COUNT(*) as cantidad_visitantes'))
            ->whereBetween('created_at', [Carbon::parse($diadesde)->startOfDay(), Carbon::parse($diahasta)->endOfDay()])
            ->groupBy('fecha')
            ->get();
    
        $visitantesPorGerencia = Visitor::select('gerencia', DB::raw('COUNT(*) as cantidad_visitantes'))
            ->whereBetween('created_at', [Carbon::parse($diadesde)->startOfDay(), Carbon::parse($diahasta)->endOfDay()])
            ->groupBy('gerencia')
            ->get();
    
        $visitantesPorFilial = Visitor::select('filial', DB::raw('COUNT(*) as cantidad_visitantes'))
            ->whereBetween('created_at', [Carbon::parse($diadesde)->startOfDay(), Carbon::parse($diahasta)->endOfDay()])
            ->groupBy('filial')
            ->get();
    
        // Pasar los datos a la vista
        return view('dashboard.index', [
            'visitantesPorGerenciaFilial' => $visitantesPorGerenciaFilial,
            'visitantesDiarios' => $visitantesDiarios,
            'visitantesPorGerencia' => $visitantesPorGerencia,
            'visitantesPorFilial' => $visitantesPorFilial,
            'diadesde' => $diadesde,
            'diahasta' => $diahasta,
            'fechaMinima' => $fechaMinima
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
    
        $visitantesPorGerenciaFilial = Visitor::select('gerencia', 'filial', DB::raw('COUNT(*) as cantidad_visitantes'))
            ->whereBetween('created_at', [Carbon::parse($diadesde)->startOfDay(), Carbon::parse($diahasta)->endOfDay()])
            ->groupBy('gerencia', 'filial')
            ->get();
    
        $visitantesDiarios = Visitor::select(DB::raw('DATE(created_at) as fecha'), DB::raw('COUNT(*) as cantidad_visitantes'))
            ->whereBetween('created_at', [Carbon::parse($diadesde)->startOfDay(), Carbon::parse($diahasta)->endOfDay()])
            ->groupBy('fecha')
            ->get();
    
        $visitantesPorGerencia = Visitor::select('gerencia', DB::raw('COUNT(*) as cantidad_visitantes'))
            ->whereBetween('created_at', [Carbon::parse($diadesde)->startOfDay(), Carbon::parse($diahasta)->endOfDay()])
            ->groupBy('gerencia')
            ->get();
    
        $visitantesPorFilial = Visitor::select('filial', DB::raw('COUNT(*) as cantidad_visitantes'))
            ->whereBetween('created_at', [Carbon::parse($diadesde)->startOfDay(), Carbon::parse($diahasta)->endOfDay()])
            ->groupBy('filial')
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
