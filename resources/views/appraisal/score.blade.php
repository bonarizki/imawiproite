@extends('layouts.appraisal')

@section('assets-top')
<style type="text/css">
    .table thead th {
        vertical-align: middle !important;
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
                <h2 class="page-title">Report Appraisal Score</h2>
            </div>
            <div class="col-auto ml-auto d-print-none">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Report</li>
                        <li class="breadcrumb-item active">Appraisal Score</li>
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
                                <label class="form-label">Appraisal Status</label>
                                <select name="appraisal_status" class="form-control select2-hide-search" style="width: 100%;">
                                    <option value="0"> ALL STATUS </option>
                                    <option value="1"> APPROVED </option>
                                    <option value="2"> WAITING APPROVAL </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Department</label>
                                <select name="department_id" class="form-control select2" style="width: 100%;">
                                    @if(in_array(Auth::user()->user_id, $hod))
                                        @foreach($department as $dept)
                                            @foreach($hod as $key => $val)
                                                @if($dept->department_id == $key && Auth::user()->user_id == $val)
                                                    <option value="{{ $dept->department_id }}">{{ $dept->department_name }}</option>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @else
                                        <option value="0">ALL DEPARTMENT</option>
                                        @foreach($department as $dept)
                                            <option value="{{ $dept->department_id }}">{{ $dept->department_name }}</option>
                                        @endforeach
                                    @endif
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
                <div class="card-header justify-content-end">
                    <a href="javascript:;" target="_blank" class="btn btn-secondary btn-export">
                        <i class="fa fa-file-excel"></i> Export
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="table-score" style="width: 100%;">
                        <thead>
                            <tr>
                                <th rowspan="2" style="text-align: center; width: 25px;"> No </th>
                                <th rowspan="2"> Level </th>
                                <th rowspan="2" style="text-align: center;"> Headcount </th>
                                <th colspan="6" style="text-align: center;"> Overall Job Performance Rating </th>
                            </tr>
                            <tr>
                                <th style="text-align: center;"> Not Scored </th>
                                <th style="text-align: center;"> OSC<br>1 </th>
                                <th style="text-align: center;"> ECC<br>1.5 - 2 </th>
                                <th style="text-align: center;"> HVC<br>2.5 - 3 </th>
                                <th style="text-align: center;"> MCE<br>3.5 - 4 </th>
                                <th style="text-align: center;"> USC<br>4.5 - 5 </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <hr>
                    <table class="table table-bordered table-striped" id="table-sum" style="width: 100%;">
                        <thead>
                            <tr>
                                <th rowspan="1" colspan="2" style="text-align: center;"> SAP<br>(Significantly Above Plan) </th>
                                <th rowspan="1" style="text-align: center;"> OP<br>(On Plan) </th>
                                <th rowspan="1" colspan="2" style="text-align: center;"> BP<br>(Below Plan) </th>
                            </tr>
                            <tr>
                                <th style="text-align: center;"> OSC<br>1 </th>
                                <th style="text-align: center;"> ECC<br>1.5 - 2 </th>
                                <th style="text-align: center;"> HVC<br>2.5 - 3 </th>
                                <th style="text-align: center;"> MCE<br>3.5 - 4 </th>
                                <th style="text-align: center;"> USC<br>4.5 - 5 </th>
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

@endsection

@section('assets-bottom')
<script type="text/javascript">
	
	$(document).ready(function() {

        $('.nav-report').addClass('active');
        $('.nav-appraisal_score').addClass('active');

        $('.select2').select2({
            theme : 'bootstrap4'
        });

        $('.select2-hide-search').select2({
            theme : 'bootstrap4',
            minimumResultsForSearch : Infinity
        });

        var table = $('#table-score').DataTable({
            dom : 't',
            processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/appraisal/report/score') }}",
                data : function(d) {
                    d.appraisal_status = $('#filter select[name=appraisal_status]').val();
                    d.department_id = $('#filter select[name=department_id]').val();
                    d.period_id = $('#filter select[name=period_id]').val();
                }
            },
            columns : [
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'grade_group_name', name : 'grade_group_name' },
                { data : 'headcount', name : 'headcount' },
                { data : 'not_scored', name : 'not_scored' },
                { data : 'osc', name : 'osc' },
                { data : 'ecc', name : 'ecc' },
                { data : 'hvc', name : 'hvc' },
                { data : 'mce', name : 'mce' },
                { data : 'usc', name : 'usc' }
            ],
            columnDefs : [
                { orderable : false, targets : [0] },
                { createdCell : function(td, data, rowData, row, col) {
                    $(td).css('text-align', 'center') }, targets : [0,2,3,4,5,6,7,8]
                }
            ],
            order : [],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });

        var table_sum = $('#table-sum').DataTable({
            dom : 't',
            processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/appraisal/report/score/sum') }}",
                data : function(d) {
                    d.department_id = $('#filter select[name=department_id]').val();
                    d.period_id = $('#filter select[name=period_id]').val();
                }
            },
            columns : [
                { data : 'osc', name : 'osc' },
                { data : 'ecc', name : 'ecc' },
                { data : 'hvc', name : 'hvc' },
                { data : 'mce', name : 'mce' },
                { data : 'usc', name : 'usc' }
            ],
            columnDefs : [
                { orderable : false, targets : [0,1,2,3,4] },
                { createdCell : function(td, data, rowData, row, col) {
                    $(td).css('text-align', 'center') }, targets : [0,1,2,3,4]
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
            table_sum.draw();
        });

        $(document).on('click', '.btn-export', function(e) {
            var period = $('#filter select[name=period_id]').val();
            var department = $('#filter select[name=department_id]').val();
            var status = $('#filter select[name=appraisal_status]').val();

            window.location.replace("{{ url('api/appraisal/report/score/export') }}?period_id="+period+"&department_id="+department+"&status="+status);
        });

	});

</script>
@endsection