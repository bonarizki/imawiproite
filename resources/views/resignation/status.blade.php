@extends('resignation/master/master')
@section('breadcumb','Resign Status')
@section('title','Status')

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row" id="filter">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-content">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col form-group">
                                    <label>Periode</label>
                                    <select type="text" class="form-control select2bs4" style="width: 100%" placeholder="Period" id="period_search" name="period_search" >
                                    </select>
                                </div>
                                <div class="col form-group" >
                                    <label>Resign Status</label>
                                    <select type="text" class="form-control select2bs4" style="width: 100%" placeholder="Resign Status" id="resign_status_search" name="resign_status_search" >
                                    </select>
                                </div>
                                <div class="col form-group" >
                                    <label>Department</label>
                                    <select type="text" class="form-control select2bs4" style="width: 100%" placeholder="Department" id="department_search" name="department_search" >
                                        <option value="">Choose</option>
                                    </select>
                                </div>
                                <div class="col form-group">
                                    <label>NIK</label>
                                    <input type="text" class="form-control" style="width: 100%" placeholder="NIK" id="nik_search" name="nik_search" ></input>
                                </div>
                                <div class="col form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" style="width: 100%" placeholder="Name" id="nama_search" name="nama_search" ></input>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-content">
                    <div class="card-body card-dashboard ">
                        <ul class="nav nav-tabs nav-fill" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab-center" data-toggle="tab" href="#proceed" aria-controls="proceed" role="tab" aria-selected="true" onclick="proceed();clearFilter();resignStatusFilter('proceed')">Proceed</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="service-tab-center" data-toggle="tab" href="#service-center" aria-controls="service-center" role="tab" aria-selected="false" onclick="unproceed();clearFilter();resignStatusFilter('unproceed')">Unproceed</a>
                            </li>
                        </ul>
                        <div class="tab-content table-responsive">
                            <div class="tab-pane table-responsive active" id="proceed" aria-labelledby="home-tab-center" role="tabpanel" >
                                <table class="table table-striped table-bordered table-hover" id="table" width="100%">
                                    <thead>
                                        <tr>
                                            <th style=" width: 1px !important;" rowspan="2">#</th>
                                            <th style=" width: 55px !important;" rowspan="2">Nik</th>
                                            <th style=" width: 55px !important;" rowspan="2">Name</th>
                                            <th style=" width: 55px !important;" rowspan="2">Department</th>
                                            <th style=" width: 55px !important;" rowspan="2">Request Date</th>
                                            <th style=" width: 55px !important;" rowspan="2">Resign Date</th>
                                            <th style=" width: 80px !important;" rowspan="2">Reason</th>
                                            <th style=" width: 80px !important;" rowspan="2">Last Approve</th>
                                            <th style=" width: 10px !important;" rowspan="2">Status</th>
                                            <th style=" width: 15px !important;" colspan="6"><center>Action<center></th>
                                        </tr>
                                        <tr>
                                            <th style=" width: 10px !important;">Cancel</th>
                                            <th style=" width: 10px !important;">Feed Back</th>
                                            <th style=" width: 10px !important;">Hand Over</th>
                                            <th style=" width: 10px !important;">Cleareance</th>
                                            <th style=" width: 10px !important;">Reference Letter</th>
                                            <th style=" width: 10px !important;">Edit</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="tab-pane table-responsive" id="service-center" aria-labelledby="service-tab-center" role="tabpanel">
                                <table class="table table-striped table-bordered table-hover" id="table-unproceed" width="100%">
                                    <thead>
                                        <tr>
                                            <th style=" width: 5px !important;">#</th>
                                            <th style=" width: 55px !important;">Nik</th>
                                            <th style=" width: 55px !important;">Name</th>
                                            <th style=" width: 55px !important;">Department</th>
                                            <th style=" width: 55px !important;">Request Date</th>
                                            <th style=" width: 55px !important;">Resign Date</th>
                                            <th style=" width: 80px !important;">Reason</th>
                                            <th style=" width: 80px !important;">Last Approve</th>
                                            <th style=" width: 10px !important;">Status</th>
                                            <th style=" width: 15px !important;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style=" width: 5px !important;">#</th>
                                            <th style=" width: 55px !important;">Nik</th>
                                            <th style=" width: 55px !important;">Name</th>
                                            <th style=" width: 55px !important;">Department</th>
                                            <th style=" width: 55px !important;">Request Date</th>
                                            <th style=" width: 55px !important;">Resign Date</th>
                                            <th style=" width: 80px !important;">Reason</th>
                                            <th style=" width: 80px !important;">Last Approve</th>
                                            <th style=" width: 10px !important;">Status</th>
                                            <th style=" width: 15px !important;">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{--soal feedback dipisah agar tidak kepanjangan--}}
