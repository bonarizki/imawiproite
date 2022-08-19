<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Vendor</title>
    <link href="{{ public_path('/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets_vuexy/app-assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets_vuexy/app-assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets_vuexy/app-assets/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets_vuexy/app-assets/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets_vuexy/app-assets/css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets_vuexy/app-assets/css/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"href="{{asset('assets_vuexy/app-assets/css/core/menu/menu-types/horizontal-menu.css')}}">
    <link rel="stylesheet" type="text/css"href="{{asset('assets_vuexy/app-assets/css/core/colors/palette-gradient.css')}}">
    <link rel="stylesheet" type="text/css"href="{{asset('assets_vuexy/app-assets/css/pages/dashboard-analytics.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets_vuexy/app-assets/css/pages/card-analytics.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets_vuexy/app-assets/css/plugins/tour/tour.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets_vuexy/assets/css/style.css')}}">
    <!-- END: Custom CSS-->
</head>
<body class="bg-white">
    <div style="padding-left: 30px;
        font-size: 17px;
        padding-top: 10px;
        font-color: black;
        padding-right: 30px;"
    >
        <h1 class="text-center mb-1">Detail Vendor</h1>
        <table width="100%" class="table">
            <tr>
                <td style=" width: 25%;"><b>Vendor Name</b></td>
                <td style=" width: 2%;">:</td>
                <td><b>{{ucwords($detail->vendor_name)}}</b></td>
            </tr>
            <tr>
                <td style=" width: 25%;"><b>Vendor Type</b></td>
                <td style=" width: 2%;">:</td>
                <td><b>{{ucwords($detail->vendor_type)}}</b></td>
            </tr>
            <tr>
                <td style=" width: 25%;"><b>Vendor SIUP</b></td>
                <td style=" width: 2%;">:</td>
                <td><b>{{$detail->vendor_siup == null ? '-' : ucwords($detail->vendor_siup)}}</b></td>
            </tr>
            <tr>
                <td style=" width: 25%;"><b>Vendor NPWP</b></td>
                <td style=" width: 2%;">:</td>
                <td><b>{{$detail->vendor_npwp == null ? '-' : ucwords($detail->vendor_npwp)}}</b></td>
            </tr>
            <tr>
                <td style=" width: 25%;"><b>Vendor TDP</b></td>
                <td style=" width: 2%;">:</td>
                <td><b>{{$detail->vendor_tdp == null ? '-' : ucwords($detail->vendor_tdp)}}</b></td>
            </tr>
            <tr>
                <td style=" width: 25%;"><b>Vendor Bank Name</b></td>
                <td style=" width: 2%;">:</td>
                <td><b>{{ucwords($detail->vendor_bank_name)}}</b></td>
            </tr>
            <tr>
                <td style=" width: 25%;"><b>Vendor Bank Number</b></td>
                <td style=" width: 2%;">:</td>
                <td><b>{{ucwords($detail->vendor_bank_number)}}</b></td>
            </tr>
            
        </table>
        <hr>
        <h1 class="text-center mb-1">Lampiran</h1>
        @if ($detail->vendor_siup_image != null)
            <div class="pt-3" style="page-break-inside: avoid;">
                <h2>Vendor SIUP Image</h2>
                <img src="{{asset('file_uploads/images/vendor_data')}}/{{$detail->vendor_siup_image}}" alt="">
            </div>
        @endif
        @if ($detail->vendor_tdp_image != null)
            <div class="pt-3" style="page-break-inside: avoid;">
                <h2>Vendor TDP Image</h2>
                <img src="{{asset('file_uploads/images/vendor_data')}}/{{$detail->vendor_tdp_image}}" alt="">
            </div>
        @endif
        @if ($detail->vendor_npwp_image != null)
            <div class="pt-3" style="page-break-inside: avoid;">
                <h2>Vendor NPWP Image</h2>
                <img src="{{asset('file_uploads/images/vendor_data')}}/{{$detail->vendor_npwp_image}}" alt="">
            </div>
        @endif
        @if ($detail->vendor_bank_image != null)
            <div class="pt-3" style="page-break-inside: avoid;">
                <h2>Vendor Bank Image</h2>
                <img src="{{asset('file_uploads/images/vendor_data')}}/{{$detail->vendor_bank_image}}" alt="">
            </div>
        @endif
        
        {{-- <table class="table table-striped table-bordered" style="border: 1px solid black;">
            <thead>
                <tr class="table-active">
                    <th style="width: 25%"><center>User Nik	</center></th>
                    <th style="width: 25%"><center>Approval Nik 2</center></th>
                    <th style="width: 25%"><center>Department</center></th>
                    <th style="width: 25%"><center>Cost Training</center></th>
                </tr>
            </thead>
            <tbody>
                @if (count($data->Participant) != 0)
                    @foreach ( $data->Participant as $participant)
                        <tr>
                            <td>{{$participant->training_user_nik}}</td>
                            <td>{{$participant->User->user_name}}</td>
                            <td>{{$participant->User->Department->department_name}}</td>
                            <td>
                                Rp. 
                                {{
                                    number_format(round($data->training_fee / $data->training_participants),'2',",",".")
                                }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table> --}}
        
    </div>
    {{-- @dd($data) --}}
</body>
</html>