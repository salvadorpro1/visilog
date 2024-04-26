<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro</title>
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
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            display: block;
            margin-bottom: 10px;
            text-decoration: none;
            color: #4caf50;
        }

        a:hover {
            text-decoration: underline;
        }

        .alert {
            margin-top: 10px;
            padding: 10px;
            background-color: #f2f2f2;
            border-left: 4px solid #4caf50;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="container">
        @include('includes._register_button')
        <a href="{{ url()->previous() }}">Volver</a>

        <a href="{{ route('show_Register_Visitor') }}">Registro de visitantes</a>

        @if ($showAll)
            <form method="POST" action="{{ route('guardar_RegistroVisitor') }}">
                @csrf
                <label for="">Cedula</label>
                <input name="cedula" value="{{ $cedula }}" type="number">
                <label for="">Nombre</label>
                <input name="nombre" type="text">
                <label for="">Apellido</label>
                <input name="apellido" type="text">
                <label for="">Filial</label>
                <select name="Subsidiary">
                    <option value="value1">Vencemos</option>
                    <option value="value2">Invecem</option>
                    <option value="value3">FNC</option>
                </select>
                <label for="">Gerencia</label>
                <select name="Management">
                    <option value="value1">Value 1</option>
                    <option value="value2">Value 2</option>
                    <option value="value3">Value 3</option>
                </select>
                <label for="">Razón de la visita</label>
                <textarea name="razon_visita" cols="30" rows="10"></textarea>
                <input type="submit" value="Enviar">
                @if (session('success'))
                    <div class="alert">
                        {{ session('success') }}
                    </div>
                @endif
            </form>
        @else
            <form method="POST" action="{{ route('guardar_RegistroVisitor') }}">
                @csrf
                <label for="">Cedula</label>
                <input name="cedula" readonly value="{{ $visitor->cedula }}" type="number">
                <label for="">Nombre</label>
                <input name="nombre" readonly value="{{ $visitor->nombre }}" type="text">
                <label for="">Apellido</label>
                <input name="apellido" readonly value="{{ $visitor->apellido }}" type="text">
                <label for="">Filial</label>
                <select name="Subsidiary">
                    <option value="value1">Vencemos</option>
                    <option value="value2">Invecem</option>
                    <option value="value3">FNC</option>
                </select>
                <label for="">Gerencia</label>
                <select name="Management">
                    <option value="value1">Value 1</option>
                    <option value="value2">Value 2</option>
                    <option value="value3">Value 3</option>
                </select>
                <label for="">Razón de la visita</label>
                <textarea name="razon_visita" cols="30" rows="10"></textarea>
                <input type="submit" value="Enviar">
            </form>
        @endif
    </div>
</body>

</html>
