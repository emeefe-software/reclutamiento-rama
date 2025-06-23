@extends('layouts.admin.admin', [
'title' => 'Dashboard'
])

@section('description')
<div>
    <h3 class="mb-1">Bienvenido, <strong>{{ $authenticatedUser->first_name }}</strong></h3>
</div>

<div class="mt-3">
    <p>
        A través de esta plataforma podrá gestionar su información personal, registrar sus horarios de prácticas
        y consultar el avance de sus horas cursadas.
    </p>
    <p>
        Le recordamos mantener sus datos actualizados y cumplir con los lineamientos establecidos por la institución.
        Para cualquier duda, comuníquese con su responsable asignado.
    </p>
</div>
@endsection

@section('content')
<div id="calendar" style="height: 600px; max-width: 900px; width: 100%; margin: 0 auto;"></div>
@endsection

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css' rel='stylesheet' />
@endpush

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>

<script>
    var app = new Vue({
        el: '#app'
    })

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es', // Opcional: para mostrarlo en español
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            },
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
            },
            selectable: true,
            events: [
                // Aquí puedes cargar eventos estáticos o vía AJAX
                {
                    title: 'Mi horario de prueba',
                    start: '2025-06-25',
                    description: 'Ejemplo'
                }
            ],
        });

        calendar.render();
    });
</script>
@endpush