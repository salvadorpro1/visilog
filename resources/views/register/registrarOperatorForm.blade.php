@extends('layouts.app')

@section('title')
    Operadores
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
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
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

        .button-danger {
            background-color: #dc3545;
        }

        .button-danger:hover {
            background-color: #c82333;
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
            padding: 8px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .operator-card .button:hover {
            background-color: #0056b3;
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
    </style>
@endsection

@section('content')
    <div class="dividir">
        <div class="container">
            <h1>Crear Operador</h1>

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
                    <input type="text" name="name" id="name" required>
                </div>

                <div class="form-group">
                    <label for="username">Nombre de Usuario:</label>
                    <input type="text" name="username" id="username" required>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar Contraseña:</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required>
                </div>

                <div class="form-actions">
                    <a class="button" href="{{ route('show_Dashboard') }}">Volver</a>
                    <button type="submit" class="button">Guardar</button>
                </div>
            </form>
        </div>
        <div class="container">
            <h1>Operadores Activos</h1>
            <div class="operator-cards-container">
                @if ($operadores->isEmpty())
                    <p>No hay operadores activos.</p>
                @else
                    @foreach ($operadores as $operador)
                        <div class="operator-card">
                            <p>Nombre: {{ $operador->name }}</p>
                            <p>Username: {{ $operador->username }}</p>
                            <button type="button" class="button button-danger"
                                onclick="confirmDeactivation({{ $operador->id }}, '{{ $operador->name }}')">Desactivar
                            </button>
                            <a href="{{ route('history_Operator', $operador->id) }}" class="button">Historial</a>
                        </div>
                    @endforeach
                @endif
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
            document.getElementById('confirmMessage').innerText = `¿Seguro desea desactivar al operador ${operatorName}?`;
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
@endsection
