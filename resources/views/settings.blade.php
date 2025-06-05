@extends('layouts.admin.admin', [
    'title' => 'Configuración'
])

@section('description')
    <h1>Configuración global del sistema</h1>
    <p>
        Configura las distintas opciones, esto afecta al funcionamiento del sistema.
    </p>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
    <form method="POST" action="{{route('settings.save')}}" >
        {{ csrf_field() }}
        <div class="card w-50">
            <div class="card-body">
                <h5 class="card-title">Modalidad de entrevistas</h5>
                <p>
                    Dependiendo la modalidad de entrevista se pedirá al aspirante su cuenta de Skype o no, configura los textos dependiendo la modalidad.
                </p>
                <select class="form-control" name="mode">
                    @if(\Setting::get('mode')=='videoCall')
                        <option value="faceToFace">Presencial</option>
                        <option value="videoCall" selected>Videollamada</option>
                    @else
                        <option value="faceToFace" selected>Presencial</option>
                        <option value="videoCall">Videollamada</option>
                    @endif
                </select>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Texto de entrevista presencial</h5>
                        <p class="card-text">
                            Texto que aparecerá cuando el candidato termine de agendar
                            su entrevista presencial
                        </p>
                        <textarea required class="form-control w-100" name="faceToFace" cols="30" rows="9">{{\Setting::get('msgFaceToFace')}}</textarea>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Texto de entrevista por videollamada</h5>
                        <p class="card-text">
                            Texto que aparecerá cuando el candidato termine de agendar
                            su entrevista por videollamada
                        </p>
                        <textarea required class="form-control w-100" name="videoCall" cols="30" rows="9">{{\Setting::get('msgVideoCall')}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
</div>
@endsection