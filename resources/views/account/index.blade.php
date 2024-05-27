<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte</title>
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

        /* Estilos para el formulario */
        .form {
            margin: 20px;
        }

        /* Estilos para las etiquetas */
        .form__label {
            display: block;
            margin-bottom: 5px;
        }

        /* Estilos para los selectores */
        .form__select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            font-size: 16px;
        }

        /* Estilos para los inputs */
        .form__input {
            width: 96.5%;
            padding: 8px;
            margin-bottom: 10px;
            font-size: 16px;
        }

        /* Estilos para el botón */
        .form__submit {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        /* Estilos para las opciones desactivadas */
        .form__option--disabled {
            color: #999;
        }

        /* Estilos para la tabla */
        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .results-table th,
        .results-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .results-table th {
            background-color: #f4f4f4;
        }

        /* Estilos para la paginación */
        .pagination {
            margin: 20px 0;
            display: flex;
            justify-content: center;
        }

        .pagination li {
            list-style: none;
            margin: 0 5px;
        }

        .pagination a {
            text-decoration: none;
            color: #007bff;
        }

        .pagination .active a {
            font-weight: bold;
            color: #000;
        }

        .pagination .disabled a {
            color: #ccc;
        }

        .result-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        .result-card {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            flex: 1 1 200px;
            /* flex-grow, flex-shrink, flex-basis */
            max-width: 200px;
        }

        .result-label {
            display: block;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .result-value {
            display: block;
            font-size: 1.1em;
            color: #666;
        }

        .no-results {
            font-style: italic;
            color: #777;
        }

        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .results-table th,
        .results-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .results-table th {
            background-color: #f4f4f4;
        }

        .pagination {
            margin: 20px 0;
            display: flex;
            justify-content: center;
        }

        .pagination li {
            list-style: none;
            margin: 0 5px;
        }

        .pagination a {
            text-decoration: none;
            color: #007bff;
        }

        .pagination .active a {
            font-weight: bold;
            color: #000;
        }

        .pagination .disabled a {
            color: #ccc;
        }
    </style>
</head>

<body>
    @include('includes._register_button', ['titulo' => 'Reporte'])

    <div class="container">

        <form class="form" method="POST" action="">
            @csrf
            <label class="form__label" for="filial">Filial</label>
            <select class="form__select" name="filial" id="filial"
                onchange="quitarSeleccionInicial('filial'), updateGerenciaOptions(this.value, 'gerencia')">
                <option value="" selected disabled>Elegir filial</option>
                <option value="vencemos">Vencemos</option>
                <option value="invecem">Invecem</option>
                <option value="fnc">FNC</option>
            </select>
            <label class="form__label" for="gerencia">Gerencia</label>
            <select class="form__select" name="gerencia" id="gerencia" onchange="quitarSeleccionInicial('gerencia')">
                <option value="" selected disabled>Elegir gerencia</option>
            </select>
            <label class="form__label" for="dia">desde</label>
            <input class="form__input" type="date" name="diadesde" id="diadesde"
                min="{{ $fechaMinima->format('Y-m-d') }}" max="{{ date('Y-m-d') }}">
            <label class="form__label" for="dia">hasta</label>
            <input class="form__input" type="date" name="diahasta" id="diahasta"
                min="{{ $fechaMinima->format('Y-m-d') }}" max="{{ date('Y-m-d') }}">
            <input class="form__submit" type="submit" value="Consultar">
            <a href="{{ route('show_ConsulForm') }}">Volver</a>

        </form>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        @if (isset($visitorCount))
            <div class="results">
                <h2>Resultados de la Consulta</h2>
                <div class="result-cards">
                    <div class="result-card">
                        <span class="result-label">Filial:</span>
                        <span class="result-value">{{ $filial }}</span>
                    </div>
                    <div class="result-card">
                        <span class="result-label">Gerencia:</span>
                        <span class="result-value">{{ $gerencia }}</span>
                    </div>
                    <div class="result-card">
                        <span class="result-label">Desde:</span>
                        <span class="result-value">{{ \Carbon\Carbon::parse($diadesde)->format('d/m/Y') }}</span>
                    </div>
                    <div class="result-card">
                        <span class="result-label">Hasta:</span>
                        <span class="result-value">{{ \Carbon\Carbon::parse($diahasta)->format('d/m/Y') }}</span>
                    </div>
                    <div class="result-card">
                        <span class="result-label">Visitantes:</span>
                        <span class="result-value">{{ $visitorCount }}</span>
                    </div>
                </div>

                @if ($visitors->count() > 0)
                    <table class="results-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Cedula</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visitors as $visitor)
                                <tr>
                                    <td><a
                                            href="{{ route('show_Register_Visitor_Detail', $visitor->id) }}">{{ $visitor->id }}</a>
                                    </td>
                                    <td>{{ $visitor->nombre }}</td>
                                    <td>{{ $visitor->apellido }}</td>
                                    <td>{{ $visitor->cedula }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination">
                        {{ $visitors->links() }}
                    </div>
                @else
                    <p class="no-results">No se encontraron visitantes para los criterios seleccionados.</p>
                @endif
            </div>

        @endif
    </div>

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
                opciones = ['Todo(vencemos)', 'value1A', 'value2A', 'value3A'];
            } else if (filialValue === 'invecem') {
                opciones = ['Todo(invecem)', 'value1B', 'value2B', 'value3B'];
            } else if (filialValue === 'fnc') {
                opciones = ['Todo(FNC)', 'value1C', 'value2C', 'value3C']; // Opciones predeterminadas
            }

            opciones.forEach(function(opcion) {
                var option = document.createElement('option');
                option.value = opcion;
                option.text = opcion;
                gerenciaSelect.appendChild(option);
            });
        }
    </script>
</body>

</html>
