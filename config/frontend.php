<?php
return [
    /**
     * Menu a mostrar en el frontend, existen elementos con
     * submenus. Para indicar url se puede utilizar url o
     * route_name teniendo mas prioridad url
     */
    'menu'=>[
        [
            'title' => 'Inicio',
            'url' => '/',
            'submenu' => null,
            'is_special' => false
        ],
        [
            'title' => 'Login',
            'route_name' => 'login',
            'submenu' => null,
            'is_special' => true
        ],

        //With submenu example
        /*
        [
            'title'=>'Submenu',
            'url'=>'#',
            'submenu'=>[
                [
                    'title'=>'Item 1',
                    'url'=>'#',
                ],
                //...more
            ]
        ]*/
    ],

    'available_studies' => [
        'Lic. en ciencias de la computación',
        'Ing. en ciencias de la computación',
        'Ing. en tecnologías de la información',
        'Lic. en Arquitectura',
        'Lic. en diseño gráfico',
        'Lic. en comunicación',
        'Ing. en mecatrónica',
        'Ing. civil'
    ]
];