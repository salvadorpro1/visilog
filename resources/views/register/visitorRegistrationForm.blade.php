<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>registro</title>
</head>

<body>
    @include('includes._register_button')

    @if ($showAll)
        <form method="POST" action="{{ route('guardar_RegistroVisitor') }}">
            @csrf
            <label for="">Cedula</label>
            <input name="cedula" readonly value="{{ $cedula }}" type="number">
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
            <label for="">razon de la visita</label>
            <textarea name="razon_visita" cols="30" rows="10"></textarea>
            <input type="submit" value="Enviar">
            @if (session('success'))
                <div class="alert alert-success">
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
            <label for="">razon de la visita</label>
            <textarea name="razon_visita" cols="30" rows="10"></textarea>
            <input type="submit" value="Enviar">

        </form>
    @endif

</body>

</html>
