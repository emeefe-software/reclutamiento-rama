@extends('layouts.admin.admin', [
    'title' => 'Registro'
])

<?php $user=Auth::user(); ?>
@section('description')
    <h1>Registro Universidad</h1>
    <p>
        Registra una universidad proporcionando los datos requeridos.
    </p>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{route('universities.store')}}">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="inputNameUniversity">Nombre *</label>
                <input type="text" class="form-control" name="inputNameUniversity" value="{{ old('inputNameUniversity')}}" required>
            </div>
            <div class="form-group">
                <label for="inputShortName">Abreviatura *</label>
                <input type="text" class="form-control" name="inputShortName" value="{{ old('inputShortName')}}" required>
            </div>
            <div class="form-group">
                <label for="inputDescription">Descripción *</label>
                <input type="text" class="form-control" name="inputDescription" required>
            </div>
                <button type="submit" class="btn btn-primary">Registrar</button>
                <a href="{{route('universities.index')}}" class="btn btn-link">Regresar</a>
        </form>
    </div>
</div>
@endsection
