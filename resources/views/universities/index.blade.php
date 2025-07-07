<?php $user = Auth::user(); ?>
@extends('layouts.admin.admin', [
'title' => 'Universidades'
])

@section('description')
<h1>Universidades</h1>
<p>Universidades que tienen convenio con GRUPO RAMA, después podrás asociar programas con la universidad para permitir a los aspirantes aplicar a nuestras vacantes.</p>
<div class="">
    <a href="{{route('universities.create')}}">
    <button type="button" class="btn btn-info">Agregar Universidad</button>
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
        @yield('extraButtons')
        @if($universities->isEmpty())
        <h1 style="text-align: center">No hay universidades registradas</h1>
        @else
        <table class="table table-striped jambo_table bulk_action table-sm" id="items-table">
            <thead class="">
                <tr class="headings">
                    <!--<th>
                        <input type="checkbox" id="check-all" class="flat">
                    </th>-->
                    <th scope="col">Nombre</th>
                    <th scope="col">Abreviatura</th>
                    <th scope="col">Descripción</th>
                    @if($user->hasRole('admin'))
                    <th scope="col" style="width:150px">Acciones</th>
                    @endif
                    <!-- <th class="bulk-actions" colspan="7">
                        <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                    </th> -->
                </tr>
            </thead>
            <tbody>
                @foreach($universities as $university)
                <tr>
                    <td> {{$university->name}}</td>
                    <td>
                        @empty($university->shortName)
                        N/D
                        @else
                        {{$university->shortName}}
                        @endif
                    </td>
                    <td>{{$university->description}}</td>
                    @if($user->hasRole('admin'))
                    <td>
                        <a href="{{route('universities.edit', ['university'=>$university])}}" class="btn btn-primary btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form class="d-inline" action="{{route('universities.destroy',$university)}}" method="POST">
                            {{ method_field('DELETE')}}
                            {{ csrf_field()}}
                            <button type="submit" class="btn btn-danger btn-sm">
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
<script>
    new Vue({
        el: '#app'
    })
</script>
<script src="{{asset('js/frontend/pages/searchName.js')}}"></script>
@endpush