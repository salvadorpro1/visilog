<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Visitantes</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
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
</head>

<body>
    @include('includes._register_button', ['titulo' => 'Detalle De Visitantes'])

    <a class="button" href="{{ url()->previous() }}">Volver</a>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <td>{{ $persona->nombre }}</td>
            </tr>
            <tr>
                <th>Apellido</th>
                <td>{{ $persona->apellido }}</td>
            </tr>
            <tr>
                <th>Cédula</th>
                <td>{{ $persona->cedula }}</td>
            </tr>
            <tr>
                <th>Gerencia</th>
                <td>{{ $persona->gerencia }}</td>
            </tr>
            <tr>
                <th>Razón de la Visita</th>
                <td>{{ $persona->razon_visita }}</td>
            </tr>
            <tr>
                <th>Fecha</th>
                <td>{{ \Carbon\Carbon::parse($persona->created_at)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Hora</th>
                <td>{{ \Carbon\Carbon::parse($persona->created_at)->toTimeString() }}</td>
            </tr>
        </thead>
    </table>
</body>

</html>
