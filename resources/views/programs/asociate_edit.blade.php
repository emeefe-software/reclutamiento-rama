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
        <form method="POST" action="{{route('programs.asociate.update')}}">
            {{ csrf_field() }}
            
            <div class="form-group">
                <label for="program">Programa *</label>
                <input type="hidden" name="program_id" value="{{$program->id}}">
                <?php $university=$program->university; ?>
                <br>
                <label for="program">
                    @empty($university->shortName)
                        <b>{{ trim($university->name).' - '.$program->name }}</b>
                    @else
                        <b>{{ trim($university->shortName).' - '.$program->name }}</b>
                    @endif
                </label>
            </div>
            <div class="form-group">
                <label for="career">Carrera *</label>
                <input type="hidden" name="careerOld" value="{{$careerUpdate->id}}">
                <select class="form-control" name="career">
                    @foreach($careers as $career)
                        @if($career->id==$careerUpdate->id)
                            <option selected value="<?php echo $career->id?>"> {{ $career->name }}</option>
                        @else
                            <option value="<?php echo $career->id?>"> {{ $career->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="responsable">Encargado *</label>
                <select class="form-control" name="responsable">
                    @foreach($responsables as $responsable)
                        @if($responsable->id==$responsableUpdate->id)
                            <option selected value="<?php echo $responsable->id?>"> <?php echo $responsable->fullname()?></option>
                        @else
                            <option value="<?php echo $responsable->id?>"> <?php echo $responsable->fullname()?></option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="places">Lugares *</label>
                <input type="number" class="form-control" min=1 max=10 name="places" value="{{$program->careers()->where('id',$careerUpdate->id)->first()->pivot->places}}" required>
                <small id="help-places" class="form-text text-muted">Este valor solo es de consulta y es para tener la referencia de la cantidad de aspirantes a aceptar.</small>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{route('programs.index')}}" class="btn btn-link">Regresar</a>
        </form>
    </div>
</div>
@endsection
