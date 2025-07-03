@extends('layouts.admin.admin', ['title' => 'Registro de horas'])
@section('description')
@php
$totalMinutes = 0;
@endphp

@foreach ($registers as $register)
@php
if ($register->end_at) {
$totalMinutes += $register->end_at->diffInMinutes($register->start_at);
}
@endphp
@endforeach

@php
$totalHours = (int)($totalMinutes / 60);
$remainingMinutes = $totalMinutes % 60;
@endphp
<div class="text-center">
    <h3>Total de horas trabajadas: </h3>
    <p style="font-size: large;">
        {{ str_pad($totalHours, 2, '0', STR_PAD_LEFT) }}:{{ str_pad($remainingMinutes, 2, '0', STR_PAD_LEFT) }} hrs
    </p>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-striped table-sm jambo_table bulk_action">
            <thead class="">
                <tr class="headings">
                    <th scope="col">Entrada</th>
                    <th scope="col">Salida</th>
                    <th scope="col">Horas</th>
                </tr>
            </thead>
            <tbody>
                @php
                $count=0;
                @endphp
                @foreach($registers as $register)
                @php
                if($register->end_at){
                $minutes=$register->end_at->diffInMinutes($register->start_at);
                $count+=$minutes;
                $hours = (int)($minutes/60);
                $minutes = $minutes - $hours*60;
                }
                @endphp
                <tr>
                    <td class="column-title">{{$register->start_at}}</td>
                    <td class="column-title">{{$register->end_at}}</td>
                    <td class="column-title">{{$register->end_at?str_pad($hours,2,'0',STR_PAD_LEFT).":".str_pad($minutes,2,'0',STR_PAD_LEFT). " hrs":''}}</td>
                </tr>
                @endforeach
                @php
                $hours = (int)($count/60);
                $minutes = $count - $hours*60;
                @endphp
            </tbody>
        </table>
    </div>
</div>

@endsection