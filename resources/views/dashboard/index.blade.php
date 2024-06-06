<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard de Visitantes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            width: 700px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form {
            margin: 20px;
        }

        .form__label {
            display: block;
            margin-bottom: 5px;
        }

        .form__select,
        .form__input {
            width: 96.5%;
            padding: 8px;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .form__submit {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .form__container_date {
            display: flex;
            justify-content: space-evenly;
        }

        .form__container_date div {
            width: 100%;
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

        .result-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        .result-card {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            flex: 1 1 200px;
            width: 100%;
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

        .alert-danger {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-danger ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .alert-danger li {
            margin: 0;
        }

        .container-card {
            display: flex;
            width: 100%;
            background: white;
            border: 1px solid black;
            border-radius: 4px
        }
    </style>
</head>

<body>
    @include('includes._register_button', ['titulo' => 'Dashboard de Visitantes'])

    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="form" action="" method="POST">
            @csrf

            <div class="form__container_date">
                <div>
                    <label class="form__label" for="diadesde">Desde:</label>
                    <input class="form__input" type="date" id="diadesde" value="{{ $diadesde }}" name="diadesde"
                        min="{{ \Carbon\Carbon::parse($fechaMinima)->format('Y-m-d') }}" max="{{ date('Y-m-d') }}"
                        required>
                </div>
                <div>
                    <label class="form__label" for="diahasta">Hasta:</label>
                    <input class="form__input" type="date" id="diahasta" value="{{ $diahasta }}" name="diahasta"
                        min="{{ \Carbon\Carbon::parse($fechaMinima)->format('Y-m-d') }}" max="{{ date('Y-m-d') }}"
                        required>
                </div>
            </div>
            <input class="form__submit" type="submit" value="Filtrar">
            <a class="button" href="{{ route('show_ConsulForm') }}">Volver</a>

        </form>
        @if (isset($diadesde) && isset($diahasta) && count($visitantesPorGerenciaFilial) > 0)
            <div class="results">
                <div class="result-cards">
                    <div class="result-card">
                        <p> Desde:{{ $diadesde }}</p>
                    </div>
                    <div class="result-card">
                        <p>Hasta:{{ $diahasta }}</p>
                    </div>
                </div>

                <h2>Visitantes Diarios</h2>
                <table class="results-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Cantidad de Visitantes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($visitantesDiarios as $visita)
                            <tr>
                                <td>{{ $visita->fecha }}</td>
                                <td>{{ $visita->cantidad_visitantes }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


                <h2>Visitantes por Filial</h2>
                <table class="results-table">
                    <thead>
                        <tr>
                            <th>Filial</th>
                            <th>Cantidad de Visitantes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($visitantesPorFilial as $visita)
                            <tr>
                                <td>{{ $visita->filial }}</td>
                                <td>{{ $visita->cantidad_visitantes }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>



                <h2>Visitantes por Gerencia</h2>
                <table class="results-table">
                    <thead>
                        <tr>
                            <th>Gerencia</th>
                            <th>Filial</th>
                            <th>Cantidad de Visitantes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($visitantesPorGerenciaFilial as $visita)
                            <tr>
                                <td>{{ $visita->gerencia }}</td>
                                <td>{{ $visita->filial }}</td>
                                <td>{{ $visita->cantidad_visitantes }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        @elseif (isset($diadesde) && isset($diahasta) && count($visitantesPorGerenciaFilial) == 0)
            <p class="no-results">No hay datos disponibles para el rango de fechas seleccionado.</p>
        @endif
    </div>
    @include('includes._footer')

</body>

</html>
