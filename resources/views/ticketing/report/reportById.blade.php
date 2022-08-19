<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report PDF</title>
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
    <style>
        .btn-yellow {
            color: black;
            border-color: #fcfc03;
            background-color: #fcfc03;
        }
    </style>
</head>
<body>
    <div class="row pl-1 pr-1">
        <div class="col-9">
            <table class="table table-striped">
                <tr>
                    <td class="table-active" style="width: 30%">Ticket ID</td>
                    <td>{{ $data->ticket_id }}</td>
                </tr>
                <tr>
                    <td class="table-active">Ticket Type</td>
                    <td>{{ $data->Type->type_name }}</td>
                </tr>
                <tr>
                    <td class="table-active">Ticket Request</td>
                    <td>{{ $data->RequestBy->user_name }}</td>
                </tr>
                <tr>
                    <td class="table-active">Ticket Request Date</td>
                    <td>{{ $data->created_at }}</td>
                </tr>
            </table>
        </div>
        <div class="col-3">
            <div class="d-flex justify-content-end">
                @php
                    $ticket_status = $data->ticket_status;
                    $color = '';
                    if ($ticket_status == 'initial' ) {
                        $color = 'primary';
                    }else if($ticket_status == 'process'){
                        $color = 'info';
                    }else if($ticket_status == 'approve'){
                        $color = 'yellow';
                    }else if($ticket_status == 'done'){
                        $color = 'success';
                    }else if($ticket_status == 'reject'){
                        $color = 'danger';
                    }else if($ticket_status == 'cancel'){
                        $color = 'warning';
                    }
                @endphp
                <span class="btn btn-dark pr-1" disabled id="ticket_priority" style="pointer-events: none;">{{ $data->Priority->priority_name }}</span>
                <span class="btn btn-{{ $color }}" id="ticket_status" disabled style="pointer-events: none;">{{ Str::ucfirst($ticket_status) }}</span>
            </div>
        </div>
    </div>
    <hr class="pl-1 pr-1">
    <div class="pl-1 pr-1 mt-1 mb-1">
        <h3>Detail PO</h3>
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="table-active">
                    <th style="width: 20%"><center>Category</center></th>
                    <th style="width: 20%"><center>Nama Barang</center></th>
                    <th style="width: 20%"><center>QTY</center></th>
                    <th style="width: 20%"><center>Harga</center></th>
                    <th style="width: 20%"><center>Total</center></th>
                    <th style="width: 20%"><center>Accept User</center></th>
                </tr>
            </thead>
            <tbody>
                @php $total_harga = 0 @endphp
                @foreach ($data->DetailPo as $item)
                @php
                    $total_harga = $total_harga + ($item->qty * $item->harga)
                @endphp
                <tr>
                    <td>{{ $item->SubCategory != null ? $item->SubCategory->Category->category_name : '' }} - {{ $item->SubCategory != null ? $item->SubCategory->sub_category_name : ''}}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>Rp. {{number_format($item->harga,2,",",'.')}}</td>
                    <td>Rp. {{number_format($item->harga * $item->qty,2,",",'.')}}</td>
                    <td>{{ $item->accept_user == '1' ? 'Yes' : 'No' }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3">
                        <b>
                            <center>Total</center>
                        </b>
                    </td>
                    <td colspan="3">
                        <b>
                            <center>Rp. {{ number_format($total_harga,2,",",'.') }}</center>
                        </b>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-striped table-bordered">
            <tr>
                <td class="table-active" style="width: 20px">Reason</td>
                <td id="reason" style="white-space: normal;">{{ $data->reason == null ? "-" : $data->reason }}</td>
            </tr>
        </table>
    </div>
    <hr class="pl-1 pr-1">
    <div class="row">
        <div class="col-6">
            <div class="pl-1 pr-1 mt-1 mb-1">
                <h3>Detail Approval Note</h3>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr class="table-active">
                            <th style="width: 20%"><center>Approval User</center></th>
                            <th style="width: 20%"><center>Note</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // @dd($data->approval);
                            $table = "";
                            $approval_data = $data->Approval;
                            $total_approve = 0;
                            for ($i=1; $i <= 6 ; $i++) { 
                                $approval = "ticketing_approval_nik_" . $i;
                                $approval_note = $approval . "_note";
                                $relation = "TicketingApproval". $i;
                                if ($approval_data->$approval_note != null) {
                                    $total_approve++;
                                    $table .= " <tr>
                                                    <td>" . $approval_data->$approval ." - ". $approval_data->$relation->user_name. "</td>
                                                    <td> 
                                                        <span style='word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal;'>
                                                            ". $approval_data->$approval_note ."
                                                        </span>
                                                    </td>
                                                </tr>";
                                }
                            }
                            if ($total_approve == 0) {
                                echo '<tr>
                                            <td colspan="2">
                                                <center>No Data Available</center>
                                            </td>
                                        <tr>';
                            }else{
                                echo $table;
                            }
                        @endphp
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-6">
            <div class="pl-1 pr-1 mt-1 mb-1">
                <h3>Detail File Attach</h3>
                <table class="table table-striped table-bordered" >
                    <thead>
                        <tr id="file_attach" class="table-active">
                            <th style="width: 20%"><b>File Attach Request</b></th>
                        </tr>
                        @php
                            if ($data->file_name_request != null) {
                                $file_request =  explode(',', $data->file_name_request);
                                foreach ($file_request as $file) {
                                    echo " <tr>
                                                <td>
                                                    $file
                                                </td>
                                            </tr>";
                                }
                            }else{
                                echo "<tr>
                                        <td>No File Available</td>
                                    <tr>";
                            }
                            
                        @endphp
                        {{-- <tr class="table-active">
                            <th><b>File Attach Offering</b></th>
                        </tr>
                        <tr id="file_offering">

                        </tr> --}}
                    </thead>
                </table>
            </div>
        </div>
    </div>
    
    <hr class="pl-1 pr-1">
    <div class="pl-1 pr-1 mt-1 mb-1">
        <h3>Detail Approval</h3>
        <table class="table table-striped table-bordered" >
            <thead>
                <tr class="table-active">
                    <th style="width: 12%"><center>Approval Nik 1</center></th>
                    <th style="width: 12%"><center>Approval Nik 2</center></th>
                    <th style="width: 12%"><center>Approval Nik 3</center></th>
                    <th style="width: 12%"><center>Approval Nik 4</center></th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 1; $i <= 4; $i++)
                    <td>
                        @php
                            $approvalRelation = 'TicketingApproval' .$i;
                            $approval = "ticketing_approval_nik_" . $i;
                            $approval_date = $approval . '_date';
                            if ($data->Approval->$approval != null) :
                                $dataApproval = $data->Approval->$approvalRelation;
                                echo "<center>".$data->Approval->$approval."</center>";
                                echo "<center>".$dataApproval->user_name."</center>";
                                if ($data->Approval->$approval_date != null) :
                                    echo '<center><img src="'.public_path('/images/approved.png').'" style="height: 35%;"></center>';
                                    echo '<center>'.$data->Approval->$approval_date.'</center>';
                                else :
                                    echo '<center><i>waiting approval</i></center>';
                                endif;
                            else :
                                echo "<center>-</center>";
                            endif;
                        @endphp
                    </td>
                @endfor
            </tbody>
        </table>
        <table class="table table-striped table-bordered" >
            <thead>
                <tr class="table-active">
                    <th style="width: 12%"><center>Approval Nik 5</center></th>
                    <th style="width: 12%"><center>Approval Nik 6</center></th>
                    <th style="width: 12%"><center>Approval IT 1</center></th>
                    <th style="width: 12%"><center>Approval IT 2</center></th>
                </tr>
            </thead>
            <tbody id="detail-approval-it">
                @for ($i = 5; $i <= 8; $i++)
                    <td>
                        @php
                            if ($i == 7 || $i == 8) {
                                    $string = $i === 7 ? 'it1' : 'it2';
                            }else{
                                $string = $i;
                            }

                            $approvalRelation = 'TicketingApproval' .$string;
                            $approval = "ticketing_approval_nik_" . $string;
                            $approval_date = $approval . '_date';
                            if ($data->Approval->$approval != null) :
                                $dataApproval = $data->Approval->$approvalRelation;
                                echo "<center>".$data->Approval->$approval."</center>";
                                echo "<center>".$dataApproval->user_name."</center>";
                                if ($data->Approval->$approval_date != null) :
                                    echo '<center><img src="'.public_path('/images/approved.png').'" style="height: 35%;"></center>';
                                    echo '<center>'.$data->Approval->$approval_date.'</center>';
                                else :
                                    echo '<center><i>waiting approval</i></center>';
                                endif;
                            else :
                                echo "<center>-</center>";
                            endif;
                        @endphp
                    </td>
                @endfor
            </tbody>
        </table>
    </div>
    {{-- @dd($data) --}}
</body>
</html>