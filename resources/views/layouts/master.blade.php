<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Flarepoint CRM</title>
    <link href="{{ URL::asset('css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lato:400,700, 300' rel='stylesheet' type='text/css'>




    
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/semantic.css') }}">

    <link href="{{ URL::asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <!---    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"> -->

    

    <link href="{{ URL::asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css">
    <!---   <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css"> -->
    <link href="{{ URL::asset('css/dropzone.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ asset(elixir('css/app.css')) }}">
    <!-- <script type="text/javascript" src="https://js.stripe.com/v2/"></script>-->
    <!---  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/i18n/jquery-ui-i18n.min.js"> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">



    <meta name="csrf-token" content="{{ csrf_token() }}"/>
</head>
<body>


<div id="wrapper">
    <div class="navbar navbar-default navbar-top">
        <!--NOTIFICATIONS START-->
        <div class="dropdown">
            <a id="dLabel" role="button" data-toggle="dropdown"  href="/page.html">
                <i class="glyphicon glyphicon-bell"><span id="notifycount"></span></i>
            </a>
            <ul class="dropdown-menu notify-drop  notifications" role="menu" aria-labelledby="dLabel">
                <div class="notification-heading"><h4 class="menu-title">Notifications</h4><h4
                            class="menu-title pull-right"><a href="{{url('notifications/markall')}}">Mark all as
                            read</a><i class="glyphicon glyphicon-circle-arrow-right"></i></h4>
                </div>
                <li class="divider"></li>
                <div class="notifications-wrapper">
                    <span id="notification-item"></span>
                    @push('scripts')
                    <script>
                        id = {};
                        function postRead(id) {
                            $.ajax({
                                type: 'post',
                                url: '{{url('/notifications/markread')}}',
                                data: {
                                    id: id,
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                        }

                        $(function () {
                            $.get("{{url('/notifications/getall')}}", function (notifications) {
                                var notifyItem = document.getElementById('notification-item');
                                var bell = document.getElementById('notifycount');
                                var msg = "";
                                var count = 0;
                                $.each(notifications, function (index, notification) {
                                    count++;
                                    var id = notification['id'];
                                    var url = notification['data']['url'];

                                    msg += `<div>
        <a class="content"  id="notify" href="{{url('notifications')}}/` + id + `">
        `
                                            + notification['data']['message'] +
                                            ` </a></div>
        <hr class="notify-line"/>`;
                                    notifyItem.innerHTML = msg;

                                    /**         notifyItem.onclick = (function(id){
             return function(){
                 postRead(id);
             }})(id); **/

                                });
                                bell.innerHTML = count;
                            })

                        });

                    </script>
                @endpush
                </div>

            </ul>
        </div>
        <!--NOTIFICATIONS END-->
        <button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target="#myNavmenu">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>


    <!-- /#sidebar-wrapper -->
    <!-- Sidebar menu -->

    <nav id="myNavmenu" class="navmenu navmenu-default navmenu-fixed-left offcanvas-sm" role="navigation">
        <div class="list-group panel">
            <p class=" list-group-item" title=""><img src="{{url('images/flarepoint_logo.png')}}" alt=""></p>
            <a href="{{route('dashboard', \Auth::id())}}" class=" list-group-item" data-parent="#MainMenu"><i
                        class="glyphicon glyphicon-dashboard"></i> @lang('menu.dashboard') </a>
            <a href="{{route('users.show', \Auth::id())}}" class=" list-group-item" data-parent="#MainMenu"><i
                        class="glyphicon glyphicon-user"></i> @lang('menu.profile') </a>


            <a href="#clients" class=" list-group-item" data-toggle="collapse" data-parent="#MainMenu"><i
                        class="glyphicon glyphicon-tag"></i> @lang('menu.clients.title') </a>
            <div class="collapse" id="clients">

                <a href="{{ route('clients.index')}}" class="list-group-item childlist">@lang('menu.clients.all')</a>
                @if(Entrust::can('client-create'))
                    <a href="{{ route('clients.create')}}"
                       class="list-group-item childlist">@lang('menu.clients.new')</a>
                @endif
            </div>

            <a href="#tasks" class=" list-group-item" data-toggle="collapse" data-parent="#MainMenu"><i
                        class="glyphicon glyphicon-tasks"></i> @lang('menu.tasks.title') </a>
            <div class="collapse" id="tasks">
                <a href="{{ route('tasks.index')}}" class="list-group-item childlist">@lang('menu.tasks.all')</a>
                @if(Entrust::can('task-create'))
                    <a href="{{ route('tasks.create')}}" class="list-group-item childlist">@lang('menu.tasks.new')</a>
                @endif
            </div>

            <a href="#user" class=" list-group-item" data-toggle="collapse" data-parent="#MainMenu"><i
                        class="fa fa-users"></i> @lang('menu.users.title') </a>
            <div class="collapse" id="user">
                <a href="{{ route('users.index')}}" class="list-group-item childlist">@lang('menu.users.all')</a>
                @if(Entrust::can('user-create'))
                    <a href="{{ route('users.create')}}"
                       class="list-group-item childlist">@lang('menu.users.new')</a>
                @endif
            </div>

            <a href="#leads" class=" list-group-item" data-toggle="collapse" data-parent="#MainMenu"><i
                        class="glyphicon glyphicon-hourglass"></i> @lang('menu.leads.title')</a>
            <div class="collapse" id="leads">
                <a href="{{ route('leads.index')}}" class="list-group-item childlist">@lang('menu.leads.all')</a>
                @if(Entrust::can('lead-create'))
                    <a href="{{ route('leads.create')}}"
                       class="list-group-item childlist">@lang('menu.leads.new')</a>
                @endif
            </div>
            <a href="#departments" class=" list-group-item" data-toggle="collapse" data-parent="#MainMenu"><i
                        class="fa fa-object-group"></i> @lang('menu.departments.title')</a>
            <div class="collapse" id="departments">
                <a href="{{ route('departments.index')}}"
                   class="list-group-item childlist">@lang('menu.departments.all')</a>
                @if(Entrust::hasRole('administrator'))
                    <a href="{{ route('departments.create')}}"
                       class="list-group-item childlist">@lang('menu.departments.new')</a>
                @endif
            </div>

            @if(Entrust::hasRole('administrator'))
                <a href="#settings" class=" list-group-item" data-toggle="collapse" data-parent="#MainMenu"><i
                            class="glyphicon glyphicon-cog"></i> @lang('menu.settings.title')</a>
                <div class="collapse" id="settings">
                    <a href="{{ route('settings.index')}}"
                       class="list-group-item childlist">@lang('menu.settings.overall')</a>

                    <a href="{{ route('roles.index')}}"
                       class="list-group-item childlist">@lang('menu.settings.roles')</a>
                    <a href="{{ route('integrations.index')}}"
                       class="list-group-item childlist">@lang('menu.settings.integrations')</a>
                </div>


            @endif
            <a href="{{ url('/logout') }}" class=" list-group-item impmenu" data-parent="#MainMenu"><i
                        class="glyphicon glyphicon-log-out"></i> @lang('menu.signout') </a>

        </div>
    </nav>


    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1>@yield('heading')</h1>
                    @yield('content')
                </div>
            </div>
        </div>
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>

        @endif
        @if(Session::has('flash_message_warning'))
            <div class="notification-warning navbar-fixed-bottom ">
                <div class="notification-icon ion-close-circled"></div>
                <div class="notification-text">
                    <span>{{ Session::get('flash_message_warning') }} </span></div>
            </div>
            @endif
        @if(Session::has('flash_message'))
            <div class="notification-success navbar-fixed-bottom ">
                <div class="notification-icon ion-checkmark-round"></div>
                <div class="notification-text">
                    <span>{{ Session::get('flash_message') }} </span></div>
            </div>
        @endif
    </div>
    <!-- /#page-content-wrapper -->
</div>
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap-paginator.js') }}"></script>
    <script src="//js.pusher.com/3.0/pusher.min.js"></script>

    <script type="text/javascript" src="{{ URL::asset('js/dropzone.js') }}"></script>
    <script src="{{ URL::asset('js/semantic.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/custom.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/sorttable.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/jasny-bootstrap.min.js') }}"></script>

@stack('scripts')
</body>

</html>
  