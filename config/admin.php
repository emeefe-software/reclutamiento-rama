<?php
return [
    /**
     * Menu a mostrar en el panel de admin, existen elementos con
     * submenus. Para indicar url se puede utilizar url o
     * route_name teniendo mas prioridad url
     */
    'menu' => [
        [
            'title' => 'Dashboard',
            'icon' => 'fa fa-dashboard',
            'route_name' => 'dashboard.home',
            'roles' => [App\Role::ROLE_ADMIN, App\Role::ROLE_PRACTICING, App\Role::ROLE_RESPONSABLE, App\Role::ROLE_CANDIDATE],
        ],
        [
            'title' => 'Usuarios',
            'icon' => 'fa fa-users',
            'roles' => [App\Role::ROLE_ADMIN, App\Role::ROLE_RESPONSABLE],
            'submenu' => [
                [
                    'title' => 'Ver usuarios',
                    'route_name' => 'users.index',
                    'roles' => [App\Role::ROLE_ADMIN],
                ],
                [
                    'title' => 'Ver candidatos',
                    'route_name' => 'candidates'
                ],
                [
                    'title' => 'Registrar Usuario',
                    'route_name' => 'users.create',
                    'roles' => [App\Role::ROLE_ADMIN],
                ],
            ]
        ],
        [
            'title' => 'Universidades',
            'icon' => 'fas fa-graduation-cap',
            'roles' => [App\Role::ROLE_ADMIN, App\Role::ROLE_RESPONSABLE],
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
            'roles' => [App\Role::ROLE_ADMIN, App\Role::ROLE_RESPONSABLE],
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
            'roles' => [App\Role::ROLE_ADMIN, App\Role::ROLE_RESPONSABLE],
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
            'roles' => [App\Role::ROLE_ADMIN, App\Role::ROLE_RESPONSABLE],
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
            'roles' => [App\Role::ROLE_ADMIN, App\Role::ROLE_RESPONSABLE],
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
            'roles' => [App\Role::ROLE_ADMIN, App\Role::ROLE_RESPONSABLE],
            'route_name' => 'settings'
        ],
        [
            'title' => 'Bienvenida',
            'icon' => 'fas fa-handshake',
            'roles' => [App\Role::ROLE_PRACTICING],
            'route_name' => 'welcome',
        ],
        [
            'title' => 'Mi Perfil',
            'icon' => 'fas fa-user-circle',
            'roles' => [App\Role::ROLE_PRACTICING, App\Role::ROLE_CANDIDATE],
            'route_name' => 'profile.edit',
        ],
        [
            'title' => 'Ver Horarios',
            'icon' => 'fas fa-calendar-alt',
            'roles' => [App\Role::ROLE_PRACTICING],
            'route_name' => 'practicing.hours',
        ],
    ],

];
