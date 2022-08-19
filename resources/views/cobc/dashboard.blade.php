@extends('layouts.cobc')

@section('assets-top')
<link href="{{ asset('assets_dashforge/lib/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/select2-bootstrap4-theme/select2-bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/toastr/build/toastr.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css') }}" rel="stylesheet">

<style type="text/css">
    .form-fieldset {
        padding: 0px 10px 10px;
        margin-top: -20px;
    }
</style>
@endsection

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-10">
            <h3 class="page-title">Dashboard</h3>
        </div>
        <div class="col-2">
            <fieldset class="form-fieldset" id="filter">
                <legend>PERIOD</legend>
                <div class="form-group">
                    <select name="period" class="form-control select2-hide-search" style="width: 100%;">
                        @foreach($period_all as $p)
                            <option value="{{ $p->period_id }}"{{ $p->period_id == $period->period_id ? ' selected' : '' }}>{{ $p->period_name }}</option>
                        @endforeach
                    </select>
                </div>
            </fieldset>
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
        <div class="col-3">
            <div class="card card-body">
                <div class="row">
                    <div class="col-3 text-center">
                        <i class="fa fa-user" style="font-size: 45px; opacity: .2;"></i>
                    </div>
                    <div class="col-9">
                        <h5 class="font-bold" style="font-size: 1rem;">Total Employee</h5>
                        <div class="d-flex d-lg-block">
                            <h2 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 employee-all"></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card card-body">
                <div class="row">
                    <div class="col-3 text-center">
                        <i class="fa fa-user-check" style="font-size: 45px; opacity: .2;"></i>
                    </div>
                    <div class="col-9">
                        <h5 class="font-bold" style="font-size: 1rem;">Have Taken the Test</h5>
                        <div class="d-flex d-lg-block d-xl-flex align-items-end justify-content-between">
                            <h2 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 employee-have-taken"></h2>
                            <p class="tx-15 tx-color-03 mg-b-0">
                                <span class="tx-medium tx-success employee-have-taken-percentage"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card card-body">
                <div class="row">
                    <div class="col-3 text-center">
                        <i class="fa fa-user-times" style="font-size: 45px; opacity: .2;"></i>
                    </div>
                    <div class="col-9">
                        <h5 class="font-bold" style="font-size: 1rem;">Have not Taken the Test</h5>
                        <div class="d-flex d-lg-block d-xl-flex align-items-end justify-content-between">
                            <h2 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 employee-havent-taken"></h2>
                            <p class="tx-15 tx-color-03 mg-b-0">
                                <span class="tx-medium tx-danger employee-havent-taken-percentage"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card card-body">
                <div class="row">
                    <div class="col-3 text-center">
                        <i class="fa fa-user-minus" style="font-size: 45px; opacity: .2;"></i>
                    </div>
                    <div class="col-9">
                        <h5 class="font-bold" style="font-size: 1rem;">Retraining</h5>
                        <div class="d-flex d-lg-block d-xl-flex align-items-end justify-content-between">
                            <h2 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 employee-retraining"></h2>
                            <p class="tx-15 tx-color-03 mg-b-0">
                                <span class="tx-medium tx-danger employee-retraining-percentage"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
	<div class="row">
		<div class="col-5">
            <div class="card" style="min-height: 404px;">
                <div class="card-body">
                    <div class="row mb-1">
                        <div class="col-2">Name</div>
                        <div class="col-1">:</div>
                        <div class="col-9">{{ Auth::user()->user_name }}</div>
                    </div>
                    <div class="row">
                        <div class="col-2">NIK</div>
                        <div class="col-1">:</div>
                        <div class="col-9">{{ Auth::user()->user_nik }}</div>
                    </div>
                    
                    <br>
                    <div id="my-score"></div>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="card">
                <div class="card-body" style="padding-bottom: 0px;">
                    <h4>Employee Participation</h4>
                    <div class="row">
                        <?php $i = 1; ?>
                        @foreach($department as $d)
                            <div class="col-3 mb-3">
                                <h6 class="mg-b-0">{{ $d->department_name }}</h6>
                                <p class="tx-11 tx-color-03 mg-b-0">
                                    <span class="tx-medium tx-success part-have-taken-{{ $i }}"></span>
                                    <span class="tx-medium tx-danger float-right part-havent-taken-{{ $i }}"></span>
                                </p>
                                <div style="height: 125px; text-align: center;">
                                    <canvas id="employeeParticipation{{ $i++ }}"></canvas>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
	</div>
    <br>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4>Passing Rate</h4>
                    <div style="height: 800px;">
                        <canvas id="passingRate"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <div class="card card-body">
                <h4>Top Scorer</h4>
                <?php $width = (100 / count($department)) - 0.5; ?>
                <div>
                    @foreach($department as $d)
                        <div style="display: inline-block; width: {{ $width }}%;">
                            <h6 style="width: 100%; word-wrap: break-word;">{{ $d->department_name }}</h6>
                            <h1 class="top-score-{{ $d->department_id }}"></h1>
                        </div>
                    @endforeach
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
<script src="{{ asset('assets_dashforge/lib/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets_dashforge/lib/toastr/build/toastr.min.js') }}"></script>
<script src="{{ asset('assets_dashforge/lib/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets_dashforge/lib/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script src="{{ asset('assets_dashforge/lib/autonumeric/autoNumeric.js') }}"></script>
<script src="{{ asset('assets_dashforge/lib/chart.js/Chart.bundle.min.js') }}"></script>

