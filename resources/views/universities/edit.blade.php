@extends('layouts.admin.admin', [
    'title' => 'Editar Universidad'
])

<?php $user=Auth::user(); ?>
@section('description')
    <h1>Edición Universidad</h1>
    <p>
        Edita la universidad proporcionando los datos requeridos.
    </p>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{route('universities.update',['university'=>$university])}}">
            {{ method_field('PUT')}}
            {{ csrf_field() }}
            <div class="form-group">
                <label for="inputNameUniversity">Nombre *</label>
                <input type="text" class="form-control" name="inputNameUniversity" value="{{ $university->name}}" required>
            </div>
            <div class="form-group">
                <label for="inputShortName">Abreviatura *</label>
                <input type="text" class="form-control" name="inputShortName" value="{{ $university->shortName}}" required>
            </div>
            <div class="form-group">
                <label for="inputDescription">Descripción *</label>
                <input type="text" class="form-control" value="{{$university->description}}" name="inputDescription" required>
            </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{route('universities.index')}}" class="btn btn-link">Regresar</a>
        </form>
    </div>
</div>
@endsection