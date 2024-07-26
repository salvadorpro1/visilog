@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Gerencia</h1>
        <form action="{{ route('gerencias.update', $gerencia->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="filial_id">Filial</label>
                <select class="form-control" id="filial_id" name="filial_id" required>
                    @foreach ($filiales as $filial)
                        <option value="{{ $filial->id }}" {{ $gerencia->filial_id == $filial->id ? 'selected' : '' }}>
                            {{ $filial->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $gerencia->nombre }}"
                    required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
@endsection