@include('resignation/feedbackQuestion')

{{-- Modal Hand Over --}}
<div class="modal fade text-left" data-backdrop="static" data-keyboard="false" id="modal_handover" role="dialog" >
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title-modal">Form Handover</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-handover">
                    @csrf
                    <div class="row" id="form-body">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="first-name-icon">User Handover Nik</label>
                                <div class="position-relative has-icon-left">
                                    <select type="text" id="user_handover_nik" class="form-control" name="user_handover_nik" placeholder="User Handover Nik" onchange="user_handover_detail()">
                                        
                                    </select>
                                    <div class="form-control-position">
                                        <i class="feather icon-user"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="email-id-icon">User Handover Name</label>
                                <div class="position-relative has-icon-left">
                                    <input type="text" id="user_handover_name" class="form-control" name="user_handover_name" placeholder="User Handover Name" readonly>
                                    <div class="form-control-position">
                                        <i class="feather icon-mail"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="contact-info-icon">User Handover Department</label>
                                <div class="position-relative has-icon-left">
                                    <input type="text" id="user_handover_department" class="form-control" name="user_handover_department" placeholder="User Handover Department" readonly>
                                    <div class="form-control-position">
                                        <i class="feather icon-smartphone"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group" id="user_handover_status">
                                <label for="contact-info-icon">User Handover Status</label>
                                <div class="position-relative has-icon-left">
                                    <ul class="list-unstyled mb-0" style="padding-left: 30px">
                                        <li class="d-inline-block mr-2 ">
                                            <fieldset>
                                                <div class="vs-radio-con vs-radio-primary">
                                                    <input type="radio" name="user_handover_status" value="sudah">
                                                    <span class="vs-radio vs-radio-lg">
                                                        <span class="vs-radio--border"></span>
                                                        <span class="vs-radio--circle"></span>
                                                    </span>
                                                    <span class="">Sudah</span>
                                                </div>
                                            </fieldset>
                                        </li>
                                        <li class="d-inline-block mr-2">
                                            <fieldset>
                                                <div class="vs-radio-con vs-radio-primary">
                                                    <input type="radio" name="user_handover_status" value="belum">
                                                    <span class="vs-radio vs-radio-lg">
                                                        <span class="vs-radio--border"></span>
                                                        <span class="vs-radio--circle"></span>
                                                    </span>
                                                    <span class="">Belum</span>
                                                </div>
                                            </fieldset>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="button-modal" >Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false" style="display: none;" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Resign</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="form form-horizontal" id="formedit">
                @csrf
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <span>Employee Name</span>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="position-relative has-icon-left">
                                            <input type="text" id="user_name" class="form-control" name="user_name" readonly>
                                            <div class="form-control-position">
                                                <i class="feather icon-user"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <span>Request Date</span>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="position-relative has-icon-left">
                                            <input type="text" id="resign_request_date" class="form-control" name="resign_request_date" readonly>
                                            <div class="form-control-position">
                                                <i class="feather icon-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <span>Resign Date</span>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="position-relative has-icon-left">
                                            <input type="text" id="resign_date" class="form-control format-picker" name="resign_date">
                                            <div class="form-control-position">
                                                <i class="feather icon-calendar"></i>
                                            </div>
                                            <small class="text-danger" id="alert-notice"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <span>Resign Reason</span>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="position-relative has-icon-left">
                                            <textarea class="form-control" id="resign_reason" name="resign_reason" rows="3" placeholder="reason"></textarea>
                                            <div class="form-control-position">
                                                <i class="feather icon-align-justify"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <span>Resign User Talent</span>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="position-relative has-icon-left">
                                            <ul class="list-unstyled mb-0">
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <label>
                                                            <input type="radio" name="resign_user_talent" class="resign_user_talent-talent" value="talent">
                                                            Talent
                                                        </label>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <label>
                                                            <input type="radio" name="resign_user_talent" class="resign_user_talent-non-talent" value="non-talent">
                                                            Non - Talent
                                                        </label>
                                                    </fieldset>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <span>Resign User Initation</span>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="position-relative has-icon-left">
                                            <ul class="list-unstyled mb-0">
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <label>
                                                            <input type="radio" name="resign_user_initation" class="resign_user_initation-volunteer" value="volunteer">
                                                            Volunteer
                                                        </label>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <label>
                                                            <input type="radio" name="resign_user_initation" class="resign_user_initation-non-valunteer" value="non-valunteer"> 
                                                            Non - volunteer
                                                        </label>
                                                    </fieldset>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal-edit" onclick="closeModal()">Close</button>
                    <button type="button" class="btn btn-primary" onclick="validasiEdit()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal View Detail Approval --}}
