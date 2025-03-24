<?php

namespace App\Exports;

use App\Models\Visitor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class VisitorsExport implements FromCollection, WithHeadings
{
    protected $filial_id;
    protected $gerencia_id;
    protected $diadesde;
    protected $diahasta;

    public function __construct($filial_id, $gerencia_id, $diadesde, $diahasta)
    {
        $this->filial_id = $filial_id;
        $this->gerencia_id = $gerencia_id;
        $this->diadesde = $diadesde;
        $this->diahasta = $diahasta;
    }

    public function collection()
    {
        // Consulta los visitantes según los filtros
        $query = Visitor::with('filial', 'gerencia', 'user') // Asegura la carga de relaciones
            ->where('filial_id', $this->filial_id)
            ->whereBetween('created_at', [Carbon::parse($this->diadesde)->startOfDay(), Carbon::parse($this->diahasta)->endOfDay()]);
    
        if ($this->gerencia_id) {
            $query->where('gerencia_id', $this->gerencia_id);
        }
    
        return $query->get()->map(function ($visitor) {
            return [
                'cedula' => $visitor->cedula,
                'nombre' => $visitor->nombre . ' ' . $visitor->apellido, // Se une nombre y apellido
                'created_at' => Carbon::parse($visitor->created_at)->format('d/m/Y H:i:s'), // Fecha detallada
                'filial_id' => $visitor->filial->siglas, // Filial
                'direccion' => $visitor->gerencia->nombre, // Cambiar "Gerencia" a "Dirección"
                'operador' => $visitor->user ? $visitor->user->name : 'Desconocido', // Operador
                'telefono' => $visitor->telefono, // Teléfono
                'razon_visita' => $visitor->razon_visita, // Motivo de la visita (razón_visita)
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Cédula',
            'Nombre Completo',
            'Fecha de Visita', // Modificado para reflejar la fecha detallada
            'Filial',
            'Dirección', // Cambio de "Gerencia" a "Dirección"
            'Operador',
            'Teléfono', // Nuevo encabezado
            'Motivo de la Visita', // Nuevo encabezado
        ];
    }
}