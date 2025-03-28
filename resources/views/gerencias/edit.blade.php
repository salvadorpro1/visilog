@extends('layouts.app')

@section('title', 'Editar Dirección')

@section('style')
    <style>
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px 30px;
            background-color: #f7f7f9;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            color: #4e4e4e;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #495057;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            transition: border-color 0.3s ease-in-out;
            text-transform: uppercase;
        }

        .form-control:focus {
            border-color: #80bdff;
            outline: none;
            box-shadow: 0 0 8px rgba(128, 189, 255, 0.5);
        }

        select.form-control {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='%23202020' d='M2 0L0 2h4z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 10px;
        }

        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 12px 15px;
            font-size: 18px;
            color: #ffffff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .button {
            display: inline-block;
            padding: 10px 15px;
            margin: 10px 0;
            color: #ffffff;
            background-color: #6C757D;
            border: none;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease-in-out;
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
        <h1>Editar Dirección</h1>
        <form action="{{ route('gerencias.update', $gerencia->id) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- Campo de nombre de la gerencia -->
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $gerencia->nombre }}"
                    placeholder="Ingrese el nombre de la dirección">
            </div>

            <!-- Campo de selección de la filial -->
            <div class="form-group">
                <label for="filial_id">Filial</label>
                <select name="filial_id" id="filial_id" class="form-control">
                    <option value="">Seleccione una filial</option>
                    @foreach ($filiales as $filial)
                        <option value="{{ $filial->id }}" {{ $filial->id == $gerencia->filial_id ? 'selected' : '' }}>
                            {{ $filial->siglas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Botón de actualización -->
            <a class="user-menu__item-link  button" href="{{ route('gerencias.index') }}">Volver</a>

            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
@endsection
