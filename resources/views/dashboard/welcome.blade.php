@extends('layouts.admin.admin', [
'title' => 'Dashboard'
])

@section('description')
Bienvenido <b>{{$authenticatedUser->first_name}}</b>
<br><br>
Esta sección muestra un resumen rápido del sistema.
@endsection

@section('content')
<div>
    <h1>Bienvenido</h1>
</div>
@endsection

@push('scripts')
<script>
    var app = new Vue({
        el: '#app'
    })
</script>
@endpush