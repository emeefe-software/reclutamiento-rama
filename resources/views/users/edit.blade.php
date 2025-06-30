@extends('layouts.admin.admin')

@section('description')
<h1>Edicion</h1>
<p>
    Edición de un usuario de RAMA
    <br><br><b-badge variant="success">Activar</b-badge>: Usuario de RAMA que se encuentra laborando o en programa de prácticas profesionales.
    <br><b-badge variant="danger">Bloquear</b-badge>: El usuario se encuentra bloqueado por RAMA ya sea porque era un trabajador de RAMA y ya no labora o por cualquier motivo en el que se necesita bloquear el acceso al usuario.
    <br><b-badge variant="secondary">Deshabilitar</b-badge>: La cuenta del usuario se encuentra desabilitada debido a que el usuario ya no se encuentra en RAMA, se diferencia de Locked en que un usuario desabilitado pudo ser un practicante y haber terminado su periodo, además las marcas o indicadores en el sistema son menos fuertes con este caso que con Locked.
</p>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row justify-content-center">
            Cambiar el estado del Usuario
        </div>
        <div class="row justify-content-center">
            @if($userToEdit->status != 'active')
            <form method="POST" action="{{ route('users.activate', ['user' => $userToEdit]) }}">
                @method('PUT')
                @csrf
                <button class="btn btn-success" type="submit">Activar</button>
            </form>
            @endif
            @if($userToEdit->status != 'locked')
            <form method="POST" action="{{ route('users.lock', ['user' => $userToEdit]) }}">
                @method('PUT')
                @csrf
                <button class="btn btn-danger" type="submit">Bloquear</button>
            </form>
            @endif
            @if($userToEdit->status != 'disabled')
            <form method="POST" action="{{ route('users.disable', ['user' => $userToEdit]) }}">
                @method('PUT')
                @csrf
                <button class="btn btn-secondary" type="submit">Deshabilitar</button>
            </form>
            @endif
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{ route('users.update',['user'=>$userToEdit]) }}">
                    {{ method_field('PUT')}}
                    @csrf

                    <div class="form-group row">
                        <label for="first_name" class="col-md-4 col-form-label text-md-right">Nombre *</label>

                        <div class="col-md-6">
                            <input id="first_name"
                                type="text"
                                name="first_name"
                                class="form-control @error('first_name') is-invalid @enderror"
                                value="{{ old('first_name', $userToEdit->first_name) }}"
                                required
                                autocomplete="given-name"
                                autofocus>

                            @error('first_name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="last_name" class="col-md-4 col-form-label text-md-right">Apellidos *</label>

                        <div class="col-md-6">
                            <input id="last_name"
                                type="text"
                                class="form-control @error('last_name') is-invalid @enderror"
                                name="last_name"
                                value="{{ old('last_name', $userToEdit->last_name) }}"
                                required
                                autocomplete="family-name">

                            @error('last_name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">Email *</label>

                        <div class="col-md-6">
                            <input id="email"
                                type="email"
                                name="email"
                                value="{{ old('email', $userToEdit->email) }}"
                                class="form-control @error('email') is-invalid @enderror"
                                required
                                autocomplete="email">

                            <small id="email-help" class="form-text text-muted">Debe ser único en el sistema.</small>

                            @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="area" class="col-md-4 col-form-label text-md-right">Área *</label>

                        <div class="col-md-6">
                            <input id="area"
                                type="text"
                                name="area"
                                class="form-control @error('area') is-invalid @enderror"
                                value="{{ old('area', $userToEdit->area) }}"
                                required
                                autocomplete="organization">

                            @error('area')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="pin" class="col-md-4 col-form-label text-md-right">PIN(4 dígitos)</label>

                        <div class="col-md-6">
                            <input id="pin" type="number" min="1000" max="9999" class="form-control @error('pin') is-invalid @enderror" name="pin" value="{{$userToEdit->pin}}" autocomplete="new-pin">
                            <small id="pin-help" class="form-text text-muted">El PIN es obligatorio cuando se quieren contabilizar las horas por medio de la app</small>
                            @error('pin')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="rol" class="col-md-4 col-form-label text-md-right">Roles *</label>

                        <div class="col-md-6">
                            <select multiple class="form-control" name="rol[]">
                                @foreach($roles as $rol)
                                    @if (($rol->id !== 4))
                                     <option value="<?php echo $rol->id ?>" {{in_array($rol->id, $userToEdit->roles()->pluck('id')->toArray()) ? 'selected="selected"': null}}> <?php echo $rol->display_name ?></option>
                                    @endif
                                @endforeach
                            </select>
                            <small id="rol-help" class="form-text text-muted">Puedes asignar uno o más roles.</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="phone" class="col-md-4 col-form-label text-md-right">Teléfono</label>

                        <div class="col-md-6">
                            <input id="phone"
                                type="text"
                                name="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $userToEdit->phone) }}"
                                autocomplete="tel"
                                pattern="\d{10}"
                                maxlength="10"
                                placeholder="Ej. 5512345678">

                            @error('phone')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="contact_name" class="col-md-4 col-form-label text-md-right">Nombre de contacto de emergencia</label>

                        <div class="col-md-6">
                            <input id="contact_name"
                                type="text"
                                name="contact_name"
                                class="form-control @error('contact_name') is-invalid @enderror"
                                value="{{ old('contact_name', $userToEdit->contact_name) }}"
                                autocomplete="name">

                            @error('contact_name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="contact_phone" class="col-md-4 col-form-label text-md-right">Teléfono de contacto de emergencia</label>

                        <div class="col-md-6">
                            <input id="contact_phone"
                                type="text"
                                name="contact_phone"
                                class="form-control @error('contact_phone') is-invalid @enderror"
                                value="{{ old('contact_phone', $userToEdit->contact_phone) }}"
                                autocomplete="tel"
                                pattern="\d{10}"
                                maxlength="10"
                                placeholder="Ej. 5512345678">

                            @error('contact_phone')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="address" class="col-md-4 col-form-label text-md-right">Dirección *</label>

                        <div class="col-md-6">
                            <input id="address"
                                required
                                type="text"
                                name="address"
                                class="form-control @error('address') is-invalid @enderror"
                                value="{{ old('address', $userToEdit->address) }}"
                                autocomplete="street-address"
                                placeholder="Calle, número, colonia, ciudad">
                            @error('address')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                    </div>

                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Actualizar
                            </button>
                            <a href="{{route('users.index')}}" class="btn btn-link">Regresar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    window.addEventListener('load', function() {
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: @json(session('success')),
            confirmButtonColor: '#3085d6',
        });
        @endif

        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: @json(session('error')),
            confirmButtonColor: '#d33',
        });
        @endif
    });
</script>
@endpush