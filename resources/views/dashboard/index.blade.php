<!DOCTYPE html>
<html>

<head>
    <title>Dashboard de Visitantes</title>
</head>

<body>
    <h1>Dashboard de Visitantes</h1>

    <!-- Formulario para filtrar por rango de fechas -->
    <form action="" method="POST">
        @csrf
        <label for="diadesde">Desde:</label>
        <input type="date" id="diadesde" name="diadesde" value="{{ $diadesde }}" required>
        <label for="diahasta">Hasta:</label>
        <input type="date" id="diahasta" name="diahasta" value="{{ $diahasta }}" required>
        <button type="submit">Filtrar</button>
    </form>

    @if (isset($diadesde) && isset($diahasta) && count($visitantesPorGerenciaFilial) > 0)
        <!-- Mostrar el rango de fechas -->
        <p>Rango de fechas seleccionado: Desde {{ $diadesde }} hasta {{ $diahasta }}</p>

        <!-- Tabla de visitantes por gerencia y filial -->
        <h2>Visitantes por Gerencia y Filial</h2>
        <table border="1">
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

        <!-- Tabla de visitantes diarios -->
        <h2>Visitantes Diarios</h2>
        <table border="1">
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

        <!-- Tabla de visitantes por gerencia -->
        <h2>Visitantes por Gerencia</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Gerencia</th>
                    <th>Cantidad de Visitantes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($visitantesPorGerencia as $visita)
                    <tr>
                        <td>{{ $visita->gerencia }}</td>
                        <td>{{ $visita->cantidad_visitantes }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Tabla de visitantes por filial -->
        <h2>Visitantes por Filial</h2>
        <table border="1">
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
    @elseif (isset($diadesde) && isset($diahasta) && count($visitantesPorGerenciaFilial) == 0)
        <p>No hay datos disponibles para el rango de fechas seleccionado.</p>
    @endif
</body>

</html>
