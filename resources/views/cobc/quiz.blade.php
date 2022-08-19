@extends('layouts.cobc')

@section('assets-top')
<link href="{{ asset('assets_dashforge/lib/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/select2-bootstrap4-theme/select2-bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/toastr/build/toastr.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets_dashforge/lib/icheck-bootstrap/icheck-bootstrap.min.css') }}" rel="stylesheet">

<style type="text/css">
    .card-header .bootstrap-switch {
        float: right;
    }
    .need-answer {
        background-color: #ffcccc;
    }
    .container {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 15px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default radio button */
    .container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    /* Create a custom radio button */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 22px;
        width: 22px;
        background-color: #eee;
        border-radius: 50%;
    }

    /* On mouse-over, add a grey background color */
    .container:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .container input:checked ~ .checkmark {
        background-color: #2196F3;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .container input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the indicator (dot/circle) */
    .container .checkmark:after {
        top: 7px;
        left: 7px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: white;
    }
</style>
@endsection

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 align-self-center">
            <h4 class="page-title d-inline">Quiz</h4>
            <div class="float-right">
                <input type="checkbox" class="float-right" id="language" value="1" data-bootstrap-switch>
                <input type="hidden" name="language" value="eng">
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
		<div class="col-12">
			<div class="card mb-4">
				<div class="card-body">
                    <input type="hidden" name="answer_id">
                    @for($i = 1; $i < 26; $i++)
                        <div class="row mb-1 answer_detail_id_{{ $i }}" style="padding: 10px;">
                            <input type="hidden" class="answer_detail_id" name="answer_detail_id_{{ $i }}">
                            <div class="col-1" style="max-width: 5%;">{{ $i }}.</div>
                            <div class="col-11">
                                <p style="font-size: 15px;" class="text-justify" id="question_text_{{ $i }}"></p>
                                <label class="container">
                                    <span class="text-justify" id="question_option_1_{{ $i }}"></span>
                                    <input type="radio" name="question_answer_{{ $i }}" value="1">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="container">
                                    <span class="text-justify" id="question_option_2_{{ $i }}"></span>
                                    <input type="radio" name="question_answer_{{ $i }}" value="2">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="container">
                                    <span class="text-justify" id="question_option_3_{{ $i }}"></span>
                                    <input type="radio" name="question_answer_{{ $i }}" value="3">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    @endfor
                </div>
			</div>
            <center>
                <button type="button" class="btn btn-lg btn-primary btn-submit" style="width: 200px;">SUBMIT</button>
            </center>
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

<script type="text/javascript">
	
	$(document).ready(function() {

        $('.select2').select2({
            theme: 'bootstrap4'
        });

        $('#language').bootstrapSwitch({
            onText : 'INA',
            offText : 'ENG',
            offColor : 'primary'
        });

		generateQuestion('eng');

        $(document).on('switchChange.bootstrapSwitch', '#language', function(event, state) {
            if(state) {
                $('input[name=language]').val('ina');
                generateQuestion('ina');
            } else {
                $('input[name=language]').val('eng');
                generateQuestion('eng');
            }
        });

        $(document).on('change', 'input[type=radio]', function(e) {
            var me = $(this);
            var id = $(this).parents('.row.mb-1').find('input.answer_detail_id').val();

            $.ajax({
                type : "POST",
                url : "{{ url('api/cobc/save') }}",
                data : {
                    "_token" : "{{ csrf_token() }}",
                    id : id,
                    answer : me.val()
                },
                success : function(res) {
                    me.parents('.row.mb-1').removeClass('need-answer');
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    swal({
                        title : 'Oops! Somethings wrong',
                        text : 'Refresh this page or contact the administrator',
                        type : 'warning',
                        showCancelButton : false, 
                        confirmButtonText : 'Refresh',
                        reverseButtons : true,
                    }).then((result) => {
                        if(result.value) {
                            window.location.href = "{{ url('/cobc/quiz') }}";
                        }
                    });
                }
            });
        });

        $(document).on('click', '.btn-submit', function(e) {
            var answer_id = $('input[name=answer_id]').val();

            $('.se-pre-con').fadeIn('fast');

            $.ajax({
                type : "GET",
                url : "{{ url('api/cobc/submit') }}?answer_id="+answer_id,
                dataType : "JSON",
                success : function(res) {
                    if(res.message == 'empty') {
                        $('html, body').animate({
                            scrollTop : $('.answer_detail_id_'+res.answer_detail_id).offset().top - 100
                        }, 2000);
                        $('.answer_detail_id_'+res.answer_detail_id).addClass('need-answer');
                        $('.se-pre-con').fadeOut('slow');
                    } else if(res.message == 'success') {
                        window.location.href = "{{ url('/cobc') }}";
                    }
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    swal({
                        title : 'Oops! Somethings wrong',
                        text : 'Refresh this page or contact the administrator',
                        type : 'warning',
                        showCancelButton : false, 
                        confirmButtonText : 'Refresh',
                        reverseButtons : true,
                    }).then((result) => {
                        if(result.value) {
                            window.location.href = "{{ url('/cobc/quiz') }}";
                        }
                    });
                }
            });
        });

	});

    function generateQuestion(lang) {
        $.ajax({
            type : "GET",
            url : "{{ url('api/cobc/generate') }}",
            dataType : "JSON",
            success : function(res) {
                $('input[name=answer_id]').val(res[0]['answer_id']);
                if(lang == 'eng') {
                    for(var i = 0; i < 25; i++) {
                        $('input[name=answer_detail_id_'+(i+1)+']').val(res[i]['answer_detail_id']);
                        $('#question_text_'+(i+1)).html(res[i]['question_text_eng']);
                        $('#question_option_1_'+(i+1)).html(res[i]['question_option_1_eng']);
                        $('#question_option_2_'+(i+1)).html(res[i]['question_option_2_eng']);
                        $('#question_option_3_'+(i+1)).html(res[i]['question_option_3_eng']);
                        if(res[i]['question_user_answer'] != null) {
                            $('input[name=question_answer_'+(i+1)+'][value='+res[i]['question_user_answer']+']').prop('checked', true);
                        }
                    }
                } else if(lang == 'ina') {
                    for(var i = 0; i < 25; i++) {
                        $('input[name=answer_detail_id_'+(i+1)+']').val(res[i]['answer_detail_id']);
                        $('#question_text_'+(i+1)).html(res[i]['question_text_bhs']);
                        $('#question_option_1_'+(i+1)).html(res[i]['question_option_1_bhs']);
                        $('#question_option_2_'+(i+1)).html(res[i]['question_option_2_bhs']);
                        $('#question_option_3_'+(i+1)).html(res[i]['question_option_3_bhs']);
                        if(res[i]['question_user_answer'] != null) {
                            $('input[name=question_answer_'+(i+1)+'][value='+res[i]['question_user_answer']+']').prop('checked', true);
                        }
                    }
                }
            },
            error : function(jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

</script>
@endsection