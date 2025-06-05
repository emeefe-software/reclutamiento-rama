@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Comidas</div>

                <div class="card-body">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Fecha</th>
                                <th scope="col">Cantidad de platillos extra</th>
                                <th scope="col">Personas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($foods as $food)
                            @php
                                $registers = App\FoodRegister::date($food->date)->get();
                                $persons = [];
                                foreach ($registers as $register) {
                                    $persons[]=$register->user->fullname();
                                }

                                $now = now();
                                $is_now = $now->isSameAs('Y-m-d', $food->date);
                                $is_tomorrow = $now->copy()->addDay()->isSameAs('Y-m-d', $food->date); 
                            @endphp
                                <tr>
                                    <td>{{($is_now?'Hoy':($is_tomorrow?'Mañana':'')).' '.$food->date->format('d/m/Y')}}</td>
                                    <td>{{$food->total}}</td>
                                    <td>{!!implode(', ', $persons)!!}</td>
                                </tr> 
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
