@extends('layouts.app')

@section('title')
    Reporte
@endsection

@section('style')
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            font-weight: 300;
            margin-bottom: 30px;
            font-size: 2.2em;
        }

        /* Estilos para el formulario */
        form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            flex: 1;
            min-width: 200px;
        }

        .form-group label {
            font-weight: bold;
            color: #555;
            margin-bottom: 8px;
        }

        .form-control {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            width: 100%;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn-primary {
            padding: 10px 30px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .btn-primary--back {
            padding: 10px 30px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
            cursor: pointer;
            text-decoration: none;

        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Estilos para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #f1f1f1;
            color: #333;
            font-weight: 600;
        }

        table td {
            color: #555;
        }

        table td a {
            color: #007bff;
            text-decoration: none;
        }

        table td a:hover {
            text-decoration: underline;
        }

        .alert-info {
            background-color: #e9f7fe;
            color: #31708f;
            padding: 15px;
            border: 1px solid #bce8f1;
            border-radius: 5px;
        }

        /* Paginación */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination li {
            list-style: none;
            margin: 0 5px;
        }

        .pagination a {
            padding: 8px 12px;
            color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            border: 1px solid #ddd;
            transition: background-color 0.3s ease;
        }

        .pagination a:hover {
            background-color: #f1f1f1;
        }

        .pagination .active a {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .pagination .disabled a {
            color: #999;
        }

        /* Resumenes */
        .summary-section {
            margin-top: 30px;
        }

        .summary-section h4 {
            color: #555;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .summary-table th,
        .summary-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .summary-table th {
            background-color: #f9f9f9;
            font-weight: 600;
        }

        .summary-table td {
            color: #666;
        }

        .form-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0 10px
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h1>Reporte de Visitantes</h1>

        <!-- Formulario de filtros -->
        <form method="GET" action="{{ route('show_Account') }}" class="mb-5">
            <input type="hidden" name="filial_id" value="{{ request('filial_id') }}">
            <input type="hidden" name="gerencia_id" value="{{ request('gerencia_id') }}">
            <input type="hidden" name="diadesde" value="{{ request('diadesde') }}">
            <input type="hidden" name="diahasta" value="{{ request('diahasta') }}">

            <div class="form-group">
                <label for="filial_id">Filial:</label>
                <select name="filial_id" id="filial_id" class="form-control" required>
                    <option value="">Seleccione una filial</option>
                    @foreach ($filials as $filial)
                        <option value="{{ $filial->id }}"
                            {{ old('filial_id', request('filial_id')) == $filial->id ? 'selected' : '' }}>
                            {{ $filial->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="gerencia_id">Gerencia:</label>
                <select name="gerencia_id" id="gerencia_id" class="form-control">
                    <option value="">Todas las gerencias</option>
                    @if (isset($gerencias))
                        @foreach ($gerencias as $gerencia)
                            <option value="{{ $gerencia->id }}"
                                {{ old('gerencia_id', request('gerencia_id')) == $gerencia->id ? 'selected' : '' }}>
                                {{ $gerencia->nombre }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="form-group">
                <label for="diadesde">Fecha desde:</label>
                <input type="date" name="diadesde" id="diadesde" class="form-control"
                    value="{{ old('diadesde', request('diadesde')) }}" required
                    min="{{ \Carbon\Carbon::parse($fechaMinima)->format('Y-m-d') }}" max="{{ date('Y-m-d') }}">
            </div>

            <div class="form-group">
                <label for="diahasta">Fecha hasta:</label>
                <input type="date" name="diahasta" id="diahasta" class="form-control"
                    value="{{ old('diahasta', request('diahasta')) }}"
                    min="{{ \Carbon\Carbon::parse($fechaMinima)->format('Y-m-d') }}" max="{{ date('Y-m-d') }}">
            </div>

            <div class="form-buttons">
                <a class="btn btn-primary--back" href="{{ route('show_Dashboard') }}">Volver</a>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </form>

        <!-- Resultados -->
        @if (request()->has('filial_id') &&
                request()->has('gerencia_id') &&
                request()->has('diadesde') &&
                request()->has('diahasta'))
            @if (isset($visitors) && $visitors->count() > 0)
                <h4>Resultados para {{ $visitors->first()->filial->nombre }} -
                    {{ request('gerencia_id') ? $visitors->first()->gerencia->nombre : 'Todas las gerencias' }}
                    ({{ \Carbon\Carbon::parse($diadesde)->format('d/m/Y') }} -
                    {{ \Carbon\Carbon::parse($diahasta)->format('d/m/Y') }})</h4>
                <p><strong>Total de Visitantes: {{ $visitorCount }}</strong></p>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Cedula</th>
                            <th>Nombre</th>
                            <th>Fecha de Visita</th>
                            <th>Filial</th>
                            <th>Gerencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($visitors as $visitor)
                            <tr>
                                <td><a
                                        href="{{ route('show_Register_Visitor_Detail', $visitor->id) }}">{{ $visitor->cedula }}</a>
                                </td>
                                <td>{{ $visitor->nombre }}</td>
                                <td>{{ \Carbon\Carbon::parse($diahasta)->format('d/m/Y') }}</td>
                                <td>{{ $visitor->filial->nombre }}</td>
                                <td>{{ $visitor->gerencia->nombre }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Paginación -->
                <div class="pagination">
                    {{ $visitors->appends([
                            'filial_id' => request('filial_id'),
                            'gerencia_id' => request('gerencia_id') ?? '',
                            'diadesde' => request('diadesde'),
                            'diahasta' => request('diahasta'),
                        ])->links() }}
                </div>
            @else
                <p class="alert alert-info">No se encontraron visitantes para los filtros seleccionados.</p>
            @endif
        @endif

        <!-- Resumen por Filial -->
        @if (isset($visitorCountsByFilial) && $visitorCountsByFilial->count() > 0)
            <div class="summary-section">
                <h4>Conteo de Visitantes por Filial</h4>

                <table class="summary-table">
                    <thead>
                        <tr>
                            <th>Filial</th>
                            <th>Cantidad de Visitantes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($visitorCountsByFilial as $filial)
                            <tr>
                                <td>{{ $filial->nombre }}</td>
                                <td>{{ $filial->visitante_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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

                        // Agregar opción para "Todas las gerencias"
                        var defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.text = 'Todas las gerencias';
                        gerenciaSelect.add(defaultOption);

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
