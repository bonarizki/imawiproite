@extends('resignation/master/master')
@section('breadcumb', 'Analytics')
@section('title', 'Analytics')

@section('content')
<style type="text/css">
	.top-count {
		flex: 0 0 20%;
		max-width: 20%;
		position: relative;
		width: 100%;
		padding-right: 10px;
		padding-left: 10px;
	}
</style>
<section id="basic-horizontal-layouts">
	<!-- ============================================================== -->
	<!-- Bread crumb -->
	<!-- ============================================================== -->
	<div class="content-header row">
	    <div class="content-header-left col-md-7 col-12 mb-2"></div>
	    <div class="content-header-right col-md-5 col-12 d-md-block d-none">
	        <div class="form-group row" style="margin-top: -50px;">
	            <div class="col-4">
	                <select name="filter_type" class="form-control select2-hide-search" style="width: 100%;">
	                    <option value="period" selected> Period </option>
	                    <option value="month_year"> Monthly </option>
	                </select>
	            </div>
	            <div class="col-8" id="filter_period">
	                <select name="period_id" class="form-control select2-hide-search" style="width: 100%;">
	                    @foreach($period_all as $p)
	                    <option value="{{ $p->period_id }}" {{ $p->period_id == $period->period_id ? ' selected' : '' }}>
	                        {{ $p->period_name }}</option>
	                    @endforeach
	                </select>
	            </div>
	            <div class="col-8" id="filter_month_year" style="display: none;">
	                <div class="row">
	                    <div class="col-7">
	                        <select name="month" class="form-control select2-hide-search" style="width: 100%;">
	                            @foreach($month as $m)
	                            <option value="{{ $m->month_id }}" {{ $m->month_id == date('n') ? ' selected' : '' }}>
	                                {{ $m->month_name }}</option>
	                            @endforeach
	                        </select>
	                    </div>
	                    <div class="col-5">
	                        <select name="year" class="form-control select2-hide-search" style="width: 100%;">
	                            @foreach($year as $y)
	                            <option value="{{ $y->year_name }}" {{ $y->year_name == date('Y') ? ' selected' : '' }}>
	                                {{ $y->year_name }}</option>
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
	<div class="row">
		<div class="top-count">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0 resignation-request">0</h2>
                        <p>Resignation<br>Request</p>
                    </div>
                    <div class="avatar bg-rgba-primary p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-user-plus text-primary font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
		</div>
		<div class="top-count">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0 resignation-approval">0</h2>
                        <p>Resignation<br>Waiting for Approval</p>
                    </div>
                    <div class="avatar bg-rgba-warning p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-refresh-ccw text-warning font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
		</div>
		<div class="top-count">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0 resignation-feedback">0</h2>
                        <p>Resignation<br>Waiting for Feedback</p>
                    </div>
                    <div class="avatar bg-rgba-warning p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-refresh-ccw text-warning font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
		</div>
		<div class="top-count">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0 resignation-clearance">0</h2>
                        <p>Resignation<br>Waiting for Clearance</p>
                    </div>
                    <div class="avatar bg-rgba-warning p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-refresh-ccw text-warning font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
		</div>
		<div class="top-count">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0 resignation-fulfilled">0</h2>
                        <p>Resignation<br>Completed</p>
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
		<div class="col-6">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Attrition Rate By Talent</h4>
				</div>
				<div class="card-body">
					<div id="attrition-talent" class="height-300"></div>
				</div>
			</div>
		</div>
		<div class="col-6">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Attrition Rate By Initiation</h4>
				</div>
				<div class="card-body">
					<div id="attrition-initiation" class="height-300"></div>
				</div>
			</div>
		</div>
		{{-- <div class="col-4">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Resignation By Department</h4>
				</div>
				<div class="card-body">
					<div id="resign-by-dept" class="height-300"></div>
				</div>
			</div>
		</div> --}}
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Attrition By Grade Group</h4>
				</div>
				<div class="card-body">
					<div id="attrition-gradeGroup" class="height-400"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Attrition By Age Category</h4>
				</div>
				<div class="card-body">
					<div id="attrition-ageCategory" class="height-400"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Attrition By Department</h4>
				</div>
				<div class="card-body">
					<div id="attrition-department" class="height-400"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Attrition By Reason</h4>
				</div>
				<div class="card-body">
					<div id="attrition-reason" class="height-400"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Attrition By Years of Service</h4>
				</div>
				<div class="card-body">
					<div id="attrition-years" class="height-400"></div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@section('script')
