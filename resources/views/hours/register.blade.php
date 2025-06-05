<?php $user=Auth::user();?>
@extends('layouts.admin.admin', [
    'title' => 'Horas trabajadas'
])

@section('description')
    <h1>Nuevo Horario</h1>
    <p>
        Registra un horario o rango de horarios.
        
        <br><ul>
            <li><b>Único</b>: Si un aspirante agenda en un horario de este tipo entonces ningún aspirante más podrá elegir este mismo horario</li>
            <li><b>Simultáneo</b>: Si un aspirante agenda en un horario de este tipo puede haber otra entrevista con otro encargado a la misma hora</li>
        </ul>
    </p>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{route('hours.store')}}">
            {{ csrf_field() }}
                <div class="form-group">
                    <label for="datepicker-full-width">Fecha de inicio</label>
                        <b-form-datepicker
                            v-model="date"
                            class="mb-2"
                            :min="startDate"
                            menu-class="w-100"
                            calendar-width="100%"
                        ></b-form-datepicker>
                        <input type="hidden" name="date" :value="date">
                </div>
                <div class="form-group">
                    <label for="datepicker-full-width">Fecha de finalización</label>
                        <b-form-datepicker
                            v-model="end_date"
                            class="mb-2"
                            :min="startDate"
                            menu-class="w-100"
                            calendar-width="100%"
                        ></b-form-datepicker>
                        <input type="hidden" name="end_date" :value="end_date">
                </div>
                <div class="form-group">
                    <label for="time">Hora de inicio</label>
                    <br><b-time 
                        v-model="time" 
                        locale="es" 
                        @@context="onContext"
                        :minutes-step="15"
                        ></b-time>
                    <input type="hidden" name="time" required :value="timeFormatted">
                </div>
                <div class="form-group">
                    <label for="time">Hora de finalización</label>
                    <br><b-time
                        v-model="endTime"
                        locale="es"
                        @@context="onContextEnd"
                        :minutes-step="15"
                        ></b-time>
                    <input type="hidden" name="end_time" required :value="endTimeFormatted">
                </div>
                <div class="form-group">
                    <label>Encargados</label>
                    <?php $r=0 ?>
                    @if($user->hasRole('admin'))
                        @foreach($responsibles as $responsible)
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="{{$responsible->id}}" class="custom-control-input"  name="responsibleCheck[]" id="responsibleCheck<?php echo $r ?>">
                                <label class="custom-control-label" for="responsibleCheck<?php echo $r?>">{{$responsible->fullname()}}</label>
                            </div>
                        <?php $r=$r+1 ?>
                        @endforeach
                    @else
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" value="{{$user->id}}" class="custom-control-input"  name="responsibleCheck[]" id="responsibleCheck<?php echo $r ?>">
                            <label class="custom-control-label" for="responsibleCheck<?php echo $r?>">{{$user->fullname()}}</label>
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label>Tipo de horario</label>
                    <div style="padding-top: 10px; padding-bottom: 10px" class="custom-control custom-radio">
                        <input type="radio" id="typeRadio0" name="typeRadio" class="custom-control-input" value="0">
                        <label class="custom-control-label" for="typeRadio0">
                            Simultáneo: Los encargados seleccionados pueden tener entrevistas simultáneamente
                        </label>
                    </div>
                    <div style="padding-bottom: 10px;" class="custom-control custom-radio">
                        <input type="radio" id="typeRadio1" name="typeRadio" class="custom-control-input" value="1">
                        <label class="custom-control-label" for="typeRadio1">
                            Único: Solo puede haber una entrevista en el horario por alguno de los encargados seleccionados
                        </label>
                    </div>
                </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{route('hours.index')}}" class="btn btn-link">Regresar</a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/backend/pages/hours_register.js')}}"></script>
@endpush