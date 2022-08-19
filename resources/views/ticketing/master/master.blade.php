<!--
=========================================================
* Argon Dashboard - v1.2.0
=========================================================
* Product Page: https://www.creative-tim.com/product/argon-dashboard


* Copyright  Creative Tim (http://www.creative-tim.com)
* Coded by www.creative-tim.com



=========================================================
* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html>

<head>
  <title>I'am A Wiproite | Ticketing - @yield('title')</title>
  @include('ticketing/master/include/ScriptHeader')
</head>

<body>
    <!-- Sidenav -->
    <div class="se-pre-con"></div>
    <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
        <div class="scrollbar-inner">
            <!-- Brand -->
            <div class="sidenav-header  d-flex  align-items-center">
                <a class="navbar-brand">
                   <h1 class="text-primary">TICKETING</h1>
                </a>
                <div class=" ml-auto ">
                    <!-- Sidenav toggler -->
                    <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin"
                        data-target="#sidenav-main">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar-inner">
                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <!-- Nav items -->
                    <ul class="navbar-nav">
                        @php
                            $allMenu = App\Model\Ticketing\Menu\Menu::with(['MenuChild','MenuChild.MenuGrandChild'])->get();
                            $access = App\Model\Ticketing\Access::where('user_id', Auth::user()->user_id)->first();
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
                                        <li class="dropdown nav-item parent-{{$parentMenu->menu_parent_id}}" data-menu="dropdown">
                                            <a class="nav-link collapsed" href="#parent-{{$parentMenu->menu_parent_id}}" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="parent-{{$parentMenu->menu_parent_id}}">
                                                <i class="{{$parentMenu->menu_parent_icon}}"></i>
                                                <span class="nav-link-text">{{$parentMenu->menu_parent_name}}</span>
                                            </a>
                                            <div class="collapse" id="parent-{{$parentMenu->menu_parent_id}}" style="background: white">
                                                <ul class="nav nav-sm flex-column">
                                                    @foreach ($parentMenu->MenuChild as $menuChild)
                                                        @foreach ($child as $accessChild)
                                                            @if ($menuChild->menu_child_id == $accessChild )
                                                                @if (count($menuChild->MenuGrandChild)>0)
                                                                    <li class="nav-item">
                                                                        <a href="#child-{{$menuChild->menu_child_id}}" class="nav-link" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-multilevel">
                                                                            <span class="sidenav-mini-icon"> {{$menuChild->menu_child_icon}} </span>
                                                                            <span class="sidenav-normal">
                                                                                <i class="{{$menuChild->menu_child_icon}}"></i>
                                                                                {{$menuChild->menu_child_name}}
                                                                            </span>
                                                                        </a>
                                                                        <div class="collapse show" id="child-{{$menuChild->menu_child_id}}"
                                                                            style="">
                                                                            <ul class="nav nav-sm flex-column">
                                                                                @foreach ( $menuChild->MenuGrandChild as $menuGrandChild)
                                                                                    @foreach ($grand_child as $accessGrandChild)
                                                                                        @if ($menuGrandChild->menu_grand_child_id == $accessGrandChild)
                                                                                            <li class="nav-item">
                                                                                                <a href="{{url($menuGrandChild->menu_grand_child_icon)}}" class="nav-link ">
                                                                                                    {{$menuGrandChild->menu_grand_child_name}}
                                                                                                </a>
                                                                                            </li>
                                                                                        @endif
                                                                                    @endforeach
                                                                                @endforeach
                                                                                
                                                                            </ul>
                                                                        </div>
                                                                    </li>
                                                                @else
                                                                    <li class="nav-item child-{{ $menuChild->menu_child_id }}">
                                                                        <a href="{{url($menuChild->menu_child_url)}}" class="nav-link">
                                                                            <span class="sidenav-mini-icon">
                                                                                <i class="{{$menuChild->menu_child_icon}}"></i>
                                                                            </span>
                                                                            <span class="sidenav-normal"> 
                                                                                <i class="{{$menuChild->menu_child_icon}}"></i>
                                                                                {{$menuChild->menu_child_name}} 
                                                                            </span>
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>
                                    @else
                                        <li class="nav-item parent-{{$parentMenu->menu_parent_id}}" >
                                            <a class="nav-link" href="{{url($parentMenu->menu_parent_url)}}">
                                                <i class="{{$parentMenu->menu_parent_icon}}"></i>
                                                <span data-i18n="{{$parentMenu->menu_parent_name}}" class="nav-link-text">{{$parentMenu->menu_parent_name}}</span>
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
    </nav>
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
        <nav class="navbar navbar-top navbar-expand navbar-light bg-secondary border-bottom">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    
                    <form class="navbar-search navbar-search-transparent form-inline mr-sm-3" id="navbar-search-main">
                        <div class="form-group mb-0">
                            <div class="input-group input-group-alternative input-group-merge">
                                <a href="{{url('/')}}">
                                    <img src="{{asset('images/wipro-logo.png')}}" alt="" height="50px" width="65px">
                                </a>
                            </div>
                        </div>
                    </form>
                   
                            
                    <!-- Navbar links -->
                    <ul class="navbar-nav align-items-center  ml-md-auto ">
                        <li class="nav-item d-xl-none">
                            <!-- Sidenav toggler -->
                            <div class="pr-3 sidenav-toggler sidenav-toggler-light" data-action="sidenav-pin"
                                data-target="#sidenav-main">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item d-sm-none">
                            <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                                <i class="ni ni-zoom-split-in"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class=""><span id="jam"></span></i>
                                <i class="far fa-clock"></i>
                                <i class="fas fa-caret-left"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav align-items-center ml-auto ml-md-0 ">
                        <li class="nav-item dropdown">
                            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <div class="media align-items-center">
                                    <span class="avatar avatar-sm rounded-circle">
                                        @if (Auth::user()->user_sex == 'M')
                                            <img alt="Image placeholder" src="{{asset('img-user/male.png')}}">
                                        @else
                                            <img alt="Image placeholder" src="{{asset('img-user/female.png')}}">
                                        @endif
                                    </span>
                                    <div class="media-body  ml-2  d-none d-lg-block">
                                        <span class="mb-0 text-sm  font-weight-bold">{{Auth::user()->user_name}}</span>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu  dropdown-menu-right ">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome!</h6>
                                </div>
                                <a href="{{url('/')}}" class="dropdown-item">
                                    <i class="ni ni-single-02"></i>
                                    <span>Back To Home</span>
                                </a>
                                <a href="{{url('/profile')}}" class="dropdown-item">
                                    <i class="ni ni-single-02"></i>
                                    <span>My profile</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="{{route('logout')}}" class="dropdown-item">
                                    <i class="ni ni-user-run"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header -->
        <!-- Header -->
        @yield('navigation')
        <div class="header pb-6" >
            <div class="container-fluid" id="breadcumbs">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg">
                            <h6 class="h2 d-inline-block mb-0">@yield('breadcumb')</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links">
                                    {{-- <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="#">Dashboards</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Alternative</li> --}}
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--6">
            
            @yield('content')
            
            @include('ticketing/master/include/footer')
        </div>
    </div>
    <!-- Argon Scripts -->
    @include('ticketing/master/include/ScriptFooter')
</body>

</html>