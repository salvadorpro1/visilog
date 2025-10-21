@extends('layouts.app')

@section('title')
    Registro
@endsection

@section('style')
    <style>
        .modal-confirmation {
            display: none;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1000;
            animation: fadeIn 0.3s;
            overflow: hidden;
        }

        .modal-confirmation-content {
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            gap: 15px;
            transform: scale(0.9);
            animation: popIn 0.3s forwards;
        }

        .modal-confirmation-title {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            color: #333333;
            text-align: center;
        }

        .modal-confirmation-body {
            background: #f8f9fa;
            padding: 15px 20px;
            border-radius: 8px;
            flex: 1;
            overflow-y: auto;
        }

        .modal-confirmation-body ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .modal-confirmation-body li {
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .modal-confirmation-body li strong {
            width: 150px;
            flex-shrink: 0;
        }

        .modal-confirmation-body li.razon-visita {
            flex-direction: column;
        }

        .modal-confirmation-body li:last-child {
            border-bottom: none;
        }

        .modal-confirmation-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            background: #fff;
            position: sticky;
            bottom: 0;
        }

        .modal-btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .cancel-btn {
            background: #e0e0e0;
            color: #333;
        }

        .cancel-btn:hover {
            background: #d6d6d6;
        }

        .confirm-btn {
            background: #4CAF50;
            color: white;
        }

        .confirm-btn:hover {
            background: #45a049;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes popIn {
            0% {
                transform: scale(0.9);
            }

            100% {
                transform: scale(1);
            }
        }


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
            margin-bottom: 20px
        }

        .form_register__container--containerimagen {
            height: 17rem;
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
            transform: rotatey(180deg);

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
            align-items: flex-start;
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

        .divisor__element {
            margin: 10px 0
        }

        .separar {
            display: flex;
            gap: 10px;
            margin: 20px 0;
        }

        .separar__uni {
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            gap: 5px;
        }

        .separar__uni input {
            margin-bottom: 5px;
        }

        /* ==== Campo "Nombre de la empresa" ==== */
        .empresa-input {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 15px;
            position: relative;
        }

        .empresa-label {
            font-weight: 600;
            color: #333;
            font-size: 1rem;
            margin-left: 2px;
        }

        .empresa-field {
            width: 100%;
            padding: 10px 12px;
            font-size: 0.95rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
            transition: all 0.2s ease-in-out;
            box-sizing: border-box;
            background-color: #fff;
        }

        /* Hover y foco */
        .empresa-field:hover {
            border-color: #000000;
        }

        .empresa-field:focus {
            border-color: #000000;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.4);
        }

        /* Placeholder más visible */
        .empresa-field::placeholder {
            color: #aaa;
            font-style: italic;
        }

        /* Ícono opcional (si quisieras añadir uno después) */
        .empresa-input::before {
            position: absolute;
            top: 39px;
            left: 10px;
            opacity: 0.6;
            pointer-events: none;
            font-size: 1rem;
            transition: opacity 0.2s;
        }

        .empresa-field:focus+datalist,
        .empresa-input:hover::before {
            opacity: 0.9;
        }

        /* Para pantallas pequeñas */
        @media (max-width: 600px) {
            .empresa-field {
                font-size: 0.9rem;
                padding: 8px 10px;
            }
        }
    </style>
@endsection

@section('content')

    <h1>Registro de visitas</h1>
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
        <form id="visitorForm" method="POST" action="{{ route('guardar_RegistroVisitor') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="showAll" value="{{ $showAll ? 'true' : 'false' }}">

            @if ($showAll)
                {{-- Registro de visitante nuevo --}}
                <div class="divisor">
                    <div class="divisor__inputs">
                        <div class="divisor__element">
                            <label for="nacionalidad">Nacionalidad</label>
                            <p>
                                @switch($nacionalidad)
                                    @case('V')
                                        Venezolana
                                    @break

                                    @case('E')
                                        Extranjero
                                    @break

                                    @default
                                        Dato no válido
                                @endswitch
                            </p>
                            <input type="hidden" id="nacionalidad" name="nacionalidad" value="{{ $nacionalidad }}">
                        </div>

                        <div class="divisor__element">
                            <label for="cedula">Cédula</label>
                            <p>{{ $cedula }}</p>
                            <input type="hidden" id="cedula" name="cedula" value="{{ $cedula }}">
                        </div>

                        <label for="">Nombre</label>
                        <input name="nombre" value="{{ old('nombre') }}" type="text"
                            style="text-transform: capitalize;">
                        <label for="">Apellido</label>
                        <input name="apellido" value="{{ old('apellido') }}" type="text"
                            style="text-transform: capitalize;">
                        <label for="">Clasificación</label>
                        <div class="separar">
                            <div class="separar__uni">
                                <label for="persona">Persona</label>
                                <label for="empresa">Empresa</label>
                            </div>
                            <div class="separar__uni">
                                <input type="radio" id="persona" name="clasificacion" value="persona"
                                    {{ old('clasificacion') == 'persona' ? 'checked' : '' }} onclick="toggleEmpresaInput()">
                                <input type="radio" id="empresa" name="clasificacion" value="empresa"
                                    {{ old('clasificacion') == 'empresa' ? 'checked' : '' }} onclick="toggleEmpresaInput()">
                            </div>
                        </div>
                        <div id="empresaInput" style="{{ old('clasificacion') == 'empresa' ? '' : 'display: none;' }}">
                            <label for="nombre_empresa">Nombre de la empresa</label>
                            <input style="text-transform: capitalize;" type="text" id="nombre_empresa"
                                name="nombre_empresa" value="{{ old('nombre_empresa') }}">
                        </div>
                        <label for="">Teléfono</label>
                        <input name="telefono" value="{{ old('telefono') }}" type="text" placeholder="Ej: 04121234567"
                            maxlength="11">
                        <label>Tipo de Carnet</label>
                        <div class="separar">
                            <div class="separar__uni">
                                <label for="carnet_visitante">Carnet de visitante</label>
                                <label for="carnet_trabajador">Ficha</label>
                            </div>
                            <div class="separar__uni">
                                <input type="radio" id="carnet_visitante" name="tipo_carnet" value="visitante"
                                    {{ old('tipo_carnet') == 'visitante' ? 'checked' : '' }}>
                                <input type="radio" id="carnet_trabajador" name="tipo_carnet" value="ficha"
                                    {{ old('tipo_carnet') == 'ficha' ? 'checked' : '' }}>
                            </div>
                        </div>
                        <label for="numero_carnet">Número de Carnet</label>
                        <input name="numero_carnet" id="numero_carnet" type="text" value="{{ old('numero_carnet') }}">
                    </div>
                    {{-- Bloque de captura de foto --}}
                    <input type="hidden" id="fotoInput" name="foto">
                    <div class="form_register__container form_register__container--containerimagen">
                        <div class="form_register__container form_register__container--containerimagen">
                            <div class="form_register__imagecontainer" onclick="initCamera(); hideIcon()">
                                <div id="loadingIndicator" class="loading-indicator" style="display:none;">Cargando...</div>
                                <video id="video" autoplay style="display:none;"></video>
                                <img id="photo" style="display:none;" alt="Foto capturada">
                                <img class="icono" src="{{ asset('img/camara.png') }}" alt="">
                            </div>
                            <button type="button" id="capture" onclick="takePhoto()">Tomar Foto</button>
                            <button type="button" id="reset" onclick="resetPhoto()" style="display:none;">Reiniciar
                                Foto</button>
                        </div>
                        <label id="no_foto_label">
                            <input type="checkbox" name="no_foto" id="no_foto" onchange="toggleFotoRequired()"> No
                            tomar
                            foto
                        </label>
                    </div>
                </div>
                <label for="filial_id">Filial</label>
                <select name="filial_id" id="filial_id" onchange="updateGerencias()">
                    <option value="">Elegir filial</option>
                    @foreach ($filials as $filial)
                        <option value="{{ $filial->id }}"
                            {{ old('filial_id', isset($visitor) ? $visitor->filial_id : '') == $filial->id ? 'selected' : '' }}>
                            {{ $filial->siglas }}
                        </option>
                    @endforeach
                </select>
                <label for="gerencia_id">Dirección</label>
                <select name="gerencia_id" id="gerencia_id">
                    <option value="" selected disabled>Elegir dirección</option>
                </select>
                <label for="">Motivo de la visita</label>
                <textarea name="razon_visita" cols="30" rows="10" maxlength="255">{{ old('razon_visita') }}</textarea>
                <a class="button"
                    href="{{ Auth::user()->role == 'operador' ? route('show_consult') : route('show_Dashboard') }}">Volver</a>
                <input type="submit" value="Enviar">
            @else
                {{-- Modo de visitante existente --}}
                <div class="divisor">
                    <div class="divisor__inputs">
                        <div class="divisor__element">
                            <label for="nacionalidad">Nacionalidad</label>
                            <p>
                                @switch($visitor->nacionalidad)
                                    @case('V')
                                        Venezolana
                                    @break

                                    @case('E')
                                        Extranjero
                                    @break

                                    @default
                                        Dato no válido
                                @endswitch
                            </p>
                            <input type="hidden" id="nacionalidad" name="nacionalidad"
                                value="{{ $visitor->nacionalidad }}">
                        </div>
                        <div class="divisor__element">
                            <label for="cedula">Cédula</label>
                            <p>{{ $visitor->cedula }}</p>
                            <input type="hidden" id="cedula" name="cedula" value="{{ $visitor->cedula }}">
                        </div>
                        <div class="divisor__element">
                            <label for="nombre">Nombre</label>
                            <p>{{ $visitor->nombre }}</p>
                            <input type="hidden" id="nombre" name="nombre" value="{{ $visitor->nombre }}">
                        </div>
                        <div class="divisor__element">
                            <label for="apellido">Apellido</label>
                            <p>{{ $visitor->apellido }}</p>
                            <input type="hidden" id="apellido" name="apellido" value="{{ $visitor->apellido }}">
                        </div>
                    </div>
                    <div class="form_register__container form_register__container--containerimagen">
                        @if (!empty($visitor->foto))
                            <div class="form_register__imagecontainer">
                                <img class="foto" src="{{ route('visitor.photo', ['filename' => $visitor->foto]) }}"
                                    alt="Foto del visitante" width="200">
                            </div>
                        @else
                            {{-- Si no existe foto, mostrar bloque de captura --}}
                            <input type="hidden" id="fotoInput" name="foto">
                            <div class="form_register__container form_register__container--containerimagen">
                                <div class="form_register__imagecontainer" onclick="initCamera(); hideIcon()">
                                    <div id="loadingIndicator" class="loading-indicator" style="display:none;">
                                        Cargando...</div>
                                    <video id="video" autoplay style="display:none;"></video>
                                    <img id="photo" style="display:none;" alt="Foto capturada">
                                    <img class="icono" src="{{ asset('img/camara.png') }}" alt="">
                                </div>
                                <button type="button" id="capture" onclick="takePhoto()">Tomar Foto</button>
                                <button type="button" id="reset" onclick="resetPhoto()"
                                    style="display:none;">Reiniciar Foto</button>
                            </div>
                            <label id="no_foto_label">
                                <input type="checkbox" name="no_foto" id="no_foto" onchange="toggleFotoRequired()"> No
                                tomar foto
                            </label>
                        @endif
                    </div>
                </div>
                <label for="">Clasificación</label>
                <div class="separar">
                    <div class="separar__uni">
                        <label for="persona">Persona</label>
                        <label for="empresa">Empresa</label>
                    </div>
                    <div class="separar__uni">
                        <input type="radio" id="persona" name="clasificacion" value="persona"
                            {{ old('clasificacion', '') == 'persona' ? 'checked' : '' }} onclick="toggleEmpresaInput()">
                        <input type="radio" id="empresa" name="clasificacion" value="empresa"
                            {{ old('clasificacion', '') == 'empresa' ? 'checked' : '' }} onclick="toggleEmpresaInput()">
                    </div>
                </div>

                <div id="empresaInput" class="empresa-input" style="display: none;">
                    <label for="nombre_empresa" class="empresa-label">Nombre de la empresa</label>
                    <input list="lista_empresas" id="nombre_empresa" name="nombre_empresa" class="empresa-field"
                        value="{{ old('nombre_empresa', $lastCompanyName ?? '') }}" autocomplete="off"
                        placeholder="Ejemplo: Polar, Movistar, Coca-Cola..." />
                    <datalist id="lista_empresas">
                        @if (isset($companies) && $companies->isNotEmpty())
                            @foreach ($companies as $company)
                                <option value="{{ $company }}"></option>
                            @endforeach
                        @endif
                    </datalist>
                </div>



                <label for="">Teléfono</label>
                <input name="telefono" value="{{ $visitor->telefono }}" type="text" placeholder="Ej: 04121234567"
                    maxlength="11">

                <label>Tipo de Carnet</label>
                <div class="separar">
                    <div class="separar__uni">
                        <label for="carnet_visitante">Carnet de visitante</label>
                        <label for="carnet_trabajador">Ficha</label>
                    </div>
                    <div class="separar__uni">
                        <input type="radio" id="carnet_visitante" name="tipo_carnet" value="visitante"
                            {{ old('tipo_carnet') == 'visitante' ? 'checked' : '' }}>
                        <input type="radio" id="carnet_trabajador" name="tipo_carnet" value="ficha"
                            {{ old('tipo_carnet') == 'ficha' ? 'checked' : '' }}>
                    </div>
                </div>
                <label for="numero_carnet">Número de Carnet</label>
                <input name="numero_carnet" id="numero_carnet" type="text" value="{{ old('numero_carnet') }}">
                <label for="filial_id">Filial</label>
                <select name="filial_id" id="filial_id" onchange="updateGerencias()">
                    <option value="">Elegir filial</option>
                    @foreach ($filials as $filial)
                        <option value="{{ $filial->id }}" {{ old('filial_id') == $filial->id ? 'selected' : '' }}>
                            {{ $filial->siglas }}
                        </option>
                    @endforeach
                </select>
                <label for="gerencia_id">Dirección</label>
                <select name="gerencia_id" id="gerencia_id">
                    <option value="" selected disabled>Elegir dirección</option>
                </select>
                <label for="">Motivo de la visita</label>
                <textarea name="razon_visita" cols="30" rows="10" maxlength="255">{{ old('razon_visita') }}</textarea>
                {{-- En modo existente, si hubiera foto se envía mediante hidden --}}
                @if (!empty($visitor->foto))
                    <input type="hidden" name="foto" value="{{ $visitor->foto }}">
                @endif
                <a class="button"
                    href="{{ Auth::user()->role == 'operador' ? route('show_consult') : route('show_Dashboard') }}">Volver</a>
                <input type="submit" value="Enviar">
            @endif
        </form>
        <div id="confirmationModal" class="modal-confirmation">
            <div class="modal-confirmation-content">
                <h3 class="modal-confirmation-title">¿Quiere enviar estos datos?</h3>
                <div id="confirmationModalContent" class="modal-confirmation-body"></div>
                <div class="modal-confirmation-buttons">
                    <button id="cancelConfirmationBtn" class="modal-btn cancel-btn">Cancelar</button>
                    <button id="confirmConfirmationBtn" class="modal-btn confirm-btn">¡Si, quiero enviarlos!</button>
                </div>
            </div>
        </div>





    </div>


    <script>
        function updateGerencias() {
            const filialId = document.getElementById('filial_id').value;
            const gerenciaSelect = document.getElementById('gerencia_id');
            const csrfToken = "{{ csrf_token() }}"; // Token CSRF desde Laravel

            // Limpiar opciones actuales antes de cargar las nuevas
            gerenciaSelect.innerHTML = '<option value="" selected disabled>Elegir dirección</option>';

            if (filialId) {
                console.log('Cargando gerencias para filial_id:', filialId);

                const formData = new FormData();
                formData.append('_token', csrfToken);

                fetch(`/get-gerencias/${filialId}`, {
                        method: "POST",
                        body: formData
                    })
                    .then(response => {
                        console.log('Respuesta recibida:', response);
                        if (!response.ok) {
                            throw new Error('Error en la respuesta del servidor');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Datos de gerencias recibidos:', data);

                        data.forEach(gerencia => {
                            const option = document.createElement('option');
                            option.value = gerencia.id;
                            option.text = gerencia.nombre;

                            // Mantener `gerencia_id` seleccionado si coincide
                            if (gerencia.id == "{{ old('gerencia_id', request('gerencia_id')) }}") {
                                option.selected = true;
                            }
                            gerenciaSelect.add(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error al cargar las gerencias:', error);
                    });
            } else {
                console.log('No se ha seleccionado ningún filial_id');
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const filialId = document.getElementById('filial_id').value;
            if (filialId) {
                updateGerencias();
            }
        });
    </script>

    <script>
        // Variables globales para los elementos
        let video = document.getElementById('video');
        let photo = document.getElementById('photo');
        let captureButton = document.getElementById('capture');
        let resetButton = document.getElementById('reset');
        let loadingIndicator = document.getElementById('loadingIndicator');

        // Función para iniciar la cámara
        function initCamera() {
            if (loadingIndicator) loadingIndicator.style.display = 'block';
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(stream => {
                    video.srcObject = stream;
                    video.style.display = 'block';
                    photo.style.display = 'none';
                    captureButton.style.display = 'block';
                    resetButton.style.display = 'none';
                    if (loadingIndicator) loadingIndicator.style.display = 'none';
                })
                .catch(err => {
                    console.error("Error al iniciar la cámara:", err);
                    if (loadingIndicator) loadingIndicator.style.display = 'none';
                });
        }

        // Función para capturar la foto
        function takePhoto() {
            let canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            let context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            let dataURL = canvas.toDataURL('image/png');

            // Mostrar la imagen capturada
            photo.src = dataURL;
            photo.style.display = 'block';
            video.style.display = 'none';
            captureButton.style.display = 'none';
            resetButton.style.display = 'block';

            // Asignar el dataURL al input oculto
            document.getElementById('fotoInput').value = dataURL;

            // Detener la cámara
            let stream = video.srcObject;
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }

            // Ocultar checkbox de "No tomar foto"
            let checkbox = document.getElementById("no_foto");
            let label = document.getElementById("no_foto_label");
            if (checkbox) {
                checkbox.checked = false;
                checkbox.style.display = "none";
            }
            if (label) {
                label.style.display = "none";
            }
        }

        // Función para reiniciar la captura
        function resetPhoto() {
            photo.style.display = 'none';
            video.style.display = 'block';
            captureButton.style.display = 'block';
            resetButton.style.display = 'none';
            document.getElementById('fotoInput').value = '';

            // Reiniciar la cámara
            initCamera();

            // Mostrar nuevamente el checkbox de "No tomar foto"
            let checkbox = document.getElementById("no_foto");
            let label = document.getElementById("no_foto_label");
            if (checkbox) checkbox.style.display = "inline";
            if (label) label.style.display = "inline";
        }

        // Función para ocultar el ícono (si es necesario)
        function hideIcon() {
            let icono = document.querySelector('.icono');
            if (icono) icono.style.display = 'none';
        }

        // Alternar el requerimiento del input foto según el checkbox
        function toggleFotoRequired() {
            const noFotoChecked = document.getElementById('no_foto').checked;
            document.getElementById('fotoInput').required = !noFotoChecked;
        }

        // Mostrar/Ocultar input de empresa según selección
        function toggleEmpresaInput() {
            const empresaRadio = document.getElementById('empresa');
            const empresaInput = document.getElementById('empresaInput');

            if (empresaRadio.checked) {
                empresaInput.style.display = 'block';
            } else {
                empresaInput.style.display = 'none';
                document.getElementById('nombre_empresa').value = '';
            }
        }

        document.addEventListener("DOMContentLoaded", toggleEmpresaInput);



        // Actualizar gerencias (función existente, se deja igual o con mejoras si es necesario)
        async function updateGerencias() {
            const filialId = document.getElementById('filial_id').value;
            const gerenciaSelect = document.getElementById('gerencia_id');
            const csrfToken = "{{ csrf_token() }}";

            // Limpiar las opciones existentes
            gerenciaSelect.innerHTML = '<option value="" selected disabled>Elegir dirección</option>';

            if (filialId) {
                try {
                    const response = await fetch(`/get-gerencias/${filialId}`, {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({})
                    });
                    if (!response.ok) throw new Error('Error en la respuesta del servidor');
                    const data = await response.json();
                    data.forEach(gerencia => {
                        let option = new Option(gerencia.nombre, gerencia.id);
                        // Seleccionar si coincide con el valor previo
                        if (gerencia.id == "{{ old('gerencia_id', request('gerencia_id')) }}") {
                            option.selected = true;
                        }
                        gerenciaSelect.add(option);
                    });
                } catch (error) {
                    console.error('Error al cargar las gerencias:', error);
                }
            }
        }

        // Al cargar el DOM, inicializar funciones necesarias
        document.addEventListener("DOMContentLoaded", function() {
            // Si hay filial seleccionada, cargar gerencias
            if (document.getElementById('filial_id').value) {
                updateGerencias();
            }
            // Inicializar el estado del input empresa
            toggleEmpresaInput();
        });
    </script>

    <script>
        function toggleFotoRequired() {
            const noFotoChecked = document.getElementById('no_foto').checked;
            document.getElementById('fotoInput').required = !noFotoChecked;
        }
    </script>

    <script>
        function toggleEmpresaInput() {
            const empresaRadio = document.getElementById('empresa');
            const empresaInput = document.getElementById('empresaInput');
            const nombreEmpresaInput = document.getElementById('nombre_empresa');

            if (empresaRadio.checked) {
                empresaInput.style.display = 'block';
                // Solo llenar con la última empresa si el campo está vacío
                if (!nombreEmpresaInput.value) {
                    nombreEmpresaInput.value = "{{ $lastCompanyName ?? '' }}";
                }
            } else {
                empresaInput.style.display = 'none';
                nombreEmpresaInput.value = '';
            }
        }


        // Inicializar el estado del input cuando se carga la página
        document.addEventListener('DOMContentLoaded', toggleEmpresaInput);
    </script>

    <script>
        const form = document.getElementById('visitorForm');
        const modal = document.getElementById('confirmationModal');
        const modalContent = document.getElementById('confirmationModalContent');
        const cancelBtn = document.getElementById('cancelConfirmationBtn');
        const confirmBtn = document.getElementById('confirmConfirmationBtn');

        const labels = {
            nacionalidad: "Nacionalidad",
            cedula: "Cédula",
            nombre: "Nombre",
            apellido: "Apellido",
            clasificacion: "Clasificación",
            nombre_empresa: "Empresa",
            telefono: "Teléfono",
            tipo_carnet: "Tipo de Carnet",
            numero_carnet: "Número de Carnet",
            filial_id: "Filial",
            gerencia_id: "Dirección",
            razon_visita: "Razón de visita"
        };

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(form);
            const clasificacion = formData.get('clasificacion');
            let html = '<ul>';

            formData.forEach((value, key) => {
                if (['foto', '_token', 'showAll', 'no_foto'].includes(key)) return;

                let displayValue = value ? value.toString().toUpperCase() : '';
                let liClass = key === 'razon_visita' ? 'razon-visita' : '';

                // Reemplazar nacionalidad
                if (key === 'nacionalidad') {
                    if (value === 'V') displayValue = 'VENEZOLANA';
                    else if (value === 'E') displayValue = 'EXTRANJERO';
                }

                if (key === 'nombre_empresa') {
                    if (clasificacion === 'empresa' && displayValue) {
                        html +=
                            `<li class="${liClass}"><strong>${labels[key]}:</strong> ${displayValue}</li>`;
                    }
                    return;
                }

                if (key === 'filial_id') {
                    const filialSelect = document.getElementById('filial_id');
                    const filialName = filialSelect.options[filialSelect.selectedIndex]?.text
                        .toUpperCase() || '';
                    html += `<li class="${liClass}"><strong>${labels[key]}:</strong> ${filialName}</li>`;
                    return;
                }

                if (key === 'gerencia_id') {
                    const gerenciaSelect = document.getElementById('gerencia_id');
                    const gerenciaName = gerenciaSelect.options[gerenciaSelect.selectedIndex]?.text
                        .toUpperCase() || '';
                    html += `<li class="${liClass}"><strong>${labels[key]}:</strong> ${gerenciaName}</li>`;
                    return;
                }

                const label = labels[key] || key.replace(/_/g, ' ');
                html += `<li class="${liClass}"><strong>${label}:</strong> ${displayValue}</li>`;
            });

            html += '</ul>';
            modalContent.innerHTML = html;
            modal.style.display = 'flex';
        });

        cancelBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        confirmBtn.addEventListener('click', function() {
            form.submit();
        });
    </script>

@endsection
