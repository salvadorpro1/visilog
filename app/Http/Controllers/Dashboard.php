<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Visitor;


class Dashboard extends Controller
{    

    public function showDashboard(Request $request)
    {
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
        ]);
    }

    public function dashboard(Request $request)
    {
        $request->validate([
            'diadesde' => 'required|date',
            'diahasta' => 'required|date|after_or_equal:diadesde',
        ]);

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
        ]);
    }
    
    }
