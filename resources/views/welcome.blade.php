@extends('layouts.frontend.frontend')

@section('content')
<!-- feature_part start-->
<br>
<section class="feature_part mt-5">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-xl-3 align-self-center">
                <div class="single_feature_text ">
                    <h2>Grupo RAMA</h2>
                    <p>Elige la acción que deseas realizar por medio de alguna de nuestras herramientas disponibles
                </div>
            </div>

            @foreach($actionsForUsers as $actionForUser)
                <div class="col-sm-6 col-xl-3">
                    <a {{$actionForUser['open_new_tab']?"target=\"_blank\"":""}} href="{{$actionForUser['url']}}">
                        <div class="single_feature">
                            <div class="single_feature_part">
                                <span class="single_feature_icon"><i class="{{$actionForUser['icon']}}"></i></span>
                                <h4>{{$actionForUser['title']}}</h4>
                                <p>{{$actionForUser['description']}}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection