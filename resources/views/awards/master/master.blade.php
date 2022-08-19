<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <title>I am A Wiproites | Sales Awards - @yield('title')</title>
    <link rel="shortcut icon" href="{{asset('images/wipro.ico')}}" type="image/x-icon" />
    <link rel="apple-touch-icon" href="{{asset('images/wipro.ico')}}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    @include('resignation/master/include/scriptHeader')
    <style>
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
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu 2-columns  navbar-floating footer-static " data-open="hover" data-menu="horizontal-menu" data-col="2-columns">
    <div class="se-pre-con"></div>
    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-fixed navbar-shadow navbar-brand-center">
        <div class="navbar-header d-xl-block d-none">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item">
                    <a class="navbar-brand" href="{{url('/')}}">
                        <div>
                            <img src="{{asset('images/wipro-logo.png')}}" alt="" height="50px" width="65px">
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
                            <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="{{url('/')}}"><i class="ficon feather icon-menu"></i></a></li>
                        </ul>
                        <ul class="nav navbar-nav bookmark-icons">
                            <li class="nav-item d-none d-lg-block mt-1">
                                <h3>SALES AWARDS</h3>
                            </li>
                        </ul>
                    </div>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <div class="user-nav d-sm-flex d-none">
                                    <span class="user-name text-bold-600">{{Auth::user()->user_name}}</span>
                                    <span class="user-status">{{\App\Repository\Dashboard\Title\TitleRepository::getTitleById(Auth::user()->title_id)->title_name}}</span>
                                </div>
                                <span ><i class="feather icon-user font-medium-5"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{url('/')}}">
                                    <i class="feather icon-home"></i> Back To Home
                                </a>
                                <div class="custom-control dropdown-item custom-switch switch-lg custom-switch-success mr-2 mb-1">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch100">
                                    <label class="custom-control-label" for="customSwitch100">
                                        <span class="switch-text-left">Light</span>
                                        <span class="switch-text-right">Dark</span>
                                    </label>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{route('logout')}}">
                                    <i class="feather icon-power"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    <div class="horizontal-menu-wrapper">
        <div class="header-navbar navbar-expand-sm navbar navbar-horizontal floating-nav navbar-light navbar-without-dd-arrow navbar-shadow menu-border" role="navigation" data-menu="menu-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mr-auto"><a class="navbar-brand">
                            <h2 class="brand-text mb-0">Sales Awards</h2>
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
                    @php
                        $user = App\Model\User::with('SalesAwards')->find(Auth::user()->user_id);
                        $allMenu = App\Model\Awards\Menu\Menu::with(['MenuChild','MenuChild.MenuGrandChild'])->get();
                        $access = App\Model\Awards\Access::find($user->SalesAwards->access_id);
                        if ($access) {
                            $menu = explode('#', $access->menu);
                            $parent = explode(',', $menu[0]);
                            $child = explode(',', $menu[1]);
                            $grand_child = explode(',', $menu[2]);
                        }else{
                            $parent = [];
                            $child = [];
                            $grand_child = [];
                        }
                    @endphp
                    @foreach ($allMenu as $parentMenu)
                        @foreach ($parent as $accessParent)
                           @if ($parentMenu->menu_parent_id==$accessParent)
                               @if (count($parentMenu->MenuChild)>0)
                                    <li class="dropdown nav-item {{$parentMenu->menu_parent_name}}" data-menu="dropdown">
                                        <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                                            <i class="{{$parentMenu->menu_parent_icon}}"></i>
                                            <span data-i18n="{{$parentMenu->menu_parent_name}}">{{$parentMenu->menu_parent_name}}</span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach ($parentMenu->MenuChild as $menuChild)
                                                @foreach ($child as $accessChild)
                                                    @if ($menuChild->menu_child_id == $accessChild )
                                                        @if (count($menuChild->MenuGrandChild)>0)
                                                            <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="{{url($menuChild->menu_child_url)}}" data-toggle="dropdown"><i class="{{$menuChild->menu_child_icon}}"></i>{{$menuChild->menu_child_name}}</a>
                                                                <ul class="dropdown-menu">
                                                                @foreach ( $menuChild->MenuGrandChild as $menuGrandChild)
                                                                    @foreach ($grand_child as $accessGrandChild)
                                                                        @if ($menuGrandChild->menu_grand_child_id == $accessGrandChild)
                                                                            <li data-menu="">
                                                                                <a class="dropdown-item" href="{{url($menuGrandChild->menu_grand_child_icon)}}" data-toggle="dropdown" data-i18n="Shop"><i class="{{$menuGrandChild->menu_grand_child_icon}}"></i>{{$menuGrandChild->menu_grand_child_name}}</a>
                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                                </ul>
                                                        @else
                                                        <li data-menu="">
                                                            <a class="dropdown-item" href="{{url($menuChild->menu_child_url)}}" data-toggle="dropdown">
                                                                <i class="{{$menuChild->menu_child_icon}}"></i>{{$menuChild->menu_child_name}}
                                                            </a>
                                                        </li>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </ul>
                                    </li>
                               @else
                                    <li class="nav-item {{$parentMenu->menu_parent_name}}" >
                                        <a class="nav-link" href="{{url($parentMenu->menu_parent_url)}}">
                                            <i class="{{$parentMenu->menu_parent_icon}}"></i>
                                            <span data-i18n="{{$parentMenu->menu_parent_name}}">{{$parentMenu->menu_parent_name}}</span>
                                        </a>
                                    </li>
                               @endif
                           @endif
                        @endforeach
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
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2" id="breadcumbs" hidden>
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">@yield('breadcumb')</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    {{-- <li class="breadcrumb-item"><a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Content</a>
                                    </li>
                                    <li class="breadcrumb-item active">Helper Classes
                                    </li> --}}
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Dashboard Analytics Start -->
                <section id="dashboard-analytics">
                    <div class="row">
                        <div class="col">
                            @yield('content')
                        </div>
                    </div>
                </section>
                <!-- Dashboard Analytics end -->
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    {{-- <footer class="footer footer-static footer-light navbar-shadow" aria-disabled="true" >
        <p class="clearfix blue-grey lighten-2 mb-0">
            <span class="float-md-left d-block d-md-inline-block mt-25">
                {{ App\Model\Plugin\PluginVersion::query()->selectRaw('version_name')->where('version_status', '1')->first()->version_name }}
                <a class="text-bold-800 grey darken-2" href="https://www.wipro-unza.co.id/" target="_blank">
                    Wipro Unza
                </a>All rights Reserved
            </span>
            <span class="float-md-right d-none d-md-block">
                <b>Version</b> {{ App\Model\Plugin\PluginVersion::query()->selectRaw('version_code')->where('version_status', '1')->first()->version_code }}
            </span>
            <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="feather icon-arrow-up"></i></button>
        </p>
    </footer> --}}
    <!-- END: Footer-->

    @include('resignation/master/include/scriptFooter')
    <script>
        $(document).ready(function () {
            let path = window.location.pathname
            path = path.substring(1)
            $.ajax({
                type: "get",
                url: "{{url('breadcumAwards')}}",
                data: {
                    path: path
                },
                success: function (response) {
                    let data = response.data;
                    let breadcumb = '<li class="breadcrumb-item"><a href="{{url('/awards')}}">Home</a></li>'
                    if (path != 'awards') {
                        if (data != null) {
                            if (data.menu_parent_name != null) breadcumb += `<li class="breadcrumb-item">${data.menu_parent_name}</li>`
                            if (data.menu_child_name != null) breadcumb += `<li class="breadcrumb-item"><a href="{{url('${data.menu_child_url}')}}">${data.menu_child_name}</a></li>`
                            if (data.menu_grand_child_name != null) breadcumb += `<li class="breadcrumb-item"><a href="{{url('${data.menu_grand_child_url}')}}">${data.menu_grand_child_name}</a></li>`
                        } else {
                            let pathsplit = path.split('/')
                            let parent = minToSpace(pathsplit[0])
                            let child = minToSpace(pathsplit[1])
                            let grand_child = minToSpace(pathsplit[2])
                            if (parent != null) breadcumb += `<li class="breadcrumb-item">${parent}</li>`
                            if (child != null) breadcumb += `<li class="breadcrumb-item"><a href="{{url('${path}')}}">${child}</a></li>`
                            if (grand_child != null) breadcumb += `<li class="breadcrumb-item"><a href="{{url('${path}')}}">${grand_child}</a></li>`
                        }
                        $('.breadcrumb').append(breadcumb);
                        $('#breadcumbs').attr('hidden', false);
                        
                    } else {
                        $('#breadcumbs').attr('hidden', true);
                    }
                    $(`.${data.menu_parent_name}`).addClass('active');
                }
            });
            $('#memory').html(window.performance.memory.totalJSHeapSize / 1000000);
        });

        $(window).on('load', function () {
            setTimeout(function () {
                $('.se-pre-con').fadeOut()
            }, 2000)
        })

        // $(document).ready(function(){
        //   $('nav ul li a').click(function(){
        //     $('li a').removeClass("active");
        //         $(this).addClass("active");
        //     });
        // });

        function minToSpace(data) {
            let words = null;
            if (data != null) {
                words = data.split('-').map(w => w.substring(0, 1).toUpperCase() + w.substring(1)).join(' ');
            }
           return words
        }
    </script>
    @yield('script')

</body>
<!-- END: Body-->
</html>