@extends('layouts.admin.admin')

@section('description')
    <h1>Edicion de Carrera</h1>
    <p>
        Edita una carrera
    </p>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{route('careers.update',['career'=>$career])}}">
            {{ method_field('PUT')}}
            {{ csrf_field() }}
            <div class="form-group">
                <label for="inputNameCareer">Nombre</label>
                <input type="text" class="form-control" name="inputNameCareer" value="{{ $career->name }}" required>
            </div>
            <div class="form-group">
                <label for="inputWithCV">Solicita CV</label>
                <select class="form-control" name="inputWithCV">
                    <option value="1">Si</option>
                    <option value="0">No</option>
                </select>
                <small id="cv-help" class="form-text text-muted">En caso de solicitarlo se le pedirá adjuntarlo al aspirante cuando agende su entrevista.</small>
            </div>
            <div class="form-group">
                <label for="inputWithPortfolio">Solicita Portafolio</label>
                <select class="form-control" name="inputWithPortfolio">
                    <option value="1">Si</option>
                    <option value="0">No</option>
                </select>
                <small id="portfolio-help" class="form-text text-muted">En caso de solicitarlo se le pedirá adjuntarlo al aspirante cuando agende su entrevista.</small>
            </div>
            <div class="row justify-content-center">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{route('careers.index')}}" class="btn btn-link">Regresar</a>
            </div>
        </form>
    </div>
</div>
@endsection