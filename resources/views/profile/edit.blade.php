@extends('layouts.admin.admin', ['title' => 'Mi Perfil'])

@section('description')
<h1>Edición</h1>
<p>
    En esta sección, puede editar su perfil. Asegúrese de que la información sea precisa y esté actualizada.
</p>
@endsection
@section('content')
<div class="card">
    <div class="card-header">Editar Perfil</div>
    <div class="card-body">
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div class="form-group">
                <label for="first_name">Nombre</label>
                <input id="first_name"
                    type="text"
                    name="first_name"
                    class="form-control @error('first_name') is-invalid @enderror"
                    value="{{ old('first_name', $userToEdit->first_name) }}"
                    required
                    autocomplete="given-name">
                @error('first_name')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- Apellidos -->
            <div class="form-group">
                <label for="last_name">Apellidos</label>
                <input id="last_name"
                    type="text"
                    name="last_name"
                    class="form-control @error('last_name') is-invalid @enderror"
                    value="{{ old('last_name', $userToEdit->last_name) }}"
                    required
                    autocomplete="family-name">
                @error('last_name')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
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

            <!-- Pin -->
            <div class="form-group">
                <label for="pin">PIN(4 dígitos) </label>
                <input id="pin"
                    type="number"
                    name="pin"
                    class="form-control @error('pin') is-invalid @enderror"
                    value="{{ old('pin', $userToEdit->pin) }}"
                    min="1000" max="9999"
                    autocomplete="off"
                    placeholder="Ej. 1234">
                @error('pin')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- Telefono -->
            <div class="form-group">
                <label for="phone">Telefono </label>
                <input id="phone"
                    type="tel"
                    name="phone"
                    class="form-control @error('phone') is-invalid @enderror"
                    value="{{ old('phone', $userToEdit->phone) }}"
                    required
                    pattern="\d{10}"
                    maxlength="10"
                    autocomplete="tel"
                    placeholder="Ej. 5512345678">
                @error('phone')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- Direccion -->
            <div class="form-group">
                <label for="address">Dirección </label>
                <input id="address"
                    type="text"
                    name="address"
                    class="form-control @error('address') is-invalid @enderror"
                    value="{{ old('address', $userToEdit->address) }}"
                    required
                    autocomplete="street-address"
                    placeholder="Calle, número, colonia, ciudad">
                @error('address')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- Nombre contacto de emergencia -->
            <div class="form-group">
                <label for="contact_name">Nombre de contacto de emergencia </label>
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

            <!-- Teléfono de contacto de emergencia -->
            <div class="form-group">
                <label for="contact_phone">Teléfono de contacto de emergencia </label>
                <input id="contact_phone"
                    type="tel"
                    name="contact_phone"
                    class="form-control @error('contact_phone') is-invalid @enderror"
                    value="{{ old('contact_phone', $userToEdit->contact_phone) }}"
                    pattern="\d{10}"
                    maxlength="10"
                    autocomplete="tel"
                    placeholder="Ej. 5512345678">
                @error('contact_phone')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.addEventListener('load', function () {
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
