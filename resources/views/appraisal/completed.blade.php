@extends('layouts.appraisal')

@section('assets-top')
<link rel="stylesheet" type="text/css" href="{{ asset('assets_dashforge/lib/filepond/filepond.css') }}">
<style type="text/css">
    .table thead th {
        vertical-align: middle !important;
    }
    .table-signature tbody tr td div {
        min-height: 162px;
    }
    #table-completed tbody td {
        vertical-align: middle;
    }
    .filepond--root {
        margin-bottom: 0px !important;
    }
    .alert .alert-content {
        max-height: 200px;
        overflow-y: auto;
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
                <h2 class="page-title">Report Appraisal Completed</h2>
            </div>
            <div class="col-auto ml-auto d-print-none">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Report</li>
                        <li class="breadcrumb-item active">Appraisal Completed</li>
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
            <div class="card mb-1" id="filter">
                <div class="card-body pb-0">
                    <h3><i class="fa fa-filter"></i> Filter</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Department</label>
                                <select name="department_id" class="form-control select2" style="width: 100%;">
                                    <option value="0">ALL DEPARTMENT</option>
                                    @foreach($department as $dept)
                                        <option value="{{ $dept->department_id }}">{{ $dept->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Level</label>
                                <select name="grade_group_id" class="form-control select2" style="width: 100%;">
                                    <option value="0">ALL LEVEL</option>
                                    @foreach($grade_group as $gg)
                                        <option value="{{ $gg->grade_group_id }}">{{ $gg->grade_group_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Period</label>
                                <select name="period_id" class="form-control select2-hide-search" style="width: 100%;">
                                    @foreach($period_all as $p)
                                        <option value="{{ $p->period_id }}"{{ $p->period_id == $period->period_id ? ' selected' : '' }}>{{ $p->period_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header row">
                    <div class="col-md-6">
                        <a href="#uploadFinalScore" class="btn btn-primary" data-toggle="modal">
                            <i class="fa fa-upload"></i> Upload Final Score
                        </a>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="javascript:;" target="_blank" class="btn btn-secondary btn-export-excel">
                            <i class="fa fa-file-excel"></i> Export
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="table-completed" style="width: 100%;">
                        <thead>
                            <tr>
                                <th rowspan="2" style="text-align: center; width: 25px;"> No </th>
                                <th rowspan="2"> Employee </th>
                                <th rowspan="2"> Department </th>
                                <th rowspan="2"> Level </th>
                                <th rowspan="2" style="text-align: center;"> Overall<br>Milestones<br>Rating </th>
                                <th rowspan="2" style="text-align: center;"> Overall<br>Competencies<br>Rating </th>
                                <th rowspan="2" style="text-align: center;"> Overall<br>Job Performance<br>Rating </th>
                                <th rowspan="2" style="text-align: center;"> Final<br>Score </th>
                                <th colspan="3" style="text-align: center;"> Action </th>
                            </tr>
                            <tr>
                                <th style="text-align: center; width: 50px;"> Edit </th>
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

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="uploadFinalScore">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload Final Score</h4>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="file" class="filepond" data-max-file-size="10MB">
                </form>
                <hr>
                <!-- ALERT -->
                <div class="alert alert-danger alert-dismissible" style="display: none;">
                    <button type="button" class="btn-close" aria-hidden="true" aria-label="Close"></button>
                    <h5><i class="icon fa fa-ban"></i> Alert, Check your Excel File </h5>
                    <div class="alert-content"></div>
                </div>
                <!-- END ALERT -->
                <div class="x_content table-responsive">
                    <table class="table table-striped table-bordered" id="table-final_score_temp" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 25px;"> No </th>
                                <th> NIK </th>
                                <th> Employee </th>
                                <th> Department </th>
                                <th> Level </th>
                                <th style="text-align: center;"> Final<br>Score </th>
                                <th> Confidential Summary </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger btn-reset">Reset</button>
                <button type="button" class="btn btn-success btn-submit">Save</button>
            </div>
        </div>
    </div>
</div>

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
                        <textarea name="confidential_summary" class="form-control mt-2" rows="7" placeholder="Type confidential summary.."></textarea>
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

@include('appraisal.modal.confidential')
@include('appraisal.modal.confidential_staff')

@endsection

@section('assets-bottom')
<script src="{{ asset('assets_dashforge/lib/filepond/filepond.js') }}"></script>
<script src="{{ asset('assets_dashforge/lib/filepond/filepond-plugin-file-encode.js') }}"></script>
<script src="{{ asset('assets_dashforge/lib/filepond/filepond-plugin-file-validate-size.js') }}"></script>
<script src="{{ asset('assets_dashforge/lib/filepond/filepond-plugin-file-validate-type.js') }}"></script>
<script type="text/javascript">

	$(document).ready(function() {

        $('.nav-report').addClass('active');
        $('.nav-appraisal_completed').addClass('active');

        $('.select2').select2({
            theme : 'bootstrap4'
        });

        $('.select2-hide-search').select2({
            theme : 'bootstrap4',
            minimumResultsForSearch : Infinity
        });

        var table = $('#table-completed').DataTable({
            processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/appraisal/report/completed') }}",
                data : function(d) {
                    d.period_id = $('#filter select[name=period_id]').val();
                    d.department_id = $('#filter select[name=department_id]').val();
                    d.grade_group_id = $('#filter select[name=grade_group_id]').val();
                }
            },
            columns : [
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'user_nik_name', name : 'user_nik_name' },
                { data : 'department_name', name : 'department_name' },
                { data : 'grade_group_name', name : 'grade_group_name' },
                { data : 'overall_milestone_score', name : 'overall_milestone_score' },
                { data : 'overall_competency_score', name : 'overall_competency_score' },
                { data : 'overall_performance_score', name : 'overall_performance_score' },
                { data : 'final_score', name : 'final_score' },
                { data : 'edit', name : 'edit' },
                { data : 'view', name : 'view' },
                { data : 'export', name : 'export' }
            ],
            columnDefs : [
                { orderable : false, targets : [0,8,9,10] },
                { searchable : false, targets : [0,4,5,6,7,8,9,10] },
                { createdCell : function(td, data, rowData, row, col) {
                    $(td).css('text-align', 'center') }, targets : [0,4,5,6,7,8,9,10]
                }
            ],
            order : [],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });

        var table_temp = $('#table-final_score_temp').DataTable({
            processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/appraisal/report/temp') }}",
                data : function(d) {

                }
            },
            columns : [
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'nik', name : 'nik' },
                { data : 'employee', name : 'employee' },
                { data : 'department', name : 'department' },
                { data : 'level', name : 'level' },
                { data : 'final_score', name : 'final_score' },
                { data : 'confidential_summary', name : 'confidential_summary' }
            ],
            columnDefs : [
                { orderable : false, targets : [0] },
                { searchable : false, targets : [0,5] },
                { createdCell : function(td, data, rowData, row, col) {
                    $(td).css('text-align', 'center') }, targets : [0,5]
                }
            ],
            order : [],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });

        $(document).on('change', '#filter select', function(e) {
            table.draw();
        });

        $(document).on('click', '.btn-export-excel', function(e) {
            var department = $('#filter select[name=department_id]').val();
            var grade_group = $('#filter select[name=grade_group_id]').val();
            var period = $('#filter select[name=period_id]').val();

            window.location.replace("{{ url('api/appraisal/report/completed/export') }}?period_id="+period+"&department_id="+department+"&grade_group_id="+grade_group);
        });

        $(document).on('click', '.btn-export-pdf', function(e) {
            $(this).closest('form').submit();
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

        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginFileValidateSize);

        FilePond.setOptions({
            server : {
                process : (filepond, file, metadata, load, error, progress, abort, transfer, options) => {

                    const formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append(filepond, file, file.name);

                    const request = new XMLHttpRequest();
                    request.open('POST', '{{ url("api/appraisal/report/upload/temp") }}');

                    request.upload.onprogress = (e) => {
                        progress(e.lengthComputable, e.loaded, e.total);
                    };

                    request.onload = function() {
                        if (request.status >= 200 && request.status < 300) {
                            // console.log(request.responseText);
                            table_temp.draw(false);

                            $('.alert').find('.alert-message').remove();
                            var res = request.response.substr(1, request.response.length-2).split('#');

                            if(res[0] != '') {
                                // console.log(res);
                                $.each(res, function(key, val) {
                                    $('.alert-content').append('<div class="alert-message">'+val+'</div>');
                                });

                                $('.alert').slideDown();
                            }

                            load(request.responseText);
                        }
                        else {
                            error('oh no');
                        }
                    };

                    request.send(formData);

                    return {
                        abort: () => {
                            request.abort();
                            abort();
                        }
                    };
                }
            }
        });

        const upload = document.querySelector('.filepond');
        const pond = FilePond.create(upload, {
            acceptedFileTypes : ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        });

        $(document).on('show.bs.modal', '#uploadFinalScore', function() {
            table_temp.draw();
        });

        $(document).on('click', '.alert .btn-close', function(e) {
            $('.alert').slideUp();
        });

        $(document).on('click', '.btn-reset', function(e) {
            e.preventDefault();

            Swal.fire({
                title : 'Are you sure?',
                text : 'You\'re going to reset the uploaded Final Score',
                icon : 'warning',
                showCancelButton : true,
                confirmButtonText : 'Yes, reset',
                reverseButtons : true
            }).then((result) => {
                if(result.value) {
                    $.ajax({
                        type : "GET",
                        url : "{{ url('api/appraisal/report/upload/temp/reset') }}",
                        dataType : "JSON",
                        success : function(res) {
                            table_temp.draw();
                        },
                        error : function(jqXhr, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                }
            });
        });

        $(document).on('click', '.btn-submit', function(e) {
            e.preventDefault();

            if(table_temp.rows().data().length == 0) {
                Swal.fire({
                    title : 'No Data Found',
                    text : 'You have to upload data first',
                    icon : 'warning'
                });
            } else {
                Swal.fire({
                    title : 'Are you sure?',
                    text : 'You\'re going to submit the uploaded Final Score',
                    icon : 'warning',
                    showCancelButton : true,
                    confirmButtonText : 'Yes, submit',
                    reverseButtons : true
                }).then((result) => {
                    if(result.value) {
                        $.ajax({
                            type : "POST",
                            url : "{{ url('api/appraisal/report/upload/submit') }}",
                            data : {
                                "_token" : "{{ csrf_token() }}"
                            },
                            success : function(res) {
                                table_temp.draw();

                                if(res.length == 0) {
                                    Swal.fire({
                                        title : 'Success',
                                        text : 'Final Score Submitted',
                                        icon : 'success',
                                        showCancelButton : false,
                                        confirmButtonText : 'OK',
                                        allowOutsideClick : false
                                    }).then((result) => {
                                        if(result.value) {
                                            table.draw();
                                            $('#uploadFinalScore').modal('hide');
                                        }
                                    });
                                } else {
                                    if(res[0] != '') {
                                        $.each(res, function(key, val) {
                                            $('.alert-content').append('<div class="alert-message">'+val+'</div>');
                                        });

                                        $('.alert').slideDown();
                                    }
                                }
                            },
                            error : function(jqXhr, textStatus, errorThrown) {
                                console.log(textStatus);
                            }
                        });
                    }
                });
            }
        });

	});

</script>
@endsection
