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
    <div class="container">
        <h1 class="text-center my-4">Reporte de Visitantes</h1>

        <!-- Formulario de filtros con estilos -->
        <form method="GET" action="{{ route('show_Account') }}" class="mb-5">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="filial_id" class="font-weight-bold">Filial:</label>
                        <select name="filial_id" id="filial_id" class="form-control" required>
                            <option value="">Seleccione una filial</option>
                            @foreach ($filials as $filial)
                                <option value="{{ $filial->id }}" {{ old('filial_id') == $filial->id ? 'selected' : '' }}>
                                    {{ $filial->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="gerencia_id" class="font-weight-bold">Gerencia:</label>
                        <select name="gerencia_id" id="gerencia_id" class="form-control" required>
                            <option value="">Seleccione una gerencia</option>
                            @if (isset($gerencias))
                                @foreach ($gerencias as $gerencia)
                                    <option value="{{ $gerencia->id }}"
                                        {{ old('gerencia_id') == $gerencia->id ? 'selected' : '' }}>
                                        {{ $gerencia->nombre }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="diadesde" class="font-weight-bold">Fecha desde:</label>
                        <input type="date" name="diadesde" id="diadesde" class="form-control"
                            value="{{ old('diadesde', $diadesde ?? '') }}" required min="{{ $fechaMinima }}">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="diahasta" class="font-weight-bold">Fecha hasta:</label>
                        <input type="date" name="diahasta" id="diahasta" class="form-control"
                            value="{{ old('diahasta', $diahasta ?? '') }}" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block mt-3">Filtrar</button>
        </form>

        <!-- Tabla de resultados -->
        @if (isset($visitors) && $visitors->count() > 0)
            <h4>
                Resultados para {{ $visitors->first()->filial->nombre }} - {{ $visitors->first()->gerencia->nombre }}
                ({{ \Carbon\Carbon::parse($diadesde)->format('d/m/Y') }}
                {{ \Carbon\Carbon::parse($diahasta)->format('d/m/Y') }})
            </h4>
            <p><strong>Total de Visitantes: {{ $visitorCount }}</strong></p>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Fecha de Visita</th>
                        <th>Filial</th>
                        <th>Gerencia</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($visitors as $visitor)
                        <tr>
                            <td>{{ $visitor->id }}</td>
                            <td>{{ $visitor->nombre }}</td>
                            <td>{{ \Carbon\Carbon::parse($diahasta)->format('d/m/Y') }}</td>
                            <td>{{ $visitor->filial->nombre }}</td>
                            <td>{{ $visitor->gerencia->nombre }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Paginación -->
            <div class="d-flex justify-content-center">
                {{ $visitors->links() }}
            </div>
        @else
            <p class="alert alert-info">No se encontraron visitantes para los filtros seleccionados.</p>
        @endif

        <!-- Resumen de visitantes por filial -->
        @if (isset($visitorCountsByFilial) && $visitorCountsByFilial->count() > 0)
            <h4>Conteo de Visitantes por Filial</h4>
            <table class="table table-bordered mt-3">
                <thead class="thead-light">
                    <tr>
                        <th>Filial</th>
                        <th>Total de Visitantes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($visitorCountsByFilial as $filialData)
                        <tr>
                            <td>{{ $filialData->filial }}</td>
                            <td>{{ $filialData->visitor_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- Resumen de visitantes por gerencia y filial -->
        @if (isset($visitantesPorGerenciaFilial) && $visitantesPorGerenciaFilial->count() > 0)
            <h4>Visitantes por Gerencia y Filial</h4>
            <table class="table table-bordered mt-3">
                <thead class="thead-light">
                    <tr>
                        <th>Gerencia</th>
                        <th>Filial</th>
                        <th>Cantidad de Visitantes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($visitantesPorGerenciaFilial as $data)
                        <tr>
                            <td>{{ $data->gerencia }}</td>
                            <td>{{ $data->filial }}</td>
                            <td>{{ $data->cantidad_visitantes }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <script>
        // Script para actualizar las gerencias cuando se seleccione una filial
        document.getElementById('filial_id').addEventListener('change', function() {
            var filialId = this.value;

            // Hacer la solicitud AJAX para obtener las gerencias de la filial seleccionada
            if (filialId) {
                fetch(`/get-gerencias/${filialId}`)
                    .then(response => response.json())
                    .then(data => {
                        var gerenciaSelect = document.getElementById('gerencia_id');
                        gerenciaSelect.innerHTML = ''; // Limpiar las opciones actuales

                        if (data.length > 0) {
                            data.forEach(function(gerencia) {
                                var option = document.createElement('option');
                                option.value = gerencia.id;
                                option.text = gerencia.nombre;
                                gerenciaSelect.add(option);
                            });
                        } else {
                            var option = document.createElement('option');
                            option.value = '';
                            option.text = 'No hay gerencias disponibles';
                            gerenciaSelect.add(option);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        });
    </script>

@endsection
