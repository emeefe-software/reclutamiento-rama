<?php
return [
    /**
     * Menu a mostrar en el panel de admin, existen elementos con
     * submenus. Para indicar url se puede utilizar url o
     * route_name teniendo mas prioridad url
     */
    'menu'=>[
        [
            'title' => 'Dashboard',
            'icon' => 'fa fa-dashboard',
            'route_name' => 'dashboard.home'
        ],
        [
            'title' => 'Usuarios',
            'icon' => 'fa fa-users',
            'submenu' => [
                [
                    'title' => 'Ver usuarios',
                    'route_name' => 'users.index'
                ],
                [
                    'title' => 'Ver candidatos',
                    'route_name' => 'candidates'
                ],
                [
                    'title' => 'Registrar Usuario',
                    'route_name' => 'users.create'
                ],
            ]
        ],
        [
            'title' => 'Universidades',
            'icon' => 'fas fa-graduation-cap',
            'submenu' => [
                [
                    'title' => 'Ver universidades',
                    'route_name' => 'universities.index'
                ],
                [
                    'title' => 'Registrar universidad',
                    'route_name' => 'universities.create'
                ]
            ]
        ],
        [
            'title' => 'Carreras',
            'icon' => 'fas fa-user-graduate',
            'submenu' => [
                [
                    'title' => 'Ver carreras',
                    'route_name' => 'careers.index'
                ],
                [
                    'title' => 'Registrar carrera',
                    'route_name' => 'careers.create'
                ]
            ]
        ],
        [
            'title' => 'Programas',
            'icon' => 'fa fa-book',
            'submenu' => [
                [
                    'title' => 'Ver programas',
                    'route_name' => 'programs.index'
                ],
                [
                    'title' => 'Registrar programas',
                    'route_name' => 'programs.create'
                ]
            ]
        ],
        [
            'title' => 'Entrevistas',
            'icon' => 'fas fa-book-reader',
            'submenu' => [
                [
                    'title' => 'Ver entrevistas',
                    'route_name' => 'interviews.index'
                ],
                [
                    'title' => 'Registrar entrevista',
                    'route_name' => 'interviews'
                ]
            ]
        ],
        [
            'title' => 'Horarios',
            'icon' => 'fas fa-calendar-alt',
            'submenu' => [
                [
                    'title' => 'Ver horarios',
                    'route_name' => 'hours.index'
                ],
                [
                    'title' => 'Registrar horario',
                    'route_name' => 'hours.create'
                ]
            ]
        ],
        [
            'title' => 'Configuración',
            'icon' => 'fas fa-cog',
            'route_name' => 'settings'
        ]
    ],
    
];