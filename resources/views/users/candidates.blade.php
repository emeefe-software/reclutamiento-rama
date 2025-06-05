@extends('layouts.admin.admin', [
    'title' => 'Aspirantes'
])

@section('description')
<h1>Aspirantes a practicantes de Grupo RAMA</h1>
<p>
    Aspirantes que han agendado una entrevista en RAMA, por default se muestran aspirantes con entrevistas realizadas y aún no han sido descartadas y entrevistas pendientes.
</p>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <form method="GET" action="{{ route('candidates') }}">
            @if($marcado == '1')
                <input type="checkbox" name="noRealizada" checked>Entrevista no realizada
                <input type="checkbox" name="rechazados">Rechazados
            @elseif($marcado == '2')
                <input type="checkbox" name="noRealizada">Entrevista no realizada
                <input type="checkbox" name="rechazados" checked>Rechazados
            @elseif($marcado== '3')
                <input type="checkbox" name="noRealizada" checked>Entrevista no realizada
                <input type="checkbox" name="rechazados" checked>Rechazados
            @else
                <input type="checkbox" name="noRealizada">Entrevista no realizada
                <input type="checkbox" name="rechazados">Rechazados
            @endif
            <button type="submit" class="btn btn-info"><i class="fas fa-filter"></i> Filtrar</button>                       
        </form>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Email</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Estatus de la entrevista</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach($candidates as $candidate)
                <tr>
                    <td>{{$candidate->fullname()}}</td>
                    <td>{{$candidate->email}}</td>
                    <td>{{$candidate->phone}}</td>
                    <td>{{$candidate->interview->getStatus()}}</td>
                    <td>
                    <a href="{{route('interviews.show',['interview'=>$candidate->interview])}}"class="btn btn-info btn-sm"><i class="fas fa-clipboard-check"></i> Seguimiento a entrevista</a>
                    </td>
                </tr> 
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

