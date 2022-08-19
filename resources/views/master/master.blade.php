<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>I'am A Wiproite | @yield('title')</title>
    <link rel="shortcut icon" href="{{asset('images/wipro.ico')}}" type="image/x-icon" />
    <link rel="apple-touch-icon" href="{{asset('images/wipro.ico')}}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('master/include/scriptHeader')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
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

        .dropdown-toggle2::after {
            display: inline-block;
            position: absolute;
            width: 0;
            height: 0;
            margin-left: 0.255em;
            vertical-align: 0.255em;
            content: "";
            border-top: 0.3em solid;
            border-right: 0.3em solid transparent;
            border-bottom: 0;
            border-left: 0.3em solid transparent;
        }
        footer {
        background-repeat: no-repeat;
        background-size: cover;
        background-attachment: fixed;
        background-position: left top;
        background-image: url({{ asset('images/footer.png') }});
        }

        .content-wrapper { background: white !important; } /* Adding !important forces the browser to overwrite the default style applied by Bootstrap */
        
        body { 
            padding-top: 50px; 
        }
    </style>
</head>

<body class="hold-transition layout-top-nav text-sm">
    <div class="se-pre-con"></div>
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar fixed-top navbar-expand-md navbar-light navbar-white shadow">
            <div class="container">
                <a href="{{url('/home')}}" class="navbar-brand">
                    <img src="{{asset('images/wipro-logo.png')}}" alt="UNZA VITALIS" width="50" height="40">
                    <span class="brand-text font-weight-light"></span>
                </a>
                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <?php
                    $access = App\Model\UserAccess::where('user_id',Auth::user()->user_id)->first();
                    $menu = App\Model\Menu\Menu::with(['MenuChild.MenuGrandChild'])->orderBy('menu_parent_name','asc')->get();

                    if($access) {
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

                <div class="collapse navbar-collapse order-3" id="navbarCollapse" style="width: 100%;">
                    <ul class="navbar-nav">
                        @foreach($menu as $parent_menu)
                            @if(in_array($parent_menu->menu_parent_id, $parent))
                                @if(count($parent_menu->MenuChild) > 0)
                                    <li class="nav-item dropdown mr-3">
                                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">
                                            <i class="{{ $parent_menu->menu_parent_icon }}"></i> {{ $parent_menu->menu_parent_name }}
                                        </a>
                                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                            @foreach($parent_menu->MenuChild as $child_menu)
                                                @if(in_array($child_menu->menu_child_id, $child) && $child_menu->menu_parent_id == $parent_menu->menu_parent_id)
                                                    @if(count($child_menu->MenuGrandChild ) > 0 )
                                                        <li class="dropdown dropdown-submenu dropdown-hover">
                                                            <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" class="dropdown-item dropdown-toggle2" >
                                                                <i class="{{ $child_menu->menu_child_icon }}"></i> {{ $child_menu->menu_child_name }}
                                                            </a>
                                                            <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                                                                @foreach($child_menu->MenuGrandChild as $grand_child_menu)
                                                                    <li>
                                                                        <a href="{{ url($grand_child_menu->menu_grand_child_url) }}" class="dropdown-item">
                                                                            <i class="{{ $grand_child_menu->menu_grand_child_icon }}"></i> {{ $grand_child_menu->menu_grand_child_name }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <a href="{{ url($child_menu->menu_child_url) }}" class="dropdown-item">
                                                                <i class="{{ $child_menu->menu_child_icon }}"></i> {{ $child_menu->menu_child_name }}
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li class="nav-item mr-3">
                                        <a href="{{ url($parent_menu->menu_parent_url) }}" class="nav-link">
                                            <i class="{{ $parent_menu->menu_parent_icon }}"></i> {{ $parent_menu->menu_parent_name }}
                                        </a>
                                    </li>
                                @endif
                            @endif
                        @endforeach
                    </ul>
                </div>

                <div class="collapse navbar-collapse order-4" id="navbarCollapse2" style="width: 100%;">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class=""><span id="jam"></span></i>
                                <i class="far fa-clock"></i>
                                <i class="fas fa-caret-left"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link  dropdown-toggle"><i class="fas fa-user"></i> User</a>
                            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                <li><a href="{{url('profile')}}" class="dropdown-item">Profile</a></li>
                                <li><a href="{{route('logout')}}" class="dropdown-item">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper ">
            <div style="background-image: url({{ asset('images/header.png') }}); height: 140px; background-repeat: no-repeat; background-size: 100% 100%;"></div>
            <div class="content-header shadow" hidden>
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark" id="title-plugins">@yield('breadcumb')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6 mt-1">
                            <ol class="breadcrumb float-sm-right" id="breadcumb">
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            &nbsp;
            <div class="container container-fluid mt-3">
                <!-- .card -->
                @yield('content')
                <!-- /.card -->
            </div>
        </div>
        <!-- /.content-wrapper -->
         
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        @php
            $version = App\Model\Plugin\PluginVersion::select(['version_name','version_code'])->where('version_status', '1')->first();
        @endphp

        <footer class="main-footer mt-4" style="background-image: url({{ asset('images/footer.png') }}); height: 140px; background-size: 100% 100%; width: 100%; position: absolute;">
            <strong>
                {{ $version->version_name }} <a href="https://www.wipro-unza.co.id/"> Wipro Unza</a>
            </strong> All rights reserved.
            <br/>
            <b>Version</b> {{ $version->version_code }}
            <br/><br/><br/>
            <span>Page loaded : <span id="load-time"></span> second(s) - Memory Consumed : <span id="memory"></span> Mb</span>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    
    @include('master/include/scriptFooter')
   
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
    <script>
        $(window).on('load', function () {
            // $('.se-pre-con').fadeOut('slow');
            setTimeout(function () {
                $('.se-pre-con').fadeOut()
            }, 2000)
        })

        $(document).ready(function () {
            let path = window.location.pathname
            path = path.substring(1)
            $.ajax({
                type: "get",
                url: "{{url('breadcum')}}",
                data: {
                    path: path
                },
                success: function (response) {
                    let data = response.data;
                    let breadcumb = '<li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>'
                    if (path != 'home') {
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
                        $('#breadcumb').append(breadcumb);
                        $('.content-header').attr('hidden', false);
                    } else {
                        $('.content-header').attr('hidden', true);
                    }
                }
            });

            $('#memory').html(window.performance.memory.totalJSHeapSize / 1000000);
        });

        window.onload = function(){
          setTimeout(function(){
            var t = performance.timing;
            var a = (t.loadEventEnd - t.responseEnd) / 1000;
            $('#load-time').html(a);
          }, 0);
        }

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

</html>