<script type="text/javascript">

	
	
	$(document).ready(function() {

		$('.select2-hide-search').select2({
			theme : 'bootstrap4',
			minimumResultsForSearch : Infinity
		});

		var period = $('select[name=period_id]').val();

        getResignCount(period);
        getAttritionTalent(period);
        getAttritionInitiation(period);
        getResignationByDept(period);
		getResignationByGradeGroup(period);
		getResignationByAgeCategory(period)
        getAttritionReason(period);
        getAttritionYears(period);

        $(document).on('change', 'select[name=filter_type], select[name=period_id], select[name=month], select[name=year]', function(e) {
			let data = {
				filter_type : $('select[name=filter_type]').val(),
				period_id	: $('select[name=period_id]').val(),
				month		: $('select[name=month]').val(),
				year 		: $('select[name=year]').val()
			};

			getResignationByAgeCategory($(this).val(),data);
        	getResignCount($(this).val(),data);
	        getAttritionTalent($(this).val(),data);
	        getAttritionInitiation($(this).val(),data);
	        getResignationByDept($(this).val(),data);
	        getResignationByGradeGroup($(this).val(),data);
	        getAttritionReason($(this).val(),data);
	        getAttritionYears($(this).val(),data);
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

	function getResignCount(period, data = null) {
		$.ajax({
            type : "GET",
            url : "{{ url('api/resignation/dashboard/count') }}",
            dataType : "JSON",
			data : data,
            success : function(res) {
                if(res) {
                	$('.resignation-request').html(res.resignation_request);
                	$('.resignation-approval').html(res.resignation_approval);
                	$('.resignation-feedback').html(res.resignation_feedback);
                	$('.resignation-clearance').html(res.resignation_clearance);
                	$('.resignation-fulfilled').html(res.resignation_fulfilled);
                }
            },
            error : function(jqXhr, errorThrown, textStatus) {
                console.log(errorThrown);
            }
        });
	}

	function getAttritionTalent(period, data = null) {
		$.ajax({
            type : "GET",
            url : "{{ url('api/resignation/dashboard/talent') }}",
			data : data,
            dataType : "JSON",
            success : function(res) {
                var pieChart = echarts.init(document.getElementById('attrition-talent'));

			    var pieChartoption = {
			        tooltip : {
			            trigger: 'item',
			            formatter: "{b} : {c} ({d}%)"
			        },
			        series : [
			            {
			                name: 'Attrition Rate By Talent',
			                type: 'pie',
			                radius : '60%',
			                center: ['50%', '50%'],
			                color: ['#FF9F43','#28C76F'],
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

	function getAttritionInitiation(period, data = null) {
		$.ajax({
            type : "GET",
            url : "{{ url('api/resignation/dashboard/initiation') }}",
			data : data,
            dataType : "JSON",
            success : function(res) {
                var pieChart = echarts.init(document.getElementById('attrition-initiation'));

			    var pieChartoption = {
			        tooltip : {
			            trigger: 'item',
			            formatter: "{b} : {c} ({d}%)"
			        },
			        series : [
			            {
			                name: 'Attrition Rate By Initiation',
			                type: 'pie',
			                radius : '60%',
			                center: ['50%', '50%'],
			                color: ['#FF9F43','#28C76F'],
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

	function getResignationByDept(period, data = null) {
		$.ajax({
            type : "GET",
            url : "{{ url('api/resignation/dashboard/department') }}",
			data : data,
            dataType : "JSON",
            success : function(res) {
                var barChart = echarts.init(document.getElementById('attrition-department'));

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
			            data : createArray(res,'name'),
						axisLabel: {
							interval: 0,
							rotate: 30 //If the label names are too long you can manage this by rotating the label.
						},
			            splitLine : { show : false },
			        },
			        yAxis : {},
			        series : [
			            {
			                name : 'Attrition Rate By Department',
			                type : 'bar',
			                itemStyle : { color : '#4ea397' },
			                data : createArray(res,'value')
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

	function getResignationByAgeCategory(period, data = null) {
		$.ajax({
            type : "GET",
            url : "{{ url('api/resignation/dashboard/ageCategory') }}",
			data : data,
            dataType : "JSON",
            success : function(res) {
                var barChart = echarts.init(document.getElementById('attrition-ageCategory'));

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
			            data : createArray(res,'name'),
						axisLabel: {
							interval: 0,
							rotate: 30 //If the label names are too long you can manage this by rotating the label.
						},
			            splitLine : { show : false },
			        },
			        yAxis : {},
			        series : [
			            {
			                name : 'Attrition Rate By Age Category',
			                type : 'bar',
			                itemStyle : { color : '#4ea397' },
			                data : createArray(res,'value')
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

	function getResignationByGradeGroup(period, data = null) {
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
            url : "{{ url('api/resignation/dashboard/gradeGroup') }}",
			data : data,
            dataType : "JSON",
            success : function(res) {
                var barChart = echarts.init(document.getElementById('attrition-gradeGroup'));

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
			            data : createArray(res,'name'),
						axisLabel: {
							interval: 0,
							rotate: 30 //If the label names are too long you can manage this by rotating the label.
						},
			            splitLine : { show : false },
			        },
			        yAxis : {},
			        series : [
			            {
			                name : 'Attrition Rate By Grade Group',
			                type : 'bar',
			                itemStyle : { color : '#4ea397' },
			                data : createArray(res,'value')
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

	function getAttritionReason(period, data = null) {
		$.ajax({
            type : "GET",
            url : "{{ url('api/resignation/dashboard/reason') }}",
			data : data,
            dataType : "JSON",
            success : function(res) {
                var barChart = echarts.init(document.getElementById('attrition-reason'));

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
			            data : ['Leadership Issue', 'Working Location', 'Better Benefit', 'Career Development', 'Family or Personal Reason', 'Work Load', 'Medical Reason', 'Environment & Culture'],
			            splitLine : { show : false },
						axisLabel: {
							interval: 0,
							rotate: 30 //If the label names are too long you can manage this by rotating the label.
						},
			        },
			        yAxis : {},
			        series : [
			            {
			                name : 'Attrition Rate By Reason',
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

	function getAttritionYears(period, data = null) {
		$.ajax({
            type : "GET",
            url : "{{ url('api/resignation/dashboard/years') }}",
			data : data,
            dataType : "JSON",
            success : function(res) {
                var barChart = echarts.init(document.getElementById('attrition-years'));

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
			            data : ['Less Than 1 Year', '1 to 3 Years', '3 to 10 Years', 'More Than 10 Years'],
						axisLabel: {
							interval: 0,
							rotate: 30 //If the label names are too long you can manage this by rotating the label.
						},
			            splitLine : { show : false },
			        },
			        yAxis : {},
			        series : [
			            {
			                name : 'Attrition Rate By Years of Service',
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

	createArray = (data,key) => {
		let array = []
		data.forEach(item => {
			array.push(item[key]);
		});
		return array
	}

</script>
@endsection
    