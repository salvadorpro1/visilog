@extends('layouts.app')

@section('title', 'Editar Gerencia')

@section('content')
    <div class="container">
        <h1>Editar Gerencia</h1>
        <form action="{{ route('gerencias.update', $gerencia->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $gerencia->nombre }}"
                    required>
            </div>
            <div class="form-group">
                <label for="filial_id">Filial</label>
                <select name="filial_id" id="filial_id" class="form-control" required>
                    @foreach ($filiales as $filial)
                        <option value="{{ $filial->id }}" {{ $filial->id == $gerencia->filial_id ? 'selected' : '' }}>
                            {{ $filial->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
@endsection
