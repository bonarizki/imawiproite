@extends('resignation/master/master')
@section('breadcumb','Approval Resign')
@section('title','Approval')
@section('content')
<section id="basic-horizontal-layouts">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-content">
                    <div class="card-body card-dashboard table-responsive">
                        <table class="table table-striped table-bordered table-hover table-sm" id="table" width="100%" hidden>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Resign User</th>
                                    <th>Request Date</th>
                                    <th>Resign Date</th>
                                    <th>Reason</th>
                                    <th>Last Approve</th>
                                    <th>Approve</th>
                                    <th>Reject</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Resign User</th>
                                    <th>Request Date</th>
                                    <th>Resign Date</th>
                                    <th>Reason</th>
                                    <th>Last Approve</th>
                                    <th>Approve</th>
                                    <th>Reject</th>
                                    <th>Option</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Resign Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="form form-horizontal" id="form">
                @csrf
                <input type="text" id="resign_id" class="form-control" name="resign_id" hidden>
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
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="validasi()">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
                            <th style="width: 15%"><center>Approval Nik HR</center></th>
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
            $('.format-picker').datepicker({
                format: 'yyyy-mm-dd',
                orientation: "bottom"
            });

            $.fn.dataTable.ext.errMode = 'none';
            let table = $('#table').DataTable({
                serverSide: true,
                processing: true,
                destroy: true,
                ajax: "{{url('resignation/getDataForApprove')}}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "user.user_name",
                        name: "user.user_name"
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
                        data: "resign_id",
                        name: "resign_id",
                        render: function (data, type, row, meta) {
                            return approvalaAction('approve', row, '')
                        }
                    },
                    {
                        data: "resign_id",
                        name: "resign_id",
                        render: function (data, type, row, meta) {
                            return approvalaAction('reject', row, '')
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
                "columnDefs": [{
                        "targets": 0,
                        "searchable": false,
                        "orderable": false
                    },
                    {
                        "targets": [8,4],
                        "visible": checkHR(),
                        "searchable": false
                    }
                ],
                rowCallback: function (row, data, index) {
                    let result = approvalaAction('', data, 'rowcallback');
                    if (result == true) $(row).hide();
                },
                createdRow: function (row, data, index) {
                    if (data['resign_status'] == 'reject') {
                        $(row).addClass('table-danger');
                    }
                }
            });

            $('#table tbody').on('click', 'tr', function () {
                var data = table.row( this ).data();
                viewDetailResign(data.resign_id)
            } );

            $('#table').attr('hidden',false);
        });

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
            for (let index = 1; index <= 6; index++) {
                let approval_nik = 'resign_approval_nik';
                let object_name = `resign_approval`; //relationshipmodel
                approval_nik += `_${index}`
                if (row[approval_nik] != null && row[approval_nik + '_date'] != null) {
                    last_approve = `${row[approval_nik]} - ${row[object_name += index].user_name}` 
                }
            }
            return last_approve;
        }

        function approvalaAction(type, data, typeUse) { // type(reject/approve),data(data row),typeUse(columns/callrowback)
            let approver = "{{Auth::user()->user_nik}}";
            let array = arrayApproval(data); // data nama field resign nik approval 1- 6 yang tidak kosong
            let string = '';
            for (let index = 1; index <= 7; index++) { // looping 7 x karena approval 1 s/d 6  + hr
                //string digunakan untunk menyimpan nilai dari index yang akan di gunakan untuk memanggail approval (resign_approval_nik_1)
                string = index == 7 ?"hr" : index;
                if (data[`resign_approval_nik_${string}`] == approver) { // jika data resign approval nik sama dengan approver (di ambil dari session)
                    if (data[`resign_approval_nik_${string}_date`] != null || data[`resign_approval_nik_hr_date`] != null) { //kondisi jika user suda approve cek dari resign_approval_nik_String_date
                        if (data['resign_status'] != 'reject') {
                            return type != "reject" ? "Approved" : "";
                        }
                    } else {
                        if (typeUse == 'rowcallback') { // jika fungsi ini di jalankan dari rowcallbak maka akan menjalankan kondisi di bawah
                            if (data["resign_status"]=="reject") {
                                return true;
                            }else{
                                if (index != 1) {
                                    let result = ''
                                    if (index == 7) { // 7 == hr
                                        result = "not null"; // di define not null karena user hr bisa lihat semua 
                                    } else {
                                        result = data[`resign_approval_nik_${index - 1}_date`];
                                    }
                                    return result == null ? true : false; // jika true hide row jika false show row
                                }
                            }
                        } else { // jika fungsi ni di panggil oleh column makan dia akan menjalankan kondisi ini

                            if (type == 'reject') {
                                return `<button class="btn btn-danger btn-sm btn-block" onclick="event.stopPropagation();AlertApproval('${type}','${data.resign_id}','${string}')">
                                            <span class="fa fa-times"></span> Reject
                                        </button>`
                            } else {
                                return `<button class="btn btn-success btn-sm btn-block" onclick="event.stopPropagation();AlertApproval('${type}','${data.resign_id}','${string}')">
                                            <span class="fa fa-check"></span> Approve
                                        </button>`
                            }
                        }
                    }
                }
            }
        }

        function checkHR() {
            let hr = "72031703" // hardcode nik ardhini
            if (hr == "{{Auth::user()->user_nik}}") {
                return true
            } else {
                return false
            }
        }

        function arrayApproval(data) {
            let array = [];
            for (let index = 1; index <= 6; index++) { // looing data approval resign nik 1 - 6
                if (data[`resign_approval_nik_${index}`] != null) { // jika data looping approval nik tidak kosong maka di masukan kedalam array
                    array.push(`resign_approval_nik_${index}`);
                }
            }
            return array;
        }

        function updateApproval(type, id, index) {
            $.ajax({
                type: "put",
                url: "{{url('resignation/update/Approval')}}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    resign_id: id,
                    type: type,
                    index: index
                },
                success: function (response) {
                    sweetSuccess(response.message, response.data.message)
                    $('#table').DataTable().ajax.reload();
                    let dataSendMail = response.data.data.SendEmail
                    let userResign = response.data.data.userResign
                    if(dataSendMail != null ){
                        $.ajax({
                            type : "post",
                            data : {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                recipient_name : dataSendMail.user_name,
                                recipient_email : dataSendMail.user_email,
                                resign_code : userResign.resign_id,
                                requested_user : userResign.user.user_name,
                                resign_user_department : userResign.user.department.department_name,
                                resign_user_title : userResign.user.title.title_name,
                                resign_user_grade : userResign.user.grade.grade_name,
                                type : dataSendMail.user_nik == '45121101' ? 'updated' : 'approval'
                            },
                            url : "{{url('resignation/send-mail/resign')}}",
                            success : function(res) {
                                console.log(index)
                            },
                            error : function(jqXhr, errorThrown, textStatus) {
                                console.log(errorThrown);
                            }
                        });
                    }
                }
            })
        }

        function sweetError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: message,
            })
        }

        function sweetSuccess(status, message) {
            Swal.fire({
                title: 'Good job!',
                text: message,
                icon: status
            })
        }

        function edit(id) {
            $.ajax({
                type:"get",
                url:"{{url('resignation/detail')}}",
                data:{
                    _token : $('meta[name="csrf-token"]').attr('content'),
                    resign_id : id,
                },
                success:function(response){
                    let data = response.data.data;
                    resignNotice(data.user.grade.grade_group.grade_group_name);
                    $("#user_name").val(data.user.user_name);
                    $("#resign_id").val(data.resign_id);
                    $("#resign_request_date").val(data.resign_request_date);
                    $("#resign_date").val(data.resign_date);
                    $("#resign_reason").val(data.resign_reason);
                    $(`.resign_user_initation-${data.resign_user_initation}`).prop("checked", true);
                    $(`.resign_user_talent-${data.resign_user_talent}`).prop("checked", true);
                    $('#modal').modal("show");
                }
            })
        }

        function resignNotice(grade_group_name)
        {
            if(grade_group_name == 'Workman' || grade_group_name == 'Promoter' || grade_group_name == 'Staff' || grade_group_name == 'Supervisor'){
                $('#alert-notice').text("Minimal Resign Date 1 Month Notice")
            }else if(grade_group_name == 'Executive' || grade_group_name == 'Manager'){
                $('#alert-notice').text("Minimal Resign Date 2 Month Notice")
            }else if(grade_group_name == 'Senior Manager'){
                $('#alert-notice').text("Minimal Resign Date 3 Month Notice")
            }
        }

        function validasi() {
            $('.is-invalid').removeClass('is-invalid')
            let data = $('#form').serializeArray();
            console.log(data)
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

        function loopingValidasi(data) {
            let dataArray = [];
            for (let index = 0; index < data.length; index++) {
                if (data[index]['value'] == '') {
                    dataArray.push(data[index]['name'])
                }
            }
            return dataArray;
        }

        function update() {
            let data = $('#form').serialize()
            $.ajax({
                type:"put",
                url:"{{url('resignation/update/Resign')}}",
                data:data,
                success:function(response){
                    sweetSuccess(response.message, response.data.message)
                    $('#table').DataTable().ajax.reload();
                    $('#modal').modal("hide");
                    $("#form")[0].reset();
                }
            })
        }

        function AlertApproval(type, id, index){
            Swal.fire( {
                title: `Are you sure to ${type} this resignation request?`,
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, ${type} it!`,
                preConfirm : function()  {
                    updateApproval(type, id, index)
                }
            })
        }
    </script>
@endsection