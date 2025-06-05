@extends('layouts.admin.admin')

@section('description')
<h1>Registrar Entrevista</h1>
<p>
    Registra una entrevista manualmente, <b>la entrevista será asignada al responsable del programa</b> y será notificado por medio de un email.
</p>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <section v-if="!scheduleCompleted" class="contact-section section_padding">
            <form ref="form" enctype="multipart/form-data" @@submit.prevent="submit" autocomplete="off" class="form-contact contact_form" action="{{route('agendarResponsable')}}" method="POST" id="contactForm">
                <div class="row">
                    <div class="col-lg-12">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-12">
                                <h3>Datos de la vacante</h3>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="career">Elige la universidad *</label>
                                    <select ref="university" class="form-control" name="university" v-model="university" required>
                                        <option v-for="university in universities" :value="university.id">@{{ university.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="career">Carrera a fin *</label>
                                    <select ref="career" class="form-control" name="career" @change="checkCareer" v-model="career" required>
                                        <option v-for="career in careers" :value="career.id">@{{career.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="program">Elija el programa *</label>
                                    <select ref="program" class="form-control" name="program" v-model="program" required>
                                        <option v-for="program in programs" :value="program.id">@{{program.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <h3>Datos del interesado</h3>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Nombre *</label>
                                    <input class="form-control" v-format-name name="name" id="name" type="text" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="last_name">Apellidos *</label>
                                    <input class="form-control" v-format-name name="last_name" id="last_name" type="text" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input class="form-control" name="email" id="email" type="email" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="phone">Teléfono (10 dígitos)</label>
                                    <input class="form-control" v-format-simple-phone name="phone" id="phone" type="text" maxlength="10" minlength="10">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    @if(\Setting::get('mode')=='videoCall')
                                    <label for="skype">Gmail (Google Meet)</label>
                                    <input class="form-control" name="skype" id="skype" type="text">
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <h3>Selección del horario *</h3>
                                <label>Selecciona un horario de los disponibles o agrega un nuevo horario para agendar la entrevista</label>
                            </div>
                            <div class="col-12">
                                <select class="form-control" name="selectHour" v-model="selectedHour" @change="onChangeHour" required>
                                    <option v-for="option in options" v-bind:value="option.value">@{{option.text}}</option>
                                </select>
                            </div>
                            <div v-if="isVisibleHours" class="col-12 mt-4">
                                <h3>Horarios Disponibles</h3>
                                <div class="form-group">
                                    <select ref="hour" class="form-control" name="hour" v-model="hour" required>
                                        <option v-for="hour in hours" :value="hour.id">@{{hour.formatted}}</option>
                                    </select>
                                </div>
                            </div>
                            <div v-if="isVisibleNewHour">

                                <!-- elemento horas del responsable -->
                                <div id="hourResponsable" class="col-12 mt-4">
                                    <h3>Nuevo Horario</h3>
                                    <div class="form-group">
                                        <label for="datepicker-full-width">Fecha</label>
                                        <b-form-datepicker v-model="date" class="mb-2" :min="startDate"></b-form-datepicker>
                                        <input type="hidden" name="date" :value="date">
                                    </div>
                                    <div class="form-group">
                                        <label for="time">Hora de inicio *</label>
                                        <br>
                                        <b-time v-model="time" locale="es" @@context="onContext" :minutes-step="15"></b-time>
                                        <input ref="time" type="hidden" name="time" required :value="formatTime(time)">
                                    </div>
                                    <div class="form-group">
                                        <label for="time">Hora de finalización *</label>
                                        <br>
                                        <b-time v-model="endTime" locale="es" @@context="onContextEnd" :minutes-step="15"></b-time>
                                        <input type="hidden" name="end_time" required :value="formatTime(endTime)">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <h3>Notas adicionales</h3>
                                <label>Coloca información adicional en caso de ser necesaria(opcional)</label>
                            </div>
                            <div v-if="cinematografia" class="col-12 mt-4">
                                <div class="alert alert-primary" role="alert">
                                    Por favor coloca un enlace a un Reel tuyo en las notas
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <b-form-textarea name="message" id="message" cols="30" rows="9" placeholder="Detalles Adicionales"></b-form-textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-4 pb-4" v-if="withCV">
                            <div class="media contact-info">
                                <span class="contact-info__icon"><i class="ti-home"></i></span>
                                <div class="media-body">
                                    <h3>Adjunta el CV en formato PDF</h3>
                                </div>
                            </div>
                            <div>
                                <b-form-file accept=".pdf" name="cv"></b-form-file>
                            </div>
                        </div>

                        <div v-if="withPortfolio">
                            <div class="media contact-info">
                                <span class="contact-info__icon"><i class="ti-home"></i></span>
                                <div class="media-body">
                                    <h3>Adjunta el portafolio en formato PDF</h3>
                                </div>
                            </div>
                            <div>
                                <b-form-file accept=".pdf" name="portfolio"></b-form-file>
                            </div>
                        </div>


                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group mt-3">
                            <b-button type="submit" variant="primary">Agendar Entrevista</b-button>
                        </div>
                    </div>
                </div>
            </form>
        </section>

        <section v-else id="completed" class="contact-section section_padding">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <h2 class="text-center">Entrevista registrada</h2>
                    <p class="h1 text-center">
                        <b-icon icon="check" class="rounded-circle bg-success text-white"></b-icon>
                    </p>
                    <br>
                    <div class="card">
                        <div class="card-header">
                            Información
                        </div>
                        <div class="card-body">
                            <ul>
                                <li><b>Universidad</b>: @{{summary.university}}</li>
                                <li><b>Carrera</b>: @{{summary.career}}</li>
                                <li><b>Programa</b>: @{{summary.program}}</li>
                                <li><b>Horario</b>: @{{summary.hour}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@endsection

@push('scripts')
<script>
    var dictionary = {
        universities: @json($universities),
        careers: @json($careers),
    };
</script>
<script src="{{asset('js/frontend/pages/interviews_schedule.js')}}"></script>
@endpush