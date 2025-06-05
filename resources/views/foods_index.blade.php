@extends('layouts.app_table',['empty'=>$foods->isEmpty()])

@section('emptyMessage','No hay comidas registradas')

@section('title','Comidas')

@section('header')
    <th scope="col">Fecha</th>
    <th scope="col">Cantidad de platillos</th>
    <th scope="col">Personas</th>
@endsection

@section('body')
    @foreach($foods as $food)
    @php
        $registers = App\FoodRegister::date($food->date)->get();
        $persons = [];
        foreach ($registers as $register) {
            $persons[]='<food-payment 
                :id="'.$register->id.'"
                :can-check-payment="'.($user->can('manage_food_payments')?'true':'false').'"
                :is-payed="'.($register->payed_at?'true':'false').'">
                </food-payment> '.$register->user->fullname();
        }
    @endphp
        <tr>
            <td>{{$food->date->format('d/m/Y')}}</td>
            <td>{{$food->total}}</td>
            <td>{!!implode(', ', $persons)!!}</td>
        </tr> 
    @endforeach
@endsection
