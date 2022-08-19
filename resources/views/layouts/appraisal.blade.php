<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-alpha.13
* @link https://tabler.io
* Copyright 2018-2020 The Tabler Authors
* Copyright 2018-2020 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>

    <title>I'M A WIPROITE | Appraisal</title>
    <!-- CSS files -->
    <link href="{{ asset('assets_tabler/dist/css/tabler.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets_tabler/dist/libs/fontawesome/css/all.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets_tabler/dist/libs/datatables/datatables.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets_tabler/dist/libs/datatables/extensions/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets_tabler/dist/libs/select2/css/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets_tabler/dist/libs/select2/css/select2-bootstrap4.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets_tabler/dist/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets_tabler/dist/libs/toastr/build/toastr.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets_tabler/dist/libs/daterangepicker/daterangepicker.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets_tabler/dist/libs/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css') }}" rel="stylesheet"/>
    <!-- <link href="{{ asset('assets_tabler/dist/css/demo.min.css') }}" rel="stylesheet"/> -->

    <!-- Libs JS -->
    <script src="{{ asset('assets_tabler/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets_tabler/dist/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets_tabler/dist/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets_tabler/dist/libs/datatables/extensions/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets_tabler/dist/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets_tabler/dist/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets_tabler/dist/libs/toastr/build/toastr.min.js') }}"></script>
    <script src="{{ asset('assets_tabler/dist/libs/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets_tabler/dist/libs/daterangepicker/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets_tabler/dist/libs/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <script src="{{ asset('assets_tabler/dist/libs/autonumeric/autonumeric.js') }}"></script>
    <!-- Tabler Core -->
    <script src="{{ asset('assets_tabler/dist/js/tabler.min.js') }}"></script>

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
      .page-header {
        margin-bottom: 1rem !important;
      }
      .nav-link-title {
        margin-left: 10px;
      }
      .form-group {
        margin-bottom: 1rem;
      }
      .btn i {
        margin-top: 5px;
      }
    </style>

    @yield('assets-top')

  </head>
  <body class="antialiased">
    <div class="page">
      <div class="se-pre-con"></div>
      <header class="navbar navbar-expand-md navbar-light d-print-none">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h2 class="mb-0">PERFORMANCE APPRAISAL</h2>
          <a href="{{ url('/') }}" class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pr-0 pr-md-3" style="padding-top: 0px; padding-bottom: 3px;">
            <img src="{{ asset('images/wipro-logo.png') }}" style="width: 60px; margin-right: 10px;">
          </a>
          <div class="navbar-nav flex-row order-md-last">

            <div class="nav-item dropdown">
              <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-toggle="dropdown">
                <span class="avatar avatar-sm">
                  <i class="fa fa-user"></i>
                </span>
                <div class="d-none d-xl-block pl-2">
                  <div>{{ Auth::user()->user_name }}</div>
                  <div class="mt-1 small text-muted">{{ App\Model\Title::where('title_id', Auth::user()->title_id)->first()->title_name }}</div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                <a href="{{ url('/home') }}" class="dropdown-item">Back To Home</a>
                <div class="dropdown-divider"></div>
                <a href="{{ url('/logout') }}" class="dropdown-item">Logout</a>
              </div>
            </div>
          </div>
        </div>
      </header>
      <div class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
          <div class="navbar navbar-light">
            <div class="container-fluid">
              <ul class="navbar-nav">

                <?php
                  $all_parent = App\Model\Appraisal\MenuParent::all();
                  $all_child = App\Model\Appraisal\MenuChild::all();
                  $all_grand_child = App\Model\Appraisal\MenuGrandChild::all();

                  $access_exist = App\Model\Appraisal\Access::where('user_id', Auth::user()->user_id)->exists();
                  if($access_exist) {
                    $access = App\Model\Appraisal\Access::where('user_id', Auth::user()->user_id)->first();
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
                    @if(App\Model\Appraisal\MenuChild::where('menu_parent_id', $ap->menu_parent_id)->exists())
                      <li class="nav-item dropdown nav-{{ strtolower(str_replace(' ', '_', $ap->menu_parent_name)) }}">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                          <i class="{{ $ap->menu_parent_icon }}"></i>
                          <span class="nav-link-title">{{ $ap->menu_parent_name }}</span>
                        </a>
                        <div class="dropdown-menu">
                          @foreach($all_child as $ac)
                            @if(in_array($ac->menu_child_id, $child) && $ac->menu_parent_id == $ap->menu_parent_id)
                              @if(App\Model\Appraisal\MenuGrandChild::where('menu_child_id', $ac->menu_child_id)->exists())
                                <div class="dropright">
                                  <a href="#" class="dropdown-item dropdown-toggle nav-{{ strtolower(str_replace(' ', '_', $ac->menu_child_name)) }}" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <i class="{{ $ac->menu_child_icon }}"></i>
                                    <span class="nav-link-title">{{ $ac->menu_child_name }}</span>
                                  </a>
                                  <div class="dropdown-menu">
                                    @foreach($all_grand_child as $agc)
                                      @if(in_array($agc->menu_grand_child_id, $grand_child) && $agc->menu_child_id == $ac->menu_child_id)
                                        <a href="{{ url($agc->menu_grand_child_url) }}" class="dropdown-item nav-{{ strtolower(str_replace(' ', '_', $agc->menu_grand_child_name)) }}">
                                          <i class="{{ $agc->menu_grand_child_icon }}"></i>
                                          <span class="nav-link-title">{{ $agc->menu_grand_child_name }}</span>
                                        </a>
                                      @endif
                                    @endforeach
                                  </div>
                                </div>
                              @else
                                <a href="{{ url($ac->menu_child_url) }}" class="dropdown-item nav-{{ strtolower(str_replace(' ', '_', $ac->menu_child_name)) }}">
                                  <i class="{{ $ac->menu_child_icon }}"></i>
                                  <span class="nav-link-title">{{ $ac->menu_child_name }}</span>
                                </a>
                              @endif
                            @endif
                          @endforeach
                        </div>
                      </li>
                    @else
                      <li class="nav-item nav-{{ strtolower(str_replace(' ', '_', $ap->menu_parent_name)) }}">
                        <a href="{{ url($ap->menu_parent_url) }}" class="nav-link">
                          <i class="{{ $ap->menu_parent_icon }}"></i>
                          <span class="nav-link-title">{{ $ap->menu_parent_name }}</span>
                        </a>
                      </li>
                    @endif
                  @endif
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="content mt-2">

        @yield('content')

      </div>
    </div>



    <script type="text/javascript">

      $(window).on('load', function() {
        $('.se-pre-con').fadeOut('slow');
      });

    </script>

    @yield('assets-bottom')

  </body>
</html>
