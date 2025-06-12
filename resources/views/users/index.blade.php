@php
$statusBloqueados = '';
$statusDesabilitados = '';
$statusActivos = '';
if(app('request')->input('bloqueados') == 'on'){
$statusBloqueados = 'checked';
}
if(app('request')->input('desabilitados') == 'on'){
$statusDesabilitados = 'checked';
}
if(app('request')->input('activos') == 'on'){
$statusActivos = 'checked';
}
@endphp

@extends('layouts.admin.admin')

@section('description')
<h1>Usuarios</h1>
<p>
    Listado de usuarios activos registrados en el sistema, se muestran datos relevantes y acciones disponibles.
    <br><br><b-badge variant="success">ACTIVO</b-badge>: Usuario de RAMA que se encuentra laborando o en programa de prácticas profesionales.
    <br><b-badge variant="danger">BLOQUEADO</b-badge>: El usuario se encuentra bloqueado por RAMA ya sea porque era un trabajador de RAMA y ya no labora o por cualquier motivo en el que se necesita bloquear el acceso al usuario.
    <br><b-badge variant="secondary">DESHABILITADO</b-badge>: La cuenta del usuario se encuentra desabilitada debido a que el usuario ya no se encuentra en RAMA, se diferencia de Locked en que un usuario desabilitado pudo ser un practicante y haber terminado su periodo, además las marcas o indicadores en el sistema son menos fuertes con este caso que con Locked.
</p>
<a href="{{route('users.create')}}">
    <b-button variant="info">Agregar Usuario</b-button>
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <form method="GET" action="{{ route('users.index') }}">
            <div class="form-row align-items-center">
                <div class="form-group mb-0 mr-3 d-flex align-items-center">
                    <div class="col-auto">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="activos" {{ $statusActivos }} name="activos">
                            <label class="form-check-label" for="activos">Activos</label>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="bloqueados" {{ $statusBloqueados }} name="bloqueados">
                            <label class="form-check-label" for="bloqueados">Bloqueados</label>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="desabilitados" {{ $statusDesabilitados }} name="desabilitados">
                            <label class="form-check-label" for="desabilitados">Desabilitados</label>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-0 mr-3 flex-grow-1">
                    <input type="text" class="form-control" id="search" placeholder="Buscar por nombre">
                </div>
                <div class="col-auto ml-auto">
                    <button type="submit" class="btn btn-info"><i class="fas fa-filter"></i> Filtrar</button>
                </div>
            </div>
        </form>
    </div>

    <div class="card-body">
        <table class="table table-striped jambo_table bulk_action table-sm" id="usersTable">
            <thead class="">
                <tr class="headings">
                    <th scope="col">Nombre</th>
                    <th scope="col">Email</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Área</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Contacto</th>
                    <th scope="col">Dirección</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $listedUser)
                <tr>
                    <td class="column-title">
                        {{$listedUser->fullname()}}
                        <br>
                        @if($listedUser->hasRole('admin'))
                        <span class="badge badge-success">Administrador</span>
                        @else
                        @foreach($listedUser->roles()->pluck('display_name')->toArray() as $rolName)
                        <span class="badge badge-info">{{$rolName}}</span>
                        @endforeach
                        @endif
                    </td>
                    <td class="column-title">{{$listedUser->email}}</td>
                    <td class="column-title">
                        @if ($listedUser->status == 'active')
                        <b-badge variant="success">ACTIVO</b-badge>
                        @elseif ($listedUser->status == 'locked')
                        <b-badge variant="danger">BLOQUEADO</b-badge>
                        @else
                        <b-badge variant="secondary">DESHABILITADO</b-badge>
                        @endif
                    </td>
                    <td class="column-title">
                        @isset($listedUser->area)
                        {{$listedUser->area}}
                        @else
                        N/D
                        @endisset
                    </td>
                    <td class="column-title">
                        @isset($listedUser->phone)
                        {{$listedUser->phone}}
                        @else
                        N/D
                        @endisset
                    </td>
                    <td class="column-title">
                        @if(!isset($listedUser->contact_name) && !isset($listedUser->contact_phone))
                        N/D
                        @else
                        {{$listedUser->contact_name}}
                        <br>
                        {{$listedUser->contact_phone}}
                        @endif
                    </td>
                    <td class="column-title">
                        @isset($listedUser->address)
                        {{$listedUser->address}}
                        @else
                        N/D
                        @endisset
                    </td>
                    <td class="column-title no-link last">
                        @if(Auth::user()->hasRole(App\Role::ROLE_ADMIN))
                        @if($listedUser->hasRole(App\Role::ROLE_PRACTICING))
                        <a href="{{route('users.registers.index', ['user'=>$listedUser])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Horarios registrados">
                            <i class="fas fa-clock"></i>
                        </a>
                        @endif
                        <a href="{{route('users.edit', ['user'=>$listedUser])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar usuario">
                            <i class="fa fa-edit"></i>
                        </a>
                        @if(!$listedUser->hasRole(App\Role::ROLE_ADMIN))
                        <form class="d-inline" id="formUserDelete{{ $listedUser->id }}" action="{{route('users.destroy',$listedUser)}}" method="POST">
                            {{ method_field('DELETE')}}
                            {{ csrf_field()}}
                            <button type="submit" onclick="eliminaUsuario(event, {{ $listedUser->id }})" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar usuario">
                                <i class="fa fa-remove"></i>
                            </button>
                        </form>
                        @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const app = new Vue({
        el: '#app'
    })
</script>
//Filtrado de usuarios por nombre
<script src="{{ asset('js/frontend/pages/searchUser.js') }}"></script>
<!-- mensaje de confirmacion para eliminar un Usuario -->
<script src="{{ asset('js/backend/pages/confirm_delete_user.js') }}"></script>

@endpush