<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            background-image: url('{{ asset('img/fondoInicio.jpg') }}');
            /* Coloca aquí la URL de tu imagen */
            background-size: cover;
            /* Hace que la imagen cubra todo el fondo */
            background-repeat: no-repeat;
            /* Evita que la imagen se repita */
            background-position: center center;
            /* Centra la imagen */
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>



<body>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @error('username')
        <div class="error">{{ $message }}</div>
    @enderror
    <form action="/login" method="POST">
        @csrf
        <label for="username">Usuario</label>
        <input type="text" id="username" name="username">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password">
        <input type="submit" value="Iniciar Sesión">
    </form>

</body>

</html>
