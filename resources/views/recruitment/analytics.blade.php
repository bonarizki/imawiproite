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
    <div class="content-header-left col-md-7 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">Analytics</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Report</li>
                        <li class="breadcrumb-item active">Analytics</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-5 col-12 d-md-block d-none">
        <div class="form-group row">
            <div class="col-4">
                <select name="filter_type" class="form-control select2-hide-search" style="width: 100%;">
                    <option value="period" selected> Period </option>
                    <option value="month_year"> Monthly </option>
                </select>
            </div>
        	<div class="col-8" id="filter_period">
        		<select name="period_id" class="form-control select2-hide-search" style="width: 100%;">
                    @foreach($period_all as $p)
                        <option value="{{ $p->period_id }}"{{ $p->period_id == $period->period_id ? ' selected' : '' }}>{{ $p->period_name }}</option>
                    @endforeach
                </select>
        	</div>
            <div class="col-8" id="filter_month_year" style="display: none;">
                <div class="row">
                    <div class="col-7">
                        <select name="month" class="form-control select2" style="width: 100%;">
                            @foreach($month as $m)
                                <option value="{{ $m->month_id }}"{{ $m->month_id == date('n') ? ' selected' : '' }}>{{ $m->month_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-5">
                        <select name="year" class="form-control select2-hide-search" style="width: 100%;">
                            @foreach($year as $y)
                                <option value="{{ $y->year_name }}"{{ $y->year_name == date('Y') ? ' selected' : '' }}>{{ $y->year_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
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
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0 recruitment-request">0</h2>
                        <p>Recruitment Request</p>
                    </div>
                    <div class="avatar bg-rgba-primary p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-user-plus text-primary font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0 recruitment-process">0</h2>
                        <p>Recruitment On Process</p>
                    </div>
                    <div class="avatar bg-rgba-warning p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-refresh-ccw text-warning font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0 recruitment-fulfilled">0</h2>
                        <p>Recruitment Fulfilled</p>
                    </div>
                    <div class="avatar bg-rgba-success p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-check-circle text-success font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="row">
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Hiring Resource</h4>
				</div>
				<div class="card-body">
					<div id="hiring-source" class="height-300"></div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Recruitment Request By Department</h4>
				</div>
				<div class="card-body">
					<div id="request-by-dept" class="height-300"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Average Lead Time</h4>
				</div>
				<div class="card-body">
					<div id="avg-leadtime" class="height-400"></div>
				</div>
			</div>
		</div>
	</div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Average Cost/Hire</h4>
                </div>
                <div class="card-body">
                    <div id="avg-costhire" class="height-400"></div>
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
            $('.nav-analytics').addClass('sidebar-group-active').addClass('active').addClass('open');
        }, 3000);

        $('.select2').select2();
        $('.select2-hide-search').select2({
            minimumResultsForSearch : Infinity
        });

        var period = $('select[name=period_id]').val();

        getRecruitCount('period', period, 0, 0);
        getHiringSource('period', period, 0, 0);
        getRequestByDept('period', period, 0, 0);
        getAverageLeadTime('period', period, 0, 0);
        getAverageCostHire('period', period, 0, 0);

        $(document).on('change', 'select[name=filter_type], select[name=period_id], select[name=month], select[name=year]', function(e) {
            var filter = $('select[name=filter_type]').val();
            var period = $('select[name=period_id]').val();
            var month = $('select[name=month]').val();
            var year = $('select[name=year]').val();

        	getRecruitCount(filter, period, month, year);
        	getHiringSource(filter, period, month, year);
        	getRequestByDept(filter, period, month, year);
        	getAverageLeadTime(filter, period, month, year);
            getAverageCostHire(filter, period, month, year);
        });

        $(document).on('change', 'select[name=filter_type]', function(e) {
            if($(this).val() == 'period') {
                $('#filter_period').css('display', 'block');
                $('#filter_month_year').css('display', 'none');
            } else {
                $('#filter_period').css('display', 'none');
                $('#filter_month_year').css('display', 'block');
            }
        });

	});

	function getRecruitCount(filter, period, month, year) {
		$.ajax({
            type : "GET",
            url : "{{ url('api/recruitment/chart/count') }}",
            data : {
                filter_type : filter,
                period_id : period,
                month : month,
                year : year
            },
            dataType : "JSON",
            success : function(res) {
                if(res) {
                	$('.recruitment-request').html(res.recruitment_request);
                	$('.recruitment-process').html(res.recruitment_process);
                	$('.recruitment-fulfilled').html(res.recruitment_fulfilled);
                }
            },
            error : function(jqXhr, errorThrown, textStatus) {
                console.log(errorThrown);
            }
        });
	}

	function getHiringSource(filter, period, month, year) {
		$.ajax({
            type : "GET",
            url : "{{ url('api/recruitment/chart/resource') }}",
            data : {
                filter_type : filter,
                period_id : period,
                month : month,
                year : year
            },
            dataType : "JSON",
            success : function(res) {
                var pieChart = echarts.init(document.getElementById('hiring-source'));

			    var pieChartoption = {
			        tooltip : {
			            trigger: 'item',
			            formatter: "{b} : {c} ({d}%)"
			        },
			        series : [
			            {
			                name: 'Hiring Source',
			                type: 'pie',
			                radius : '70%',
			                center: ['50%', '50%'],
			                color: ['#FF9F43','#28C76F','#EA5455','#87ceeb','#7367F0', '#000000'],
			                data: res,
			                itemStyle: {
			                    emphasis: {
			                        shadowBlur: 10,
			                        shadowOffsetX: 0,
			                        shadowColor: 'rgba(0, 0, 0, 0.5)'
			                    }
			                }
			            }
			        ],
			    };

			    pieChart.setOption(pieChartoption);
            },
            error : function(jqXhr, errorThrown, textStatus) {
                console.log(errorThrown);
            }
        });
	}

	function getRequestByDept(filter, period, month, year) {
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
            url : "{{ url('api/recruitment/chart/request') }}",
            data : {
                filter_type : filter,
                period_id : period,
                month : month,
                year : year
            },
            dataType : "JSON",
            success : function(res) {
                var pieChart = echarts.init(document.getElementById('request-by-dept'));

			    var pieChartoption = {
			        tooltip : {
			            trigger: 'item',
			            formatter: "{b} : {c} ({d}%)"
			        },
			        series : [
			            {
			                name: 'Recruitment Request By Department',
			                type: 'pie',
			                radius : '70%',
			                center: ['50%', '50%'],
			                color: color,
			                data: res,
			                itemStyle: {
			                    emphasis: {
			                        shadowBlur: 10,
			                        shadowOffsetX: 0,
			                        shadowColor: 'rgba(0, 0, 0, 0.5)'
			                    }
			                }
			            }
			        ],
			    };

			    pieChart.setOption(pieChartoption);
            },
            error : function(jqXhr, errorThrown, textStatus) {
                console.log(errorThrown);
            }
        });
	}

	function getAverageLeadTime(filter, period, month, year) {
		$.ajax({
            type : "GET",
            url : "{{ url('api/recruitment/chart/leadtime') }}",
            data : {
                filter_type : filter,
                period_id : period,
                month : month,
                year : year
            },
            dataType : "JSON",
            success : function(res) {
                var barChart = echarts.init(document.getElementById('avg-leadtime'));

			    var barChartoption = {
			        legend : {},
			        tooltip : {},
                    grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },
			        xAxis : {
			            type : 'category',
			            data : ['Workman', 'Promoter', 'Staff', 'Supervisor', 'Executive', 'Manager', 'Senior Manager'],
			            splitLine : { show : false },
			        },
			        yAxis : {},
			        series : [
			            {
			                name : 'Average Lead Time',
			                type : 'bar',
			                itemStyle : { color : '#4ea397' },
			                data : res
			            }
			        ]
			    };

			    barChart.setOption(barChartoption);
            },
            error : function(jqXhr, errorThrown, textStatus) {
                console.log(errorThrown);
            }
        });
	}

    function getAverageCostHire(filter, period, month, year) {
        $.ajax({
            type : "GET",
            url : "{{ url('api/recruitment/chart/costhire') }}",
            data : {
                filter_type : filter,
                period_id : period,
                month : month,
                year : year
            },
            dataType : "JSON",
            success : function(res) {
                var barChart = echarts.init(document.getElementById('avg-costhire'));

                var barChartoption = {
                    legend : {},
                    tooltip : {},
                    grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },
                    xAxis : {
                        type : 'category',
                        data : ['Workman', 'Promoter', 'Staff', 'Supervisor', 'Executive', 'Manager', 'Senior Manager'],
                        splitLine : { show : false },
                    },
                    yAxis : {},
                    series : [
                        {
                            name : 'Average Cost/Hire',
                            type : 'bar',
                            itemStyle : { color : '#4ea397' },
                            data : res
                        }
                    ]
                };

                barChart.setOption(barChartoption);
            },
            error : function(jqXhr, errorThrown, textStatus) {
                console.log(errorThrown);
            }
        });
    }

</script>
@endsection