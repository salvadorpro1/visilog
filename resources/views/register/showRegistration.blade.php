@extends('layouts.app')

@section('title')
    Visitantes
@endsection

@section('style')
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            font-weight: 300;
            margin-bottom: 30px;
            font-size: 2.2em;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            background-color: #6C757D;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:active {
            transform: scale(0.97);
        }

        /* Estilos para el formulario */
        .search-form {
            display: flex;
            justify-content: center;
            margin: 20px;
            padding: 20px;
            border-radius: 10px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .search-form__input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 250px;
            margin-right: 10px;
            font-size: 16px;
        }

        .search-form__button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-form__button:active {
            transform: scale(0.97);
        }

        /* Estilos para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f1f1f1;
            color: #333;
            font-weight: 600;
        }

        td {
            color: #555;
        }

        td a {
            color: #007bff;
            text-decoration: none;
        }

        td a:hover {
            text-decoration: underline;
        }

        .truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 250px;
        }

        /* Paginación */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination li {
            list-style: none;
            margin: 0 5px;
        }

        .pagination a {
            padding: 8px 12px;
            color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            border: 1px solid #ddd;
            transition: background-color 0.3s ease;
        }

        .pagination a:hover {
            background-color: #f1f1f1;
        }

        .pagination .active a {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
    </style>
@endsection


@section('content')
    <div class="container">
        <h1>Tabla de Visitantes</h1>
        <form class="search-form" action="{{ route('show_Register_Visitor') }}" method="GET">
            <input type="search" class="search-form__input" name="search" id="search"
                placeholder="Buscar por nombre o cédula" value="{{ request('search') }}">
            <button type="submit" class="search-form__button">Buscar</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Nacionalidad</th>
                    <th>Cédula</th>
                    <th>Dirección</th>
                    <th>Motivo de la visita</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($registros as $registro)
                    <tr>
                        <td>{{ $registro->nombre }}</td>
                        <td>{{ $registro->apellido }}</td>
                        @switch($registro->nacionalidad)
                            @case('V')
                                <td>Venezolana</td>
                            @break

                            @case('E')
                                <td>Extranjero</td>
                            @break

                            @default
                                <td>Dato no válido</td>
                        @endswitch
                        <td><a href="{{ route('show_Register_Visitor_Detail', $registro->id) }}">{{ $registro->cedula }}</a>
                        </td>
                        <td>{{ $registro->gerencia->nombre }}</td>
                        <td class="truncate">{{ $registro->razon_visita }}</td>
                        <td>{{ \Carbon\Carbon::parse($registro->created_at)->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @php
            $user = auth()->user();
        @endphp
        <a class="button"
            href="
    @if ($user->role === 'administrador') {{ route('show_Dashboard') }}
    @elseif($user->role === 'operador')
        {{ route('show_consult') }} @endif
">Volver
        </a>
        <div class="pagination">
            {{ $registros->links() }}
        </div>
    </div>
@endsection
