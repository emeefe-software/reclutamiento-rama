@extends('layouts.admin.admin')

@section('description')
<h1>{{ $user->fullname() }}</h1>
<p>
    Registro de horas acumuladas al registrar desde la app o desde este mismo panel.
    <br><br>Puedes registrar, editar o eliminar horas manuálmente, al final puedes visualizar el acumulado de horas.
</p>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
    <b-button variant='primary' @click="prevAgregaRegistro">Agregar registro</b-button>
    <b-modal @ok="guardaRegistro" size="md" centered id="modal-nuevo-registro" title="Nuevo Registro">
        <b-row>
            <b-col md="12">
                <b-form-group label="Fecha registro">
                    <label for="fechaRegistro">Personalizar fecha:</label>
                    <b-form-datepicker menu-class="w-100" calendar-width="100%" id="fechaRegistro" v-model="fechaRegistro"></b-form-datepicker>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="6">
                <b-form-group label="Hora de inicio">
                    <b-time v-model="timeValue1"></b-time>
                </b-form-group>
            </b-col>
            <b-col md="6">
                <b-form-group label="Hora de fin">
                    <b-time v-model="timeValue2"></b-time>
                </b-form-group>
            </b-col>
        </b-row>
    </b-modal>
    <b-modal @ok="guardaRegistroEditado" size="md" centered id="modal-edita-registro" title="Edita Registro">
        <b-row>
            <b-col md="12">
                <b-form-group label="Fecha registro">
                    <label for="fechaRegistroDatePicker">Personalizar fecha:</label>
                    <b-form-datepicker menu-class="w-100" calendar-width="100%" id="fechaRegistroDatePicker" v-model="fechaRegistro"></b-form-datepicker>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="6">
                <b-form-group label="Hora de inicio">
                    <b-time v-model="timeValue1"></b-time>
                </b-form-group>
            </b-col>
            <b-col md="6">
                <b-form-group label="Hora de fin">
                    <b-time v-model="timeValue2"></b-time>
                </b-form-group>
            </b-col>
        </b-row>
    </b-modal>
    </div>

    <div class="card-body">
        <table class="table table-striped table-sm jambo_table bulk_action">
            <thead class="">
                <tr class="headings">
                    <th scope="col">Entrada</th>
                    <th scope="col">Salida</th>
                    <th scope="col">Horas</th>
                    <th scope="col">Acciones</th>
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
                        <td>
                            <b-button size="sm" variant="primary" @click="prevEditarRegistro({{ $register }})"><b-icon icon="pencil-square"></b-icon></b-button>
                            <b-button size="sm" variant="danger" @click="eliminaRegistro({{$register}})"><b-icon icon="trash"></b-icon></b-button>
                        </td>
                    </tr>
                @endforeach
                @php
                    $hours = (int)($count/60);
                    $minutes = $count - $hours*60;
                @endphp
                <tr>
                    <td class="column-title" colspan="2">Total de horas</td>
                    <td class="column-title" colspan="1">{{str_pad($hours,2,'0',STR_PAD_LEFT).":".str_pad($minutes,2,'0',STR_PAD_LEFT). " hrs"}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var app = new Vue({
        el: '#app',
        data: {
            timeValue1: "09:00:00",
            timeValue2: "09:01:00",
            fechaRegistro: null,
            registroEditado: null
        },
        methods: {
            prevAgregaRegistro: function(){
                let today = new Date();
                //this.fechaRegistro = String(today.getDate()).padStart(2, '0') + '-' + String(today.getMonth()+1).padStart(2, '0') + '-' + today.getFullYear();
                this.fechaRegistro = today;
                this.$bvModal.show('modal-nuevo-registro');
            },
            guardaRegistro: function(){
                if(Date.parse(this.timeValue1) < Date.parse(this.timeValue2)) {

                    try{
                        this.fechaRegistro = this.fechaRegistro.toDateString();
                    }catch(e){}

                    axios.post("{{ route('users.registers.store') }}",{
                        user_id: "{{ $user->id }}",
                        start_at: this.fechaRegistro + " " + this.timeValue1,
                        end_at: this.fechaRegistro + " " + this.timeValue2
                    }).then(response => {
                        location.reload();
                    }).catch(e =>{
                        console.log(e);
                    });
                } else {
                    swal({
                        title: "Atencion!!!",
                        text: "la hora de Inicio tiene que ser menor a la hora de Fin",
                        icon: "warning",
                        dangerMode: true,
                    })
                }
            },
            guardaRegistroEditado: function(){
                try{
                    this.fechaRegistro = this.fechaRegistro.toDateString();
                }catch(e){}

                if(Date.parse(this.timeValue1) < Date.parse(this.timeValue2)) {
                    axios.put("/admin/users/registers/" + this.registroEditado.id,{
                        start_at: this.fechaRegistro + " " + this.timeValue1,
                        end_at: this.fechaRegistro + " " + this.timeValue2
                    }).then(response => {
                        swal("Registro editado correctamente", {
                            icon: "success",
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }).catch(e =>{
                        console.log();
                    });
                } else {
                    swal({
                        title: "Atencion!!!",
                        text: "la hora de Inicio tiene que ser menor a la hora de Fin",
                        icon: "warning",
                        dangerMode: true,
                    })
                }
            },
            prevEditarRegistro: function(reg) {
                this.registroEditado = reg;
                this.fechaRegistro = reg.start_at.substring(0,10);
                this.timeValue1 = reg.start_at.substring(11,19);
                this.timeValue2 = reg.end_at.substring(11,19);

                this.$bvModal.show('modal-edita-registro');
            },
            eliminaRegistro: function(registro){
                swal({
                        title: "Atencion!!!",
                        text: "¿Realmente deseas eliminar el Registro?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                })
                .then( option => {
                    if( option ){
                        axios.delete('/admin/users/registers/destroy/' + registro.id)
                        .then( response => {

                            swal(response.data.description, {
                                icon: "success",
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        })
                        .catch(e => {
                            swal("Error al eliminar la carrera", {
                                text : e,
                                icon: "warning",
                            });
                        });
                    }
                })
            }
        }
    });
</script>
@endpush