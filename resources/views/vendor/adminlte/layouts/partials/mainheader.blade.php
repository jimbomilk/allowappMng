<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->

    <a href="{{ url('/home') }}" class="logo " >

        <img src="{{ asset('/img/logo_white200x50.png') }}">

    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <div class="col-sm-1 col-xs-2 " style="color:white;text-align: center">
            <img style="position: relative;top:5px"height="40px"  src="{{Auth::user()->location->icon}}">
        </div>
        <div class="col-sm-9 col-xs-9 nopadding" style="color:white;text-transform: uppercase;">
            <span style="font-size:1.2em;position: relative;top:10px">{{Auth::user()->location->description}}</span>
        </div>



        <!-- Tasks Menu -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>

                    <a href="#" class="dropdown-toggle" data-toggle="control-sidebar" title="ayuda">
                        <i class="fa fa-question-circle"></i>

                    </a>
                </li>
                <li class="dropdown tasks-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-o"></i>
                        <span class="label label-danger">9</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">{{ trans('labels.tasks') }}</li>
                        <li>
                            <!-- Inner menu: contains the tasks -->
                            <ul class="menu">
                                <li><!-- Task item -->
                                    <a href="#">
                                        <!-- Task title and progress text -->
                                        <h3>
                                            Task1
                                            <span class="label label-danger pull-right">Alta</span>
                                        </h3>

                                    </a>
                                </li><!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <!-- Task title and progress text -->
                                        <h3>
                                            Task2
                                            <span class="label label-warning pull-right">Media</span>
                                        </h3>

                                    </a>
                                </li><!-- end task item -->
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#">Allowapp © 2018</a>
                        </li>
                    </ul>
                </li>
                @if (Auth::guest())
                    <li><a href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>
                    <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                @else
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu" id="user_menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{isset(Auth::user()->profile->avatar)? Auth::user()->profile->avatar:Gravatar::get($user->email)}}" class="user-image" alt="User Image"/>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="{{isset(Auth::user()->profile->avatar)? Auth::user()->profile->avatar:Gravatar::get($user->email)}}" class="user-image" alt="User Image"/>
                                <p>
                                    {{ Auth::user()->name }}
                                    <small>{{ trans('adminlte_lang::message.login') }} Nov. 2012</small>
                                </p>
                            </li>
                            <!-- Menu Body -->

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ url("/profiles/$user->id/edit") }}" class="btn btn-default btn-flat">{{ trans('adminlte_lang::message.profile') }}</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat" id="logout"
                                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        {{ trans('adminlte_lang::message.signout') }}
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        <input type="submit" value="logout" style="display: none;">
                                    </form>

                                </div>
                            </li>
                        </ul>
                    </li>
                @endif

            </ul>
        </div>
    </nav>
</header>
