@extends('layouts.admin.admin', [
'title' => 'Dashboard'
])

@section('description')
Bienvenido <b>{{$authenticatedUser->first_name}}</b>
<br><br>
Esta sección muestra un resumen rápido del sistema.
@endsection

@section('content')
@if($pendingInterviews)
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Entrevistas pendientes</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    @foreach($pendingInterviews as $pendingInterview)
                    @php
                        $hour=$pendingInterview->hour()->first();
                        $today=$hour->date()===now()->toDateString() ? true : false;
                        $program=$pendingInterview->program;
                        $career=$program->careers()->find($pendingInterview->career_id);
                        $responsable = App\User::find($career->pivot->responsable_id);
                        $candidato = $pendingInterview->candidate;
                    @endphp
                    @if($responsable->id==$authenticatedUser->id || $rol == 'Admin')
                        <article class="media event mb-3" style="cursor: pointer;" onclick=' window.location=("{{ route('interviews.show',['interview'=>$pendingInterview]) }}") '>
                            <a class="pull-left date bg-info">
                                <p class="month">{{ $hour->MonthAlphabetic() }}</p>
                                <p class="day">{{ $hour->DayNumeric() }}</p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#">Candidato</a>: {{ $candidato->fullName() }}
                                <br><a class="title" href="#">Fecha y Hora</a>: {{ $hour->date().' '.$hour->time() }}
                                @if($pendingInterview->status == 'scheduled' && $today)
                                    <span class="badge badge-success">Hoy</span>
                                @endif
                                <br><a class="title" href="#">Encargado</a>: {{ $responsable->fullName() }}
                                @if($authenticatedUser->id == $responsable->id)
                                    <span class="badge badge-success badge-pill">Yo</span>
                                @endif
                                <br><a class="title" href="#">Carrera</a>: {{ $career->name }}
                                <br><a class="title" href="#">Programa</a>: {{ $program->name }}
                                <br><a class="title" href="#">Universidad</a>: {{ $program->university->name }}
                            </div>
                        </article>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
    var app = new Vue({
        el: '#app'
    })
</script>
@endpush