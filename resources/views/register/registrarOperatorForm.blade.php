@extends('layouts.app')

@section('title')
    Recepcionistas
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
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            border: none;
            cursor: pointer;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            background-color: #0dcaf0;
            /* Color por defecto */
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-align: center;
            font-size: 16px;
        }

        .button:active {
            transform: scale(0.97)
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

        .operator-cards-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 20px;
            height: 360px;
            overflow: auto;
        }

        .operator-card {
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .operator-card p {
            margin: 5px 0;
        }

        .operator-card .button {
            display: inline-block;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .modal-header .close {
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
        }

        .modal-body {
            padding: 10px 0;
        }

        .modal-body p {
            margin: 0 0 20px 0;
        }

        .modal-body form {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dividir {
            display: flex;
            justify-content: center;
            gap: 0 5%;
            align-items: center;
            height: 83.5vh;
        }

        .button-danger {
            background-color: #dc3545;
        }

        .button__back {
            background-color: #6C757D;
            /* Color para volver */
        }


        .button__summit {
            background-color: #007bff;
            /* Color para guardar */
        }

        .button:hover {
            opacity: 0.9;
            /* Efecto hover para todos los botones */
        }

        .alert {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        /* Modal específico para cambiar contraseña */
        .modal-password {
            display: none;
            position: fixed;
            z-index: 1002;
            /* más alto que otros modales */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(2px);
            transition: opacity 0.3s ease;
        }

        /* Contenido del modal */
        .modal-password .modal-content {
            background-color: #fff;
            margin: 12% auto;
            padding: 30px 25px;
            border-radius: 12px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.35);
            transform: translateY(-20px);
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        /* Header */
        .modal-password .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .modal-password .modal-header .modal-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
        }

        .modal-password .modal-header .close {
            font-size: 1.5rem;
            font-weight: bold;
            color: #888;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .modal-password .modal-header .close:hover {
            color: #ff4d4f;
        }

        /* Body */
        .modal-password .modal-body {
            padding: 20px 0 0 0;
        }

        .modal-password .modal-body form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        /* Inputs */
        .modal-password .modal-body input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .modal-password .modal-body input[type="password"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.3);
            outline: none;
        }

        /* Botones */
        .modal-password .modal-body .button {
            padding: 10px;
            font-size: 15px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s ease;
        }

        .modal-password .modal-body .button:hover {
            opacity: 0.95;
            transform: translateY(-1px);
        }

        .modal-password .modal-body .button.button__summit {
            background-color: #007bff;
            color: #fff;
        }

        .modal-password .modal-body .button.button__summit:hover {
            background-color: #0056b3;
        }

        .modal-password .modal-body .button.button__cancel {
            background-color: #6c757d;
            color: #fff;
        }

        .modal-password .modal-body .button.button__cancel:hover {
            background-color: #565e64;
        }

        /* Responsive */
        @media (max-width: 500px) {
            .modal-password .modal-content {
                margin: 15% auto;
                padding: 20px;
            }
        }
    </style>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="dividir">
        <div class="container">
            <h1>Crear Recepcionista</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('create_operator') }}" method="POST" class="form">
                @csrf

                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}">
                </div>

                <div class="form-group">
                    <label for="username">Nombre de Usuario:</label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}">
                </div>

                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" id="password">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar Contraseña:</label>
                    <input type="password" name="password_confirmation" id="password_confirmation">
                </div>

                <div class="form-actions">
                    <a class="button button__back" href="{{ route('show_Dashboard') }}">Volver al tablero</a>
                    <button type="submit" class="button button__summit">Guardar</button>
                </div>
            </form>
        </div>
        <div class="container">
            <h1>Recepcionistas Activos</h1>
            <div class="operator-cards-container">
                @if ($operadores->isEmpty())
                    <p>No hay Recepcionistas activos.</p>
                @else
                    @foreach ($operadores as $operador)
                        <div class="operator-card">
                            <p>Nombre: {{ $operador->name }}</p>
                            <p>Nombre de usuario: {{ $operador->username }}</p>
                            <button type="button" class="button button-danger"
                                onclick="confirmDeactivation({{ $operador->id }}, '{{ $operador->name }}')">Desactivar
                            </button>
                            <a href="{{ route('history_Operator', $operador->id) }}" class="button">Registros</a>
                            <button type="button" class="button button__summit"
                                onclick="openPasswordModal({{ $operador->id }}, '{{ $operador->name }}')">
                                Cambiar Contraseña
                            </button>

                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>


    <!-- Modal para cambiar contraseña -->

    <div class="modal-password" id="passwordModal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar Contraseña</h5>
                <span class="close" onclick="closePasswordModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form id="passwordForm" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="new_password">Nueva Contraseña:</label>
                        <input type="password" name="new_password" id="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password_confirmation">Confirmar Contraseña:</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" required>
                    </div>
                    <button type="button" class="button button__cancel" onclick="closePasswordModal()">Cancelar</button>
                    <button type="submit" class="button button__summit">Actualizar</button>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal" id="confirmModal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Desactivación</h5>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body">
                <p id="confirmMessage"></p>
                <form id="confirmForm" method="POST">
                    @csrf
                    <button type="button" class="button" onclick="closeModal()">Cancelar</button>
                    <button type="submit" class="button button-danger">Desactivar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript para manejar el modal -->
    <script>
        function confirmDeactivation(operatorId, operatorName) {
            const actionUrl = '{{ route('deactivate_Operator', ':id') }}'.replace(':id', operatorId);
            document.getElementById('confirmForm').action = actionUrl;
            document.getElementById('confirmMessage').innerText =
                `¿Seguro desea desactivar al recepcionista ${operatorName}?`;
            document.getElementById('confirmModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('confirmModal').style.display = 'none';
        }

        // Close the modal if clicked outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('confirmModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
    <script>
        function openPasswordModal(operatorId, operatorName) {
            const actionUrl = '{{ route('update_operator_password', ':id') }}'.replace(':id', operatorId);
            document.getElementById('passwordForm').action = actionUrl;
            document.getElementById('passwordModal').style.display = 'block';
        }

        function closePasswordModal() {
            document.getElementById('passwordModal').style.display = 'none';
            document.getElementById('new_password').value = '';
            document.getElementById('new_password_confirmation').value = '';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('passwordModal');
            if (event.target == modal) {
                closePasswordModal();
            }
        }
    </script>

@endsection
