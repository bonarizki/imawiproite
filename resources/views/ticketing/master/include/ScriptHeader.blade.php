<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="shortcut icon" href="{{asset('images/wipro.ico')}}" type="image/x-icon" />
<link rel="apple-touch-icon" href="{{asset('images/wipro.ico')}}">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<!-- Favicon -->
<!-- Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
<!-- Icons -->
<link rel="stylesheet" href="{{asset('assets_argon/vendor/nucleo/css/nucleo.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('assets_argon/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" type="text/css">
{{-- Select 2 --}}
<link rel="stylesheet" href="{{asset('assets_argon/vendor/select2/dist/css/select2.min.css')}}" type="text/css">
<!-- Page plugins -->
<!-- Argon CSS -->
<link rel="stylesheet" href="{{asset('assets_argon/css/argon.min.css?v=1.2.0')}}" type="text/css">

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

    .swal2-container {
        display: -webkit-box;
        display: flex;
        position: fixed;
        z-index: 300000 !important;
    }

    /* .main-content{
        min-height:100vh;
    }


    .footer{
        position: absolute;
        width: 95%;
        bottom: 0;
        height: 0%;
    } */

    .active-navbar
    {
        background: rgb(147, 122, 238) !important;
    }
    
</style>

@yield('header')