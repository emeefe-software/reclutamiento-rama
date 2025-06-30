@extends('layouts.admin.admin')

@section('description')
<h1>{{ $user->fullname() }}</h1>
<p>
    Esta sección muestra el historial de entrevistas del usuario seleccionado. Aquí podrás ver las entrevistas pasadas y detalles relevantes.
</p>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        @if ($interview)
        <?php
        $candidate = $interview->candidate;
        $program = $interview->program;
        $career = $program->careers()->find($interview->career_id);
        $responsable = App\User::find($career->pivot->responsable_id);
        ?>
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <h5 class="card-header bg-primary text-white">Solicitante</h5>
                    <div class="card-body">
                        <b>Nombre:</b> {{ $candidate->fullname() }}
                        <br><b>Email:</b> {{ $candidate->email }}
                        <br><b>Teléfono:</b> {{ $candidate->phone }}
                        <br><b>Carrera:</b> {{ $career->name }}
                        <br><b>Skype:</b> {{ $candidate->skype }}
                        <div class="row mt-4">
                            @if ($interview->CV)
                            <div class="col-sm-6">
                                <a target="_blank" href="{{ \Storage::url($interview->CV) }}" class="btn btn-primary">Descargar CV</a>
                            </div>
                            @endif
                            @if ($interview->portfolio)
                            <div class="col-sm-6">
                                <a target="_blank" href="{{ \Storage::url($interview->portfolio) }}" class="btn btn-primary">Descargar portafolio</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <br>
                <div class="card">
                    <h5 class="card-header text-white bg-secondary">Entrevista</h5>
                    <div class="card-body">
                        <b>Fecha y hora:</b> {{ $interview->hour->first()->datetime }}
                        <br><b>Estatus:</b> {{ $interview->getStatus() }}
                        <br><b>Encargado:</b> {{ $responsable->fullname() }}
                        <br><b>Carrera a fin:</b> {{ $career->name }}
                        <br><b>Programa:</b> {{ $program->name }}
                        <br><b>Universidad:</b> {{ $program->university->name }}
                    </div>
                </div>
                <br>
                <div class="card">
                    <h5 class="card-header text-white bg-secondary">Historial</h5>
                    <ul class="list-group list-group-flush">
                        @foreach ($records as $record)
                        <li class="list-group-item">
                            <b>{{ $record->summary }}</b>
                            <br><small>{{ $record->created_at }}</small>
                        </li>
                        @endforeach
                        @if ($records->isEmpty())
                        <li class="list-group-item text-muted">Sin historial</li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="card">
                    <h5 class="card-header text-white bg-secondary">Estatus</h5>
                    <div class="card-body">
                        <b>Actual estatus:</b> {{ $interview->getStatus() }}
                    </div>
                </div>
                <br>
                <div class="card">
                    <h5 class="card-header text-white bg-secondary">Notas</h5>
                    <ul class="list-group list-group-flush">
                        @forelse ($notes as $note)
                        <li class="list-group-item">
                            <small class="font-weight-bold">{{ $note->created_at }}</small>
                            <br>{!! nl2br(e($note->note)) !!}
                        </li>
                        @empty
                        <li class="list-group-item text-muted">Sin notas</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-warning" role="alert">
            El usuario no cuenta con historial de entrevistas.
        </div>
        @endif
    </div>
</div>
@endsection