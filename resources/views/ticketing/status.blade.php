@extends('ticketing/master/master')
@section('title','Ticketing Status')
@section('breadcumb','Ticketing Status')

@section('header')
    {{-- DataTables --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets_argon/vendor/datatables/datatables.min.css')}}"/>
    {{-- Select2 --}}
    {{-- <link rel="stylesheet" href="{{asset('assets_admin_lte/assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets_admin_lte/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}"> --}}
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets_argon/filepond/dist/filepond-plugin-get-file.min.css') }}">
    <style>
        .filepond--item {
            width: calc(50% - .5em);
        }

        @media (min-width: 30em) {
            .filepond--item {
                width: calc(50% - .5em);
            }
        }

        @media (min-width: 50em) {
            .filepond--item {
                width: calc(33.33% - .5em);
            }
        }

        /* use a hand cursor intead of arrow for the action buttons */
        .filepond--file-action-button {
            cursor: pointer;
        }

        /* the text color of the drop label*/
        .filepond--drop-label {
            color: #555;
        }

        /* underline color for "Browse" button */
        .filepond--label-action {
            text-decoration-color: #aaa;
        }

        /* the background color of the filepond drop area */
        .filepond--panel-root {
            background-color: #eee;
        }

        /* the border radius of the drop area */
        .filepond--panel-root {
            border-radius: 0.5em;
        }

        /* the border radius of the file item */
        .filepond--item-panel {
            border-radius: 0.5em;
        }

        /* the background color of the file and file panel (used when dropping an image) */
        .filepond--item-panel {
            background-color: #555;
        }

        /* the background color of the drop circle */
        .filepond--drip-blob {
            background-color: #999;
        }

        /* the background color of the black action buttons */
        .filepond--file-action-button {
            background-color: rgba(0, 0, 0, 0.5);
        }

        /* the icon color of the black action buttons */
        .filepond--file-action-button {
            color: white;
        }

        /* the color of the focus ring */
        .filepond--file-action-button:hover,
        .filepond--file-action-button:focus {
            box-shadow: 0 0 0 0.125em rgba(255, 255, 255, 0.9);
        }

        /* the text color of the file status and info labels */
        .filepond--file {
            color: white;
        }

        /* error state color */
        [data-filepond-item-state*='error'] .filepond--item-panel,
        [data-filepond-item-state*='invalid'] .filepond--item-panel {
            background-color: red;
        }

        [data-filepond-item-state='processing-complete'] .filepond--item-panel {
            background-color: green;
        }

        .table-active,
        .table-active>th,
        .table-active>td {
            background-color: rgba(0, 0, 0, .075);
        }

        .table-hover .table-active:hover {
            background-color: rgba(0, 0, 0, .075);
        }

        .table-hover .table-active:hover>td,
        .table-hover .table-active:hover>th {
            background-color: rgba(0, 0, 0, .075);
        }

        .badge-primary
        {
            color: white;
            background-color: #5e72e4;
        }
        .badge-primary[href]:hover,
        .badge-primary[href]:focus
        {
            text-decoration: none;

            color: #fff;
            background-color: #5e72e4;
        }

        .badge-yellow {
            color: black;
            background-color: #fcfc03;
        }

        a.badge-yellow:hover,
        a.badge-yellow:focus {
            color: black;
            background-color: #fcfc03;
        }

        a.badge-yellow:focus,
        a.badge-yellow.focus {
            outline: 0;
            box-shadow: 0 0 0 .2rem rgba(205, 226, 16, 0.815);
        }

        .btn-yellow {
            color: black;
            border-color: #fcfc03;
            background-color: #fcfc03;
        }

        table.dataTable tbody td {
            vertical-align: middle;
        }

        table {
            vertical-align: middle;
        }

    </style>
@endsection

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row" id="filter">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-content">
                    <div class="card">
                        <div class="card-header"><h4>Filter</h4></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col form-group">
                                    <label>Periode</label>
                                    <select type="text" class="form-control select2bs4 filter" style="width: 100%" placeholder="Period" id="period_search" name="period_search" >
                                    </select>
                                </div>
                                <div class="col form-group" >
                                    <label>Ticket Status</label>
                                    <select type="text" class="form-control select2bs4 filter" style="width: 100%" placeholder="Ticket Status" id="ticket_status_search" name="ticket_status_search" >
                                    </select>
                                </div>
                                <div class="col form-group" >
                                    <label>Department</label>
                                    <select type="text" class="form-control select2bs4 filter" style="width: 100%" placeholder="Department" id="department_search" name="department_search" >
                                        <option value="">Choose</option>
                                    </select>
                                </div>
                                <div class="col form-group" >
                                    <label>Ticket Type</label>
                                    <select type="text" class="form-control select2bs4 filter" style="width: 100%" placeholder="Ticket Type" id="ticket_type_search" name="ticket_type_search" >
                                    </select>
                                </div>
                                <div class="col-2 form-group" >
                                    <label>Download</label>
                                    <button class="btn btn-primary form-control" id="button-download">
                                        <span class="ni ni-cloud-download-95"></span>
                                    </button>
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
                                <a class="nav-link active" id="home-tab-center" data-toggle="tab" href="#proceed" aria-controls="proceed" role="tab" aria-selected="true" onclick="getData('proceed');clearFilter();TicketStatusFilter('proceed')">Proceed</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="service-tab-center" data-toggle="tab" href="#service-center" aria-controls="service-center" role="tab" aria-selected="false" onclick="getData('unproceed');clearFilter();TicketStatusFilter('unproceed')">Unproceed</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane table-responsive active" id="proceed" aria-labelledby="home-tab-center" role="tabpanel" >
                                <br>
                                <table class="table table-striped table-bordered table-hover table-sm" id="table-proceed" width="100%" style="vertical-align: middle;">
                                    <thead style="vertical-align: middle;">
                                        <tr>
                                            <th style="vertical-align: middle; width: 5px !important;" rowspan="2">#</th>
                                            <th style="vertical-align: middle; width: 55px !important;" rowspan="2">Ticket ID</th>
                                            <th style="vertical-align: middle; width: 55px !important;" rowspan="2">Ticket Type</th>
                                            <th style="vertical-align: middle; width: 55px !important;" rowspan="2">Ticket Status</th>
                                            <th style="vertical-align: middle; width: 55px !important;" rowspan="2">Date Ticket</th>
                                            <th style="vertical-align: middle; width: 15px !important;" rowspan="2">Last Approve</th>
                                            <th style="vertical-align: middle; width: 15px !important;" colspan="4"><center>Action</center></th>
                                        </tr>
                                        <tr>
                                            <th style=" width: 15px !important;"><cener>Detail</center></th>
                                            <th style=" width: 15px !important;"><center>Cancel</center></th>
                                            <th style=" width: 15px !important;"><center>Edit</center></th>
                                            <th style=" width: 15px !important;"><center>Upload</center></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="tab-pane table-responsive" id="service-center" aria-labelledby="service-tab-center" role="tabpanel">
                                <table class="table table-striped table-bordered table-hover mt-3" id="table-unproceed" width="100%" style="vertical-align: middle;">
                                    <br>
                                    <thead>
                                        <tr>
                                            <th style=" width: 5px !important;" rowspan="2">#</th>
                                            <th style=" width: 55px !important;" rowspan="2">Ticket ID</th>
                                            <th style=" width: 55px !important;" rowspan="2">Ticket Type</th>
                                            <th style=" width: 55px !important;" rowspan="2">Ticket Status</th>
                                            <th style=" width: 55px !important;" rowspan="2">Date Ticket</th>
                                            <th style=" width: 15px !important;" rowspan="2">Last Approve</th>
                                            <th style=" width: 15px !important;" colspan="4"><center>Action</center></th>
                                        </tr>
                                        <tr>
                                            <th style=" width: 15px !important;"><cener>Detail</center></th>
                                            <th style=" width: 15px !important;"><center>Cancel</center></th>
                                            <th style=" width: 15px !important;"><center>Edit</center></th>
                                            <th style=" width: 15px !important;"><center>Offering</center></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit Detail Ticket --}}
    <div class="modal fade text-left" id="modal_detail" role="dialog" >
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="title-modal-detail"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            <i class="fa fa-window-close"></i>
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form >
                    @csrf
                        <div class="row">
                            <div class="col-9">
                                <table class="table table-bordereless table-striped">
                                    <tr>
                                        <td class="table-active" style="width: 20px">Ticket ID</td>
                                        <td id="ticket_id"></td>
                                    </tr>
                                    <tr>
                                        <td class="table-active">Ticket Type</td>
                                        <td id="ticket_type"><b></b></td>
                                    </tr>
                                    <tr>
                                        <td class="table-active">Ticket Request</td>
                                        <td id="ticket_request"></td>
                                    </tr>
                                    <tr>
                                        <td class="table-active">Ticket Request Date</td>
                                        <td id="ticket_request_date"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-3">
                                <div class="d-flex justify-content-end">
                                    <span class="btn btn-default" disabled id="ticket_priority" style="pointer-events: none;"> </span>
                                    <span class="" id="ticket_status" disabled style="pointer-events: none;"></span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="pl-1 pr-1 mt-1 mb-1" id="detail-content">
                           
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <div class="pl-1 pr-1 mt-1 mb-1">
                                    <h3>Detail Approval Note</h3>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr class="table-active">
                                                <th style="width: 50% !important"><center><b>Approval user</b></center></th>
                                                <th style="width: 50% !important"><center><b>Note</b></center></th>
                                            </tr>
                                        </thead>
                                        <tbody id="detail-approval-note">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col detail-attach-file">
                                <div class="pl-1 pr-1 mt-1 mb-1">
                                    <h3>Detail File Attach</h3>
                                    <table class="table table-striped table-bordered" >
                                        <thead>
                                            <tr id="file_attach" class="table-active">
                                                <th><b>File Attach Request</b></th>
                                            </tr>
                                            {{-- <tr class="table-active" id="file_offering">
                                                <th><b>File Attach Offering</b></th>
                                            </tr> --}}
                                            {{-- <tr id="file_offering">

                                            </tr> --}}
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
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
                                <tbody id="detail-approval">

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

                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-save">Save</button>
                    <button type="button" class="btn btn-success pdf" onclick="downloadPDF()">Download</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="modal_upload" role="dialog" >
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="title-modal-upload"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            <i class="fa fa-window-close"></i>
                        </span>
                    </button>
                </div>
                <div class="modal-body ">
                    <form class="modal-body-upload">
                        @csrf
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-save-upload" class="btn btn-primary" >Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

