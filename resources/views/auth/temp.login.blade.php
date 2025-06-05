@extends('layouts.frontend.frontend')

@section('content')
<br><br><br>
<section class="contact-section mt-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center contact-title">Iniciar Sesión</h3>
                <br>
            </div>
            <div class="col-md-6 offset-md-3">
                <form class="form-contact contact_form" method="POST" action="{{ route('login') }}" id="contactForm">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <input placeholder="Correo electrónico" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                {{--
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror--}}
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <input placeholder="Contraseña" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                {{--@error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror--}}
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
    
                                    <label class="form-check-label" for="remember">
                                        Recordar sesión
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mt-3">
                        <button type="submit" class="button button-contactForm btn_1">Login</button>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
