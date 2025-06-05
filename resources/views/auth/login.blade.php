<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{asset('favicon100x100.jpg')}}" sizes="32x32">
        <link rel="icon" href="{{asset('favicon300x300.jpg')}}" sizes="192x192">

        <title>Login</title>

        <!-- Bootstrap -->
        <link href="{{ asset('css/frontend/plugins/bootstrap.min.css') }}" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="{{ asset('css/frontend/plugins/font-awesome.min.css') }}" rel="stylesheet">
        <!-- NProgress -->
        <link href="{{ asset('css/frontend/plugins/nprogress.css') }}" rel="stylesheet">
        <!-- Animate.css -->
        <link href="{{ asset('css/frontend/plugins/animate.min.css') }}" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="{{ asset('css/frontend/plugins/custom.min.css') }}" rel="stylesheet">
    </head>

    <body class="login">
        <div>
            <a class="hiddenanchor" id="signup"></a>
            <a class="hiddenanchor" id="signin"></a>

            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <div class="row">
                            <div class="col-sm-8 offset-sm-2">
                                <img class="img-fluid" src="{{ asset('images/rama_gris.png') }}"/>
                            </div>
                        </div>
                        <br/>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <h1>Iniciar sesión</h1>
                            <div>
                                <input type="text" class="form-control" placeholder="Email" required="" name="email" />
                            </div>
                            <div>
                                <input type="password" class="form-control" placeholder="Password" required="" name="password" />
                            </div>

                            @error('email')
                                <div class="alert alert-danger alert-dismissible " role="alert">
                                    {{$message}}
                                </div>
                            @enderror

                            
                            <div>
                                <button type="submit" class="btn btn-primary submit">Login</button>
                                @if (Route::has('password.request'))
                                    <a class="reset_pass" href="{{ route('password.request') }}">
                                        {{ __('Olvidaste tu contraseña?') }}
                                    </a>
                                @endif
                            </div>

                            <div class="clearfix"></div>

                            <div class="separator">
                                <div class="clearfix"></div>
                                <br />

                                <div>
                                <h1>Grupo RAMA</h1>
                                <p>©{{now()->year}} Todos los derechos reservados</p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </body>
</html>
