<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel VideoSharing</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>

    <!-- Scripts -->
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    @yield('head_for_script')
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    VideoSharing
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Navbar Search Engine -->
                <div class="col-sm-6 col-md-8 col-lg-8">
                    <form class="input-group" id="search-video-form" method="GET" action="/search">
                        <input class="form-control" type="text" name="search_content" placeholder="Search for videos"  
                            @if (isset($search_content))
                                value = "{{ $search_content }}"
                            @endif
                        />
                        <div class="input-group-btn">
                        <div class="btn-group" role="group">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-default dropdown-toggle" id="search-detail-button" data-toggle="dropdown" aria-expanded="false">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right form-horizontal" role="menu" stlye="">
                                        <li class="form-group">
                                            <label for="filter">Time Range</label><br>
                                            <label for="filter">From&nbsp;&nbsp;</label>
                                            <input class="form-control-static" type="text" name="search_time_from" placeholder="Format: 2016/07/18" style="text-align: center;"/>
                                            <label for="filter">&nbsp;&nbsp;To&nbsp;&nbsp;</label>
                                            <input class="form-control-static" type="text" name="search_time_to" placeholder="Format: 2016/10/7" style="text-align: center;"/>
                                        @if (Session::has('error_search_format'))
                                        <span class="help-block">
                                            <strong style="color: #ff0000">{{ Session::get('error_search_format') }}</strong>
                                        </span>
                                        @endif
                                        </li>
                                        <li class="form-group ">
                                            <label for="contain">User</label>
                                            <input class="form-control" type="text"  name="search_user"/>
                                        </li>
                                        <li class="form-group ">
                                            <button type="submit" class="btn btn-primary">
                                                <span class="fa fa-button fa-search" aria-hidden="true"></span>
                                            </button>
                                        </li>
                                    </ul>
                                    @if (Session::has('error_search_format'))
                                    <script>
                                        $('#search-video-form .dropdown-menu').toggle();
                                    </script>
                                    @endif
                                    <button type="submit" class="btn btn-primary">
                                        <span class="fa fa-button fa-search" aria-hidden="true"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('auth/login') }}">Login</a></li>
                        <li><a href="{{ url('auth/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('myplace') }}"><i class="fa fa-btn fa-sign-out"></i>My place</a></li>
                                <li><a href="{{ url('auth/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
