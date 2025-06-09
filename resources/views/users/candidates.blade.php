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
        <form method="GET" action="{{ route('candidates') }}" class="d-flex align-items-center">
            {{-- Select de estado --}}
            <div class="form-group mb-0 mr-3" style="min-width: 200px;">
                <select name="status" class="form-control">
                    <option value="">-- Agendados --</option>
                    <option value="unrealized" {{ request('status') == 'unrealized' ? 'selected' : '' }}>No realizada</option>
                    <option value="done-rejected" {{ request('status') == 'done-rejected' ? 'selected' : '' }}>Rechazado</option>
                    <option value="done-checking" {{ request('status') == 'done-evaluating' ? 'selected' : '' }}>Evaluando</option>
                    <option value="done-accepted" {{ request('status') == 'done-accepted' ? 'selected' : '' }}>Aceptado</option>
                    <option value="done-enrolled" {{ request('status') == 'done-enrolled' ? 'selected' : '' }}>Inscrito</option>
                </select>
            </div>

            {{-- Input de búsqueda --}}
            <div class="form-group mb-0 mr-3 flex-grow-1">
                <input type="text" class="form-control" id="search" placeholder="Buscar por nombre">
            </div>

            {{-- Botón filtrar --}}
            <div class="form-group mb-0">
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-filter"></i> Filtrar
                </button>
            </div>
        </form>
    </div>
    <div class="card-body">
        <table class="table table-sm" id="usersTable">
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
                        <a href="{{route('interviews.show',['interview'=>$candidate->interview])}}" class="btn btn-info btn-sm"><i class="fas fa-clipboard-check"></i> Seguimiento a entrevista</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
//Filtrado de usuarios por nombre
<script src="{{ asset('js/frontend/pages/searchUser.js') }}"></script>
@endpush