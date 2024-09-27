@extends('layouts.app')

@section('title', 'Filiales')

@section('style')
    <style>
        .container {
            max-width: 900px;
            margin: 50px auto;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            margin: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #fff;
            border: none;
        }

        .btn-warning:hover {
            background-color: #d39e00;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #343a40;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .button {
            display: inline-block;
            padding: 10px 15px;
            margin: 10px 0;
            color: #ffffff;
            background-color: #17a2b8;
            border: none;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease-in-out;
        }

        .button:hover {
            background-color: #138496;
        }

        .actions {
            display: flex;
            gap: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h1>Filiales</h1>

        <!-- Botón para volver -->
        <a class="button" href="{{ route('showRegisterCreate') }}">Volver</a>

        <!-- Botón para crear filial -->
        <a href="{{ route('filiales.create') }}" class="btn btn-primary">Crear Filial</a>

        <!-- Tabla de filiales -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($filiales as $filial)
                    <tr>
                        <td>{{ $filial->id }}</td>
                        <td>{{ $filial->nombre }}</td>
                        <td class="actions">
                            <a href="{{ route('filiales.edit', $filial->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('filiales.destroy', $filial->id) }}" method="POST"
                                style="display:inline-block;"
                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta filial?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
