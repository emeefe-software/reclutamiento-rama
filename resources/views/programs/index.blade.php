<?php $isAdmin = Auth::user()->hasRole('admin') ?>
@extends('layouts.admin.admin', [
'title' => 'Programas'
])

@section('description')
<h1>Programas</h1>
<p>
    Listado de programas registrados en distintas universidades. Los pasos a seguir son los siguientes:
    <br>
<ul>
    <li>Crear universidad a la que se relacionará el programa</li>
    <li>Crear carrera a la que se asociará el programa</li>
    <li>Agregar programa: Permite asociar un programa a una universidad, para universidades distintas a la BUAP y que no cuentan con muchos programas se recomienda crear un programa llamado <b>Convenio Nombre_Universidad</b></li>
    <li>Asociar el programa con una o más carreras: Esto permite indicar la carrera a la que se ligará el programa y quién será el encargado de entrevistas a la hora de agendar.</li>
</ul>

Adicionálmente puedes pausar/reanudar un programa en el listado cambiando el valor del checkbox y presionando el botón <b>Actualizar</b>, los programas pausados no aparecerán como opciones disponibles a los aspirantes al querer agendar entrevista.

<br><br>Si deseas eliminar/editar una asociación de un programa con un responsable puedes encontrar las acciones en la columna <b>Asociaciones</b>
</p>
<div class=>
    <a href="{{route('programs.create')}}">
        <button type="button" class="btn btn-info">Agregar Programa</button>
    </a>
    <a href="{{route('programs.asociate')}}">
        <button type="button" class="btn btn-secondary">Asociar programa</button>
    </a>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="form-group mb-0 mr-3 flex-grow-1">
            <input type="text" class="form-control" id="search" placeholder="Buscar por nombre o universidad o folio">
        </div>
    </div>
    <div class="card-body">
        @if($programs->isEmpty())
        <h1 style="text-align: center">No hay programas registrados</h1>
        @else
        <table class="table table-striped jambo_table bulk_action table-sm" id="programsTable">
            <thead class="">
                <tr class="headings">
                    <!--<th>
                            <input type="checkbox" id="check-all" class="flat">
                        </th>-->
                    <th>Folio</th>
                    <th>Nombre</th>
                    <th>Universidad</th>
                    <th>Descripción</th>
                    <th>Pausar programa</th>
                    <th>Asociaciones</th>
                    @if($isAdmin)
                    <th>Acciones</th>
                    @endif
                    <!-- <th class="bulk-actions" colspan="7">
                            <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                        </th> -->
                </tr>
            </thead>
            <tbody>
                @foreach($programs as $program)
                <tr>
                    <td>{{$program->folio}}</td>
                    <td>{{$program->name}}</td>
                    <td>{{$program->university->name}}</td>
                    <td>{{$program->description}}</td>
                    <td>
                        <form method="POST" action="{{ route('programs.ispaused', ['program'=>$program]) }}">
                            @method('PUT')
                            @csrf
                            @if($program->is_paused=='1')
                            <input type="checkbox" name="pausar" checked> Pausar programa
                            @else
                            <input type="checkbox" name="pausar"> Pausar programa
                            @endif
                            <input type="hidden" name="id" value="{{ $program-> id }}">
                            <button type="submit" class="btn btn-info btn-sm" style="font-size:11px"><i class="fas fa-check-circle"></i> Actualizar</button>
                        </form>
                    </td>
                    <td>
                        <button class="btn btn-info btn-sm btn-toggle-asociaciones">Ver Asociaciones</button>
                        <ul class="lista-carreras flex-column align-items-center" style="display: none" ;>
                            @if($program->careers->count())
                            @foreach ($program->careers as $career)
                            <li class="w-100" style="max-width: 400px;">
                                <?php $responsable = App\User::find($career->pivot->responsable_id); ?>
                                {{$career->name}} - {{$responsable->fullname()}} ({{$career->pivot->places}} lugares)
                                @if($isAdmin)
                                <div class="row" style="justify-content: space-around;">
                                    <div class="col">
                                        {{--
                                                    TODO: NO DEBERIA MANDARSE COMO FORMULARIO SINO PASAR LOS PARAMETROS POR GET
                                                --}}
                                        <form class="d-inline" action="{{route('programs.asociateEdit',$program)}}" method="POST">
                                            {{ csrf_field()}}
                                            <input type="hidden" name="program_id" id="program_id" value="{{$program->id}}">
                                            <input type="hidden" name="career_id" id="career_id" value="{{$career->id}}">
                                            <input type="hidden" name="responsable_id" id="responsable_id" value="{{$responsable->id}}">
                                            <button class="btn btn-link btn-sm">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col">
                                        <form onSubmit="return deleteAsociate()" class="d-inline" action="{{route('programs.asociate.destroy')}}" method="POST">
                                            {{ csrf_field()}}
                                            <input type="hidden" name="career_id" id="career_id" value="{{$career->id}}">
                                            <input type="hidden" name="program_id" id="program_id" value="{{$program->id}}">
                                            <button type="submit" class="btn btn-link btn-sm">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </li>
                            @endforeach
                            @else
                            <span class="badge badge-warning">Debes asociar el programa</span>
                            @endif
                        </ul>
                    </td>
                    @if($isAdmin)
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{route('programs.edit', ['program'=>$program])}}" style="font-size:15px">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form onSubmit="return deleteProgram()" class="d-inline" action="{{route('programs.destroy',$program)}}" method="POST">
                            {{ method_field('DELETE')}}
                            {{ csrf_field()}}
                            <button type="submit" class="btn btn-danger btn-sm" style="font-size:20px">
                                <i class="fa fa-remove"></i>
                            </button>
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/frontend/pages/programs.js') }}"></script>
<script src="{{asset('js/backend/pages/program.js')}}"></script>
@endpush