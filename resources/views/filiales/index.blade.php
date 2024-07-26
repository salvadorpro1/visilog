@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Filiales</h1>
        <a href="{{ route('filiales.create') }}" class="btn btn-primary">Crear Filial</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Gerencias</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($filiales as $filial)
                    <tr>
                        <td>{{ $filial->nombre }}</td>
                        <td>
                            <ul>
                                @foreach ($filial->gerencias as $gerencia)
                                    <li>{{ $gerencia->nombre }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <a href="{{ route('filiales.edit', $filial->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('filiales.destroy', $filial->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                            <a href="{{ route('gerencias.create', ['filial_id' => $filial->id]) }}"
                                class="btn btn-secondary">Agregar Gerencia</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
