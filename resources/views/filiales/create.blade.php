@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Crear Filial</h1>
        <form action="{{ route('filiales.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection
