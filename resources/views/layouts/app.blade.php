<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>Serial Tracker</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/font-awesome/css/font-awesome.min.css')}}">
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    {{--<link href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" rel="stylesheet">--}}
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <nav class="navbar navbar-info navbar-static-top mainThemeColor">
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
                <a style="color: white;" class="navbar-brand " href="{{ url('/') }}">
                    Serial Tracker
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                @if (!Auth::guest())
                <ul class="nav navbar-nav navbar-left nav-pills">
                    {{--<div class="navbar-header">--}}
                        {{--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">--}}
                            {{--<span class="icon-bar"></span>--}}
                            {{--<span class="icon-bar"></span>--}}
                            {{--<span class="icon-bar"></span>--}}
                        {{--</button>--}}
                        {{--<a class="navbar-brand" href="javascript:void(0)">Grv</a>--}}
                    {{--</div>--}}
                    @if(\App\Setting::where('setting_id',7)->first()->default_value==2)
                   <li class="colorwhite {{Request::segment(1) == 'grv' ? 'active':''}}">
                       <a class="" href="{{route('grv.index')}}" style="background-color:lightsalmon;">
                           <img src="{{asset('/images/hand.svg')}}" style="width: 50px;height: 40px;margin-top: -15px;" alt=""> Receive
                       </a>
                   </li>

                    @endif
                    @if(\App\Setting::where('setting_id',7)->first()->default_value==1)
                    <li class="colorwhite {{Request::segment(1) == 'unprocessed' ? 'active':''}}">
                        <a class="" href="{{url('unprocessed')}}" style="background-color:lightsalmon;ont-size: 16px;font-weight: 600;color: #1f1f2e;">
                            <img src="{{asset('/images/hand.svg')}}" style="width: 50px;height: 40px;margin-top: -15px;" alt=""> Receive
                        </a>
                    </li>
                    @endif


                                                       

                    <li class="colorwhite {{Request::segment(1) == 'issue' ? 'active':''}}">
                        <a class="" href="{{url('issue')}}" style="font-size: 16px;font-weight: 600;background-color: lightgreen;color: #1f1f2e;">
                            <img src="{{asset('/images/commerce.svg')}}" style="width: 50px;height: 40px;margin-top: -15px;" alt="">Issue
                        </a>
                    </li>



                    <li class="colorwhite {{Request::segment(1) == 'sync' ? 'active':''}}">
                        <a  href="{{url('sync')}}">
                            <img src="{{asset('/images/sync.svg')}}" style="width: 50px;height: 40px;margin-top: -15px;" alt=""> Sync
                        </a>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle colorwhite" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <img src="{{asset('/images/report.png')}}" style="width: 50px;height: 40px;margin-top: -15px;" alt=""> Reports <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a  href="{{url('reports/create')}}">
                                    GRVS
                                </a>

                            </li>
                            <li>
                                <a  href="{{url('sales-report')}}">
                                    Sales Orders
                                </a>

                            </li>
                        </ul></li>
                </ul>
                @endif
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    {{--<li class="dropdown">--}}
                        {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>--}}
                        {{--<ul class="dropdown-menu">--}}
                            {{--<li><a href="#">Action</a></li>--}}
                            {{--<li><a href="#">Another action</a></li>--}}
                            {{--<li><a href="#">Something else here</a></li>--}}
                            {{--<li role="separator" class="divider"></li>--}}
                            {{--<li><a href="#">Separated link</a></li>--}}
                            {{--<li role="separator" class="divider"></li>--}}
                            {{--<li><a href="#">One more separated link</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}" class="colorwhite">Login</a></li>
{{--                        <li><a href="{{ url('/register') }}">Register</a></li>--}}
                    @else

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle colorwhite" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                               {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{url('/logout')}}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{url('/logout')}}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>

                                @if(\App\Setting::where('setting_id',7)->first()->default_value==2)
                                    <li>
                                        <a href="{{route('serialized.index')}}">
                                            Serialized Grv
                                        </a>
                                    </li>
                                @endif
                                @if(\App\Setting::where('setting_id',7)->first()->default_value==1)
                                    <li>
                                        <a href="{{url('serialized-unprocessed')}}">
                                            Serialized Grv
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a  href="{{route('issue.index')}}">
                                        Sale Orders
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('serials.index')}}">
                                        Serials
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('warranties.index')}}">
                                        Warranties
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('setting.index')}}">
                                        Settings
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('manage-users')}}">
                                        Manage Users
                                    </a>
                                </li>

                            </ul>
                        </li>
                            <li>
                                <a href="{{url('/logout')}}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    <img src="{{asset('/images/signout.svg')}}" style="width: 50px;height: 40px;margin-top: -15px;" alt="">
                                </a>

                                <form id="logout-form" action="{{url('/logout')}}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                                </li>
                    @endif
                </ul>

            </div>
        </div>
    </nav>


    @yield('content')

    <script src="/js/app.js"></script>
    <script src="/js/all.js"></script>
    {{--<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>--}}
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="{{ asset('js/jquery.PrintArea.js') }}" type="text/JavaScript"></script>
    <script>

        $(document).ready(function() {
            $('#example').DataTable();
        } );

        $(function() {
            $('.nav_backgroundColor a').click(function() {
                $('.nav_backgroundColor').removeClass();
                $('.nav_backgroundColor a').addClass('active');
            });
        });

        function closemodal() {
            $('#serialModal').modal('hide');
            $('#serialModal').on('hidden.bs.modal', function() {
                $('#dismiss').trigger('click');
            });
        }
    </script>
    @include('vendor.smodav.flash.flash')
    {{--<script>alert('test');</script>--}}
    @yield('script')
    @if(isset($message))
        <script>
            sflash({
                title: "Success",
                text: '{{$message['msg']}}',
                type: "success",
                allowOutsideClick: true,
                showConfirmButton: false,
                timer: 2500
            });
        </script>
    @endif
</body>
</html>
