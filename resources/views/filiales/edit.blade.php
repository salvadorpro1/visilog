@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Filial</h1>
        <form action="{{ route('filiales.update', $filial->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $filial->nombre }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
@endsection
