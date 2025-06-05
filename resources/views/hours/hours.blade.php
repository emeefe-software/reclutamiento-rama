@extends('layouts.admin.admin', [
    'title' => 'Horas trabajadas'
])
@section('description')
<h1>Horarios</h1>
    <p>
        Horas contabilizadas.
    </p>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Horas trabajadas</div>

                <div class="card-body">
                    Tus horas acumuladas al día de hoy son: PROXIMAMENTE
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
