@extends('layouts.appraisal')

@section('assets-top')
<style type="text/css">
    .nav-pills .nav-link {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    .nav-pills .nav-link.active, .nav-pills .nav-link:hover {
        color: #FFFFFF;
        background-color: #206BC4;
    }
    .card .avatar {
        --tblr-avatar-size: 3.5rem;
        cursor: pointer;
    }
    .table tbody td {
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
            <div class="col-md-10">
                <h2 class="page-title d-inline mr-4">Dashboard</h2>
                <ul class="nav nav-pills d-inline-flex">
                    @if(in_array($grade_group, $gg_spv_above) || in_array(Auth::user()->user_id, $super_admin))
                        <li class="nav-item mr-2">
                            <a href="#spv_above" class="nav-link active" data-toggle="tab">Supervisor and Above</a>
                        </li>
                        <li class="nav-item">
                            <a href="#staff" class="nav-link" data-toggle="tab">Staff</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="#staff" class="nav-link {{ (!in_array($grade_group, $gg_spv_above) && !in_array(Auth::user()->user_id, $super_admin)) ? 'active' : '' }}" data-toggle="tab">Staff</a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="col-md-2 ml-auto d-print-none">
                <select name="period_id" class="form-control select2-hide-search" style="width: 100%;">
                    @foreach($period_all as $p)
                        <option value="{{ $p->period_id }}"{{ $p->period_id == $period->period_id ? ' selected' : '' }}>{{ $p->period_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page Title -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page Content -->
    <!-- ============================================================== -->
    <div class="tab-content">
        <div class="tab-pane fade {{ (in_array($grade_group, $gg_spv_above) || in_array(Auth::user()->user_id, $super_admin)) ? 'active show' : '' }}" id="spv_above">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-sm" style="min-height: 102px;">
                        <div class="card-body d-flex align-items-center">
                            <span class="bg-blue text-white avatar mr-3" data-status="milestone open">
                                <i class="fa fa-user-plus"></i>
                            </span>
                            <div class="mr-3">
                                <div class="font-weight-bold milestone-open" style="font-size: 25px;"></div>
                                <div>MILESTONE OPEN</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-sm" style="min-height: 102px;">
                        <div class="card-body d-flex align-items-center">
                            <span class="bg-yellow text-white avatar mr-3" data-status="milestone in progress">
                                <i class="fa fa-user-clock"></i>
                            </span>
                            <div class="mr-3">
                                <div class="font-weight-bold milestone-in-progress" style="font-size: 25px;"></div>
                                <div>MILESTONE IN PROGRESS</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-sm" style="min-height: 102px;">
                        <div class="card-body d-flex align-items-center">
                            <span class="bg-green text-white avatar mr-3" data-status="milestone approved">
                                <i class="fa fa-user-check"></i>
                            </span>
                            <div class="mr-3">
                                <div class="font-weight-bold milestone-approved" style="font-size: 25px;"></div>
                                <div>MILESTONE APPROVED</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div style="flex: 0 0 auto; width: 20%;">
                    <div class="card card-sm" style="min-height: 102px;">
                        <div class="card-body d-flex align-items-center">
                            <span class="bg-blue text-white avatar mr-3" data-status="open">
                                <i class="fa fa-user-plus"></i>
                            </span>
                            <div class="mr-3">
                                <div class="font-weight-bold appraisal-open" style="font-size: 25px;"></div>
                                <div>APPRAISAL OPEN</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="flex: 0 0 auto; width: 20%;">
                    <div class="card card-sm" style="min-height: 102px;">
                        <div class="card-body d-flex align-items-center">
                            <span class="bg-yellow text-white avatar mr-3" data-status="in progress">
                                <i class="fa fa-user-clock"></i>
                            </span>
                            <div class="mr-3">
                                <div class="font-weight-bold appraisal-in-progress" style="font-size: 25px;"></div>
                                <div>APPRAISAL IN PROGRESS</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="flex: 0 0 auto; width: 20%;">
                    <div class="card card-sm" style="min-height: 102px;">
                        <div class="card-body d-flex align-items-center">
                            <span class="bg-green text-white avatar mr-3" data-status="closed">
                                <i class="fa fa-user-check"></i>
                            </span>
                            <div class="mr-3">
                                <div class="font-weight-bold appraisal-closed" style="font-size: 25px;"></div>
                                <div>APPRAISAL CLOSED</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="flex: 0 0 auto; width: 20%;">
                    <div class="card card-sm" style="min-height: 102px;">
                        <div class="card-body d-flex align-items-center">
                            <span class="bg-orange text-white avatar mr-3" data-status="waiting feedback">
                                <i class="fa fa-sync-alt"></i>
                            </span>
                            <div class="mr-3">
                                <div class="font-weight-bold appraisal-waiting-feedback" style="font-size: 25px;"></div>
                                <div>WAITING FEEDBACK</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="flex: 0 0 auto; width: 20%;">
                    <div class="card card-sm" style="min-height: 102px;">
                        <div class="card-body d-flex align-items-center">
                            <span class="bg-lime text-white avatar mr-3" data-status="feedback completed">
                                <i class="fa fa-check-circle"></i>
                            </span>
                            <div class="mr-3">
                                <div class="font-weight-bold appraisal-feedback-completed" style="font-size: 25px;"></div>
                                <div>FEEDBACK COMPLETED</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 col-sm-12 col-xs-12">
                    <div class="card mt-3">
                        <div class="card-body">
                            <h4 class="font-weight-bold"> EMPLOYEE PARTICIPATION STATUS </h4>
                            <div id="employee-participation" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="card mt-3">
                        <div class="card-body">
                            <h4 class="font-weight-bold" style="margin-bottom: 25px;"> EMPLOYEE LEVEL </h4>
                            <div id="employee-level" style="height: 350px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="card mt-3">
                        <div class="card-body">
                            <h4 class="font-weight-bold"> EMPLOYEE YEARS OF SERVICE </h4>
                            <div id="employee-service" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade {{ (!in_array($grade_group, $gg_spv_above) && !in_array(Auth::user()->user_id, $super_admin)) ? 'active show' : '' }}" id="staff">
            <div class="row">
                <div style="flex: 0 0 auto; width: 20%;">
                    <div class="card card-sm" style="min-height: 102px;">
                        <div class="card-body d-flex align-items-center">
                            <span class="bg-blue text-white avatar mr-3" data-status="staff open">
                                <i class="fa fa-user-plus"></i>
                            </span>
                            <div class="mr-3">
                                <div class="font-weight-bold appraisal-staff-open" style="font-size: 25px;"></div>
                                <div>APPRAISAL OPEN</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="flex: 0 0 auto; width: 20%;">
                    <div class="card card-sm" style="min-height: 102px;">
                        <div class="card-body d-flex align-items-center">
                            <span class="bg-yellow text-white avatar mr-3" data-status="staff in progress">
                                <i class="fa fa-user-clock"></i>
                            </span>
                            <div class="mr-3">
                                <div class="font-weight-bold appraisal-staff-in-progress" style="font-size: 25px;"></div>
                                <div>APPRAISAL IN PROGRESS</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="flex: 0 0 auto; width: 20%;">
                    <div class="card card-sm" style="min-height: 102px;">
                        <div class="card-body d-flex align-items-center">
                            <span class="bg-green text-white avatar mr-3" data-status="staff closed">
                                <i class="fa fa-user-check"></i>
                            </span>
                            <div class="mr-3">
                                <div class="font-weight-bold appraisal-staff-closed" style="font-size: 25px;"></div>
                                <div>APPRAISAL CLOSED</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="flex: 0 0 auto; width: 20%;">
                    <div class="card card-sm" style="min-height: 102px;">
                        <div class="card-body d-flex align-items-center">
                            <span class="bg-orange text-white avatar mr-3" data-status="staff waiting feedback">
                                <i class="fa fa-sync-alt"></i>
                            </span>
                            <div class="mr-3">
                                <div class="font-weight-bold appraisal-staff-waiting-feedback" style="font-size: 25px;"></div>
                                <div>WAITING FEEDBACK</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="flex: 0 0 auto; width: 20%;">
                    <div class="card card-sm" style="min-height: 102px;">
                        <div class="card-body d-flex align-items-center">
                            <span class="bg-lime text-white avatar mr-3" data-status="staff feedback completed">
                                <i class="fa fa-check-circle"></i>
                            </span>
                            <div class="mr-3">
                                <div class="font-weight-bold appraisal-staff-feedback-completed" style="font-size: 25px;"></div>
                                <div>FEEDBACK COMPLETED</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 col-sm-12 col-xs-12">
                    <div class="card mt-3">
                        <div class="card-body">
                            <h4 class="font-weight-bold"> STAFF PARTICIPATION STATUS </h4>
                            <div id="staff-participation" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="card mt-3">
                        <div class="card-body">
                            <h4 class="font-weight-bold" style="margin-bottom: 25px;"> STAFF GENDER </h4>
                            <div id="staff-gender" style="height: 350px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="card mt-3">
                        <div class="card-body">
                            <h4 class="font-weight-bold"> STAFF YEARS OF SERVICE </h4>
                            <div id="staff-service" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page Content -->
    <!-- ============================================================== -->
</div>

<!-- BEGIN MODAL INFO -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalInfo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"></h3>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="status">
                <table class="table table-bordered table-striped" id="table-info" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 25px;"> No </th>
                            <th> Employee </th>
                            <th> Department </th>
                            <th> Level </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL INFO -->
@endsection

@section('assets-bottom')
<script src="{{ asset('assets_tabler/dist/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script type="text/javascript">

	$(document).ready(function() {

        $('.nav-dashboard').addClass('active');

        $('.select2-hide-search').select2({
            theme : 'bootstrap4',
            minimumResultsForSearch : Infinity
        });

        var period = $('select[name=period_id]').val();

        getAppraisalCount(period);
        getEmployeeParticipation(period);
        getEmployeeLevel(period);
        getStaffParticipation(period);
        getStaffGender(period);
        getStaffYearsService(period);
        getEmployeeYearsService(period);

        $(document).on('change', 'select[name=period_id]', function(e) {
            getAppraisalCount($(this).val());
            getEmployeeParticipation($(this).val());
            getEmployeeLevel($(this).val());
            getStaffParticipation($(this).val());
            getStaffGender($(this).val());
            getStaffYearsService($(this).val());
            getEmployeeYearsService($(this).val());
        });

        var table = $('#table-info').DataTable({
            processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/appraisal/dashboard/info') }}",
                data : function(d) {
                    d.period_id = $('select[name=period_id]').val();
                    d.status = $('#modalInfo input[name=status]').val();
                }
            },
            columns : [
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'employee', name : 'employee', className: 'text-nowrap' },
                { data : 'department_name', name : 'department_name' },
                { data : 'grade_group_name', name : 'grade_group_name' }
            ],
            columnDefs : [
                { orderable : false, targets : [0] },
                { searchable : false, targets : [0] },
                { createdCell : function(td, data, rowData, row, col) {
                    $(td).css('text-align', 'center') }, targets : [0]
                }
            ],
            order : [],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });

        $(document).on('click', '.avatar', function(e) {
            var modal = $('#modalInfo');

            if(e.currentTarget.dataset.status == 'milestone open') {
                modal.find('.modal-title').html('Milestone Open');
            } else if(e.currentTarget.dataset.status == 'milestone in progress') {
                modal.find('.modal-title').html('Milestone In Progress');
            } else if(e.currentTarget.dataset.status == 'milestone approved') {
                modal.find('.modal-title').html('Milestone Approved');
            } else if(e.currentTarget.dataset.status == 'open' || e.currentTarget.dataset.status == 'staff open') {
                modal.find('.modal-title').html('Appraisal Open');
            } else if(e.currentTarget.dataset.status == 'in progress' || e.currentTarget.dataset.status == 'staff in progress') {
                modal.find('.modal-title').html('Appraisal In Progress');
            } else if(e.currentTarget.dataset.status == 'closed' || e.currentTarget.dataset.status == 'staff closed') {
                modal.find('.modal-title').html('Appraisal Closed');
            } else if(e.currentTarget.dataset.status == 'waiting feedback' || e.currentTarget.dataset.status == 'staff waiting feedback') {
                modal.find('.modal-title').html('Appraisal Waiting Feedback');
            } else if(e.currentTarget.dataset.status == 'feedback completed' || e.currentTarget.dataset.status == 'staff feedback completed') {
                modal.find('.modal-title').html('Appraisal Feedback Completed');
            }

            modal.find('input[name=status]').val(e.currentTarget.dataset.status);
            table.draw();

            modal.modal('show');
        });

        $('#modalInfo').on('shown.bs.modal', function() {
            var table = $('#table-info').DataTable();
            table.columns.adjust();
        });
	});

    function getAppraisalCount(period) {
        $.ajax({
            type : "GET",
            url : "{{ url('api/appraisal/dashboard/count') }}?period_id="+period,
            dataType : "JSON",
            beforeSend : function() {
                $('.se-pre-con').fadeIn();
            },
            success : function(res) {
                if(res) {
                    $('.milestone-open').html(res.milestone_open);
                    $('.milestone-in-progress').html(res.milestone_in_progress);
                    $('.milestone-approved').html(res.milestone_approved);
                    $('.appraisal-open').html(res.appraisal_open);
                    $('.appraisal-in-progress').html(res.appraisal_in_progress);
                    $('.appraisal-closed').html(res.appraisal_closed);
                    $('.appraisal-waiting-feedback').html(res.appraisal_waiting_feedback);
                    $('.appraisal-feedback-completed').html(res.appraisal_feedback_completed);

                    $('.appraisal-staff-open').html(res.appraisal_staff_open);
                    $('.appraisal-staff-in-progress').html(res.appraisal_staff_in_progress);
                    $('.appraisal-staff-closed').html(res.appraisal_staff_closed);
                    $('.appraisal-staff-waiting-feedback').html(res.appraisal_staff_waiting_feedback);
                    $('.appraisal-staff-feedback-completed').html(res.appraisal_staff_feedback_completed);
                }
            },
            complete : function() {
                $('.se-pre-con').fadeOut();
            },
            error : function(jqXhr, errorThrown, textStatus) {
                console.log(errorThrown);
            }
        })
    }

    function getEmployeeParticipation(period) {
        var color = [
            '#ff8100', // Finance & Accounting
            '#22ff00', // HR & GA
            '#f0ff00', // IT
            '#001737', // Manufacturing
            '#0011ff', // Marketing
            '#06ab00', // R & D
            '#ff0000', // Sales
            '#00b8ff' // Skin Care
        ];

        $.ajax({
            type : "GET",
            url : "{{ url('api/appraisal/dashboard/participation') }}?period_id="+period,
            dataType : "JSON",
            beforeSend : function() {
                $('.se-pre-con').fadeIn();
                $('#employee-participation').empty();
            },
            success : function(res) {
                if(res) {
                    var options = {
                        series : [{
                            name : 'Employee Participation',
                            data : res.participation
                        }],
                        chart : {
                            height : 350,
                            type : 'bar'
                        },
                        colors : color,
                        plotOptions : {
                            bar : {
                                borderRadius : 6,
                                columnWidth : '45%',
                                distributed : true,
                            }
                        },
                        dataLabels : {
                            enabled : false
                        },
                        legend : {
                            show : false
                        },
                        xaxis : {
                            categories : res.department,
                            labels : {
                                style : {
                                    colors : color,
                                    fontSize : '13px'
                                }
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#employee-participation"), options);
                    chart.render();
                }
            },
            complete : function() {
                $('.se-pre-con').fadeOut();
            },
            error : function(jqXhr, errorThrown, textStatus) {
                console.log(errorThrown);
            }
        });
    }

    function getStaffParticipation(period) {
        var color = [
            '#ff8100', // Finance & Accounting
            '#22ff00', // HR & GA
            '#f0ff00', // IT
            '#001737', // Manufacturing
            '#0011ff', // Marketing
            '#06ab00', // R & D
            '#ff0000', // Sales
            '#00b8ff' // Skin Care
        ];

        $.ajax({
            type : "GET",
            url : "{{ url('api/appraisal/dashboard/staff-participation') }}?period_id="+period,
            dataType : "JSON",
            beforeSend : function() {
                $('.se-pre-con').fadeIn();
                $('#staff-participation').empty();
            },
            success : function(res) {
                if(res) {
                    var options = {
                        series : [{
                            name : 'Staff Participation',
                            data : res.participation
                        }],
                        chart : {
                            height : 350,
                            type : 'bar'
                        },
                        colors : color,
                        plotOptions : {
                            bar : {
                                borderRadius : 6,
                                columnWidth : '45%',
                                distributed : true,
                            }
                        },
                        dataLabels : {
                            enabled : false
                        },
                        legend : {
                            show : false
                        },
                        xaxis : {
                            categories : res.department,
                            labels : {
                                style : {
                                    colors : color,
                                    fontSize : '13px'
                                }
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#staff-participation"), options);
                    chart.render();
                }
            },
            complete : function() {
                $('.se-pre-con').fadeOut();
            },
            error : function(jqXhr, errorThrown, textStatus) {
                console.log(errorThrown);
            }
        });
    }

    function getEmployeeLevel(period) {
        $.ajax({
            type : "GET",
            url : "{{ url('api/appraisal/dashboard/level') }}?period_id="+period,
            dataType : "JSON",
            beforeSend : function() {
                $('.se-pre-con').fadeIn();
                $('#employee-level').empty();
            },
            success : function(res) {
                if(res) {
                    var options = {
                        series : res.count,
                        chart : {
                            width : 320,
                            type : 'pie'
                        },
                        labels : res.level,
                        legend : {
                            position : 'bottom'
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#employee-level"), options);
                    chart.render();
                }
            },
            complete : function() {
                $('.se-pre-con').fadeOut();
            },
            error : function(jqXhr, errorThrown, textStatus) {
                console.log(errorThrown);
            }
        });
    }

    function getStaffGender(period) {
        $.ajax({
            type : "GET",
            url : "{{ url('api/appraisal/dashboard/staff-gender') }}?period_id="+period,
            dataType : "JSON",
            beforeSend : function() {
                $('.se-pre-con').fadeIn();
                $('#staff-gender').empty();
            },
            success : function(res) {
                if(res) {
                    var options = {
                        series : res.count,
                        chart : {
                            width : 320,
                            type : 'pie'
                        },
                        labels : res.gender,
                        legend : {
                            position : 'bottom'
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#staff-gender"), options);
                    chart.render();
                }
            },
            complete : function() {
                $('.se-pre-con').fadeOut();
            },
            error : function(jqXhr, errorThrown, textStatus) {
                console.log(errorThrown);
            }
        });
    }

    function getStaffYearsService(period) {
        $.ajax({
            type : "GET",
            url : "{{ url('api/appraisal/dashboard/staff-years') }}?period_id="+period,
            dataType : "JSON",
            beforeSend : function() {
                $('.se-pre-con').fadeIn();
                $('#staff-service').empty();
            },
            success : function(res) {
                if(res) {
                    var options = {
                        series : [{
                            name : 'Staff Years of Services',
                            data : res
                        }],
                        chart : {
                            height : 350,
                            type : 'bar'
                        },
                        colors : ['#034341'],
                        plotOptions : {
                            bar : {
                                borderRadius : 6,
                                columnWidth : '45%',
                                distributed : true,
                            }
                        },
                        dataLabels : {
                            enabled : false
                        },
                        legend : {
                            show : false
                        },
                        xaxis : {
                            categories : ['Less than 1 year', '1 to 3 years', '3 to 10 years', 'More than 10 years'],
                            labels : {
                                style : {
                                    colors : ['#034341'],
                                    fontSize : '13px'
                                }
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#staff-service"), options);
                    chart.render();
                }
            },
            complete : function() {
                $('.se-pre-con').fadeOut();
            },
            error : function(jqXhr, errorThrown, textStatus) {
                console.log(errorThrown);
            }
        });
    }

    function getEmployeeYearsService(period) {
        $.ajax({
            type : "GET",
            url : "{{ url('api/appraisal/dashboard/years') }}?period_id="+period,
            dataType : "JSON",
            beforeSend : function() {
                $('.se-pre-con').fadeIn();
                $('#employee-service').empty();
            },
            success : function(res) {
                if(res) {
                    var options = {
                        series : [{
                            name : 'Employee Years of Services',
                            data : res
                        }],
                        chart : {
                            height : 350,
                            type : 'bar'
                        },
                        colors : ['#034341'],
                        plotOptions : {
                            bar : {
                                borderRadius : 6,
                                columnWidth : '45%',
                                distributed : true,
                            }
                        },
                        dataLabels : {
                            enabled : false
                        },
                        legend : {
                            show : false
                        },
                        xaxis : {
                            categories : ['Less than 1 year', '1 to 3 years', '3 to 10 years', 'More than 10 years'],
                            labels : {
                                style : {
                                    colors : ['#034341'],
                                    fontSize : '13px'
                                }
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#employee-service"), options);
                    chart.render();
                }
            },
            complete : function() {
                $('.se-pre-con').fadeOut();
            },
            error : function(jqXhr, errorThrown, textStatus) {
                console.log(errorThrown);
            }
        });
    }

</script>
@endsection