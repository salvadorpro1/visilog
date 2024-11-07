@extends('layouts.app')

@section('title', 'Crear Filial')

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
            text-transform: uppercase;
        }

        .form-control:focus {
            border-color: #80bdff;
            outline: none;
            box-shadow: 0 0 8px rgba(128, 189, 255, 0.5);
        }

        /* Botón de envío */
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
            text-align: center;
            transition: background-color 0.3s ease;
        }

        /* Botón de "Volver" */
        button[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
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

        .juntos {
            display: flex;
            justify-content: center;
            align-items: center;

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
        <h1>Crear Filial</h1>
        <form action="{{ route('filiales.store') }}" method="POST">
            @csrf
            <!-- Campo de nombre de la filial -->
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control"
                    placeholder="Ingrese el nombre de la filial">
            </div>
            <div class="form-group">
                <label for="nombre">Siglas</label>
                <input type="text" name="siglas" id="siglas" class="form-control"
                    placeholder="Ingrese las siglas de la filial">
            </div>

            <!-- Botón de "Volver" y de "Guardar" -->
            <div class="juntos">
                <a class="button" href="{{ route('filiales.index') }}">Volver</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
@endsection
