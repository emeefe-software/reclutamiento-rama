@php
    $user = isset($user) ? $user : Auth::user();
    $menuItems = collect(config('admin.menu'));


    // Función para saber si el usuario tiene alguno de los roles permitidos
    function userHasAnyRole($user, $roles)
    {
        if (!is_array($roles))
            return true; // si no se especifican roles, se muestra a todos
        foreach ($roles as $role) {
            if ($user->hasRole($role))
                return true;
        }
        return false;
    }

    // Filtrar menú
    $menuItems = $menuItems->map(function ($item) use ($user) {
        // Si tiene submenú, filtrar subitems
        if (isset($item['submenu'])) {
            $item['submenu'] = collect($item['submenu'])->filter(function ($subitem) use ($user) {
                return !isset($subitem['roles']) || userHasAnyRole($user, $subitem['roles']);
            })->values()->all();
        }
        return $item;
    })->filter(function ($item) use ($user) {
        // Ocultar ítem si no tiene submenú visible ni permisos
        $hasRole = !isset($item['roles']) || userHasAnyRole($user, $item['roles']);
        $hasSubmenu = isset($item['submenu']) && count($item['submenu']) > 0;
        $isDirectLink = isset($item['route_name']) || isset($item['url']);
        return $hasRole && ($hasSubmenu || $isDirectLink);
    })->map(function ($item) {
        if (!isset($item['url']) && isset($item['route_name'])) {
            $item['url'] = route($item['route_name']);
        }
        return new \App\Library\Frontend\MenuItem($item);
    });

@endphp

<div class="col-md-3 left_col position-fixed ">
    <div class="left_col scroll-view ">
        <div class="navbar nav_title" style="border: 0;">
            <a href="" class="site_title"><span>{{ config('app.name', 'RAMA') }}</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="{{ asset('images/empty_user.png') }}" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{ $user->fullname() }}</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>

                <ul class="nav side-menu">
                    @foreach($menuItems as $menuItem)
                        @if($menuItem->hasSubMenu())
                            <li>
                                <a>
                                    @if($menuItem->hasIcon())
                                        <i class="{{$menuItem->icon}}"></i>
                                    @endif
                                    {{$menuItem->title}}
                                    <span class="fa fa-chevron-down"></span>
                                </a>
                                <ul class="nav child_menu">
                                    @foreach($menuItem->getSubMenu() as $submenuItem)
                                        <li><a href="{{ $submenuItem->url }}">{{$submenuItem->title}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li>
                                <a href="{{$menuItem->url}}">
                                    @if($menuItem->hasIcon())
                                        <i class="{{$menuItem->icon}}"></i>
                                    @endif
                                    {{$menuItem->title}}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            {{-- SE PUEDE REGISTRAR OTRO MENU SECTION --}}

        </div>
        <!-- /sidebar menu -->

    </div>
</div>