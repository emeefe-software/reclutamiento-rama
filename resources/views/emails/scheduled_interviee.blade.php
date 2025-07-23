<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Entrevista Agendada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            color: #333;
            background-color: #f9f9f9;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
        }

        h2 {
            color: #007BFF;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a.button {
            display: inline-block;
            padding: 8px 12px;
            color: #fff;
            background-color: #007BFF;
            text-decoration: none;
            border-radius: 4px;
        }

        a.button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container" style="font-family: Arial, sans-serif; color: #333;">
        <h2 style="color: #2c3e50;">¡Tu entrevista ha sido agendada!</h2>

        <p>Hola {{ $candidate->fullname() }},</p>

        <p>Te informamos que tu entrevista ha sido programada exitosamente. A continuación te compartimos los detalles:</p>

        <ul style="list-style-type: none; padding-left: 0;">
            <li><strong>Nombre del candidato:</strong> {{ $candidate->fullname() }}</li>
            <li><strong>Email de contacto:</strong> {{ $candidate->email }}</li>
            <li><strong>Carrera:</strong> {{ $career->name }}</li>
            <li><strong>Correo de Gmail:</strong> {{ $candidate->skype }}</li>

            @if($interview->CV)
            <li><strong>CV:</strong> <a href="{{ url(\Storage::url($interview->CV)) }}" target="_blank" style="color: #2980b9;">Descargar CV</a></li>
            @endif

            @if($interview->portfolio)
            <li><strong>Portafolio:</strong> <a href="{{ url(\Storage::url($interview->portfolio)) }}" target="_blank" style="color: #2980b9;">Descargar Portafolio</a></li>
            @endif

            <li><strong>Fecha y hora:</strong> {{ $interview->hour()->first()->dateTime() }}</li>
            <li><strong>Programa:</strong> {{ $program->name }}</li>
            <li><strong>Universidad:</strong> {{ $university->name }}</li>

        </ul>

        <p style="margin-top: 20px;">
            Por favor, mantente al pendiente de tu correo electrónico para recibir el link de la videollamada.
        </p>

        <p>Gracias por tu interés en formar parte de nuestro equipo.</p>

        <p>Atentamente,<br>
            <strong>Equipo de Reclutamiento - Grupo RAMA</strong>
        </p>
    </div>
    <!-- Firma de Grupo RAMA -->
    <table border="0" cellpadding="0" cellspacing="0" width="500" style="width:500px; max-width:500px; font-family:Arial, sans-serif; background:#ffffff; margin-top:20px; border-top:1px solid #e0e0e0;">
        <tr>
            <td style="padding:10px 0;">
                <!-- Header -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="180" valign="middle" style="text-align:center; padding-right:20px;">
                            <a href="http://redesdevalor.com" target="_blank">
                                <img src="https://dingdong.mx/wp-content/uploads/2025/04/ramalogos.png" alt="Logo Rama" width="180" style="display:block; border:0; outline:none; text-decoration:none;" />
                            </a>
                        </td>
                        <td width="1" bgcolor="#000000" style="font-size:1px; line-height:140px;">&nbsp;</td>
                        <td valign="middle" style="color:#333; text-align:left; padding-left:20px;">
                            <h2 style="margin:0; font-size:18px; font-weight:bold;">Grupo Rama</h2>
                            <p style="margin:5px 0; font-size:14px; color:#666;">Equipo de Reclutamiento</p>
                            <p style="margin:5px 0; font-size:14px; color:#666;">Web: <a href="https://redesdevalor.com/" style="color:#666; text-decoration:none;">redesdevalor.com</a></p>
                        </td>
                    </tr>
                </table>

                <!-- Footer -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#999999" style="margin-top:10px;">
                    <tr>
                        <td style="padding:5px; text-align:center;">
                            <!-- Logos -->
                            <div style="display:inline-block; margin:0 5px;">
                                <a href="http://emeefe.mx" target="_blank">
                                    <img src="https://dingdong.mx/wp-content/uploads/2025/03/Recurso-8logos.png" alt="EMEIFE" height="45" style="border:0; outline:none; display:block;" />
                                </a>
                            </div>
                            <div style="display:inline-block; margin:0 5px;">
                                <a href="http://mundofrio.com.mx" target="_blank">
                                    <img src="https://dingdong.mx/wp-content/uploads/2025/03/Recurso-10logos.png" alt="MUNDO FRÍO" height="45" style="border:0; outline:none; display:block;" />
                                </a>
                            </div>
                            <div style="display:inline-block; margin:0 5px;">
                                <a href="http://meeyi.mx/" target="_blank">
                                    <img src="https://dingdong.mx/wp-content/uploads/2025/03/Recurso-9logos.png" alt="MEEYI" height="45" style="border:0; outline:none; display:block;" />
                                </a>
                            </div>
                            <div style="display:inline-block; margin:0 5px;">
                                <a href="http://hecco.mx" target="_blank">
                                    <img src="https://dingdong.mx/wp-content/uploads/2025/03/Recurso-11logos.png" alt="HECCO" height="45" style="border:0; outline:none; display:block;" />
                                </a>
                            </div>
                            <div style="display:inline-block; margin:0 5px;">
                                <a href="http://dingdong.mx" target="_blank">
                                    <img src="https://dingdong.mx/wp-content/uploads/2025/03/Recurso-12logos.png" alt="DINGDONG" height="45" style="border:0; outline:none; display:block;" />
                                </a>
                            </div>
                            <div style="display:inline-block; margin:0 5px;">
                                <a href="http://alohamx.rest/" target="_blank">
                                    <img src="https://dingdong.mx/wp-content/uploads/2025/03/Recurso-13logos.png" alt="LA CARACOLA" height="30" style="border:0; outline:none; display:block;" />
                                </a>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>