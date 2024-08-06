@extends('layouts.app')

@section('title', 'Filiales')

@section('content')
    <div class="container">
        <h1>Filiales</h1>
        <a href="{{ route('filiales.create') }}" class="btn btn-primary">Crear Filial</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($filiales as $filial)
                    <tr>
                        <td>{{ $filial->id }}</td>
                        <td>{{ $filial->nombre }}</td>
                        <td>
                            <a href="{{ route('filiales.edit', $filial->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('filiales.destroy', $filial->id) }}" method="POST"
                                style="display:inline-block;"
                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta filial?');">
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
