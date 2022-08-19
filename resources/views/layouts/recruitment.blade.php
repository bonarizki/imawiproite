<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">

    <title>I'M A WIPROITE | Recruitment</title>
    <link rel="shortcut icon" href="{{asset('images/wipro.ico')}}" type="image/x-icon" />

    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/app-assets/vendors/css/extensions/tether-theme-arrows.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/app-assets/vendors/css/extensions/tether.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/app-assets/vendors/css/extensions/shepherd-theme-default.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/app-assets/vendors/css/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/app-assets/vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_dashforge/lib/filepond/filepond.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_dashforge/lib/filepond/filepond-plugin-image-preview.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/app-assets/css/themes/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/app-assets/css/core/menu/menu-types/horizontal-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/app-assets/css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/app-assets/css/pages/dashboard-analytics.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/app-assets/css/pages/card-analytics.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/app-assets/css/plugins/tour/tour.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/app-assets/css/plugins/extensions/toastr.css') }}">

    <style type="text/css">
        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url({{ asset('images/Loader-wipro-2.gif') }}) center no-repeat rgba(255,255,255,0.6);
        }
    </style>

    @yield('assets-top')

    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_vuexy/assets/css/style.css') }}">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu 2-columns  navbar-floating footer-static  " data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

    <div class="se-pre-con"></div>

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-fixed navbar-shadow navbar-brand-center">
        <div class="navbar-header d-xl-block d-none">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item">
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        <div class="brand-logo">
                            <img src="{{ asset('images/wipro-logo.png') }}" style="width: 60px;">
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon feather icon-menu"></i></a></li>
                        </ul>
                        <ul class="nav navbar-nav bookmark-icons">
                            <li class="nav-item d-none d-lg-block mt-1">
                                <h3>RECRUITMENT</h3>
                            </li>
                        </ul>
                    </div>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <div class="user-nav d-sm-flex d-none">
                                    <span class="user-name text-bold-600">{{ Auth::user()->user_name }}</span>
                                    <span class="user-status">{{ App\Model\Title::where('title_id', Auth::user()->title_id)->first()->title_name }}</span>
                                </div>
                                <span>
                                    <i class="feather icon-user font-medium-5"></i>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ url('/home') }}">
                                    <i class="feather icon-skip-back"></i> Back To Home
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('/logout') }}">
                                    <i class="feather icon-power"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- BEGIN: Main Menu-->
    <div class="horizontal-menu-wrapper">
        <div class="header-navbar navbar-expand-sm navbar navbar-horizontal floating-nav navbar-light navbar-without-dd-arrow navbar-shadow menu-border" role="navigation" data-menu="menu-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mr-auto"><a class="navbar-brand">
                            <h2 class="brand-text mb-0">RESIGNATION</h2>
                        </a>
                    </li>
                    <li class="nav-item nav-toggle">
                        <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                            <i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i>
                            <i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Horizontal menu content-->
            <div class="navbar-container main-menu-content" data-menu="menu-container">
                <!-- include {{asset('assets_vuexy/includes/mixins')}}-->
                <ul class="nav navbar-nav hover" id="main-menu-navigation" data-menu="menu-navigation">

                    <?php
                        $all_parent = App\Model\Recruitment\MenuParent::all();
                        $all_child = App\Model\Recruitment\MenuChild::all();
                        $all_grand_child = App\Model\Recruitment\MenuGrandChild::all();

                        $access_exist = App\Model\Recruitment\Access::where('user_id', Auth::user()->user_id)->exists();
                        if($access_exist) {
                            $access = App\Model\Recruitment\Access::where('user_id', Auth::user()->user_id)->first();
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
                            @if(App\Model\Recruitment\MenuChild::where('menu_parent_id', $ap->menu_parent_id)->exists())
                                <li class="dropdown nav-item nav-{{ strtolower(str_replace(' ', '_', $ap->menu_parent_name)) }}" data-menu="dropdown">
                                    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                                        <i class="{{ $ap->menu_parent_icon }}"></i>
                                        <span data-i18n="{{ $ap->menu_parent_name }}">{{ $ap->menu_parent_name }}</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        @foreach($all_child as $ac)
                                            @if(in_array($ac->menu_child_id, $child) && $ac->menu_parent_id == $ap->menu_parent_id)
                                                @if(App\Model\Recruitment\MenuGrandChild::where('menu_child_id', $ac->menu_child_id)->exists())
                                                    <li class="dropdown dropdown-submenu nav-{{ strtolower(str_replace(' ', '_', $ac->menu_child_name)) }}" data-menu="dropdown-submenu">
                                                        <a class="dropdown-item dropdown-toggle" href="{{ url($ac->menu_child_url) }}" data-toggle="dropdown">
                                                            <i class="{{ $ac->menu_child_icon }}"></i>{{ $ac->menu_child_name }}
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            @foreach($all_grand_child as $agc)
                                                                @if(in_array($agc->menu_grand_child_id, $grand_child) && $agc->menu_child_id == $ac->menu_child_id)
                                                                    <li class="nav-{{ strtolower(str_replace(' ', '_', $agc->menu_grand_child_name)) }}" data-menu="">
                                                                        <a class="dropdown-item" href="{{ url($agc->menu_grand_child_icon) }}" data-toggle="dropdown" data-i18n="">
                                                                            <i class="{{ $agc->menu_grand_child_icon }}"></i>{{ $agc->menu_grand_child_name }}
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @else
                                                    <li class="nav-{{ strtolower(str_replace(' ', '_', $ac->menu_child_name)) }}" data-menu="">
                                                        <a class="dropdown-item" href="{{ url($ac->menu_child_url) }}" data-toggle="dropdown">
                                                            <i class="{{$ac->menu_child_icon}}"></i>{{ $ac->menu_child_name }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item nav-{{ strtolower(str_replace(' ', '_', $ap->menu_parent_name)) }}">
                                    <a class="nav-link" href="{{ url($ap->menu_parent_url) }}">
                                        <i class="{{ $ap->menu_parent_icon }}"></i>
                                        <span data-i18n="{{ $ap->menu_parent_name }}">{{ $ap->menu_parent_name }}</span>
                                    </a>
                                </li>
                           @endif
                        @endif
                    @endforeach

                </ul>
            </div>
        </div>
    </div>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            @yield('content')

        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>




    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('assets_vuexy/app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('assets_vuexy/app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
    <script src="{{ asset('assets_vuexy/app-assets/vendors/js/charts/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets_vuexy/app-assets/vendors/js/extensions/tether.min.js') }}"></script>
    <script src="{{ asset('assets_vuexy/app-assets/vendors/js/extensions/shepherd.min.js') }}"></script>
    <script src="{{ asset('assets_vuexy/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ asset('assets_vuexy/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets_vuexy/app-assets/vendors/js/extensions/polyfill.min.js') }}"></script>
    <script src="{{ asset('assets_vuexy/app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('assets_vuexy/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets_vuexy/app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets_vuexy/app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets_vuexy/app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets_vuexy/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets_vuexy/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets_vuexy/app-assets/vendors/js/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets_vuexy/app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets_vuexy/app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('assets_vuexy/app-assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('assets_vuexy/app-assets/vendors/js/pickers/pickadate/legacy.js') }}"></script>
    <script src="{{ asset('assets_vuexy/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets_vuexy/app-assets/vendors/js/autonumeric/autoNumeric.js') }}"></script>
    <script src="{{ asset('assets_dashforge/lib/filepond/filepond.js') }}"></script>
    <script src="{{ asset('assets_dashforge/lib/filepond/filepond-plugin-file-encode.js') }}"></script>
    <script src="{{ asset('assets_dashforge/lib/filepond/filepond-plugin-file-validate-size.js') }}"></script>
    <script src="{{ asset('assets_dashforge/lib/filepond/filepond-plugin-file-validate-type.js') }}"></script>
    <script src="{{ asset('assets_dashforge/lib/filepond/filepond-plugin-image-preview.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('assets_vuexy/app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('assets_vuexy/app-assets/js/core/app.js') }}"></script>
    <script src="{{ asset('assets_vuexy/app-assets/js/scripts/components.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script type="text/javascript">
        $(window).on('load', function() {
            $('.se-pre-con').fadeOut('slow');
        });
    </script>

    @yield('assets-bottom')
    <!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>