<script type="text/javascript">
	
	$(document).ready(function() {

        $('.nav-dashboard').addClass('active');

        $('.select2').select2({
            theme: 'bootstrap4'
        });

        $('.select2-hide-search').select2({
            theme: 'bootstrap4',
            minimumResultsForSearch: Infinity
        });

        var period = $('#filter select[name=period]').val();
        
        myScore(period);
        employeeParticipation(period);
        passingRate(period);
        topScore(period);
        
        $(document).on('change', '#filter select[name=period]', function(e) {
            myScore($(this).val());
            employeeParticipation($(this).val());
            passingRate($(this).val());
            topScore($(this).val());
        });

	});

    function myScore(period) {
        var period_now = {!! json_encode($period->period_id); !!};

        $.ajax({
            type : "GET",
            url : "{{ url('api/cobc/my-score') }}?period_id="+period,
            dataType : "JSON",
            success : function(res) {
                var html = '';
                if(res.status == 'under_staff') {
                    html = `<h5>You don't have access for COBC Refreshment Test, Please Contact HR</h5><br>`;
                } else if(res.status == 'before_time') {
                    html = `<h5>It's not the time to take COBC Refreshment Test, Please Wait for more information</h5><br>`;
                } else if(res.status == 'new_emp') {
                    html = `<h5>You can take COBC Refreshment Test after working for 6 months</h5><br>`;
                } else if(res.status == 'new') {
                    html = `<h5>You have not taken the COBC Refreshment Test</h5><br>`;
                    if(period == period_now) {
                        html += `<center>
                            <a href="{{ url('/cobc/quiz') }}" class="btn btn-lg btn-primary" style="width: 200px;">START</a>
                        </center>`;
                    }
                } else if(res.status == 'continue') {
                    html = `<h5>You're in the middle of the test</h5>
                        <br>
                        <center>`;
                    if(res.score.length == 1) {
                        html += `<h6>Your score</h6>
                                <h1 style="font-size: 60px;">${res.score[0]}</h1>`;
                    } else if(res.score.length == 2) {
                        html += `<div class="row">
                                    <div class="col-6">
                                        <h6>Phase 1</h6>
                                        <h1 style="font-size: 50px;">${res.score[1]}</h1>
                                    </div>
                                    <div class="col-6">
                                        <h6>Your score</h6>
                                        <h1 style="font-size: 60px;">${res.score[0]}</h1>
                                    </div>
                                </div>`;
                    }

                    if(period == period_now) {
                        html += `<a href="{{ url('/cobc/quiz') }}" class="btn btn-lg btn-primary" style="width: 200px;">CONTINUE</a></center>`;
                    }
                } else if(res.status == 'try again') {
                    html = `<h5>You've failed the COBC Refreshment Test</h5>
                        <br>
                        <center>`;
                    if(res.score.length == 1) {
                        html += `<h6>Your score</h6>
                                <h1 style="font-size: 60px;">${res.score[0]}</h1>`;
                    } else if(res.score.length == 2) {
                        html += `<div class="row">
                                    <div class="col-6">
                                        <h6>Phase 1</h6>
                                        <h1 style="font-size: 50px;">${res.score[1]}</h1>
                                    </div>
                                    <div class="col-6">
                                        <h6>Your score</h6>
                                        <h1 style="font-size: 60px;">${res.score[0]}</h1>
                                    </div>
                                </div>`;
                    }

                    if(period == period_now) {
                        html += `<a href="{{ url('/cobc/quiz') }}" class="btn btn-lg btn-primary" style="width: 200px;">TRY AGAIN</a></center>`;
                    }
                } else if(res.status == 'failed') {
                    html = `<h5>You've failed the COBC Refreshment Test</h5>
                        <br>
                        <center>`;
                    if(res.score.length == 1) {
                        html += `<h6>Your score</h6>
                                <h1 style="font-size: 60px;">${res.score[0]}</h1>`;
                    } else if(res.score.length == 2) {
                        html += `<div class="row">
                                    <div class="col-6">
                                        <h6>Phase 1</h6>
                                        <h1 style="font-size: 50px;">${res.score[1]}</h1>
                                    </div>
                                    <div class="col-6">
                                        <h6>Your score</h6>
                                        <h1 style="font-size: 60px;">${res.score[0]}</h1>
                                    </div>
                                </div>`;
                    } else if(res.score.length == 3) {
                        html += `<div class="row">
                                    <div class="col-4">
                                        <h6>Phase 1</h6>
                                        <h1 style="font-size: 50px;">${res.score[2]}</h1>
                                    </div>
                                    <div class="col-4">
                                        <h6>Phase 2</h6>
                                        <h1 style="font-size: 50px;">${res.score[1]}</h1>
                                    </div>
                                    <div class="col-4">
                                        <h6>Your score</h6>
                                        <h1 style="font-size: 60px;">${res.score[0]}</h1>
                                    </div>
                                </div>`;
                    }
                    html += `</center>`;
                } else if(res.status == 'completed') {
                    html = `<h5>Congratulations! You've completed the COBC Refreshment Test</h5>
                        <br>
                        <center>`;
                    if(res.score.length == 1) {
                        html += `<h6>Your score</h6>
                                <h1 style="font-size: 60px;">${res.score[0]}</h1>`;
                    } else if(res.score.length == 2) {
                        html += `<div class="row">
                                    <div class="col-6">
                                        <h6>Phase 1</h6>
                                        <h1 style="font-size: 50px;">${res.score[1]}</h1>
                                    </div>
                                    <div class="col-6">
                                        <h6>Your score</h6>
                                        <h1 style="font-size: 60px;">${res.score[0]}</h1>
                                    </div>
                                </div>`;
                    } else if(res.score.length == 3) {
                        html += `<div class="row">
                                    <div class="col-4">
                                        <h6>Phase 1</h6>
                                        <h1 style="font-size: 50px;">${res.score[2]}</h1>
                                    </div>
                                    <div class="col-4">
                                        <h6>Phase 2</h6>
                                        <h1 style="font-size: 50px;">${res.score[1]}</h1>
                                    </div>
                                    <div class="col-4">
                                        <h6>Your score</h6>
                                        <h1 style="font-size: 60px;">${res.score[0]}</h1>
                                    </div>
                                </div>`;
                    }
                    html += `</center>`;
                } else if(res.status == 'after_time_no_score') {
                    html = `<h5>The time to take COBC Refreshment Test has passed, Please Contact HR for more information</h5><br>`;
                }

                $('#my-score').html(html);
            },
            error : function(jqXhr, errorThrown, textStatus) {
                console.log(errorThrown);
            }
        });
    }

    function employeeParticipation(period) {
        $.ajax({
            type : "GET",
            url : "{{ url('api/cobc/chart1') }}?period_id="+period,
            dataType : "JSON",
            beforeSend : function() {
                $('.se-pre-con').fadeIn();
            },
            success : function(res) {
                $('.employee-all').html(res.user_all);
                $('.employee-have-taken').html(res.have_taken);
                $('.employee-have-taken-percentage').html(res.have_taken_percentage+' %');
                $('.employee-havent-taken').html(res.havent_taken);
                $('.employee-havent-taken-percentage').html(res.havent_taken_percentage+' %');
                $('.employee-retraining').html(res.retraining);
                $('.employee-retraining-percentage').html(res.retraining_percentage+' %');

                var optionpie = {
                    maintainAspectRatio : false,
                    responsive : true,
                    legend : { display : false },
                    animation : {
                        animateScale : true,
                        animateRotate : true
                    }
                };

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

                for(var i=0; i<res.dept.length; i++) {
                    $('.part-have-taken-'+(i+1)).html(res.dept[i].have_taken_percentage + ' %');
                    $('.part-havent-taken-'+(i+1)).html(res.dept[i].havent_taken_percentage + ' %');

                    new Chart(document.getElementById('employeeParticipation'+(i+1)), {
                        type : 'pie',
                        data : {
                            labels : ['Have Taken', 'Haven\'t Taken'],
                            datasets : [{
                                data : [res.dept[i].have_taken, res.dept[i].havent_taken],
                                backgroundColor : [color[i], '#cbe0e3']
                            }]
                        },
                        options: optionpie
                    });
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

    function passingRate(period) {
        $.ajax({
            type : "GET",
            url : "{{ url('api/cobc/chart2') }}?period_id="+period,
            dataType : "JSON",
            success : function(res) {
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

                var object = [];

                $.each(res.department, function(key, val) {
                    object.push({ data : res.passing[key], label : val, backgroundColor : color[key]});
                });

                var ctx2 = document.getElementById('passingRate').getContext('2d');
                new Chart(ctx2, {
                    type : 'bar',
                    data : {
                        labels : res.grade_group,
                        datasets : object,
                    },
                    options : {
                        maintainAspectRatio : false,
                        responsive : true,
                        legend : {
                            display : true,
                            labels : {
                                display : true
                            }
                        },
                        scales: {
                            yAxes : [{
                                gridLines : {
                                    display : false
                                },
                                ticks : {
                                    beginAtZero : true,
                                    fontSize : 10,
                                    fontColor : '#182b49',
                                    max : 100
                                }
                            }],
                            xAxes : [{
                                gridLines : {
                                    color : '#e5e9f2'
                                },
                                barPercentage : 0.6,
                                ticks : {
                                    beginAtZero : true,
                                    fontSize : 11,
                                    fontColor : '#182b49',
                                    max : 100
                                }
                            }]
                        }
                    }
                });
            },
            error : function(jqXhr, errorThrown, textStatus) {
                console.log(errorThrown);
            }
        });
    }

    function topScore(period) {
        $.ajax({
            type : "GET",
            url : "{{ url('api/cobc/chart3') }}?period_id="+period,
            dataType : "JSON",
            success : function(res) {
                $.each(res, function(key, val) {
                    $('.top-score-'+key).html(val);
                });
            },
            error : function(jqXhr, errorThrown, textStatus) {
                console.log(errorThrown);
            }
        });
    }

</script>
@endsection