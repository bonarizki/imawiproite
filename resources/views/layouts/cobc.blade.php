<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="shortcut icon" href="{{asset('images/wipro.ico')}}" type="image/x-icon" />
    <!-- Title -->
    <title>I'M A WIPROITE | COBC</title>

    <!-- Vendor CSS -->
    <link href="{{ asset('assets_dashforge/lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets_dashforge/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets_dashforge/lib/typicons.font/typicons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets_dashforge/lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets_dashforge/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet">

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{{ asset('assets_dashforge/assets/css/dashforge.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('assets/css/dashforge.dashboard.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('assets_dashforge/assets/css/dashforge.demo.css') }}">

    <style type="text/css">
        .no-js #loader {
            display: none;
        }
        .js #loader {
            display: block;
            position: absolute;
            left: 100px;
            top: 0;
        }
        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url({{ asset('images/Loader-wipro-2.gif') }}) center no-repeat rgba(255,255,255,0.6);
        }
        .navbar-menu-sub .nav-sub-item .nav-sub-link {
            font-weight: 500;
        }
        .navbar-menu-sub .nav-sub-item.active .nav-sub-link {
            color: #0168FA;
        }
        .page-breadcrumb {
            margin-bottom: 20px;
        }
        table thead tr th, table tbody tr td {
            vertical-align: middle !important;
        }
        .table thead tr th.sorting {
            padding-right: 25px;
        }
        .btn i {
            margin-right: 5px;
        }
    </style>

    @yield('assets-top')

</head>

<body>
    <div class="se-pre-con"></div>
    <header class="navbar navbar-header navbar-header-fixed">
        <a href="" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>
        <div class="navbar-brand">
            <a href="{{ url('/cobc') }}" class="df-logo">COBC<span></span></a>
        </div>
        <div id="navbarMenu" class="navbar-menu-wrapper">
            <div class="navbar-menu-header">
                <a href="#" class="df-logo">COBC<span></span></a>
                <a id="mainMenuClose" href=""><i data-feather="x"></i></a>
            </div>
            <ul class="nav navbar-menu">
                <li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">Main Navigation</li>

                <?php
                    $all_parent = App\Model\COBC\MenuParent::all();
                    $all_child = App\Model\COBC\MenuChild::all();
                    $all_grand_child = App\Model\COBC\MenuGrandChild::all();

                    $access_exist = App\Model\COBC\Access::where('user_id', Auth::user()->user_id)->exists();
                    if($access_exist) {
                        $access = App\Model\COBC\Access::where('user_id', Auth::user()->user_id)->first();
                        $module = explode('#', $access->menu);
                        $parent = explode(',', $module[0]);
                        $child = explode(',', $module[1]);
                        $grand_child = explode(',', $module[2]);
                    } else {
                        $parent = array();
                        $child = array();
                        $grand_child = array();
                    }
                ?>

                @foreach($all_parent as $ap)
                    @if(in_array($ap->menu_parent_id, $parent))
                        @if(App\Model\COBC\MenuChild::where('menu_parent_id', $ap->menu_parent_id)->exists())
                            <li class="nav-item with-sub nav-{{ strtolower(str_replace(' ', '_', $ap->menu_parent_name)) }}">
                                <a href="" class="nav-link">{{ $ap->menu_parent_name }}</a>
                                <ul class="navbar-menu-sub">
                                    @foreach($all_child as $ac)
                                        @if(in_array($ac->menu_child_id, $child) && $ac->menu_parent_id == $ap->menu_parent_id)
                                            <li class="nav-sub-item nav-{{ strtolower(str_replace(' ', '_', $ac->menu_child_name)) }}">
                                                <a href="{{ url($ac->menu_child_url) }}" class="nav-sub-link">{{ $ac->menu_child_name }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="nav-item nav-{{ strtolower(str_replace(' ', '_', $ap->menu_parent_name)) }}">
                                <a href="{{ url($ap->menu_parent_url) }}" class="nav-link">{{ $ap->menu_parent_name }}</a>
                            </li>
                        @endif
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="navbar-right">
            <div class="text-right">
                <h6 class="tx-semibold mg-b-0">{{ Auth::user()->user_name }}</h6>
                <p class="tx-12 mg-b-0">{{ App\Model\Title::where('title_id', Auth::user()->title_id)->first()->title_name }}</p>
            </div>
            <div class="dropdown dropdown-profile">
                <a href="" class="dropdown-link" data-toggle="dropdown" data-display="static">
                    <div class="avatar avatar-sm">
                        <img src="{{ asset('assets_dashforge/assets/img/user.png') }}" class="rounded-circle" alt="">
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right tx-13">
                    <a href="{{ url('/home') }}" class="dropdown-item">
                        <i data-feather="home"></i> Back to Home
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ url('/logout') }}" class="dropdown-item"><i data-feather="log-out"></i>Sign Out</a>
                </div>
            </div>
        </div>
    </header>

    <div class="content content-fixed">

        @yield('content')

    </div>

    <script src="{{ asset('assets_dashforge/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets_dashforge/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets_dashforge/lib/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets_dashforge/lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets_dashforge/lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets_dashforge/lib/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets_dashforge/lib/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets_dashforge/lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js') }}"></script>

    <script src="{{ asset('assets_dashforge/assets/js/dashforge.js') }}"></script>

    <script type="text/javascript">
        $(window).on('load', function() {
            $('.se-pre-con').fadeOut('slow');
        });
    </script>

    @yield('assets-bottom')

</body>

</html>
