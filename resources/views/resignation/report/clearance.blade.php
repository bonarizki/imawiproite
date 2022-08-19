<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Clearance</title>
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

<body style="background-color:white;">
    {{-- <div align="center">
        <h5><b>Check List of Resignation Form</b></h5>
    </div> --}}
    <div align="left" style="padding-left: 30px;
                            font-size: 17px;
                            padding-top: 10px;
                            font-color: black;">
        <table>
            <tr>
                <td>Nama</td>
                <td> &nbsp; :</td>
                <td>&nbsp; {{$data->User->user_name}}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>&nbsp; :</td>
                <td>&nbsp; {{$data->User->Title->title_name}}</td>
            </tr>
            <tr>
                <td>Tanggal Masuk Kerja</td>
                <td>&nbsp; :</td>
                <td>&nbsp; {{$data->User->user_join_date}}</td>
            </tr>
            <tr>
                <td>Tanggal Keluar Kerja</td>
                <td>&nbsp; :</td>
                <td>&nbsp;  {{$data->resign_date}}</td>
            </tr>
            <tr>
                <td>Department</td>
                <td>&nbsp; :</td>
                <td>&nbsp; {{$data->User->Department->department_name}}</td>
            </tr>
        </table>
    </div>
    <div align="left" style="padding-left: 30px;
                            font-size:15px;
                            padding-top: 20px">
        <p>Silahkan berikan tanda &#10004; sebagai tanda bahwa fasilitas dibawah ini telah dikembalikan kepada PT Unza Vitalis.</p>
    </div>
    <div style="padding-left: 30px;
                font-size:17px;
                padding-top: 5px">
        <table style="width:100%">
        @foreach ($question as $item)
        <tr>
            <td style="width:144px">{{$item->clearance_question_name}}</td>
            <td style="width:144px"><input type="checkbox" {{ App\Http\Controllers\Resignation\ReportContorller::ValidationChecked($item->clearance_question_id.'-sudah',$answer)}}> Sudah </td>
            <td style="width:144px"><input type="checkbox" {{ App\Http\Controllers\Resignation\ReportContorller::ValidationChecked($item->clearance_question_id.'-belum',$answer)}}> Belum</td>
            <td style="width:144px"><input type="checkbox" {{ App\Http\Controllers\Resignation\ReportContorller::ValidationChecked($item->clearance_question_id.'-tidak_relevan',$answer)}}> Tidak Relevan</td>
        </tr>
        @endforeach
        </table>
    </div>
    <div style="padding-left: 30px;
                font-size:17px;
                padding-top: 20px">
        <p><b>Serah Terima Pekerjaan, kepada</b></p>
        <table>
            <tr>
                <td  style="width:144px">Nama/Nik</td>
                <td>&nbsp; :</td>
                @php
                    $handover = App\Repository\Dashboard\User\UserRepository::getUserByNik($data->resign_handover_nik);
                @endphp
                <td>{{ $handover->user_name .' - '. $handover->user_nik}}</td>
            </tr>
            <tr>
                <td  style="width:144px">Jabatan</td>
                <td>&nbsp; :</td>
                <td>{{ $handover->Title->title_name}}</td>
            </tr>
            <tr>
                <td  style="width:144px">Status</td>
                <td style="width: 100px"><input type="checkbox" {{ $data->resign_handover_status == 'sudah' ? "checked" : '' }}> Sudah</td>
                <td><input type="checkbox" {{ $data->resign_handover_status == 'belum' ? "checked" : '' }}> Belum</td>
            </tr>
        </table>
    </div>
    <div style="padding-left: 30px;
                font-size:17px;
                padding-top: 20px;
                padding-right: 30px;">
        <p>Bersama ini dinyatakan bahwa Karyawan tersebut diatas telah menyelesaikan tangung jawabnya, dan oleh karena itu dapat segera diberikan haknya:</p>
    </div>
    <div style="padding-left: 30px;
                font-size:17px;
                padding-top: 20px;
                padding-right: 30px;">
        <table class="table table-striped">
            <tr>
                <th><center>IT Dept.</center></th>
                <th><center>HR&GA Dept</center></th>
                <th><center>F&A Dept</center></th>
            </tr>
            <tr>
                <td>
                    <center><img src="{{ public_path('/images/approved.png') }}" style="height: 35%;"></center>
                    <center>{{$data->resign_approval_nik_clearance_it}}</center>
                    <center>{{$data_approval->approval_name_it}}</center>
                    <center>{{date_format(date_create($data->resign_approval_nik_clearance_it_date), "d M Y")}}</center>
                </td>
                <td>
                    <center><img src="{{ public_path('/images/approved.png') }}" style="height: 35%;"></center>
                    <center>{{$data->resign_approval_nik_clearance_hr}}</center>
                    <center>{{$data_approval->approval_name_hr}}</center>
                    <center>{{date_format(date_create($data->resign_approval_nik_clearance_hr_date), "d M Y")}}</center>
                </td>
                <td>
                    <center><img src="{{ public_path('/images/approved.png') }}" style="height: 35%;"></center>
                    <center>{{$data->resign_approval_nik_clearance_fa}}</center>
                    <center>{{$data_approval->approval_name_fa}}</center>
                    <center>{{date_format(date_create($data->resign_approval_nik_clearance_fa_date), "d M Y")}}</center>
                </td>
            </tr>
        </table>

    </div>
    @include('resignation/master/include/scriptFooter')
</body>

</html>