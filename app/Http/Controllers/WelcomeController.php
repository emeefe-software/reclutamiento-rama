<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome(){
        $actionsForUsers = [
            [
                'icon' => 'fa fa-calendar-alt',
                'title' => 'Solicitar entrevista',
                'description' => 'Agenda una entrevista para aplicar a alguno de nuestros programas de prácticas profesionales',
                'url' => route('interviews.schedule'),
                'open_new_tab' => false
            ],
            [
                'icon' => 'fa fa-envelope',
                'title' => 'Acceder a correo',
                'description' => 'Accede a tu correo electrónico de RAMA',
                'url' => "https://mx44.hostgator.mx:2096/",
                'open_new_tab' => true
            ]
        ];
    
        return view('welcome', [
            'actionsForUsers' => $actionsForUsers
        ]);
    }
}