@section('footer')
    <link type="text/css"  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"  rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    {{-- Datatables --}}
    <script type="text/javascript" src="{{asset('assets_argon/vendor/datatables/datatables.min.js')}}"></script>
    {{-- Helper & Validation --}}
    <script src="{{asset('js/script.js')}}"></script>

    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

    <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>

    <script src="{{ asset('assets_argon/filepond/dist/filepond-plugin-get-file.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            getData('proceed');
            TicketStatusFilter('proceed')
            getAllOption();
            setFilterPeriod();
            setFilterTicketType();
            $('.select2bs4').select2({theme:'bootstrap4'});

            (chekNik() == true) 
                ? $('#filter').attr('hidden',false)
                : $('#filter').attr('hidden',true)
        });

        const files = $('.filePond')

        const data = {
            id_name : "ticket_id",
            url:"{{url('ticketing/status/data')}}"
        }

        const Helper = new valbon(data);

        setFilterPeriod = () => {
            $.ajax({
                type: "get",
                url: "{{url('/getall/plugin/period/active')}}",
                success: function (response) {
                    let data = response.data
                    let periodOption = '<option value="">Choose</option>'
                    periodOption += loopingOption(data, 'period');
                    $('#period_search').append(periodOption);
                },
            })
        }

        setFilterTicketType = () => {
            $.ajax({
                type: "get",
                url: "{{url('ticketing/all/type')}}",
                success: function (response) {
                    let data = response.data
                    let typeOption = '<option value="">Choose</option>'
                    typeOption += loopingOption(data, 'type');
                    $('#ticket_type_search').append(typeOption);
                },
            })
        }

        loopingOption = (data, type) => {
            let option = ``
            for (let index = 0; index < data.length; index++) {
                var name = type + '_name';
                var id = type + '_id';
                option += `<option value="${data[index][id]}">${data[index][name]}</option>`;
            }
            return option;
        }

        getAllOption = () => {
            $.ajax({
                type: 'get',
                url: "{{url('/get/option/user')}}",
                success: function (response) {
                    showingOptionSearch(response.data);
                }
            })
        }

        showingOptionSearch = (data) => {
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

        TicketStatusFilter = (type) => {
            $('#ticket_status_search').empty();
            setFilter(type);
        }

        setFilter = (type) => {
            $('#department_search').attr('onchange', `getData('${type}')`)
            $('#ticket_status_search').attr('onchange', `getData('${type}')`)
            $('#ticket_type_search').attr('onchange', `getData('${type}')`)
            $('#period_search').attr('onchange', `getData('${type}')`)
            let optionFilter = '<option value="">Choose</option>';
            $('#button-download').attr('onclick',`download('${type}')`)
            if (type == 'proceed') {
                optionFilter += `<option value="initial">Initial</option>
                                 <option value="process">Process</option>
                                 <option value="approve">Approve</option>
                                 <option value="done">Done</option>`;
            } else {
                optionFilter += `<option value="cancel">Cancel</option>
                                <option value="reject">Reject</option>`;
            }
            $('#ticket_status_search').append(optionFilter);
        }

        clearFilter = () => {
            $('#department_search').val('').select2({
                theme: 'bootstrap4'
            });
            $('#period_search').val('').select2({
                theme: 'bootstrap4'
            });
            $('#ticket_status_search').val('').select2({
                theme: 'bootstrap4'
            });
            $('#ticket_type_search').val('').select2({
                theme: 'bootstrap4'
            });
        }

        const chekNik = () => {
            let array_admin = JSON.parse(JSON.stringify({{\Helper::instance()->checkNIK()}}));
            let nik = "{{Auth::user()->user_nik}}";
            if (array_admin.includes(parseInt(nik))) {
                return true;
            } else {
                return false;
            }
        }

        getData = (type) => {
            let url = getUrl(type);
            var table = $(`#table-${type}`).DataTable({
                processing: true,
                destroy: true,
                language: {
                    loadingRecords: "Please Wait - loading",
                    processing: '<div class="se-pre-con"></div>',
                    paginate: {
                        previous: "<b> < </b>",
                        next: "<b> > </b>",
                    }
                },
                ajax: {
                    url: url,
                    data: {
                        "department_id": $('#department_search').val(),
                        "ticket_status": $('#ticket_status_search').val(),
                        "type_id": $('#ticket_type_search').val(),
                        "period_id": $('#period_search').val(),
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "ticket_id",
                        name: "ticket_id"
                    },
                    {
                        data: "type.type_name",
                        name: "type.type_name",
                        render : (data,meta,row) => {
                            if (row.type_id == 8) { // untuk ticket it po
                                return getCategoryITPO(data,row.detail_po);
                            }else if(row.type_id == 6){ // untuk ticket user request
                                return `<b> ${data} </b><br> ${row.other_information}`;
                            }else if (row.type_id == 10) {
                                return `<b> ${data} </b><br> ${row.other_information}`;
                            }else{
                                return `<b> ${data} </b>`;
                            }
                        }
                    },
                    {
                        data: "ticket_status",
                        name: "ticket_status",
                        render : (data,meta,row) => {
                            let info =''
                            if (data == 'cancel' && row.reason_cancel != null) {
                                info = row.reason_cancel
                            }
                            return `
                                    <center>
                                        <span class="badge badge-${chooseColorStatus(data)} .text-dark">${Helper.capitalizeFirstWords(data)}</span><br>
                                        ${info}
                                    </center>
                                    `
                        }
                    },
                    {
                        data: "created_at",
                        name: "created_at",
                        render: (data,meta,row) => {
                            return `${row.request_by.user_name} <br> ${data}`
                        }
                    },
                    {
                        data:"ticket_id",
                        name:"ticket_id",
                        render: function(data, type, row, meta) {
                            let last_approve = getLastApprove(row)
                            if (last_approve != '') {
                                return `${last_approve} <br> ${row.approval.updated_at}`;
                            }else{
                                return ' - ';
                            }
                        }
                    },
                    {
                        data: "ticket_id",
                        name: "ticket_id",
                        render: (data,meta,row) => {
                            return `<center>
                                        <button class="btn btn-sm btn-info" onclick="EditTicketing('${data}',${row.type_id})">
                                            <span class="fa fa-eye" title="Detail" data-toggle="tooltip" data-placement="bottom">
                                            </span>
                                        </button>
                                    </center>`;
                           
                        }
                    },
                    {
                        data: "ticket_id",
                        name: "ticket_id",
                        render: (data,meta,row) => {
                            if (row.ticket_status == 'approve' || row.ticket_status == 'done') {
                                return `<center>
                                            <button type="" class="btn btn-sm btn-warning">
                                                <span class="fa fa-lock" title="lock" data-toggle="tooltip" data-placement="bottom">
                                                </span>
                                            </button>
                                        </center>`
                            }else{
                                return `<center>
                                            <button class="btn btn-sm btn-danger" onclick="CancelTicketing('${data}','${type}')">
                                                <span class="fa fa-times-circle" title="Cancel" data-toggle="tooltip" data-placement="bottom">
                                                </span>
                                            </button>
                                        </center>`;
                                
                            }
                           
                        }
                    },
                    {
                        data: "ticket_id",
                        name: "ticket_id",
                        render: (data,meta,row) => {
                            if (row.edit == false) {
                                return `<center>
                                        <button type="" class="btn btn-sm btn-warning">
                                            <span class="fa fa-lock" title="lock" data-toggle="tooltip" data-placement="bottom">
                                            </span>
                                        </button>
                                    </center>`
                            }else{
                                return `<center>
                                        <button type="" class="btn btn-sm btn-warning" onclick="ChangeStatus('${data}')">
                                            <span class="fa fa-edit" title="Edit" data-toggle="tooltip" data-placement="bottom">
                                            </span>
                                        </button>
                                    </center>`
                            }
                           
                        }
                    },
                    {
                        data: "ticket_id",
                        name: "ticket_id",
                        render: (data,meta,row) => {
                            let type;
                            if (row.type_id == '8') { // menentukan type
                                type = "it_po";
                            }
                            return `<center>
                                        <button type="" class="btn btn-sm btn-success" onclick="modalUplooad('${data}','it_po')">
                                            <span class="fa fa-cloud-arrow-up" title="Upload File" data-toggle="tooltip" data-placement="bottom">
                                            </span>
                                        </button>
                                    </center>`
                        }
                    }
                    
                ],
                columnDefs: [
                    {
                        "targets": [8,9],
                        "visible": chekNik(),
                        "searchable": false
                    },
                    {
                        "targets": [7],
                        "visible": type == 'proceed' ? true : false ,
                        "searchable": false
                    },
                ]
            })
        }

        getCategoryITPO = (type_nama,detail) => {
            let str = '<b>' + type_nama + '</b>' + `<br>`;
            for (let index = 0; index < detail.length; index++) {
                if (detail[index].sub_category != null) {
                    let data = detail[index].sub_category;
                    str += `<i>${data.category.category_name}</i> - <i>${data.sub_category_name}</i> <br>`
                }
            }
            return str
        }

        chooseColorStatus = (ticket_status) => {
            if (ticket_status == 'initial' ) {
                return 'primary';
            }else if(ticket_status == 'process'){
                return 'info';
            }else if(ticket_status == 'approve'){
                return 'yellow';
            }else if(ticket_status == 'done'){
                return 'success';
            }else if(ticket_status == 'reject'){
                return 'danger';
            }else if(ticket_status == 'cancel'){
                return 'warning';
            }
        }

        getUrl = (type) => {
            let url = '';
            if (chekNik() == true) {
                if (type == 'proceed') {
                    url = "{{url('ticketing/status/data')}}";
                } else {
                    url = "{{url('ticketing/status/data/uproceed')}}"
                }
            } else {
                if (type == 'proceed') {
                    url = "{{url('ticketing/status/data/ById')}}";
                } else {
                    url = "{{url('ticketing/status/data/ById/unproceed')}}";
                }
            }
            return url;
        }

        CancelTicketing = (id,type) => {
            Swal.fire( {
                title: 'Are you sure to cancel your ticketing request?',
                input: 'text',
                icon: 'warning',
                inputAttributes: {
                    autocapitalize: 'off',
                    placeholder: 'Reason',
                    required: true
                },
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!',
                preConfirm : function(reason)  {
                    cancel(id,type,reason)
                }
            })
        }

        cancel = (id,type,reason) => {
            $.ajax({
                type:"delete",
                url:"{{url('ticketing/status')}}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    ticket_id: id,
                    reason_cancel : reason
                },
                success: (response) => {
                    Helper.sweetSuccess(response.message,response.data.message);
                    $(`#table-${type}`).DataTable().ajax.reload();
                    Helper.closeModal();
                },
                error:  (response) => {
                    Helper.errorHandle(response);
                },
            }).done(() => {
                $('.se-pre-con').hide();
            })
        }

        ChangeStatus = (id) => {
            Swal.fire({
                title: `Edit Status Ticketing ${id}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Save`,
                focusConfirm: true,
                html: ` <select id="select-sweet">
                            <option value="initial">Initial</option>
                            <option value="process">Process</option>
                            <option value="approve">Approve</option>
                            <option value="done">Done</option>
                            <option value="reject">Reject</option>
                            <option value="cancel">Cancel</option>
                        </select>`,
                didOpen: function () {
                        $('#select-sweet').select2({
                            dropdownPosition: 'below',
                            dropdownParent: $(".swal2-container"),
                            theme: 'bootstrap4',
                            minimumResultsForSearch: 3,

                        });
                },
                preConfirm: () => {
                    let status = $('#select-sweet').val();
                    Swal.fire({
                        title: 'Are you sure to change ticket status?',
                        text: "",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, save it!',
                        preConfirm : function()  {
                            let data = {
                                ticket_id : id,
                                ticket_status : status,
                                _token: $('meta[name="csrf-token"]').attr('content'),
                            }
                            update(data);
                        }
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            })

        }

        EditTicketing = (id,type = null) => {
            $('#detail-content').empty();
            $('#detail-approval').empty();
            $('#detail-approval-it').empty();
            $('#detail-participant').empty();
            $('#detail-barang').empty();
            $('#ticket_status').removeClass();
            $('.btn-save').attr('hidden',true);
            $('.detail-attach-file').attr('hidden',true);
            $.ajax({
                url: "{{url('ticketing/status/data-id')}}",
                data: {
                    ticket_id: id
                },
                beforeSend: () => {
                    $('.se-pre-con').show();
                },
                success: (res) => {
                    let data = res.data
                    // let vendor_name = data.vendor == null ? 'Vendor Not Set' : data.vendor.vendor_name;
                    $('#title-modal-detail').text(`Detail Ticketing Request ${data.ticket_id} - ${Helper.capitalizeFirstWords(data.ticket_status)}`);
                    $('#ticket_id').text(data.ticket_id);

                    //show ticket type with other information
                    if (data.type_id == 8) {
                        $('#ticket_type b').text(`${data.type.type_name}`);
                    }else if (data.type_id == 6 || data.type_id == 10) {
                        $('#ticket_type b').text(`${data.type.type_name} - ${data.other_information} (${Helper.capitalizeFirstWords(data.request_type)})`);
                    }

                    $('#ticket_priority').text(Helper.capitalizeFirstWords(data.priority.priority_name));
                    $('#ticket_status').addClass(`btn btn-${chooseColorStatus(data.ticket_status)}`)
                    $('#ticket_status').text(Helper.capitalizeFirstWords(data.ticket_status))
                    $('#ticket_request').text(data.request_by.user_name);
                    $('#ticket_request_date').text(data.created_at);

                    contentTicketing(data);

                    $('#reason').text(data.reason == null ? "-" : data.reason);
                    

                    let detailData = detailApproval(data); //mendapatkan data detail approval nik 1-6 dan approval nik it1 - it-2
                    $('#detail-approval').append(detailData.Number);
                    $('#detail-approval-it').append(detailData.IT);
                    
                    $('#modal_detail').modal('show');
                    $('.pdf').attr('onclick',`downloadPDF('${id}','${data.type_id}')`)
                    // type === 'view' ? changeEditToView() : '';

                    detailApprovalNote(data.approval); //membuat table note approval
                    detailFileAttachRequest(data.file_name_request)
                },
                error: (response) => {
                    Helper.errorHandle(response);
                },
                complete: () => {
                    $('.se-pre-con').hide();
                }
            })
        }

        contentTicketing = (data) => {
            let content = ''
            if (data.type_id == 8) { // content detail it po
                content = ` <h3>Detail PO</h3>
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                        <th style="width:20%" rowspan="2" class="align-middle">Category</th>
                                        <th style="width:20%" rowspan="2" class="align-middle">Nama Barang</th>
                                        <th style="width:10%" rowspan="2" class="align-middle">Qty</th>
                                        <th style="width:20%" rowspan="2" class="align-middle">Harga</th>
                                        <th style="width:20%" rowspan="2" class="align-middle">Jumlah</th>
                                        <th style="width:5%" colspan="2"><center>Accept User</center></th>
                                    </tr>
                                </thead>
                                <tbody id="detail-barang">

                                </tbody>
                            </table>
                            <table class="table table-striped table-bordered" style="vertical-align: middle;">
                                <tr>
                                    <td class="table-active" style="width: 20px" >Reason</td>
                                    <td id="reason" style="white-space: normal;"></td>
                                </tr>
                            </table>`;
                $('#detail-content').append(content)
                detailItem(data);
                $('.detail-attach-file').attr('hidden',false);

                
            }else if(data.type_id == 6 ) { // content detail request user
                content = ` <h3>Detail Request User</h3>
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr class="table-active">
                                        <th style="width: 20%"><b>User Nik</b></th>
                                        <th style="width: 20%"><b>Email</b></th>
                                        <th style="width: 20%"><b>Request System</b></th>
                                    </tr>
                                </thead>
                                <tbody id="detail-request-user">

                                </tbody>
                            </table>
                            <table class="table table-striped table-bordered" style="vertical-align: middle;">
                                <tr>
                                    <td class="table-active" style="width: 20px" >Reason</td>
                                    <td id="reason" style="white-space: normal;"></td>
                                </tr>
                                <tr>
                                    <td class="table-active" style="width: 20px" >Description</td>
                                    <td id="description" style="white-space: normal;"></td>
                                </tr>
                            </table>`;
                $('#detail-content').append(content);
                $('#description').text(data.description == null ? "-" : data.description);
                detailItem(data);
            }else if (data.type_id == 10) { // content detail cra dan form cra admin
                content = ` <h3>Detail Change Request Form</h3>
                            <table class="table table-striped table-bordered" style="vertical-align: middle;">
                                <tr>
                                    <td class="table-active" style="width: 20px" >Reason</td>
                                    <td id="reason" style="white-space: normal;"></td>
                                </tr>
                                <tr>
                                    <td class="table-active" style="width: 20px" >Description</td>
                                    <td id="description" style="white-space: normal;"></td>
                                </tr>
                            </table>
                            <hr>
                            <h3>Demand Analysis <span style="color:red">*filled by IT team</span></h3>
                            <form class="form form-vertical" novalidate id="form">
                                @csrf
                                <input type="text" id="cra_id" name="cra_id" hidden>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label><b>Implementation Impact</b></label>
                                            <textarea class="form-control form-cra" id="implementation_impact_cra" name="implementation_impact_cra" rows="3" wrap="hard" placeholder="Impact Implementation" style="resize:none;" required></textarea>
                                            <small id="implementation_impact_cra_alert" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label><b>Security Impact / Service Impact </b></label>
                                            <textarea class="form-control form-cra" id="security_service_impact_cra" name="security_service_impact_cra" rows="3" wrap="hard" placeholder="Impact Implementation" style="resize:none;" required></textarea>
                                            <small id="security_service_impact_cra_alert" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label><b>Change of Location </b></label>
                                            <input type="text" class="form-control form-cra" id="location_cra" name="location_cra" rows="3" wrap="hard" placeholder="Change of Location" style="resize:none;" required>
                                            <small id="location_cra_alert" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label><b>Number of Personnel </b></label>
                                            <input type="text" class="form-control form-cra" id="number_personnel_cra" name="number_personnel_cra" rows="3" wrap="hard" placeholder="IT Team" style="resize:none;" required>
                                            <small id="number_personnel_cra_alert" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label><b>Price of Change </b></label>
                                            <input type="text" class="form-control form-cra" id="price_cra" name="price_cra" rows="3" wrap="hard" placeholder="Price of Change" style="resize:none;" required>
                                            <small id="price_cra_alert" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label><b>Impact of Change</b></label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input form-cra" type="radio" name="impact_cra" id="inlineRadio1" value="extensive">
                                                <label class="form-check-label" for="inlineRadio1">Extensive</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input form-cra" type="radio" name="impact_cra" id="inlineRadio2" value="significant">
                                                <label class="form-check-label" for="inlineRadio2">Significant</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input form-cra" type="radio" name="impact_cra" id="inlineRadio3" value="moderate">
                                                <label class="form-check-label" for="inlineRadio3">Moderate</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input form-cra" type="radio" name="impact_cra" id="inlineRadio4" value="minor">
                                                <label class="form-check-label" for="inlineRadio3">Minor</label>
                                            </div>
                                            <small id="impact_cra_alert" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label><b>Urgency of Change</b></label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input form-cra" type="radio" name="urgent_cra" id="inlineRadio1" value="critical">
                                                <label class="form-check-label" for="inlineRadio1">Critical</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input form-cra" type="radio" name="urgent_cra" id="inlineRadio2" value="high">
                                                <label class="form-check-label" for="inlineRadio2">High</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input form-cra" type="radio" name="urgent_cra" id="inlineRadio3" value="medium">
                                                <label class="form-check-label" for="inlineRadio3">Medium</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input form-cra" type="radio" name="urgent_cra" id="inlineRadio4" value="low">
                                                <label class="form-check-label" for="inlineRadio3">Low</label>
                                            </div>
                                            <small id="urgent_cra_alert" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label><b>Priority of Change</b></label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input form-cra" type="radio" name="priority_cra" id="inlineRadio1" value="critical">
                                                <label class="form-check-label" for="inlineRadio1">Critical</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input form-cra" type="radio" name="priority_cra" id="inlineRadio2" value="high">
                                                <label class="form-check-label" for="inlineRadio2">High</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input form-cra" type="radio" name="priority_cra" id="inlineRadio3" value="medium">
                                                <label class="form-check-label" for="inlineRadio3">Medium</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input form-cra" type="radio" name="priority_cra" id="inlineRadio4" value="low">
                                                <label class="form-check-label" for="inlineRadio3">Low</label>
                                            </div>
                                            <small id="priority_cra_alert" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label><b>Estimated Processing Time </b></label>
                                            <input type="text" class="form-control form-cra" id="estimate_cra" name="estimate_cra" rows="3" wrap="hard" placeholder="Estimated Processing Time" style="resize:none;" required>
                                            <small id="estimate_cra_alert" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                            </form>`;
                $('#detail-content').append(content);
                $('.form-cra').prop( "disabled", true );
                $('.btn-save').attr("onclick",`validate('edit','10')`) //10 adalah id dari type ticket
                showDetailCRA(data);
                $('#description').text(data.description == null ? "-" : data.description);
                $('.detail-attach-file').attr('hidden',false);
            }
        }

        showDetailCRA = (data) => {
            let detail = data.detail_request_cra;
            $('#cra_id').val(detail.cra_id);
            if (detail.implementation_impact_cra != null)
                $('#implementation_impact_cra').val(detail.implementation_impact_cra) ;
            if (detail.security_service_impact_cra != null)
                $('#security_service_impact_cra').val(detail.security_service_impact_cra) ;
            if (detail.location_cra != null)
                $('#location_cra').val(detail.location_cra) ;
            if (detail.number_personnel_cra != null)
                $('#number_personnel_cra').val(detail.number_personnel_cra) ;
            if (detail.price_cra != null)
                $('#price_cra').val(detail.price_cra) ;
            if (detail.estimate_cra != null)
                $('#estimate_cra').val(detail.estimate_cra) ;
            if (detail.impact_cra != null)
                $("[name=impact_cra]").val([detail.impact_cra]); 
            if (detail.urgent_cra != null)
                $("[name=urgent_cra]").val([detail.urgent_cra]); 
            if (detail.priority_cra != null)
                $("[name=priority_cra]").val([detail.priority_cra]); 
        }

        detailFileAttachRequest = (file_name) => {
            $('.file_attach').remove();
            let table_file = '';
            if (file_name != null) {
                let array_file = file_name.split(',');
                array_file.forEach(file => {
                    table_file += ` <tr class="file_attach">
                                        <th>
                                            <a href="{{ asset('file_uploads/ticketing/request') }}/${file}" target="_blank">
                                                <i class="fa fa-arrow-alt-to-bottom"></i> ${file}
                                            </a>
                                        </th>
                                    </tr>`
                });

            }else{
                table_file += ` <tr class="file_attach">
                                    <th>
                                        No File Available
                                    </th>
                                </tr>`
            }

            $('#file_attach').after(table_file);
        }

        detailFileAttachOffering = (file_name) => {

        }

        detailApprovalNote = (data) => {
            $('#detail-approval-note').empty();
            let table = '';
            let string = '';
            for (let index = 1; index <= 8; index++) {
                if (index == 7) {
                    string = 'it1';
                }else if (index == 8) {
                    string = 'it2';
                }else{
                    string = index
                }
                let approval_nik_note = 'ticketing_approval_nik_' + string + '_note';
                let approval_nik = 'ticketing_approval_nik_' + string;
                let ticketing_approval = 'ticketing_approval' + string;
                if (data[approval_nik_note] != null) {
                    table += `  <tr>
                                    <td>${data[approval_nik]} - ${data[ticketing_approval].user_name}</td>
                                    <td> <span style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal;">${data[approval_nik_note]}</span></td>
                                </tr>`
                }
            }

            if (table.length == 0) {
                table = `<tr>
                            <td colspan="2"><center>No Data Available</center></td>
                        <tr>`
            }

            $('#detail-approval-note').append(table);
        }

        changeEditToView = () => {
            $('#approve-reject').attr('hidden',true);
            $('.btn-save').attr('hidden',true);
        }

        detailItem = (data) => {
           if (data.type_id == 8) { // detail item Request PO
                let item = data.detail_po;
                let detailTableItem = '';
                let totalHarga = 0;
                item.forEach(item => {
                    totalHarga = totalHarga + parseInt(item.qty) * parseInt(item.harga);
                    detailTableItem += `
                        <tr>
                            <td>${item.sub_category != null ? item.sub_category.category.category_name : ''} - ${item.sub_category != null ?  item.sub_category.sub_category_name : ''}</td>
                            <td>${item.nama_barang}</td>
                            <td>${item.qty}</td>
                            <td>${formatRp(parseInt(item.harga))}</td>
                            <td>${formatRp(parseInt(item.qty) * parseInt(item.harga))}</td>
                            <td>${item.accept_user == '1' ? 'Yes' : 'No'}</td>
                        </tr>
                    `;
                });

                detailTableItem += `
                        <tr>
                            <td colspan="3"><center><h3>Total</h3><center></td>
                            <td colspan="3"><center><h3>${formatRp(totalHarga)}</h3></center></td>
                        </tr>
                    `
                $('#detail-barang').append(detailTableItem);
           } else if(data.type_id == 6) { // detail item Request User
                let item = data.detail_request_access_user;
                let detailTableItem = '';
                item.forEach(item => {
                    detailTableItem += `
                        <tr>
                            <td>${item.user_nik} - ${item.user.user_name}</td>
                            <td>${item.user.user_email}</td>
                            <td>${data.other_information}</td>
                        </tr>`;
                });
                $('#detail-request-user').append(detailTableItem);
           }
        }

        detailApproval = (data) => {
            // detailTableApproval untuk data table approval 1-6
            // detailTableApprovalCEOHR untuk data table approval ceo & hr
            let detailTableApproval = '<tr>'; 
            let detailTableApprovalIT = '<tr>';
            for (let index = 1; index <= 8; index++) {
                let approval_nik = 'ticketing_approval_nik';
                let objectApproval = 'ticketing_approval';
                let nik_str = ''
                //melakaukan set nik_str
                if (index == 7) {
                    nik_str = 'it1';
                } else if (index == 8) {
                    nik_str = 'it2';
                } else {
                    nik_str = index;
                }
                approval_nik += `_${nik_str}`;
                objectApproval += `${nik_str}`;
                if (nik_str == 'it1' || nik_str == 'it2' || nik_str == '5' || nik_str == '6') {
                    detailTableApprovalIT += '<td>'
                    detailTableApprovalIT += detailContentApproval(data,objectApproval,approval_nik);
                    detailTableApprovalIT += '</td>';
                }else{
                    detailTableApproval += '<td>'
                    detailTableApproval += detailContentApproval(data,objectApproval,approval_nik);
                    detailTableApproval += '</td>';
                }
            }
            detailTableApproval += '</tr>';
            detailTableApprovalIT += '</tr>';

            return {Number:detailTableApproval,IT:detailTableApprovalIT};
        }

        detailContentApproval = (data,objectApproval,approval_nik) => {
            let detailApproval = ''
            let newData = data.approval;
            let array = arrayApproval(newData);
            array.push('ticketing_approval_nik_it1','ticketing_approval_nik_it2'); //menambahkan index
            if (newData[objectApproval] != null) {
                let detailAppover = newData[objectApproval].user_name; // mendapatkan nama approval
                detailApproval += `<center>${newData[approval_nik]}</center>
                                        <center>${detailAppover}</center>`;
                if (newData[approval_nik + '_date'] == null) {
                    detailApproval += `<center> <i> waiting approval </i> </center>`
                } else {
                    let image = chooseImage(array,approval_nik,newData,data) // mendapatkan gambar reject atau approve
                    let date = newData[approval_nik + '_date'].split(' ');
                    detailApproval += `<center><img src="{{ asset('${image}') }}" style="height: 50px;"></center>
                                        <center>${date[0]}</center>
                                        <center>${date[1]}</center>`
                }
            } else {
                detailApproval += '<center> - </center>';
            }
            return detailApproval;
        }

        update = (credentials) => {
            $.ajax({
                type:"patch",
                url:data.url,
                data: credentials,
                beforeSend:() =>{
                    $('.se-pre-con').show();
                },
                success:(response)=>{
                    Helper.sweetSuccess(response.message,response.data.message);
                    $(`#table-proceed`).DataTable().ajax.reload();
                    // Helper.closeModal('#modal_detail');
                },
                complete : () => {
                    $('.se-pre-con').hide();
                }
            })
        }

        formatRp = (data) => {
            let nominal = 'Rp. ' + parseInt(data).toLocaleString();
            return nominal;
        }

        arrayApproval = (data) => {
            let array = [];
            for (let index = 1; index <= 6; index++) { // looing data approval training nik 1 - 6
                if (data[`ticketing_approval_nik_${index}`] != null) { // jika data looping approval nik tidak kosong maka di masukan kedalam array
                    array.push(`ticketing_approval_nik_${index}`);
                }
            }
            return array;
        }

        chooseImage = (array, approval_nik, approval,data) => {
            let inarr = array.indexOf(approval_nik)
            let image = ''
            if (approval[array[inarr + 1] += '_date'] == null && data.ticket_status == 'reject') {
                image = '/images/rejected.png';
            } else {
                image = '/images/approved.png'
            }
            return image;
        }

        chooseIndex = (index) => {
            let str = '';

            if (index == 7) {
                str = 'it1'
            }else if(index == 8) {
                str = 'it2'
            }else{
                str = index
            }

            return str;
        }

        modalUplooad = (id,type) => {
            FilePond.registerPlugin(FilePondPluginGetFile);
            $('.modal-body-upload').empty();
            let content =''
            if (type == 'it_po') { //untuk it_po
                content = ` <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label><b> File Offering</b> </label>
                                            <input type="file" class="filepond offering" name="offering" multiple data-max-file-size="3MB" data-max-files="5" download>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label><b> File Capex</b> </label>
                                            <input type="file" class="filepond capex" name="capex[]" multiple data-max-file-size="3MB" data-max-files="3">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label><b> File PO</b> </label>
                                            <input type="file" class="filepond po" name="po[]" multiple data-max-file-size="3MB" data-max-files="3">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label><b> File PR</b> </label>
                                            <input type="file" class="filepond pr" name="pr[]" multiple data-max-file-size="3MB" data-max-files="4">
                                        </div>
                                    </div>
                                </div>`
            }

            $('.modal-body-upload').append(content);
            $('#title-modal-upload').text(`Upload File For Ticket ${id}`);
            $('.filepond').filepond({
                labelButtonDownloadItem: 'custom label', // by default 'Download file'
                allowDownloadByUrl: false, // by default downloading by URL disabled
            });
            $('#btn-save-upload').attr('onclick',`UploadProcess('${id}','${type}')`)
            $('#modal_upload').modal('show');
            $.ajax({
                url: "{{url('ticketing/status/data-id')}}",
                data: {
                    ticket_id: id
                },
                beforeSend: () => {
                    $('.se-pre-con').show();
                },
                success: (res) => {
                    let data = res.data
                    if (data.file_upload != null) {
                        showfilepo(JSON.parse(data.file_upload))
                    }
                },
                error: (response) => {
                    Helper.errorHandle(response);
                },
                complete: () => {
                    $('.se-pre-con').hide();
                }
            })
        }

        showfilepo = (data_file) => {
            let data = [
                'offering',
                'po',
                'capex',
                'pr'
            ];

            data.forEach(item => {
                let file_name = data_file[item];
                if (Array.isArray(file_name)) {
                    if (file_name.length > 0) {
                        for (let index = 0; index < file_name.length; index++) {
                            let name = file_name[index];
                            $(`.${item}`).filepond('addFile', `{{asset('file_uploads/ticketing/file_uploads/it_po/${name}')}}`).then(function(file){

                            });;
                        }
                    }
                }else if(file_name != null){
                    $(`.${item}`).filepond('addFile', `{{asset('file_uploads/ticketing/file_uploads/it_po/${file_name}')}}`).then(function(file){

                    });
                }
                
            });
        }

        UploadProcess = (id,type) => {
            if (type == "it_po") {
                let file = $(`.filepond`).filepond('getFiles');
                let formData = new FormData($('.form_modal_upload').get(0));
                let string = [
                    'offering[]',
                    'capex[]',
                    'po[]',
                    'pr[]',
                ]
                for (let index = 0; index < string.length; index++) {
                    for (let i = 0; i < file[index].length; i++) {
                        if (file[index][i] != null) {
                            formData.append(string[index],file[index][i].file,file[index][i].file.name); // mendapatkan file
                        }
                    }
                }
                formData.append(`type`,type); 
                formData.append(`id`,id); 
                formData.append('_token',$('meta[name="csrf-token"]').attr('content'))
                $.ajax({
                    type:"post",
                    url:`{{ url('ticketing/status/uploadFile') }}`,
                    data:formData,
                    enctype: 'multipart/form-data',
                    cache: false,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend:() =>{
                        $('.se-pre-con').show();
                    },
                    success:(response) => {
                        Helper.sweetSuccess(response.message,response.data.message);
                        $(`#table`).DataTable().ajax.reload();
                        $('#modal_upload').modal('hide');
                    },
                    error:  (response) => {
                        Helper.errorHandle(response);
                    },
                    complete : () => {
                        $('.se-pre-con').hide();
                    }
                })
            }
        }

        /* Fungsi formatRupiah */
        formatRupiah = (data,index) => {
            let rupiah = NumberToRupiah('',data.value)
            $(`#${data.id}`).val(rupiah);
            let total = parseInt($('#qty').text()) * NumberToRupiah('number',data.value);
            total = NumberToRupiah('',total.toString());
            $(`#total_offers${index}`).val(total)
            // calculateFeeParticipant();
        }

        NumberToRupiah = (type,angka, prefix =  "Rp. ") => {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "" + split[1] : rupiah;

            if (type == "number") {
                return split.join("");
            }else{
                rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
                return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
            }
        }


        function getLastApprove(row) {
            let last_approve = '';
            for (let index = 1; index <= 8; index++) {
                let approval_nik = 'ticketing_approval_nik';
                let object_name = `approval`; //relationshipmodel
                let relation = 'ticketing_approval';
                let string = "";
                if (index == 7) {
                    string = 'it1';
                }else if (index == 8) {
                    string = 'it2';
                }else{
                    string = index
                }

                approval_nik += `_${string}`
                relation += `${string}`
                if (row[object_name] != null && row[object_name][approval_nik] != null && row[object_name][approval_nik + '_date'] != null) {
                    last_approve = `${row[object_name][approval_nik]} - ${row[object_name][relation]['user_name']}` 
                }
            }
            return last_approve;
        }

        download = (type) => {
            if ($('#ticket_type_search').val() == '') {
                Helper.sweetError('Before downloading, please fill in the ticket type')
            }else{
                let data = $('.filter').serialize();
                data += `&type=${type}`;
                window.open("{{url('ticketing/download')}}?"+data , '_blank');
            }
        }

        downloadPDF = (id,type_id) => {
            if (type_id == 8) {
                window.open("{{url('ticketing/downloadByIdPDF')}}/"+Helper.backTomin(id) , '_blank');
            } else if (type_id == 6) {
                window.open("{{url('ticketing/downloadByIdRequestAccessUser')}}/"+Helper.backTomin(id) , '_blank')
            } else if (type_id == 10) {
                window.open("{{url('ticketing/downloadByIdRequestCRA')}}/"+Helper.backTomin(id) , '_blank')
            }
        }

    </script>
@endsection