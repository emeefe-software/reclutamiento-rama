<?php 
    $user=Auth::user(); 
    $isAdmin=$user->hasRole(App\Role::ROLE_ADMIN); 
    $isResponsable=$user->hasRole(App\Role::ROLE_RESPONSABLE); 
?>
@extends('layouts.admin.admin', [
    'title' => 'Entrevistas'
])

@section('description')
    <h1>Entrevistas</h1>
    <p>
        Listado de entrevistas y sus estatus, puedes dar seguimiento accediendo a ellas y colocando notas. La mayoría son agendadas desde la vista pública disponible para los aspirantes pero también puedes registrarlas manuálmente.
    </p>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{route('interviews')}}">
            <button type="button" class="btn btn-info">Agendar Entrevista</button>
        </a>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm jambo_table bulk_action">
            <thead>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estatus de la entrevista</th>
                <th>Resumen</th>
                <th>Acciones</th>
            </thead>
            <tbody>
                @foreach ($interviews as $interview)
                    @php
                        $hour=$interview->hour()->first();
                        $today=$hour->date()===now()->toDateString() ? true : false; 
                        $program=$interview->program; 
                        $career=$program->careers()->find($interview->career_id); 
                        $responsable = App\User::find($career->pivot->responsable_id);
                    @endphp
                    @if($responsable->id==$user->id || $isAdmin)
                        <tr>
                            <td>
                                {{$hour->date()}}
                                @if($interview->status == 'scheduled' && $today)
                                    <br><span class="badge badge-success">Hoy</span>
                                @endif
                            </td>
                            <td>{{$hour->time()}}hrs - {{$hour->endTime()}}hrs</td>
                            <td>
                                @switch($interview->status)
                                    @case('scheduled')
                                        <span class="badge badge-info">Agendada</span>
                                        @break
                                    @case('unrealized')
                                        <span class="badge badge-secondary">No realizada</span>
                                        @break
                                    @case('done-checking')
                                        <span class="badge badge-primary">Realizada (evaluando)</span>
                                        @break
                                    @case('done-accepted')
                                        <span class="badge badge-success">Realizada (aceptado)</span>
                                        @break
                                    @case('done-rejected')
                                        <span class="badge badge-danger">Realizada (rechazado)</span>
                                        @break
                                    @case('done-enrolled')
                                        <span class="badge badge-success">Realizada (inscrito)</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                <b>Encargado:</b> {{$responsable->fullname()}}
                                <br><b>Carrera:</b> {{$career->name}}
                                <br><b>Programa:</b> {{$program->name}}
                                <br><b>Solicitante:</b> {{$interview->candidate->fullname()}} 
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{route('interviews.show',['interview'=>$interview])}}">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection