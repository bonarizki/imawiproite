@extends('layouts.recruitment')

@section('assets-top')
<style type="text/css">
    
</style>
@endsection

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb -->
<!-- ============================================================== -->
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">Fulfillment Rate</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Recruitment</li>
                        <li class="breadcrumb-item">Report</li>
                        <li class="breadcrumb-item active">Fulfillment Rate</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none text-right">
        <ul class="nav nav-pills justify-content-end">
            <li class="nav-item">
                <a class="nav-link active" id="level-tab-end" data-toggle="pill" href="#level-end" aria-expanded="false">Grade Group</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="department-tab-end" data-toggle="pill" href="#department-end" aria-expanded="false">Department</a>
            </li>
        </ul>
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
            <div class="tab-content">
                <div class="tab-pane active" id="level-end" role="tabpanel" aria-labelledby="level-tab-end" aria-expanded="false">
                    <div class="card" id="filter" style="margin-bottom: 10px;">
                        <div class="card-body" style="padding-bottom: 0px;">
                            <h4><i class="feather icon-filter"></i> Filter </h4>
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label class="col-form-label">Department</label>
                                        <select name="department_id" class="form-control select2" style="width: 100%;">
                                            <option value="0">ALL DEPARTMENT</option>
                                            @foreach($department as $d)
                                                <option value="{{ $d->department_id }}">{{ $d->department_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Period</label>
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
                        <div class="card-body">
                            <a target="_blank" href="#" class="btn btn-primary btn-export float-right">
                                <i class="feather icon-file-text"></i> Export
                            </a><br><br>
                            <table class="table table-bordered table-striped nowrap" id="table-level" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="text-align: center; width: 25px;"> # </th>
                                        <th> Grade Group </th>
                                        <th> Total Request </th>
                                        <th> Total Fulfilled </th>
                                        <th> Average Lead Time </th>
                                        <th> Average Cost/Hire </th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
        				</div>
        			</div>
                </div>
                <div class="tab-pane" id="department-end" role="tabpanel" aria-labelledby="department-tab-end" aria-expanded="false">
                    <div class="card" id="filter2" style="margin-bottom: 10px;">
                        <div class="card-body" style="padding-bottom: 0px;">
                            <h4><i class="feather icon-filter"></i> Filter </h4>
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label class="col-form-label">Grade Group</label>
                                        <select name="grade_group_id" class="form-control select2" style="width: 100%;">
                                            <option value="0">ALL GRADE GROUP</option>
                                            @foreach($grade_group as $gg)
                                                <option value="{{ $gg->grade_group_id }}">{{ $gg->grade_group_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Period</label>
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
                        <div class="card-body">
                            <a target="_blank" href="#" class="btn btn-primary btn-export float-right">
                                <i class="feather icon-file-text"></i> Export
                            </a><br><br>
                            <table class="table table-bordered table-striped nowrap" id="table-dept" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="text-align: center; width: 25px;"> # </th>
                                        <th> Department </th>
                                        <th> Total Request </th>
                                        <th> Total Fulfilled </th>
                                        <th> Average Lead Time </th>
                                        <th> Average Cost/Hire </th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
<!-- ============================================================== -->
<!-- End container fluid -->
<!-- ============================================================== -->
@endsection

@section('assets-bottom')
<script type="text/javascript">
	
	$(document).ready(function() {

        setTimeout(function() {
            $('.nav-report').addClass('sidebar-group-active').addClass('active').addClass('open');
            $('.nav-fulfillment_rate').addClass('sidebar-group-active').addClass('active').addClass('open');
        }, 3000);

        $('.select2').select2();
        $('.select2-hide-search').select2({
            minimumResultsForSearch : Infinity
        });
        $('.numbers').autoNumeric('init', {mDec : '0'});

        var table_level = $('#table-level').DataTable({
            processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/recruitment/rate-by-level') }}",
                data : function(d) {
                    d.department_id = $('#filter select[name=department_id]').val();
                    d.period_id = $('#filter select[name=period_id]').val();
                }
            },
            columns : [
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'grade_group', name : 'grade_group' },
                { data : 'request', name : 'request' },
                { data : 'fulfilled', name : 'fulfilled' },
                { data : 'lead_time', name : 'lead_time' },
                { data : 'cost_hire', name : 'cost_hire' }
            ],
            columnDefs : [
                { orderable : false, targets : [0] },
                { searchable : false, targets : [0,2,3,4,5] },
                { createdCell : function(td, data, rowData, row, col) {
                    $(td).css('text-align', 'right') }, targets : [0,2,3,4,5]
                }
            ],
            order : [],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });

        var table_dept = $('#table-dept').DataTable({
            processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/recruitment/rate-by-dept') }}",
                data : function(d) {
                    d.grade_group_id = $('#filter2 select[name=grade_group_id]').val();
                    d.period_id = $('#filter2 select[name=period_id]').val();
                }
            },
            columns : [
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'department', name : 'department' },
                { data : 'request', name : 'request' },
                { data : 'fulfilled', name : 'fulfilled' },
                { data : 'lead_time', name : 'lead_time' },
                { data : 'cost_hire', name : 'cost_hire' }
            ],
            columnDefs : [
                { orderable : false, targets : [0] },
                { searchable : false, targets : [0,2,3,4,5] },
                { createdCell : function(td, data, rowData, row, col) {
                    $(td).css('text-align', 'right') }, targets : [0,2,3,4,5]
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
            table_level.draw();
        }, 2000);

        $(document).on('change', '#filter select, #filter2 select', function(e) {
            table_level.draw();
            table_dept.draw();
        });

        $(document).on('show.bs.tab', '#level-tab-end', function(e) {
            table_level.draw();
        });

        $(document).on('show.bs.tab', '#department-tab-end', function(e) {
            table_dept.draw();
        });

        $(document).on('click', '.btn-export', function(e) {
            var period = $('#filter select[name=period_id]').val();
            var department = $('#filter select[name=department_id]').val();
            var grade_group = $('#filter2 select[name=grade_group_id]').val();

            $('.btn-export').attr('href', '{!! url("/recruitment/rate/export?period='+period+'&department='+department+'&gg='+grade_group+'") !!}');
        });

	});

</script>
@endsection