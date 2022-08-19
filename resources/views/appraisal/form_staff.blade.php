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
            <!-- ALERT -->
            @if($appraisal->appraisal_status == 'REJECTED')
                <div class="alert alert-danger">
                    <h4><span data-eng="Your Appraisal is <b>REJECTED</b> by <b>{{ $appraisal->updated_by }}</b> with note :" data-bhs="Appraisal Anda <b>DITOLAK</b> oleh <b>{{ $appraisal->updated_by }}</b> dengan catatan :">Appraisal Anda <b>DITOLAK</b> oleh <b>{{ $appraisal->updated_by }}</b> dengan catatan :</span></h4>
                    <div class="alert-content">{{ $appraisal->appraisal_approval_reject_note }}</div>
                </div>
            @endif
            <!-- END ALERT -->
            <div class="card">
                <div class="row pt-3 pl-3 pr-3" style="width: 100%;">
                    <div class="col-md-10">
                        <ul class="nav nav-tabs" data-toggle="tabs">
                            <li class="nav-item">
                                <a href="#objective" class="nav-link active" data-toggle="tab" data-eng="Objective / Work Area" data-bhs="Objective / Area Kerja">Objective / Area Kerja</a>
                            </li>
                            <li class="nav-item">
                                <a href="#competencies" class="nav-link" data-toggle="tab" data-eng="Competencies" data-bhs="Kompetensi">Kompetensi</a>
                            </li>
                            <li class="nav-item">
                                <a href="#objective_next" class="nav-link" data-toggle="tab" data-eng="Objective / KPI Next Year" data-bhs="Objective / KPI Tahun Depan">Objective / KPI Tahun Depan</a>
                            </li>
                            <li class="nav-item">
                                <a href="#personal_development" class="nav-link" data-toggle="tab" data-eng="Personal Development" data-bhs="Pengembangan Diri">Pengembangan Diri</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-2 text-right">
                        <input type="checkbox" id="language" value="1" data-bootstrap-switch>
                        <input type="hidden" name="language" value="ina">
                    </div>
                </div>
                <div class="card-body">
                    <form class="p-2" method="post">
                        {{ csrf_field() }}
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="objective">
                                <h5 class="font-weight-bold mb-1" data-eng="Guide to Objective Review :" data-bhs="Petunjuk Penilaian Objective :">Petunjuk Penilaian Objective :</h5>
                                <div class="row m-0">
                                    <small class="font-weight-bold" style="flex: 0 0 auto; width: 3%;">I.</small>
                                    <small class="font-weight-bold" style="flex: 0 0 auto; width: 90%;" data-eng="Objective / KPI" data-bhs="Objective / Area Kerja">Objective / Area Kerja</small>
                                </div>
                                <div class="row m-0">
                                    <small style="flex: 0 0 auto; width: 3%;"></small>
                                    <small style="flex: 0 0 auto; width: 90%;" data-eng="To be filled out by the employee based on the main work area / main job description." data-bhs="Diisi oleh karyawan yang bersangkutan berdasarkan area kerja utama / uraian kerja utama.">Diisi oleh karyawan yang bersangkutan berdasarkan area kerja utama / uraian kerja utama.</small>
                                </div>
                                <div class="row m-0">
                                    <small class="font-weight-bold" style="flex: 0 0 auto; width: 3%;">II.</small>
                                    <small class="font-weight-bold" style="flex: 0 0 auto; width: 90%;" data-eng="Employee's assessment regarding the achievement of the Objective / KPI" data-bhs="Penilaian karyawan mengenai pencapaian Objective / Area Kerja">Penilaian karyawan mengenai pencapaian Objective / Area Kerja</small>
                                </div>
                                <div class="row m-0 mb-1">
                                    <small style="flex: 0 0 auto; width: 3%;"></small>
                                    <small style="flex: 0 0 auto; width: 90%;" data-eng="Filled with measurable work results (Qualitative / Quantitative)." data-bhs="Diisi dengan hasil kerja yang dapat terukur (Kualitatif / Kuantitatif).">Diisi dengan hasil kerja yang dapat terukur (Kualitatif / Kuantitatif).</small>
                                </div>
                                <small class="font-weight-bold mb-1" data-eng="Example :" data-bhs="Contoh :">Contoh :</small>
                                <table class="table table-sm table-bordered" style="width: 80%;">
                                    <thead>
                                        <tr>
                                            <th data-eng="Objective / Work Area" data-bhs="Objective / Area Kerja">Objective / Area Kerja</th>
                                            <th data-eng="Employee's Assessment Regarding Achievement of Objective / Work Area" data-bhs="Penilaian Karyawan Mengenai Pencapaian Objective / KPI">Penilaian Karyawan Mengenai Pencapaian Objective / Area Kerja</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><small data-eng="Vehicle Maintenance" data-bhs="Perawatan Kendaraan">Perawatan Kendaraan</small></td>
                                            <td><small data-eng="1. Always carry out regular vehicle inspections and maintenance every 2 weeks<br>2. In 1 year only 2 times damage to operational vehicles" data-bhs="1. Selalu melakukan pemeriksaan dan perawatan kendaraan secara berkala 2 minggu sekali<br>2. Dalam 1 tahun hanya terjadi 2 kali kerusakan pada kendaraan operasional">1. Selalu melakukan pemeriksaan dan perawatan kendaraan secara berkala 2 minggu sekali<br>2. Dalam 1 tahun hanya terjadi 2 kali kerusakan pada kendaraan operasional</small></td>
                                        </tr>
                                    </tbody>
                                </table>
                                @if(count($objective) > 0) 
                                    @foreach($objective as $key => $value)
                                        <div class="row objective-point">
                                            <div class="form-group" style="flex: 0 0 auto; width: 48%;">
                                                @if($key == 0) <label class="form-label" data-eng="Objective / Work Area" data-bhs="Objective / Area Kerja">Objective / Area Kerja</label> @endif
                                                <textarea name="objective_description[]" class="form-control" rows="5" data-pl_eng="Type objective description.." data-pl_bhs="Isi deskripsi objective.." placeholder="Isi deskripsi objective.."{{ ($appraisal->appraisal_status != 'DRAFT' && $appraisal->appraisal_status != 'REJECTED' ? ' readonly' : '') }}>{{ $value->objective_description }}</textarea>
                                                <small class="text-danger"></small>
                                            </div>
                                            <div class="form-group" style="flex: 0 0 auto; width: 48%;">
                                                @if($key == 0) <label class="form-label" data-eng="Employee's Assessment" data-bhs="Penilaian Karyawan">Penilaian Karyawan</label> @endif
                                                <textarea name="employee_assessment[]" class="form-control" rows="5" data-pl_eng="Type employee assessment.." data-pl_bhs="Isi penilaian karyawan.." placeholder="Isi penilaian karyawan.."{{ ($appraisal->appraisal_status != 'DRAFT' && $appraisal->appraisal_status != 'REJECTED' ? ' readonly' : '') }}>{{ $value->employee_assessment }}</textarea>
                                                <small class="text-danger"></small>
                                            </div>
                                            @if($key > 0 && ($appraisal->appraisal_status == 'DRAFT' || $appraisal->appraisal_status == 'REJECTED'))
                                                <div style="flex: 0 0 auto; width: 4%; padding-top: 40px; text-align: center;">
                                                    <a href="javascript:;" class="text-danger btn-delete-point" style="font-size: 20px;"><i class="fa fa-minus-circle"></i></a>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @elseif(count($objective_from_last_year) > 0)
                                    @foreach($objective_from_last_year as $key => $value)
                                        <div class="row objective-point">
                                            <div class="form-group" style="flex: 0 0 auto; width: 48%;">
                                                @if($key == 0) <label class="form-label" data-eng="Objective / Work Area" data-bhs="Objective / Area Kerja">Objective / Area Kerja</label> @endif
                                                <textarea name="objective_description[]" class="form-control" rows="5" data-pl_eng="Type objective description.." data-pl_bhs="Isi deskripsi objective.." placeholder="Isi deskripsi objective..">{{ $value->objective_next_description }}</textarea>
                                                <small class="text-danger"></small>
                                            </div>
                                            <div class="form-group" style="flex: 0 0 auto; width: 48%;">
                                                @if($key == 0) <label class="form-label" data-eng="Employee's Assessment" data-bhs="Penilaian Karyawan">Penilaian Karyawan</label> @endif
                                                <textarea name="employee_assessment[]" class="form-control" rows="5" data-pl_eng="Type employee assessment.." data-pl_bhs="Isi penilaian karyawan.." placeholder="Isi penilaian karyawan.."></textarea>
                                                <small class="text-danger"></small>
                                            </div>
                                            @if($key > 0)
                                                <div style="flex: 0 0 auto; width: 4%; padding-top: 40px; text-align: center;">
                                                    <a href="javascript:;" class="text-danger btn-delete-point" style="font-size: 20px;"><i class="fa fa-minus-circle"></i></a>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row">
                                        <div class="form-group" style="flex: 0 0 auto; width: 48%;">
                                        <label class="form-label" data-eng="Objective / Work Area" data-bhs="Objective / Area Kerja">Objective / Area Kerja</label>
                                            <textarea name="objective_description[]" class="form-control" rows="5" data-pl_eng="Type objective description.." data-pl_bhs="Isi deskripsi objective.." placeholder="Isi deskripsi objective.."{{ ($appraisal->appraisal_status != 'DRAFT' && $appraisal->appraisal_status != 'REJECTED' ? ' readonly' : '') }}></textarea>
                                            <small class="text-danger"></small>
                                        </div>
                                        <div class="form-group" style="flex: 0 0 auto; width: 48%;">
                                            <label class="form-label" data-eng="Employee's Assessment" data-bhs="Penilaian Karyawan">Penilaian Karyawan</label>
                                            <textarea name="employee_assessment[]" class="form-control" rows="5" data-pl_eng="Type employee assessment.." data-pl_bhs="Isi penilaian karyawan.." placeholder="Isi penilaian karyawan.."{{ ($appraisal->appraisal_status != 'DRAFT' && $appraisal->appraisal_status != 'REJECTED' ? ' readonly' : '') }}></textarea>
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>
                                @endif
                                <div class="added-objective-point"></div>
                                @if($appraisal->appraisal_status == 'DRAFT' || $appraisal->appraisal_status == 'REJECTED')
                                    <a href="javascript:;" class="btn btn-secondary btn-add-point mt-2">
                                        <i class="fa fa-plus"></i>
                                        <span data-eng="Add More Point" data-bhs="Tambah Point"> Tambah Point </span>
                                    </a>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="competencies">
                                <h5 class="font-weight-bold mb-1" data-eng="Guide to Competencies Review :" data-bhs="Petunjuk Penilaian Kompetensi :">Petunjuk Penilaian Kompetensi :</h5>
                                <div class="row m-0">
                                    <small style="flex: 0 0 auto; width: 3%;">I.</small>
                                    <small style="flex: 0 0 auto; width: 90%;" data-eng="Self Assessment of competency is filled with reference to the 4 levels of proficiency in the options provided." data-bhs="Penilaian kompetensi oleh diri sendiri diisi dengan mengacu pada 4 level kemahiran pada pilihan yang telah disediakan.">Penilaian kompetensi oleh diri sendiri diisi dengan mengacu pada 4 level kemahiran pada pilihan yang telah disediakan.</small>
                                </div>
                                <div class="row m-0">
                                    <small style="flex: 0 0 auto; width: 3%;">II.</small>
                                    <small style="flex: 0 0 auto; width: 90%;" data-eng="Proficiency levels are arranged by category Basic (first choice) and Expert (last choice)." data-bhs="Level kemahiran disusun berdasarkan kategori Basic (pilihan pertama) dan Expert (pilihan terakhir).">Level kemahiran disusun berdasarkan kategori Basic (pilihan pertama) dan Expert (pilihan terakhir).</small>
                                </div>
                                <div class="row m-0">
                                    <small style="flex: 0 0 auto; width: 3%;">III.</small>
                                    <small style="flex: 0 0 auto; width: 90%;" data-eng="Assessment is done by looking at the suitability of your abilities/skills in completing the work." data-bhs="Penilaian dilakukan dengan melihat kesesuaian kemampuan/keahlian Anda dalam menyelesaikan pekerjaan.">Penilaian dilakukan dengan melihat kesesuaian kemampuan/keahlian Anda dalam menyelesaikan pekerjaan.</small>
                                </div>
                                <table class="table table-bordered table-striped mt-2">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center; width: 50px;"> No </th>
                                            <th style="width: 35%;" data-eng="Competency" data-bhs="Kompetensi"> Kompetensi </th>
                                            <th data-eng="Proficiency Level Assessment from Employee" data-bhs="Penilaian Tingkat Kemahiran dari Karyawan"> Penilaian Tingkat Kemahiran dari Karyawan </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($competency) > 0)
                                            @foreach($competency as $key => $value)
                                                <tr>
                                                    <input type="hidden" name="competency_staff_id[]" value="{{ $value->competency_staff_id }}">
                                                    <td style="text-align: center;">{{ $key+1 }}</td>
                                                    <td class="competency-name" data-eng="<?php echo "<b>$value->competency_title_eng</b></br>".str_replace("\n", "<br>", $value->competency_eng); ?>" data-bhs="<?php echo "<b>$value->competency_title_eng</b></br>".str_replace("\n", "<br>", $value->competency_bhs); ?>"><?php echo "<b>$value->competency_title_eng</b></br>".str_replace("\n", "<br>", $value->competency_bhs); ?></td>
                                                    <td class="form-group" style="vertical-align: middle;">
                                                        <label class="form-check {{ $value->employee_rating == 1 ? 'checked' : '' }}">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="1" {{ $value->employee_rating == 1 ? 'checked' : '' }} {{ $appraisal->appraisal_status != 'DRAFT' && $appraisal->appraisal_status != 'REJECTED' ? 'disabled' : '' }}>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_1_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_1_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_1_bhs); ?></span>
                                                        </label>
                                                        <label class="form-check {{ $value->employee_rating == 2 ? 'checked' : '' }}">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="2" {{ $value->employee_rating == 2 ? 'checked' : '' }} {{ $appraisal->appraisal_status != 'DRAFT' && $appraisal->appraisal_status != 'REJECTED' ? 'disabled' : '' }}>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_2_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_2_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_2_bhs); ?></span>
                                                        </label>
                                                        <label class="form-check {{ $value->employee_rating == 3 ? 'checked' : '' }}">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="3" {{ $value->employee_rating == 3 ? 'checked' : '' }} {{ $appraisal->appraisal_status != 'DRAFT' && $appraisal->appraisal_status != 'REJECTED' ? 'disabled' : '' }}>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_3_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_3_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_3_bhs); ?></span>
                                                        </label>
                                                        <label class="form-check {{ $value->employee_rating == 4 ? 'checked' : '' }}">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="4" {{ $value->employee_rating == 4 ? 'checked' : '' }} {{ $appraisal->appraisal_status != 'DRAFT' && $appraisal->appraisal_status != 'REJECTED' ? 'disabled' : '' }}>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_4_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_4_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_4_bhs); ?></span>
                                                        </label>
                                                        <small class="text-danger"></small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @elseif(count($competency_template) > 0)
                                            @foreach($competency_template as $key => $value)
                                                <tr>
                                                    <input type="hidden" name="competency_staff_id[]" value="{{ $value->competency_staff_id }}">
                                                    <td style="text-align: center;">{{ $key+1 }}</td>
                                                    <td class="competency-name" data-eng="<?php echo "<b>$value->competency_title_eng</b></br>".str_replace("\n", "<br>", $value->competency_eng); ?>" data-bhs="<?php echo "<b>$value->competency_title_eng</b></br>".str_replace("\n", "<br>", $value->competency_bhs); ?>"><?php echo "<b>$value->competency_title_eng</b></br>".str_replace("\n", "<br>", $value->competency_bhs); ?></td>
                                                    <td class="form-group" style="vertical-align: middle;">
                                                        <label class="form-check">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="1">
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_1_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_1_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_1_bhs); ?></span>
                                                        </label>
                                                        <label class="form-check">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="2">
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_2_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_2_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_2_bhs); ?></span>
                                                        </label>
                                                        <label class="form-check">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="3">
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_3_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_3_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_3_bhs); ?></span>
                                                        </label>
                                                        <label class="form-check">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="4">
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_4_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_4_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_4_bhs); ?></span>
                                                        </label>
                                                        <small class="text-danger"></small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="objective_next">
                                <h5 class="font-weight-bold mb-1" data-eng="Guide to Objective / KPI Next Year :" data-bhs="Petunjuk Pengisian Objective / KPI Tahun Depan :">Petunjuk Pengisian Objective / KPI Tahun Depan :</h5>
                                <small data-eng="To be filled out by the employee based on the main work area / main job description to be carried out / target for next year." data-bhs="Diisi oleh karyawan yang bersangkutan berdasarkan area kerja utama / uraian kerja utama yang akan dilakukan / target untuk tahun depan.">Diisi oleh karyawan yang bersangkutan berdasarkan area kerja utama / uraian kerja utama yang akan dilakukan / target untuk tahun depan.</small>
                                <br><br>
                                @if(count($objective_next) > 0) 
                                    @foreach($objective_next as $key => $value)
                                        <div class="row objective-point">
                                            <div class="form-group" style="flex: 0 0 auto; width: 96%;">
                                                @if($key == 0) <label class="form-label">Objective / KPI</label> @endif
                                                <textarea name="objective_next_description[]" class="form-control" rows="5" data-pl_eng="Type objective description.." data-pl_bhs="Isi deskripsi objective.." placeholder="Isi deskripsi objective.."{{ ($appraisal->appraisal_status != 'DRAFT' && $appraisal->appraisal_status != 'REJECTED' ? ' readonly' : '') }}>{{ $value->objective_next_description }}</textarea>
                                                <small class="text-danger"></small>
                                            </div>
                                            @if($key > 0 && ($appraisal->appraisal_status == 'DRAFT' || $appraisal->appraisal_status == 'REJECTED'))
                                                <div style="flex: 0 0 auto; width: 4%; padding-top: 40px; text-align: center;">
                                                    <a href="javascript:;" class="text-danger btn-delete-point" style="font-size: 20px;"><i class="fa fa-minus-circle"></i></a>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row">
                                        <div class="form-group" style="flex: 0 0 auto; width: 96%;">
                                            <label class="form-label">Objective / KPI</label>
                                            <textarea name="objective_next_description[]" class="form-control" rows="5" data-pl_eng="Type objective description.." data-pl_bhs="Isi deskripsi objective.." placeholder="Isi deskripsi objective.."{{ ($appraisal->appraisal_status != 'DRAFT' && $appraisal->appraisal_status != 'REJECTED' ? ' readonly' : '') }}></textarea>
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>
                                @endif
                                <div class="added-objective-next-point"></div>
                                @if($appraisal->appraisal_status == 'DRAFT' || $appraisal->appraisal_status == 'REJECTED')
                                    <a href="javascript:;" class="btn btn-secondary btn-add-point-next mt-2">
                                        <i class="fa fa-plus"></i>
                                        <span data-eng="Add More Point" data-bhs="Tambah Point"> Tambah Point </span>
                                    </a>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="personal_development">
                                <div class="form-group">
                                    <label class="form-label mb-0" data-eng="Skills Development Needs for Employees" data-bhs="Kebutuhan Pengembangan Keahlian/Keterampilan bagi Karyawan">Kebutuhan Pengembangan Keahlian/Keterampilan bagi Karyawan</label>
                                    <textarea name="training_employee" class="form-control mt-2" rows="7" data-pl_eng="Type skills development needs for employees.." data-pl_bhs="Isi kebutuhan pengembangan keahlian/keterampilan bagi karyawan.." placeholder="Isi kebutuhan pengembangan keahlian/keterampilan bagi karyawan.."{{ ($appraisal->appraisal_status != 'DRAFT' && $appraisal->appraisal_status != 'REJECTED' ? ' readonly' : '') }}>{{ $appraisal->training_employee }}</textarea>
                                    <small class="text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-0" data-eng="Career Development for Employees" data-bhs="Pengembangan Karir Karyawan">Pengembangan Karir Karyawan</label>
                                    <textarea name="career_development_employee" class="form-control mt-2" rows="7" data-pl_eng="Type career development for employees.." data-pl_bhs="Isi pengembangan karir karyawan.." placeholder="Isi pengembangan karir karyawan.."{{ ($appraisal->appraisal_status != 'DRAFT' && $appraisal->appraisal_status != 'REJECTED' ? ' readonly' : '') }}>{{ $appraisal->career_development_employee }}</textarea>
                                    <small class="text-danger"></small>
                                </div>
                            </div>
                            @if($appraisal->appraisal_status == 'DRAFT' || $appraisal->appraisal_status == 'REJECTED')
                                <div class="w-100 d-flex mt-5">
                                    <input type="hidden" name="appraisal_status">
                                    <button type="button" class="btn btn-primary pt-3 pb-3" id="btn-draft" data-eng="Save as Draft" data-bhs="Simpan sebagai Draft" style="width: 175px;">Simpan sebagai Draft</button>
                                    <button type="button" class="btn btn-success ml-auto pt-3 pb-3" id="btn-submit" data-eng="Submit to Superior" data-bhs="Ajukan ke Atasan" style="width: 175px;">Ajukan ke Atasan</button>
                                </div>
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
            onText : 'ENG',
            offText : 'INA',
            offColor : 'primary'
        });

        $('.select2-hide-search').select2({
            theme : 'bootstrap4',
            minimumResultsForSearch : Infinity
        });

        $(document).on('switchChange.bootstrapSwitch', '#language', function(event, state) {
            if(!state) {
                $('input[name=language]').val('ina');
                $('.nav-tabs .nav-link, .competency-name, th, h5, label, small, span, button').each(function(index) {
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
                $('.nav-tabs .nav-link, .competency-name, th, h5, label, small, span, button').each(function(index) {
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
            var lang = $('input[name=language]').val();

            var html = '<div class="row objective-point">'+
                    '<div class="form-group" style="flex: 0 0 auto; width: 48%;">'+
                        '<textarea name="objective_description[]" class="form-control" rows="5" data-pl_eng="Type objective description.." data-pl_bhs="Isi deskripsi objective.." placeholder="'+(lang == 'ina' ? 'Isi deskripsi objective..' : 'Type objective description..')+'"></textarea>'+
                    '</div><div class="form-group" style="flex: 0 0 auto; width: 48%;">'+
                        '<textarea name="employee_assessment[]" class="form-control" rows="5" data-pl_eng="Type employee assessment.." data-pl_bhs="Isi penilaian karyawan.." placeholder="'+(lang == 'ina' ? 'Isi penilaian karyawan..' : 'Type employee assessment..')+'"></textarea>'+
                    '</div><div style="flex: 0 0 auto; width: 4%; padding-top: 40px; text-align: center;">'+
                        '<a href="javascript:;" class="text-danger btn-delete-point" style="font-size: 20px;"><i class="fa fa-minus-circle"></i></a>'+
                    '</div>'+
                '</div>';

            $('.added-objective-point').append(html);
        });

        $(document).on('click', '.btn-add-point-next', function(e) {
            var id = e.currentTarget.dataset.id;
            var lang = $('input[name=language]').val();

            var html = '<div class="row objective-point">'+
                    '<div class="form-group" style="flex: 0 0 auto; width: 96%;">'+
                        '<textarea name="objective_next_description[]" class="form-control" rows="5" data-pl_eng="Type objective description.." data-pl_bhs="Isi deskripsi objective.." placeholder="'+(lang == 'ina' ? 'Isi deskripsi objective..' : 'Type objective description..')+'"></textarea>'+
                    '</div><div style="flex: 0 0 auto; width: 4%; padding-top: 40px; text-align: center;">'+
                        '<a href="javascript:;" class="text-danger btn-delete-point" style="font-size: 20px;"><i class="fa fa-minus-circle"></i></a>'+
                    '</div>'+
                '</div>';

            $('.added-objective-next-point').append(html);
        });

        $(document).on('click', '.btn-delete-point', function(e) {
            $(this).parents('.row.objective-point').remove();
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

        $(document).on('click', '#btn-draft', function(e) {
            e.preventDefault();

            $('input[name=appraisal_status]').val('DRAFT');

            $('form').submit();
        });

        $(document).on('click', '#btn-submit', function(e) {
            e.preventDefault();

            var status = 'ok';

            $.each($('textarea[name="objective_description[]"]'), function(index) {
                if(index == 0) {
                    if($(this).val() == '') {
                        $(this).addClass('is-invalid');
                        $(this).closest('.form-group').find('.text-danger').html('Please Fill Objective Description');
                        $('a[href="#objective"]').tab('show');
                        status = 'err';
                    }
                }
            });
            
            $.each($('textarea[name="employee_assessment[]"]'), function(index) {
                if(index == 0) {
                    if($(this).val() == '') {
                        $(this).addClass('is-invalid');
                        $(this).closest('.form-group').find('.text-danger').html('Please Fill Employee Assessment');
                        $('a[href="#objective"]').tab('show');
                        status = 'err';
                    } else if($(this).val().length <= 10) {
                        $(this).addClass('is-invalid');
                        $(this).closest('.form-group').find('.text-danger').html('Employee Assessment must be at least 10 characters');
                        $('a[href="#objective"]').tab('show');
                        status = 'err';
                    }
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

            $.each($('textarea[name="objective_next_description[]"]'), function(index) {
                if(index == 0) {
                    if($(this).val() == '') {
                        $(this).addClass('is-invalid');
                        $(this).closest('.form-group').find('.text-danger').html('Please Fill Objective Description for Next Year');

                        if(status == 'ok') {
                            $('a[href="#objective_next"]').tab('show');
                        }

                        status = 'err';
                    }
                }
            });

            if($('textarea[name=training_employee]').val() == '') {
                $('textarea[name=training_employee]').addClass('is-invalid');
                $('textarea[name=training_employee]').parents('.form-group').find('.text-danger').html('Please Fill Training Needs for Employee');

                if(status == 'ok') {
                    $('a[href="#personal_development"]').tab('show');
                }

                status = 'err';
            }

            if($('textarea[name=career_development_employee]').val() == '') {
                $('textarea[name=career_development_employee]').addClass('is-invalid');
                $('textarea[name=career_development_employee]').parents('.form-group').find('.text-danger').html('Please Fill Career Development for Employee');

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
                url : "{{ url('api/appraisal/form-staff') }}",
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