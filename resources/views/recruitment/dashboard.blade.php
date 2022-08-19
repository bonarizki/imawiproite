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
		<div class="col-12 col-md-12 col-sm-12 col-xs-12">
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
</div>
<!-- ============================================================== -->
<!-- End container fluid -->
<!-- ============================================================== -->


@endsection

@section('assets-bottom')
<script type="text/javascript">
	
	$(document).ready(function() {

        setTimeout(function() {
            $('.nav-dashboard').addClass('sidebar-group-active').addClass('active').addClass('open');
        }, 3000);

        $('.select2').select2();
        $('.select2-hide-search').select2({
            minimumResultsForSearch : Infinity
        });

        var period = $('select[name=period_id]').val();

        getRecruitCount(period);
        getRequestByDept(period);

        $(document).on('change', 'select[name=period_id]', function(e) {
        	getRecruitCount($(this).val());
        	getRequestByDept($(this).val());
        });

	});

	function getRecruitCount(period) {
		$.ajax({
            type : "GET",
            url : "{{ url('api/recruitment/chart/count') }}?period_id="+period,
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

	function getRequestByDept(period) {
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
            url : "{{ url('api/recruitment/chart/request') }}?period_id="+period,
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

</script>
@endsection