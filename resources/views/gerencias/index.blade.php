@extends('layouts.app')

@section('title', 'Dirección')

@section('style')
    <style>
        .container {
            max-width: 900px;
            margin: 50px auto;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            margin: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #fff;
            border: none;
        }

        .btn-warning:hover {
            background-color: #d39e00;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #343a40;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .button {
            display: inline-block;
            padding: 10px 15px;
            margin: 10px 0;
            color: #ffffff;
            background-color: #17a2b8;
            border: none;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease-in-out;
            cursor: pointer;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

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

        .close {
            cursor: pointer;
            font-size: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 15px;
            margin: 10px 0;
            color: #ffffff;
            background-color: #6C757D;
            border: none;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease-in-out;
        }

        .button-danger {
            background-color: #dc3545;
        }

        .button-danger:hover {
            background-color: #c82333;
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

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .truncate {
            /* Evita que el texto se envuelva */
            overflow: hidden;
            /* Oculta el texto que se desborda */
            text-overflow: ellipsis;
            /* Agrega puntos suspensivos (...) al final del texto truncado */
            max-width: 250px;
            /* Ancho máximo del contenedor */
        }

        .btn {
            text-decoration: none
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
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <h1>Direcciones</h1>

        <!-- Botón para volver -->
        <a class="button" href="{{ route('show_Dashboard') }}">Volver al tablero</a>

        <!-- Botón para crear gerencia -->
        <a href="{{ route('gerencias.create') }}" class="btn btn-primary">Crear</a>

        <!-- Tabla de gerencias -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Filial</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gerencias as $gerencia)
                    <tr>
                        <td>{{ $gerencia->id }}</td>
                        <td class="truncate">{{ $gerencia->nombre }}</td>
                        <td class="truncate">{{ $gerencia->filial->siglas }}</td>
                        <td class="actions">
                            <a href="{{ route('gerencias.edit', $gerencia->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('gerencias.destroy', $gerencia->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger"
                                    onclick="confirmDeletion({{ $gerencia->id }}, '{{ addslashes($gerencia->nombre) }}')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal" id="confirmModal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Eliminación</h5>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body">
                <p id="confirmMessage"></p>
                <form id="confirmForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="button" onclick="closeModal()">Cancelar</button>
                    <button type="submit" class="button button-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
    <div class="pagination justify-content-center">
        {{ $gerencias->links() }} <!-- Enlaces de paginación -->
    </div>
    <script>
        // Mostrar el modal de confirmación
        function confirmDeletion(gerenciaId, gerenciaName) {
            // Definir la URL de eliminación
            const actionUrl = '{{ route('gerencias.destroy', ':id') }}'.replace(':id', gerenciaId);
            document.getElementById('confirmForm').action = actionUrl;

            // Cambiar el mensaje dentro del modal
            document.getElementById('confirmMessage').innerText =
                `¿Está seguro de que desea eliminar la dirección ${gerenciaName}?`;

            // Mostrar el modal
            document.getElementById('confirmModal').style.display = 'block';
        }

        // Cerrar el modal
        function closeModal() {
            document.getElementById('confirmModal').style.display = 'none';
        }

        // Cerrar el modal si se hace clic fuera de él
        window.onclick = function(event) {
            const modal = document.getElementById('confirmModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
@endsection
