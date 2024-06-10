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
            margin-top: 14px;
            height: 42px;
        }

        .form__container_date {
            display: flex;
            align-items: center;
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
            border: 1px solid #9c9c9c;
            padding: 8px;
            text-align: left;
            border: 1px solid black;

        }

        .results-table th {
            background-color: #9c9c9c;
            border: 1px solid black
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

        h2 {
            margin: 20px 0;
            padding: 10px
        }

        .container-table {
            background: #9c9c9c;
            border-radius: 8px;

        }

        th {
            background: #9c9c9c;
            border: 1px solid black;
        }
    </style>
</head>

<body>
    @include('includes._cintillo')
    @include('includes._register_button', ['titulo' => 'Dashboard de Visitantes'])

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
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
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
        <h1>Dashboard de Visitantes </h1>
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
                <input class="form__submit" type="submit" value="Filtrar">
            </div>

        </form>
        <div class="results">
            <div class="result-cards">
                <div class="result-card">
                    <p>Desde: {{ \Carbon\Carbon::parse($diadesde)->format('d/m/Y') }}</p>
                </div>
                <div class="result-card">
                    <p>Hasta: {{ \Carbon\Carbon::parse($diahasta)->format('d/m/Y') }}</p>
                </div>
            </div>

            @if (isset($diadesde) && isset($diahasta) && count($visitantesPorGerenciaFilial) > 0)
                <div class="container-table">
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
                </div>

                <div class="container-table">
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
                </div>


                <div class="container-table">
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


        </div>
    @elseif (isset($diadesde) && isset($diahasta) && count($visitantesPorGerenciaFilial) == 0)
        <p class="no-results">No hay datos disponibles para el rango de fechas seleccionado.</p>
        @endif
    </div>

</body>

</html>
