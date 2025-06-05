@extends('layouts.admin.admin')
@section('content')
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
                    <div class="card">
                        <div class="card-header">
                            @yield('routeForm')
                            <button type="button" class="btn btn-info">@yield('newRecord')</button>
                            </a>
                        </div>
                        
                        <div class="card-body">
                            @yield('extraButtons')
                            @if($empty)
                            <h1 style="text-align: center">@yield('emptyMessage')</h1>
                            @else
                            <table class="table table-striped jambo_table bulk_action">
                                <thead class="">
                                    <tr class="headings">
                                        <!--<th>
                                            <input type="checkbox" id="check-all" class="flat">
                                        </th>-->
                                        @yield('header')
                                        <!-- <th class="bulk-actions" colspan="7">
                                            <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                        </th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @yield('body')
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection