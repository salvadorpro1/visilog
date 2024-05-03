use Illuminate\Support\Str;

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
            margin-right: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .truncate {
            white-space: nowrap;
            /* Evita que el texto se envuelva */
            overflow: hidden;
            /* Oculta el texto que se desborda */
            text-overflow: ellipsis;
            /* Agrega puntos suspensivos (...) al final del texto truncado */
            max-width: 200px;
            /* Ancho máximo del contenedor */
        }
    </style>

</head>

<body>
    @include('includes._register_button')
    <a class="button" href="{{ url()->previous() }}">Volver</a>
    <h2>Tabla de Visitantes</h2>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Cédula</th>
                <th>Gerencia</th>
                <th>Razón de la Visita</th>
                <th>Fecha</th>
                {{-- <th>Hora</th> --}}

            </tr>
        </thead>
        <tbody>
            <!-- Aquí puedes agregar las filas con los datos de los visitantes -->
            @foreach ($registros as $registro)
                <tr>
                    <td>{{ $registro->nombre }}</td>
                    <td>{{ $registro->apellido }}</td>
                    <td><a
                            href="{{ route('show_Register_Visitor_Detail', $registro->cedula) }}">{{ $registro->cedula }}</a>
                    </td>
                    <td>{{ $registro->gerencia }}</td>
                    <td class="truncate">{{ $registro->razon_visita }}</td>
                    <td>{{ \Carbon\Carbon::parse($registro->created_at)->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $registros->links() }}

</body>

</html>
