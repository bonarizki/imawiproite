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
                <h2 class="page-title">Appraisal Form</h2>
            </div>
            <div class="col-auto ml-auto d-print-none">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item active">Appraisal Form</li>
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
                    <div class="col-md-10">
                        <ul class="nav nav-tabs" data-toggle="tabs">
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
                                <a href="#milestone_next" class="nav-link" data-toggle="tab" data-eng="Milestone for Next Year" data-bhs="Milestone untuk Tahun Depan">Milestone for Next Year</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-2 text-right">
                        <input type="checkbox" id="language" value="1" data-bootstrap-switch>
                        <input type="hidden" name="language" value="eng">
                    </div>
                </div>
                <div class="card-body">
                    <form class="p-2" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="appraisal_status">
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
                                    @endif
                                </div>
                                <div class="tab-content mt-3">
                                    @if(count($milestone) > 0)
                                        @foreach($milestone as $key => $mlst)
                                            @if($key > 0 && $mlst['milestone_id'] == $milestone[($key-1)]['milestone_id'])
                                                <div class="row mt-2">
                                                    <input type="hidden" name="appraisal_milestone_detail_id[{{ $mlst->milestone_id }}][]" value="{{ $mlst->appraisal_milestone_detail_id }}">
                                                    <div style="flex: 0 0 auto; width: 32%;">
                                                        <textarea name="milestone_description[{{ $mlst->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type milestone description.." data-pl_bhs="Isi deskripsi milestone.." placeholder="Type milestone description.." readonly>{{ $mlst->milestone_description }}</textarea>
                                                    </div>
                                                    <div style="flex: 0 0 auto; width: 32%;">
                                                        <textarea name="milestone_measurement[{{ $mlst->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type milestone measurement.." data-pl_bhs="Isi pencapaian milestone.." placeholder="Type milestone measurement.." readonly>{{ $mlst->milestone_measurement }}</textarea>
                                                    </div>
                                                    <div class="form-group mb-0" style="flex: 0 0 auto; width: 32%;">
                                                        <textarea name="employee_assessment[{{ $mlst->milestone_id }}][]" class="form-control employee_assessment" rows="5" data-mlst="{{ str_replace(' ', '_', strtolower($mlst->milestone_eng)) }}" data-pl_eng="Type employee's assessment.." data-pl_bhs="Isi penilaian karyawan.." placeholder="Type employee's assessment.."{{ $appraisal->appraisal_status != 'DRAFT' ? ' readonly' : '' }}>{{ $mlst->employee_assessment }}</textarea>
                                                        <small class="text-danger"></small>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="tab-pane fade{{ $key == 0 ? ' show active' : '' }}" id="{{ str_replace(' ', '_', strtolower($mlst->milestone_eng)) }}" role="tabpanel" aria-labelledby="{{ str_replace(' ', '_', strtolower($mlst->milestone_eng)) }}-pill">
                                                    <input type="hidden" name="milestone_id[]" value="{{ $mlst->milestone_id }}">
                                                    <div class="row mt-2">
                                                        <input type="hidden" name="appraisal_milestone_detail_id[{{ $mlst->milestone_id }}][]" value="{{ $mlst->appraisal_milestone_detail_id }}">
                                                        <div style="flex: 0 0 auto; width: 32%;">
                                                            <label class="form-label col-form-label" data-eng="Milestone Description" data-bhs="Deskripsi Milestone">Milestone Description</label>
                                                            <textarea name="milestone_description[{{ $mlst->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type milestone description.." data-pl_bhs="Isi deskripsi milestone.." placeholder="Type milestone description.." readonly>{{ $mlst->milestone_description }}</textarea>
                                                        </div>
                                                        <div style="flex: 0 0 auto; width: 32%;">
                                                            <label class="form-label col-form-label" data-eng="Milestone Measurement" data-bhs="Pencapaian Milestone">Milestone Measurement</label>
                                                            <textarea name="milestone_measurement[{{ $mlst->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type milestone measurement.." data-pl_bhs="Isi pencapaian milestone.." placeholder="Type milestone measurement.." readonly>{{ $mlst->milestone_measurement }}</textarea>
                                                        </div>
                                                        <div class="form-group mb-0" style="flex: 0 0 auto; width: 32%;">
                                                            <label class="form-label col-form-label" data-eng="Employee's Assessment" data-bhs="Penilaian Karyawan">Employee's Assessment</label>
                                                            <textarea name="employee_assessment[{{ $mlst->milestone_id }}][]" class="form-control employee_assessment" rows="5" data-mlst="{{ str_replace(' ', '_', strtolower($mlst->milestone_eng)) }}" data-pl_eng="Type employee's assessment.." data-pl_bhs="Isi penilaian karyawan.." placeholder="Type employee's assessment.."{{ $appraisal->appraisal_status != 'DRAFT' ? ' readonly' : '' }}>{{ $mlst->employee_assessment }}</textarea>
                                                            <small class="text-danger"></small>
                                                        </div>
                                                    </div>
                                                @endif

                                            @if($key < (count($milestone)-1) && $mlst['milestone_id'] != $milestone[($key+1)]['milestone_id'])
                                                <!-- DRAFT BUTTON AND NEXT BUTTON -->
                                                @if($appraisal == null || $appraisal->appraisal_status == 'DRAFT')
                                                    <div class="w-100 d-flex mt-5">
                                                        <button type="button" class="btn btn-primary btn-draft pt-3 pb-3" data-eng="Save as Draft" data-bhs="Simpan sebagai Draft" style="width: 175px;">Save as Draft</button>
                                                        <button type="button" class="btn btn-info btn-next ml-auto pt-3 pb-3" data-target="{{ str_replace(' ', '_', strtolower($milestone[$key+1]->milestone_eng)) }}" style="width: 175px;">Next</button>
                                                    </div>
                                                @endif

                                                </div>
                                            @elseif($key == (count($milestone)-1))
                                                <!-- DRAFT BUTTON AND NEXT BUTTON -->
                                                @if($appraisal == null || $appraisal->appraisal_status == 'DRAFT')
                                                    <div class="w-100 d-flex mt-5">
                                                        <button type="button" class="btn btn-primary btn-draft pt-3 pb-3" data-eng="Save as Draft" data-bhs="Simpan sebagai Draft" style="width: 175px;">Save as Draft</button>
                                                        <button type="button" class="btn btn-info btn-next ml-auto pt-3 pb-3" data-target="competencies" style="width: 175px;">Next</button>
                                                    </div>
                                                @endif

                                                </div>
                                            @endif
                                        @endforeach
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
                                            <th data-eng="Proficiency Level Assessment from Employee" data-bhs="Penilaian Tingkat Kemahiran dari Karyawan"> Proficiency Level Assessment from Employee </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($competency) > 0)
                                            @foreach($competency as $key => $value)
                                                <tr>
                                                    <input type="hidden" name="competency_new_id[]" value="{{ $value->competency_new_id }}">
                                                    <td style="text-align: center;">{{ $key+1 }}</td>
                                                    <td class="competency-name" data-eng="<?php echo "<b>$value->competency_title</b></br>".str_replace("\n", "<br>", $value->competency_eng); ?>" data-bhs="<?php echo "<b>$value->competency_title</b></br>".str_replace("\n", "<br>", $value->competency_bhs); ?>"><?php echo "<b>$value->competency_title</b></br>".str_replace("\n", "<br>", $value->competency_eng); ?></td>
                                                    <td class="form-group" style="vertical-align: middle;">
                                                        <label class="form-check {{ $value->employee_rating == 1 ? 'checked' : '' }}">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="1" {{ $value->employee_rating == 1 ? 'checked' : '' }} {{ $appraisal->appraisal_status != 'DRAFT' && $appraisal->appraisal_status != 'REJECTED' ? 'disabled' : '' }}>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_1_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_1_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_1_eng); ?></span>
                                                        </label>
                                                        <label class="form-check {{ $value->employee_rating == 2 ? 'checked' : '' }}">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="2" {{ $value->employee_rating == 2 ? 'checked' : '' }} {{ $appraisal->appraisal_status != 'DRAFT' && $appraisal->appraisal_status != 'REJECTED' ? 'disabled' : '' }}>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_2_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_2_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_2_eng); ?></span>
                                                        </label>
                                                        <label class="form-check {{ $value->employee_rating == 3 ? 'checked' : '' }}">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="3" {{ $value->employee_rating == 3 ? 'checked' : '' }} {{ $appraisal->appraisal_status != 'DRAFT' && $appraisal->appraisal_status != 'REJECTED' ? 'disabled' : '' }}>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_3_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_3_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_3_eng); ?></span>
                                                        </label>
                                                        <label class="form-check {{ $value->employee_rating == 4 ? 'checked' : '' }}">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="4" {{ $value->employee_rating == 4 ? 'checked' : '' }} {{ $appraisal->appraisal_status != 'DRAFT' && $appraisal->appraisal_status != 'REJECTED' ? 'disabled' : '' }}>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_4_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_4_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_4_eng); ?></span>
                                                        </label>
                                                        <small class="text-danger"></small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @elseif(count($competency_template) > 0)
                                            @foreach($competency_template as $key => $value)
                                                <tr>
                                                    <input type="hidden" name="competency_new_id[]" value="{{ $value->competency_new_id }}">
                                                    <td style="text-align: center;">{{ $key+1 }}</td>
                                                    <td class="competency-name" data-eng="<?php echo "<b>$value->competency_title</b></br>".str_replace("\n", "<br>", $value->competency_eng); ?>" data-bhs="<?php echo "<b>$value->competency_title</b></br>".str_replace("\n", "<br>", $value->competency_bhs); ?>"><?php echo "<b>$value->competency_title</b></br>".str_replace("\n", "<br>", $value->competency_eng); ?></td>
                                                    <td class="form-group" style="vertical-align: middle;">
                                                        <label class="form-check">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="1">
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_1_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_1_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_1_eng); ?></span>
                                                        </label>
                                                        <label class="form-check">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="2">
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_2_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_2_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_2_eng); ?></span>
                                                        </label>
                                                        <label class="form-check">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="3">
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_3_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_3_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_3_eng); ?></span>
                                                        </label>
                                                        <label class="form-check">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="4">
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_4_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_4_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_4_eng); ?></span>
                                                        </label>
                                                        <small class="text-danger"></small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <!-- DRAFT BUTTON AND NEXT BUTTON -->
                                @if($appraisal == null || $appraisal->appraisal_status == 'DRAFT')
                                    <div class="w-100 d-flex mt-5">
                                        <button type="button" class="btn btn-primary btn-draft pt-3 pb-3" data-eng="Save as Draft" data-bhs="Simpan sebagai Draft" style="width: 175px;">Save as Draft</button>
                                        <button type="button" class="btn btn-info btn-next ml-auto pt-3 pb-3" data-target="personal_development" style="width: 175px;">Next</button>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="personal_development">
                                <div class="form-group">
                                    <label class="form-label mb-0" data-eng="Job & Personal Development" data-bhs="Pengembangan Diri & Pekerjaan">Job & Personal Development</label>
                                    <small class="text-muted" data-eng="List any areas, which with management’s help or specific training, could improve your overall performance and develop your competences and skills." data-bhs="Dalam bidang apa pun, yang dengan bantuan manajemen atau pelatihan khusus, dapat meningkatkan kinerja Anda secara keseluruhan dan mengembangkan kompetensi dan keterampilan Anda.">List any areas, which with management’s help or specific training, could improve your overall performance and develop your competences and skills.</small>
                                    <textarea name="personal_development_employee" class="form-control mt-2" rows="7" data-pl_eng="Type job & personal development.." data-pl_bhs="Isi pengembangan diri & pekerjaan.." placeholder="Type job & personal development.."{{ ($appraisal != null && $appraisal->appraisal_status != 'DRAFT' ? ' readonly' : '') }}>{{ $appraisal->personal_development_employee }}</textarea>
                                    <small class="text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-0" data-eng="Career Development & Ambitions" data-bhs="Pengembangan Karir & Ambisi">Career Development & Ambitions</label>
                                    <small class="text-muted" data-eng="Looking ahead, please indicate how you would like to see your present job and career development over the next five years' time frame." data-bhs="Ke depan, tunjukkan bagaimana Anda ingin melihat pekerjaan dan perkembangan karir Anda saat ini menuju lima tahun ke depan.">Looking ahead, please indicate how you would like to see your present job and career development over the next five years' time frame.</small>
                                    <textarea name="career_development_employee" class="form-control mt-2" rows="7" data-pl_eng="Type career development & ambitions.." data-pl_bhs="Isi pengembangan karir & ambisi.." placeholder="Type career development & ambitions.."{{ ($appraisal != null && $appraisal->appraisal_status != 'DRAFT' ? ' readonly' : '') }}>{{ $appraisal->career_development_employee }}</textarea>
                                    <small class="text-danger"></small>
                                </div>
                                <!-- DRAFT BUTTON AND NEXT BUTTON -->
                                @if($appraisal == null || $appraisal->appraisal_status == 'DRAFT')
                                    <div class="w-100 d-flex mt-5">
                                        <button type="button" class="btn btn-primary btn-draft pt-3 pb-3" data-eng="Save as Draft" data-bhs="Simpan sebagai Draft" style="width: 175px;">Save as Draft</button>
                                        <button type="button" class="btn btn-info btn-next ml-auto pt-3 pb-3" data-target="milestone_next" style="width: 175px;">Next</button>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="milestone_next">
                                <small class="text-muted">(To be complete by Employee and agreed by Superiors)</small><br>
                                <small class="text-muted">You must specify the Quantitative measurements & Timeline for each milestone.</small><br><br>
                                <div class="nav nav-pills d-flex" data-toggle="tabs" role="tablist" aria-orientation="horizontal">
                                    @if(count($milestone_template) > 0)
                                        @foreach($milestone_template as $key => $mlst_temp)
                                            <a href="#{{ str_replace(' ', '_', strtolower($mlst_temp->milestone_eng)) }}_next" class="nav-link{{ $key == 0 ? ' active' : '' }}" id="{{ str_replace(' ', '_', strtolower($mlst_temp->milestone_eng)) }}_next-pill" data-toggle="pill" role="tab" aria-controls="{{ str_replace(' ', '_', strtolower($mlst_temp->milestone_eng)) }}_next" aria-selected="true">
                                                <span class="numbering">{{ $key+1 }}</span> <span class="milestone-name" data-eng="{{ $mlst_temp->milestone_eng }}" data-bhs="{{ $mlst_temp->milestone_bhs }}">{{ $mlst_temp->milestone_eng }}</span>
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="tab-content mt-3">
                                    @if(count($milestone_template) > 0)
                                        @foreach($milestone_template as $key => $mlst_temp)
                                            <div class="tab-pane fade{{ $key == 0 ? ' show active' : '' }}" id="{{ str_replace(' ', '_', strtolower($mlst_temp->milestone_eng)) }}_next" role="tabpanel" aria-labelledby="{{ str_replace(' ', '_', strtolower($mlst_temp->milestone_eng)) }}_next-pill">
                                                <input type="hidden" name="milestone_id_next[]" value="{{ $mlst_temp->milestone_id }}">
                                                @if(count($milestone_next) > 0)
                                                    <?php $count = 0; ?>
                                                    @foreach($milestone_next as $obj_next)
                                                        @if($obj_next->milestone_id == null)
                                                            <div class="row mt-2">
                                                                <div style="flex: 0 0 auto; width: 48%;">
                                                                    <label class="form-label col-form-label" data-eng="Milestone Description" data-bhs="Deskripsi Milestone">Milestone Description</label>
                                                                    <textarea name="milestone_description_next[{{ $mlst_temp->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type milestone description.." data-pl_bhs="Isi deskripsi milestone.." placeholder="Type milestone description.."{{ ($appraisal != null && $appraisal->appraisal_status != 'DRAFT' ? ' readonly' : '') }}></textarea>
                                                                </div>
                                                                <div style="flex: 0 0 auto; width: 48%;">
                                                                    <label class="form-label col-form-label" data-eng="Milestone Measurement" data-bhs="Pencapaian Milestone">Milestone Measurement</label>
                                                                    <textarea name="milestone_measurement_next[{{ $mlst_temp->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type milestone measurement.." data-pl_bhs="Isi pencapaian milestone.." placeholder="Type milestone measurement.."{{ ($appraisal != null && $appraisal->appraisal_status != 'DRAFT' ? ' readonly' : '') }}></textarea>
                                                                </div>
                                                            </div>
                                                        @elseif($obj_next->milestone_id == $mlst_temp->milestone_id)
                                                            <?php $count++; ?>
                                                            <div class="row mt-2">
                                                                <input type="hidden" name="appraisal_milestone_next_detail_id[{{ $mlst_temp->milestone_id }}][]" value="{{ $obj_next->appraisal_milestone_next_detail_id }}">
                                                                <div style="flex: 0 0 auto; width: 48%;">
                                                                    @if($count == 1)
                                                                        <label class="form-label col-form-label" data-eng="Milestone Description" data-bhs="Deskripsi Milestone">Milestone Description</label>
                                                                    @endif
                                                                    <textarea name="milestone_description_next[{{ $mlst_temp->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type milestone description.." data-pl_bhs="Isi deskripsi milestone.." placeholder="Type milestone description.."{{ ($appraisal != null && $appraisal->appraisal_status != 'DRAFT' ? ' readonly' : '') }}><?php echo $obj_next->milestone_description; ?></textarea>
                                                                </div>
                                                                <div style="flex: 0 0 auto; width: 48%;">
                                                                    @if($count == 1)
                                                                        <label class="form-label col-form-label" data-eng="Milestone Measurement" data-bhs="Pencapaian Milestone">Milestone Measurement</label>
                                                                    @endif
                                                                    <textarea name="milestone_measurement_next[{{ $mlst_temp->milestone_id }}][]" class="form-control" rows="5" data-pl_eng="Type milestone measurement.." data-pl_bhs="Isi pencapaian milestone.." placeholder="Type milestone measurement.."{{ ($appraisal != null && $appraisal->appraisal_status != 'DRAFT' ? ' readonly' : '') }}><?php echo $obj_next->milestone_measurement; ?></textarea>
                                                                </div>
                                                                @if($count > 1 && $appraisal->appraisal_status == 'DRAFT')
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
                                                @if($count < 5 && $appraisal->appraisal_status == 'DRAFT')
                                                    <a href="javascript:;" class="btn btn-secondary btn-add-point-next mt-2" data-id="{{ $mlst_temp->milestone_id }}" data-mlst="{{ str_replace(' ', '_', strtolower($mlst_temp->milestone_eng)) }}" data-count="{{ $count == 0 ? 1 : $count }}">
                                                        <i class="fa fa-plus"></i>
                                                        <span data-eng="Add More Point" data-bhs="Tambah Point"> Add More Point </span>
                                                    </a>
                                                @endif

                                                <!-- DRAFT BUTTON AND NEXT BUTTON -->
                                                @if($appraisal == null || $appraisal->appraisal_status == 'DRAFT')
                                                    <div class="w-100 d-flex mt-5">
                                                        <button type="button" class="btn btn-primary btn-draft pt-3 pb-3" data-eng="Save as Draft" data-bhs="Simpan sebagai Draft" style="width: 175px;">Save as Draft</button>
                                                        @if($key != count($milestone_template)-1)
                                                            <button type="button" class="btn btn-info btn-next ml-auto pt-3 pb-3" data-target="{{ str_replace(' ', '_', strtolower($milestone_template[$key+1]->milestone_eng)) }}_next" style="width: 175px;">Next</button>
                                                        @else
                                                            <button type="button" class="btn btn-success ml-auto pt-3 pb-3" id="btn-submit" data-eng="Submit to Superior" data-bhs="Ajukan ke Atasan" style="width: 175px;">Submit to Superior</button>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            @if($appraisal == null || $appraisal->appraisal_status == 'DRAFT')
                                <!-- <div class="w-100 d-flex mt-5">
                                    <button type="button" class="btn btn-primary btn-draft pt-3 pb-3" data-eng="Save as Draft" data-bhs="Simpan sebagai Draft" style="width: 175px;">Save as Draft</button>
                                    <button type="button" class="btn btn-success btn-submit ml-auto pt-3 pb-3" data-eng="Submit to Superior" data-bhs="Ajukan ke Atasan" style="width: 175px;">Submit to Superior</button>
                                </div> -->
                            @endif
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
@endsection