<div class="modal fade text-left" data-backdrop="static" data-keyboard="false" id="modal_detail" role="dialog" >
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title-modal-detail"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table>
                    <tr>
                        <td>Nik</td>
                        <td>:</td>
                        <td id="detail_nik"></td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td id="detail_name"></td>
                    </tr>
                    <tr>
                        <td>Department</td>
                        <td>:</td>
                        <td id="detail_department"></td>
                    </tr>
                    <tr>
                        <td>Title</td>
                        <td>:</td>
                        <td id="detail_title"></td>
                    </tr>
                    <tr>
                        <td>Grade</td>
                        <td>:</td>
                        <td id="detail_grade"></td>
                    </tr>
                    <tr>
                        <td>Resign Request date</td>
                        <td>:</td>
                        <td id="detail_resign_request_date"></td>
                    </tr>
                    <tr>
                        <td>Resign Date</td>
                        <td>:</td>
                        <td id="detail_resign_date"></td>
                    </tr>
                    <tr>
                        <td>Resign Reason</td>
                        <td>:</td>
                        <td id="detail_resign_reason"></td>
                    </tr>
                    <tr>
                        <td>Resign Status</td>
                        <td>:</td>
                        <td id="detail_resign_status"></td>
                    </tr>
                </table>
                <hr>
                <table class="table table-striped" >
                    <thead>
                        <tr>
                            <th style="width: 15%"><center>Approval Nik 1</center></th>
                            <th style="width: 15%"><center>Approval Nik 2</center></th>
                            <th style="width: 15%"><center>Approval Nik 3</center></th>
                            <th style="width: 15%"><center>Approval Nik 4</center></th>
                            <th style="width: 15%"><center>Approval Nik 5</center></th>
                            <th style="width: 15%"><center>Approval Nik 6</center></th>
                            <th style="width: 15%"><center>Approval HR</center></th>
                        </tr>
                    </thead>
                    <tbody id="detail-approval">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <link type="text/css"  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"  rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function () {
            proceed();
            resignStatusFilter('proceed')
            getAllOption();
            setFilterPeriod();
            $('.select2bs4').select2({theme:'bootstrap4'});
            $('.format-picker').datepicker({
                format: 'yyyy-mm-dd',
                orientation: "bottom"
            });
        });

        function chekNik() {
            let array_admin = JSON.parse(JSON.stringify({{\Helper::instance()->checkNIK()}}));
            let nik = "{{Auth::user()->user_nik}}";
            if (array_admin.includes(parseInt(nik))) {
                return true;
            } else {
                return false;
            }
        }

        function clearFilter()
        {
            $('#department_search').val('').select2({theme:'bootstrap4'});
            $('#period_search').val('').select2({theme:'bootstrap4'});
            $('#resign_status_search').val('').select2({theme:'bootstrap4'});
            $('#nik_search').val('');
            $('#nama_search').attr('');
        }

        function resignStatusFilter(type)
        {
            $('#resign_status_search').empty();
            setFilter(type);
        }
        
        function proceed(){
            let url = '';
            if (chekNik() == true) {
                url = "{{url('resignation/statusAll')}}";
            }else{
                url = "{{url('resignation/statusById')}}";
            }
            
            var table = $('#table').DataTable({
                processing: true,
                destroy: true,
                language: {
                    'processing': '<div class="se-pre-con"></div>'
                },
                responsive: true,
                ajax:{
                    url: url,
                    data: {
                        "department_id": $('#department_search').val(),
                        "resign_status": $('#resign_status_search').val(),
                        "period_id": $('#period_search').val(),
                        "user_nik": $('#nik_search').val(),
                        "user_name": $('#nama_search').val()
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "user_nik",
                        name: "user_nik"
                    },
                    {
                        data: "user.user_name",
                        name: "user.user_name"
                    },
                    {
                        data: "user.department.department_name",
                        name: "user.department.department_name"
                    },
                    {
                        data: "resign_request_date",
                        name: "resign_request_date"
                    },
                    {
                        data: "resign_date",
                        name: "resign_date"
                    },
                    {
                        data: "resign_reason",
                        name: "resign_reason"
                    },
                    {
                        data: "resign_status",
                        name: "resign_status",
                        render: function(data, type, row, meta) {
                            if (type === 'display') {
                                let last_approve = getLastApprove(row)
                                if (last_approve != '') {
                                    return last_approve 
                                }else{
                                    return ' - ';
                                }
                            }else{
                                return true;
                            }
                        }
                    },
                    {
                        data: "resign_status",
                        name: "resign_status"
                    },
                    {
                        data: "resign_status",
                        name: "resign_status",
                        render: function (data, type, row, meta) {
                            if (data == 'in progress') {
                                return `<div class="row">
                                            <div class="col">
                                                <button class="btn btn-danger btn-sm btn-block text-nowrap" onclick="event.stopPropagation(); CancelResign('${row.resign_id}')">
                                                    <span class="fa fa-times"></span> <b> Cancel </b>
                                                </button>
                                            </div>
                                        </div>`;
                            } else{
                                return `<div class="row">
                                            <div class="col">
                                                <button class="btn btn-danger btn-sm btn-block text-nowrap" disabled>
                                                    <span class="fa fa-lock"></span>
                                                </button>
                                            </div>
                                        </div>`
                            }
                            
                        }
                    },
                    {
                        data: "resign_status",
                        name: "resign_status",
                        render: function (data, type, row, meta) {
                            if(data == 'approve' && row.feedback == null){
                                return `<button class="btn btn-warning btn-sm btn-block text-nowrap" onclick="event.stopPropagation(); remind('${row.resign_id}')">
                                            <span class="fa fa-bell"></span> <b> Remind </b>
                                        </button>
                                        <button class="btn btn-success btn-sm btn-block text-nowrap" onclick="event.stopPropagation(); feedback('${row.resign_id}')">
                                            <span class="fa fa-reply"></span> <b> Feedback </b>
                                        </button>`;
                            } else if(data == 'approve' && row.feedback != null ){
                                return `<button class="btn btn-warning btn-sm btn-block text-nowrap" onclick="event.stopPropagation(); FeedbackID('${row.resign_id}')">
                                            <span class="fa fa-file-text-o"></span> <b> Feedback </b>
                                        </button>`
                            } else if (data == 'in progress') {
                                return `<div class="row">
                                            <div class="col">
                                                <button class="btn btn-success btn-sm btn-block text-nowrap" disabled>
                                                    <span class="fa fa-lock"></span>
                                                </button>
                                            </div>
                                        </div>`
                            }
                        }
                    },
                    {
                        data: "resign_status",
                        name: "resign_status",
                        render: function (data, type, row, meta) {
                            if(data == 'approve' && row.feedback != null && row.resign_handover_nik == null){
                                return `<button class="btn btn-primary btn-sm btn-block text-nowrap" onclick="event.stopPropagation(); handover('${row.resign_id}')">
                                            <span class="fa fa-tasks"></span> <b> Hand Over </b>
                                        </button>`
                            } else{
                                return `<div class="row">
                                            <div class="col">
                                                <button class="btn btn-primary btn-sm btn-block text-nowrap" disabled>
                                                    <span class="fa fa-lock"></span>
                                                </button>
                                            </div>
                                        </div>`
                            }
                            
                        }
                    },
                    {
                        data: "resign_status",
                        name: "resign_status",
                        render: function (data, type, row, meta) {
                            if(data == 'approve' && row.feedback != null && row.resign_clearance_status == "approve"){
                                return `<button class="btn btn-success btn-sm btn-block text-nowrap" onclick="event.stopPropagation(); Clearance('${row.resign_id}')">
                                            <span class="fa fa-file-text-o"></span> <b> Clearance </b>
                                        </button>`;
                            }else{
                                return `Waiting For Approval Clearance`;
                            }
                            
                        }
                    },
                    {
                        data: "resign_status",
                        name: "resign_status",
                        render: function (data, type, row, meta) {
                            if(data == 'approve' && row.feedback != null && row.resign_clearance_status == "approve"){
                                return `<button class="btn btn-secondary btn-sm btn-block text-nowrap" onclick="event.stopPropagation(); parklaring('${row.resign_id}')">
                                            <span class="fa fa-file-text-o"></span> <b> Reference Letter </b>
                                        </button>`;
                            }else{
                                return `<div class="row">
                                            <div class="col">
                                                <button class="btn btn-secondary btn-sm btn-block text-nowrap" disabled>
                                                    <span class="fa fa-lock"></span>
                                                </button>
                                            </div>
                                        </div>`
                            }
                            
                        }
                    },
                    {
                        data: "resign_id",
                        name: "resign_id",
                        render: function (data, type, row, meta) {
                            return `<button class="btn btn-info btn-sm btn-block" onclick="event.stopPropagation();edit('${data}')">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>`
                        }
                    },
                ],
                "columnDefs": [
                    {
                        "targets": 0,
                        "searchable": false,
                        "orderable": false
                    },{
                        "targets": [ 1,2,3,6,14],
                        "visible": chekNik(),
                        "searchable": true
                    }
                ]
            });

            $('#table tbody').on('click', 'tr', function () {
                var data = table.row(this).data();
                if (data != null) viewDetailResign(data.resign_id);
            } );
        }

        function viewDetailResign(resign_id) {
            $('#detail-approval').empty()
            $.ajax({
                type: "get",
                url: "{{url('resignation/detail')}}",
                data : {
                    resign_id : resign_id
                },
                success: (response) => {
                    $('#title-modal-detail').text(`Detail Resign ${resign_id}`);
                    $('#modal_detail').modal('show');
                    let data = response.data.data;
                    $('#detail_nik').text(data.user_nik);
                    $('#detail_name').text(data.user.user_name);
                    $('#detail_title').text(data.user.title.title_name);
                    $('#detail_grade').text(`${data.user.grade.grade_group.grade_group_name} - ${data.user.grade.grade_name}`);
                    $('#detail_department').text(data.user.department.department_name);
                    $('#detail_resign_request_date').text(data.resign_request_date);
                    $('#detail_resign_date').text(data.resign_date);
                    $('#detail_resign_reason').text(data.resign_reason);
                    $('#detail_resign_status').text(data.resign_status);
                    let detaildata = detailApproval(data);
                    $('#detail-approval').append(detaildata)
                },
            })
        }
        
        function detailApproval(data){
            let detailTableApproval = '<tr>'
            for (let index = 1; index <= 7; index++) {
                let approval_nik = 'resign_approval_nik';
                let nik_str = index == 7 ? 'hr' : index;
                let resign_approval = 'resign_approval' + nik_str;
                approval_nik += `_${nik_str}`
                detailTableApproval += '<td>'
                if (data[approval_nik] != null) {
                    let detailApprover = data[resign_approval].user_name;
                    detailTableApproval += `<center>${data[approval_nik]}</center>
                                            <center>${detailApprover}</center>`;
                    if (data[approval_nik + '_date'] == null ) {
                        detailTableApproval += `<center> <i> waiting approval </i> </center>`
                    }else{
                        let date = data[approval_nik + '_date'].split(' ');
                        detailTableApproval += `<center><img src="{{ asset('/images/approved.png') }}" style="height: 50px;"></center>
                                                <center>${date[0]}</center>`
                    }
                }else{
                    detailTableApproval += '<center> - </center>'
                }
                detailTableApproval += '</td>'
            }
            detailTableApproval += '</tr>'
            return detailTableApproval;
        }

        function getLastApprove(row) {
            let last_approve = '';
            for (let index = 1; index <= 7; index++) {
                let string = index == 7 ? 'hr' : index;
                let approval_nik = 'resign_approval_nik';
                let object_name = `resign_approval`; //relationshipmodel
                approval_nik += `_${string}`
                if (row[approval_nik] != null && row[approval_nik + '_date'] != null) {
                    last_approve = `${row[approval_nik]} - ${row[object_name += string].user_name}` 
                }
            }
            return last_approve;
        }

        function unproceed() {
            $('#resign_status_search').empty();
            let url = '';
            if (chekNik() == true) {
                url = "{{url('resignation/statusAll/unproceed')}}";
            }else{
                url = "{{url('resignation/statusById/unproceed')}}";
            }
            setFilter('unproceed');
            $('#table-unproceed').DataTable({
                serverSide: true,
                processing: false,
                destroy: true,
                ajax:{
                    url: url,
                    data: {
                        "department_id": $('#department_search').val(),
                        "resign_status": $('#resign_status_search').val(),
                        "period_id": $('#period_search').val(),
                        "user_nik": $('#nik_search').val(),
                        "user_name": $('#nama_search').val()
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "user_nik",
                        name: "user_nik"
                    },
                    {
                        data: "user.user_name",
                        name: "user.user_name"
                    },
                    {
                        data: "user.department.department_name",
                        name: "user.department.department_name"
                    },
                    {
                        data: "resign_request_date",
                        name: "resign_request_date"
                    },
                    {
                        data: "resign_date",
                        name: "resign_date"
                    },
                    {
                        data: "resign_reason",
                        name: "resign_reason"
                    },
                    {
                        data: "resign_status",
                        name: "resign_status",
                        render: function(data, type, row, meta) {
                            let last_approve = getLastApprove(row)
                            if (last_approve != '') {
                                return last_approve;
                            }else{
                                return ' - ';
                            }
                        }
                    },
                    {
                        data: "resign_status",
                        name: "resign_status"
                    },
                    {
                        data: "resign_status",
                        name: "resign_status",
                        render: function (data, type, row, meta) {
                            if(data == 'approve' && row.feedback != null && row.resign_clearance_status == "approve"){
                                return `<div class="row">
                                            <div class="col mb-1">
                                                <button class="btn btn-info btn-sm" onclick="event.stopPropagation();parklaring('${row.resign_id}')">
                                                    <span class="fa fa-file-text-o"></span> Reference Letter
                                                </button>
                                            </div>
                                            <div class="col">
                                                <button class="btn btn-success btn-sm" onclick="event.stopPropagation();Clearance('${row.resign_id}')">
                                                    <span class="fa fa-file-text-o"></span> Clearance
                                                </button>
                                            </div>
                                            <div class="col">
                                                <button class="btn btn-warning btn-sm" onclick="event.stopPropagation();FeedbackID('${row.resign_id}')">
                                                    <span class="fa fa-file-text-o"></span> Feedback
                                                </button>
                                            </div>
                                        </div>`;
                            } else if (data == 'cancel' || data == 'reject') {
                                return 'No Action'
                            }
                        }
                    },
                ],
                "columnDefs": [
                    {
                        "targets": 0,
                        "searchable": false,
                        "orderable": false
                    },{
                        "targets": [ 1,2,3,6 ],
                        "visible": chekNik(),
                        "searchable": false
                    }
                ]
            });
        }

        function setFilter(type){
            $('#department_search').attr('onchange',`${type}()`)
            $('#resign_status_search').attr('onchange',`${type}()`)
            $('#period_search').attr('onchange',`${type}()`)
            $('#nik_search').attr('onkeyup',`${type}()`)
            $('#nama_search').attr('onkeyup',`${type}()`)
            let optionFilter = '<option value="">Choose</option>';
            if(type == 'proceed'){
                optionFilter += `<option value="in progress">In Progress</option>
                                 <option value="approve">Approve</option>`;
            }else{
                optionFilter += `<option value="cancel">Cancel</option>
                                <option value="reject">Reject</option>`;
            }
            $('#resign_status_search').append(optionFilter);
        }

        function handover(id) {
            $('#user_handover_nik').empty();
            $('#form-handover')[0].reset();
            let url = ''
            chekNik() == true 
                ? url = "{{url('resignation/user/department-all')}}"
                : url = "{{url('resignation/user/department')}}"
            $.ajax({
                type: "get",
                url: url,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    let data = response.data.data;
                    let optionNik = '<option value="">Select Nik</option>';
                    for (let index = 0; index < data.length; index++) {
                        optionNik += `<option value="${data[index].user_nik}">
                                        ${data[index].user_nik} - ${data[index].user_name}
                                    </option>`
                    }
                    $('#user_handover_nik').select2({
                        theme: 'bootstrap4'
                    });
                    $('#user_handover_nik').append(optionNik);
                    $('#modal_handover').modal('show');
                    $('#button-modal').attr('onclick', `validasiHandOver('${id}')`)
                }
            })
        }

        edit = (id) => {
            $.ajax({
                type:"get",
                url:"{{url('resignation/detail')}}",
                data:{
                    _token : $('meta[name="csrf-token"]').attr('content'),
                    resign_id : id,
                },
                success:function(response){
                    $('#formedit').append('<input type="text" id="resign_id" class="form-control" name="resign_id" hidden>')
                    let data = response.data.data;
                    resignNotice(data.user.grade.grade_group.grade_group_name);
                    $("#user_name").val(data.user.user_name);
                    $("#resign_id").val(data.resign_id);
                    $("#resign_request_date").val(data.resign_request_date);
                    $("#resign_date").val(data.resign_date);
                    $("#resign_reason").val(data.resign_reason);
                    $(`.resign_user_initation-${data.resign_user_initation}`).prop("checked", true);
                    $(`.resign_user_talent-${data.resign_user_talent}`).prop("checked", true);
                    $('#modal-edit').modal("show");
                }
            })
        }

        function resignNotice(grade_group_name) {
            if (grade_group_name == 'Workman' || grade_group_name == 'Promoter' || grade_group_name == 'Staff' || grade_group_name == 'Supervisor') {
                $('#alert-notice').text("Minimal Resign Date 1 Month Notice")
            } else if (grade_group_name == 'Executive' || grade_group_name == 'Manager') {
                $('#alert-notice').text("Minimal Resign Date 2 Month Notice")
            } else if (grade_group_name == 'Senior Manager') {
                $('#alert-notice').text("Minimal Resign Date 3 Month Notice")
            }
        }

        function user_handover_detail() {
            $.ajax({
                type: "get",
                url: "{{url('resignation/user/nik')}}",
                data: {
                    user_nik: $('#user_handover_nik').val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    let data = response.data.data
                    $('#user_handover_name').val(data.user_name)
                    $('#user_handover_department').val(data.department.department_name)
                }
            })
        }

        update = () => {
            let data = $('#formedit').serialize()
            $.ajax({
                type:"put",
                url:"{{url('resignation/update/Resign')}}",
                data:data,
                success:function(response){
                    sweetSuccess(response.message, response.data.message)
                    $('#table').DataTable().ajax.reload();
                    $('#modal-edit').modal("hide");
                    $("#formedit")[0].reset();
                    $('#resign_id').remove();
                }
            })
        }

        function updateHandOVer(id) {
            let data = $('#form-handover').serialize();
            data += `&resign_id=${id}`;
            $.ajax({
                type: "put",
                url: "{{url('resignation/handover/resign')}}",
                data: data,
                success: function (response) {
                    sweetSuccess(response.message, response.data.message);
                    $('#modal_handover').modal('hide');
                    $('#table').DataTable().ajax.reload();
                }
            })
        }

        function setFilterPeriod(){
            $.ajax({
                type: "get",
                url: "{{url('/getall/plugin/period/active')}}",
                success: function (response) {
                    let data = response.data
                    let periodOption = '<option value="">Choose</option>'
                    periodOption += loopingOption(data,'period');
                    $('#period_search').append(periodOption);
                },
            })
        }

        function cancel(id){
            $.ajax({
                type:"put",
                url : "{{url('resignation/cancel/resign')}}",
                data:{
                    resign_id : id,
                    _token : $('meta[name="csrf-token"]').attr('content')
                },
                success:function(response){
                    $('#table').DataTable().ajax.reload();
                }
            })
        }

        function feedback(id){
            $('#modal').modal("show");
            $('#modal form').append(`<input type="text" name="resign_id" id="resign_id" hidden>`);
            $('#resign_id').val(id);
        }

        function validasi() {
            let data = $('#form').serializeArray();
            let newFailData = [];
            let result = loopingValidasi(data); // melakukan pengecekan validasi apakah data null atau tidak (data returnnya data yg tidak null)
            let array = getUnique(result); //menghapus data yang samma
            let formName = allFormName(); //mendapat kan semua nama input di dalam form
            let failData = formName.filter(x => !array.includes(x));
            if (failData.length == 0) {
                insertFeedback()
            }else{
                newFailData = array.length == 0 ? formName : failData
                errorValidasi(newFailData)
            }
        }

        validasiEdit = () => {
            $('.is-invalid').removeClass('is-invalid')
            let data = $('#formedit').serializeArray();
            let result = loopingValidasi(data)
            if (result.length == 0) {
                update()
            } else {
                for (let index = 0; index < result.length; index++) {
                    $(`#${result[index]}`).addClass('is-invalid');
                    sweetError('Form cannot be empty');
                }
            }
        }

        function validasiHandOver(id) {
            let data = $('#form-handover').serializeArray();
            let result = loopingValidasiHandOver(data)
            if (result.length == 0) {
                if($('input:radio[name=user_handover_status]').is(':checked')){
                    updateHandOVer(id);
                }else{
                    sweetError('user handover status cannot be empty');
                }
            } else {
                for (let index = 0; index < result.length; index++) {
                    $(`#${result[index]}`).addClass('is-invalid');
                    sweetError('Form cannot be empty');
                }
            }
        }

        function insertFeedback()
        {
            let data = $('#form').serialize()
            $.ajax({
                type:"post",
                data:data,
                url:"{{url('resignation/insert/feedback')}}",
                success:function(response){
                    sweetSuccess(response.message, response.data.message);
                    $('#table').DataTable().ajax.reload();
                    $('#modal').modal("hide");
                    $('#resign_id').remove();
                }
            })
        }

        function sweetSuccess(status, message) {
            Swal.fire(
                'Good job!',
                message,
                status
            );
        }

        function sweetError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: message,
            })
        }

        function errorValidasi(data) {
            for (let i = 0; i < data.length; i++) {
                let name = data[i].replace(`[]`, "")
                $(`#${name}_group`).addClass("border border-danger");
            }
        }

        //mengecek apakah resign feedback yang di data dan looping sama jika sama maka data tersebut direturn
        function loopingValidasi(data) {
            let dataArray = [];
            for (let index = 1; index <= 27; index++) { // 27 karena jumlah soal itu ada 27
                for (let i = 0; i < data.length; i++) {
                    let num = index == 1 ? `${index}[]` : index
                    if (data[i]['name'] == "resign_feedback_" + num && data[i]['value'] != '') {
                        dataArray.push(data[i]['name'])
                    }
                }
            }
            return dataArray;
        }

        function loopingValidasiHandOver(data) {
            let dataArray = [];
            for (let index = 0; index < data.length; index++) {
                if (data[index]['value'] == '') {
                    dataArray.push(data[index]['name'])
                }
            }
            return dataArray;
        }

        function allFormName() {
            let array = [];
            for (let i = 1; i <= 27; i++) {
                let num = i == 1 ? `${i}[]` : i
                array.push("resign_feedback_" + num)
            }
            return array
        }

        function getUnique(array) {
            var uniqueArray = [];
            // Loop through array values
            for (i = 0; i < array.length; i++) {
                if (uniqueArray.indexOf(array[i]) === -1) {
                    uniqueArray.push(array[i]);
                }
            }
            return uniqueArray;
        }

        function saveFeedBack() {
            let data = $('#form').serialize()
        }

        function parklaring(id) {
            let resign_id = backTomin(id)
            window.open("{{url('resignation/report/reference_letter')}}/" + resign_id, '_blank');
        }

        function Clearance(id) {
            let resign_id = backTomin(id);
            window.open("{{url('resignation/report/clearance')}}/" + resign_id, '_blank');
        }

        function FeedbackID(id) {
            let resign_id = backTomin(id);
            window.open("{{url('resignation/report/feedback')}}/" + resign_id, '_blank');
        }

        function remind(id) {
            let resign_id = backTomin(id);
            $.ajax({
                type : "get",
                url : "{{ url('resignation/status/remind-feedback') }}/" + resign_id,
                success : (res) => {
                    sweetSuccess(res.message, res.data.message)
                }
            })
        }

        function backTomin(id) // merubah backslah to min
        {
            return id.replace('/', '-');
        }

        function getAllOption() {
            $.ajax({
                type: 'get',
                url: "{{url('/get/option/user')}}",
                success: function (response) {
                    showingOptionSearch(response.data);
                }
            })
        }

        function showingOptionSearch(data){
            let index = ["grade", "department"];
            let test = 'type_name';
            for (let i = 0; i < index.length; i++) {
                let id = `${index[i]}_id`;
                let name = `${index[i]}_name`;
                let dataObject = data[index[i]];
                for (let u = 0; u < dataObject.length; u++) {
                    $(`#${index[i]}_search`).append(`<option value="${dataObject[u][id]}">
                                            ${dataObject[u][name]}
                                        </option>`);
                }
            }
        }

        function loopingOption(data, type) {
            let option = ``
            for (let index = 0; index < data.length; index++) {
                var name = type + '_name';
                var id = type + '_id';
                option += `<option value="${data[index][id]}">${data[index][name]}</option>`;
            }
            return option;
        }

        closeModal = () => {
            $('.modal').modal("hide");
            $('#resign_id').remove();
        }

        function CancelResign(id){
            Swal.fire( {
                title: 'Are you sure to cancel your resignation request?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!',
                preConfirm : function()  {
                    cancel(id)
                }
            })
        }
        
    </script>
@endsection