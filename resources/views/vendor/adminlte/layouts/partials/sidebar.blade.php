<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">



        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header"><h4>{{ trans('labels.header') }}</h4></li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active">
                <a href="{{ url('/') }}" class="logo " >

                    <i class='fa fa-dashboard'></i> <span>{{ trans('labels.dashboard') }}</span>

                </a>
            </li>

            @if(Auth::user()->checkRole('admin'))
                <li class="treeview hide-mobile">
                    <a href="#"><i class='fa fa-home'></i> <span>{{ trans('labels.config') }}</span><i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('locations') }}"><i class='fa fa-legal'></i> <span>{!! trans('labels.locations') !!}</span></a></li>
                        <li><a href="{{ url('consents') }}"><i class='fa fa-legal'></i> <span>{!! trans('labels.consents') !!}</span></a></li>
                        <li><a href="{{ url('locations/excel/show/'. Auth::user()->location->id) }}"><i class='fa fa-legal'></i> <span>{!! trans('labels.import') !!}</span></a></li>
                    </ul>
                </li>
            @endif

            @if(Auth::user()->checkRole('admin'))
            <li class="active hide-mobile">
                <a href="{{ url('users') }}">
                    <i class='fa fa-key'></i> <span>{{ trans('labels.users') }}</span></a>
            </li>
            @endif

            <li class="active">
                <a href="{{ url('groups') }}">
                    <i class='fa fa-address-book'></i> <span>{{ trans('labels.groups') }}</span></a>

            </li>




            <li class="treeview active ">
                <a href="#"><i class='fa fa-users'></i> <span>{{ trans('labels.persons') }}</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('persons') }}"><i class='fa fa-id-card-o'></i> <span>{!! trans('labels.persons') !!}</span></a></li>
                    <li><a href="{{ url('rightholders') }}"><i class='fa fa-id-card-o'></i> <span>{!! trans('labels.rightholders') !!}</span></a></li>
                </ul>
            </li>



            <li class="active">
                <a href="{{ url('photos') }}">
                    <i class='fa fa-image'></i>
                    <span>{{ trans('labels.photos') }}</span>
                </a>
            </li>
            <li class="active">
                <a href="{{ url('tasks') }}">
                    <i class='fa fa-flag-o'></i>
                    <span>{{ trans('labels.tasks') }}</span>
                </a>
            </li>

            <li class="treeview hide-mobile">
                <a href="#"><i class='fa fa-history'></i> <span>{{ trans('labels.historial') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('historic/persons')}}"><i class='fa fa-users'></i> <span>{{ trans('labels.byperson') }}</span></a></li>
                    <li><a href="{{ url('historic/rightholders')}}"><i class='fa fa-id-card'></i> <span>{{ trans('labels.byrightholder') }}</span></a></li>
                    <li><a href="{{ url('historic/photos')}}"><i class='fa fa-camera-retro'></i> <span>{{ trans('labels.byphoto') }}</span></a></li>
                </ul>
            </li>
<!--

            <li class="active treeview">
                <a href="#"><i class='fa fa-edit'></i> <span>{{ trans('labels.templates') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class='fa fa-envelope'></i> <span>{{ trans('labels.emails') }}</span></a></li>
                    <li><a href="#"><i class='fa fa-balance-scale'></i> <span>{{ trans('labels.legal') }}</span></a></li>
                </ul>
            </li>
            -->

        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
