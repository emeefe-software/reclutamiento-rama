<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduled Interview</title>
</head>

<body>
    <p>Datos de la Entrevista Agendada:</p>
    <ul>
        <li>Candidato: {{ $candidate->fullname() }}</li>
        <li>Email: {{ $candidate->email }}</li>
        <li>Carrera: {{ $career->name }}</li>
        <li>Skype: {{ $candidate->skype }}</li>
        @if($interview->CV)
            <li>Link a CV: <a target="_blank" href="{{url(\Storage::url($interview->CV))}}" class="btn btn-primary">Descargar CV</a></li>
        @endif
        @if($interview->portfolio)
            <li>Link a CV: <a target="_blank" href="{{url(\Storage::url($interview->portfolio))}}" class="btn btn-primary">Descargar portafolio</a>
        @endif
        <li>Fecha y hora: {{ $interview->hour()->first()->dateTime() }}</li>
        <li>Programa: {{ $program->name }}</li>
        <li>Universidad: {{ $university->name }}</li>
        <li><a href="{{$linkToInterviewView}}">Link a la vista de entrevista</a></li>
    </ul>
</body>

</html>