@extends('layouts.recruitment')

@section('assets-top')
<style type="text/css">
    .container-checkbox, .container-radio {
        display: block;
        position: relative;
        padding-top: 2px;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 15px;
        font-weight: 450 !important;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    .container-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }
    .container-radio input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }
    .container-checkbox .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #eee;
    }
    .container-radio .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 50%;
    }
    .container-checkbox:hover input ~ .checkmark, .container-radio:hover input ~ .checkmark {
        background-color: #ccc;
    }
    .container-checkbox input:checked ~ .checkmark, .container-radio input:checked ~ .checkmark {
        background-color: #2196F3;
    }
    .container-checkbox .checkmark:after, .container-radio .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }
    .container-checkbox input:checked ~ .checkmark:after, .container-radio input:checked ~ .checkmark:after {
        display: block;
    }
    .container-checkbox .checkmark:after {
        left: 7px;
        top: 3px;
        width: 6px;
        height: 11px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
    .container-radio .checkmark:after {
        top: 8.5px;
        left: 8.5px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: white;
    }
    .filepond--root {
        width: 75%;
    }
</style>
@endsection

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb -->
<!-- ============================================================== -->
<div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <h2 class="content-header-title float-left mb-0">Recruitment Request</h2>
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Recruitment Request
                    </li>
                </ol>
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
			<div class="card">
                <div class="card-body">
					<form method="post" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label class="col-form-label col-3">Title</label>
                            <div class="col-5">
                                <select name="title_id" class="form-control select2" id="title_id" data-placeholder="Select a Title" style="width: 100%;">
                                    <option></option>
                                    @foreach($title as $t)
                                        <option value="{{ $t->title_id }}">{{ $t->title_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-3">Grade</label>
                            <div class="col-4">
                                <select name="grade_id" class="form-control select2" id="grade_id" data-placeholder="Select a Grade" style="width: 100%;">
                                    <option></option>
                                    @foreach($grade as $g)
                                        <option value="{{ $g->grade_id }}">[{{ $g->grade_code }}] {{ $g->grade_name }}
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-3">Sex</label>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-4" style="padding-top: 7px;">
                                        <label class="container-radio"> Male
                                            <input type="radio" name="sex" value="Male" required>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col-4" style="padding-top: 7px;">
                                        <label class="container-radio"> Female
                                            <input type="radio" name="sex" value="Female" required>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col-4" style="padding-top: 7px;">
                                        <label class="container-radio"> Any
                                            <input type="radio" name="sex" value="Any" required>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-form-label col-3">Age</label>
                            <div class="col-2">
                                <div class="form-group">
                                    <input type="number" name="minimum_age" class="form-control" id="minimum_age" min="17" max="99" placeholder="Type minimum age..">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <label class="col-form-label col-2">Minimum</label>
                            <div class="col-2">
                                <div class="form-group">
                                    <input type="number" name="maximum_age" class="form-control" id="maximum_age" min="17" max="99" placeholder="Type maximum age..">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <label class="col-form-label col-2">Maximum</label>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-3">Reason for Request</label>
                            <div class="col-4">
                                <select name="reason_for_request" class="form-control select2-hide-search" id="reason_for_request" data-placeholder="Select a Reason for Request" style="width: 100%;">
                                    <option></option>
                                    <option value="Additional">Additional</option>
                                    <option value="Replacement">Replacement</option>
                                    <option value="Movement">Movement</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-3">Point of Hire</label>
                            <div class="col-4">
                                <select name="point_of_hire_id" class="form-control select2" id="point_of_hire_id" data-placeholder="Select a Point of Hire" style="width: 100%;">
                                    <option></option>
                                    @foreach($point_of_hire as $poh)
                                        <option value="{{ $poh->point_of_hire_id }}">{{ $poh->point_of_hire_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-3">Employment Status</label>
                            <div class="col-9">
                                <div class="row">
                                    <div class="col-3" style="padding-top: 7px;">
                                        <label class="container-radio"> Permanent
                                            <input type="radio" name="employment_status" value="Permanent" required>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col-2">
                                        <input type="text" name="probation_length" class="form-control numbers" id="probation_length" placeholder="Type.." disabled>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <label class="col-form-label col-4">months probation</label>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3"></div>
                            <div class="col-9">
                                <div class="row">
                                    <div class="col-3" style="padding-top: 7px;">
                                        <label class="container-radio"> Contract
                                            <input type="radio" name="employment_status" value="Contract" required>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col-2">
                                        <input type="text" name="contract_length" class="form-control numbers" id="contract_length" placeholder="Type.." disabled>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <label class="col-form-label col-4">months</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3"></div>
                            <div class="col-9">
                                <div class="row">
                                    <div class="col-3" style="padding-top: 7px;">
                                        <label class="container-radio"> Internship
                                            <input type="radio" name="employment_status" value="Internship" required>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col-2">
                                        <input type="text" name="internship_length" class="form-control numbers" id="internship_length" placeholder="Type.." disabled>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <label class="col-form-label col-4">months</label>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3"></div>
                            <div class="col-9">
                                <div class="row">
                                    <div class="col-3" style="padding-top: 7px;">
                                        <label class="container-radio"> Daily Worker
                                            <input type="radio" name="employment_status" value="Daily Worker" required>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="form-group col-2">
                                        <input type="text" name="daily_worker_length" class="form-control numbers" id="daily_worker_length" placeholder="Type.." disabled>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <label class="col-form-label col-1">days</label>
                                    <div class="form-group col-2">
                                        <input type="text" name="daily_worker_person" class="form-control numbers" id="daily_worker_person" placeholder="Type.." disabled>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <label class="col-form-label col-2">persons</label>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-form-label col-3">Expected Join Date</label>
                            <div class="col-3">
                                <fieldset class="form-group position-relative">
                                    <input type="text" name="expected_join_date" class="form-control" id="expected_join_date" placeholder="Choose date..">
                                    <div class="form-control-position">
                                        <i class="feather icon-calendar"></i>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-3">Status of Recruitment</label>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-6" style="padding-top: 7px;">
                                        <label class="container-radio"> Budgeted
                                            <input type="radio" name="recruitment_status" value="Budgeted" required>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col-6" style="padding-top: 7px;">
                                        <label class="container-radio"> Non Budgeted
                                            <input type="radio" name="recruitment_status" value="Non Budgeted" required>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <h4 class="mt-3">Basic Requirement</h4>
                        <div class="form-group row">
                            <label class="col-form-label col-3">Education</label>
                            <div class="col-2" style="padding-top: 7px;">
                                <label class="container-radio"> High School
                                    <input type="radio" name="education" value="High School" required>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-2" style="padding-top: 7px;">
                                <label class="container-radio"> Diploma
                                    <input type="radio" name="education" value="Diploma" required>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-2" style="padding-top: 7px;">
                                <label class="container-radio"> S1
                                    <input type="radio" name="education" value="S1" required>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-2" style="padding-top: 7px;">
                                <label class="container-radio"> S2
                                    <input type="radio" name="education" value="S2" required>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3"></div>
                            <div class="col-5">
                                <div class="row">
                                    <div class="col-4" style="padding-top: 7px;">
                                        <label class="container-radio"> Other
                                            <input type="radio" name="education" value="Other" required>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col-7">
                                        <input type="text" name="education_other" class="form-control" id="education_other" placeholder="Specify other education.." disabled>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-3">General Competency</label>
                            <div class="col-6">
                                <textarea name="general_competency" class="form-control" id="general_competency" rows="3" placeholder="Fill general competency.."></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-3">Specific Competency</label>
                            <div class="col-6">
                                <textarea name="specific_competency" class="form-control" id="specific_competency" rows="3" placeholder="Fill specific competency.."></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-3">Job Description</label>
                            <div class="col-6">
                                <textarea name="job_description" class="form-control" id="job_description" rows="3" placeholder="Fill job description.."></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-3">Special Note</label>
                            <div class="col-6">
                                <textarea name="special_note" class="form-control" id="special_note" rows="3" placeholder="Fill special note.."></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <h4>Proposed Package</h4>
                        <div class="form-group row">
                            <label class="col-form-label col-3">Basic Salary</label>
                            <div class="col-4">
                                <fieldset class="has-icon-left">
                                    <input type="text" name="basic_salary" class="form-control numbers" id="basic_salary" placeholder="Type basic salary..">
                                    <div class="form-control-position">Rp.</div>
                                    <div class="invalid-feedback"></div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-3">Allowances</label>
                            <div class="col-4">
                                <fieldset class="has-icon-left">
                                    <input type="text" name="allowances" class="form-control numbers" id="allowances" placeholder="Type allowances..">
                                    <div class="form-control-position">Rp.</div>
                                    <div class="invalid-feedback"></div>
                                </fieldset>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label class="col-form-label col-3">Organization Structure</label>
                            <div class="col-6">
                                <textarea name="organization_structure" class="form-control" id="organization_structure" rows="4" placeholder="Describe the requested position on your Organization Structure"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Organization Structure Attachment</label>
                            <input type="file" class="filepond-normal" data-max-file-size="10MB">
                            <input type="hidden" name="organization_structure_attach" class="filename">
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-lg btn-success" style="width: 150px;"> SUBMIT </button>
                        </div>
                    </form>
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
            $('.nav-recruitment').addClass('sidebar-group-active').addClass('active').addClass('open');
        }, 2000);

        $('.select2').select2();
        $('.select2-hide-search').select2({
            minimumResultsForSearch: Infinity
        })
        $('.numbers').autoNumeric('init', {mDec : '0'});

        $(document).on('change input', 'input[name=employment_status]', function(e) {
            if($(this).val() == 'Permanent') {
                $('input[name=probation_length]').prop('disabled', false);
                $('input[name=contract_length]').prop('disabled', true);
                $('input[name=internship_length]').prop('disabled', true);
                $('input[name=daily_worker_length]').prop('disabled', true);
                $('input[name=daily_worker_person]').prop('disabled', true);
            } else if($(this).val() == 'Contract') {
                $('input[name=probation_length]').prop('disabled', true);
                $('input[name=contract_length]').prop('disabled', false);
                $('input[name=internship_length]').prop('disabled', true);
                $('input[name=daily_worker_length]').prop('disabled', true);
                $('input[name=daily_worker_person]').prop('disabled', true);
            } else if($(this).val() == 'Internship') {
                $('input[name=probation_length]').prop('disabled', true);
                $('input[name=contract_length]').prop('disabled', true);
                $('input[name=internship_length]').prop('disabled', false);
                $('input[name=daily_worker_length]').prop('disabled', true);
                $('input[name=daily_worker_person]').prop('disabled', true);
            } else if($(this).val() == 'Daily Worker') {
                $('input[name=probation_length]').prop('disabled', true);
                $('input[name=contract_length]').prop('disabled', true);
                $('input[name=internship_length]').prop('disabled', true);
                $('input[name=daily_worker_length]').prop('disabled', false);
                $('input[name=daily_worker_person]').prop('disabled', false);
            }

            $('input[name=probation_length]').val('');
            $('input[name=contract_length]').val('');
            $('input[name=internship_length]').val('');
            $('input[name=daily_worker_length]').val('');
            $('input[name=daily_worker_person]').val('');
        });

        $(document).on('change input', 'input[name=education]', function(e) {
            if($(this).val() == 'Other') {
                $('input[name=education_other]').prop('disabled', false);
            } else {
                $('input[name=education_other]').prop('disabled', true);
            }

            $('input[name=education_other]').val('');
        });

        $('input[name=expected_join_date]').pickadate({
            format: 'mmm d, yyyy'
        });

		$(document).on('submit', 'form', function(e) {
            e.preventDefault();

            $.ajax({
                url : "{{ url('/recruitment/recruit') }}",
                type : "POST",
                data : $('form').serialize(),
                beforeSend : function() {
                    $('.se-pre-con').fadeIn();
                },
                success : function(res) {
                    $.ajax({
                        type : "POST",
                        url : "{{ url('recruitment/send-mail') }}",
                        data : {
                            "_token" : "{{ csrf_token() }}",
                            type : "approval",
                            recipient_name : res.recipient_name,
                            recipient_email : res.recipient_email,
                            recruit_code : res.recruit_code,
                            recruit_request : res.recruit_request,
                            recruit_title : res.recruit_title,
                            recruit_grade : res.recruit_grade
                        },
                        success : function(res) {
                            $('.se-pre-con').fadeOut();

                            swal({
                                title : 'SUCCESS',
                                text : 'Recruit has been created',
                                type : 'success',
                                showCancelButton : false, 
                                confirmButtonText : 'OK'
                            }).then((result) => {
                                if(result.value) {
                                    window.location.replace('{{ url("/recruitment/status") }}');
                                }
                            });
                        },
                        error : function(jqXhr, errorThrown, textStatus) {
                            $('.se-pre-con').fadeOut();
                            
                            swal({
                                title : 'SUCCESS',
                                text : 'Recruit has been created but failed to send Notification Email',
                                type : 'success',
                                showCancelButton : false, 
                                confirmButtonText : 'OK'
                            }).then((result) => {
                                if(result.value) {
                                    window.location.replace('{{ url("/recruitment/status") }}');
                                }
                            });
                        }
                    });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    $('.form-group .form-control').removeClass('is-invalid');
                    $('.form-group .invalid-feedback').empty();

                    var err = jqXhr.responseJSON;
                    if($.isEmptyObject(err) == false) {
                        $.each(err.errors, function(key, val) {
                            $('#'+key)
                                .closest('.form-control')
                                .addClass('is-invalid')
                                .parents('.form-group')
                                .find('.invalid-feedback')
                                .html(val)
                        });
                    }

                    $('.se-pre-con').fadeOut();
                }
            });
        });

        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginFileValidateSize);

        const osa = FilePond.create(document.querySelector('.filepond-normal'));

        osa.setOptions({
            server : {
                process : (filepond, file, metadata, load, error, progress, abort, transfer, options) => {

                    var formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append(filepond, file, file.name);

                    var request = new XMLHttpRequest();
                    request.open('POST', '{{ url("/recruitment/temp/osa") }}');

                    request.upload.onprogress = (e) => {
                        progress(e.lengthComputable, e.loaded, e.total);
                    };

                    request.onload = function() {
                        if (request.status >= 200 && request.status < 300) {
                            
                            $('input[name=organization_structure_attach]').val(request.response.substring(39, request.response.length-1));

                            load(request.responseText);
                        }
                        else {
                            error('oh no');
                        }
                    };

                    request.send(formData);
                    
                    return {
                        abort: () => {
                            request.abort();
                            abort();
                        }
                    };
                }
            }
        });

	});

</script>
@endsection