@extends('ticketing/master/master')
@section('breadcumb','Approval Ticketing PO')
@section('title','Approval Ticketing PO')

@section('header')
    {{-- DataTables --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets_argon/vendor/datatables/datatables.min.css')}}"/>
    {{-- Select2 --}}
    {{-- <link rel="stylesheet" href="{{asset('assets_admin_lte/assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets_admin_lte/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}"> --}}
    <style>
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
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table class="table table-striped table-bordered table-hover table-sm" id="table" width="100%">
                            <thead>
                                <tr>
                                    <th style=" width: 5px !important;">#</th>
                                    <th style=" width: 55px !important;">Ticket ID</th>
                                    <th style=" width: 55px !important;">Ticket Type</th>
                                    <th style=" width: 55px !important;">Ticket Status</th>
                                    <th style=" width: 55px !important;">Date Ticket</th>
                                    <th style=" width: 55px !important;"><centr>Action</center></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th style=" width: 5px !important;">#</th>
                                    <th style=" width: 55px !important;">Ticket ID</th>
                                    <th style=" width: 55px !important;">Ticket Type</th>
                                    <th style=" width: 55px !important;">Ticket Status</th>
                                    <th style=" width: 55px !important;">Date Ticket</th>
                                    <th style=" width: 55px !important;"><centr>Action</center></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
                                            <th><b>File Attach Reqeuest</b></th>
                                        </tr>
                                        {{-- <tr class="table-active" id="file_offering">
                                            <th><b>File Attach Offering</b></th>
                                        </tr>
                                        <tr id="file_offering">

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
                <div id="approve-reject" hidden>
                    <button class="btn btn-danger" id="btn-reject">
                        <span class="fa fa-window-close" title="Reject" data-toggle="tooltip" data-placement="bottom">
                        </span>
                        Reject
                    </button>
                    <button class="btn btn-success" id="btn-approve">
                        <span class="fa fa-check-square" title="Approve" data-toggle="tooltip" data-placement="bottom">
                        </span>
                        Approve
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer')
<link type="text/css"  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"  rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
{{-- Datatables --}}
<script type="text/javascript" src="{{asset('assets_argon/vendor/datatables/datatables.min.js')}}"></script>
{{-- Helper & Validation --}}
<script src="{{asset('js/script.js')}}"></script>
<script>
    const Helper = new valbon();

    $(document).ready(function () {
        $('#table').DataTable({
            type: "get",
            destroy: true,
            info: false,
            language: {
                loadingRecords: "Please Wait - loading",
                processing: '<div class="se-pre-con"></div>',
                paginate: {
                    previous: "<b> < </b>",
                    next: "<b> > </b>",
                }
            },
            ajax: "{{url('ticketing/approval/data')}}",
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
                    render: (data) => {
                        return `
                                <center>
                                    <span class="badge badge-${chooseColorStatus(data)} .text-dark">${Helper.capitalizeFirstWords(data)}</span>
                                </center>
                                `
                    }
                },
                {
                    data: "created_at",
                    name: "created_at",
                    render: (data, meta, row) => {
                        return `${row.request_by.user_name} <br> ${data}`
                    }
                },
                {
                    data: "ticket_id",
                    name: "ticket_id",
                    render: (data) => {
                        return `<center>
                                    <button class="btn btn-sm btn-info" title="Detail" data-toggle="tooltip" data-placement="bottom" onclick="detail('${data}')">
                                        <span class="fa fa-eye">
                                        </span>
                                    </button>
                                </center>`
                    }
                },
            ],

            rowCallback: function (row, data, index) {
                let result = approvalaAction(data);
                if (result == true) $(row).hide(); // true untuk hide , false untuk show
            },
        })
    });

    chooseColorStatus = (ticket_status) => {
        if (ticket_status == 'initial') {
            return 'primary';
        } else if (ticket_status == 'process') {
            return 'info';
        } else if (ticket_status == 'approve') {
            return 'yellow';
        } else if (ticket_status == 'done') {
            return 'success';
        } else if (ticket_status == 'reject') {
            return 'danger';
        } else if (ticket_status == 'cancel') {
            return 'warning';
        }
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

    detail = (id) => {
        $('#detail-content').empty();
        $('#detail-approval').empty();
        $('#detail-approval-it').empty();
        $('#detail-participant').empty();
        $('#detail-barang').empty();
        $('#ticket_status').removeClass();
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


                let detailData = detailApproval(data); //mendapatkan data detail approval nik 1-6 dan approval nik ceo-hr
                $('#detail-approval').append(detailData.Number);
                $('#detail-approval-it').append(detailData.IT);

                $('#modal_detail').modal('show');
                $('.pdf').attr('onclick', `downloadPDF('${id}','${data.type_id}')`)
                // type === 'view' ? changeEditToView() : '';

                let condition = checkApproval(data.approval)
                if (condition == false) { // kondisi button
                    $('#approve-reject').attr('hidden', false);
                    $('#btn-reject').attr('onclick', `confirm('${id}','reject')`);

                    if (data.type_id == 10 && checkPIC(data) == true) {
                        $('#btn-approve').attr("onclick",`validate('edit','10','${id}')`)
                    }else{
                        $('#btn-approve').attr('onclick', `confirm('${id}','process')`);
                    }
                } else {
                    $('#approve-reject').attr('hidden', true);
                }

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
                                <tr class="table-active">
                                    <th style="width: 20%"><center><b>Category</b></center></th>
                                    <th style="width: 20%"><center><b>Nama Barang</b></center></th>
                                    <th style="width: 20%"><center><b>QTY</b></center></th>
                                    <th style="width: 20%"><center><b>Harga</b></center></th>
                                    <th style="width: 20%"><center><b>Total</b></center></th>
                                    <th style="width: 20%"><center>Accept User</center></th>
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
            $('#description').text(data.description == null ? "-" : data.reason);
            detailItem(data);
        }else if (data.type_id == 10) { // content detail cra dan form cra admin
            content = ` <h3>Detail Change Request Application</h3>
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
                                            <input class="form-check-input form-cra" type="radio" name="impact_cra" id="inlineRadio3" value="moderat">
                                            <label class="form-check-label" for="inlineRadio3">Moderat</label>
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
            let result = checkPIC(data)
            if (result == false) {
                $('.form-cra').prop( "disabled", true );
            }
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
                        <td>
                            <input type="checkbox" class="form-control checkbox" id="accept_user" data-id="${item.detail_po_id}" alt="Check When User Have Accept Item" onclick="updateAcceptUser(this)" ${ item.accept_user == 1 ? 'checked' : ''}>
                        </td>
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
                detailTableApprovalIT += detailContentApproval(data, objectApproval, approval_nik);
                detailTableApprovalIT += '</td>';
            } else {
                detailTableApproval += '<td>'
                detailTableApproval += detailContentApproval(data, objectApproval, approval_nik);
                detailTableApproval += '</td>';
            }
        }
        detailTableApproval += '</tr>';
        detailTableApprovalIT += '</tr>';

        return {
            Number: detailTableApproval,
            IT: detailTableApprovalIT
        };
    }

    chooseColorStatus = (ticket_status) => {
        if (ticket_status == 'initial') {
            return 'primary';
        } else if (ticket_status == 'process') {
            return 'info';
        } else if (ticket_status == 'approve') {
            return 'yellow';
        } else if (ticket_status == 'done') {
            return 'success';
        } else if (ticket_status == 'reject') {
            return 'danger';
        } else if (ticket_status == 'cancel') {
            return 'warning';
        }
    }

    detailContentApproval = (data, objectApproval, approval_nik) => {
        let detailApproval = ''
        let newData = data.approval;
        let array = arrayApproval(newData);
        array.push('ticketing_approval_nik_it1', 'ticketing_approval_nik_it2'); //menambahkan index
        if (newData[objectApproval] != null) {
            let detailAppover = newData[objectApproval].user_name; // mendapatkan nama approval
            detailApproval += `<center>${newData[approval_nik]}</center>
                                        <center>${detailAppover}</center>`;
            if (newData[approval_nik + '_date'] == null) {
                detailApproval += `<center> <i> waiting approval </i> </center>`
            } else {
                let image = chooseImage(array, approval_nik, newData, data) // mendapatkan gambar reject atau approve
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

    approvalaAction = (data) => {
        let data_approval = data.approval;
        let data_header = data;
        if (data_approval != null) {
            let approver = "{{Auth::user()->user_nik}}";
            let array = arrayApproval(data_approval); // data_approval nama field training nik approval 1- 6 yang tidak kosong
            let string = '';
            let result = '';
            for (let index = 1; index <= 8; index++) { // looping 8 x karena approval 1 s/d 6  + hr + ceo
                //string digunakan untunk menyimpan nilai dari index yang akan di gunakan 
                let string = chooseIndex(index);
                if (data_approval[`ticketing_approval_nik_${string}`] == approver) { // jika data_approval training approval nik sama dengan approver (approver di ambil dari session)
                    if (data_header.type_id == 10) {
                        if (string == 'it2') {
                            if (data_approval[`ticketing_approval_nik_${string}_date`] == null) {
                                result = false;
                                break;
                            }else{
                                result = true;
                                break;
                            }
                        }else{
                            if (index != 1) {
                                let field_date = `ticketing_approval_nik_${parseInt(string)-1}_date`;
                                if (data_approval[field_date] == null) { // jika approval nik sebelumnya null maka hide
                                    result = true;
                                    break
                                } else {
                                    if (data_approval[`ticketing_approval_nik_${string}_date`] != null) { // jika approval nik current tidak kosong maka hide
                                        result = true;
                                        break
                                    }

                                    result = false; // menapmpilkan 
                                    break
                                }
                            }else{
                                if (index == 1 && data_approval[`ticketing_approval_nik_${parseInt(string)}_date`] == null && data_approval[`ticketing_approval_nik_it2_date`] != null) {
                                    result = false;
                                    break;
                                }

                                result = true;
                                break;
                            }
                        }
                    }else{
                        if (index != 1) {
                            if (string == 'it2' || string == 'it1') { // untuk approval nik ceo dan hr
                                let LastApprovalNik = array[array.length - 1];

                                if (LastApprovalNik === undefined) {
                                    result = false;
                                    break;
                                } else if (data_approval[LastApprovalNik += '_date'] == null) {
                                    result = true;
                                    break;
                                } else {
                                    // jika approval nik current tidak kosong maka hide
                                    if (data_approval[`ticketing_approval_nik_${string}_date`] != null) {
                                        result = true;
                                        break
                                    }

                                    result = false;
                                    break;
                                }
                            } else { // untuk approval nik 1 - 6
                                let field_date = `ticketing_approval_nik_${parseInt(string)-1}_date`;
                                if (data_approval[field_date] == null) { // jika approval nik sebelumnya null maka hide
                                    result = true;
                                    break
                                } else {
                                    if (data_approval[`ticketing_approval_nik_${string}_date`] != null) { // jika approval nik current tidak kosong maka hide
                                        result = true;
                                        break
                                    }

                                    result = false; // menapmpilkan 
                                    break
                                }
                            }
                        } else {
                            if (index == 1 && data_approval[`ticketing_approval_nik_${parseInt(string)}_date`] == null) {
                                result = false;
                                break;
                            }

                            result = true
                            break;
                        }
                    }
                    
                }
            }
            return result;
        }
    }


    confirm = (id, type) => {
        Swal.fire({
            title: `Are you sure to ${type} this request?`,
            input: 'text',
            icon: 'warning',
            inputAttributes: {
                autocapitalize: 'off',
                placeholder: 'Note'
            },
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: `Yes, ${type} it!`,
            preConfirm: (note) => {
                updateApproveReject(id, type, note)
            },
            allowOutsideClick: () => !Swal.isLoading()
        })
    }

    updateApproveReject = (id, type, note) => {
        $.ajax({
            type: "patch",
            url: "{{url('ticketing/approval/data')}}",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                ticket_id: id,
                type: type,
                note: note,
            },
            beforeSend: () => {
                $('.se-pre-con').show();
            },
            success: (response) => {
                Helper.sweetSuccess(response.message, response.data.message);
                $(`#table`).DataTable().ajax.reload();
                $('#modal_detail').modal('hide');
                $('.se-pre-con').hide();
            },
            complete: () => {
                $('.se-pre-con').hide();
            }
        })
    }

    checkApproval = (data) => {
        let user_nik = "{{Auth::user()->user_nik}}";
        let training_approval = "ticketing_approval_nik_";
        let result = '';
        for (let index = 1; index <= 8; index++) {
            //string digunakan untunk menyimpan nilai dari index yang akan di gunakan 
            let string = chooseIndex(index);
            if (user_nik == data[`${training_approval+string}`]) {
                if (data[`${training_approval+string}_date`] != null) {
                    return true;
                    break;
                } else {
                    result = false; //false jika training_approval_{index}_date masih null
                    break;
                }
            }
        }
        return result;
    }

    chooseImage = (array, approval_nik, data) => {
        let inarr = array.indexOf(approval_nik)
        let image = ''
        if (data[array[inarr + 1] += '_date'] == null && data.training_status == 'reject') {
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
        } else if (index == 8) {
            str = 'it2'
        } else {
            str = index
        }

        return str;
    }

    arrayApproval = (data) => {
        let array = [];
        if (data != null) {
            for (let index = 1; index <= 6; index++) { // looing data approval training nik 1 - 6
                if (data[`ticketing_approval_nik_${index}`] != null) { // jika data looping approval nik tidak kosong maka di masukan kedalam array
                    array.push(`ticketing_approval_nik_${index}`);
                }
            }
        }
        return array;
    }

    formatRp = (data) => {
        let nominal = 'Rp. ' + parseInt(data).toLocaleString();
        return nominal;
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

        } else {
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

    checkPIC = (data) => {
        let nik = "{{Auth::user()->user_nik}}";
        let pic = '';
         $.ajax({
            async: false,
            type : 'get' , 
            url : `{{ url('ticketing/system/applications-pic')}}/${data.other_information}`,
            success : (res) => {
                pic = res.data
            }
        })
        if (pic == nik) {
           return true;
        }else{
           return false;
        }
    }

    //variable type untuk menentukan jenis apakah itu update atau add
    //variable type_id adalah id dari ticket_type
    validate = (type,type_id,id) => {
        // Helper.validasi('edit')
        let data = $('#form').serializeArray();
        let result = Helper.loopingValidasi(data)
        if (result.length == 0) {
            data.push({name:"type_id", value : type_id});
            if (type == 'edit') {
                update(data,id);
            } else {

            }
        } else {
            Helper.loopingErrorEmpty(result);
        }
    }

    update = (credentials,id) => {
        $.ajax({
            type:"patch",
            url:"{{url('ticketing/status/data')}}",
            data: credentials,
            beforeSend:() =>{
                $('.se-pre-con').show();
            },
            success:(response)=>{
                Helper.sweetSuccess(response.message,response.data.message);
                $(`#table-proceed`).DataTable().ajax.reload();
                Helper.closeModal('#modal_detail');
            },
            complete : () => {
                $('.se-pre-con').hide();
                confirm(id,'process');
            }
        })
    }

    const updateAcceptUser = (data ) => {
        let isChecked = $(data).is(':checked');
        id = $(data).attr("data-id")
        $.ajax({
            url : "{{ url('ticketing/approval/update-accept') }}",
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            data : {
                id : id,
                accept_user : isChecked == true ? 1 : 0
            },
            success : (res) => {
                console.log(res.message)
            }
        })
    }

</script>
@endsection