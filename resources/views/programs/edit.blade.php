@extends('layouts.admin.admin', [
    'title' => 'Registro de programa'
])

@section('description')
    <h1>Registro Programa</h1>
    <p>
        Edita un programa de práctica profesional.
    </p>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
    <form method="POST" action="{{route('programs.update',['program'=>$program])}}">
        {{ method_field('PUT')}}
        {{ csrf_field() }}
        <div class="form-group">
            <label for="folio">Folio</label>
            <input type="text" class="form-control" name="folio" value="{{ $program->folio }}" required>
            <small id="help-folio" class="form-text text-muted">No es necesario que sea único, solo es dato de consulta</small>
        </div>
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" name="name" value="{{ $program->name }}" required>
        </div>
        <div class="form-group">
            <label for="university">Universidad</label>
            <select class="form-control" name="university">
                @foreach($universities as $university)
                    <option value="<?php echo $university->id?>"> <?php echo $university->name?></option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="description">Descripción</label>
            <input type="text" class="form-control" name="description" value="{{$program->description}}" required>
        </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{route('programs.index')}}" class="btn btn-link">Regresar</a>
    </form>
    </div>
</div>
@endsection


@section('form')

@endsection