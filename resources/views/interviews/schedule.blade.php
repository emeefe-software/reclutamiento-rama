@extends('layouts.frontend.frontend', [
    'withImageHeader' => true
])

@section('content')
<section class="breadcrumb breadcrumb_bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner text-center">
                    <div class="breadcrumb_iner_item">
                        <h2>Agendar entrevista</h2>
                        <p>Agenda una entrevista para ocupar alguna de nuestras vacantes para nuestros programas de prácticas profesionales</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section v-if="!scheduleCompleted" class="contact-section section_padding">
    <div class="container">
        <form ref="form" enctype="multipart/form-data" @@submit.prevent="submit" autocomplete="off" class="form-contact contact_form" action="{{route('agendar')}}" method="POST" id="contactForm" >
            <div class="row">
                <div class="col-lg-8">
                    {{ csrf_field() }} 
                    <div class="row">
                        <div class="col-12">
                            <h3>Datos de la vacante</h3>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="career">Elige la universidad</label>
                                <select ref="university" class="form-control" name="university" v-model="university" required>
                                    <option v-for="university in universities" :value="university.id">@{{university.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="career">Carrera a fin</label>
                                    <select ref="career" class="form-control" name="career" @change="checkCareer" v-model="career" required>
                                    <option v-for="career in careers" :value="career.id">@{{career.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="program">Elija el programa deseado</label>
                                <select ref="program" class="form-control" name="program" v-model="program" required>
                                    <option v-for="program in programs" :value="program.id">@{{program.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <h3>Datos del interesado</h3>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input class="form-control" v-format-name name="name" id="name" type="text" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="last_name">Apellidos</label>
                                <input class="form-control" v-format-name name="last_name" id="last_name" type="text" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control" name="email" id="email" type="email" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="phone">Teléfono (10 dígitos)</label>
                                <input class="form-control" v-format-simple-phone name="phone" id="phone" type="text" required maxlength="10" minlength="10">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                @if(\Setting::get('mode')=='videoCall')
                                    <label for="skype">GMAIL (te contactaremos por Google Meet)</label>
                                    <input class="form-control" name="skype" id="skype" type="text" required>
                                @else
                                    <input class="form-control" name="skype" id="skype" type="hidden" value="Not" required>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <h3>Selecciona el horario</h3>
                            <label>Selecciona un horario de los disponibles para agendar la entrevista</label>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <select ref="hour" class="form-control" name="hour" v-model="hour" required>
                                    <option v-for="hour in hours" :value="hour.id">@{{hour.formatted}}</option>
                                </select>
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
                                <textarea class="form-control w-100" name="message" id="message" cols="30" rows="9" placeholder="Detalles adicionales"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-4 pb-4" v-if="withCV">
                        <div class="media contact-info">
                            <span class="contact-info__icon"><i class="ti-home"></i></span>
                            <div class="media-body">
                                <h3>Adjunta tu CV en formato PDF</h3>
                            </div>
                        </div>
                        <div>
                            <input type="file" required accept="application/pdf" name="cv">
                        </div>
                    </div>

                    <div v-if="withPortfolio">
                        <div class="media contact-info">
                            <span class="contact-info__icon"><i class="ti-home"></i></span>
                            <div class="media-body">
                                <h3>Adjunta tu portafolio en formato PDF</h3>
                                <label>El portafolio es requerido para la carrera elegida, el portafolio son capturas capturas o ejemplos de tus trabajos realizados mas sobresalientes, por favor no repitas aquí tu CV</label>
                            </div>
                        </div>
                        <div>
                            <input type="file" required accept="application/pdf" name="portfolio">
                        </div>
                    </div>

                    
                </div>
            </div>

            <div class="row">
                <div class="col">
                    @if(config('app.env') == 'production')
                        <div id="recaptcha" class="g-recaptcha" data-sitekey="{{config('recaptcha.key')}}"></div>
                    @endif

                    <div class="form-group mt-3">
                        <button type="submit" class="button button-contactForm btn_1">Agendar entrevista</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<section v-else id="completed" class="contact-section section_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <h2 class="text-center">Se ha confirmado tu entrevista</h2>
                <p class="h1 text-center">
                    <b-icon icon="check" class="rounded-circle bg-success text-white" ></b-icon>
                </p>
                <br>
                <div class="card">
                    <div class="card-header">
                        Información
                    </div>
                    <div class="card-body">
                        @if(\Setting::get('mode')=='faceToFace')
                            <label>{{\Setting::get('msgFaceToFace')}}</label>
                        @else
                            <label>{{\Setting::get('msgVideoCall')}}</label>
                        @endif
                        <br><br>
                        <ul>
                            <li><b>Universidad</b>: @{{summary.university}}<li>
                            <li><b>Carrera</b>: @{{summary.career}}<li>
                            <li><b>Programa</b>: @{{summary.program}}<li>
                            <li><b>Horario</b>: @{{summary.hour}}<li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    var dictionary = {
        universities: @json($universities),
        careers: @json($careers)
    }
</script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="{{asset('js/frontend/pages/interviews_schedule.js')}}"></script>
@endsection