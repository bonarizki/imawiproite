<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- CSS files -->
<link href="{{ asset('assets_tabler/dist/css/tabler.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets_tabler/dist/libs/fontawesome/css/all.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets_tabler/dist/libs/datatables/datatables.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets_tabler/dist/libs/datatables/extensions/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets_tabler/dist/libs/select2/css/select2.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets_tabler/dist/libs/select2/css/select2-bootstrap4.min.css') }}" rel="stylesheet"/>
{{-- <link href="{{ asset('assets_tabler/dist/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"/> --}}
<link href="{{ asset('assets_tabler/dist/libs/toastr/build/toastr.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets_tabler/dist/libs/daterangepicker/daterangepicker.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets_tabler/dist/libs/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css') }}" rel="stylesheet"/>
<!-- <link href="{{ asset('assets_tabler/dist/css/demo.min.css') }}" rel="stylesheet"/> -->
<style>
    
    body {
    display: none;
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

    .short-text {
        width: 190px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>