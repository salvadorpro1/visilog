@extends('layouts.app')

@section('title', 'Detalle De Visitantes')

@section('style')
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #eef1f5;
            color: #333;
        }

        h1 {
            text-align: center;
            margin: 30px 0 20px;
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .details-container {
            max-width: 900px;
            margin: 0 auto 50px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            padding: 20px;
        }

        .details-header {
            background: linear-gradient(135deg, #4A90E2, #357ABD);
            color: #fff;
            padding: 15px;
            text-align: center;
            font-weight: bold;
            font-size: 1.2rem;
            letter-spacing: 1px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .details-image {
            text-align: center;
            margin-bottom: 20px;
        }

        .foto {
            max-width: 220px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            border: 3px solid #f4f4f4;
        }

        .icono {
            max-width: 150px;
            opacity: 0.7;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .details-item {
            background-color: #fafafa;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
        }

        .details-label {
            font-weight: 600;
            color: #000000;
            font-size: 0.85rem;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .details-value {
            color: #2c3e50;
            font-size: 0.95rem;
            word-break: break-word;
            text-transform: uppercase;
        }

        .button {
            display: block;
            width: fit-content;
            margin: 0 auto 20px;
            padding: 12px 28px;
            background-color: #6C757D;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .button:hover {
            background-color: #5a6268;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .desactivate {
            color: #d9534f;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <h1>Detalle De Visitantes</h1>
    <a class="button" href="{{ url()->previous() }}">⬅ Volver</a>

    <div class="details-container">
        <div class="details-header">Detalles del Visitante</div>

        <div class="details-image">
            @if (!empty($persona->foto))
                <img class="foto" src="{{ route('visitor.photo', ['filename' => $persona->foto]) }}"
                    alt="Foto del visitante">
            @else
                <img class="icono" src="{{ asset('img/sinfoto.png') }}" alt="Sin foto">
            @endif
        </div>

        <div class="details-grid">
            <div class="details-item">
                <span class="details-label">Recepcionista</span>
                <span class="details-value">
                    @if ($persona->user->estatus == 'desactivado')
                        {{ $persona->user->name }} (<span class="desactivate">Desactivado</span>)
                    @else
                        {{ $persona->user->name }}
                    @endif
                </span>
            </div>
            <div class="details-item"><span class="details-label">Nombre</span><span
                    class="details-value">{{ $persona->nombre }}</span></div>
            <div class="details-item"><span class="details-label">Apellido</span><span
                    class="details-value">{{ $persona->apellido }}</span></div>
            <div class="details-item">
                <span class="details-label">Nacionalidad</span>
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
            <div class="details-item"><span class="details-label">Cédula</span><span
                    class="details-value">{{ $persona->cedula }}</span></div>
            <div class="details-item"><span class="details-label">Filial</span><span
                    class="details-value">{{ $persona->filial->nombre }}</span></div>
            <div class="details-item"><span class="details-label">Siglas</span><span
                    class="details-value">{{ $persona->filial->siglas }}</span></div>
            <div class="details-item"><span class="details-label">Dirección</span><span
                    class="details-value">{{ $persona->gerencia->nombre }}</span></div>
            <div class="details-item"><span class="details-label">Teléfono</span><span
                    class="details-value">{{ $persona->telefono }}</span></div>
            <div class="details-item"><span class="details-label">Clasificación</span><span
                    class="details-value">{{ $persona->clasificacion }}</span></div>
            <div class="details-item"><span class="details-label">Empresa</span><span
                    class="details-value">{{ $persona->nombre_empresa }}</span></div>
            <div class="details-item"><span class="details-label">{{ $persona->tipo_carnet }}</span><span
                    class="details-value">{{ $persona->numero_carnet }}</span></div>
            <div class="details-item"><span class="details-label">Motivo</span><span
                    class="details-value">{{ $persona->razon_visita }}</span></div>
            <div class="details-item"><span class="details-label">Fecha</span><span
                    class="details-value">{{ \Carbon\Carbon::parse($persona->created_at)->format('d/m/Y') }}</span></div>
            <div class="details-item"><span class="details-label">Hora</span><span
                    class="details-value">{{ \Carbon\Carbon::parse($persona->created_at)->format('h:i A') }}</span></div>
        </div>
    </div>
@endsection
