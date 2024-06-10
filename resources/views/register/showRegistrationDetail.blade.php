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
    </style>
@endsection

@section('content')
    <h1>Detalle De Visitantes</h1>
    <a class="button" href="{{ url()->previous() }}">Volver</a>
    <table>
        <thead>
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
                <td>{{ $persona->filial }}</td>
            </tr>
            <tr>
                <th>Gerencia</th>
                <td>{{ $persona->gerencia }}</td>
            </tr>
            <tr>
                <th>Razón de la Visita</th>
                <td>{{ $persona->razon_visita }}</td>
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