@section('assets-bottom')
<script type="text/javascript">
	
	$(document).ready(function() {

        $('.nav-appraisal_form').addClass('active');

        $('#language').bootstrapSwitch({
            onText : 'INA',
            offText : 'ENG',
            offColor : 'primary'
        });

        $('.select2-hide-search').select2({
            theme : 'bootstrap4',
            minimumResultsForSearch : Infinity
        });

        $(document).on('switchChange.bootstrapSwitch', '#language', function(event, state) {
            if(state) {
                $('input[name=language]').val('ina');
                $('.nav-tabs .nav-link, .milestone-name, .competency-name, th, h5, label, small, span, button').each(function(index) {
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
                $('.nav-tabs .nav-link, .milestone-name, .competency-name, th, h5, label, small, span, button').each(function(index) {
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

        $(document).on('click', '.btn-add-point', function(e) {
            var id = e.currentTarget.dataset.id;
            var mlst = e.currentTarget.dataset.mlst;
            var count = parseInt(e.currentTarget.dataset.count);

            var html = '';
            if($('input[name=language]').val() == 'eng') {
                html = '<div class="row mt-2">'+
                    '<div style="flex: 0 0 auto; width: 32%;">'+
                        '<textarea name="milestone_description['+id+'][]" class="form-control" rows="5" data-pl_eng="Type milestone description.." data-pl_bhs="Isi deskripsi milestone.." placeholder="Type milestone description.."></textarea>'+
                    '</div><div style="flex: 0 0 auto; width: 32%;">'+
                        '<textarea name="milestone_measurement['+id+'][]" class="form-control" rows="5" data-pl_eng="Type milestone measurement.." data-pl_bhs="Isi pencapaian milestone.." placeholder="Type milestone measurement.."></textarea>'+
                    '</div><div style="flex: 0 0 auto; width: 32%;">'+
                        '<textarea name="employee_assessment['+id+'][]" class="form-control" rows="5" data-pl_eng="Type employee assessment.." data-pl_bhs="Isi penilaian karyawan.." placeholder="Type employee assessment.."></textarea>'+
                    '</div><div style="flex: 0 0 auto; width: 4%; padding-top: 40px; text-align: center;">'+
                        '<a href="javascript:;" class="text-danger btn-delete-point" data-mlst="'+mlst+'" style="font-size: 20px;"><i class="fa fa-minus-circle"></i></a>'+
                    '</div></div>';
            } else if($('input[name=language]').val() == 'ina') {
                html = '<div class="row mt-2">'+
                    '<div style="flex: 0 0 auto; width: 32%;">'+
                        '<textarea name="milestone_description['+id+'][]" class="form-control" rows="5" data-pl_eng="Type milestone description.." data-pl_bhs="Isi deskripsi milestone.." placeholder="Isi deskripsi milestone.."></textarea>'+
                    '</div><div style="flex: 0 0 auto; width: 32%;">'+
                        '<textarea name="milestone_measurement['+id+'][]" class="form-control" rows="5" data-pl_eng="Type milestone measurement.." data-pl_bhs="Isi pencapaian milestone.." placeholder="Isi pencapaian milestone.."></textarea>'+
                    '</div><div style="flex: 0 0 auto; width: 32%;">'+
                        '<textarea name="employee_assessment['+id+'][]" class="form-control" rows="5" data-pl_eng="Type employee assessment.." data-pl_bhs="Isi penilaian karyawan.." placeholder="Isi penilaian karyawan.."></textarea>'+
                    '</div><div style="flex: 0 0 auto; width: 4%; padding-top: 40px; text-align: center;">'+
                        '<a href="javascript:;" class="text-danger btn-delete-point" data-mlst="'+mlst+'" style="font-size: 20px;"><i class="fa fa-minus-circle"></i></a>'+
                    '</div></div>';
            }

            if(count == 4) {
                $(this).parents('.tab-pane#'+mlst).find('.added-milestone-point').append(html);
                $(this).attr('data-count', (count+1));
                $(this).hide();
            } else if(count < 5) {
                $(this).parents('.tab-pane#'+mlst).find('.added-milestone-point').append(html);
                $(this).attr('data-count', (count+1));
            }
        });

        $(document).on('click', '.btn-add-point-next', function(e) {
            var id = e.currentTarget.dataset.id;
            var mlst = e.currentTarget.dataset.mlst;
            var count = parseInt(e.currentTarget.dataset.count);

            var html = '';
            if($('input[name=language]').val() == 'eng') {
                html = '<div class="row mt-2">'+
                    '<input type="hidden" name="appraisal_milestone_next_detail_id['+id+'][]">'+
                    '<div style="flex: 0 0 auto; width: 48%;">'+
                        '<textarea name="milestone_description_next['+id+'][]" class="form-control" rows="5" data-pl_eng="Type milestone description.." data-pl_bhs="Isi deskripsi milestone.." placeholder="Type milestone description.."></textarea>'+
                    '</div><div style="flex: 0 0 auto; width: 48%;">'+
                        '<textarea name="milestone_measurement_next['+id+'][]" class="form-control" rows="5" data-pl_eng="Type milestone measurement.." data-pl_bhs="Isi pencapaian milestone.." placeholder="Type milestone measurement.."></textarea>'+
                    '</div><div style="flex: 0 0 auto; width: 4%; padding-top: 40px; text-align: center;">'+
                        '<a href="javascript:;" class="text-danger btn-delete-point" data-mlst="'+mlst+'" style="font-size: 20px;"><i class="fa fa-minus-circle"></i></a>'+
                    '</div></div>';
            } else if($('input[name=language]').val() == 'ina') {
                html = '<div class="row mt-2">'+
                    '<input type="hidden" name="appraisal_milestone_next_detail_id['+id+'][]">'+
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

        $(document).on('change input keyup', 'select, textarea', function(e) {
            $(this).removeClass('is-invalid');
            $(this).parents('.form-group').find('.text-danger').html('');
        });

        $(document).on('change', '.form-check-input', function(e) {
            if($(this).is(':checked')) {
                $(this).closest('td').find('.form-check').removeClass('checked');
                $(this).closest('.form-check').addClass('checked');
                $(this).closest('.form-group').find('.text-danger').html('');
            }
        });

        $(document).on('click', '.btn-next', function(e) {
            $('a[href="#'+e.currentTarget.dataset.target+'"]').tab('show');
        });

        $(document).on('click', '.btn-draft', function(e) {
            e.preventDefault();

            $('input[name=appraisal_status]').val('DRAFT');

            $('form').submit();
        });

        $(document).on('click', '#btn-submit', function(e) {
            e.preventDefault();

            var status = 'ok';

            $.each($('textarea.employee_assessment'), function(index) {
                if($(this).val() == '') {
                    $(this).addClass('is-invalid');
                    $(this).closest('.form-group').find('.text-danger').html('Please Fill Employee Assessment');

                    if(status == 'ok') {
                        $('a[href="#milestone"]').tab('show');
                        $('a[href="#'+$(this).data('mlst')+'"]').tab('show');
                    }

                    status = 'err';
                } else if($(this).val().length <= 10) {
                    $(this).addClass('is-invalid');
                    $(this).closest('.form-group').find('.text-danger').html('Employee Assessment must be at least 10 characters');

                    if(status == 'ok') {
                        $('a[href="#milestone"]').tab('show');
                        $('a[href="#'+$(this).data('mlst')+'"]').tab('show');
                    }

                    status = 'err';
                }
            });

            @foreach($competency_template as $key => $val)
                var x = false;
                $.each($('input[name="employee_rating[{{ $key }}]"]'), function(index) {
                    if($(this).is(':checked')) {
                        x = true;
                    }
                });

                if(x == false) {
                    $('input[name="employee_rating[{{ $key }}]"]').closest('.form-group').find('.text-danger').html('Please Select A Rating');

                    if(status == 'ok') {
                        $('a[href="#competencies"]').tab('show');
                    }

                    status = 'err';
                }
            @endforeach

            if($('textarea[name=personal_development_employee]').val() == '') {
                $('textarea[name=personal_development_employee]').addClass('is-invalid');
                $('textarea[name=personal_development_employee]').parents('.form-group').find('.text-danger').html('Please Fill Job & Personal Development');

                if(status == 'ok') {
                    $('a[href="#personal_development"]').tab('show');
                }

                status = 'err';
            }

            if($('textarea[name=career_development_employee]').val() == '') {
                $('textarea[name=career_development_employee]').addClass('is-invalid');
                $('textarea[name=career_development_employee]').parents('.form-group').find('.text-danger').html('Please Fill Career Development & Ambitions');

                if(status == 'ok') {
                    $('a[href="#personal_development"]').tab('show');
                }

                status = 'err';
            }

            if(status == 'ok') {
                $('input[name=appraisal_status]').val('IN PROGRESS');

                Swal.fire({
                    title : 'Submit this Appraisal Form?',
                    type : 'warning',
                    showCancelButton : true,
                    confirmButtonText : 'Yes, Submit',
                    reverseButtons : true
                }).then((result) => {
                    if(result.value) {
                        $('form').submit();
                    }
                });
            }
        });

        $(document).on('submit', 'form', function(e) {
            e.preventDefault();

            $.ajax({
                type : "POST",
                url : "{{ url('api/appraisal/form') }}",
                data : $('form').serialize(),
                beforeSend : function() {
                    $('.se-pre-con').fadeIn();
                },
                success : function(res) {
                    if(res[0] == 'Saved as Draft') {
                        $('.se-pre-con').fadeOut();
                        toastr.success('Saved as Draft!', 'Success', { "closeButton": true });
                    } else if(res[0] == 'Submitted to Superior') {
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
                                    title : 'Submitted',
                                    type : 'success'
                                }).then((result) => {
                                    window.location.href = "{{ url('/appraisal/status') }}";
                                });
                            },
                            error : function(jqXhr, errorThrown, textStatus) {
                                $('.se-pre-con').fadeOut();

                                Swal.fire({
                                    title : 'Submitted',
                                    text : 'Failed to Send Email Notification',
                                    type : 'success'
                                }).then((result) => {
                                    window.location.href = "{{ url('/appraisal/status') }}";
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
        });

	});

</script>
@endsection