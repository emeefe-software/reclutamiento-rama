@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Comida {{$is_now?'de hoy':($is_monday?'del lunes':'de mañana')}}</div>
                <div class="card-body">
                <ask-for-food day="{{$is_now?'hoy':($is_monday?'el lunes':'mañana')}}" :confirmed="{{$is_confirmed?'true':'false'}}"></ask-for-food>
                </div>
            </div>

            <div class="card mt-5">
                <div class="card-header">Adeudos</div>
                    <div class="card-body">
                        @if(!count($debts))
                            <p>No hay adeudos</p>
                        @else
                            <p>Tienes los siguientes adeudos:</p>
                        @endif

                        <table class="table table-striped">
                            @foreach($debts as $debt)
                                <tr>
                                    <td>
                                        {{$debt->date}}
                                    </td>
                                    <td>$30.00</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
