@extends('layouts.appraisal')

@section('assets-top')
<style type="text/css">
    .table thead th {
        vertical-align: middle !important;
    }
    #table-appraisal tbody tr td {
        vertical-align: middle;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Page Title -->
    <!-- ============================================================== -->
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">Appraisal Status</h2>
            </div>
            <div class="col-auto ml-auto d-print-none">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item active">Appraisal Status</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page Title -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-3" @if(in_array(Auth::user()->user_id, $hr) || in_array(Auth::user()->user_id, $hr_admin)) style="display: block;" @else style="display: none;" @endif>
                <div class="card-body pb-0">
                    <h5 class="font-weight-bold"><i class="fa fa-filter"></i> Filter </h5>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Department</label>
                                <select name="department_id" class="form-control select2 filter-table" style="width: 100%;">
                                    <option value="0">ALL DEPARTMENT</option>
                                    @foreach($department as $dept)
                                        <option value="{{ $dept->department_id }}">{{ $dept->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Level</label>
                                <select name="grade_group_id" class="form-control select2 filter-table" style="width: 100%;">
                                    <option value="0">ALL LEVEL</option>
                                    @foreach($grade_group as $gg)
                                        <option value="{{ $gg->grade_group_id }}">{{ $gg->grade_group_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select name="period_id" class="form-control select2-hide-search filter-table" style="width: 100%;">
                                @foreach($period_all as $p)
                                    <option value="{{ $p->period_id }}"{{ $p->period_id == $period->period_id ? ' selected' : '' }}>{{ $p->period_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped" id="table-appraisal" style="width: 100%;">
                        <thead>
                            <tr>
                                <th rowspan="2" style="text-align: center; width: 25px;"> No </th>
                                <th rowspan="2"> Employee </th>
                                <th rowspan="2"> Level </th>
                                <th rowspan="2"> Department </th>
                                <th rowspan="2" style="text-align: center; width: 150px;"> Status </th>
                                <th rowspan="2" style="text-align: center; width: 300px;"> Action Needed </th>
                                @if(in_array(Auth::user()->user_id, $hr) || in_array(Auth::user()->user_id, $hod) || in_array(Auth::user()->user_id, $ceo))
                                    <th colspan="3" style="text-align: center;"> Action </th>
                                @else
                                    <th colspan="2" style="text-align: center;"> Action </th>
                                @endif
                            </tr>
                            <tr>
                                @if(in_array(Auth::user()->user_id, $hr) || in_array(Auth::user()->user_id, $hod) || in_array(Auth::user()->user_id, $ceo))
                                    <th style="text-align: center; width: 50px;"> Edit </th>
                                @endif
                                <th style="text-align: center; width: 50px;"> View </th>
                                <th style="text-align: center; width: 50px;"> Export </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page Content -->
    <!-- ============================================================== -->
</div>

@include('appraisal.modal.in_progress')
@include('appraisal.modal.closed')

@include('appraisal.modal.in_progress_staff')
@include('appraisal.modal.closed_staff')

<!-- BEGIN MODAL FEEDBACK -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalFeedback">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <input type="hidden" name="id">
                <input type="hidden" name="type">
                <div class="modal-header">
                    <h3 class="modal-title">Give Feedback</h3>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label col-form-label">Feedback from Employee</label>
                        <textarea name="employee_feedback" class="form-control" rows="8" placeholder="Type feedback from employee.."></textarea>
                        <small class="text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODAL FEEDBACK -->

<!-- BEGIN MODAL FINAL SCORE OPEN -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="finalScoreOpen">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="post" class="form-horizontal">
                {{ csrf_field() }}
                <input type="hidden" name="id">
                <input type="hidden" name="type">
                <div class="modal-header">
                    <h3 class="modal-title">Final Score</h3>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-3">
                    <div class="row mb-1">
                        <div class="col-md-4">Employee NIK</div>
                        <div class="col-md-1">:</div>
                        <div class="col-md-7 employee_nik"></div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-4">Employee Name</div>
                        <div class="col-md-1">:</div>
                        <div class="col-md-7 employee_name"></div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-4">Department</div>
                        <div class="col-md-1">:</div>
                        <div class="col-md-7 department"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">Level</div>
                        <div class="col-md-1">:</div>
                        <div class="col-md-7 level"></div>
                    </div>
                    <hr style="margin-top: 1rem; margin-bottom: 1rem;">
                    <div class="form-group row">
                        <label class="col-md-4 form-label col-form-label">Overall Score</label>
                        <label class="col-md-1 form-label col-form-label">:</label>
                        <div class="col-md-5">
                            <input type="text" name="overall_performance" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 form-label col-form-label">Final Score</label>
                        <label class="col-md-1 form-label col-form-label">:</label>
                        <div class="col-md-7">
                            <select name="final_score" class="form-control select2-hide-search" data-placeholder="Select A Rating" style="width: 100%;">
                                <option></option>
                                <option value="1 (OSC)">1 (OSC)</option>
                                <option value="1.5 (ECC)">1.5 (ECC)</option>
                                <option value="2 (ECC)">2 (ECC)</option>
                                <option value="2.5 (HVC)">2.5 (HVC)</option>
                                <option value="3 (HVC)">3 (HVC)</option>
                                <option value="3.5 (MCE)">3.5 (MCE)</option>
                                <option value="4 (MCE)">4 (MCE)</option>
                                <option value="4.5 (USC)">4.5 (USC)</option>
                                <option value="5 (USC)">5 (USC)</option>
                            </select>
                            <small class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label mb-0">Confidential Summary & Management Development Plan</label>
                        <small class="text-muted">Overall view of job holder’s performance and short to medium term aspiration<br>To be completed by assessor and reviewed with his superior</small>
                        <textarea name="confidential_summary" class="form-control mt-2" rows="5" placeholder="Type confidential summary.."></textarea>
                        <small class="text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODAL FINAL SCORE OPEN -->

@endsection

@section('assets-bottom')
<script type="text/javascript">
	
	$(document).ready(function() {

        $('.nav-appraisal_status').addClass('active');

        $('.select2').select2({
            theme : 'bootstrap4'
        });

        $('.select2-hide-search').select2({
            theme : 'bootstrap4',
            minimumResultsForSearch : Infinity
        });

        $('.numbers').autoNumeric('init');

        var table = $('#table-appraisal').DataTable({
            processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/appraisal/status') }}",
                data : function(d) {
                    d.period_id = $('select[name=period_id]').val();
                    d.department_id = $('select[name=department_id]').val();
                    d.grade_group_id = $('select[name=grade_group_id]').val();
                }
            },
            columns : [
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'user', name : 'user' },
                { data : 'grade_group_name', name : 'grade_group_name' },
                { data : 'department_name', name : 'department_name' },
                { data : 'status', name : 'status' },
                { data : 'action_needed', name : 'action_needed' },
                <?php
                    if(in_array(Auth::user()->user_id, $hr) || in_array(Auth::user()->user_id, $hod) || in_array(Auth::user()->user_id, $ceo)) {
                        echo "{ data : 'edit', name : 'edit' },";
                    }
                ?>
                { data : 'view', name : 'view' },
                { data : 'export', name : 'export' }
            ],
            columnDefs : [
                <?php
                    if(in_array(Auth::user()->user_id, $hr) || in_array(Auth::user()->user_id, $hod) || in_array(Auth::user()->user_id, $ceo)) {
                        echo "{ orderable : false, targets : [0,6,7,8] },
                                { searchable : false, targets : [0,6,7,8] },
                                { createdCell : function(td, data, rowData, row, col) {
                                    $(td).css('text-align', 'center') }, targets : [0,4,5,6,7,8]
                                }";
                    } else {
                        echo "{ orderable : false, targets : [0,6,7] },
                                { searchable : false, targets : [0,6,7] },
                                { createdCell : function(td, data, rowData, row, col) {
                                    $(td).css('text-align', 'center') }, targets : [0,4,5,6,7]
                                }";
                    }
                ?>
            ],
            order : [],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });

        $(document).on('change', 'select.filter-table', function(e) {
            table.draw();
        });

        $(document).on('click', '.btn-export', function(e) {
            $(this).closest('form').submit();
        });

        $(document).on('click', '.btn-feedback', function(e) {
            var modal = $('#modalFeedback');

            modal.find('input[name=id]').val(e.currentTarget.dataset.id);
            modal.find('input[name=type]').val(e.currentTarget.dataset.type);
            modal.find('textarea').removeClass('is-invalid');
            modal.find('.text-danger').html('');

            modal.modal('show');
        });

        $(document).on('submit', '#modalFeedback form', function(e) {
            e.preventDefault();

            if($(this).find('textarea[name=employee_feedback]').val() == '') {
                $(this).find('textarea[name=employee_feedback]').addClass('is-invalid');
                $(this).find('.text-danger').html('Please Fill Employee Feedback');
            } else {
                $.ajax({
                    type : "POST",
                    url : "{{ url('/appraisal/feedback') }}",
                    data : $(this).serialize(),
                    success : function(res) {
                        $('#modalFeedback').modal('hide');
                        table.draw();

                        toastr.success('Feedback Submitted!', 'Success', { "closeButton": true });
                    },
                    error : function(jqXhr, errorThrown, textStatus) {
                        console.log(errorThrown);
                    }
                });
            }

        });

        $(document).on('click', '.btn-final-score', function(e) {
            var modal = $('#finalScoreOpen');
            modal.find('input[name=id]').val(e.currentTarget.dataset.id);
            modal.find('input[name=type]').val(e.currentTarget.dataset.type);

            if(e.currentTarget.dataset.type == 'staff') {
                $.ajax({
                    type : "GET",
                    url : "{{ url('api/appraisal/detail-staff') }}?id="+e.currentTarget.dataset.id+"&type=view",
                    dataType : "JSON",
                    success : function(res) {
                        modal.find('.employee_nik').html(res.appraisal.appraisal_user_nik);
                        modal.find('.employee_name').html(res.appraisal.appraisal_user_name);
                        modal.find('.department').html(res.appraisal.department_name);
                        modal.find('.level').html(res.appraisal.grade_group_name);

                        modal.find('input[name=overall_performance]').val(res.appraisal.overall_performance_score);
                        modal.find('select[name=final_score]').val(res.appraisal.final_score).trigger('change');
                        modal.find('textarea[name=confidential_summary]').val(res.appraisal.confidential_summary);
                    },
                    error : function(jqXhr, errorThrown, textStatus) {
                        console.log(errorThrown);
                    }
                });
            } else {
                $.ajax({
                    type : "GET",
                    url : "{{ url('api/appraisal/detail') }}?id="+e.currentTarget.dataset.id,
                    dataType : "JSON",
                    success : function(res) {
                        modal.find('.employee_nik').html(res.appraisal.user_nik);
                        modal.find('.employee_name').html(res.appraisal.user_name);
                        modal.find('.department').html(res.appraisal.department_name);
                        modal.find('.level').html(res.appraisal.grade_group_name);

                        modal.find('input[name=overall_performance]').val(res.appraisal.overall_performance_score);
                        modal.find('select[name=final_score]').val(res.appraisal.final_score).trigger('change');
                        modal.find('textarea[name=confidential_summary]').val(res.appraisal.confidential_summary);
                    },
                    error : function(jqXhr, errorThrown, textStatus) {
                        console.log(errorThrown);
                    }
                });
            }

            modal.modal('show');
        });

        $(document).on('change', '#finalScoreOpen select', function(e) {
            $(this).removeClass('is-invalid');
            $(this).parents('.form-group').find('.text-danger').html('');
        });

        $(document).on('change input keyup', '#finalScoreOpen textarea', function(e) {
            $(this).removeClass('is-invalid');
            $(this).parents('.form-group').find('.text-danger').html('');
        });

        $(document).on('submit', '#finalScoreOpen form', function(e) {
            e.preventDefault();

            if($(this).find('select[name=final_score]').val() == '') {
                $(this).find('select[name=final_score]').addClass('is-invalid');
                $(this).find('select[name=final_score]').parents('.form-group').find('.text-danger').html('Please Select Final Score');
            } else if($(this).find('textarea[name=confidential_summary]').val() == '') {
                $(this).find('textarea[name=confidential_summary]').addClass('is-invalid');
                $(this).find('textarea[name=confidential_summary]').parents('.form-group').find('.text-danger').html('Please Fill Confidential Summary');
            } else {
                $.ajax({
                    type : "POST",
                    url : "{{ url('/appraisal/final-score') }}",
                    data : $(this).serialize(),
                    success : function(res) {
                        $('#finalScoreOpen').modal('hide');
                        table.draw(false);

                        toastr.success('Final Score Submitted!', 'Success', { "closeButton": true });
                    },
                    error : function(jqXhr, errorThrown, textStatus) {
                        console.log(errorThrown);
                    }
                });
            }
        });

	});

</script>
@endsection