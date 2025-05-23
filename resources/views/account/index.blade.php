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
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .btn-primary:active {
            transform: scale(0.97)
        }

        .btn-primary--back {
            padding: 10px 30px;
            background-color: #6C757D;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-primary--back:active {
            transform: scale(0.97)
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

        .btn-secondary {
            padding: 8px
        }
    </style>
@endsection

@section('content')
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
        <h1>Reporte de Visitantes</h1>
        @if (isset($visitors) && $visitors->count() > 0)
            <!-- Mostrar el botón de descarga si hay visitantes -->
            <form method="GET" action="{{ route('download_report') }}">
                @csrf
                <input type="hidden" name="filial_id" value="{{ old('filial_id', request('filial_id')) }}">
                <input type="hidden" name="gerencia_id" value="{{ old('gerencia_id', request('gerencia_id')) }}">
                <input type="hidden" name="diadesde" value="{{ old('diadesde', request('diadesde')) }}">
                <input type="hidden" name="diahasta" value="{{ old('diahasta', request('diahasta')) }}">
                <button type="submit" class="btn btn-secondary">Descargar Excel</button>
            </form>
        @endif

        <!-- Formulario de filtros -->
        <form method="POST" action="{{ route('show_Account') }}" class="mb-5">
            @csrf

            <div class="form-group">
                <label for="show_deleted">
                    <input type="checkbox" id="show_deleted" name="show_deleted" value="on"
                        {{ old('show_deleted', request('show_deleted', 'off')) === 'on' ? 'checked' : '' }}>
                    Direcciones eliminadas
                </label>
            </div>
            <input type="hidden" name="filial_id" value="{{ old('filial_id', request('filial_id')) }}">
            <input type="hidden" name="gerencia_id" value="{{ old('gerencia_id', request('gerencia_id')) }}">
            <input type="hidden" name="diadesde" value="{{ old('diadesde', request('diadesde')) }}">
            <input type="hidden" name="diahasta" value="{{ old('diahasta', request('diahasta')) }}">
            {{-- <input type="hidden" name="show_deleted" value="off"> --}}


            <div class="form-group">
                <label for="filial_id">Filial:</label>
                <select name="filial_id" id="filial_id" class="form-control">
                    <option value="">Seleccione una filial</option>
                    @foreach ($filials as $filial)
                        <option value="{{ $filial->id }}"
                            {{ old('filial_id', request('filial_id')) == $filial->id ? 'selected' : '' }}>
                            {{ $filial->siglas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="gerencia_id">Direcciones:</label>
                <select name="gerencia_id" id="gerencia_id" class="form-control">
                    <option value="">Todas las Direcciones</option>
                    @if (!empty($gerencias))
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
                    value="{{ old('diadesde', request('diadesde')) }}"
                    min="{{ \Carbon\Carbon::parse($fechaMinima)->format('Y-m-d') }}" max="{{ date('Y-m-d') }}">
            </div>

            <div class="form-group">
                <label for="diahasta">Fecha hasta:</label>
                <input type="date" name="diahasta" id="diahasta" class="form-control"
                    value="{{ old('diahasta', request('diahasta')) }}"
                    min="{{ \Carbon\Carbon::parse($fechaMinima)->format('Y-m-d') }}" max="{{ date('Y-m-d') }}">
            </div>

            <div class="form-buttons">
                <a class="button btn-primary--back" href="{{ route('show_Dashboard') }}">Volver al tablero</a>
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
                            <th>Dirección</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($visitors as $visitor)
                            <tr>
                                <td><a
                                        href="{{ route('show_Register_Visitor_Detail', $visitor->id) }}">{{ $visitor->cedula }}</a>
                                </td>
                                <td>{{ $visitor->nombre }}</td>
                                <td>{{ $visitor->created_at->format('d/m/Y') }}</td>
                                <td>{{ $visitor->filial->siglas }}</td>
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
                                <td>{{ $filial->siglas }}</td>
                                <td>{{ $filial->visitante_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const filialSelect = document.getElementById('filial_id');
            const gerenciaSelect = document.getElementById('gerencia_id');
            const showDeletedCheckbox = document.getElementById('show_deleted');
            const csrfToken = "{{ csrf_token() }}"; // Obtener el token CSRF desde Laravel

            // Mantener el estado del checkbox `show_deleted` basado en la URL
            if ("{{ old('show_deleted', request('show_deleted')) }}" === 'on') {
                showDeletedCheckbox.checked = true;
            } else {
                showDeletedCheckbox.checked = false;
            }
            // Si hay un `filial_id` seleccionado, cargar sus `gerencias` desde el controlador
            if (filialSelect.value) {
                loadGerencias(filialSelect.value);
            }

            // Al cambiar `filial_id`, cargar `gerencias` con AJAX
            filialSelect.addEventListener('change', function() {
                loadGerencias(this.value);
            });

            // Al cambiar el estado del checkbox, recargar las gerencias
            showDeletedCheckbox.addEventListener('change', function() {
                loadGerencias(filialSelect.value);
            });

            function loadGerencias(filialId) {
                if (filialId) {
                    const formData = new FormData();
                    formData.append('show_deleted', showDeletedCheckbox.checked ? 'on' :
                        'off'); // Agregar `show_deleted`
                    formData.append('_token', csrfToken); // Incluir el token CSRF en la solicitud POST

                    // Realizar la solicitud POST para obtener las gerencias, usando el `filial_id` en la URL
                    fetch(`/get-gerencias/${filialId}`, {
                            method: "POST",
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            gerenciaSelect.innerHTML = ''; // Limpiar opciones actuales

                            // Opción para "Todas las Direcciones"
                            const defaultOption = document.createElement('option');
                            defaultOption.value = '';
                            defaultOption.text = 'Todas las Direcciones';
                            gerenciaSelect.add(defaultOption);

                            // Cargar gerencias obtenidas por AJAX
                            if (data.length > 0) {
                                data.forEach(gerencia => {
                                    const option = document.createElement('option');
                                    option.value = gerencia.id;
                                    option.text = gerencia.nombre;

                                    // Si la gerencia está eliminada, añadir "(eliminada)" al nombre
                                    if (gerencia.is_deleted) {
                                        option.text += ' (eliminada)';
                                    }

                                    // Mantener `gerencia_id` seleccionado
                                    option.selected = gerencia.id ==
                                        "{{ old('gerencia_id', request('gerencia_id')) }}";
                                    gerenciaSelect.add(option);
                                });
                            } else {
                                const noDataOption = document.createElement('option');
                                noDataOption.value = '';
                                noDataOption.text = 'No hay Direcciones disponibles';
                                gerenciaSelect.add(noDataOption);
                            }
                        })
                        .catch(error => {
                            console.error('Error al cargar las Gerencias:', error);
                        });
                }
            }
        });
    </script>

@endsection
