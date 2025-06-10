@php
$user = isset($user) ? $user : Auth::user();

$menuItems = config('admin.menu');
foreach ($menuItems as $index => $menuItemConfig) {
    //Convertir route_name a URL en caso de no haber una URL
    if(!isset($menuItemConfig['url']) && isset($menuItemConfig['route_name'])){
        $menuItemConfig['url'] = route($menuItemConfig['route_name']);
    }

    $menuItems[$index] = new App\Library\Frontend\MenuItem($menuItemConfig);
}
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
         
        <!-- /menu footer buttons -->
       <!-- <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('login') }}">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div> -->
        <!-- /menu footer buttons -->
    </div>
</div>