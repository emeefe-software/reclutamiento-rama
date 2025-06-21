@extends('layouts.admin.admin')

@section('description')
<h1>Registro</h1>
<p>
    Esta sección te permite dar de alta nuevos usuarios Activos de distintos roles: Administrador, Practicante y Responsable. <br>
     Para registrar un aspirante, debes hacerlo en la sección de "Entrevistas" y "Registrar Entrevista". 
</p>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Datos Requeridos</h2>
    </div>

    <div class="card-body">
        <form @@submit.prevent="onSubmit" action="{{ route('users.store') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="first_name" class="col-md-4 text-md-right">Nombre *</label>
                <div class="col-md-6">
                    <input id="first_name" type="text" class="form-control" name="first_name" v-model='form.first_name' autofocus>
                    <b-badge v-if='errors && errors.first_name' variant='danger'>@{{ errors.first_name[0] }}</b-badge>
                </div>
            </div>

            <div class="form-group row">
                <label for="last_name" class="col-md-4 text-md-right">Apellidos *</label>
                <div class="col-md-6">
                    <input id="last_name" type="text" class="form-control" name="last_name" v-model='form.last_name'>
                    <b-badge v-if='errors && errors.last_name' variant='danger'>@{{ errors.last_name[0] }}</b-badge>
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-4 text-md-right">Email *</label>
                <div class="col-md-6">
                    <input id="email" class="form-control" name="email" v-model='form.email'>
                    <small id="email-help" class="form-text text-muted">Debe ser único en el sistema.</small>
                    <b-badge v-if='errors && errors.email' variant='danger'>@{{ errors.email[0] }}</b-badge>
                </div>
            </div>

            <div class="form-group row">
                <label for="area" class="col-md-4 text-md-right">Área *</label>
                <div class="col-md-6">
                    <input id="area" type="text" class="form-control" name="area" v-model='form.area'>
                    <b-badge v-if='errors && errors.area' variant='danger'>@{{ errors.area[0] }}</b-badge>
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 text-md-right">{{ __('Password') }} *</label>
                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" v-model='form.password'>
                    <b-badge v-if='errors && errors.password' variant='danger'>@{{ errors.password[0] }}</b-badge>
                </div>
            </div>

            <div class="form-group row">
                <label for="password-confirm" class="col-md-4 text-md-right">Repetir password *</label>
                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" v-model='form.password_confirmation'>
                    <b-badge v-if='errors && errors.password_confirmation' variant='danger'>@{{ errors.password_confirmation[0] }}</b-badge>
                </div>
            </div>

            <div class="form-group row">
                <label for="pin" class="col-md-4 text-md-right">PIN(4 dígitos)</label>
                <div class="col-md-6">
                    <input id="pin" type="number" class="form-control" name="pin" v-model='form.pin'>
                    <small id="pin-help" class="form-text text-muted">El PIN es obligatorio cuando se quieren contabilizar las horas por medio de la app</small>
                    <b-badge v-if='errors && errors.pin' variant='danger'>@{{ errors.pin[0] }}</b-badge>
                </div>
            </div>

            <div class="form-group row">
                <label for="rol" class="col-md-4 text-md-right">Roles *</label>
                <div class="col-md-6">
                    <select multiple name="rol[]" class="form-control" v-model='form.rol'>
                        @foreach($roles as $rol)
                            @if($rol->id != 4) <!-- Excluye el rol de aspirante -->
                            <option value="<?php echo $rol->id?>"> <?php echo $rol->display_name?></option>
                            @endif
                        @endforeach
                    </select>
                    <small id="rol-help" class="form-text text-muted">Puedes asignar uno o más roles.</small>
                    <b-badge v-if='errors && errors.rol' variant='danger'>@{{ errors.rol[0] }}</b-badge>
                </div>
            </div>

            <div class="form-group row">
                <label for="phone" class="col-md-4 text-md-right">Teléfono</label>
                <div class="col-md-6">
                    <input id="phone" type="text" class="form-control" name="phone" v-model='form.phone'>
                    <b-badge v-if='errors && errors.phone' variant='danger'>@{{ errors.phone[0] }}</b-badge>
                </div>
            </div>

            <div class="form-group row">
                <label for="contact_name" class="col-md-4 text-md-right">Nombre del contacto</label>
                <div class="col-md-6">
                    <input id="contact_name" type="text" class="form-control" name="contact_name" v-model='form.contact_name'>
                    <b-badge v-if='errors && errors.contact_name' variant='danger'>@{{ errors.contact_name[0] }}</b-badge>
                </div>
            </div>

            <div class="form-group row">
                <label for="contact_phone" class="col-md-4 text-md-right">Teléfono de contacto</label>
                <div class="col-md-6">
                    <input id="contact_phone" type="text" class="form-control" name="contact_phone" v-model='form.contact_phone'>
                    <b-badge v-if='errors && errors.contact_phone' variant='danger'>@{{ errors.contact_phone[0] }}</b-badge>
                </div>
            </div>

            <div class="form-group row">
                <label for="address" class="col-md-4 text-md-right">Dirección</label>
                <div class="col-md-6">
                    <input id="address" type="text" class="form-control" name="address" v-model='form.address'>
                    <b-badge v-if='errors && errors.address' variant='danger'>@{{ errors.address[0] }}</b-badge>
                </div>
            </div>

            <div class="form-group row mb-0 justify-content-center">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        Registrar
                    </button>
                    <a href="{{route('users.index')}}" class="btn btn-link">Regresar</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const app = new Vue({
        el: "#app",
        data:{
            form:{
                first_name: null,
                last_name: null,
                email: null,
                area: null,
                password: null,
                password_confirmation: null,
                pin: null,
                rol: [],
                phone: null,
                contact_name: null,
                contact_phone: null,
                address: null,
            },
            
            errors: [],
            success: false,
        },
        methods: {
            onSubmit: function(){
                let dataForm = new FormData();
                for(let e in this.form){
                    dataForm.append(e, this.form[e] ? this.form[e] : '');
                }
                this.errors = [];
                axios.post('{{ route("users.store") }}', dataForm)
                .then(response => {
                    this.success = true;
                    swal({
                        title: 'Registro Completo',
                        text: 'el registro realizo correctamente',
                        icon: 'success',
                        showConfirmButton: true,
                    })
                    .then(result => {
                        window.location = '{{ route("users.index") }}';
                    });
                })
                .catch(error =>{
                    this.errors = error.response.data.errors;
                    this.success = false;
                    let element = document.querySelector('[name="'+ Object.keys(this.errors)[0] +'"]')
                    element.focus();
                    swal({
                        icon: 'error',
                        title: 'verifica los datos ingresados',
                    });
                })
            }
        }
    })
</script>
@endpush