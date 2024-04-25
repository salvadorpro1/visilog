<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>registro</title>
</head>

<body>
    @if ($showAll)
        <form method="POST" action="">
            @csrf
            <label for="">Cedula</label>
            <input readonly value="{{ $cedula }}" type="number">
            <label for="">Nombre</label>
            <input type="text">
            <label for="">Apellido</label>
            <input type="text">
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
            <textarea name="" id="" cols="30" rows="10"></textarea>
        </form>
    @else
        <form method="POST" action="">
            @csrf
            <label for="">Cedula</label>
            <input readonly value="{{ $visitor->cedula }}" type="number">
            <label for="">Nombre</label>
            <input readonly value="{{ $visitor->nombre }}" type="text">
            <label for="">Apellido</label>
            <input readonly value="{{ $visitor->apellido }}" type="text">
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
            <textarea name="" id="" cols="30" rows="10"></textarea>
        </form>
    @endif

</body>

</html>