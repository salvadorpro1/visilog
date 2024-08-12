<!-- resources/views/historial.blade.php -->

@extends('layouts.app')

@section('style')
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Contenedor principal */
        .container {
            width: 90%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Título */
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Estilos para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        /* Estilos para el mensaje sin registros */
        .historial-table p {
            text-align: center;
            color: #888;
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

        td a {
            text-decoration: none;
            color: #0000EE;
        }

        td a:hover {
            text-decoration: underline;
            color: #0000d1;
        }

        .truncate {
            white-space: nowrap;
            /* Evita que el texto se envuelva */
            overflow: hidden;
            /* Oculta el texto que se desborda */
            text-overflow: ellipsis;
            /* Agrega puntos suspensivos (...) al final del texto truncado */
            max-width: 250px;
            /* Ancho máximo del contenedor */
        }
    </style>
@endsection

@section('content')

    <a class="button" href="{{ route('showRegisterCreate') }}">Volver</a>

    <div class="container">
        <h1>Historial de {{ $operador->name }}</h1>
        <div class="historial-table">
            @if ($historial->isEmpty())
                <p>No hay registros de visitantes para este operador.</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Nacionalidad</th>
                            <th>Cédula</th>
                            <th>Filial</th>
                            <th>Gerencia</th>
                            <th>Razón de Visita</th>
                            <th>Fecha de Registro</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($historial as $visitante)
                            <tr>
                                <td>{{ $visitante->nombre }}</td>
                                <td>{{ $visitante->apellido }}</td>
                                <td>{{ $visitante->nacionalidad }}</td>
                                <td><a
                                        href="{{ route('show_Register_Visitor_Detail', $visitante->id) }}">{{ $visitante->cedula }}</a>
                                </td>
                                <td>{{ $visitante->filial->nombre }}</td>
                                <td>{{ $visitante->gerencia->nombre }}</td>
                                <td class="truncate">{{ $visitante->razon_visita }}</td>
                                <td>{{ $visitante->created_at->format('d-m-Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Agregar paginación -->
                <div class="pagination">
                    {{ $historial->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
