@extends('layouts.app')

@section('title')
    Crear operador
@endsection

@section('style')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
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
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .alert-danger {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-danger ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .alert-danger li {
            margin: 0;
        }

        .juntos {
            display: flex;
            justify-content: center;
            align-items: center;

        }
    </style>
@endsection

@section('content')
    <h1>Cambiar Contraseña</h1>
    <div class="container">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="cambiar-contraseña" method="POST">
            @csrf

            <label for="current_password">Contraseña Actual:</label>
            <input type="password" name="current_password" id="current_password">

            <label for="new_password">Nueva Contraseña:</label>
            <input type="password" name="new_password" id="new_password">

            <label for="new_password_confirmation">Confirmar Nueva Contraseña:</label>
            <input type="password" name="new_password_confirmation" id="new_password_confirmation">
            <div class="juntos">
                <a class="button" href="{{ route('show_Dashboard') }}">Volver al tablero</a>
                <button type="submit">Cambiar Contraseña</button>
            </div>

        </form>

    </div>
@endsection
