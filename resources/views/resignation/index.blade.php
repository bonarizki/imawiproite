@extends('resignation/master/master')
@section('breadcumb', 'Dashboard')
@section('title', 'Dashboard')

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
	    <div class="content-header-left col-md-9 col-12 mb-2">
	        <div class="row breadcrumbs-top">
	            <div class="col-12">
	                <h2 class="content-header-title float-left mb-0">Dashboard</h2>
	                <div class="breadcrumb-wrapper col-12">
	                    <ol class="breadcrumb">
	                        <li class="breadcrumb-item active">Dashboard</li>
	                    </ol>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="content-header-right col-md-3 col-12 d-md-block d-none">
	        <div class="form-group row">
	        	<label class="col-form-label col-4">Period</label>
	        	<div class="col-8">
	        		<select name="period_id" class="form-control select2-hide-search" style="width: 100%;">
	                    @foreach($period_all as $p)
	                        <option value="{{ $p->period_id }}"{{ $p->period_id == $period->period_id ? ' selected' : '' }}>{{ $p->period_name }}</option>
	                    @endforeach
	                </select>
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
        getAttritionReason(period);
        getAttritionYears(period);

        $(document).on('change', 'select[name=period_id]', function(e) {
        	getResignCount($(this).val());
	        getAttritionReason($(this).val());
	        getAttritionYears($(this).val());
        });

	});

	function getResignCount(period) {
		$.ajax({
            type : "GET",
            url : "{{ url('api/resignation/dashboard/count') }}?period_id="+period,
            dataType : "JSON",
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

	function getAttritionReason(period) {
		$.ajax({
            type : "GET",
            url : "{{ url('api/resignation/dashboard/reason') }}?period_id="+period,
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

	function getAttritionYears(period) {
		$.ajax({
            type : "GET",
            url : "{{ url('api/resignation/dashboard/years') }}?period_id="+period,
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

</script>
@endsection
    