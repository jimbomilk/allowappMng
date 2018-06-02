<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif



        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">{{ trans('labels.header') }}</li>
            <!-- Optionally, you can add icons to the links -->

            @if(Auth::user()->profile->type == 'super')
            <li class="active">
                <a href="{{ url('locations') }}">
                    <i class='fa fa-home'></i> <span>{{ trans('labels.locations') }}</span></a></li>
            @endif

            @if(Auth::user()->profile->type == 'admin'||Auth::user()->profile->type == 'super')
            <li class="active">
                <a href="{{ url('users') }}">
                    <i class='fa fa-key'></i> <span>{{ trans('labels.users') }}</span></a></li>
            @endif

            <li class="active">
                <a href="{{ url('groups') }}">
                    <i class='fa fa-users'></i> <span>{{ trans('labels.groups') }}</span></a>

            </li>

            <li class="active">
                <a href="{{ url('persons') }}">
                    <i class='fa fa-users'></i> <span>{{ trans('labels.persons') }}</span></a>
            </li>

            <li class="active">
                <a href="{{ url('rightholders') }}">
                    <i class='fa fa-id-card-o'></i> <span>{{ trans('labels.rightholders') }}</span></a>
            </li>

            <li class="active">
                <a href="{{ url('photos') }}">
                    <i class='fa fa-camera'></i> <span>{{ trans('labels.photos') }}</span></a></li>

            <!--
            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>Multinivel</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">Nivel2</a></li>
                    <li><a href="#">Nivel2</a></li>
                </ul>
            </li>
            -->
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
