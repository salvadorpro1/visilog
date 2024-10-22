@extends('layouts.app')

@section('title', 'Editar Filial')

@section('style')
    <style>
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px 40px;
            background-color: #f7f7f9;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 30px;
            font-weight: bold;
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #495057;
            font-size: 16px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            font-size: 16px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            transition: border-color 0.3s ease-in-out;
        }

        .form-control:focus {
            border-color: #80bdff;
            outline: none;
            box-shadow: 0 0 8px rgba(128, 189, 255, 0.5);
        }

        /* Botón de envío */
        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 14px 20px;
            font-size: 18px;
            color: #ffffff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
            margin-top: 15px;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Botón de "Volver" */
        .button {
            display: inline-block;
            padding: 12px 18px;
            color: #ffffff;
            background-color: #17a2b8;
            border: none;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
            font-size: 16px;
            margin-right: 10px;
            margin-bottom: 20px;
        }

        .button:hover {
            background-color: #138496;
        }

        /* Centrado de botones */
        .button-container {
            text-align: center;
        }

        .alert {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
        <h1>Editar Filial</h1>
        <form action="{{ route('filiales.update', $filial) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Campo de nombre de la filial -->
            <div class="form-group">
                <label for="nombre">Nombre de la Filial</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $filial->nombre }}"
                    placeholder="Ingrese el nombre de la filial" required>
            </div>

            <!-- Botón de "Volver" y de "Actualizar" -->
            <div class="button-container">
                <a class="button" href="{{ route('filiales.index') }}">Volver</a>
                <button type="submit" class="btn btn-primary">Actualizar Filial</button>
            </div>
        </form>
    </div>
@endsection
