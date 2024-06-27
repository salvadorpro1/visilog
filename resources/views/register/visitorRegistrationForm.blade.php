@extends('layouts.app')

@section('title')
    Registro
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
            max-width: 600px;
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
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .alert {
            margin-top: 10px;
            padding: 10px;
            background-color: #f2f2f2;
            border-left: 4px solid #4caf50;
            color: #333;
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

    <h1>Registrar Visitante</h1>
    <div class="container">

        <form method="POST" action="{{ route('guardar_RegistroVisitor') }}">
            @csrf
            @if ($showAll)
                <label for="">Nacionalidad</label>
                <select name="nacionalidad" readonly>
                    <option value="V" {{ $nacionalidad == 'V' ? 'selected' : '' }}>V</option>
                    <option value="E" {{ $nacionalidad == 'E' ? 'selected' : '' }}>E</option>
                </select>
                <label for="">Cédula</label>
                <input name="cedula" value="{{ $cedula }}" type="number">
                <label for="">Nombre</label>
                <input name="nombre" type="text">
                <label for="">Apellido</label>
                <input name="apellido" type="text">
                <label for="">Filial</label>
                <select name="filial"
                    onchange="quitarSeleccionInicial('filial'), updateGerenciaOptions(this.value, 'gerencia')">
                    <option value="" selected disabled>Elegir filial</option>
                    <option value="vencemos">Vencemos</option>
                    <option value="invecem">Invecem</option>
                    <option value="fnc">FNC</option>
                </select>
                <label for="">Gerencia</label>
                <select name="gerencia" onchange="quitarSeleccionInicial('gerencia')">
                    <option value="" selected disabled>Elegir gerencia</option>
                </select>
                <label for="">Razón de la visita</label>
                <textarea name="razon_visita" cols="30" rows="10" maxlength="255"></textarea>
                <a class="button"
                    href="{{ Auth::user()->role == 'operador' ? route('show_consult') : route('show_Dashboard') }}">
                    Volver
                </a>
                <input type="submit" value="Enviar">
            @else
                <label for="">Nacionalidad</label>
                <select name="nacionalidad" readonly>
                    <option value="V" {{ $visitor->nacionalidad == 'V' ? 'selected' : '' }}>V</option>
                    <option value="E" {{ $visitor->nacionalidad == 'E' ? 'selected' : '' }}>E</option>
                </select>
                <label for="">Cédula</label>
                <input name="cedula" readonly value="{{ $visitor->cedula }}" type="number">
                <label for="">Nombre</label>
                <input name="nombre" readonly value="{{ $visitor->nombre }}" type="text">
                <label for="">Apellido</label>
                <input name="apellido" readonly value="{{ $visitor->apellido }}" type="text">
                <label for="">Filial</label>
                <select name="filial"
                    onchange="quitarSeleccionInicial('filial'), updateGerenciaOptions(this.value, 'gerencia')">
                    <option value="" selected disabled>Elegir filial</option>
                    <option value="vencemos">Vencemos</option>
                    <option value="invecem">Invecem</option>
                    <option value="fnc">FNC</option>
                </select>
                <label for="">Gerencia</label>
                <select name="gerencia" onchange="quitarSeleccionInicial('gerencia')">
                    <option value="" selected disabled>Elegir gerencia</option>
                </select>
                <label for="">Razón de la visita</label>
                <textarea name="razon_visita" cols="30" rows="10" maxlength="255"></textarea>
                <a class="button"
                    href="{{ Auth::user()->role == 'operador' ? route('show_consult') : route('show_Dashboard') }}">
                    Volver
                </a>
                <input type="submit" value="Enviar">
            @endif
        </form>



    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif



    <script>
        function quitarSeleccionInicial(nombreSelect) {
            var selectElement = document.getElementsByName(nombreSelect)[0];
            var optionElement = selectElement.querySelector("option[selected][disabled]");
            if (optionElement) {
                optionElement.remove();
            }
        }

        function updateGerenciaOptions(filialValue, gerenciaName) {
            var gerenciaSelect = document.getElementsByName(gerenciaName)[0];
            gerenciaSelect.innerHTML = ''; // Limpiar opciones actuales

            var opciones = [];
            if (filialValue === 'vencemos') {
                opciones = ['value1A', 'value2A', 'value3A'];
            } else if (filialValue === 'invecem') {
                opciones = ['value1B', 'value2B', 'value3B'];
            } else {
                opciones = ['value1C', 'value2C', 'value3C']; // Opciones predeterminadas
            }

            opciones.forEach(function(opcion) {
                var option = document.createElement('option');
                option.value = opcion;
                option.text = opcion;
                gerenciaSelect.appendChild(option);
            });
        }
    </script>

    <script>
        function quitarSeleccionInicial(nombreSelect) {
            var selectElement = document.getElementsByName(nombreSelect)[0];
            var optionElement = selectElement.querySelector("option[selected][disabled]");
            if (optionElement) {
                optionElement.remove();
            }
        }
    </script>
@endsection
