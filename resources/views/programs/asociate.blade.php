@extends('layouts.admin.admin', [
    'title' => 'Asociar programa'
])

@section('description')
    <h1>Asociar Programa</h1>
    <p>
        Asocia el programa con algún responsable y carrera disponibles. Esto permite definir quién realizará la entrevista cuando se agende una nueva por los aspirantes, el responsable obtendrá un email con los datos de la entrevista.
    </p>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
    <form method="POST" action="{{route('programs.asociate.store')}}">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="career">Programa *</label>
            <select class="form-control" name="program">
                @foreach($programs as $program)
                    <option value="<?php echo $program->id?>">
                        <?php $university=$program->university; ?>
                        @empty($university->shortName)
                            {{ trim($university->name).'- '.$program->name }}
                        @else
                            {{ trim($university->shortName).' - '.$program->name }}
                        @endif
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="career">Carrera *</label>
            <select class="form-control" name="career">
                @foreach($careers as $career)
                    <option value="<?php echo $career->id?>"> {{ $career->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="responsable">Encargado *</label>
            <select class="form-control" name="responsable">
                @foreach($responsables as $responsable)
                    <option value="<?php echo $responsable->id?>"> <?php echo $responsable->fullname()?></option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="places">Lugares *</label>
            <input type="number" class="form-control" min=1 max=10 name="places" value="{{old('places')}}" required>
            <small id="help-places" class="form-text text-muted">Este valor solo es de consulta y es para tener la referencia de la cantidad de aspirantes a aceptar.</small>
        </div>

        <button type="submit" class="btn btn-primary">Registrar</button>
        <a href="{{route('programs.index')}}" class="btn btn-link">Regresar</a>
    </form>
    </div>
</div>
@endsection
