@extends('layouts.app')

@section('title')
    Registro
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
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
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

        .form_register__container {
            display: flex;
            width: 100%;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .form_register__container--containerimagen {
            height: 15rem;
            position: relative;
        }

        .form_register__container--affiliate {
            flex-direction: row;
        }

        .form_register__label {
            color: var(--second-color);
            font-size: 1.4rem;
            margin: 1rem 0 0 1rem;
            align-self: flex-start;
            font-weight: 600;
        }

        .form_register__label--center {
            align-self: center;
            margin: 1rem 0 0 0;
        }

        .form_register__imagecontainer {
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid black;
            height: 92%;
            width: 60%;
            cursor: pointer;

        }


        #video,
        #photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }



        #capture,
        #reset {
            display: none;
            margin-top: 10px;
        }

        #photo {
            display: none;
            object-fit: cover
        }

        .foto {
            width: 100%;
            height: 100%;
            object-fit: cover
        }

        .divisor {
            display: flex;
            align-items: center;
        }

        .divisor__inputs {
            width: 100%;
        }

        .icono {
            width: 20%;
            text-align: center;
            position: absolute;
            top: 0;
            bottom: 0;
            right: 0;
            left: 0;
            margin: auto
        }

        .loading-indicator {
            display: none;
            /* Oculto por defecto */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            z-index: 1000;
        }
    </style>
@endsection

@section('content')

    <h1>Registrar Visitante</h1>
    <div class="container">

        <form method="POST" action="{{ route('guardar_RegistroVisitor') }}" enctype="multipart/form-data">
            @csrf
            @if ($showAll)
                <div class="divisor">
                    <div class="divisor__inputs">
                        <label for="">Nacionalidad</label>
                        <select name="nacionalidad" readonly>
                            <option value="V" {{ $nacionalidad == 'V' ? 'selected' : '' }}>V</option>
                            <option value="E" {{ $nacionalidad == 'E' ? 'selected' : '' }}>E</option>
                        </select>
                        <label for="">Cédula</label>
                        <input name="cedula" value="{{ $cedula }}" type="number">
                        <label for="">Nombre</label>
                        <input name="nombre" type="text">
                        <label for="">Apellido</label>
                        <input name="apellido" type="text">
                    </div>
                    <input type="hidden" id="fotoInput" name="foto">
                    <div class="form_register__container form_register__container--containerimagen">
                        <div class="form_register__container form_register__container--containerimagen">
                            <div class="form_register__imagecontainer" onclick="initCamera(); hideIcon()">
                                <div id="loadingIndicator" class="loading-indicator">Cargando...</div>
                                <video id="video" autoplay></video>
                                <img id="photo">
                                <img class="icono" src="{{ asset('img/camara.png') }}" alt="">
                            </div>
                            <button type="button" id="capture" onclick="takePhoto()">Tomar Foto</button>
                            <button type="button" id="reset" onclick="resetPhoto()">Reiniciar Foto</button>
                        </div>
                    </div>
                </div>
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
                <textarea name="razon_visita" cols="30" rows="10" maxlength="255"></textarea>
                <a class="button"
                    href="{{ Auth::user()->role == 'operador' ? route('show_consult') : route('show_Dashboard') }}">
                    Volver
                </a>
                <input type="submit" value="Enviar">
            @else
                <div class="divisor">
                    <div class="divisor__inputs">
                        <label for="">Nacionalidad</label>
                        <select name="nacionalidad" readonly>
                            <option value="V" {{ $visitor->nacionalidad == 'V' ? 'selected' : '' }}>V</option>
                            <option value="E" {{ $visitor->nacionalidad == 'E' ? 'selected' : '' }}>E</option>
                        </select>
                        <label for="">Cédula</label>
                        <input name="cedula" readonly value="{{ $visitor->cedula }}" type="number">
                        <label for="">Nombre</label>
                        <input name="nombre" readonly value="{{ $visitor->nombre }}" type="text">
                        <label for="">Apellido</label>
                        <input name="apellido" readonly value="{{ $visitor->apellido }}" type="text">
                    </div>
                    <div class="form_register__container form_register__container--containerimagen">
                        <div class="form_register__container form_register__container--containerimagen">
                            <div class="form_register__imagecontainer">
                                <img class="foto" src="{{ route('visitor.photo', ['filename' => $visitor->foto]) }}"
                                    alt="Foto del visitante" width="200">
                            </div>
                        </div>
                    </div>
                </div>


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
                <textarea name="razon_visita" cols="30" rows="10" maxlength="255"></textarea>
                <input type="hidden" name="foto" value="{{ $visitor->foto }}">

                <a class="button"
                    href="{{ Auth::user()->role == 'operador' ? route('show_consult') : route('show_Dashboard') }}">
                    Volver
                </a>
                <input type="submit" value="Enviar">
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

    <script>
        let video = document.getElementById('video');
        let photo = document.getElementById('photo');
        let captureButton = document.getElementById('capture');
        let resetButton = document.getElementById('reset');
        let photoInput = document.getElementById('fotoInput');
        let loadingIndicator = document.getElementById('loadingIndicator');

        function initCamera() {
            loadingIndicator.style.display = 'block'; // Mostrar el indicador de carga
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(stream => {
                    video.srcObject = stream;
                    video.style.display = 'block';
                    photo.style.display = 'none';
                    captureButton.style.display = 'block';
                    resetButton.style.display = 'none';
                    loadingIndicator.style.display =
                    'none'; // Ocultar el indicador de carga cuando la cámara esté lista
                })
                .catch(err => {
                    console.log("Error: " + err);
                    loadingIndicator.style.display = 'none'; // Ocultar el indicador de carga en caso de error
                });
        }

        function takePhoto() {
            let canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            let dataURL = canvas.toDataURL('image/png');
            photo.src = dataURL;
            photo.style.display = 'block';
            video.style.display = 'none';
            captureButton.style.display = 'none';
            resetButton.style.display = 'block';
            photoInput.value = dataURL;

            // Detener la corriente de video y cerrar la cámara
            let stream = video.srcObject;
            let tracks = stream.getTracks();
            tracks.forEach(track => track.stop());
        }

        function resetPhoto() {
            photo.style.display = 'none';
            video.style.display = 'block';
            captureButton.style.display = 'block';
            resetButton.style.display = 'none';
            photoInput.value = '';

            // Reiniciar la cámara
            initCamera();
        }

        function hideIcon() {
            var icono = document.querySelector('.icono');
            if (icono) {
                icono.style.display = 'none';
            }
        }
    </script>
@endsection
