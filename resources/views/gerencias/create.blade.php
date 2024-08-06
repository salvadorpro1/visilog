@extends('layouts.app')

@section('title', 'Crear Gerencia')

@section('content')
    <div class="container">
        <h1>Crear Gerencia</h1>
        <form action="{{ route('gerencias.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="filial_id">Filial</label>
                <select name="filial_id" id="filial_id" class="form-control" required>
                    @foreach ($filiales as $filial)
                        <option value="{{ $filial->id }}">{{ $filial->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection
