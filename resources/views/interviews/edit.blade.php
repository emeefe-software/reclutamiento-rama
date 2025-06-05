@extends('layouts.admin.admin', [
    'title' => 'Entrevista'
])

@section('description')
    <h1>Entrevista</h1>
    <p>
        Esta herramienta te sirve para dar seguimiento a los aspirantes a practicantes, puedes llevar un registro por medio de notas que podrás ver después tanto tu como los usuarios que tengan permiso para acceder a esta sección.
        <br><br>Además puedes indicar el estatus de la entrevista en la sub secciín <b>Estatus</b>, esto quedará como registro y puedes actualizar este valor en el momento que desees sin restricciones.
    </p>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <?php
            $candidate=$interview->candidate;
            $program=$interview->program;
            $career=$program->careers()->find($interview->career_id); 
            $responsable = App\User::find($career->pivot->responsable_id);
        ?>
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <h5 class="card-header bg-primary text-white">Solicitante</h5>
                        <div class="card-body">
                            <?php $candidate=$interview->candidate; ?>
                                <b>Nombre:</b> {{$candidate->fullname()}}
                                <br><b>Email:</b> {{$candidate->email}}
                                <br><b>Teléfono:</b> {{$candidate->phone}}
                                <br><b>Carrera:</b> {{$career->name}}
                                <br><b>Skype:</b> {{$candidate->skype}}
                                <div class="row mt-4">
                                    @if($interview->CV)
                                        <div class="col-sm-6">
                                            <a target="_blank" href="{{\Storage::url($interview->CV)}}" class="btn btn-primary">Descargar CV</a>
                                        </div>
                                    @endif
                                    @if($interview->portfolio)
                                        <div class="col-sm-6">
                                            <a target="_blank" href="{{\Storage::url($interview->portfolio)}}" class="btn btn-primary">Descargar portafolio</a>
                                        </div>
                                    @endif
                                </div>
                        </div>
                </div>
                <br>
                <div class="card">
                    <h5 class="card-header text-white bg-secondary">Entrevista</h5>
                    <div class="card-body">
                        <b>Fecha y hora:</b> {{$interview->hour->first()->datetime}}
                        <br><b>Estatus:</b> {{$interview->getStatus()}}
                        <br><b>Encargado:</b> {{$responsable->fullname()}}
                        <br><b>Carrera a fin:</b> {{$career->name}}
                        <br><b>Programa:</b> {{$program->name}}
                        <br><b>Universidad:</b> {{$program->university->name}}
                    </div>
                </div>
                <br>
                <div class="card ">
                    <h5 class="card-header text-white bg-secondary">Historial</h5>
                    <ul class="list-group list-group-flush">
                        @foreach($records as $record)
                            <li class="list-group-item">
                                <b>{{$record->summary}}</b>
                                <br><small>{{$record->created_at}}</small>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="card">
                    <h5 class="card-header text-white bg-secondary">Estatus</h5>
                    <div class="card-body">
                        <form id="update" method="POST" action="{{route('interviews.update',['interview'=>$interview])}}">
                            {{ method_field('PUT')}}
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <select class="form-control" name="status">
                                            @foreach($interview->getAllStatus() as $status)
                                                @if($interview->getStatus($interview->status)==$status)
                                                    <option selected value="{{$status}}">{{$status}}</option>
                                                @else
                                                    <option value="{{$status}}">{{$status}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <button type="submit" class="btn btn-primary">Cambiar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>  
                <br>
                <div class="card">
                    <h5 class="card-header text-white bg-secondary">Nueva Nota</h5>
                    <div class="card-body">
                        <form id="note" method="POST" action="{{route('notes.create')}}"> 
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <textarea class="form-control w-100" name="inputNote" cols="30" rows="9"></textarea>
                                        <input name="idInterview" type="hidden" value="{{$interview->id}}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <button type="submit" class="btn btn-primary">Agregar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
                <div class="card">
                    <h5 class="card-header text-white bg-secondary">Notas</h5>
                    <ul class="list-group list-group-flush">
                        @foreach($notes as $note)
                            <li class="list-group-item">
                                <small class="font-weight-bold">{{$note->created_at}}</small>
                                <br>{!!nl2br($note->note)!!}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{asset('js/backend/pages/interview.js')}}"></script>
@endpush