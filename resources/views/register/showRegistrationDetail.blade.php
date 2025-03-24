@extends('layouts.app')

@section('title')
    Detalle De Visitantes
@endsection

@section('style')
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fa;
            color: #333;
            line-height: 1.6;
        }

        .details-container {
            max-width: 500px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-transform: uppercase;

        }

        .details-header {
            background-color: #4A90E2;
            color: #fff;
            padding: 15px;
            text-transform: uppercase;
            font-weight: bold;
            text-align: center;
        }

        .details-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 20px;
            border-bottom: 1px solid #e0e0e0;
        }

        .details-item:nth-child(even) {
            background-color: #f9f9f9;
        }

        .details-label {
            font-weight: 600;
            color: #555;
        }

        .details-value {
            color: #333;
            flex: 1;
            text-align: right;
        }

        .details-item-img {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .foto {
            width: 100%;
            max-width: 250px;
            height: auto;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            margin: 20px 0 0 30px;
            background-color: #6C757D;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }


        .desactivate {
            color: #d9534f;
            font-weight: bold;
        }

        .icono {
            width: 40%;

        }
    </style>
@endsection

@section('content')
    <h1 style="text-align: center; margin-bottom: 20px;">Detalle De Visitantes</h1>
    <a class="button" href="{{ url()->previous() }}">Volver</a>
    <div class="details-container">
        <div class="details-header">Detalles del Visitante</div>
        <div class="details-item details-item-img">
            <span class="details-value details-item-img">
                @if (!empty($persona->foto))
                    <img class="foto" src="{{ route('visitor.photo', ['filename' => $persona->foto]) }}"
                        alt="Foto del visitante">
                @else
                    <img class="icono" src="{{ asset('img/sinfoto.png') }}" alt="">
                @endif
            </span>
        </div>
        <div class="details-item">
            <span class="details-label">recepcionista:</span>
            <span class="details-value">
                @if ($persona->user->estatus == 'desactivado')
                    {{ $persona->user->name }} (<span class="desactivate">Desactivado</span>)
                @else
                    {{ $persona->user->name }}
                @endif
            </span>
        </div>

        <div class="details-item">
            <span class="details-label">Nombre:</span>
            <span class="details-value">{{ $persona->nombre }}</span>
        </div>

        <div class="details-item">
            <span class="details-label">Apellido:</span>
            <span class="details-value">{{ $persona->apellido }}</span>
        </div>

        <div class="details-item">
            <span class="details-label">Nacionalidad:</span>
            <span class="details-value">
                @switch($persona->nacionalidad)
                    @case('V')
                        Venezolana
                    @break

                    @case('E')
                        Extranjero
                    @break

                    @default
                        Dato no válido
                @endswitch
            </span>
        </div>

        <div class="details-item">
            <span class="details-label">Cédula:</span>
            <span class="details-value">{{ $persona->cedula }}</span>
        </div>

        <div class="details-item">
            <span class="details-label">Filial:</span>
            <span class="details-value">{{ $persona->filial->nombre }}</span>
        </div>

        <div class="details-item">
            <span class="details-label">Siglas:</span>
            <span class="details-value">{{ $persona->filial->siglas }}</span>
        </div>

        <div class="details-item">
            <span class="details-label">Dirección:</span>
            <span class="details-value">{{ $persona->gerencia->nombre }}</span>
        </div>

        <div class="details-item">
            <span class="details-label">Teléfono:</span>
            <span class="details-value">{{ $persona->telefono }}</span>
        </div>

        <div class="details-item">
            <span class="details-label">Clasificación:</span>
            <span class="details-value">{{ $persona->clasificacion }}</span>
        </div>

        <div class="details-item">
            <span class="details-label">Nombre de la Empresa:</span>
            <span class="details-value">{{ $persona->nombre_empresa }}</span>
        </div>

        <div class="details-item">
            <span class="details-label">Número de Carnet:</span>
            <span class="details-value">{{ $persona->numero_carnet }}</span>
        </div>

        <div class="details-item">
            <span class="details-label">Motivo de la Visita:</span>
            <span class="details-value">{{ $persona->razon_visita }}</span>
        </div>


        <div class="details-item">
            <span class="details-label">Fecha:</span>
            <span class="details-value">{{ \Carbon\Carbon::parse($persona->created_at)->format('d/m/Y') }}</span>
        </div>

        <div class="details-item">
            <span class="details-label">Hora:</span>
            <span class="details-value">{{ \Carbon\Carbon::parse($persona->created_at)->format('h:i A') }}</span>
        </div>
    </div>
@endsection
