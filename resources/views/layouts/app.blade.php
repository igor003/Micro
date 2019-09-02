<?php
date_default_timezone_set("Europe/Chisinau");
?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('js/jquery-ui-1.12.1.custom/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('js/jquery-ui-1.12.1.custom/jquery-ui.theme.css')}}">
    <!--Datapicker-->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{asset('js/jquery-ui-1.12.1.custom/jquery-ui.js')}}"></script>
    <!--Timepicker-->
    <script src="{{ asset('js/timepicker/jquery-ui-sliderAccess.js') }}"></script>
    <script src="{{ asset('js/timepicker/jquery-ui-timepicker-addon.js') }}"></script>

    <link href="{{ asset('js/timepicker/jquery-ui-timepicker-addon.css') }}" rel="stylesheet">

    
</head>
<script>

</script>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        MICROGRAFIA
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">


                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                    @if(Auth::user())
                        @if(Auth::user()->status == 'admin')
                             
                            <ul class="nav navbar-nav navbar-center vertical-center">
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        Adding
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                        <li>
                                            <a href="{{ route('add_project_view') }}">
                                                Add project
                                            </a>
                                        </li>
                                        <li>
                                            <a href ="{{route('add_codice_view')}}" >
                                                Add codice
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('add_configuration')}}">
                                                Add configuration
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('add_miniaplicator_view')}}">
                                                Add miniaplicator
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('add_machine_view')}}">
                                                Add machine
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('add_connector_view')}}">
                                                Add connector
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('mini_calibration_view')}}">Add mini calibration</a>
                                        </li>
                                    </ul>
                                </div>
                            </ul>
                   @endif
                    @endif
                    <ul class="nav navbar-nav navbar-center vertical-center">
                         @if(Auth::user())
                            @if(Auth::user()->status == 'admin')   
                                <li>
                                    <a href="{{route('projects_list_view')}}">Project</a>
                                </li>
                           @endif
                        @endif
                        <li>
                            <a href="{{route('codice_list_view')}}">Codice</a>
                        </li>
                        <li>
                            <a href="{{route('conf_list_view')}}">Configuration</a>
                        </li>
                        <li>
                            <a href="{{route('photo_list_view')}}">Photo list</a>
                        </li>
                        @if(Auth::user())
                            @if(Auth::user()->status == 'admin')   
                                <li>
                                    <a href="{{route('mini_list_view')}}">Miniaplicators</a>
                                </li>
                                <li>
                                    <a href="{{route('connector_list_view')}}">Connectors</a>
                                </li>
                                <li>
                                    <a href="{{route('machine_list_view')}}">Machines</a>
                                </li>
                            @endif
                        @endif
                        <li>
                            <a href="{{route('raport_view')}}">Report efficiency</a>
                        </li>
                        <li>
                            <a href="{{route('report_list_view')}}">Daily reports</a>
                        </li>
                        <li>
                            <a href="{{route('mini_calibration_list_view')}}">Mini Calibration</a>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>
    <!-- Scripts -->


</body>
</html>
