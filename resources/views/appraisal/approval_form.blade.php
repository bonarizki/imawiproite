@extends('layouts.appraisal')

@section('assets-top')
<style type="text/css">
    .nav-pills .nav-link {
        padding: 20px;
        margin-right: 10px;
        border-radius: 5px;
        background-color: rgba(32,107,196,.06);
    }
    .nav-pills .nav-link.active, .nav-pills .nav-link:hover {
        background-color: rgba(32,107,196,.77);
        color: #FFFFFF;
    }
    .nav-pills .nav-link .numbering {
        display: flex;
        font-size: 15px;
        border: 1px solid #757575;
        border-radius: 50%;
        justify-content: center;
        align-items: center;
        width: 25px;
        height: 25px;
        margin-right: 10px;
    }
    .nav-pills .nav-link:hover .numbering, .nav-pills .nav-link.active .numbering {
        border: 1px solid #FFFFFF;
    }
    .table thead th, .table tbody td {
        vertical-align: middle;
    }
    .form-check {
        margin: 0;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    .form-check.checked {
        background-color: #648fc547;
    }
    .form-check-input~.form-check-label, .form-check-input~.form-check-label {
        cursor: pointer;
    }
    .form-check-input:disabled~.form-check-label, .form-check-input[disabled]~.form-check-label {
        opacity: 1;
        cursor: default;
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
                <h2 class="page-title">Appraisal Approval Form</h2>
            </div>
            <div class="col-auto ml-auto d-print-none">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item">Appraisal Approval</li>
                        <li class="breadcrumb-item active">Approval Form</li>
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
            <div class="card">
                <div class="row pt-3 pl-3 pr-3" style="width: 100%;">
                    <div class="col-md-10 col-sm-12">
                        <div class="row pt-1 pl-3">
                            <div class="col-md-2">Employee</div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-9">{{ $appraisal->user_name }}</div>
                        </div>
                        <div class="row pt-1 pl-3">
                            <div class="col-md-2">Department</div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-9">{{ $appraisal->department_name }}</div>
                        </div>
                        <div class="row pt-1 pl-3">
                            <div class="col-md-2">Level</div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-9">{{ $appraisal->grade_group_name }}</div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 text-right">
                        <input type="checkbox" id="language" value="1" data-bootstrap-switch>
                        <input type="hidden" name="language" value="eng">
                    </div>
                </div>
                <ul class="nav nav-tabs pt-3 pl-3 pr-3" data-toggle="tabs">
                    <li class="nav-item">
                        <a href="#milestone" class="nav-link active" data-toggle="tab" data-eng="Personal Milestone and Assessment" data-bhs="Penilaian Milestone Pribadi">Personal Milestone and Assessment</a>
                    </li>
                    <li class="nav-item">
                        <a href="#competencies" class="nav-link" data-toggle="tab" data-eng="Competencies" data-bhs="Kompetensi">Competencies</a>
                    </li>
                    <li class="nav-item">
                        <a href="#personal_development" class="nav-link" data-toggle="tab" data-eng="Personal Development" data-bhs="Pengembangan Diri">Personal Development</a>
                    </li>
                    <li class="nav-item">
                        <a href="#milestone_next" class="nav-link" data-toggle="tab" data-eng="Milestone for Next Year" data-bhs="Milestone Tahun Depan">Milestone for Next Year</a>
                    </li>
                    <li class="nav-item">
                        <a href="#performance_review" class="nav-link" data-toggle="tab" data-eng="Performance Review" data-bhs="Ulasan Kinerja">Performance Review</a>
                    </li>
                </ul>
                <div class="card-body">
                    <form class="p-2" method="post" id="approvalForm">
                        {{ csrf_field() }}
                        <input type="hidden" name="appraisal_id" value="{{ $appraisal->appraisal_id }}">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="milestone">
                                <h5 class="mt-1" data-eng="Your Milestones must be set and agreed with your superior and each milestone shall consist the following elements :" data-bhs="Milestone Anda harus ditetapkan dan disetujui oleh atasan Anda dan setiap milestone harus terdiri dari elemen-elemen berikut :">Your Milestones must be set and agreed with your superior and each milestone shall consist the following elements :</h5>
                                <div class="row m-0">
                                    <small style="flex: 0 0 auto; width: 3%;">I.</small>
                                    <small style="flex: 0 0 auto; width: 90%;" data-eng="How does the milestone links to your department/business strategies." data-bhs="Bagaimana milestone terhubung ke departemen / strategi bisnis Anda.">How does the milestone links to your department/business strategies.</small>
                                </div>
                                <div class="row m-0">
                                    <small style="flex: 0 0 auto; width: 3%;">II.</small>
                                    <small style="flex: 0 0 auto; width: 90%;" data-eng="Each milestone must be SMART (Specific, Measurement, Actionable, Reasonable, Time bounded), you must specify the Quantitative Measurement (e.g. financial results) and the Timeline for each milestone." data-bhs="Setiap Milestone harus SMART (Specific, Measurement, Actionable, Reasonable, Time bounded), Anda harus menentukan Pengukuran Kuantitatif (misalnya hasil keuangan) dan Timeline untuk setiap milestone.">Each milestone must be SMART (Specific, Measurement, Actionable, Reasonable, Time bounded), you must specify the Quantitative Measurement (e.g. financial results) and the Timeline for each milestone.</small>
                                </div>
                                <div class="nav nav-pills d-flex mt-3" data-toggle="tabs" role="tablist" aria-orientation="horizontal">
                                    @if(count($milestone) > 0)
                                        <?php $count = 0; ?>
                                        @foreach($milestone as $key => $mlst)
                                            @if($key > 0 && $mlst['milestone_id'] == $milestone[($key-1)]['milestone_id'])
                                            @else
                                                <?php $count++; ?>
                                                <a href="#{{ str_replace(' ', '_', strtolower($mlst->milestone_eng)) }}" class="nav-link{{ $key == 0 ? ' active' : '' }}" id="{{ str_replace(' ', '_', strtolower($mlst->milestone_eng)) }}-pill" data-toggle="pill" role="tab" aria-controls="{{ str_replace(' ', '_', strtolower($mlst->milestone_eng)) }}" aria-selected="{{ $key == 0 ? 'true' : 'false' }}">
                                                    <span class="numbering">{{ $count }}</span> <span class="milestone-name" data-eng="{{ $mlst->milestone_eng }}" data-bhs="{{ $mlst->milestone_bhs }}">{{ $mlst->milestone_eng }}</span>
                                                </a>
                                            @endif
                                        @endforeach
                                        <a href="#milestone_feedback" class="nav-link" id="milestone_feedback-pill" data-toggle="pill" role="tab" aria-controls="milestone_feedback" aria-selected="false">
                                            <span class="numbering">{{ $count+1 }}</span>
                                            <span class="milestone-name" data-eng="Summary" data-bhs="Kesimpulan">Summary</span>
                                        </a>
                                    @endif
                                </div>
                                <div class="tab-content mt-2">
                                    @if(count($milestone) > 0)
                                        @foreach($milestone as $key => $mlst)
                                            @if($key > 0 && $mlst['milestone_id'] == $milestone[($key-1)]['milestone_id'])
                                                <div class="row mt-2">
                                                    <input type="hidden" name="milestone_detail_id[{{ $mlst->milestone_id }}][]" value="{{ $mlst->appraisal_milestone_detail_id }}">
                                                    <div style="flex: 0 0 auto; width: 20%;">
                                                        <textarea name="milestone_description[{{ $mlst->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type milestone description.." data-pl_bhs="Isi deskripsi milestone.." placeholder="Type milestone description.." readonly>{{ $mlst->milestone_description }}</textarea>
                                                    </div>
                                                    <div style="flex: 0 0 auto; width: 20%;">
                                                        <textarea name="milestone_measurement[{{ $mlst->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type milestone measurement.." data-pl_bhs="Isi pencapaian milestone.." placeholder="Type milestone measurement.." readonly>{{ $mlst->milestone_measurement }}</textarea>
                                                    </div>
                                                    <div style="flex: 0 0 auto; width: 20%;">
                                                        <textarea name="employee_assessment[{{ $mlst->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type employee's assessment.." data-pl_bhs="Isi penilaian karyawan.." placeholder="Type employee's assessment.." readonly>{{ $mlst->employee_assessment }}</textarea>
                                                    </div>
                                                    <div class="form-group mb-0" style="flex: 0 0 auto; width: 20%;">
                                                        <textarea name="superior_assessment[{{ $mlst->milestone_id }}][]" class="form-control superior_assessment" rows="5" data-mlst="{{ str_replace(' ', '_', strtolower($mlst->milestone_eng)) }}" data-pl_eng="Type superior's assessment.." data-pl_bhs="Isi penilaian atasan.." placeholder="Type superior's assessment..">{{ $mlst->superior_assessment }}</textarea>
                                                        <small class="text-danger"></small>
                                                    </div>
                                                    <div class="form-group mb-0" style="flex: 0 0 auto; width: 20%;">
                                                        <!-- <input type="text" name="superior_score[{{ $mlst->milestone_id }}][]" class="form-control superior_score" data-mlst_id="{{ $mlst->milestone_id }}" data-mlst="{{ str_replace(' ', '_', strtolower($mlst->milestone_eng)) }}" data-pl_eng="Type Rating" data-pl_bhs="Isi Nilai" placeholder="Type Rating" style="width: 100%;" value="{{ $mlst->superior_score }}"> -->
                                                        <select name="superior_score[{{ $mlst->milestone_id }}][]" class="form-control select2-hide-search superior_score" data-mlst_id="{{ $mlst->milestone_id }}" data-mlst="{{ str_replace(' ', '_', strtolower($mlst->milestone_eng)) }}" data-pl_eng="Select A Rating" data-pl_bhs="Pilih Nilai" data-placeholder="Select A Rating" style="width: 100%;">
                                                            <option></option>
                                                            <option value="1"{{ $mlst->superior_score == '1' ? ' selected' : '' }}>(1) Outstanding / Outperform</option>
                                                            <option value="1.5"{{ $mlst->superior_score == '1.5' ? ' selected' : '' }}>(1.5)</option>
                                                            <option value="2"{{ $mlst->superior_score == '2' ? ' selected' : '' }}>(2) Exceed Expectation</option>
                                                            <option value="2.5"{{ $mlst->superior_score == '2.5' ? ' selected' : '' }}>(2.5)</option>
                                                            <option value="3"{{ $mlst->superior_score == '3' ? ' selected' : '' }}>(3) Meet Expectation</option>
                                                            <option value="3.5"{{ $mlst->superior_score == '3.5' ? ' selected' : '' }}>(3.5)</option>
                                                            <option value="4"{{ $mlst->superior_score == '4' ? ' selected' : '' }}>(4) Below Expectation</option>
                                                            <option value="4.5"{{ $mlst->superior_score == '4.5' ? ' selected' : '' }}>(4.5)</option>
                                                            <option value="5"{{ $mlst->superior_score == '5' ? ' selected' : '' }}>(5) Did not Meet Expectation</option>
                                                        </select>
                                                        <small class="text-danger"></small>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="tab-pane fade{{ $key == 0 ? ' show active' : '' }}" id="{{ str_replace(' ', '_', strtolower($mlst->milestone_eng)) }}" role="tabpanel" aria-labelledby="{{ str_replace(' ', '_', strtolower($mlst->milestone_eng)) }}-pill">
                                                    <input type="hidden" name="milestone_id[]" value="{{ $mlst->milestone_id }}">
                                                    <h5 class="mt-3" data-eng="Guide to Milestone Rating" data-bhs="Petunjuk Penilaian Milestone">Guide to Milestone Rating</h5>
                                                    <table class="table table-bordered mb-2">
                                                        <tbody>
                                                            <tr>
                                                                <td style="width: 20%;"><small class="text-muted" data-eng="1 - Outstanding / Outperform" data-bhs="1 - Performance kerja/ kompetensi yang luar biasa dan menjadi role model bagi karyawan lain">1 - Outstanding / Outperform</small></td>
                                                                <td style="width: 20%;"><small class="text-muted" data-eng="2 - Exceed Expectation" data-bhs="2 - Performance kerja/ kompetensi yang sangat baik, melebihi dari yang diharapkan perusahaan">2 - Exceed Expectation</small></td>
                                                                <td style="width: 20%;"><small class="text-muted" data-eng="3 - Meet Expectation" data-bhs="3 - Performance kerja/ kompetensi yang baik, memenuhi standard pekerjaan yang diharapkan perusahaan">3 - Meet Expectation</small></td>
                                                                <td style="width: 20%;"><small class="text-muted" data-eng="4 - Below Expectation" data-bhs="4 - Performance kerja/ kompetensi kurang baik, dibawah standard dari yang diharapkan, namun masih dapat diperbaiki">4 - Below Expectation</small></td>
                                                                <td style="width: 20%;"><small class="text-muted" data-eng="5 - Did not Meet Expectation" data-bhs="5 - Performance kerja/ kompetensi yang tidak memuaskan">5 - Did not Meet Expectation</small></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="row mt-2">
                                                        <input type="hidden" name="milestone_detail_id[{{ $mlst->milestone_id }}][]" value="{{ $mlst->appraisal_milestone_detail_id }}">
                                                        <div style="flex: 0 0 auto; width: 20%;">
                                                            <label class="form-label col-form-label" data-eng="Milestone Description" data-bhs="Deskripsi Milestone">Milestone Description</label>
                                                            <textarea name="milestone_description[{{ $mlst->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type milestone description.." data-pl_bhs="Isi deskripsi milestone.." placeholder="Type milestone description.." readonly>{{ $mlst->milestone_description }}</textarea>
                                                        </div>
                                                        <div style="flex: 0 0 auto; width: 20%;">
                                                            <label class="form-label col-form-label" data-eng="Milestone Measurement" data-bhs="Pencapaian Milestone">Milestone Measurement</label>
                                                            <textarea name="milestone_measurement[{{ $mlst->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type milestone measurement.." data-pl_bhs="Isi pencapaian milestone.." placeholder="Type milestone measurement.." readonly>{{ $mlst->milestone_measurement }}</textarea>
                                                        </div>
                                                        <div style="flex: 0 0 auto; width: 20%;">
                                                            <label class="form-label col-form-label" data-eng="Employee's Assessment" data-bhs="Penilaian Karyawan">Employee's Assessment</label>
                                                            <textarea name="employee_assessment[{{ $mlst->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type employee's assessment.." data-pl_bhs="Isi penilaian karyawan.." placeholder="Type employee's assessment.." readonly>{{ $mlst->employee_assessment }}</textarea>
                                                        </div>
                                                        <div class="form-group mb-0" style="flex: 0 0 auto; width: 20%;">
                                                            <label class="form-label col-form-label" data-eng="Superior's Assessment" data-bhs="Penilaian Atasan">Superior's Assessment</label>
                                                            <textarea name="superior_assessment[{{ $mlst->milestone_id }}][]" class="form-control superior_assessment" rows="5" data-mlst="{{ str_replace(' ', '_', strtolower($mlst->milestone_eng)) }}" data-pl_eng="Type superior's assessment.." data-pl_bhs="Isi penilaian atasan.." placeholder="Type superior's assessment..">{{ $mlst->superior_assessment }}</textarea>
                                                            <small class="text-danger"></small>
                                                        </div>
                                                        <div class="form-group pt-2" style="flex: 0 0 auto; width: 20%;">
                                                            <label class="form-label" data-eng="Superior's Score" data-bhs="Nilai dari Atasan">Superior's Score</label>
                                                            <!-- <small class="d-inline text-danger" style="font-weight: bold; font-style: italic;">(decimal point allowed)</small> -->
                                                            <!-- <input type="text" name="superior_score[{{ $mlst->milestone_id }}][]" class="form-control mt-2 superior_score" data-mlst_id="{{ $mlst->milestone_id }}" data-mlst="{{ str_replace(' ', '_', strtolower($mlst->milestone_eng)) }}" data-pl_eng="Type Rating" data-pl_bhs="Isi Nilai" placeholder="Type Rating" style="width: 100%;" value="{{ $mlst->superior_score }}"> -->
                                                            <select name="superior_score[{{ $mlst->milestone_id }}][]" class="form-control select2-hide-search superior_score" data-mlst_id="{{ $mlst->milestone_id }}" data-mlst="{{ str_replace(' ', '_', strtolower($mlst->milestone_eng)) }}" data-pl_eng="Select A Rating" data-pl_bhs="Pilih Nilai" data-placeholder="Select A Rating" style="width: 100%;">
                                                                <option></option>
                                                                <option value="1"{{ $mlst->superior_score == '1' ? ' selected' : '' }}>(1) Outstanding / Outperform</option>
                                                                <option value="1.5"{{ $mlst->superior_score == '1.5' ? ' selected' : '' }}>(1.5)</option>
                                                                <option value="2"{{ $mlst->superior_score == '2' ? ' selected' : '' }}>(2) Exceed Expectation</option>
                                                                <option value="2.5"{{ $mlst->superior_score == '2.5' ? ' selected' : '' }}>(2.5)</option>
                                                                <option value="3"{{ $mlst->superior_score == '3' ? ' selected' : '' }}>(3) Meet Expectation</option>
                                                                <option value="3.5"{{ $mlst->superior_score == '3.5' ? ' selected' : '' }}>(3.5)</option>
                                                                <option value="4"{{ $mlst->superior_score == '4' ? ' selected' : '' }}>(4) Below Expectation</option>
                                                                <option value="4.5"{{ $mlst->superior_score == '4.5' ? ' selected' : '' }}>(4.5)</option>
                                                                <option value="5"{{ $mlst->superior_score == '5' ? ' selected' : '' }}>(5) Did not Meet Expectation</option>
                                                            </select>
                                                            <small class="text-danger"></small>
                                                        </div>
                                                    </div>
                                                @endif
                                            @if($key < (count($milestone)-1) && $mlst['milestone_id'] != $milestone[($key+1)]['milestone_id'])
                                                    <div class="row mt-3">
                                                        <div style="flex: 0 0 auto; width: 80%;">
                                                            <label class="form-label col-form-label text-right">Total Score</label>
                                                        </div>
                                                        <div style="flex: 0 0 auto; width: 20%;">
                                                            <input type="text" name="overall_score[{{ $mlst->milestone_id }}]" class="form-control overall_score" data-mlst="{{ $mlst->milestone_id }}" value="{{ $mlst->overall_score }}" readonly>
                                                        </div>
                                                    </div>

                                                    <!-- DRAFT BUTTON AND NEXT BUTTON -->
                                                    <div class="w-100 d-flex mt-5">
                                                        <button type="button" class="btn btn-primary btn-draft pt-3 pb-3" data-eng="Save as Draft" data-bhs="Simpan sebagai Draft" style="width: 175px;">Save as Draft</button>
                                                        <button type="button" class="btn btn-danger btn-reject ml-auto pt-3 pb-3" style="width: 175px;">Reject</button>
                                                        <button type="button" class="btn btn-info btn-next ml-3 pt-3 pb-3" data-target="{{ str_replace(' ', '_', strtolower($milestone[$key+1]->milestone_eng)) }}" style="width: 175px;">Next</button>
                                                    </div>
                                                </div>
                                            @elseif($key == (count($milestone)-1))
                                                    <div class="row mt-3">
                                                        <div style="flex: 0 0 auto; width: 80%;">
                                                            <label class="form-label col-form-label text-right">Total Score</label>
                                                        </div>
                                                        <div style="flex: 0 0 auto; width: 20%;">
                                                            <input type="text" name="overall_score[{{ $mlst->milestone_id }}]" class="form-control overall_score" data-mlst="{{ $mlst->milestone_id }}" value="{{ $mlst->overall_score }}" readonly>
                                                        </div>
                                                    </div>

                                                    <!-- DRAFT BUTTON AND NEXT BUTTON -->
                                                    <div class="w-100 d-flex mt-5">
                                                        <button type="button" class="btn btn-primary btn-draft pt-3 pb-3" data-eng="Save as Draft" data-bhs="Simpan sebagai Draft" style="width: 175px;">Save as Draft</button>
                                                        <button type="button" class="btn btn-danger btn-reject ml-auto pt-3 pb-3" style="width: 175px;">Reject</button>
                                                        <button type="button" class="btn btn-info btn-next ml-3 pt-3 pb-3" data-target="milestone_feedback" style="width: 175px;">Next</button>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        <div class="tab-pane fade" id="milestone_feedback" role="tabpanel" aria-labelledby="milestone_feedback-pill">
                                            <h5 class="mt-3" data-eng="Guide to Milestone Rating" data-bhs="Petunjuk Penilaian Milestone">Guide to Milestone Rating</h5>
                                            <table class="table table-bordered mb-2">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 20%;"><small class="text-muted" data-eng="1 - Outstanding / Outperform" data-bhs="1 - Performance kerja/ kompetensi yang luar biasa dan menjadi role model bagi karyawan lain">1 - Outstanding / Outperform</small></td>
                                                        <td style="width: 20%;"><small class="text-muted" data-eng="2 - Exceed Expectation" data-bhs="2 - Performance kerja/ kompetensi yang sangat baik, melebihi dari yang diharapkan perusahaan">2 - Exceed Expectation</small></td>
                                                        <td style="width: 20%;"><small class="text-muted" data-eng="3 - Meet Expectation" data-bhs="3 - Performance kerja/ kompetensi yang baik, memenuhi standard pekerjaan yang diharapkan perusahaan">3 - Meet Expectation</small></td>
                                                        <td style="width: 20%;"><small class="text-muted" data-eng="4 - Below Expectation" data-bhs="4 - Performance kerja/ kompetensi kurang baik, dibawah standard dari yang diharapkan, namun masih dapat diperbaiki">4 - Below Expectation</small></td>
                                                        <td style="width: 20%;"><small class="text-muted" data-eng="5 - Did not Meet Expectation" data-bhs="5 - Performance kerja/ kompetensi yang tidak memuaskan">5 - Did not Meet Expectation</small></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="row mt-3">
                                                <div style="flex: 0 0 auto; width: 80%;">
                                                    <label class="form-label d-inline" data-eng="Achievement Beyond Milestone" data-bhs="Pencapaian Diluar Milestone">Achievement Beyond Milestone</label>
                                                    <small class="d-inline text-muted">(optional)</small>
                                                    <textarea name="beyond_milestone" class="form-control mt-2" rows="5" data-pl_eng="Type achievement beyond milestone.." data-pl_bhs="Isi pencapaian diluar milestone.." placeholder="Type achievement beyond milestone..">{{ $appraisal->beyond_milestone }}</textarea>
                                                </div>
                                                <div style="flex: 0 0 auto; width: 20%;">
                                                    <label class="form-label d-inline" data-eng="Superior's Score" data-bhs="Nilai dari Atasan">Superior's Score</label>
                                                    <small class="d-inline text-muted">(optional)</small>
                                                    <div class="form-group mt-2">
                                                        <!-- <input type="text" name="beyond_milestone_score" class="form-control superior_score" data-pl_eng="Type Rating" data-pl_bhs="Isi Nilai" placeholder="Type Rating" style="width: 100%;" value="{{ $appraisal->beyond_milestone_score }}"> -->
                                                        <!-- <small class="text-danger"></small> -->
                                                        <select name="beyond_milestone_score" class="form-control select2-hide-search superior_score" data-pl_eng="Select A Rating" data-pl_bhs="Pilih Nilai" data-placeholder="Select A Rating" style="width: 100%;">
                                                            <option></option>
                                                            <option value="1"{{ $appraisal->beyond_milestone_score == '1' ? ' selected' : '' }}>(1) Outstanding / Outperform</option>
                                                            <option value="1.5"{{ $appraisal->beyond_milestone_score == '1.5' ? ' selected' : '' }}>(1.5)</option>
                                                            <option value="2"{{ $appraisal->beyond_milestone_score == '2' ? ' selected' : '' }}>(2) Exceed Expectation</option>
                                                            <option value="2.5"{{ $appraisal->beyond_milestone_score == '2.5' ? ' selected' : '' }}>(2.5)</option>
                                                            <option value="3"{{ $appraisal->beyond_milestone_score == '3' ? ' selected' : '' }}>(3) Meet Expectation</option>
                                                            <option value="3.5"{{ $appraisal->beyond_milestone_score == '3.5' ? ' selected' : '' }}>(3.5)</option>
                                                            <option value="4"{{ $appraisal->beyond_milestone_score == '4' ? ' selected' : '' }}>(4) Below Expectation</option>
                                                            <option value="4.5"{{ $appraisal->beyond_milestone_score == '4.5' ? ' selected' : '' }}>(4.5)</option>
                                                            <option value="5"{{ $appraisal->beyond_milestone_score == '5' ? ' selected' : '' }}>(5) Did not Meet Expectation</option>
                                                        </select>
                                                        <a href="javascript:;" class="btn-clear-rating" style="float: right;">
                                                            <small>Clear Rating</small>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-3">
                                                <label class="form-label col-form-label" data-eng="Overall Feedback on Employee's Milestone" data-bhs="Feedback Keseluruhan terhadap Milestone ">Overall Feedback on Employee's Milestone</label>
                                                <textarea name="milestone_feedback" class="form-control" rows="7" data-pl_eng="Type overall feedback on employee's milestone.." data-pl_bhs="Isi feedback keseluruhan terhadap milestone.." placeholder="Type overall feedback on employee's milestone.." style="width: 80%;">{{ $appraisal->milestone_feedback }}</textarea>
                                                <small class="text-danger"></small>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-3 form-label col-form-label" data-eng="OVERALL MILESTONE RATING" data-bhs="NILAI MILESTONE KESELURUHAN">OVERALL MILESTONE RATING</label>
                                                <div class="col-md-2">
                                                    <input type="text" name="overall_milestone_score" class="form-control font-weight-bold" value="{{ $appraisal->overall_milestone_score }}" readonly>
                                                </div>
                                            </div>

                                            <!-- DRAFT BUTTON AND NEXT BUTTON -->
                                            <div class="w-100 d-flex mt-5">
                                                <button type="button" class="btn btn-primary btn-draft pt-3 pb-3" data-eng="Save as Draft" data-bhs="Simpan sebagai Draft" style="width: 175px;">Save as Draft</button>
                                                <button type="button" class="btn btn-danger btn-reject ml-auto pt-3 pb-3" style="width: 175px;">Reject</button>
                                                <button type="button" class="btn btn-info btn-next ml-3 pt-3 pb-3" data-target="competencies" style="width: 175px;">Next</button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade" id="competencies">
                                <h5 class="font-weight-bold mb-1" data-eng="Guide to Competencies Review :" data-bhs="Petunjuk Penilaian Kompetensi :">Guide to Competencies Review :</h5>
                                <div class="row m-0">
                                    <small style="flex: 0 0 auto; width: 3%;">I.</small>
                                    <small style="flex: 0 0 auto; width: 90%;" data-eng="Self Assessment of competency is filled with reference to the 4 levels of proficiency in the options provided." data-bhs="Penilaian kompetensi oleh diri sendiri diisi dengan mengacu pada 4 level kemahiran pada pilihan yang telah disediakan.">Self Assessment of competency is filled with reference to the 4 levels of proficiency in the options provided.</small>
                                </div>
                                <div class="row m-0">
                                    <small style="flex: 0 0 auto; width: 3%;">II.</small>
                                    <small style="flex: 0 0 auto; width: 90%;" data-eng="Proficiency levels are arranged by category Basic (first choice) and Expert (last choice)." data-bhs="Level kemahiran disusun berdasarkan kategori Basic (pilihan pertama) dan Expert (pilihan terakhir).">Proficiency levels are arranged by category Basic (first choice) and Expert (last choice).</small>
                                </div>
                                <div class="row m-0">
                                    <small style="flex: 0 0 auto; width: 3%;">III.</small>
                                    <small style="flex: 0 0 auto; width: 90%;" data-eng="Assessment is done by looking at the suitability of your abilities/skills in completing the work." data-bhs="Penilaian dilakukan dengan melihat kesesuaian kemampuan/keahlian Anda dalam menyelesaikan pekerjaan.">Assessment is done by looking at the suitability of your abilities/skills in completing the work.</small>
                                </div>
                                <div class="row m-0">
                                    <small style="flex: 0 0 auto; width: 3%;">IV.</small>
                                    <small style="flex: 0 0 auto; width: 90%;" data-eng="In the competency section provided by norm description and order through proficiency level (from top to down)." data-bhs="Pada bagian kompetensi tersedia norma dalam bentuk deskriptif yang mana telah urut berdasarkan tingkat kemahiran (semakin bawah semakin advance).">In the competency section provided by norm description and order through proficiency level (from top to down).</small>
                                </div>
                                <table class="table table-bordered table-striped mt-2">
                                    <thead>
                                        <tr>
                                        <th style="text-align: center; width: 50px;"> No </th>
                                            <th style="width: 35%;" data-eng="Competency" data-bhs="Kompetensi"> Competency </th>
                                            <th style="width: 30%;" data-eng="Proficiency Level Assessment from Employee" data-bhs="Penilaian Tingkat Kemahiran dari Karyawan"> Proficiency Level Assessment from Employee </th>
                                            <th data-eng="Proficiency Level Assessment from Superior" data-bhs="Penilaian Tingkat Kemahiran dari Atasan"> Proficiency Level Assessment from Superior </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($competency) > 0)
                                            @foreach($competency as $key => $value)
                                                <tr>
                                                    <input type="hidden" name="appraisal_competency_new_id[]" value="{{ $value->appraisal_competency_new_id }}">
                                                    <td style="text-align: center;">{{ $key+1 }}</td>
                                                    <td class="competency-name" data-eng="<?php echo "<b>$value->competency_title</b></br>".str_replace("\n", "<br>", $value->competency_eng); ?>" data-bhs="<?php echo "<b>$value->competency_title</b></br>".str_replace("\n", "<br>", $value->competency_bhs); ?>"><?php echo "<b>$value->competency_title</b></br>".str_replace("\n", "<br>", $value->competency_eng); ?></td>
                                                    <td class="form-group" style="vertical-align: middle;">
                                                        <label class="form-check {{ $value->employee_rating == 1 ? 'checked' : '' }}">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="1" {{ $value->employee_rating == 1 ? 'checked' : '' }} disabled>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_1_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_1_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_1_eng); ?></span>
                                                        </label>
                                                        <label class="form-check {{ $value->employee_rating == 2 ? 'checked' : '' }}">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="2" {{ $value->employee_rating == 2 ? 'checked' : '' }} disabled>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_2_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_2_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_2_eng); ?></span>
                                                        </label>
                                                        <label class="form-check {{ $value->employee_rating == 3 ? 'checked' : '' }}">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="3" {{ $value->employee_rating == 3 ? 'checked' : '' }} disabled>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_3_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_3_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_3_eng); ?></span>
                                                        </label>
                                                        <label class="form-check {{ $value->employee_rating == 4 ? 'checked' : '' }}">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="4" {{ $value->employee_rating == 4 ? 'checked' : '' }} disabled>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_4_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_4_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_4_eng); ?></span>
                                                        </label>
                                                    </td>
                                                    <td class="form-group" style="vertical-align: middle;">
                                                        <label class="form-check {{ $value->superior_rating == 1 ? 'checked' : '' }}">
                                                            <input type="radio" name="superior_rating[{{ $key }}]" class="form-check-input proficiency" value="1" {{ $value->superior_rating == 1 ? 'checked' : '' }}>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_1_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_1_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_1_eng); ?></span>
                                                        </label>
                                                        <label class="form-check {{ $value->superior_rating == 2 ? 'checked' : '' }}">
                                                            <input type="radio" name="superior_rating[{{ $key }}]" class="form-check-input proficiency" value="2" {{ $value->superior_rating == 2 ? 'checked' : '' }}>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_2_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_2_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_2_eng); ?></span>
                                                        </label>
                                                        <label class="form-check {{ $value->superior_rating == 3 ? 'checked' : '' }}">
                                                            <input type="radio" name="superior_rating[{{ $key }}]" class="form-check-input proficiency" value="3" {{ $value->superior_rating == 3 ? 'checked' : '' }}>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_3_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_3_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_3_eng); ?></span>
                                                        </label>
                                                        <label class="form-check {{ $value->superior_rating == 4 ? 'checked' : '' }}">
                                                            <input type="radio" name="superior_rating[{{ $key }}]" class="form-check-input proficiency" value="4" {{ $value->superior_rating == 4 ? 'checked' : '' }}>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_4_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_4_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_4_eng); ?></span>
                                                        </label>
                                                        <small class="text-danger"></small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <div class="form-group mt-4">
                                    <label class="form-label col-form-label" data-eng="Overall Feedback on Employee's Competency" data-bhs="Feedback Keseluruhan terhadap Kompetensi ">Overall Feedback on Employee's Competency</label>
                                    <textarea name="competency_feedback" class="form-control" rows="7" data-pl_eng="Type overall feedback on employee's competency.." data-pl_bhs="Isi feedback keseluruhan terhadap kompetensi.." placeholder="Type overall feedback on employee's competency.." style="width: 80%;">{{ $appraisal->competency_feedback }}</textarea>
                                    <small class="text-danger"></small>
                                </div>
                                <h5 class="mt-0 mb-1" data-eng="Guide to Overall Competency Rating" data-bhs="Petunjuk Penilaian Kompetensi Keseluruhan">Petunjuk Penilaian Kompetensi Keseluruhan</h5>
                                <small data-eng="Overall competency assessment, filled in by superiors referring to the definition of rating (1-5)." data-bhs="Penilaian kompetensi secara keseluruhan, diisi oleh atasan mengacu kepada definisi rating (1-5).">Penilaian kompetensi secara keseluruhan, diisi oleh atasan mengacu kepada definisi rating (1-5).</small>
                                <table class="table table-bordered mt-2 mb-3">
                                    <tbody>
                                        <tr>
                                            <td style="width: 20%;"><small class="text-muted">1 - Outstanding / Outperform</small></td>
                                            <td style="width: 20%;"><small class="text-muted">2 - Exceed Expectation</small></td>
                                            <td style="width: 20%;"><small class="text-muted">3 - Meet Expectation</small></td>
                                            <td style="width: 20%;"><small class="text-muted">4 - Below Expectation</small></td>
                                            <td style="width: 20%;"><small class="text-muted">5 - Did not Meet Expectation</small></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="form-group row">
                                    <label class="col-md-3 form-label col-form-label" data-eng="OVERALL COMPETENCY RATING" data-bhs="NILAI KOMPETENSI KESELURUHAN">NILAI KOMPETENSI KESELURUHAN</label>
                                    <div class="col-md-2">
                                        <select name="overall_competency_score" class="form-control select2-hide-search" data-pl_eng="Select A Rating" data-pl_bhs="Pilih Nilai" data-placeholder="Pilih Nilai" style="width: 100%;">
                                            <option></option>
                                            <option value="1.00"{{ $appraisal->overall_competency_score == '1.00' ? ' selected' : '' }}>1</option>
                                            <option value="1.50"{{ $appraisal->overall_competency_score == '1.50' ? ' selected' : '' }}>1.5</option>
                                            <option value="2.00"{{ $appraisal->overall_competency_score == '2.00' ? ' selected' : '' }}>2</option>
                                            <option value="2.50"{{ $appraisal->overall_competency_score == '2.50' ? ' selected' : '' }}>2.5</option>
                                            <option value="3.00"{{ $appraisal->overall_competency_score == '3.00' ? ' selected' : '' }}>3</option>
                                            <option value="3.50"{{ $appraisal->overall_competency_score == '3.50' ? ' selected' : '' }}>3.5</option>
                                            <option value="4.00"{{ $appraisal->overall_competency_score == '4.00' ? ' selected' : '' }}>4</option>
                                            <option value="4.50"{{ $appraisal->overall_competency_score == '4.50' ? ' selected' : '' }}>4.5</option>
                                            <option value="5.00"{{ $appraisal->overall_competency_score == '5.00' ? ' selected' : '' }}>5</option>
                                        </select>
                                        <small class="text-danger"></small>
                                    </div>
                                </div>
                                
                                <!-- DRAFT BUTTON AND NEXT BUTTON -->
                                <div class="w-100 d-flex mt-5">
                                    <button type="button" class="btn btn-primary btn-draft pt-3 pb-3" data-eng="Save as Draft" data-bhs="Simpan sebagai Draft" style="width: 175px;">Save as Draft</button>
                                    <button type="button" class="btn btn-danger btn-reject ml-auto pt-3 pb-3" style="width: 175px;">Reject</button>
                                    <button type="button" class="btn btn-info btn-next ml-3 pt-3 pb-3" data-target="personal_development" style="width: 175px;">Next</button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="personal_development">
                                <div class="form-group">
                                    <label class="form-label mb-0" data-eng="Job & Personal Development" data-bhs="Pengembangan Diri & Pekerjaan">Job & Personal Development</label>
                                    <small class="text-muted" data-eng="List any areas, which with management’s help or specific training, could improve your overall performance and develop your competences and skills." data-bhs="Dalam bidang apa pun, yang dengan bantuan manajemen atau pelatihan khusus, dapat meningkatkan kinerja Anda secara keseluruhan dan mengembangkan kompetensi dan keterampilan Anda.">List any areas, which with management’s help or specific training, could improve your overall performance and develop your competences and skills.</small>
                                    <div class="row" style="width: 99%; margin-left: auto;">
                                        <div class="col-md-6">
                                            <label class="form-label mt-2" data-eng="By Employee" data-bhs="Dari Karyawan">By Employee</label>
                                            <textarea name="personal_development_employee" class="form-control" rows="7" data-pl_eng="Type job & personal development.." data-pl_bhs="Isi pengembangan diri & pekerjaan.." placeholder="Type job & personal development.." readonly>{{ $appraisal->personal_development_employee }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label mt-2" data-eng="By Superior" data-bhs="Dari Atasan">By Superior</label>
                                            <textarea name="personal_development_superior" class="form-control" rows="7" data-pl_eng="Type job & personal development.." data-pl_bhs="Isi pengembangan diri & pekerjaan.." placeholder="Type job & personal development..">{{ $appraisal->personal_development_superior }}</textarea>
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-0" data-eng="Career Development & Ambitions" data-bhs="Pengembangan Karir & Ambisi">Career Development & Ambitions</label>
                                    <small class="text-muted" data-eng="Looking ahead, please indicate how you would like to see your present job and career development over the next five years' time frame." data-bhs="Ke depan, tunjukkan bagaimana Anda ingin melihat pekerjaan dan perkembangan karir Anda saat ini menuju lima tahun ke depan.">Looking ahead, please indicate how you would like to see your present job and career development over the next five years' time frame.</small>
                                    <div class="row" style="width: 99%; margin-left: auto;">
                                        <div class="col-md-6">
                                            <label class="form-label mt-2" data-eng="By Employee" data-bhs="Dari Karyawan">By Employee</label>
                                            <textarea name="career_development_employee" class="form-control" rows="7" data-pl_eng="Type career development & ambitions.." data-pl_bhs="Isi pengembangan karir & ambisi.." placeholder="Type career development & ambitions.." readonly>{{ $appraisal->career_development_employee }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label mt-2" data-eng="By Superior" data-bhs="Dari Atasan">By Superior</label>
                                            <textarea name="career_development_superior" class="form-control" rows="7" data-pl_eng="Type career development & ambitions.." data-pl_bhs="Isi pengembangan karir & ambisi.." placeholder="Type career development & ambitions..">{{ $appraisal->career_development_superior }}</textarea>
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>
                                </div>

                                <!-- DRAFT BUTTON AND NEXT BUTTON -->
                                <div class="w-100 d-flex mt-5">
                                    <button type="button" class="btn btn-primary btn-draft pt-3 pb-3" data-eng="Save as Draft" data-bhs="Simpan sebagai Draft" style="width: 175px;">Save as Draft</button>
                                    <button type="button" class="btn btn-danger btn-reject ml-auto pt-3 pb-3" style="width: 175px;">Reject</button>
                                    <button type="button" class="btn btn-info btn-next ml-3 pt-3 pb-3" data-target="milestone_next" style="width: 175px;">Next</button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="milestone_next">
                                <small class="text-muted" data-eng="To be completed by Employee and agreed by Superiors" data-bhs="Diisi oleh Karyawan dan disetujui oleh Atasan">To be completed by Employee and agreed by Superiors</small><br>
                                <small class="text-muted" data-eng="You must specify the Quantitative measurements & Timeline for each milestone." data-bhs="Anda harus menentukan pengukuran Kuantitatif & Timeline untuk setiap milestone.">You must specify the Quantitative measurements & Timeline for each milestone.</small><br><br>
                                <div class="nav nav-pills d-flex" data-toggle="tabs" role="tablist" aria-orientation="horizontal">
                                    @if(count($milestone_template) > 0)
                                        @foreach($milestone_template as $key => $mlst_temp)
                                            <a href="#{{ str_replace(' ', '_', strtolower($mlst_temp->milestone_eng)) }}_next" class="nav-link{{ $key == 0 ? ' active' : '' }}" id="{{ str_replace(' ', '_', strtolower($mlst_temp->milestone_eng)) }}_next-pill" data-toggle="pill" role="tab" aria-controls="{{ str_replace(' ', '_', strtolower($mlst_temp->milestone_eng)) }}_next" aria-selected="true">
                                                <span class="numbering">{{ $key+1 }}</span> <span class="milestone-name" data-eng="{{ $mlst_temp->milestone_eng }}" data-bhs="{{ $mlst_temp->milestone_bhs }}">{{ $mlst_temp->milestone_eng }}</span>
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="tab-content">
                                    @if(count($milestone_template) > 0)
                                        @foreach($milestone_template as $key => $mlst_temp)
                                            <div class="tab-pane fade{{ $key == 0 ? ' show active' : '' }}" id="{{ str_replace(' ', '_', strtolower($mlst_temp->milestone_eng)) }}_next" role="tabpanel" aria-labelledby="{{ str_replace(' ', '_', strtolower($mlst_temp->milestone_eng)) }}_next-pill">
                                                <input type="hidden" name="milestone_id_next[]" value="{{ $mlst_temp->milestone_id }}">
                                                @if(count($milestone_next) > 0)
                                                    <?php $count = 0; ?>
                                                    @foreach($milestone_next as $mlst_next)
                                                        @if($mlst_next->milestone_id == null)
                                                            <div class="row mt-2">
                                                                <div style="flex: 0 0 auto; width: 48%;">
                                                                    <label class="form-label col-form-label" data-eng="Milestone Description" data-bhs="Deskripsi Milestone">Milestone Description</label>
                                                                    <textarea name="milestone_description_next[{{ $mlst_temp->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type milestone description.." data-pl_bhs="Isi deskripsi milestone.." placeholder="Type milestone description.."></textarea>
                                                                </div>
                                                                <div style="flex: 0 0 auto; width: 48%;">
                                                                    <label class="form-label col-form-label" data-eng="Milestone Measurement" data-bhs="Pencapaian Milestone">Milestone Measurement</label>
                                                                    <textarea name="milestone_measurement_next[{{ $mlst_temp->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type milestone measurement.." data-pl_bhs="Isi pencapaian milestone.." placeholder="Type milestone measurement.."></textarea>
                                                                </div>
                                                            </div>
                                                        @elseif($mlst_next->milestone_id == $mlst_temp->milestone_id)
                                                            <?php $count++; ?>
                                                            <div class="row mt-2">
                                                                <div style="flex: 0 0 auto; width: 48%;">
                                                                    @if($count == 1)
                                                                        <label class="form-label col-form-label" data-eng="Milestone Description" data-bhs="Deskripsi Milestone">Milestone Description</label>
                                                                    @endif
                                                                    <textarea name="milestone_description_next[{{ $mlst_temp->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type milestone description.." data-pl_bhs="Isi deskripsi milestone.." placeholder="Type milestone description.."><?php echo $mlst_next->milestone_description; ?></textarea>
                                                                </div>
                                                                <div style="flex: 0 0 auto; width: 48%;">
                                                                    @if($count == 1)
                                                                        <label class="form-label col-form-label" data-eng="Milestone Measurement" data-bhs="Pencapaian Milestone">Milestone Measurement</label>
                                                                    @endif
                                                                    <textarea name="milestone_measurement_next[{{ $mlst_temp->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type milestone measurement.." data-pl_bhs="Isi pencapaian milestone.." placeholder="Type milestone measurement.."><?php echo $mlst_next->milestone_measurement; ?></textarea>
                                                                </div>
                                                                @if($count > 1)
                                                                    <div style="flex: 0 0 auto; width: 4%; padding-top: 40px; text-align: center;">
                                                                        <a href="javascript:;" class="text-danger btn-delete-point" data-mlst="{{ str_replace(' ', '_', strtolower($mlst_temp->milestone_eng)) }}" style="font-size: 20px;">
                                                                            <i class="fa fa-minus-circle"></i>
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                <div class="added-milestone-point"></div>
                                                @if($count < 5)
                                                    <a href="javascript:;" class="btn btn-secondary btn-add-point-next mt-2" data-id="{{ $mlst_temp->milestone_id }}" data-mlst="{{ str_replace(' ', '_', strtolower($mlst_temp->milestone_eng)) }}" data-count="{{ $count == 0 ? 1 : $count }}">
                                                        <i class="fa fa-plus"></i> Add More Point
                                                    </a>
                                                @endif

                                                <!-- DRAFT BUTTON AND NEXT BUTTON -->
                                                <div class="w-100 d-flex mt-5">
                                                    <button type="button" class="btn btn-primary btn-draft pt-3 pb-3" data-eng="Save as Draft" data-bhs="Simpan sebagai Draft" style="width: 175px;">Save as Draft</button>
                                                    <button type="button" class="btn btn-danger btn-reject ml-auto pt-3 pb-3" style="width: 175px;">Reject</button>
                                                    @if($key != count($milestone_template)-1)
                                                        <button type="button" class="btn btn-info btn-next ml-3 pt-3 pb-3" data-target="{{ str_replace(' ', '_', strtolower($milestone_template[$key+1]->milestone_eng)) }}_next" style="width: 175px;">Next</button>
                                                    @else
                                                        <button type="button" class="btn btn-info btn-next ml-3 pt-3 pb-3" data-target="performance_review" style="width: 175px;">Next</button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade" id="performance_review">
                                <h4 class="font-weight-bold mb-0" data-eng="SUMMARY OF PERFORMANCE APPRAISAL" data-bhs="RINGKASAN PENILAIAN KINERJA">SUMMARY OF PERFORMANCE APPRAISAL</h4>
                                <small class="text-muted" data-eng="Please give summary of appraisal identifying any special circumstances influencing performance and areas for further development/improvement" data-bhs="Harap berikan ringkasan penilaian yang mengidentifikasi keadaan khusus yang memengaruhi kinerja dan bidang untuk pengembangan / peningkatan lebih lanjut">Please give summary of appraisal identifying any special circumstances influencing performance and areas for further development/improvement</small>
                                <div class="form-group row mt-3">
                                    <label class="col-md-3 form-label col-form-label" data-eng="Strength & Area Improvements" data-bhs="Kelebihan & Area Perbaikan">Strength & Area Improvements</label>
                                    <div class="col-md-9">
                                        <textarea name="improvement" class="form-control" rows="7" data-pl_eng="Type strength & area improvements.." data-pl_bhs="Isi kelebihan & area perbaikan.." placeholder="Type strength & area improvements..">{{ $appraisal->improvement }}</textarea>
                                        <small class="text-danger"></small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label class="form-label col-form-label" data-eng="Feedback from Superior and Superior's Superior" data-bhs="Feedback dari Atasan (L1 dan L2)">Feedback from Superior and Superior's Superior</label>
                                        <small class="text-muted" data-eng="Please input your name before your feedback (e.g John Doe : feedback)" data-bhs="Masukkan nama Anda sebelum feedback (e.g John Doe : feedback)">Please input your name before your feedback (e.g John Doe : feedback)</small>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea name="superior_feedback" class="form-control" rows="7" data-pl_eng="Type feedback from superior.." data-pl_bhs="Isi feedback dari atasan.." placeholder="Type feedback from superior..">{{ $appraisal->superior_feedback }}</textarea>
                                        <small class="text-danger"></small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-6 form-label col-form-label" data-eng="OVERALL MILESTONE RATING" data-bhs="NILAI MILESTONE KESELURUHAN">OVERALL MILESTONE RATING</label>
                                            <div class="col-md-4">
                                                <input type="text" name="overall_milestone_score" class="form-control font-weight-bold" value="{{ $appraisal->overall_milestone_score }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-6 form-label col-form-label" data-eng="OVERALL COMPETENCIES RATING" data-bhs="NILAI KOMPETENSI KESELURUHAN">OVERALL COMPETENCIES RATING</label>
                                            <div class="col-md-4">
                                                <input type="text" name="overall_competency_score" class="form-control font-weight-bold" value="{{ $appraisal->overall_competency_score }}" readonly>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                            <label class="col-md-3 form-label col-form-label" data-eng="OVERALL JOB PERFORMANCE RATING" data-bhs="NILAI KESELURUHAN KINERJA">OVERALL JOB PERFORMANCE RATING</label>
                                            <div class="col-md-2">
                                                <input type="text" name="overall_performance_score" class="form-control font-weight-bold" readonly>
                                            </div>
                                        </div> -->
                                        <div class="form-group row">
                                            <label class="col-md-6 form-label col-form-label" data-eng="OVERALL JOB PERFORMANCE RATING" data-bhs="NILAI KESELURUHAN KINERJA">OVERALL JOB PERFORMANCE RATING <small class="text-muted">(recommended by superior)</small></label>
                                            <div class="col-md-4">
                                                <select name="overall_performance_score_rounded" class="form-control select2-hide-search" data-pl_eng="Select A Rating" data-pl_bhs="Pilih Nilai" data-placeholder="Select A Rating" style="width: 100%;">
                                                    <option></option>
                                                    <option value="1 (OSC)"{{ $appraisal->overall_performance_score == '1 (OSC)' ? ' selected' : '' }}>1 (OSC)</option>
                                                    <option value="1.5 (ECC)"{{ $appraisal->overall_performance_score == '1.5 (ECC)' ? ' selected' : '' }}>1.5 (ECC)</option>
                                                    <option value="2 (ECC)"{{ $appraisal->overall_performance_score == '2 (ECC)' ? ' selected' : '' }}>2 (ECC)</option>
                                                    <option value="2.5 (HVC)"{{ $appraisal->overall_performance_score == '2.5 (HVC)' ? ' selected' : '' }}>2.5 (HVC)</option>
                                                    <option value="3 (HVC)"{{ $appraisal->overall_performance_score == '3 (HVC)' ? ' selected' : '' }}>3 (HVC)</option>
                                                    <option value="3.5 (MCE)"{{ $appraisal->overall_performance_score == '3.5 (MCE)' ? ' selected' : '' }}>3.5 (MCE)</option>
                                                    <option value="4 (MCE)"{{ $appraisal->overall_performance_score == '4 (MCE)' ? ' selected' : '' }}>4 (MCE)</option>
                                                    <option value="4.5 (USC)"{{ $appraisal->overall_performance_score == '4.5 (USC)' ? ' selected' : '' }}>4.5 (USC)</option>
                                                    <option value="5 (USC)"{{ $appraisal->overall_performance_score == '5 (USC)' ? ' selected' : '' }}>5 (USC)</option>
                                                </select>
                                                <small class="text-danger"></small>
                                                <!-- <input type="text" name="overall_performance_score_rounded" class="form-control font-weight-bold" value="{{ $appraisal->overall_performance_score }}" readonly> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="font-weight-bold mt-2 mb-1" data-eng="Guide to Overall Performance Rating :" data-bhs="Petunjuk Pengisian Nilai Keseluruhan Kerja :">Guide to Overall Performance Rating :</h5>
                                        <table style="width: 100%;">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 7%;"> OSC </td><td style="width: 3%;"> : </td>
                                                    <td> Outstanding Contribution </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 7%;"> ECC </td><td style="width: 3%;"> : </td>
                                                    <td> Excellent Contribution </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 7%;"> HVC </td><td style="width: 3%;"> : </td>
                                                    <td> Highly Valued Contribution </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 7%;"> MCE </td><td style="width: 3%;"> : </td>
                                                    <td> More Contribution Expected </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 7%;"> USC </td><td style="width: 3%;"> : </td>
                                                    <td> Unsatisfactory Contribution </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- DRAFT BUTTON AND APPROVE/REJECT BUTTON -->
                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-primary btn-draft pt-3 pb-3" style="width: 175px;">Save as Draft</button>
                                    </div>
                                    <div class="col-md-8 text-right">
                                        <input type="hidden" name="status">
                                        <button type="button" class="btn btn-danger btn-reject ml-auto pt-3 pb-3" style="width: 175px;">Reject</button>
                                        <button type="button" class="btn btn-success ml-3 pt-3 pb-3" id="btn-approve" style="width: 175px;">Approve</button>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="appraisal_approval_reject_note">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page Content -->
    <!-- ============================================================== -->
</div>

<!-- BEGIN MODAL REJECT -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="rejectModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title">Reject This Appraisal</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Note</label>
                        <textarea name="note" class="form-control" rows="8" placeholder="Type reason for rejecting this milestone.."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODAL REJECT -->
@endsection

@section('assets-bottom')
<script type="text/javascript">
	
	$(document).ready(function() {

        $('.nav-appraisal_approval').addClass('active');

        $('#language').bootstrapSwitch({
            onText : 'INA',
            offText : 'ENG',
            offColor : 'primary'
        });

        $('.select2-hide-search').select2({
            theme : 'bootstrap4',
            minimumResultsForSearch : Infinity
        });

        $('.numbers').autoNumeric('init');

        var milestone = parseFloat($('input[name=overall_milestone_score]').val());
        var competency = parseFloat($('select[name=overall_competency_score]').val());

        if(milestone != null && competency != null) {
            var overall = (milestone + competency) / 2;

            if(isNaN(overall) || overall == undefined) {
                $('input[name=overall_performance_score]').val('-').change();
            } else {
                $('input[name=overall_performance_score]').val(overall.toFixed(2)).change();
            }
        }

        $(document).on('switchChange.bootstrapSwitch', '#language', function(event, state) {
            if(state) {
                $('input[name=language]').val('ina');
                $('.nav-tabs .nav-link, .milestone-name, .competency-name, h4, h5, th, label, span, small, button').each(function(index) {
                    $(this).html($(this).data('bhs'));
                });
                $('textarea').each(function(index) {
                    $(this).prop('placeholder', $(this).data('pl_bhs'));
                });
                $('.select2-selection__placeholder').each(function(index) {
                    $(this).html('Pilih Nilai');
                });
            } else {
                $('input[name=language]').val('eng');
                $('.nav-tabs .nav-link, .milestone-name, .competency-name, h4, h5, th, label, span, small, button').each(function(index) {
                    $(this).html($(this).data('eng'));
                });
                $('textarea').each(function(index) {
                    $(this).prop('placeholder', $(this).data('pl_eng'));
                });
                $('.select2-selection__placeholder').each(function(index) {
                    $(this).html('Select A Rating');
                });
            }
        });

        $(document).on('click', '.btn-add-point-next', function(e) {
            var id = e.currentTarget.dataset.id;
            var mlst = e.currentTarget.dataset.mlst;
            var count = parseInt(e.currentTarget.dataset.count);

            var html = '';
            if($('input[name=language]').val() == 'eng') {
                html = '<div class="row mt-2">'+
                    '<div style="flex: 0 0 auto; width: 48%;">'+
                        '<textarea name="milestone_description_next['+id+'][]" class="form-control" rows="5" data-pl_eng="Type milestone description.." data-pl_bhs="Isi deskripsi milestone.." placeholder="Type milestone description.."></textarea>'+
                    '</div><div style="flex: 0 0 auto; width: 48%;">'+
                        '<textarea name="milestone_measurement_next['+id+'][]" class="form-control" rows="5" data-pl_eng="Type milestone measurement.." data-pl_bhs="Isi pencapaian milestone.." placeholder="Type milestone measurement.."></textarea>'+
                    '</div><div style="flex: 0 0 auto; width: 4%; padding-top: 40px; text-align: center;">'+
                        '<a href="javascript:;" class="text-danger btn-delete-point" data-mlst="'+mlst+'" style="font-size: 20px;"><i class="fa fa-minus-circle"></i></a>'+
                    '</div></div>';
            } else if($('input[name=language]').val() == 'ina') {
                html = '<div class="row mt-2">'+
                    '<div style="flex: 0 0 auto; width: 48%;">'+
                        '<textarea name="milestone_description_next['+id+'][]" class="form-control" rows="5" data-pl_eng="Type milestone description.." data-pl_bhs="Isi deskripsi milestone.." placeholder="Isi deskripsi milestone.."></textarea>'+
                    '</div><div style="flex: 0 0 auto; width: 48%;">'+
                        '<textarea name="milestone_measurement_next['+id+'][]" class="form-control" rows="5" data-pl_eng="Type milestone measurement.." data-pl_bhs="Isi pencapaian milestone.." placeholder="Isi pencapaian milestone.."></textarea>'+
                    '</div><div style="flex: 0 0 auto; width: 4%; padding-top: 40px; text-align: center;">'+
                        '<a href="javascript:;" class="text-danger btn-delete-point" data-mlst="'+mlst+'" style="font-size: 20px;"><i class="fa fa-minus-circle"></i></a>'+
                    '</div></div>';
            }

            if(count == 4) {
                $(this).parents('.tab-pane#'+mlst+'_next').find('.added-milestone-point').append(html);
                $(this).attr('data-count', (count+1));
                $(this).hide();
            } else if(count < 5) {
                $(this).parents('.tab-pane#'+mlst+'_next').find('.added-milestone-point').append(html);
                $(this).attr('data-count', (count+1));
            }
        });

        $(document).on('click', '.btn-delete-point', function(e) {
            var mlst = e.currentTarget.dataset.mlst;

            var count = $(this).parents('.added-milestone-point').find('.row.mt-2').length;
            $(this).parents('.tab-pane').find('.btn-add-point').attr('data-count', count);

            if(count < 5) {
                $(this).parents('.tab-pane').find('.btn-add-point').show();
            }

            $(this).parents('.row.mt-2').remove();
        });

        $(document).on('change input keyup', 'select, textarea, input', function(e) {
            $(this).removeClass('is-invalid');
            $(this).parents('.form-group').find('.text-danger').html('');
        });

        $(document).on('click', '.btn-clear-rating', function(e) {
            $('select[name=beyond_milestone_score]').val(0).trigger('change');
        });

        $(document).on('change', 'select.superior_score', function(e) {
            var mlst = e.currentTarget.dataset.mlst_id;
            var score = [];

            $.each($('select.superior_score[data-mlst_id='+mlst+']'), function(index) {
                score.push($(this).val());
            });

            var overall = 0;

            $.each(score, function(key, value) {
                if(value == "") {
                    overall = 0;
                    return false;
                } else {
                    overall = (parseFloat(overall) + parseFloat(value));
                }
            });

            overall = overall / score.length;

            if(isNaN(overall) || overall == undefined || overall == 0) {
                $('input.overall_score[data-mlst='+mlst+']').val('-').change();
            } else {
                $('input.overall_score[data-mlst='+mlst+']').val(overall.toFixed(2)).change();
            }
        });

        $(document).on('change input keyup', 'input.overall_score, select[name=beyond_milestone_score]', function(e) {
            var score = [];

            $.each($('input.overall_score'), function(index) {
                score.push($(this).val());
            });

            if($('select[name=beyond_milestone_score]').val() != '' && $('select[name=beyond_milestone_score]').val() != null) {
                score.push($('select[name=beyond_milestone_score]').val());
            }

            var overall = 0;

            $.each(score, function(key, value) {
                if(value == "") {
                    overall = 0;
                    return false;
                } else {
                    overall = (parseFloat(overall) + parseFloat(value));
                }
            });

            overall = overall / score.length;

            if(isNaN(overall) || overall == undefined || overall == 0) {
                $('input[name=overall_milestone_score]').val('-').change();
            } else {
                if(overall >= 4.76 && overall <= 5.00) {
                    overall = 5;
                } else if(overall >= 4.26 && overall <= 4.75) {
                    overall = 4.5;
                } else if(overall >= 3.76 && overall <= 4.25) {
                    overall = 4;
                } else if(overall >= 3.26 && overall <= 3.75) {
                    overall = 3.5;
                } else if(overall >= 2.76 && overall <= 3.25) {
                    overall = 3;
                } else if(overall >= 2.26 && overall <= 2.75) {
                    overall = 2.5;
                } else if(overall >= 1.76 && overall <= 2.25) {
                    overall = 2;
                } else if(overall >= 1.26 && overall <= 1.75) {
                    overall = 1.5;
                } else if(overall >= 1.00 && overall <= 1.25) {
                    overall = 1;
                }

                $('input[name=overall_milestone_score]').val(overall.toFixed(2)).change();
            }
        });

        $(document).on('change', '.form-check-input', function(e) {
            if($(this).is(':checked')) {
                $(this).closest('td').find('.form-check').removeClass('checked');
                $(this).closest('.form-check').addClass('checked');
                $(this).closest('.form-group').find('.text-danger').html('');
            }
        });

        $(document).on('change', 'select[name=overall_competency_score]', function(e) {
            $('input[name=overall_competency_score]').val($(this).val()).change();
        });

        $(document).on('change', 'input[name=overall_milestone_score], input[name=overall_competency_score]', function(e) {
            var milestone = parseFloat($('input[name=overall_milestone_score]').val());
            var competency = parseFloat($('input[name=overall_competency_score]').val());

            var overall = (milestone + competency) / 2;
            
            if(isNaN(overall) || overall == undefined) {
                $('input[name=overall_performance_score]').val('-').change();
            } else {
                $('input[name=overall_performance_score]').val(overall.toFixed(2)).change();
            }
        });

        $(document).on('change', 'input[name=overall_performance_score]', function(e) {
            var score = parseFloat($(this).val());
            var overall = '';

            if(score >= 4.76 && score <= 5.00) {
                overall = '5 (USC)';
            } else if(score >= 4.26 && score <= 4.75) {
                overall = '4.5 (USC)';
            } else if(score >= 3.76 && score <= 4.25) {
                overall = '4 (MCE)';
            } else if(score >= 3.26 && score <= 3.75) {
                overall = '3.5 (MCE)';
            } else if(score >= 2.76 && score <= 3.25) {
                overall = '3 (HVC)';
            } else if(score >= 2.26 && score <= 2.75) {
                overall = '2.5 (HVC)';
            } else if(score >= 1.76 && score <= 2.25) {
                overall = '2 (ECC)';
            } else if(score >= 1.26 && score <= 1.75) {
                overall = '1.5 (ECC)';
            } else if(score >= 1.00 && score <= 1.25) {
                overall = '1 (OSC)';
            }

            $('input[name=overall_performance_score_rounded]').val(overall).change();
        });

        $(document).on('click', '.btn-next', function(e) {
            $('a[href="#'+e.currentTarget.dataset.target+'"]').tab('show');
        });

        $(document).on('click', '.btn-draft', function(e) {
            e.preventDefault();

            $.ajax({
                url : "{{ url('/appraisal/draft') }}",
                type : "POST",
                data : $('form').serialize(),
                beforeSend : function() {
                    $('.se-pre-con').fadeIn();
                },
                success : function(res) {
                    $('.se-pre-con').fadeOut();
                    toastr.success('Saved as Draft!', 'Success', { "closeButton": true });
                },
                error : function(jqXhr, errorThrown, textStatus) {
                    $('.se-pre-con').fadeOut();
                    toastr.error('Something is wrong, Try Again!', 'Oops!', { "closeButton": true });
                }
            });
        });

        $(document).on('click', '.btn-reject', function(e) {
            var modal = $('#rejectModal');

            modal.modal('show');
        });

        $(document).on('submit', '#rejectModal form', function(e) {
            e.preventDefault();

            $('input[name=appraisal_approval_reject_note]').val($('textarea[name=note]').val());

            $.ajax({
                url : "{{ url('/appraisal/reject') }}",
                type : "POST",
                data : $('#approvalForm').serialize(),
                beforeSend : function() {
                    $('.se-pre-con').fadeIn();
                },
                success : function(res) {
                    $.ajax({
                        type : "POST",
                        url : "{{ url('/appraisal/send-reject-mail') }}",
                        data : {
                            "_token" : "{{ csrf_token() }}",
                            recipient_name : res.recipient_name,
                            recipient_email : res.recipient_email,
                            reject_note : res.reject_note
                        },
                        success : function(res) {
                            $('.se-pre-con').fadeOut();
                            
                            Swal.fire({
                                title : 'Rejected',
                                type : 'success'
                            }).then((result) => {
                                window.location.href = "{{ url('/appraisal/approval') }}";
                            });
                        },
                        error : function(jqXhr, errorThrown, textStatus) {
                            $('.se-pre-con').fadeOut();

                            Swal.fire({
                                title : 'Rejected',
                                text : 'Failed to Send Notification Email',
                                type : 'success'
                            }).then((result) => {
                                window.location.href = "{{ url('/appraisal/approval') }}";
                            });
                        }
                    });
                },
                error : function(jqXhr, errorThrown, textStatus) {
                    $('.se-pre-con').fadeOut();
                    toastr.error('Something is wrong, Try Again!', 'Oops!', { "closeButton": true });
                }
            });
        });

        $(document).on('click', '#btn-approve', function(e) {
            e.preventDefault();

            var status = 'ok';

            $.each($('textarea.superior_assessment'), function(index) {
                if($(this).val() == '') {
                    $(this).addClass('is-invalid');
                    $(this).parents('.form-group').find('.text-danger').html('Please Fill Superior\'s Assessment');

                    if(status == 'ok') {
                        $('a[href="#milestone"]').tab('show');
                        $('a[href="#'+$(this).data('mlst')+'"]').tab('show');
                    }

                    status = 'err';
                }
            });

            $.each($('select.superior_score'), function(index) {
                if($(this).val() == '' && $(this).attr('name') != 'beyond_milestone_score') {
                    $(this).addClass('is-invalid');
                    $(this).parents('.form-group').find('.text-danger').html('Please Select A Rating');

                    if(status == 'ok') {
                        $('a[href="#milestone"]').tab('show');
                        $('a[href="#'+$(this).data('mlst')+'"]').tab('show');
                    }

                    status = 'err';
                }
            });

            if($('textarea[name=milestone_feedback]').val() == '') {
                $('textarea[name=milestone_feedback]').addClass('is-invalid');
                $('textarea[name=milestone_feedback]').parents('.form-group').find('.text-danger').html('Please Fill Overall Feedback on Employee\'s milestone');

                if(status == 'ok') {
                    $('a[href="#milestone"]').tab('show');
                    $('a[href="#milestone_feedback').tab('show');
                }

                status = 'err';
            }

            @foreach($competency as $key => $val)
                var x = false;
                $.each($('input[name="superior_rating[{{ $key }}]"]'), function(index) {
                    if($(this).is(':checked')) {
                        x = true;
                    }
                });

                if(x == false) {
                    // $(this).addClass('is-invalid');
                    $('input[name="superior_rating[{{ $key }}]"]').closest('.form-group').find('.text-danger').html('Please Select A Rating');

                    if(status == 'ok') {
                        $('a[href="#competencies"]').tab('show');
                    }

                    status = 'err';
                }
            @endforeach

            if($('textarea[name=competency_feedback]').val() == '') {
                $('textarea[name=competency_feedback]').addClass('is-invalid');
                $('textarea[name=competency_feedback]').parents('.form-group').find('.text-danger').html('Please Fill Overall Feedback on Employee\'s Competency');

                if(status == 'ok') {
                    $('a[href="#competencies"]').tab('show');
                }

                status = 'err';
            }

            if($('select[name=overall_competency_score]').val() == '') {
                $('select[name=overall_competency_score]').addClass('is-invalid');
                $('select[name=overall_competency_score]').parents('.form-group').find('.text-danger').html('Please Select A Rating');

                if(status == 'ok') {
                    $('a[href="#competencies"]').tab('show');
                }

                status = 'err';
            }

            if($('textarea[name=personal_development_superior]').val() == '') {
                $('textarea[name=personal_development_superior]').addClass('is-invalid');
                $('textarea[name=personal_development_superior]').parents('.form-group').find('.text-danger').html('Please Fill Job & Personal Development');

                if(status == 'ok') {
                    $('a[href="#personal_development"]').tab('show');
                }

                status = 'err';
            }

            if($('textarea[name=career_development_superior]').val() == '') {
                $('textarea[name=career_development_superior]').addClass('is-invalid');
                $('textarea[name=career_development_superior]').parents('.form-group').find('.text-danger').html('Please Fill Career Development & Ambitions');

                if(status == 'ok') {
                    $('a[href="#personal_development"]').tab('show');
                }

                status = 'err';
            }

            if($('textarea[name=improvement]').val() == '') {
                $('textarea[name=improvement]').addClass('is-invalid');
                $('textarea[name=improvement]').parents('.form-group').find('.text-danger').html('Please Fill Strength & Area Improvements');

                if(status == 'ok') {
                    $('a[href="#performance_review"]').tab('show');
                }

                status = 'err';
            }

            if($('textarea[name=superior_feedback]').val() == '') {
                $('textarea[name=superior_feedback]').addClass('is-invalid');
                $('textarea[name=superior_feedback]').parents('.form-group').find('.text-danger').html('Please Fill Feedback from Superior');

                if(status == 'ok') {
                    $('a[href="#performance_review"]').tab('show');
                }

                status = 'err';
            }

            if($('select[name=overall_performance_score_rounded]').val() == '') {
                $('select[name=overall_performance_score_rounded]').addClass('is-invalid');
                $('select[name=overall_performance_score_rounded]').parents('.form-group').find('.text-danger').html('Please Select A Rating');

                if(status == 'ok') {
                    $('a[href="#performance_review"]').tab('show');
                }

                status = 'err';
            }

            if(status == 'ok') {
                Swal.fire({
                    title : 'Approve this Appraisal Form?',
                    type : 'warning',
                    showCancelButton : true,
                    confirmButtonText : 'Yes, Approve',
                    reverseButtons : true,
                }).then((result) => {
                    if(result.value) {
                        $.ajax({
                            url : "{{ url('/appraisal/approve') }}",
                            type : "POST",
                            data : $('#approvalForm').serialize(),
                            beforeSend : function() {
                                $('.se-pre-con').fadeIn();
                            },
                            success : function(res) {
                                if(res[0] == 'closed') {
                                    $.ajax({
                                        type : "POST",
                                        url : "{{ url('/appraisal/send-feedback-mail') }}",
                                        data : {
                                            "_token" : "{{ csrf_token() }}",
                                            recipient_name : res[1].recipient_name,
                                            recipient_email : res[1].recipient_email
                                        },
                                        success : function(res) {
                                            $('.se-pre-con').fadeOut();
                                            
                                            Swal.fire({
                                                title : 'Approved',
                                                type : 'success'
                                            }).then((result) => {
                                                window.location.href = "{{ url('/appraisal/approval') }}";
                                            });
                                        },
                                        error : function(jqXhr, errorThrown, textStatus) {
                                            $('.se-pre-con').fadeOut();

                                            Swal.fire({
                                                title : 'Approved',
                                                text : 'Failed to Send Notification Email',
                                                type : 'success'
                                            }).then((result) => {
                                                window.location.href = "{{ url('/appraisal/approval') }}";
                                            });
                                        }
                                    });
                                } else if(res[0] == 'open') {
                                    $.ajax({
                                        type : "POST",
                                        url : "{{ url('/appraisal/send-mail') }}",
                                        data : {
                                            "_token" : "{{ csrf_token() }}",
                                            recipient_name : res[1].recipient_name,
                                            recipient_email : res[1].recipient_email,
                                            nik : res[1].nik,
                                            employee : res[1].employee,
                                            department : res[1].department,
                                            level : res[1].level
                                        },
                                        success : function(res) {
                                            $('.se-pre-con').fadeOut();
                                            
                                            Swal.fire({
                                                title : 'Approved',
                                                type : 'success'
                                            }).then((result) => {
                                                window.location.href = "{{ url('/appraisal/approval') }}";
                                            });
                                        },
                                        error : function(jqXhr, errorThrown, textStatus) {
                                            $('.se-pre-con').fadeOut();

                                            Swal.fire({
                                                title : 'Approved',
                                                text : 'Failed to Send Notification Email',
                                                type : 'success'
                                            }).then((result) => {
                                                window.location.href = "{{ url('/appraisal/approval') }}";
                                            });
                                        }
                                    });
                                }
                            },
                            error : function(jqXhr, errorThrown, textStatus) {
                                $('.se-pre-con').fadeOut();
                                toastr.error('Something is wrong, Try Again!', 'Oops!', { "closeButton": true });
                            }
                        });
                    }
                });
            }
        });

	});

</script>
@endsection