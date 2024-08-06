@extends('layouts.app')

@section('title', 'Editar Filial')

@section('content')
    <div class="container">
        <h1>Editar Filial</h1>
        <form action="{{ route('filiales.update', $filial) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $filial->nombre }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
@endsection
