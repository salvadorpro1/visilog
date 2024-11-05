@extends('layouts.app')

@section('title')
    Detalle De Visitantes
@endsection

@section('style')
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .foto {
            width: 150px;
            height: 150px;
            object-fit: cover;
            transform: rotatey(180deg);

        }

        .desactivate {
            color: rgb(255, 0, 0);
            font-weight: 600
        }
    </style>
@endsection

@section('content')
    <h1>Detalle De Visitantes</h1>
    <a class="button" href="{{ url()->previous() }}">Volver</a>
    <table>
        <thead>
            <tr>
                <th>Operador</th>
                @if ($persona->user->estatus == 'desactivado')
                    <td>{{ $persona->user->name }} (<span class="desactivate">Desactivado</span>)</td>
                @else
                    <td>{{ $persona->user->name }}</td>
                @endif
            </tr>
            <tr>
                <th>Nombre</th>
                <td>{{ $persona->nombre }}</td>
            </tr>
            <tr>
                <th>Apellido</th>
                <td>{{ $persona->apellido }}</td>
            </tr>
            <tr>
                <th>Nacionalidad</th>
                @switch($persona->nacionalidad)
                    @case('V')
                        <td>Venezolana</td>
                    @break

                    @case('E')
                        <td>Extranjero</td>
                    @break

                    @default
                        <td>Dato no valido</td>
                @endswitch
            </tr>
            <tr>
                <th>Cédula</th>
                <td>{{ $persona->cedula }}</td>
            </tr>
            <tr>
                <th>Filial</th>
                <td>{{ $persona->filial->nombre }}</td>
            </tr>
            <tr>
                <th>Dirección</th>
                <td>{{ $persona->gerencia->nombre }}</td>
            </tr>
            <tr>
                <th>Telefono</th>
                <td>{{ $persona->telefono }}</td>
            </tr>
            <tr>
                <th>Clasificacion</th>
                <td>{{ $persona->clasificacion }}</td>
            </tr>
            <tr>
                <th>Numero de carnet</th>
                <td>{{ $persona->numero_carnet }}</td>
            </tr>
            <tr>
                <th>Razón de la Visita</th>
                <td>{{ $persona->razon_visita }}</td>
            </tr>
            <tr>
                <th>Foto</th>
                <td>
                    @if (!empty($persona->foto))
                        <img class="foto" src="{{ route('visitor.photo', ['filename' => $persona->foto]) }}"
                            alt="Foto del visitante" width="200">
                    @else
                        <p>No hay foto disponible.</p>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Fecha</th>
                <td>{{ \Carbon\Carbon::parse($persona->created_at)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Hora</th>
                <td>{{ \Carbon\Carbon::parse($persona->created_at)->toTimeString() }}</td>
            </tr>
        </thead>
    </table>
@endsection
