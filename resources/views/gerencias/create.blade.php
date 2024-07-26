@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Crear Gerencia</h1>
        <form action="{{ route('gerencias.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="filial_id">Filial</label>
                <select class="form-control" id="filial_id" name="filial_id" required>
                    @foreach ($filiales as $filial)
                        <option value="{{ $filial->id }}">{{ $filial->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection
