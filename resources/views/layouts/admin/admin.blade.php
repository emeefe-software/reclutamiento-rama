@php
$title = isset($title) ? $title : config("app.name");
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{asset('favicon100x100.jpg')}}" sizes="32x32">
    <link rel="icon" href="{{asset('favicon300x300.jpg')}}" sizes="192x192">

    <title>{{ $title }}</title>

    <!-- Bootstrap -->
    {{--<link href="{{ asset('css/frontend/plugins/bootstrap.min.css') }}" rel="stylesheet">--}}
    <!-- Font Awesome -->
    <link href="{{ asset('css/frontend/plugins/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('css/frontend/plugins/nprogress.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('css/frontend/plugins/green.css') }}" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="{{ asset('css/frontend/plugins/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ asset('css/frontend/plugins/jqvmap.min.css') }}" rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('css/frontend/plugins/daterangepicker.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('css/frontend/plugins/custom.min.css') }}" rel="stylesheet">


    @stack('styles')
</head>
<?php
$user = Auth::user();
?>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">

            @include('layouts.admin.aside')
            @include('layouts.admin.top_navigation')

            <div class="right_col" role="main" id="app">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>{{$title}}</h3>
                        </div>

                        {{--
                        <div class="title_right">
                            <div class="col-md-5 col-sm-5 form-group pull-right top_search">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search for...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">Go!</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        --}}
                    </div>
                    <div class="clearfix"></div>
                    <div>
                        <main class="py-4">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                @yield('description')
                                            </div>
                                        </div>
                                        <br>
                                        @yield('content')
                                    </div>
                                </div>
                            </div>
                        </main>
                    </div>
                </div>
            </div>

            @include('layouts.admin.footer')
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <!-- jQuery -->
    <script src="{{ asset('js/frontend/plugins/jquery-2.2.4.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('js/frontend/plugins/bootstrap-4.3.1.bundle.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('js/frontend/plugins/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ asset('js/frontend/plugins/nprogress.js') }}"></script>
    <!-- Chart.js -->
    <script src="{{ asset('js/frontend/plugins/Chart.min.js') }}"></script>
    <!-- gauge.js -->
    <script src="{{ asset('js/frontend/plugins/gauge.min.js') }}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{ asset('js/frontend/plugins/bootstrap-progressbar-0.9.0.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('js/frontend/plugins/icheck-1.0.2.min.js') }}"></script>
    <!-- Skycons -->
    <script src="{{ asset('js/frontend/plugins/skycons.js') }}"></script>
    <!-- Flot -->
    <script src="{{ asset('js/frontend/plugins/jquery.flot.js') }}"></script>
    <script src="{{ asset('js/frontend/plugins/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('js/frontend/plugins/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('js/frontend/plugins/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('js/frontend/plugins/jquery.flot.resize.js') }}"></script>
    <!-- Flot plugins -->
    <script src="{{ asset('js/frontend/plugins/jquery.flot.orderBars.js') }}"></script>
    <script src="{{ asset('js/frontend/plugins/jquery.flot.spline.min.js') }}"></script>
    <script src="{{ asset('js/frontend/plugins/flot.curvedLines.js') }}"></script>
    <!-- DateJS -->
    <script src="{{ asset('js/frontend/plugins/date.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('js/frontend/plugins/jquery.vmap.js') }}"></script>
    <script src="{{ asset('js/frontend/plugins/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('js/frontend/plugins/jquery.vmap.sampledata.js') }}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{ asset('js/frontend/plugins/moment-2.13.0.min.js') }}"></script>
    <script src="{{ asset('js/frontend/plugins/daterangepicker.js') }}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{ asset('js/frontend/plugins/custom.min.js') }}"></script>

    <script src="https://kit.fontawesome.com/0045a7366e.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('sweet::alert')
    @stack('scripts')

</body>

</html>