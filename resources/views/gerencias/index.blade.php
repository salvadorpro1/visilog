@extends('layouts.app')

@section('title', 'Gerencias')

@section('content')
    <div class="container">
        <h1>Gerencias</h1>
        <a href="{{ route('gerencias.create') }}" class="btn btn-primary">Crear Gerencia</a>
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
                        <td>{{ $gerencia->nombre }}</td>
                        <td>{{ $gerencia->filial->nombre }}</td>
                        <td>
                            <a href="{{ route('gerencias.edit', $gerencia->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('gerencias.destroy', $gerencia->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
