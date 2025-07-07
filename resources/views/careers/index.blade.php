<?php $isAdmin = $authenticatedUser->hasRole('admin'); ?>
@extends('layouts.admin.admin')

@section('emptyMessage','No hay carreras registradas')

@section('description')
<h1>Carreras</h1>
<p>
    Listado de carreras que pueden aplicar a nuestros programas de práctica profesional, los nombres deben ser genéricos para que los usuarios puedan seleccionar la carrera a fin a la suya.
    <br><br>Una vez tengas carreras puedes crear programas asociados.
</p>
<div>
    <a href="{{route('careers.create')}}">
        <button type="button" class="btn btn-info">Agregar Carrera</button>
    </a>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="form-group mb-0 mr-3 flex-grow-1">
            <input type="text" class="form-control" id="search" placeholder="Buscar por nombre">
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped jambo_table bulk_action table-sm" id="items-table">
            <thead>
                <tr class="headings">
                    <th scope="col">Nombre</th>
                    <th scope="col">Número de programas asociados</th>
                    <th scope="col">Solicita CV</th>
                    <th scope="col">Solicita Portafolio</th>
                    @if($isAdmin)
                    <th scope="col">Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($careers as $career)
                <tr>
                    <td class="column-title"> {{$career->name}}</td>
                    <td class="column-title">
                        <?php $total = $career->programs->count() ?>
                        @if ($total>0)
                        {{$total}}
                        @else
                        Ninguno
                        @endif
                    </td>
                    <td class="column-title">
                        @if($career->withCV=='1')
                        Si
                        @else
                        No
                        @endif
                    </td>
                    <td class="column-title">
                        @if($career->withPortfolio=='1')
                        Si
                        @else
                        No
                        @endif
                    </td>
                    @if($isAdmin)
                    <td class="column-title">
                        <a class="btn btn-primary btn-sm" href="{{route('careers.edit', ['career'=>$career])}}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form class="d-inline" id="formCareerDelete{{ $career->id }}" action="{{route('careers.destroy',$career)}}" method="POST" onsubmit="">
                            {{ method_field('DELETE')}}
                            {{ csrf_field()}}
                            <button type="submit" onclick="eliminaCarrera(event, {{ $career->id }})" class="btn btn-danger btn-sm">
                                <i class="fa fa-remove"></i>
                            </button>
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<!-- mensaje de confirmacion para eliminar una Carrera -->
<script src="{{ asset('js/backend/pages/confirm_delete_career.js') }}"></script>
<script src="{{asset('js/frontend/pages/searchName.js')}}"></script>
<script>
    window.addEventListener('load', function() {
        @if(session('alert'))
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: @json(session('alert')),
            confirmButtonColor: '#3085d6',
        });
        @endif
    });
</script>
@endpush