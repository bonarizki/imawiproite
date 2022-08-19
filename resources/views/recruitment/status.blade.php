@extends('layouts.recruitment')

@section('assets-top')
<style type="text/css">
    .table > tbody > tr > td > a > i {
        font-size: 18px;
    }
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
    .table-view thead tr th, .table-view tbody tr td {
        padding: .25rem;
        border-color: #E0E0E0;
    }
    .table-view thead tr th {
        background-color: #EFEFEF;
    }
    .table-view tbody tr td span {
        font-size: 12px;
    }
    .table-view tbody tr td img {
        margin-top: 5px;
        margin-bottom: 5px;
    }
    .table-view tbody tr td div {
        min-height: 184px;
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
            <h2 class="content-header-title float-left mb-0">Recruitment Status</h2>
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Recruitment</a>
                    </li>
                    <li class="breadcrumb-item active">Status
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
            <div class="card" id="filter" style="margin-bottom: 10px;">
                <div class="card-body" style="padding-bottom: 0px;">
                    <h4><i class="feather icon-filter"></i> Filter </h4>
                    <div class="row">
                        <div class="col-5">
                            <div class="form-group">
                                <label class="col-form-label">Requested Title</label>
                                <select name="title_id" class="form-control select2" style="width: 100%;">
                                    <option value="0">ALL TITLE</option>
                                    @foreach($title as $t)
                                        <option value="{{ $t->title_id }}">{{ $t->title_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="col-form-label">Point of Hire</label>
                                <select name="point_of_hire" class="form-control select2" style="width: 100%;">
                                    <option value="0">ALL POH</option>
                                    @foreach($point_of_hire as $poh)
                                        <option value="{{ $poh->point_of_hire_id }}">{{ $poh->point_of_hire_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
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
                    <ul class="nav nav-tabs nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="proceed-tab" data-toggle="tab" href="#proceed" role="tab" aria-controls="proceed" aria-selected="true">Proceed</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="unproceed-tab" data-toggle="tab" href="#unproceed" role="tab" aria-controls="unproceed" aria-selected="true">Unproceed</a>
                        </li>
                    </ul>
                    <div class="tab-content pt-1">
                        <div class="tab-pane active" id="proceed" role="tabpanel" aria-labelledby="proceed-tab">
                            <button type="button" class="btn btn-warning btn-cancel" style="width: 150px;">CANCEL</button>
        					<table class="table table-bordered table-striped nowrap" id="table-proceed" style="width: 100%;">
        						<thead>
        							<tr>
        								<th style="text-align: center; width: 25px;"> # </th>
                                        <th> Reference No </th>
                                        <th> Requested Title </th>
                                        <th> Requested Grade </th>
                                        <th> Point of Hire </th>
                                        <th> Requested By </th>
                                        <th style="text-align: center;"> Status </th>
                                        @if(in_array(Auth::user()->user_id, $hr) || in_array(Auth::user()->user_id, $super_admin))
                                            <th style="text-align: center; width: 41px;"> Process </th>
                                        @endif
                                        <th style="text-align: center; width: 41px;"> Edit </th>
                                        <th style="text-align: center; width: 41px;"> View </th>
                                        <th style="text-align: center; width: 41px;"> Copy </th>
                                        <th style="text-align: center; width: 41px;"> Export </th>
                                    </tr>
        						</thead>
        						<tbody></tbody>
        					</table>
                        </div>
                        <div class="tab-pane" id="unproceed" role="tabpanel" aria-labelledby="unproceed-tab">
                            <table class="table table-bordered table-striped nowrap" id="table-unproceed" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="text-align: center; width: 25px;"> # </th>
                                        <th> Reference No </th>
                                        <th> Requested Title </th>
                                        <th> Requested Grade </th>
                                        <th> Point of Hire </th>
                                        <th> Requested By </th>
                                        <th style="text-align: center;"> Status </th>
                                        <th style="text-align: center; width: 41px;"> View </th>
                                        <th style="text-align: center; width: 41px;"> Copy </th>
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
<!-- ============================================================== -->
<!-- Begin Modal edit -->
<!-- ============================================================== -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editRecruit">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form method="post">
				{{ csrf_field() }}
				<input type="hidden" name="id">
				<div class="modal-header">
					<h4 class="modal-title">Edit Recruit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
				</div>
				<div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-3">Title</label>
                        <div class="col-5">
                            <select name="title_id" class="form-control select2" id="title_id_edit" data-placeholder="Select a Title" style="width: 100%;">
                                <option></option>
                                @foreach($title as $t)
                                    <option value="{{ $t->title_id }}">{{ $t->title_name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-4 text-right">
                            <h2 class="text-bold-600 request_code"></h2>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Grade</label>
                        <div class="col-4">
                            <select name="grade_id" class="form-control select2" id="grade_id_edit" data-placeholder="Select a Grade" style="width: 100%;">
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
                                <input type="number" name="minimum_age" class="form-control" id="minimum_age_edit" min="17" max="99">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <label class="col-form-label col-2">Minimum</label>
                        <div class="col-2">
                            <div class="form-group">
                                <input type="number" name="maximum_age" class="form-control" id="maximum_age_edit" min="17" max="99">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <label class="col-form-label col-2">Maximum</label>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Reason for Request</label>
                        <div class="col-4">
                            <select name="reason_for_request" class="form-control select2-hide-search" id="reason_for_request_edit" data-placeholder="Select A Reason for Request" style="width: 100%;">
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
                            <select name="point_of_hire_id" class="form-control select2" id="point_of_hire_id_edit" data-placeholder="Select A Point of Hire" style="width: 100%;">
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
                                    <input type="text" name="probation_length" class="form-control numbers" id="probation_length_edit" placeholder="Type.." disabled>
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
                                    <input type="text" name="contract_length" class="form-control numbers" id="contract_length_edit" placeholder="Type.." disabled>
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
                                    <input type="text" name="internship_length" class="form-control numbers" id="internship_length_edit" placeholder="Type.." disabled>
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
                                    <input type="text" name="daily_worker_length" class="form-control numbers" id="daily_worker_length_edit" placeholder="Type.." disabled>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <label class="col-form-label col-1">days</label>
                                <div class="form-group col-2">
                                    <input type="text" name="daily_worker_person" class="form-control numbers" id="daily_worker_person_edit" placeholder="Type.." disabled>
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
                                <input type="text" name="expected_join_date" class="form-control" id="expected_join_date_edit" placeholder="Choose Date" readonly>
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
                    <h4>Basic Requirement</h4>
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
                                    <input type="text" name="education_other" class="form-control" id="education_other_edit" disabled>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3">General Competency</label>
                        <div class="col-6">
                            <textarea name="general_competency" class="form-control" id="general_competency_edit" rows="3" placeholder="Fill general competency.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Specific Competency</label>
                        <div class="col-6">
                            <textarea name="specific_competency" class="form-control" id="specific_competency_edit" rows="3" placeholder="Fill specific competency.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Job Description</label>
                        <div class="col-6">
                            <textarea name="job_description" class="form-control" id="job_description_edit" rows="3" placeholder="Fill job description.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Special Note</label>
                        <div class="col-6">
                            <textarea name="special_note" class="form-control" id="special_note_edit" rows="3" placeholder="Fill special note.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <h4>Proposed Package</h4>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Basic Salary</label>
                        <div class="col-4">
                            <fieldset class="has-icon-left">
                                <input type="text" name="basic_salary" class="form-control numbers" id="basic_salary_edit">
                                <div class="form-control-position">Rp.</div>
                                <div class="invalid-feedback"></div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Allowances</label>
                        <div class="col-4">
                            <fieldset class="has-icon-left">
                                <input type="text" name="allowances" class="form-control numbers" id="allowances_edit">
                                <div class="form-control-position">Rp.</div>
                                <div class="invalid-feedback"></div>
                            </fieldset>
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Organization Structure</label>
                        <div class="col-6">
                            <textarea name="organization_structure" class="form-control" id="organization_structure_edit" rows="4" placeholder="Describe the requested position on your Organization Structure"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Organization Structure Attachment</label>
                        <div class="file-upload">
                            <input type="file" class="filepond-edit" data-max-file-size="10MB">
                        </div>
                        <div class="file-info">
                            <a href="" target="_blank" class="btn btn-primary btn-download">
                                Download <i class="fa fa-download"></i>
                            </a>
                            <a href="javascript:;" class="btn btn-danger btn-delete">
                                <i class="fa fa-times"></i> Delete
                            </a>
                        </div>
                        <input type="hidden" name="organization_structure_attach" class="filename">
                    </div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Update</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- ============================================================== -->
<!-- End Modal edit -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Begin Modal copy -->
<!-- ============================================================== -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="copyRecruit">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h4 class="modal-title">Copy Recruit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-3">Title</label>
                        <div class="col-5">
                            <select name="title_id" class="form-control select2" id="title_id_copy" data-placeholder="Select a Title" style="width: 100%;">
                                <option></option>
                                @foreach($title as $t)
                                    <option value="{{ $t->title_id }}">{{ $t->title_name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-4 text-right">
                            <h2 class="text-bold-600 request_code"></h2>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Grade</label>
                        <div class="col-4">
                            <select name="grade_id" class="form-control select2" id="grade_id_copy" data-placeholder="Select a Grade" style="width: 100%;">
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
                                <input type="number" name="minimum_age" class="form-control" id="minimum_age_copy" min="17" max="99">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <label class="col-form-label col-2">Minimum</label>
                        <div class="col-2">
                            <div class="form-group">
                                <input type="number" name="maximum_age" class="form-control" id="maximum_age_copy" min="17" max="99">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <label class="col-form-label col-2">Maximum</label>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Reason for Request</label>
                        <div class="col-4">
                            <select name="reason_for_request" class="form-control select2-hide-search" id="reason_for_request_copy" data-placeholder="Select a Reason for Request" style="width: 100%;">
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
                            <select name="point_of_hire_id" class="form-control select2" id="point_of_hire_id_copy" data-placeholder="Select a Point of Hire" style="width: 100%;">
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
                                    <input type="text" name="probation_length" class="form-control numbers" id="probation_length_copy" placeholder="Type.." disabled>
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
                                    <input type="text" name="contract_length" class="form-control numbers" id="contract_length_copy" placeholder="Type.." disabled>
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
                                    <input type="text" name="internship_length" class="form-control numbers" id="internship_length_copy" placeholder="Type.." disabled>
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
                                    <input type="text" name="daily_worker_length" class="form-control numbers" id="daily_worker_length_copy" placeholder="Type.." disabled>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <label class="col-form-label col-1">days</label>
                                <div class="form-group col-2">
                                    <input type="text" name="daily_worker_person" class="form-control numbers" id="daily_worker_person_copy" placeholder="Type.." disabled>
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
                                <input type="text" name="expected_join_date" class="form-control" id="expected_join_date_copy" placeholder="Choose Date" readonly>
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
                    <h4>Basic Requirement</h4>
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
                                    <input type="text" name="education_other" class="form-control" id="education_other_copy" disabled>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3">General Competency</label>
                        <div class="col-6">
                            <textarea name="general_competency" class="form-control" id="general_competency_copy" rows="3" placeholder="Fill general competency.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Specific Competency</label>
                        <div class="col-6">
                            <textarea name="specific_competency" class="form-control" id="specific_competency_copy" rows="3" placeholder="Fill specific competency.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Job Description</label>
                        <div class="col-6">
                            <textarea name="job_description" class="form-control" id="job_description_copy" rows="3" placeholder="Fill job description.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Special Note</label>
                        <div class="col-6">
                            <textarea name="special_note" class="form-control" id="special_note_copy" rows="3" placeholder="Fill special note.."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <h4>Proposed Package</h4>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Basic Salary</label>
                        <div class="col-4">
                            <fieldset class="has-icon-left">
                                <input type="text" name="basic_salary" class="form-control numbers" id="basic_salary_copy">
                                <div class="form-control-position">Rp.</div>
                                <div class="invalid-feedback"></div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Allowances</label>
                        <div class="col-4">
                            <fieldset class="has-icon-left">
                                <input type="text" name="allowances" class="form-control numbers" id="allowances_copy">
                                <div class="form-control-position">Rp.</div>
                                <div class="invalid-feedback"></div>
                            </fieldset>
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Organization Structure</label>
                        <div class="col-6">
                            <textarea name="organization_structure" class="form-control" id="organization_structure_copy" rows="4" placeholder="Describe the requested position on your Organization Structure"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Organization Structure Attachment</label>
                        <input type="file" class="filepond-copy" data-max-file-size="10MB">
                        <input type="hidden" name="organization_structure_attach" class="filename">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Copy</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Modal copy -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Begin Modal view -->
<!-- ============================================================== -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="viewRecruit">
    <div class="modal-dialog modal-lg" style="max-width: 1000px;">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title">View Recruit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <p class="col-4">Requested By</p>
                                <p class="col-1">:</p>
                                <p class="col-7 requested_by"></p>
                            </div>
                            <div class="row">
                                <p class="col-4">Position</p>
                                <p class="col-1">:</p>
                                <p class="col-7 requestor_pos"></p>
                            </div>
                            <div class="row">
                                <p class="col-4">Department</p>
                                <p class="col-1">:</p>
                                <p class="col-7 department"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <p class="col-4">Date of Request</p>
                                <p class="col-1">:</p>
                                <p class="col-7 request_date"></p>
                            </div>
                            <div class="row">
                                <p class="col-4">Ticket No</p>
                                <p class="col-1">:</p>
                                <p class="col-7 request_code"></p>
                            </div>
                            <div class="row">
                                <p class="col-4">Status</p>
                                <p class="col-1">:</p>
                                <p class="col-7 recruit_status"></p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <p class="col-3">Title</p>
                        <p class="col-1">:</p>
                        <p class="col-8 title"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Grade</p>
                        <p class="col-1">:</p>
                        <p class="col-8 grade"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Sex</p>
                        <p class="col-1">:</p>
                        <p class="col-8 sex"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Age</p>
                        <p class="col-1">:</p>
                        <p class="col-8 age"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Reason for Request</p>
                        <p class="col-1">:</p>
                        <p class="col-8 reason_for_request"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Point of Hire</p>
                        <p class="col-1">:</p>
                        <p class="col-8 point_of_hire"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Employment Status</p>
                        <p class="col-1">:</p>
                        <p class="col-8 employment_status"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Expected Join Date</p>
                        <p class="col-1">:</p>
                        <p class="col-8 expected_join_date"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Status of Recruitment</p>
                        <p class="col-1">:</p>
                        <p class="col-8 recruitment_status"></p>
                    </div>
                    <h4>Basic Requirements</h4>
                    <div class="row">
                        <p class="col-3">Education</p>
                        <p class="col-1">:</p>
                        <p class="col-8 education"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">General Competency</p>
                        <p class="col-1">:</p>
                        <p class="col-8 general_competency"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Specific Competency</p>
                        <p class="col-1">:</p>
                        <p class="col-8 specific_competency"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Job Description</p>
                        <p class="col-1">:</p>
                        <p class="col-8 job_description"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Special Note</p>
                        <p class="col-1">:</p>
                        <p class="col-8 special_note"></p>
                    </div>
                    <h4>Proposed Package</h4>
                    <div class="row">
                        <p class="col-3">Basic Salary</p>
                        <p class="col-1">:</p>
                        <p class="col-8">Rp. <span class="numbers basic_salary"></span></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Allowances</p>
                        <p class="col-1">:</p>
                        <p class="col-8">Rp. <span class="numbers allowances"></span></p>
                    </div>
                    <br>
                    <div class="row">
                        <p class="col-3">Organization Structure</p>
                        <p class="col-1">:</p>
                        <p class="col-8 organization_structure"></p>
                    </div>
                    <div class="row">
                        <p class="col-3">Organization Structure Attachment</p>
                        <p class="col-1">:</p>
                        <div class="col-8 organization_structure_attach"></div>
                    </div>
                    <hr>
                    <table class="table table-bordered table-view">
                        <thead>
                            <tr>
                                <th style="text-align: center;"> Requested By </th>
                                <th colspan="4" style="text-align: center;"> Approved By </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center; width: 20%;">
                                    <div>
                                        <span class="position_proposed"></span><br>
                                        <img src="{{ asset('images/approved.png') }}" style="width: 100%;"><br>
                                        <span class="name_proposed"></span><br>
                                        <span class="nik_proposed"></span><br>
                                        <span class="date_proposed"></span>
                                    </div>
                                </td>
                                <td style="text-align: center; width: 20%;">
                                    <div>
                                        <span class="position_approval_1"></span><br>
                                        <span class="image_approval_1"></span><br>
                                        <span class="name_approval_1"></span><br>
                                        <span class="nik_approval_1"></span><br>
                                        <span class="date_approval_1"></span>
                                    </div>
                                </td>
                                <td style="text-align: center; width: 20%;">
                                    <div>
                                        <span class="position_approval_2"></span><br>
                                        <span class="image_approval_2"></span><br>
                                        <span class="name_approval_2"></span><br>
                                        <span class="nik_approval_2"></span><br>
                                        <span class="date_approval_2"></span>
                                    </div>
                                </td>
                                <td style="text-align: center; width: 20%;">
                                    <div>
                                        <span class="position_approval_3"></span><br>
                                        <span class="image_approval_3"></span><br>
                                        <span class="name_approval_3"></span><br>
                                        <span class="nik_approval_3"></span><br>
                                        <span class="date_approval_3"></span>
                                    </div>
                                </td>
                                <td style="text-align: center; width: 20%;">
                                    <div>
                                        <span class="position_approval_4"></span><br>
                                        <span class="image_approval_4"></span><br>
                                        <span class="name_approval_4"></span><br>
                                        <span class="nik_approval_4"></span><br>
                                        <span class="date_approval_4"></span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-6">
                            <table class="table table-bordered table-view">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="text-align: center;"> Approved By </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: center; width: 50%;">
                                            <div>
                                                <span class="position_approval_5"></span><br>
                                                <span class="image_approval_5"></span><br>
                                                <span class="name_approval_5"></span><br>
                                                <span class="nik_approval_5"></span><br>
                                                <span class="date_approval_5"></span>
                                            </div>
                                        </td>
                                        <td style="text-align: center; width: 50%;">
                                            <div>
                                                <span class="position_approval_6"></span><br>
                                                <span class="image_approval_6"></span><br>
                                                <span class="name_approval_6"></span><br>
                                                <span class="nik_approval_6"></span><br>
                                                <span class="date_approval_6"></span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-3">
                            <table class="table table-bordered table-view">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;"> Approved By CEO </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: center;">
                                            <div>
                                                <span class="position_approval_ceo"></span><br>
                                                <span class="image_approval_ceo"></span><br>
                                                <span class="name_approval_ceo"></span><br>
                                                <span class="nik_approval_ceo"></span><br>
                                                <span class="date_approval_ceo"></span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-3">
                            <table class="table table-bordered table-view">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;"> Reviewed By HR </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: center;">
                                            <div>
                                                <span class="position_approval_hr"></span><br>
                                                <span class="image_approval_hr"></span><br>
                                                <span class="name_approval_hr"></span><br>
                                                <span class="nik_approval_hr"></span><br>
                                                <span class="date_approval_hr"></span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="approval_note_1"></div>
                    <div class="approval_note_2"></div>
                    <div class="approval_note_3"></div>
                    <div class="approval_note_4"></div>
                    <div class="approval_note_5"></div>
                    <div class="approval_note_6"></div>
                    <div class="approval_note_ceo"></div>
                    <div class="approval_note_hr"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Modal view -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Begin Modal Cancel -->
<!-- ============================================================== -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="cancelRecruit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title">Cancel Recruit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>You're going to Cancel these Recruits</h4><br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 5%; text-align: center;"> No </th>
                                <th> Reference No </th>
                                <th> Requested Title </th>
                                <th> Requested Grade </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-flat btn-warning">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Modal Cancel -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Begin Modal Process -->
<!-- ============================================================== -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="processRecruit">
    <div class="modal-dialog modal-lg" style="max-width: 1000px;">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h4 class="modal-title">Process Recruit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <p class="col-4">Requested By</p>
                                <p class="col-1">:</p>
                                <p class="col-7 requested_by"></p>
                            </div>
                            <div class="row">
                                <p class="col-4">Position</p>
                                <p class="col-1">:</p>
                                <p class="col-7 requestor_pos"></p>
                            </div>
                            <div class="row">
                                <p class="col-4">Department</p>
                                <p class="col-1">:</p>
                                <p class="col-7 department"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <p class="col-4">Date of Request</p>
                                <p class="col-1">:</p>
                                <p class="col-7 request_date"></p>
                            </div>
                            <div class="row">
                                <p class="col-4">Ticket No</p>
                                <p class="col-1">:</p>
                                <p class="col-7 request_code"></p>
                            </div>
                            <div class="row">
                                <p class="col-4">Reviewed by HR</p>
                                <p class="col-1">:</p>
                                <p class="col-7 reviewed_date"></p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <p class="col-4">Title</p>
                                <p class="col-1">:</p>
                                <p class="col-7 title"></p>
                            </div>
                            <div class="row">
                                <p class="col-4">Grade</p>
                                <p class="col-1">:</p>
                                <p class="col-7 grade"></p>
                            </div>
                            <div class="row">
                                <p class="col-4">Sex</p>
                                <p class="col-1">:</p>
                                <p class="col-7 sex"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <p class="col-4">Age</p>
                                <p class="col-1">:</p>
                                <p class="col-7 age"></p>
                            </div>
                            <div class="row">
                                <p class="col-4">Reason for Request</p>
                                <p class="col-1">:</p>
                                <p class="col-7 reason_for_request"></p>
                            </div>
                            <div class="row">
                                <p class="col-4">Point of Hire</p>
                                <p class="col-1">:</p>
                                <p class="col-7 point_of_hire"></p>
                            </div>
                        </div>
                    </div>
                    <h4>Process</h4>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Candidate Name</label>
                        <div class="col-5">
                            <input type="text" name="candidate_name" class="form-control" maxlength="100" placeholder="Type candidate name..">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Hiring Resource</label>
                        <div class="col-5">
                            <select name="hiring_resource" class="form-control select2-hide-search" id="hiring_resource" data-placeholder="Select A Hiring Resource" style="width: 100%;">
                                <option></option>
                                <option value="Internal">Internal</option>
                                <option value="Head Hunter">Head Hunter</option>
                                <option value="Job Fair">Job Fair</option>
                                <option value="Job Ads">Job Ads</option>
                                <option value="LinkedIn">LinkedIn</option>
                                <option value="Outsourcing">Outsourcing</option>
                                <option value="Reference">Reference</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Join Date</label>
                        <div class="col-4">
                            <fieldset class="form-group position-relative">
                                <input type="text" name="join_date" class="form-control" placeholder="Choose A Date" readonly>
                                <div class="form-control-position">
                                    <i class="feather icon-calendar"></i>
                                </div>
                                <div class="invalid-feedback"></div>
                            </fieldset>
                        </div>
                    </div>
                    <h4>Hiring Cost</h4>
                    <div class="form-group row">
                        <label class="col-form-label col-3">External Cost</label>
                        <div class="col-4">
                            <fieldset class="has-icon-left">
                                <input type="text" name="external_cost" class="form-control numbers" placeholder="Type external cost..">
                                <div class="form-control-position">Rp.</div>
                                <div class="invalid-feedback"></div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Internal Cost</label>
                        <div class="col-4">
                            <fieldset class="has-icon-left">
                                <input type="text" name="internal_cost" class="form-control numbers" placeholder="Type internal cost..">
                                <div class="form-control-position">Rp.</div>
                                <div class="invalid-feedback"></div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Advertising Expenses</label>
                        <div class="col-4">
                            <fieldset class="has-icon-left">
                                <input type="text" name="advertising_expenses" class="form-control numbers" placeholder="Type advertising expenses..">
                                <div class="form-control-position">Rp.</div>
                                <div class="invalid-feedback"></div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Assessment Online</label>
                        <div class="col-4">
                            <fieldset class="has-icon-left">
                                <input type="text" name="assessment_online" class="form-control numbers" placeholder="Type assessment online..">
                                <div class="form-control-position">Rp.</div>
                                <div class="invalid-feedback"></div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Medical Checkup</label>
                        <div class="col-4">
                            <fieldset class="has-icon-left">
                                <input type="text" name="medical_checkup" class="form-control numbers" placeholder="Type medical checkup..">
                                <div class="form-control-position">Rp.</div>
                                <div class="invalid-feedback"></div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Travel Expenses</label>
                        <div class="col-4">
                            <fieldset class="has-icon-left">
                                <input type="text" name="travel_expenses" class="form-control numbers" placeholder="Type travel expenses..">
                                <div class="form-control-position">Rp.</div>
                                <div class="invalid-feedback"></div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Hiring Bonus</label>
                        <div class="col-4">
                            <fieldset class="has-icon-left">
                                <input type="text" name="hiring_bonus" class="form-control numbers" placeholder="Type hiring bonus..">
                                <div class="form-control-position">Rp.</div>
                                <div class="invalid-feedback"></div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-3">Referral Bonus</label>
                        <div class="col-4">
                            <fieldset class="has-icon-left">
                                <input type="text" name="referral_bonus" class="form-control numbers" placeholder="Type referral bonus..">
                                <div class="form-control-position">Rp.</div>
                                <div class="invalid-feedback"></div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-flat btn-primary">Process</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Modal Process -->
<!-- ============================================================== -->
@endsection

@section('assets-bottom')
<script type="text/javascript">
	
	$(document).ready(function() {

        setTimeout(function() {
            $('.nav-status').addClass('sidebar-group-active').addClass('active').addClass('open');
        }, 3000);

        $('.select2').select2();
        $('.select2-hide-search').select2({
            minimumResultsForSearch : Infinity
        });
        $('.numbers').autoNumeric('init', {mDec : '0'});

		var table_proceed = $('#table-proceed').DataTable({
			processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/recruitment/recruit') }}",
                data : function(d) {
                    d.page = 'proceed';
                    d.title_id = $('#filter select[name=title_id]').val();
                    d.point_of_hire = $('#filter select[name=point_of_hire]').val();
                    d.period_id = $('#filter select[name=period_id]').val();
                }
            },
            columns : [
                { data : 'check_cancel', name : 'check_cancel' },
                { data : 'request_code', name : 'request_code' },
                { data : 'title_name', name : 'title_name' },
                { data : 'grade', name : 'grade' },
                { data : 'point_of_hire', name : 'point_of_hire' },
                { data : 'user', name : 'user' },
                { data : 'status', name : 'status' },
                @if(in_array(Auth::user()->user_id, $hr) || (in_array(Auth::user()->user_id, $super_admin)))
                    { data : 'process', name : 'process' },
                @endif
                { data : 'edit', name : 'edit' },
                { data : 'view', name : 'view' },
                { data : 'copy', name : 'copy' },
                { data : 'export', name : 'export' }
            ],
            columnDefs : [
                @if(in_array(Auth::user()->user_id, $hr) || in_array(Auth::user()->user_id, $super_admin))
                    { orderable : false, targets : [0,6,7,8,9,10,11] },
                    { searchable : false, targets : [0,6,7,8,9,10,11] },
                    { createdCell : function(td, data, rowData, row, col) {
                        $(td).css('text-align', 'center') }, targets : [0,6,7,8,9,10,11]
                    }
                @else
                    { orderable : false, targets : [0,6,7,8,9,10] },
                    { searchable : false, targets : [0,6,7,8,9,10] },
                    { createdCell : function(td, data, rowData, row, col) {
                        $(td).css('text-align', 'center') }, targets : [0,6,7,8,9,10]
                    }
                @endif
            ],
			order : [],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
		});

        var table_unproceed = $('#table-unproceed').DataTable({
            processing : true,
            serverSide : true,
            scrollX : true,
            ajax : {
                url : "{{ url('api/recruitment/recruit') }}",
                data : function(d) {
                    d.page = 'unproceed';
                    d.title_id = $('#filter select[name=title_id]').val();
                    d.point_of_hire = $('#filter select[name=point_of_hire]').val();
                    d.period_id = $('#filter select[name=period_id]').val();
                }
            },
            columns : [
                { data : 'DT_RowIndex', name : 'DT_RowIndex' },
                { data : 'request_code', name : 'request_code' },
                { data : 'title_name', name : 'title_name' },
                { data : 'grade', name : 'grade' },
                { data : 'point_of_hire', name : 'point_of_hire' },
                { data : 'user', name : 'user' },
                { data : 'status', name : 'status' },
                { data : 'view', name : 'view' },
                { data : 'copy', name : 'copy' }
            ],
            columnDefs : [
                { orderable : false, targets : [0,6,7,8] },
                { searchable : false, targets : [0,6,7,8] },
                { createdCell : function(td, data, rowData, row, col) {
                    $(td).css('text-align', 'center') }, targets : [0,6,7,8]
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
            table_proceed.draw();
        }, 2000);

        $(document).on('show.bs.tab', '#proceed-tab', function(e) {
            table_proceed.draw();
        });

        $(document).on('show.bs.tab', '#unproceed-tab', function(e) {
            table_unproceed.draw();
        });

        $(document).on('change', '#filter select', function(e) {
            table_proceed.draw();
            table_unproceed.draw();
        });

        $(document).on('click', '.btn-cancel', function(e) {
            var modal = $('#cancelRecruit');

            modal.find('table tbody').empty();
            modal.find('input[name="recruit_id[]"]').remove();

            $('input[name="cancel[]"]:checked').each(function(index) {
                var id = $(this).val();
                modal.find('.modal-body').append('<input type="hidden" name="recruit_id[]" value="'+id+'">');
                $.ajax({
                    type : "GET",
                    url : "{{ url('api/recruitment/get-recruit') }}?id="+id,
                    dataType : "JSON",
                    success : function(res) {
                        modal.find('table tbody').append('<tr><td>'+(index+1)+'</td><td>'+res.request_code+'</td><td>'+res.title_name+'</td><td>['+res.grade_code+'] '+res.grade_name+'</td></tr>');
                    },
                    error : function(jqXhr, errorThrown, textStatus) {
                        console.log(errorThrown);
                    }
                });
            });

            modal.modal('show');
        });

        $(document).on('submit', '#cancelRecruit form', function(e) {
            e.preventDefault();

            $.ajax({
                url : "{{ url('recruitment/cancel') }}",
                type : "POST",
                data : $('#cancelRecruit form').serialize(),
                success : function(res) {
                    table_proceed.draw(false);
                    table_unproceed.draw(false);
                    $('#cancelRecruit').modal('hide');

                    $.each(res.data, function(key, val) {
                        if(val['icon'] == 'success') {
                            toastr.success(val['title'], 'Recruits Canceled', { "closeButton": true });
                        } else if(val['icon'] == 'error') {
                            toastr.error(val['title'], 'Error', { "closeButton" : true });
                        }
                    });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        });

        $(document).on('change input', '#editRecruit input[name=employment_status]', function(e) {
            if($(this).val() == 'Permanent') {
                $('#editRecruit input[name=probation_length]').prop('disabled', false);
                $('#editRecruit input[name=contract_length]').prop('disabled', true);
                $('#editRecruit input[name=internship_length]').prop('disabled', true);
                $('#editRecruit input[name=daily_worker_length]').prop('disabled', true);
                $('#editRecruit input[name=daily_worker_person]').prop('disabled', true);
            } else if($(this).val() == 'Contract') {
                $('#editRecruit input[name=probation_length]').prop('disabled', true);
                $('#editRecruit input[name=contract_length]').prop('disabled', false);
                $('#editRecruit input[name=internship_length]').prop('disabled', true);
                $('#editRecruit input[name=daily_worker_length]').prop('disabled', true);
                $('#editRecruit input[name=daily_worker_person]').prop('disabled', true);
            } else if($(this).val() == 'Internship') {
                $('#editRecruit input[name=probation_length]').prop('disabled', true);
                $('#editRecruit input[name=contract_length]').prop('disabled', true);
                $('#editRecruit input[name=internship_length]').prop('disabled', false);
                $('#editRecruit input[name=daily_worker_length]').prop('disabled', true);
                $('#editRecruit input[name=daily_worker_person]').prop('disabled', true);
            } else if($(this).val() == 'Daily Worker') {
                $('#editRecruit input[name=probation_length]').prop('disabled', true);
                $('#editRecruit input[name=contract_length]').prop('disabled', true);
                $('#editRecruit input[name=internship_length]').prop('disabled', true);
                $('#editRecruit input[name=daily_worker_length]').prop('disabled', false);
                $('#editRecruit input[name=daily_worker_person]').prop('disabled', false);
            }

            $('#editRecruit input[name=probation_length]').val('');
            $('#editRecruit input[name=contract_length]').val('');
            $('#editRecruit input[name=internship_length]').val('');
            $('#editRecruit input[name=daily_worker_length]').val('');
            $('#editRecruit input[name=daily_worker_person]').val('');
        });

        $(document).on('change input', '#editRecruit input[name=education]', function(e) {
            if($(this).val() == 'Other') {
                $('#editRecruit input[name=education_other]').prop('disabled', false);
            } else {
                $('#editRecruit input[name=education_other]').prop('disabled', true);
            }

            $('#editRecruit input[name=education_other]').val('');
        });

        $('#editRecruit input[name=expected_join_date], #copyRecruit input[name=expected_join_date], #processRecruit input[name=join_date]').pickadate({
            format: 'mmm d, yyyy'
        });

        $(document).on('change input', '#copyRecruit input[name=employment_status]', function(e) {
            if($(this).val() == 'Permanent') {
                $('#copyRecruit input[name=probation_length]').prop('disabled', false);
                $('#copyRecruit input[name=contract_length]').prop('disabled', true);
                $('#copyRecruit input[name=internship_length]').prop('disabled', true);
                $('#copyRecruit input[name=daily_worker_length]').prop('disabled', true);
                $('#copyRecruit input[name=daily_worker_person]').prop('disabled', true);
            } else if($(this).val() == 'Contract') {
                $('#copyRecruit input[name=probation_length]').prop('disabled', true);
                $('#copyRecruit input[name=contract_length]').prop('disabled', false);
                $('#copyRecruit input[name=internship_length]').prop('disabled', true);
                $('#copyRecruit input[name=daily_worker_length]').prop('disabled', true);
                $('#copyRecruit input[name=daily_worker_person]').prop('disabled', true);
            } else if($(this).val() == 'Internship') {
                $('#copyRecruit input[name=probation_length]').prop('disabled', true);
                $('#copyRecruit input[name=contract_length]').prop('disabled', true);
                $('#copyRecruit input[name=internship_length]').prop('disabled', false);
                $('#copyRecruit input[name=daily_worker_length]').prop('disabled', true);
                $('#copyRecruit input[name=daily_worker_person]').prop('disabled', true);
            } else if($(this).val() == 'Daily Worker') {
                $('#copyRecruit input[name=probation_length]').prop('disabled', true);
                $('#copyRecruit input[name=contract_length]').prop('disabled', true);
                $('#copyRecruit input[name=internship_length]').prop('disabled', true);
                $('#copyRecruit input[name=daily_worker_length]').prop('disabled', false);
                $('#copyRecruit input[name=daily_worker_person]').prop('disabled', false);
            }

            $('#copyRecruit input[name=probation_length]').val('');
            $('#copyRecruit input[name=contract_length]').val('');
            $('#copyRecruit input[name=internship_length]').val('');
            $('#copyRecruit input[name=daily_worker_length]').val('');
            $('#copyRecruit input[name=daily_worker_person]').val('');
        });

        $(document).on('change input', '#copyRecruit input[name=education]', function(e) {
            if($(this).val() == 'Other') {
                $('#copyRecruit input[name=education_other]').prop('disabled', false);
            } else {
                $('#copyRecruit input[name=education_other]').prop('disabled', true);
            }

            $('#copyRecruit input[name=education_other]').val('');
        });

		$(document).on('click', '.btn-edit', function(e) {
			var modal = $('#editRecruit');
            var id = e.currentTarget.dataset.id;

            var month_arr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

			modal.find('input[name=id]').val(id);

            $.ajax({
                type : "GET",
                url : "{{ url('api/recruitment/get-recruit') }}?id="+id,
                dataType : "JSON",
                success : function(res) {
                    modal.find('.request_code').html(res.request_code);

                    modal.find('select[name=title_id]').val(res.title_id).trigger('change');
                    modal.find('select[name=grade_id]').val(res.grade_id).trigger('change');
                    modal.find('input[name=sex][value="'+res.sex+'"]').prop('checked', true);
                    modal.find('input[name=minimum_age]').val(res.minimum_age);
                    modal.find('input[name=maximum_age]').val(res.maximum_age);
                    modal.find('select[name=reason_for_request]').val(res.reason_for_request).trigger('change');
                    modal.find('select[name=point_of_hire_id]').val(res.point_of_hire_id).trigger('change');
                    modal.find('input[name=employment_status][value="'+res.employment_status+'"]').prop('checked', true).trigger('change');
                    modal.find('input[name=contract_length]').val(res.contract_length);
                    modal.find('input[name=probation_length]').val(res.probation_length);
                    modal.find('input[name=internship_length]').val(res.internship_length);
                    modal.find('input[name=daily_worker_length]').val(res.daily_worker_length);
                    modal.find('input[name=daily_worker_person]').val(res.daily_worker_person);

                    var d = new Date(res.expected_join_date);
                    var date = d.getDate();
                    var month = d.getMonth();
                    var year = d.getFullYear();

                    modal.find('input[name=expected_join_date]').val(month_arr[month]+' '+date+', '+year);
                    modal.find('input[name=recruitment_status][value="'+res.recruitment_status+'"]').prop('checked', true);
                    modal.find('input[name=education][value="'+res.education+'"]').prop('checked', true).trigger('change');
                    modal.find('input[name=education_other]').val(res.education_other);
                    modal.find('textarea[name=general_competency]').val(res.general_competency);
                    modal.find('textarea[name=specific_competency]').val(res.specific_competency);
                    modal.find('textarea[name=job_description]').val(res.job_description);
                    modal.find('textarea[name=special_note]').val(res.special_note);
                    modal.find('input[name=basic_salary]').autoNumeric('set', res.basic_salary);
                    modal.find('input[name=allowances]').autoNumeric('set', res.allowances);
                    modal.find('textarea[name=organization_structure]').val(res.organization_structure);

                    if(res.organization_structure_attach) {
                        modal.find('.file-upload').css('display', 'none');
                        modal.find('.file-info').css('display', 'block');
                        modal.find('.btn-download').attr('href', '{!! asset("file_uploads/organization_structure/'+res.organization_structure_attach+'") !!}');
                        modal.find('input[name=organization_structure_attach]').val(res.organization_structure_attach);
                    } else {
                        modal.find('.file-upload').css('display', 'block');
                        modal.find('.file-info').css('display', 'none');
                        modal.find('input[name=organization_structure_attach]').val('');
                    }
                },
                error : function(jqXhr, errorThrown, textStatus) {
                    console.log(errorThrown);
                }
            });

            osa_edit.removeFile();

			modal.modal('show');
		});

		$(document).on('submit', '#editRecruit form', function(e) {
			e.preventDefault();

            $.ajax({
				url : "{{ url('/recruitment/recruit/update') }}",
                type : "POST",
                data : $('#editRecruit form').serialize(),
                success : function(res) {
                    table_proceed.draw(false);
                    table_unproceed.draw(false);
                    $('#editRecruit').modal('hide');

                    toastr.success('Recruit have been updated!', 'Success', { "closeButton": true });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    $('#editRecruit .form-group .form-control').removeClass('is-invalid');
                    $('#editRecruit .form-group .invalid-feedback').empty();

                    var err = jqXhr.responseJSON;
                    if($.isEmptyObject(err) == false) {
                        $.each(err.errors, function(key, val) {
                            $('#'+key+'_edit')
                                .closest('.form-control')
                                .addClass('is-invalid')
                                .closest('.form-group')
                                .find('.invalid-feedback')
                                .html(val)
                        });
                    }
                }
			});
		});

        $(document).on('click', '.btn-copy', function(e) {
            var modal = $('#copyRecruit');
            var id = e.currentTarget.dataset.id;

            var month_arr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            modal.find('input[name=id]').val(id);

            $.ajax({
                type : "GET",
                url : "{{ url('api/recruitment/get-recruit') }}?id="+id,
                dataType : "JSON",
                success : function(res) {
                    modal.find('.request_code').html(res.request_code);

                    modal.find('select[name=title_id]').val(res.title_id).trigger('change');
                    modal.find('select[name=grade_id]').val(res.grade_id).trigger('change');
                    modal.find('input[name=sex][value="'+res.sex+'"]').prop('checked', true);
                    modal.find('input[name=minimum_age]').val(res.minimum_age);
                    modal.find('input[name=maximum_age]').val(res.maximum_age);
                    modal.find('select[name=reason_for_request]').val(res.reason_for_request).trigger('change');
                    modal.find('select[name=point_of_hire_id]').val(res.point_of_hire_id).trigger('change');
                    modal.find('input[name=employment_status][value="'+res.employment_status+'"]').prop('checked', true).trigger('change');
                    modal.find('input[name=contract_length]').val(res.contract_length);
                    modal.find('input[name=probation_length]').val(res.probation_length);
                    modal.find('input[name=internship_length]').val(res.internship_length);
                    modal.find('input[name=daily_worker_length]').val(res.daily_worker_length);
                    modal.find('input[name=daily_worker_person]').val(res.daily_worker_person);

                    var d = new Date(res.expected_join_date);
                    var date = d.getDate();
                    var month = d.getMonth();
                    var year = d.getFullYear();

                    modal.find('input[name=expected_join_date]').val(month_arr[month]+' '+date+', '+year);
                    modal.find('input[name=recruitment_status][value="'+res.recruitment_status+'"]').prop('checked', true);
                    modal.find('input[name=education][value="'+res.education+'"]').prop('checked', true).trigger('change');
                    modal.find('input[name=education_other]').val(res.education_other);
                    modal.find('textarea[name=general_competency]').val(res.general_competency);
                    modal.find('textarea[name=specific_competency]').val(res.specific_competency);
                    modal.find('textarea[name=job_description]').val(res.job_description);
                    modal.find('textarea[name=special_note]').val(res.special_note);
                    modal.find('input[name=basic_salary]').autoNumeric('set', res.basic_salary);
                    modal.find('input[name=allowances]').autoNumeric('set', res.allowances);
                    modal.find('textarea[name=organization_structure]').val(res.organization_structure);
                },
                error : function(jqXhr, errorThrown, textStatus) {
                    console.log(errorThrown);
                }
            });

            modal.find('input[name=organization_structure_attach]').val('');

            osa_copy.removeFile();

            modal.modal('show');
        });

        $(document).on('submit', '#copyRecruit form', function(e) {
            e.preventDefault();

            $.ajax({
                url : "{{ url('/recruitment/recruit') }}",
                type : "POST",
                data : $('#copyRecruit form').serialize(),
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

                            table_proceed.draw(false);
                            table_unproceed.draw(false);
                            $('#copyRecruit').modal('hide');

                            toastr.success('Recruit have been copied!', 'Success', { "closeButton": true });
                        },
                        error : function(jqXhr, errorThrown, textStatus) {
                            console.log(errorThrown);
                        }
                    });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    $('#copyRecruit .form-group .form-control').removeClass('is-invalid');
                    $('#copyRecruit .form-group .invalid-feedback').empty();

                    var err = jqXhr.responseJSON;
                    if($.isEmptyObject(err) == false) {
                        $.each(err.errors, function(key, val) {
                            $('#'+key+'_copy')
                                .closest('.form-control')
                                .addClass('is-invalid')
                                .closest('.form-group')
                                .find('.invalid-feedback')
                                .html(val)
                        });
                    }
                }
            });
        });

        $(document).on('click', '.btn-view', function(e) {
            var modal = $('#viewRecruit');
            var id = e.currentTarget.dataset.id;

            var month_arr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            var approved = '<img src="{{ asset("images/approved.png") }}" style="width: 100%;">';
            var rejected = '<img src="{{ asset("images/rejected.png") }}" style="width: 100%;">';

            $.ajax({
                type : "GET",
                url : "{{ url('api/recruitment/get-recruit') }}?id="+id,
                dataType : "JSON",
                success : function(res) {
                    modal.find('.requested_by').html('['+res.user_nik+'] '+res.user_name);
                    modal.find('.requestor_pos').html(res.user_title);
                    modal.find('.department').html(res.department_name);

                    var d = new Date(res.request_date);
                    var date = d.getDate();
                    var month = d.getMonth();
                    var year = d.getFullYear();

                    modal.find('.request_date').html(month_arr[month]+' '+date+', '+year);
                    modal.find('.request_code').html(res.request_code);

                    if(res.recruit_status == 'PENDING') {
                        modal.find('.recruit_status').html('<span class="text-muted">PENDING</span>');
                    } else if(res.recruit_status == 'REJECTED') {
                        modal.find('.recruit_status').html('<span class="text-danger">REJECTED</span>');
                    } else if(res.recruit_status == 'CANCELED') {
                        modal.find('.recruit_status').html('<span class="text-warning">CANCELED</span>');
                    } else if(res.recruit_status == 'ON PROCESS') {
                        modal.find('.recruit_status').html('<span class="text-primary">ON PROCESS</span>');
                    } else if(res.recruit_status == 'FULFILLED') {
                        modal.find('.recruit_status').html('<span class="text-success">FULFILLED</span>');
                    }

                    modal.find('.title').html(res.title_name);
                    modal.find('.grade').html('['+res.grade_code+'] '+res.grade_name);
                    modal.find('.sex').html(res.sex);
                    modal.find('.age').html(res.minimum_age+' Minimum & '+res.maximum_age+' Maximum');
                    modal.find('.reason_for_request').html(res.reason_for_request);
                    modal.find('.point_of_hire').html(res.point_of_hire_name);
                    
                    if(res.employment_status == 'Permanent') {
                        modal.find('.employment_status').html('Permanent with '+res.probation_length+' months probation');
                    } else if(res.employment_status == 'Contract') {
                        modal.find('.employment_status').html('Contract for '+res.contract_length+' months');
                    } else if(res.employment_status == 'Internship') {
                        modal.find('.employment_status').html('Internship for '+res.internship_length+' months');
                    } else if(res.employment_status == 'Daily Worker') {
                        modal.find('.employment_status').html('Daily Worker for '+res.daily_worker_length+' days for '+res.daily_worker_person+' persons');
                    }

                    var d = new Date(res.expected_join_date);
                    var date = d.getDate();
                    var month = d.getMonth();
                    var year = d.getFullYear();

                    modal.find('.expected_join_date').html(month_arr[month]+' '+date+', '+year);
                    modal.find('.recruitment_status').html(res.recruitment_status);

                    if(res.education != 'Other') {
                        modal.find('.education').html(res.education);
                    } else {
                        modal.find('.education').html(res.education_other);
                    }

                    modal.find('.general_competency').html(res.general_competency);
                    modal.find('.specific_competency').html(res.specific_competency);
                    modal.find('.job_description').html(res.job_description);

                    if(res.special_note != null || res.special_note != '-') {
                        modal.find('.special_note').html(res.special_note);
                    } else {
                        modal.find('.special_note').html('-');
                    }
                    
                    modal.find('.basic_salary').autoNumeric('set', res.basic_salary);
                    modal.find('.allowances').autoNumeric('set', res.allowances);
                    modal.find('.organization_structure').html(res.organization_structure);

                    if(res.organization_structure_attach) {
                        modal.find('.organization_structure_attach').html('<a href="{!! asset("/file_uploads/organization_structure/'+res.organization_structure_attach+'") !!}" target="_blank" class="btn btn-primary btn-download"> Download <i class="fa fa-download"></i></a>')
                    } else {
                        modal.find('.organization_structure_attach').html('-');
                    }

                    modal.find('.position_proposed').html(res.user_title);
                    modal.find('.name_proposed').html(res.user_name);
                    modal.find('.nik_proposed').html(res.user_nik);
                    modal.find('.date_proposed').html(moment(res.request_date).format('DD MMM YYYY'));

                    if(res.recruit_approval_status_1 != null) {
                        modal.find('.position_approval_1').html(res.recruit_approval_title_1);
                        modal.find('.name_approval_1').html(res.recruit_approval_name_1);
                        modal.find('.nik_approval_1').html(res.recruit_approval_nik_1);
                        modal.find('.date_approval_1').html(moment(res.recruit_approval_date_1).format('DD MMM YYYY'));
                        if(res.recruit_approval_status_1 == '1') {
                            modal.find('.image_approval_1').html(approved);
                        } else if(res.recruit_approval_status_1 == '0') {
                            modal.find('.image_approval_1').html(rejected);
                        }
                    } else if(res.recruit_approval_nik_1 != null) {
                        modal.find('.position_approval_1').html('Waiting for Approval');
                        modal.find('.image_approval_1').html('');
                        modal.find('.name_approval_1').html(res.recruit_approval_name_1);
                        modal.find('.nik_approval_1').html(res.recruit_approval_nik_1);
                        modal.find('.date_approval_1').html('');
                    } else {
                        modal.find('.position_approval_1').html('');
                        modal.find('.image_approval_1').html('');
                        modal.find('.name_approval_1').html('');
                        modal.find('.nik_approval_1').html('');
                        modal.find('.date_approval_1').html('');
                    }

                    if(res.recruit_approval_status_2 != null) {
                        modal.find('.position_approval_2').html(res.recruit_approval_title_2);
                        modal.find('.name_approval_2').html(res.recruit_approval_name_2);
                        modal.find('.nik_approval_2').html(res.recruit_approval_nik_2);
                        modal.find('.date_approval_2').html(moment(res.recruit_approval_date_2).format('DD MMM YYYY'));
                        if(res.recruit_approval_status_2 == '1') {
                            modal.find('.image_approval_2').html(approved);
                        } else if(res.recruit_approval_status_2 == '0') {
                            modal.find('.image_approval_2').html(rejected);
                        }
                    } else if(res.recruit_approval_nik_2 != null) {
                        modal.find('.position_approval_2').html('Waiting for Approval');
                        modal.find('.image_approval_2').html('');
                        modal.find('.name_approval_2').html(res.recruit_approval_name_2);
                        modal.find('.nik_approval_2').html(res.recruit_approval_nik_2);
                        modal.find('.date_approval_2').html('');
                    } else {
                        modal.find('.position_approval_2').html('');
                        modal.find('.image_approval_2').html('');
                        modal.find('.name_approval_2').html('');
                        modal.find('.nik_approval_2').html('');
                        modal.find('.date_approval_2').html('');
                    }

                    if(res.recruit_approval_status_3 != null) {
                        modal.find('.position_approval_3').html(res.recruit_approval_title_3);
                        modal.find('.name_approval_3').html(res.recruit_approval_name_3);
                        modal.find('.nik_approval_3').html(res.recruit_approval_nik_3);
                        modal.find('.date_approval_3').html(moment(res.recruit_approval_date_3).format('DD MMM YYYY'));
                        if(res.recruit_approval_status_3 == '1') {
                            modal.find('.image_approval_3').html(approved);
                        } else if(res.recruit_approval_status_3 == '0') {
                            modal.find('.image_approval_3').html(rejected);
                        }
                    } else if(res.recruit_approval_nik_3 != null) {
                        modal.find('.position_approval_3').html('Waiting for Approval');
                        modal.find('.image_approval_3').html('');
                        modal.find('.name_approval_3').html(res.recruit_approval_name_3);
                        modal.find('.nik_approval_3').html(res.recruit_approval_nik_3);
                        modal.find('.date_approval_3').html('');
                    } else {
                        modal.find('.position_approval_3').html('');
                        modal.find('.image_approval_3').html('');
                        modal.find('.name_approval_3').html('');
                        modal.find('.nik_approval_3').html('');
                        modal.find('.date_approval_3').html('');
                    }

                    if(res.recruit_approval_status_4 != null) {
                        modal.find('.position_approval_4').html(res.recruit_approval_title_4);
                        modal.find('.name_approval_4').html(res.recruit_approval_name_4);
                        modal.find('.nik_approval_4').html(res.recruit_approval_nik_4);
                        modal.find('.date_approval_4').html(moment(res.recruit_approval_date_4).format('DD MMM YYYY'));
                        if(res.recruit_approval_status_4 == '1') {
                            modal.find('.image_approval_4').html(approved);
                        } else if(res.recruit_approval_status_4 == '0') {
                            modal.find('.image_approval_4').html(rejected);
                        }
                    } else if(res.recruit_approval_nik_4 != null) {
                        modal.find('.position_approval_4').html('Waiting for Approval');
                        modal.find('.image_approval_4').html('');
                        modal.find('.name_approval_4').html(res.recruit_approval_name_4);
                        modal.find('.nik_approval_4').html(res.recruit_approval_nik_4);
                        modal.find('.date_approval_4').html('');
                    } else {
                        modal.find('.position_approval_4').html('');
                        modal.find('.image_approval_4').html('');
                        modal.find('.name_approval_4').html('');
                        modal.find('.nik_approval_4').html('');
                        modal.find('.date_approval_4').html('');
                    }

                    if(res.recruit_approval_status_5 != null) {
                        modal.find('.position_approval_5').html(res.recruit_approval_title_5);
                        modal.find('.name_approval_5').html(res.recruit_approval_name_5);
                        modal.find('.nik_approval_5').html(res.recruit_approval_nik_5);
                        modal.find('.date_approval_5').html(moment(res.recruit_approval_date_5).format('DD MMM YYYY'));
                        if(res.recruit_approval_status_5 == '1') {
                            modal.find('.image_approval_5').html(approved);
                        } else if(res.recruit_approval_status_5 == '0') {
                            modal.find('.image_approval_5').html(rejected);
                        }
                    } else if(res.recruit_approval_nik_5 != null) {
                        modal.find('.position_approval_5').html('Waiting for Approval');
                        modal.find('.image_approval_5').html('');
                        modal.find('.name_approval_5').html(res.recruit_approval_name_5);
                        modal.find('.nik_approval_5').html(res.recruit_approval_nik_5);
                        modal.find('.date_approval_5').html('');
                    } else {
                        modal.find('.position_approval_5').html('');
                        modal.find('.image_approval_5').html('');
                        modal.find('.name_approval_5').html('');
                        modal.find('.nik_approval_5').html('');
                        modal.find('.date_approval_5').html('');
                    }

                    if(res.recruit_approval_status_6 != null) {
                        modal.find('.position_approval_6').html(res.recruit_approval_title_6);
                        modal.find('.name_approval_6').html(res.recruit_approval_name_6);
                        modal.find('.nik_approval_6').html(res.recruit_approval_nik_6);
                        modal.find('.date_approval_6').html(moment(res.recruit_approval_date_6).format('DD MMM YYYY'));
                        if(res.recruit_approval_status_6 == '1') {
                            modal.find('.image_approval_6').html(approved);
                        } else if(res.recruit_approval_status_6 == '0') {
                            modal.find('.image_approval_6').html(rejected);
                        }
                    } else if(res.recruit_approval_nik_6 != null) {
                        modal.find('.position_approval_6').html('Waiting for Approval');
                        modal.find('.image_approval_6').html('');
                        modal.find('.name_approval_6').html(res.recruit_approval_name_6);
                        modal.find('.nik_approval_6').html(res.recruit_approval_nik_6);
                        modal.find('.date_approval_6').html('');
                    } else {
                        modal.find('.position_approval_6').html('');
                        modal.find('.image_approval_6').html('');
                        modal.find('.name_approval_6').html('');
                        modal.find('.nik_approval_6').html('');
                        modal.find('.date_approval_6').html('');
                    }

                    if(res.recruit_approval_status_ceo != null) {
                        modal.find('.position_approval_ceo').html(res.recruit_approval_title_ceo);
                        modal.find('.name_approval_ceo').html(res.recruit_approval_name_ceo);
                        modal.find('.nik_approval_ceo').html(res.recruit_approval_nik_ceo);
                        modal.find('.date_approval_ceo').html(moment(res.recruit_approval_date_ceo).format('DD MMM YYYY'));
                        if(res.recruit_approval_status_ceo == '1') {
                            modal.find('.image_approval_ceo').html(approved);
                        } else if(res.recruit_approval_status_ceo == '0') {
                            modal.find('.image_approval_ceo').html(rejected);
                        }
                    } else {
                        modal.find('.position_approval_ceo').html('');
                        modal.find('.image_approval_ceo').html('Waiting for Approval');
                        modal.find('.name_approval_ceo').html(res.recruit_approval_name_ceo);
                        modal.find('.nik_approval_ceo').html('');
                        modal.find('.date_approval_ceo').html('');
                    }

                    if(res.recruit_approval_status_hr != null) {
                        modal.find('.position_approval_hr').html(res.recruit_approval_title_hr);
                        modal.find('.name_approval_hr').html(res.recruit_approval_name_hr);
                        modal.find('.nik_approval_hr').html(res.recruit_approval_nik_hr);
                        modal.find('.date_approval_hr').html(moment(res.recruit_approval_date_hr).format('DD MMM YYYY'));
                        if(res.recruit_approval_status_hr == '1') {
                            modal.find('.image_approval_hr').html(approved);
                        } else if(res.recruit_approval_status_hr == '0') {
                            modal.find('.image_approval_hr').html(rejected);
                        }
                    } else {
                        modal.find('.position_approval_hr').html('');
                        modal.find('.image_approval_hr').html('Waiting for Approval');
                        modal.find('.name_approval_hr').html(res.recruit_approval_name_hr);
                        modal.find('.nik_approval_hr').html('');
                        modal.find('.date_approval_hr').html('');
                    }

                    if(res.recruit_approval_note_1 != null) {
                        var note = '<label class="font-weight-bold">Note from '+res.recruit_approval_name_1+'</label>'+
                            '<p>'+res.recruit_approval_note_1+'</p>';

                        modal.find('.approval_note_1').html(note);
                    } else {
                        modal.find('.approval_note_1').html('');
                    }

                    if(res.recruit_approval_note_2 != null) {
                        var note = '<label class="font-weight-bold">Note from '+res.recruit_approval_name_2+'</label>'+
                            '<p>'+res.recruit_approval_note_2+'</p>';

                        modal.find('.approval_note_2').html(note);
                    } else {
                        modal.find('.approval_note_2').html('');
                    }

                    if(res.recruit_approval_note_3 != null) {
                        var note = '<label class="font-weight-bold">Note from '+res.recruit_approval_name_3+'</label>'+
                            '<p>'+res.recruit_approval_note_3+'</p>';

                        modal.find('.approval_note_3').html(note);
                    } else {
                        modal.find('.approval_note_3').html('');
                    }

                    if(res.recruit_approval_note_4 != null) {
                        var note = '<label class="font-weight-bold">Note from '+res.recruit_approval_name_4+'</label>'+
                            '<p>'+res.recruit_approval_note_4+'</p>';

                        modal.find('.approval_note_4').html(note);
                    } else {
                        modal.find('.approval_note_4').html('');
                    }

                    if(res.recruit_approval_note_5 != null) {
                        var note = '<label class="font-weight-bold">Note from '+res.recruit_approval_name_5+'</label>'+
                            '<p>'+res.recruit_approval_note_5+'</p>';

                        modal.find('.approval_note_5').html(note);
                    } else {
                        modal.find('.approval_note_5').html('');
                    }

                    if(res.recruit_approval_note_6 != null) {
                        var note = '<label class="font-weight-bold">Note from '+res.recruit_approval_name_6+'</label>'+
                            '<p>'+res.recruit_approval_note_6+'</p>';

                        modal.find('.approval_note_6').html(note);
                    } else {
                        modal.find('.approval_note_6').html('');
                    }

                    if(res.recruit_approval_note_ceo != null) {
                        var note = '<label class="font-weight-bold">Note from '+res.recruit_approval_name_ceo+'</label>'+
                            '<p>'+res.recruit_approval_note_ceo+'</p>';

                        modal.find('.approval_note_ceo').html(note);
                    } else {
                        modal.find('.approval_note_ceo').html('');
                    }

                    if(res.recruit_approval_note_hr != null) {
                        var note = '<label class="font-weight-bold">Note from '+res.recruit_approval_name_hr+'</label>'+
                            '<p>'+res.recruit_approval_note_hr+'</p>';

                        modal.find('.approval_note_hr').html(note);
                    } else {
                        modal.find('.approval_note_hr').html('');
                    }
                },
                error : function(jqXhr, errorThrown, textStatus) {
                    console.log(errorThrown);
                }
            });

            modal.modal('show');
        });

        $(document).on('click', '.btn-process', function(e) {
            var modal = $('#processRecruit');
            var id = e.currentTarget.dataset.id;

            modal.find('input[name=id]').val(id);
            modal.find('select[name=hiring_resource]').val(0).trigger('change');
            modal.find('input[name=cost_hire]').val('');

            var month_arr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            $.ajax({
                type : "GET",
                url : "{{ url('api/recruitment/get-recruit') }}?id="+id,
                dataType : "JSON",
                success : function(res) {
                    modal.find('.requested_by').html('['+res.user_nik+'] '+res.user_name);
                    modal.find('.requestor_pos').html(res.user_title);
                    modal.find('.department').html(res.department_name);

                    var d = new Date(res.request_date);
                    var date = d.getDate();
                    var month = d.getMonth();
                    var year = d.getFullYear();

                    modal.find('.request_date').html(month_arr[month]+' '+date+', '+year);
                    modal.find('.request_code').html(res.request_code);

                    var d = new Date(res.lead_time_start);
                    var date = d.getDate();
                    var month = d.getMonth();
                    var year = d.getFullYear();

                    modal.find('.reviewed_date').html(month_arr[month]+' '+date+', '+year);

                    modal.find('.title').html(res.title_name);
                    modal.find('.grade').html('['+res.grade_code+'] '+res.grade_name);
                    modal.find('.sex').html(res.sex);
                    modal.find('.age').html(res.minimum_age+' Minimum & '+res.maximum_age+' Maximum');
                    modal.find('.reason_for_request').html(res.reason_for_request);
                    modal.find('.point_of_hire').html(res.point_of_hire_name);
                },
                error : function(jqXhr, errorThrown, textStatus) {
                    console.log(errorThrown);
                }
            });

            modal.modal('show');
        });

        $(document).on('submit', '#processRecruit form', function(e) {
            e.preventDefault();

            $.ajax({
                url : "{{ url('/recruitment/process') }}",
                type : "POST",
                data : $('#processRecruit form').serialize(),
                success : function(res) {
                    table_proceed.draw(false);
                    $('#processRecruit').modal('hide');

                    toastr.success('Recruit have been fulfilled!', 'Success', { "closeButton": true });
                },
                error : function(jqXhr, textStatus, errorThrown) {
                    $('#processRecruit .form-group .form-control').removeClass('is-invalid');
                    $('#processRecruit .form-group .invalid-feedback').empty();

                    var err = jqXhr.responseJSON;
                    if($.isEmptyObject(err) == false) {
                        $.each(err.errors, function(key, val) {
                            $('#'+key)
                                .closest('.form-control')
                                .addClass('is-invalid')
                                .closest('.form-group')
                                .find('.invalid-feedback')
                                .html(val)
                        });
                    }
                }
            });
        });

        $(document).on('click', '#editRecruit .file-info .btn-delete', function(e) {
            $(this).parents('.file-info').css('display', 'none');
            $(this).parents('.form-group').find('.file-upload').css('display', 'block');
            $(this).parents('.form-group').find('.filename').val('');
        });

        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginFileValidateSize);

        const osa_edit = FilePond.create(document.querySelector('.filepond-edit'));

        osa_edit.setOptions({
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
                            
                            $('#editRecruit input[name=organization_structure_attach]').val(request.response.substring(39, request.response.length-1));

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

        const osa_copy = FilePond.create(document.querySelector('.filepond-copy'));

        osa_copy.setOptions({
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
                            
                            $('#copyRecruit input[name=organization_structure_attach]').val(request.response.substring(39, request.response.length-1));

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