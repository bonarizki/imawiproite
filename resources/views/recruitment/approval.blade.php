@extends('layouts.recruitment')

@section('assets-top')
<style type="text/css">
    .table > tbody > tr > td > a > i {
        font-size: 18px;
    }
    .container-checkbox, .container-radio {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 15px;
        font-weight: 450 !important;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    .container-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }
    .container-radio input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }
    .container-checkbox .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #eee;
    }
    .container-radio .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 50%;
    }
    .container-checkbox:hover input ~ .checkmark, .container-radio:hover input ~ .checkmark {
        background-color: #ccc;
    }
    .container-checkbox input:checked ~ .checkmark, .container-radio input:checked ~ .checkmark {
        background-color: #2196F3;
    }
    .container-checkbox .checkmark:after, .container-radio .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }
    .container-checkbox input:checked ~ .checkmark:after, .container-radio input:checked ~ .checkmark:after {
        display: block;
    }
    .container-checkbox .checkmark:after {
        left: 7px;
        top: 3px;
        width: 6px;
        height: 11px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
    .container-radio .checkmark:after {
        top: 8.5px;
        left: 8.5px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: white;
    }
    .table-view thead tr th, .table-view tbody tr td {
        padding: .25rem;
        border-color: #E0E0E0;
    }
    .table-view thead tr th {
        background-color: #EFEFEF;
    }
    .table-view tbody tr td span {
        font-size: 12px;
    }
    .table-view tbody tr td img {
        margin-top: 5px;
        margin-bottom: 5px;
    }
    .table-view tbody tr td div {
        min-height: 184px;
    }
</style>
@endsection

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb -->
<!-- ============================================================== -->
<div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <h2 class="content-header-title float-left mb-0">Recruitment Approval</h2>
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Recruitment</a>
                    </li>
                    <li class="breadcrumb-item active">Approval
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid -->
<!-- ============================================================== -->
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-success btn-approve" style="width: 150px;">APPROVE</button>
                    <button type="button" class="btn btn-danger btn-reject" style="width: 150px;">REJECT</button>
                    <table class="table table-bordered table-striped" id="table-approval" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 25px;"> # </th>
                                <th> Reference No </th>
                                <th> Requested Title </th>
                                <th> Requested Grade </th>
                                <th> Point of Hire </th>
                                <th> Requested By </th>
                                <th style="text-align: center;"> Status </th>
                                <th style="text-align: center; width: 41px;"> View </th>
                                <th style="text-align: center; width: 41px;"> Export </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ============================================================== -->
<!-- End container fluid -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Begin Modal view -->
<!-- ============================================================== -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="viewRecruit">
    <div class="modal-dialog modal-lg" style="max-width: 1000px;">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title">View Recruit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <p class="col-4">Requested By</p>
                                <p class="col-1">:</p>
                                <p class="col-7 requested_by"></p>
                            </div>
                            <div class="row">
                                <p class="col-4">Position</p>
                                <p class="col-1">:</p>
                                <p class="col-7 requestor_pos"></p>
                            </div>
                            <div class="row">
                                <p class="col-4">Department</p>
                                <p class="col-1">:</p>
                                <p class="col-7 department"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <p class="col-4">Date of Request</p>
                                <p class="col-1">:</p>
                                <p class="col-7 request_date"></p>
                            </div>
                            <div class="row">
                                <p class="col-4">Ticket No</p>
                                <p class="col-1">:</p>
                                <p class="col-7 request_code"></p>
                            </div>
                            <div class="row">
                                <p class="col-4">Status</p>
                                <p class="col-1">:</p>
                                <p class="col-7 recruit_status"></p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <p class="col-3">Title</p>
                        <p class="col-1">:</p>
                        <p class="col-8 title"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Grade</p>
                        <p class="col-1">:</p>
                        <p class="col-8 grade"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Sex</p>
                        <p class="col-1">:</p>
                        <p class="col-8 sex"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Age</p>
                        <p class="col-1">:</p>
                        <p class="col-8 age"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Reason for Request</p>
                        <p class="col-1">:</p>
                        <p class="col-8 reason_for_request"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Point of Hire</p>
                        <p class="col-1">:</p>
                        <p class="col-8 point_of_hire"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Employment Status</p>
                        <p class="col-1">:</p>
                        <p class="col-8 employment_status"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Expected Join Date</p>
                        <p class="col-1">:</p>
                        <p class="col-8 expected_join_date"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Status of Recruitment</p>
                        <p class="col-1">:</p>
                        <p class="col-8 recruitment_status"></p>
                    </div>
                    <h4>Basic Requirements</h4>
                    <div class="row">
                        <p class="col-3">Education</p>
                        <p class="col-1">:</p>
                        <p class="col-8 education"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">General Competency</p>
                        <p class="col-1">:</p>
                        <p class="col-8 general_competency"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Specific Competency</p>
                        <p class="col-1">:</p>
                        <p class="col-8 specific_competency"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Job Description</p>
                        <p class="col-1">:</p>
                        <p class="col-8 job_description"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Special Note</p>
                        <p class="col-1">:</p>
                        <p class="col-8 special_note"></p>
                    </div>
                    <h4>Proposed Package</h4>
                    <div class="row">
                        <p class="col-3">Basic Salary</p>
                        <p class="col-1">:</p>
                        <p class="col-8">Rp. <span class="numbers basic_salary"></span></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Allowances</p>
                        <p class="col-1">:</p>
                        <p class="col-8">Rp. <span class="numbers allowances"></span></p>
                    </div>
                    <br>
                    <div class="row">
                        <p class="col-3">Organization Structure</p>
                        <p class="col-1">:</p>
                        <p class="col-8 organization_structure"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Organization Structure Attachment</p>
                        <p class="col-1">:</p>
                        <div class="col-8 organization_structure_attach"></div>
                    </div>
                    <hr>
                    <table class="table table-bordered table-view">
                        <thead>
                            <tr>
                                <th style="text-align: center;"> Requested By </th>
                                <th colspan="4" style="text-align: center;"> Approved By </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center; width: 20%;">
                                    <div>
                                        <span class="position_proposed"></span><br>
                                        <img src="{{ asset('images/approved.png') }}" style="width: 100%;"><br>
                                        <span class="name_proposed"></span><br>
                                        <span class="nik_proposed"></span><br>
                                        <span class="date_proposed"></span>
                                    </div>
                                </td>
                                <td style="text-align: center; width: 20%;">
                                    <div>
                                        <span class="position_approval_1"></span><br>
                                        <span class="image_approval_1"></span><br>
                                        <span class="name_approval_1"></span><br>
                                        <span class="nik_approval_1"></span><br>
                                        <span class="date_approval_1"></span>
                                    </div>
                                </td>
                                <td style="text-align: center; width: 20%;">
                                    <div>
                                        <span class="position_approval_2"></span><br>
                                        <span class="image_approval_2"></span><br>
                                        <span class="name_approval_2"></span><br>
                                        <span class="nik_approval_2"></span><br>
                                        <span class="date_approval_2"></span>
                                    </div>
                                </td>
                                <td style="text-align: center; width: 20%;">
                                    <div>
                                        <span class="position_approval_3"></span><br>
                                        <span class="image_approval_3"></span><br>
                                        <span class="name_approval_3"></span><br>
                                        <span class="nik_approval_3"></span><br>
                                        <span class="date_approval_3"></span>
                                    </div>
                                </td>
                                <td style="text-align: center; width: 20%;">
                                    <div>
                                        <span class="position_approval_4"></span><br>
                                        <span class="image_approval_4"></span><br>
                                        <span class="name_approval_4"></span><br>
                                        <span class="nik_approval_4"></span><br>
                                        <span class="date_approval_4"></span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-6">
                            <table class="table table-bordered table-view">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="text-align: center;"> Approved By </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: center; width: 50%;">
                                            <div>
                                                <span class="position_approval_5"></span><br>
                                                <span class="image_approval_5"></span><br>
                                                <span class="name_approval_5"></span><br>
                                                <span class="nik_approval_5"></span><br>
                                                <span class="date_approval_5"></span>
                                            </div>
                                        </td>
                                        <td style="text-align: center; width: 50%;">
                                            <div>
                                                <span class="position_approval_6"></span><br>
                                                <span class="image_approval_6"></span><br>
                                                <span class="name_approval_6"></span><br>
                                                <span class="nik_approval_6"></span><br>
                                                <span class="date_approval_6"></span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-3">
                            <table class="table table-bordered table-view">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;"> Approved By CEO </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: center;">
                                            <div>
                                                <span class="position_approval_ceo"></span><br>
                                                <span class="image_approval_ceo"></span><br>
                                                <span class="name_approval_ceo"></span><br>
                                                <span class="nik_approval_ceo"></span><br>
                                                <span class="date_approval_ceo"></span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-3">
                            <table class="table table-bordered table-view">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;"> Reviewed By HR </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: center;">
                                            <div>
                                                <span class="position_approval_hr"></span><br>
                                                <span class="image_approval_hr"></span><br>
                                                <span class="name_approval_hr"></span><br>
                                                <span class="nik_approval_hr"></span><br>
                                                <span class="date_approval_hr"></span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="approval_note_1"></div>
                    <div class="approval_note_2"></div>
                    <div class="approval_note_3"></div>
                    <div class="approval_note_4"></div>
                    <div class="approval_note_5"></div>
                    <div class="approval_note_6"></div>
                    <div class="approval_note_ceo"></div>
                    <div class="approval_note_hr"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Modal view -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Begin Modal Approve -->
<!-- ============================================================== -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="approveRecruit">
    <div class="modal-dialog modal-lg" style="max-width: 1000px;">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title">Approve Recruit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>You're going to Approve these Recruits</h4><br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 5%; text-align: center;"> No </th>
                                <th> Reference No </th>
                                <th> Requested Title </th>
                                <th> Requested Grade </th>
                                <th> Requested By </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <br>
                    <div class="form-group">
                        <label>Note</label>
                        <textarea name="note" class="form-control" rows="4" placeholder="Note for this approval recruits.."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-flat btn-success">Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Modal Approve -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Begin Modal Reject -->
<!-- ============================================================== -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="rejectRecruit">
    <div class="modal-dialog modal-lg" style="max-width: 1000px;">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title">Reject Recruit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>You're going to Reject these Recruits</h4><br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 5%; text-align: center;"> No </th>
                                <th> Reference No </th>
                                <th> Requested Title </th>
                                <th> Requested Grade </th>
                                <th> Requested By </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <br>
                    <div class="form-group">
                        <label>Note</label>
                        <textarea name="note" class="form-control" rows="4" placeholder="Reason to reject the recruits" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-flat btn-danger">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Modal Reject -->
<!-- ============================================================== -->
@endsection

@section('assets-bottom')
<script type="text/javascript">
	
	$(document).ready(function() {

        setTimeout(function() {
            $('.nav-approval').addClass('sidebar-group-active').addClass('active').addClass('open');
        }, 3000);

        $('.select2').select2();
        $('.numbers').autoNumeric('init', {mDec : '0'});

		var table = $('#table-approval').DataTable({
			processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/recruitment/recruit') }}",
                data : function(d) {
                    d.page = 'approval';
                }
            },
            columns : [
                { data : 'check_approval', name : 'check_approval' },
                { data : 'request_code', name : 'request_code' },
                { data : 'title_name', name : 'title_name' },
                { data : 'grade', name : 'grade' },
                { data : 'point_of_hire', name : 'point_of_hire' },
                { data : 'user', name : 'user' },
                { data : 'status', name : 'status' },
                { data : 'view', name : 'view' },
                { data : 'export', name : 'export' }
            ],
            columnDefs : [
                { orderable : false, targets : [0,6,7,8] },
                { searchable : false, targets : [0,6,7,8] },
                { createdCell : function(td, data, rowData, row, col) {
                    $(td).css('text-align', 'center') }, targets : [0,6,7,8]
                }
            ],
			order : [],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
		});

        setTimeout(function() {
            table.draw();
        }, 2000);

        $(document).on('click', '.btn-approve', function(e) {
            var modal = $('#approveRecruit');

            modal.find('table tbody').empty();
            modal.find('input[name="recruit_id[]"]').remove();

            $('input[name="approval[]"]:checked').each(function(index) {
                var id = $(this).val();
                modal.find('.modal-body').append('<input type="hidden" name="recruit_id[]" value="'+id+'">');
                $.ajax({
                    type : "GET",
                    url : "{{ url('api/recruitment/get-recruit') }}?id="+id,
                    dataType : "JSON",
                    success : function(res) {
                        modal.find('table tbody').append('<tr><td>'+(index+1)+'</td><td>'+res.request_code+'</td><td>'+res.title_name+'</td><td>['+res.grade_code+'] '+res.grade_name+'</td><td>['+res.user_nik+'] '+res.user_name+'</td></tr>');
                    },
                    error : function(jqXhr, errorThrown, textStatus) {
                        console.log(errorThrown);
                    }
                });
            });

            modal.modal('show');
        });

        $(document).on('click', '.btn-reject', function(e) {
            var modal = $('#rejectRecruit');

            modal.find('table tbody').empty();
            modal.find('input[name="recruit_id[]"]').remove();
            modal.find('textarea').val('');

            $('input[name="approval[]"]:checked').each(function(index) {
                var id = $(this).val();
                modal.find('.modal-body').append('<input type="hidden" name="recruit_id[]" value="'+id+'">');
                $.ajax({
                    type : "GET",
                    url : "{{ url('api/recruitment/get-recruit') }}?id="+id,
                    dataType : "JSON",
                    success : function(res) {
                        modal.find('table tbody').append('<tr><td>'+(index+1)+'</td><td>'+res.request_code+'</td><td>'+res.title_name+'</td><td>['+res.grade_code+'] '+res.grade_name+'</td><td>['+res.user_nik+'] '+res.user_name+'</td></tr>');
                    },
                    error : function(jqXhr, errorThrown, textStatus) {
                        console.log(errorThrown);
                    }
                });
            });

            modal.modal('show');
        });

        $(document).on('submit', '#approveRecruit form', function(e) {
            e.preventDefault();

            $.ajax({
                url : "{{ url('recruitment/approve') }}",
                type : "POST",
                data : $('#approveRecruit form').serialize(),
                success : function(res) {
                    table.draw(false);
                    $('#approveRecruit').modal('hide');

                    $.each(res.data, function(key, val) {
                        if(val['icon'] == 'success') {
                            if(val['status'] == 'process') {
                                for(var i=0; i<val['processor'].length; i++) {
                                    $.ajax({
                                        type : "POST",
                                        url : "{{ url('recruitment/send-mail') }}",
                                        data : {
                                            "_token" : "{{ csrf_token() }}",
                                            type : "processing",
                                            recipient_name : val['processor'][i]['recipient_name'],
                                            recipient_email : val['processor'][i]['recipient_email'],
                                            recruit_code : val['recruit_code'],
                                            recruit_request : val['recruit_request'],
                                            recruit_title : val['recruit_title'],
                                            recruit_grade : val['recruit_grade']
                                        },
                                        success : function(res) {
                                            toastr.success(val['title'], 'Recruits Approved', { "closeButton": true });
                                        },
                                        error : function(jqXhr, errorThrown, textStatus) {
                                            console.log(errorThrown);
                                        }
                                    });
                                }
                            } else {
                                $.ajax({
                                    type : "POST",
                                    url : "{{ url('recruitment/send-mail') }}",
                                    data : {
                                        "_token" : "{{ csrf_token() }}",
                                        type : "approval",
                                        recipient_name : val['recipient_name'],
                                        recipient_email : val['recipient_email'],
                                        recruit_code : val['recruit_code'],
                                        recruit_request : val['recruit_request'],
                                        recruit_title : val['recruit_title'],
                                        recruit_grade : val['recruit_grade']
                                    },
                                    success : function(res) {
                                        toastr.success(val['title'], 'Recruits Approved', { "closeButton": true });
                                    },
                                    error : function(jqXhr, errorThrown, textStatus) {
                                        console.log(errorThrown);
                                    }
                                });
                            }
                        } else if(val['icon'] == 'error') {
                            toastr.error(val['title'], 'Error', { "closeButton" : true });
                        }
                    });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        });

        $(document).on('submit', '#rejectRecruit form', function(e) {
            e.preventDefault();

            $.ajax({
                url : "{{ url('recruitment/reject') }}",
                type : "POST",
                data : $('#rejectRecruit form').serialize(),
                success : function(res) {
                    table.draw(false);
                    $('#rejectRecruit').modal('hide');

                    $.each(res.data, function(key, val) {
                        if(val['icon'] == 'success') {
                            toastr.success(val['title'], 'Recruits Rejected', { "closeButton": true });
                        } else if(val['icon'] == 'error') {
                            toastr.error(val['title'], 'Error', { "closeButton" : true });
                        }
                    });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        });

        $(document).on('click', '.btn-view', function(e) {
            var modal = $('#viewRecruit');
            var id = e.currentTarget.dataset.id;

            var month_arr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            var approved = '<img src="{{ asset("images/approved.png") }}" style="width: 100%;">';
            var rejected = '<img src="{{ asset("images/rejected.png") }}" style="width: 100%;">';

            $.ajax({
                type : "GET",
                url : "{{ url('api/recruitment/get-recruit') }}?id="+id,
                dataType : "JSON",
                success : function(res) {
                    modal.find('.requested_by').html('['+res.user_nik+'] '+res.user_name);
                    modal.find('.requestor_pos').html(res.user_title);
                    modal.find('.department').html(res.department_name);

                    var d = new Date(res.request_date);
                    var date = d.getDate();
                    var month = d.getMonth();
                    var year = d.getFullYear();

                    modal.find('.request_date').html(month_arr[month]+' '+date+', '+year);
                    modal.find('.request_code').html(res.request_code);

                    if(res.recruit_status == 'PENDING') {
                        modal.find('.recruit_status').html('<span class="text-muted">PENDING</span>');
                    } else if(res.recruit_status == 'REJECTED') {
                        modal.find('.recruit_status').html('<span class="text-danger">REJECTED</span>');
                    } else if(res.recruit_status == 'CANCELED') {
                        modal.find('.recruit_status').html('<span class="text-warning">CANCELED</span>');
                    } else if(res.recruit_status == 'ON PROCESS') {
                        modal.find('.recruit_status').html('<span class="text-primary">ON PROCESS</span>');
                    } else if(res.recruit_status == 'FULFILLED') {
                        modal.find('.recruit_status').html('<span class="text-success">FULFILLED</span>');
                    }

                    modal.find('.title').html(res.title_name);
                    modal.find('.grade').html('['+res.grade_code+'] '+res.grade_name);
                    modal.find('.sex').html(res.sex);
                    modal.find('.age').html(res.minimum_age+' Minimum & '+res.maximum_age+' Maximum');
                    modal.find('.reason_for_request').html(res.reason_for_request);
                    modal.find('.point_of_hire').html(res.point_of_hire_name);
                    
                    if(res.employment_status == 'Permanent') {
                        modal.find('.employment_status').html('Permanent with '+res.probation_length+' months probation');
                    } else if(res.employment_status == 'Contract') {
                        modal.find('.employment_status').html('Contract for '+res.contract_length+' months');
                    } else if(res.employment_status == 'Internship') {
                        modal.find('.employment_status').html('Internship for '+res.internship_length+' months');
                    } else if(res.employment_status == 'Daily Worker') {
                        modal.find('.employment_status').html('Daily Worker for '+res.daily_worker_length+' days for '+res.daily_worker_person+' persons');
                    }

                    var d = new Date(res.expected_join_date);
                    var date = d.getDate();
                    var month = d.getMonth();
                    var year = d.getFullYear();

                    modal.find('.expected_join_date').html(month_arr[month]+' '+date+', '+year);
                    modal.find('.recruitment_status').html(res.recruitment_status);

                    if(res.education != 'Other') {
                        modal.find('.education').html(res.education);
                    } else {
                        modal.find('.education').html(res.education_other);
                    }

                    modal.find('.general_competency').html(res.general_competency);
                    modal.find('.specific_competency').html(res.specific_competency);
                    modal.find('.job_description').html(res.job_description);

                    if(res.special_note != null || res.special_note != '-') {
                        modal.find('.special_note').html(res.special_note);
                    } else {
                        modal.find('.special_note').html('-');
                    }

                    modal.find('.basic_salary').autoNumeric('set', res.basic_salary);
                    modal.find('.allowances').autoNumeric('set', res.allowances);
                    modal.find('.organization_structure').html(res.organization_structure);

                    if(res.organization_structure_attach) {
                        modal.find('.organization_structure_attach').html('<a href="{!! asset("/file_uploads/organization_structure/'+res.organization_structure_attach+'") !!}" target="_blank" class="btn btn-primary btn-download"> Download <i class="fa fa-download"></i></a>')
                    } else {
                        modal.find('.organization_structure_attach').html('-');
                    }

                    modal.find('.position_proposed').html(res.user_title);
                    modal.find('.name_proposed').html(res.user_name);
                    modal.find('.nik_proposed').html(res.user_nik);
                    modal.find('.date_proposed').html(moment(res.request_date).format('DD MMM YYYY'));

                    if(res.recruit_approval_status_1 != null) {
                        modal.find('.position_approval_1').html(res.recruit_approval_title_1);
                        modal.find('.name_approval_1').html(res.recruit_approval_name_1);
                        modal.find('.nik_approval_1').html(res.recruit_approval_nik_1);
                        modal.find('.date_approval_1').html(moment(res.recruit_approval_date_1).format('DD MMM YYYY'));
                        if(res.recruit_approval_status_1 == '1') {
                            modal.find('.image_approval_1').html(approved);
                        } else if(res.recruit_approval_status_1 == '0') {
                            modal.find('.image_approval_1').html(rejected);
                        }
                    } else if(res.recruit_approval_nik_1 != null) {
                        modal.find('.position_approval_1').html('Waiting for Approval');
                        modal.find('.image_approval_1').html('');
                        modal.find('.name_approval_1').html(res.recruit_approval_name_1);
                        modal.find('.nik_approval_1').html(res.recruit_approval_nik_1);
                        modal.find('.date_approval_1').html('');
                    } else {
                        modal.find('.position_approval_1').html('');
                        modal.find('.image_approval_1').html('');
                        modal.find('.name_approval_1').html('');
                        modal.find('.nik_approval_1').html('');
                        modal.find('.date_approval_1').html('');
                    }

                    if(res.recruit_approval_status_2 != null) {
                        modal.find('.position_approval_2').html(res.recruit_approval_title_2);
                        modal.find('.name_approval_2').html(res.recruit_approval_name_2);
                        modal.find('.nik_approval_2').html(res.recruit_approval_nik_2);
                        modal.find('.date_approval_2').html(moment(res.recruit_approval_date_2).format('DD MMM YYYY'));
                        if(res.recruit_approval_status_2 == '1') {
                            modal.find('.image_approval_2').html(approved);
                        } else if(res.recruit_approval_status_2 == '0') {
                            modal.find('.image_approval_2').html(rejected);
                        }
                    } else if(res.recruit_approval_nik_2 != null) {
                        modal.find('.position_approval_2').html('Waiting for Approval');
                        modal.find('.image_approval_2').html('');
                        modal.find('.name_approval_2').html(res.recruit_approval_name_2);
                        modal.find('.nik_approval_2').html(res.recruit_approval_nik_2);
                        modal.find('.date_approval_2').html('');
                    } else {
                        modal.find('.position_approval_2').html('');
                        modal.find('.image_approval_2').html('');
                        modal.find('.name_approval_2').html('');
                        modal.find('.nik_approval_2').html('');
                        modal.find('.date_approval_2').html('');
                    }

                    if(res.recruit_approval_status_3 != null) {
                        modal.find('.position_approval_3').html(res.recruit_approval_title_3);
                        modal.find('.name_approval_3').html(res.recruit_approval_name_3);
                        modal.find('.nik_approval_3').html(res.recruit_approval_nik_3);
                        modal.find('.date_approval_3').html(moment(res.recruit_approval_date_3).format('DD MMM YYYY'));
                        if(res.recruit_approval_status_3 == '1') {
                            modal.find('.image_approval_3').html(approved);
                        } else if(res.recruit_approval_status_3 == '0') {
                            modal.find('.image_approval_3').html(rejected);
                        }
                    } else if(res.recruit_approval_nik_3 != null) {
                        modal.find('.position_approval_3').html('Waiting for Approval');
                        modal.find('.image_approval_3').html('');
                        modal.find('.name_approval_3').html(res.recruit_approval_name_3);
                        modal.find('.nik_approval_3').html(res.recruit_approval_nik_3);
                        modal.find('.date_approval_3').html('');
                    } else {
                        modal.find('.position_approval_3').html('');
                        modal.find('.image_approval_3').html('');
                        modal.find('.name_approval_3').html('');
                        modal.find('.nik_approval_3').html('');
                        modal.find('.date_approval_3').html('');
                    }

                    if(res.recruit_approval_status_4 != null) {
                        modal.find('.position_approval_4').html(res.recruit_approval_title_4);
                        modal.find('.name_approval_4').html(res.recruit_approval_name_4);
                        modal.find('.nik_approval_4').html(res.recruit_approval_nik_4);
                        modal.find('.date_approval_4').html(moment(res.recruit_approval_date_4).format('DD MMM YYYY'));
                        if(res.recruit_approval_status_4 == '1') {
                            modal.find('.image_approval_4').html(approved);
                        } else if(res.recruit_approval_status_4 == '0') {
                            modal.find('.image_approval_4').html(rejected);
                        }
                    } else if(res.recruit_approval_nik_4 != null) {
                        modal.find('.position_approval_4').html('Waiting for Approval');
                        modal.find('.image_approval_4').html('');
                        modal.find('.name_approval_4').html(res.recruit_approval_name_4);
                        modal.find('.nik_approval_4').html(res.recruit_approval_nik_4);
                        modal.find('.date_approval_4').html('');
                    } else {
                        modal.find('.position_approval_4').html('');
                        modal.find('.image_approval_4').html('');
                        modal.find('.name_approval_4').html('');
                        modal.find('.nik_approval_4').html('');
                        modal.find('.date_approval_4').html('');
                    }

                    if(res.recruit_approval_status_5 != null) {
                        modal.find('.position_approval_5').html(res.recruit_approval_title_5);
                        modal.find('.name_approval_5').html(res.recruit_approval_name_5);
                        modal.find('.nik_approval_5').html(res.recruit_approval_nik_5);
                        modal.find('.date_approval_5').html(moment(res.recruit_approval_date_5).format('DD MMM YYYY'));
                        if(res.recruit_approval_status_5 == '1') {
                            modal.find('.image_approval_5').html(approved);
                        } else if(res.recruit_approval_status_5 == '0') {
                            modal.find('.image_approval_5').html(rejected);
                        }
                    } else if(res.recruit_approval_nik_5 != null) {
                        modal.find('.position_approval_5').html('Waiting for Approval');
                        modal.find('.image_approval_5').html('');
                        modal.find('.name_approval_5').html(res.recruit_approval_name_5);
                        modal.find('.nik_approval_5').html(res.recruit_approval_nik_5);
                        modal.find('.date_approval_5').html('');
                    } else {
                        modal.find('.position_approval_5').html('');
                        modal.find('.image_approval_5').html('');
                        modal.find('.name_approval_5').html('');
                        modal.find('.nik_approval_5').html('');
                        modal.find('.date_approval_5').html('');
                    }

                    if(res.recruit_approval_status_6 != null) {
                        modal.find('.position_approval_6').html(res.recruit_approval_title_6);
                        modal.find('.name_approval_6').html(res.recruit_approval_name_6);
                        modal.find('.nik_approval_6').html(res.recruit_approval_nik_6);
                        modal.find('.date_approval_6').html(moment(res.recruit_approval_date_6).format('DD MMM YYYY'));
                        if(res.recruit_approval_status_6 == '1') {
                            modal.find('.image_approval_6').html(approved);
                        } else if(res.recruit_approval_status_6 == '0') {
                            modal.find('.image_approval_6').html(rejected);
                        }
                    } else if(res.recruit_approval_nik_6 != null) {
                        modal.find('.position_approval_6').html('Waiting for Approval');
                        modal.find('.image_approval_6').html('');
                        modal.find('.name_approval_6').html(res.recruit_approval_name_6);
                        modal.find('.nik_approval_6').html(res.recruit_approval_nik_6);
                        modal.find('.date_approval_6').html('');
                    } else {
                        modal.find('.position_approval_6').html('');
                        modal.find('.image_approval_6').html('');
                        modal.find('.name_approval_6').html('');
                        modal.find('.nik_approval_6').html('');
                        modal.find('.date_approval_6').html('');
                    }

                    if(res.recruit_approval_status_ceo != null) {
                        modal.find('.position_approval_ceo').html(res.recruit_apprval_title_ceo);
                        modal.find('.name_approval_ceo').html(res.recruit_approval_name_ceo);
                        modal.find('.nik_approval_ceo').html(res.recruit_approval_nik_ceo);
                        modal.find('.date_approval_ceo').html(moment(res.recruit_approval_date_ceo).format('DD MMM YYYY'));
                        if(res.recruit_approval_status_ceo == '1') {
                            modal.find('.image_approval_ceo').html(approved);
                        } else if(res.recruit_approval_status_ceo == '0') {
                            modal.find('.image_approval_ceo').html(rejected);
                        }
                    } else {
                        modal.find('.position_approval_ceo').html('');
                        modal.find('.image_approval_ceo').html('Waiting for Approval');
                        modal.find('.name_approval_ceo').html(res.recruit_approval_name_ceo);
                        modal.find('.nik_approval_ceo').html('');
                        modal.find('.date_approval_ceo').html('');
                    }

                    if(res.recruit_approval_status_hr != null) {
                        modal.find('.position_approval_hr').html(res.recruit_approval_title_hr);
                        modal.find('.name_approval_hr').html(res.recruit_approval_name_hr);
                        modal.find('.nik_approval_hr').html(res.recruit_approval_nik_hr);
                        modal.find('.date_approval_hr').html(moment(res.recruit_approval_date_hr).format('DD MMM YYYY'));
                        if(res.recruit_approval_status_hr == '1') {
                            modal.find('.image_approval_hr').html(approved);
                        } else if(res.recruit_approval_status_hr == '0') {
                            modal.find('.image_approval_hr').html(rejected);
                        }
                    } else {
                        modal.find('.position_approval_hr').html('');
                        modal.find('.image_approval_hr').html('Waiting for Approval');
                        modal.find('.name_approval_hr').html(res.recruit_approval_name_hr);
                        modal.find('.nik_approval_hr').html('');
                        modal.find('.date_approval_hr').html('');
                    }

                    if(res.recruit_approval_note_1 != null) {
                        var note = '<label class="font-weight-bold">Note from '+res.recruit_approval_name_1+'</label>'+
                            '<p>'+res.recruit_approval_note_1+'</p>';

                        modal.find('.approval_note_1').html(note);
                    } else {
                        modal.find('.approval_note_1').html('');
                    }

                    if(res.recruit_approval_note_2 != null) {
                        var note = '<label class="font-weight-bold">Note from '+res.recruit_approval_name_2+'</label>'+
                            '<p>'+res.recruit_approval_note_2+'</p>';

                        modal.find('.approval_note_2').html(note);
                    } else {
                        modal.find('.approval_note_2').html('');
                    }

                    if(res.recruit_approval_note_3 != null) {
                        var note = '<label class="font-weight-bold">Note from '+res.recruit_approval_name_3+'</label>'+
                            '<p>'+res.recruit_approval_note_3+'</p>';

                        modal.find('.approval_note_3').html(note);
                    } else {
                        modal.find('.approval_note_3').html('');
                    }

                    if(res.recruit_approval_note_4 != null) {
                        var note = '<label class="font-weight-bold">Note from '+res.recruit_approval_name_4+'</label>'+
                            '<p>'+res.recruit_approval_note_4+'</p>';

                        modal.find('.approval_note_4').html(note);
                    } else {
                        modal.find('.approval_note_4').html('');
                    }

                    if(res.recruit_approval_note_5 != null) {
                        var note = '<label class="font-weight-bold">Note from '+res.recruit_approval_name_5+'</label>'+
                            '<p>'+res.recruit_approval_note_5+'</p>';

                        modal.find('.approval_note_5').html(note);
                    } else {
                        modal.find('.approval_note_5').html('');
                    }

                    if(res.recruit_approval_note_6 != null) {
                        var note = '<label class="font-weight-bold">Note from '+res.recruit_approval_name_6+'</label>'+
                            '<p>'+res.recruit_approval_note_6+'</p>';

                        modal.find('.approval_note_6').html(note);
                    } else {
                        modal.find('.approval_note_6').html('');
                    }

                    if(res.recruit_approval_note_ceo != null) {
                        var note = '<label class="font-weight-bold">Note from '+res.recruit_approval_name_ceo+'</label>'+
                            '<p>'+res.recruit_approval_note_ceo+'</p>';

                        modal.find('.approval_note_ceo').html(note);
                    } else {
                        modal.find('.approval_note_ceo').html('');
                    }

                    if(res.recruit_approval_note_hr != null) {
                        var note = '<label class="font-weight-bold">Note from '+res.recruit_approval_name_hr+'</label>'+
                            '<p>'+res.recruit_approval_note_hr+'</p>';

                        modal.find('.approval_note_hr').html(note);
                    } else {
                        modal.find('.approval_note_hr').html('');
                    }
                },
                error : function(jqXhr, errorThrown, textStatus) {
                    console.log(errorThrown);
                }
            });

            modal.modal('show');
        });

	});

</script>
@endsection