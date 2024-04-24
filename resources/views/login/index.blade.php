<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VISILOG Inicio de session</title>
</head>

<body>
    <form action="/login" method="POST">
        @csrf
        <label for="">Usuario</label>
        <input type="text" name="username">
        <label for="">Contraseña</label>
        <input type="password" name="password">
        <input type="submit" value="Iniciar Sesion">

        @error('username')
            <div>{{ $message }}</div>
        @enderror
    </form>
</body>

</html>
