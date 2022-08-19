<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Training Request</title>
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
        <table width="100%">
            <tr>
                <td>Training Topic</td>
                <td>:</td>
                <td>{{$data->training_topic}}</td>
            </tr>
            <tr>
                <td>Instructor</td>
                <td>:</td>
                <td>
                    @if ($data->Vendor != null)
                        {{$data->Vendor->vendor_name}}
                    @else
                        Vendor not set
                    @endif
                </td>
            </tr>
            <tr>
                <td>Training Fee</td>
                <td>:</td>
                <td>Rp. {{number_format($data->training_fee,2,",",'.')}}</td>
            </tr>
            <tr>
                <td>Training Participant</td>
                <td>:</td>
                <td>{{$data->training_participants}}</td>
            </tr>
            @if ($data->training_fee >= 5000000)
                <tr>
                    <td>Service Bond</td>
                    <td>:</td>
                    <td>
                        @php
                            $training_fee = round($data->training_fee / $data->training_participants);
                        @endphp
                        @if ($training_fee >= 10000000 && $training_fee <= 15999999)
                            service bond 18 (Eighteen) months.
                        @elseif($training_fee >= 16000000 && $training_fee <= 25000000)
                            servicebond for 30 (thirty) months.
                        @elseif($training_fee > 25000000)
                            servicebond for 36 (thirty six) months.
                        @endif
                    </td>
                </tr>
            @endif
            <tr>
                <td>Training Category</td>
                <td>:</td>
                <td>
                    @if ($data->Category == null)
                        Category Not Set
                    @else
                        {{$data->Category->category_name}}
                    @endif
                </td>
            </tr>
            <tr>
                <td class="align-top" >Training Purpose</td>
                <td class="align-top" >:</td>
                <td style="width:500px" >
                    {{$data->training_purpose}}
                </td>
            </tr>
        </table>
        <hr>
        <h1 class="text-center mb-1">Detail Participants</h1>
        <table class="table table-striped table-bordered" style="border: 1px solid black;">
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
        </table>
        <hr>
        <h1 class="text-center mb-1">Detail Approval</h1>
        <table class="table table-bordered shadow" style="border: 1px solid black;">
            <thead>
                <tr class="table-active">
                    <th style="width: 16%"><center>Approval Nik 1</center></th>
                    <th style="width: 16%"><center>Approval Nik 2</center></th>
                    <th style="width: 16%"><center>Approval Nik 3</center></th>
                    <th style="width: 16%"><center>Approval Nik 4</center></th>
                    
                </tr>
            </thead>
            <tbody>
                <tr>
                    @for ($i = 1; $i <= 4; $i++)
                        <td>
                            @php
                                $approval = "training_approval_nik_" . $i;
                                $approval_date = $approval . '_date';
                                if ($data->TrainingApproval->$approval != null) :
                                    $dataApproval = App\Repository\Dashboard\User\UserRepository::getUserByNik($data->TrainingApproval->$approval);
                                    echo "<center>".$data->TrainingApproval->$approval."</center>";
                                    echo "<center>".$dataApproval->user_name."</center>";
                                    if ($data->TrainingApproval->$approval_date != null) :
                                        echo '<center><img src="'.public_path('/images/approved.png').'" style="height: 35%;"></center>';
                                        echo '<center>'.date_format(date_create($data->TrainingApproval->$approval_date), "d-m-Y").'</center>';
                                    else :
                                        echo '<center><i>waiting approval</i></center>';
                                    endif;
                                else :
                                    echo "<center>-</center>";
                                endif;
                            @endphp
                        </td>
                    @endfor
                </tr>
            </tbody>
        </table>
        <table class="table table-bordered" style="border: 1px solid black;">
            <thead>
                <tr class="table-active">
                    <th style="width: 16%"><center>Approval Nik 5</center></th>
                    <th style="width: 16%"><center>Approval Nik 6</center></th>
                    <th style="width: 16%"><center>Approval Nik CEO</center></th>
                    <th style="width: 16%"><center>Approval Nik HR</center></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @for ($i = 5; $i <= 8; $i++)
                        <td>
                            @php
                                if ($i == 7 || $i == 8) {
                                    $string = $i === 7 ? 'ceo' : 'hr';
                                }else{
                                    $string = $i;
                                }
                                $approval = "training_approval_nik_" . $string;
                                $approval_date = $approval . '_date';
                                if ($data->TrainingApproval->$approval != null) :
                                    $dataApproval = App\Repository\Dashboard\User\UserRepository::getUserByNik($data->TrainingApproval->$approval);
                                    echo "<center>".$data->TrainingApproval->$approval."</center>";
                                    echo "<center>".$dataApproval->user_name."</center>";
                                    if ($data->TrainingApproval->$approval_date != null ) :
                                        echo '<center><img src="'.public_path('/images/approved.png').'" style="height: 35%;"></center>';
                                        echo '<center>'.date_format(date_create($data->resign_approval_nik_clearance_it_date), "d M Y").'</center>';
                                    else :
                                        echo '<center><i>waiting approval</i></center>';
                                    endif;
                                else :
                                    echo "<center>-</center>";
                                endif;
                            @endphp
                        </td>
                    @endfor
                </tr>
            </tbody>
        </table>
    </div>
    {{-- @dd($data) --}}
</body>
</html>