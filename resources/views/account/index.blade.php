@extends('layouts.app')

@section('title')
    Reporte
@endsection

@section('style')
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

        .form__container_date {
            display: flex;
            justify-content: space-evenly;
        }

        .form__container_date div {
            width: 100%;
        }

        .results-table--container {
            background: white;
            width: 48%;

        }

        .dates-container {
            display: flex;
            gap: 0 5px;
        }

        .results-table__title {}

        .table-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0 20px
        }

        td a {
            text-decoration: none;
            color: #0000EE;
        }

        td a:hover {
            text-decoration: underline;
            color: #0000d1;
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
    </style>
@endsection

@section('content')
    <h1>Reporte</h1>
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
        <form class="form" method="GET" action="{{ route('show_Account') }}">
            @csrf
            <label class="form__label" for="filial">Filial</label>
            <select class="form__select" name="filial_id" id="filial_id" onchange="updateGerencias()">
                <option value="" selected disabled>Elegir filial</option>
                @foreach ($filials as $filial)
                    <option value="{{ $filial->id }}" {{ old('filial_id') == $filial->id ? 'selected' : '' }}>
                        {{ $filial->nombre }}
                    </option>
                @endforeach
            </select>

            <label class="form__label" for="gerencia_id">Gerencia</label>
            <select class="form__select" name="gerencia_id" id="gerencia_id">
                <option value="" selected disabled>Elegir gerencia</option>
                @foreach ($gerencias as $gerencia)
                    <option value="{{ $gerencia->id }}" {{ old('gerencia_id') == $gerencia->id ? 'selected' : '' }}>
                        {{ $gerencia->nombre }}
                    </option>
                @endforeach
            </select>

            <div class="form__container_date">
                <div>
                    <label class="form__label" for="diadesde">Desde</label>
                    <input class="form__input" type="date" name="diadesde" id="diadesde"
                        min="{{ \Carbon\Carbon::parse($fechaMinima)->format('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                </div>
                <div>
                    <label class="form__label" for="diahasta">Hasta</label>
                    <input class="form__input" type="date" name="diahasta" id="diahasta"
                        min="{{ \Carbon\Carbon::parse($fechaMinima)->format('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                </div>
            </div>

            <a class="button" href="{{ route('show_Dashboard') }}">Volver</a>
            <input class="form__submit" type="submit" value="Consultar">
        </form>

        @if (isset($visitorCount) && !is_null($visitorCount))
            <div class="results">
                <h2>Resultados de la Consulta</h2>
                <div class="result-cards">
                    <div class="result-card">
                        <span class="result-label">Filial:</span>
                        <span class="result-value">{{ $filial->nombre }}</span>
                    </div>
                    <div class="result-card">
                        <span class="result-label">Gerencia:</span>
                        <span class="result-value">{{ $gerencia->nombre }}</span>
                    </div>
                    <div class="dates-container">
                        <div class="result-card">
                            <span class="result-label">Desde:</span>
                            <span class="result-value">{{ \Carbon\Carbon::parse($diadesde)->format('d/m/Y') }}</span>
                        </div>
                        <div class="result-card">
                            <span class="result-label">Hasta:</span>
                            <span class="result-value">{{ \Carbon\Carbon::parse($diahasta)->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    <div class="result-card">
                        <span class="result-label">Visitantes:</span>
                        <span class="result-value">{{ 'Hay ' . $visitorCount . ' visitantes totales' }}</span>
                    </div>
                </div>

                @if ($visitors->count() > 0)
                    <table class="results-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Nacionalidad</th>
                                <th>Cédula</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visitors as $visitor)
                                <tr>
                                    <td>{{ $visitor->nombre }}</td>
                                    <td>{{ $visitor->apellido }}</td>
                                    @switch($visitor->nacionalidad)
                                        @case('V')
                                            <td>Venezolana</td>
                                        @break

                                        @case('E')
                                            <td>Extranjero</td>
                                        @break

                                        @default
                                            <td>Dato no válido</td>
                                    @endswitch
                                    <td><a
                                            href="{{ route('show_Register_Visitor_Detail', $visitor->id) }}">{{ $visitor->cedula }}</a>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($visitor->created_at)->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination">
                        {{ $visitors->appends(request()->input())->links() }}
                    </div>
                @else
                    <p class="no-results">No se encontraron visitantes para los criterios seleccionados.</p>
                @endif
            </div>
        @endif
    </div>

    <script>
        function updateGerencias() {
            var filial_id = document.getElementById('filial_id').value;
            var gerenciaSelect = document.getElementById('gerencia_id');

            // Limpiar el select de gerencias antes de llenarlo
            gerenciaSelect.innerHTML = '<option value="" selected>Seleccione una gerencia</option>';

            if (filial_id) {
                fetch(`/get-gerencias/${filial_id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            console.log('No hay gerencias para esta filial.');
                        } else {
                            gerenciaSelect.disabled = false;
                        }
                        data.forEach(gerencia => {
                            var option = document.createElement('option');
                            option.value = gerencia.id;
                            option.text = gerencia.nombre;
                            gerenciaSelect.add(option);
                        });
                    })
                    .catch(error => console.error('Error en la solicitud:', error));
            }

            // Agregar un event listener para deshabilitar la opción "Seleccione una gerencia" después de seleccionar una gerencia
            gerenciaSelect.addEventListener('change', function() {
                var selectedValue = gerenciaSelect.value;
                if (selectedValue) {
                    gerenciaSelect.querySelector('option[value=""]').disabled = true;
                }
            });
        }
    </script>

    <script>
        function quitarSeleccionInicial(nombreSelect) {
            var selectElement = document.getElementsByName(nombreSelect)[0];
            var optionElement = selectElement.querySelector("option[selected][disabled]");
            if (optionElement) {
                optionElement.remove();
            }
        }
    </script>
@endsection
