<?php $userLogIn = Auth::user();
$isAdmin = $userLogIn->hasRole('admin'); ?>
@extends('layouts.admin.admin', [
'title' => 'Horarios'
])

@section('description')
<h1>Horarios</h1>
<p>
    Horarios disponibles para entrevista por encargados/responsables.
    <br><br>Los aspirantes podrán agendar dentro de los horarios disponibles seleccionando en la vista pública el más adecuado. Tomar en cuenta que los aspirantes tendrán un listado de horarios disponibles según los horarios configurados por el encargado del programa dentro de una carrera específica.
    <br>Puedes eliminar y agregar nuevos horarios en la herramienta <b>Nuevo Horario</b>.

    <br><br><b>El tipo de horario</b> define si 1 o más encargados pueden tener entrevistas a la vez en el mismo horario ya que en modalidad remota podría haber varias pero en sitio puede solo haber una entrevista por horario
    <br>
<ul>
    <li><b>Único</b>: Si un aspirante agenda en un horario de este tipo entonces ningún aspirante más podrá elegir este mismo horario</li>
    <li><b>Simultáneo</b>: Si un aspirante agenda en un horario de este tipo puede haber otra entrevista con otro encargado a la misma hora</li>
</ul>
</p>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <a href="{{ route('hours.create') }}" class="btn btn-info">
            Nuevo Horario
        </a>

        <div class="form-group mb-0">
            <select class="form-control" name="encargado" id="encargado">
                <option value="">Seleccione</option>
                @foreach ($responsables as $responsable )
                <option value="{{ $responsable }}">{{ $responsable }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="card-body">
        @yield('extraButtons')
        @if($hours->isEmpty())
        <h1 style="text-align: center">No hay horarios registrados</h1>
        @else
        <table class="table table-striped table-sm jambo_table bulk_action">
            <thead class="">
                <tr class="headings">
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Encargados</th>
                    <th>Tipo de horario</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hours as $hour)
                <tr id="horario">
                    <td>
                        {{$hour->date()}}
                    </td>
                    <td>{{$hour->time()}} hrs - {{$hour->endTime()}} hrs</td>
                    <td>
                        @foreach($hour->users as $user)
                        {{$user->fullname()}}
                        <span class="d-none nombre">{{$user->fullname()}}</span>
                        @if($user->pivot->interview_id)
                        <b-badge pill variant="success" href="{{route('interviews.show',['interview'=>$user->pivot->interview_id])}}">
                            Con {{$user->pivot->interview->candidate->fullname()}}
                        </b-badge>
                        @else
                        @if($user->id==$userLogIn->id || $isAdmin)
                        <form class="d-inline" action="{{route('hours.destroy',$hour)}}" method="POST">
                            {{ method_field('DELETE')}}
                            {{ csrf_field()}}
                            <input type="hidden" name="user" value="{{$user->id}}">
                            <button type="submit" class="btn btn-link btn-sm p-0 m-0">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                        @endif
                        @endif
                        @endforeach
                    </td>
                    <td>
                        @if($hour->type=='unique')
                        Único
                        @else
                        Simultáneo
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    const app = new Vue({
        el: '#app'
    })
</script>
<script>
    const encargado = document.querySelector('#encargado');
    const raws = document.querySelectorAll('#horario');

    function filtrar() {
        const encargadoSeleccionado = encargado.value.trim().toLowerCase();

        raws.forEach((row) => {
            const celda = row.getElementsByTagName('td')[2];
            const nombres = celda.querySelectorAll('.nombre');

            let coincide = false;

            nombres.forEach((span) => {
                const nombre = span.textContent.trim().toLowerCase();
                if (nombre === encargadoSeleccionado || encargadoSeleccionado === '') {
                    coincide = true;
                }
            });

            row.style.display = coincide ? '' : 'none';
        });
    }
    encargado.addEventListener('change', filtrar);
</script>
@endpush