@extends('resignation/master/master')
@section('breadcumb','Attrition Based on Reason')
@section('title','Attrition Based on Reason')

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row">
        <div class="col-12">
            <div class="card" id="filter" style="margin-bottom: 10px;">
                <div class="card-body" style="padding-bottom: 0px;">
                    <h4><i class="feather icon-filter"></i> Filter </h4>
                    <div class="row">
                        <div class="col-4">
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
                        <div class="col-3">
                            <div class="form-group">
                                <label class="col-form-label">Type</label>
                                <select name="type" class="form-control select2-hide-search" style="width: 100%;">
                                    <option value="1" selected>MONTHLY</option>
                                    <option value="2">QUARTERLY</option>
                                    <option value="3">ANNUALLY</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2 type-month">
                            <div class="form-group">
                                <label class="col-form-label">Month</label>
                                <select name="month" class="form-control select2-hide-search" style="width: 100%;">
                                    @foreach($month as $m)
                                        <option value="{{ sprintf('%02d', $m->month_id) }}"{{ $m->month_id == date('n') ? ' selected' : '' }}>{{ $m->month_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-2 type-quarter" style="display: none;">
                            <div class="form-group">
                                <label class="col-form-label">Quarter</label>
                                <select name="quarter" class="form-control select2-hide-search" style="width: 100%;">
                                    <option value="Q1"{{ date('m') == '04' || date('m') == '05' || date('m') == '06' ? ' selected' : '' }}>Q1</option>
                                    <option value="Q2"{{ date('m') == '07' || date('m') == '08' || date('m') == '09' ? ' selected' : '' }}>Q2</option>
                                    <option value="Q3"{{ date('m') == '10' || date('m') == '11' || date('m') == '12' ? ' selected' : '' }}>Q3</option>
                                    <option value="Q4"{{ date('m') == '01' || date('m') == '02' || date('m') == '03' ? ' selected' : '' }}>Q4</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2 type-year">
                            <div class="form-group">
                                <label class="col-form-label">Year</label>
                                <select name="year" class="form-control select2-hide-search" style="width: 100%;">
                                    @foreach($year as $y)
                                        <option value="{{ $y->year_name }}"{{ $y->year_name == date('Y') ? ' selected' : '' }}>{{ $y->year_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4 type-period" style="display: none;">
                            <div class="form-group">
                                <label class="col-form-label">Period</label>
                                <select name="period_id" class="form-control select2-hide-search" style="width: 100%;">
                                    @foreach($period_all as $p)
                                        <option value="{{ $p->period_id }}"{{ $p->period_id == $period->period_id ? ' selected' : '' }}>{{ $p->period_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-1 text-center" style="padding: 0;">
                            <button type="button" class="btn btn-primary btn-export" style="padding-top: 15px; padding-left: 15px; padding-right: 15px;">
                                <i class="feather icon-file-text"></i><br><br> Export
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4>Resignation Include Contract</h4>
                    <table class="table table-bordered table-striped nowrap" id="table-total" style="width: 100%;">
                        <thead>
                            <tr>
                                <th rowspan="2" style="vertical-align: middle; text-align: center; width: 25px;"> # </th>
                                <th rowspan="2" style="vertical-align: middle;"> Level </th>
                                <th rowspan="1" colspan="8" style="text-align: center;"> Reason </th>
                            </tr>
                            <tr>
                                <th style="text-align: center;"> Leadership Issue </th>
                                <th style="text-align: center;"> Working Location </th>
                                <th style="text-align: center;"> Better Benefit </th>
                                <th style="text-align: center;"> Career Development </th>
                                <th style="text-align: center;"> Family or Personal Reason </th>
                                <th style="text-align: center;"> Work Load </th>
                                <th style="text-align: center;"> Medical Reason </th>
                                <th style="text-align: center;"> Environment & Culture </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>

    $(document).ready(function() {

        $('.select2').select2({ theme : 'bootstrap4' });
        $('.select2-hide-search').select2({
            theme : 'bootstrap4',
            minimumResultsForSearch : Infinity
        });

        var table_total = $('#table-total').DataTable({
            processing : true,
            serverSide : true,
            scrollX : true,
            sDom : 't',
            ajax : {
                url : "{{ url('api/resignation/report/reason') }}",
                data : function(d) {
                    d.department_id = $('#filter select[name=department_id]').val();
                    d.type = $('#filter select[name=type]').val();
                    d.month = $('#filter select[name=month]').val();
                    d.quarter = $('#filter select[name=quarter]').val();
                    d.year = $('#filter select[name=year]').val();
                    d.period_id = $('#filter select[name=period_id]').val();
                }
            },
            columns : [
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'grade_group', name : 'grade_group' },
                { data : 'li', name : 'li' },
                { data : 'wl', name : 'wl' },
                { data : 'bb', name : 'bb' },
                { data : 'cd', name : 'cd' },
                { data : 'pr', name : 'pr' },
                { data : 'wlo', name : 'wlo' },
                { data : 'mr', name : 'mr' },
                { data : 'ec', name : 'ec' }
            ],
            columnDefs : [
                { orderable : false, targets : [0] },
                { searchable : false, targets : [0] },
                { createdCell : function(td, data, rowData, row, col) {
                    $(td).css('text-align', 'center') }, targets : [0,2,3,4,5,6,7,8,9]
                }
            ],
            order : []
        });

        $(document).on('change', '#filter select', function(e) {
            table_total.draw();
        });

        $(document).on('change', '#filter select[name=type]', function(e) {
            if($(this).val() == 1) {
                $('.type-month').css('display', 'block');
                $('.type-year').css('display', 'block');
                $('.type-quarter').css('display', 'none');
                $('.type-period').css('display', 'none');
            } else if($(this).val() == 2) {
                $('.type-month').css('display', 'none');
                $('.type-quarter').css('display', 'block');
                $('.type-year').css('display', 'block');
                $('.type-period').css('display', 'none');
            } else if($(this).val() == 3) {
                $('.type-month').css('display', 'none');
                $('.type-quarter').css('display', 'none');
                $('.type-year').css('display', 'none');
                $('.type-period').css('display', 'block');
            }
        });

        $(document).on('click', '.btn-export', function(e) {
            var department = $('#filter select[name=department_id]').val();
            var type = $('#filter select[name=type]').val();
            var month = $('#filter select[name=month]').val();
            var quarter = $('#filter select[name=quarter]').val();
            var year = $('#filter select[name=year]').val();
            var period = $('#filter select[name=period_id]').val();

            window.open('{!! url("resignation/report/reason/export?dept='+department+'&type='+type+'&month='+month+'&quarter='+quarter+'&year='+year+'&period='+period+'") !!}');
        });

    });

</script>
@endsection