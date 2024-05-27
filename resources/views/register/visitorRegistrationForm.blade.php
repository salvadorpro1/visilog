<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro</title>
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

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .alert {
            margin-top: 10px;
            padding: 10px;
            background-color: #f2f2f2;
            border-left: 4px solid #4caf50;
            color: #333;
        }
    </style>
</head>

<body>
    @include('includes._register_button', ['titulo' => 'Registrar Visitante'])

    <div class="container">


        <form method="POST" action="{{ route('guardar_RegistroVisitor') }}">
            @csrf
            @if ($showAll)
                <label for="">Nacionalidad</label>
                <select name="nacionalidad" disabled>
                    <option value="V" {{ $nacionalidad == 'V' ? 'selected' : '' }}>V</option>
                    <option value="E" {{ $nacionalidad == 'E' ? 'selected' : '' }}>E</option>
                </select>
                <input type="hidden" name="nacionalidad" value="{{ $nacionalidad }}">
                <label for="">Cédula</label>
                <input name="cedula" value="{{ $cedula }}" type="number">
                <label for="">Nombre</label>
                <input name="nombre" type="text">
                <label for="">Apellido</label>
                <input name="apellido" type="text">
                <label for="">Filial</label>
                <select name="filial"
                    onchange="quitarSeleccionInicial('filial'), updateGerenciaOptions(this.value, 'gerencia')">
                    <option value="" selected disabled>Elegir filial</option>
                    <option value="vencemos">Vencemos</option>
                    <option value="invecem">Invecem</option>
                    <option value="fnc">FNC</option>
                </select>
                <label for="">Gerencia</label>
                <select name="gerencia" onchange="quitarSeleccionInicial('gerencia')">
                    <option value="" selected disabled>Elegir gerencia</option>
                </select>
                <label for="">Razón de la visita</label>
                <textarea name="razon_visita" cols="30" rows="10"></textarea>
                <input type="submit" value="Enviar">
                <a href="{{ route('show_ConsulForm') }}">Volver</a>
            @else
                <label for="">Nacionalidad</label>
                <select name="nacionalidad" disabled>
                    <option value="V" {{ $visitor->nacionalidad == 'V' ? 'selected' : '' }}>V</option>
                    <option value="E" {{ $visitor->nacionalidad == 'E' ? 'selected' : '' }}>E</option>
                </select>
                <label for="">Cédula</label>
                <input name="cedula" readonly value="{{ $visitor->cedula }}" type="number">
                <label for="">Nombre</label>
                <input name="nombre" readonly value="{{ $visitor->nombre }}" type="text">
                <label for="">Apellido</label>
                <input name="apellido" readonly value="{{ $visitor->apellido }}" type="text">
                <label for="">Filial</label>
                <select name="filial"
                    onchange="quitarSeleccionInicial('filial'), updateGerenciaOptions(this.value, 'gerencia')">
                    <option value="" selected disabled>Elegir filial</option>
                    <option value="vencemos">Vencemos</option>
                    <option value="invecem">Invecem</option>
                    <option value="fnc">FNC</option>
                </select>
                <label for="">Gerencia</label>
                <select name="gerencia" onchange="quitarSeleccionInicial('gerencia')">
                    <option value="" selected disabled>Elegir gerencia</option>
                </select>
                <label for="">Razón de la visita</label>
                <textarea name="razon_visita" cols="30" rows="10"></textarea>
                <input type="submit" value="Enviar">
                <a href="{{ route('show_ConsulForm') }}">Volver</a>
            @endif
        </form>



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
                opciones = ['value1A', 'value2A', 'value3A'];
            } else if (filialValue === 'invecem') {
                opciones = ['value1B', 'value2B', 'value3B'];
            } else {
                opciones = ['value1C', 'value2C', 'value3C']; // Opciones predeterminadas
            }

            opciones.forEach(function(opcion) {
                var option = document.createElement('option');
                option.value = opcion;
                option.text = opcion;
                gerenciaSelect.appendChild(option);
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

</body>

</html>
