@extends('layouts.app')

@section('title')
    Visitantes
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
            background-color: #6C757D;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:active {
            transform: scale(0.97)
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

        td a {
            text-decoration: none;
            color: #0000EE;
        }

        td a:hover {
            text-decoration: underline;
            color: #0000d1;
        }

        .search-form {
            display: flex;
            justify-content: center;
            /* Centra el formulario horizontalmente */
            align-items: center;
            /* Centra verticalmente el contenido */
            margin: 20px;
            /* Espaciado alrededor del formulario */
            padding: 10px;
            /* Espaciado interno */
            border-radius: 5px;
            /* Bordes redondeados */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Sombra sutil */
            background-color: #f9f9f9;
            /* Color de fondo */
        }

        .search-form__input {
            padding: 10px;
            /* Espaciado interno */
            border: 1px solid #ccc;
            /* Borde */
            border-radius: 5px;
            /* Bordes redondeados */
            width: 250px;
            /* Ancho del campo de búsqueda */
            margin-right: 10px;
            /* Espaciado entre el input y el botón */
            font-size: 16px;
            /* Tamaño de fuente */
        }

        .search-form__button {
            padding: 10px 15px;
            /* Espaciado interno */
            border: none;
            /* Sin borde */
            border-radius: 5px;
            /* Bordes redondeados */
            background-color: #007bff;
            /* Color de fondo del botón */
            color: white;
            /* Color del texto */
            font-size: 16px;
            /* Tamaño de fuente */
            cursor: pointer;
            /* Cambia el cursor al pasar sobre el botón */
            transition: background-color 0.3s ease;
            /* Transición suave */
        }

        .search-form__button:active {
            transform: scale(0.97);
        }
    </style>
@endsection

@section('content')
    <h1>Tabla De Visitante</h1>
    <a class="button" href="{{ route('show_Dashboard') }}">Volver al tablero</a>
    <form class="search-form" action="{{ route('show_Register_Visitor') }}" method="GET">
        <input type="search" class="search-form__input" name="search" id="search" placeholder="Buscar por nombre o cédula"
            value="{{ request('search') }}">
        <button type="submit" class="search-form__button">Buscar</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Nacionalidad</th>
                <th>Cédula</th>
                <th>Gerencia</th>
                <th>Razón de la Visita</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí puedes agregar las filas con los datos de los visitantes -->
            @foreach ($registros as $registro)
                <tr>

                    </td>
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
                            <td>Dato no valido</td>
                    @endswitch
                    <td><a href="{{ route('show_Register_Visitor_Detail', $registro->id) }}">{{ $registro->cedula }}</a>
                    <td>{{ $registro->gerencia->nombre }}</td>
                    <td class="truncate">{{ $registro->razon_visita }}</td>
                    <td>{{ \Carbon\Carbon::parse($registro->created_at)->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $registros->links() }}
@endsection
