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
                            <li class="nav-item">
                                <a href="#performance_review" class="nav-link" data-toggle="tab" data-eng="Performance Review" data-bhs="Ulasan Kinerja">Ulasan Kinerja</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-2 text-right">
                        <input type="checkbox" id="language" value="1" data-bootstrap-switch>
                        <input type="hidden" name="language" value="ina">
                    </div>
                </div>
                <div class="card-body">
                    <form class="p-2" method="post" id="approvalForm">
                        {{ csrf_field() }}
                        <input type="hidden" name="appraisal_staff_id" value="{{ $appraisal->appraisal_staff_id }}">
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
                                <div class="row m-0">
                                    <small style="flex: 0 0 auto; width: 3%;"></small>
                                    <small style="flex: 0 0 auto; width: 90%;" data-eng="Filled with measurable work results (Qualitative / Quantitative)." data-bhs="Diisi dengan hasil kerja yang dapat terukur (Kualitatif / Kuantitatif).">Diisi dengan hasil kerja yang dapat terukur (Kualitatif / Kuantitatif).</small>
                                </div>
                                <div class="row m-0">
                                    <small class="font-weight-bold" style="flex: 0 0 auto; width: 3%;">III.</small>
                                    <small class="font-weight-bold" style="flex: 0 0 auto; width: 90%;" data-eng="Superior's assessment regarding the achievement of the Objective / KPI" data-bhs="Penilaian atasan mengenai pencapaian Objective / Area Kerja">Penilaian atasan mengenai pencapaian Objective / Area Kerja</small>
                                </div>
                                <div class="row m-0">
                                    <small style="flex: 0 0 auto; width: 3%;"></small>
                                    <small style="flex: 0 0 auto; width: 90%;" data-eng="Filled with constructive feedback on observations of the results of employee's assessments and scored based on :" data-bhs="Diisi dengan feedback konstruktif atas observasi hasil dari penilaian karyawan dan dinilai dengan acuan seperti dibawah :">Diisi dengan feedback konstruktif atas observasi hasil dari penilaian karyawan dan dinilai dengan acuan seperti dibawah :</small>
                                </div>
                                <table class="table table-bordered mt-2 mb-2">
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
                                <small class="font-weight-bold mb-1" data-eng="Example :" data-bhs="Contoh :">Contoh :</small>
                                <table class="table table-sm table-bordered" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th data-eng="Objective / Work Area" data-bhs="Objective / Area Kerja">Objective / Area Kerja</th>
                                            <th data-eng="Employee's Assessment Regarding Achievement of Objective / Work Area" data-bhs="Penilaian Karyawan Mengenai Pencapaian Objective / KPI">Penilaian Karyawan Mengenai Pencapaian Objective / Area Kerja</th>
                                            <th data-eng="Superior's Assessment Regarding Achievement of Objective / Work Area" data-bhs="Penilaian Atasan Mengenai Pencapaian Objective / KPI">Penilaian Atasan Mengenai Pencapaian Objective / Area Kerja</th>
                                            <th data-eng="Score" data-bhs="Nilai">Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><small data-eng="Vehicle Maintenance" data-bhs="Perawatan Kendaraan">Perawatan Kendaraan</small></td>
                                            <td><small data-eng="1. Always carry out regular vehicle inspections and maintenance every 2 weeks<br>2. In 1 year only 2 times damage to operational vehicles" data-bhs="1. Selalu melakukan pemeriksaan dan perawatan kendaraan secara berkala 2 minggu sekali<br>2. Dalam 1 tahun hanya terjadi 2 kali kerusakan pada kendaraan operasional">1. Selalu melakukan pemeriksaan dan perawatan kendaraan secara berkala 2 minggu sekali<br>2. Dalam 1 tahun hanya terjadi 2 kali kerusakan pada kendaraan operasional</small></td>
                                            <td><small data-eng="1. Inspections are carried out routinely, but still need to be reminded to check<br>2. Damage is not crucial" data-bhs="1. Pemeriksaan dilakukan secara rutin, namun masih harus diingatkan untuk melakukan pengecekan<br>2. Kerusakan bukan yang krusial">1. Pemeriksaan dilakukan secara rutin, namun masih harus diingatkan untuk melakukan pengecekan<br>2. Kerusakan bukan yang krusial</small></td>
                                            <td class="text-center"><small>3</small></td>
                                        </tr>
                                    </tbody>
                                </table>
                                @if(count($objective) > 0) 
                                    @foreach($objective as $key => $value)
                                        <div class="row objective-point">
                                            <input type="hidden" name="appraisal_staff_objective_id[]" value="{{ $value->appraisal_staff_objective_id }}">
                                            <div class="form-group" style="flex: 0 0 auto; width: 30%;">
                                                @if($key == 0) <label class="form-label" data-eng="Objective / Work Area" data-bhs="Objective / Area Kerja">Objective / Area Kerja</label> @endif
                                                <textarea name="objective_description[]" class="form-control" rows="5" data-pl_eng="Type objective description.." data-pl_bhs="Isi deskripsi objective.." placeholder="Isi deskripsi objective.." readonly>{{ $value->objective_description }}</textarea>
                                                <small class="text-danger"></small>
                                            </div>
                                            <div class="form-group" style="flex: 0 0 auto; width: 30%;">
                                                @if($key == 0) <label class="form-label" data-eng="Employee's Assessment" data-bhs="Penilaian Karyawan">Penilaian Karyawan</label> @endif
                                                <textarea name="employee_assessment[]" class="form-control" rows="5" data-pl_eng="Type employee's assessment.." data-pl_bhs="Isi penilaian karyawan.." placeholder="Isi penilaian karyawan.." readonly>{{ $value->employee_assessment }}</textarea>
                                                <small class="text-danger"></small>
                                            </div>
                                            <div class="form-group" style="flex: 0 0 auto; width: 30%;">
                                                @if($key == 0) <label class="form-label" data-eng="Superior's Assessment" data-bhs="Penilaian Atasan">Penilaian Atasan</label> @endif
                                                <textarea name="superior_assessment[]" class="form-control" rows="5" data-pl_eng="Type superior's assessment.." data-pl_bhs="Isi penilaian atasan.." placeholder="Isi penilaian atasan..">{{ $value->superior_assessment }}</textarea>
                                                <small class="text-danger"></small>
                                            </div>
                                            <div class="form-group" style="flex: 0 0 auto; width: 10%;">
                                                @if($key == 0) <label class="form-label" data-eng="Rating" data-bhs="Nilai">Nilai</label> @endif
                                                <select name="superior_score[]" class="form-control select2-hide-search" data-pl_eng="Select A Rating" data-pl_bhs="Pilih Nilai" data-placeholder="Pilih Nilai" style="width: 100%;">
                                                    <option></option>
                                                    <option value="1"{{ $value->superior_score == '1' ? ' selected' : '' }}>1</option>
                                                    <option value="1.5"{{ $value->superior_score == '1.5' ? ' selected' : '' }}>1.5</option>
                                                    <option value="2"{{ $value->superior_score == '2' ? ' selected' : '' }}>2</option>
                                                    <option value="2.5"{{ $value->superior_score == '2.5' ? ' selected' : '' }}>2.5</option>
                                                    <option value="3"{{ $value->superior_score == '3' ? ' selected' : '' }}>3</option>
                                                    <option value="3.5"{{ $value->superior_score == '3.5' ? ' selected' : '' }}>3.5</option>
                                                    <option value="4"{{ $value->superior_score == '4' ? ' selected' : '' }}>4</option>
                                                    <option value="4.5"{{ $value->superior_score == '4.5' ? ' selected' : '' }}>4.5</option>
                                                    <option value="5"{{ $value->superior_score == '5' ? ' selected' : '' }}>5</option>
                                                </select>
                                                <small class="text-danger"></small>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="row mt-3">
                                    <div class="form-group col-md-9">
                                        <label class="form-label col-form-label" data-eng="Overall Comments on Employee's Objective" data-bhs="Komentar Keseluruhan terhadap Objective">Komentar Keseluruhan terhadap Objective</label>
                                        <textarea name="objective_comment" class="form-control" rows="7" data-pl_eng="Type overall comments on employee's objective.." data-pl_bhs="Isi komentar keseluruhan terhadap objective.." placeholder="Isi komentar keseluruhan terhadap objective..">{{ $appraisal->objective_comment }}</textarea>
                                        <small class="text-danger"></small>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="form-label col-form-label" data-eng="OVERALL OBJECTIVE RATING" data-bhs="NILAI OBJECTIVE KESELURUHAN">NILAI OBJECTIVE KESELURUHAN</label>
                                        <input type="text" name="overall_objective_score" class="form-control font-weight-bold" value="{{ $appraisal->overall_objective_score }}" readonly>
                                    </div>
                                </div>
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
                                            <th style="width: 30%;" data-eng="Proficiency Level Assessment from Employee" data-bhs="Penilaian Tingkat Kemahiran dari Karyawan"> Penilaian Tingkat Kemahiran dari Karyawan </th>
                                            <th data-eng="Proficiency Level Assessment from Superior" data-bhs="Penilaian Tingkat Kemahiran dari Atasan"> Penilaian Tingkat Kemahiran dari Atasan </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($competency) > 0)
                                            @foreach($competency as $key => $value)
                                                <tr>
                                                    <input type="hidden" name="appraisal_staff_competency_id[]" value="{{ $value->appraisal_staff_competency_id }}">
                                                    <td style="text-align: center;">{{ $key+1 }}</td>
                                                    <td class="competency-name" data-eng="<?php echo "<b>$value->competency_title_eng</b></br>".str_replace("\n", "<br>", $value->competency_eng); ?>" data-bhs="<?php echo "<b>$value->competency_title_eng</b></br>".str_replace("\n", "<br>", $value->competency_bhs); ?>"><?php echo "<b>$value->competency_title_eng</b></br>".str_replace("\n", "<br>", $value->competency_bhs); ?></td>
                                                    <td class="form-group" style="vertical-align: middle;">
                                                        <label class="form-check {{ $value->employee_rating == 1 ? 'checked' : '' }}">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="1" {{ $value->employee_rating == 1 ? 'checked' : '' }} disabled>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_1_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_1_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_1_bhs); ?></span>
                                                        </label>
                                                        <label class="form-check {{ $value->employee_rating == 2 ? 'checked' : '' }}">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="2" {{ $value->employee_rating == 2 ? 'checked' : '' }} disabled>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_2_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_2_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_2_bhs); ?></span>
                                                        </label>
                                                        <label class="form-check {{ $value->employee_rating == 3 ? 'checked' : '' }}">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="3" {{ $value->employee_rating == 3 ? 'checked' : '' }} disabled>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_3_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_3_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_3_bhs); ?></span>
                                                        </label>
                                                        <label class="form-check {{ $value->employee_rating == 4 ? 'checked' : '' }}">
                                                            <input type="radio" name="employee_rating[{{ $key }}]" class="form-check-input proficiency" value="4" {{ $value->employee_rating == 4 ? 'checked' : '' }} disabled>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_4_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_4_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_4_bhs); ?></span>
                                                        </label>
                                                    </td>
                                                    <td class="form-group" style="vertical-align: middle;">
                                                        <label class="form-check {{ $value->superior_rating == 1 ? 'checked' : '' }}">
                                                            <input type="radio" name="superior_rating[{{ $key }}]" class="form-check-input proficiency" value="1" {{ $value->superior_rating == 1 ? 'checked' : '' }}>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_1_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_1_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_1_bhs); ?></span>
                                                        </label>
                                                        <label class="form-check {{ $value->superior_rating == 2 ? 'checked' : '' }}">
                                                            <input type="radio" name="superior_rating[{{ $key }}]" class="form-check-input proficiency" value="2" {{ $value->superior_rating == 2 ? 'checked' : '' }}>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_2_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_2_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_2_bhs); ?></span>
                                                        </label>
                                                        <label class="form-check {{ $value->superior_rating == 3 ? 'checked' : '' }}">
                                                            <input type="radio" name="superior_rating[{{ $key }}]" class="form-check-input proficiency" value="3" {{ $value->superior_rating == 3 ? 'checked' : '' }}>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_3_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_3_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_3_bhs); ?></span>
                                                        </label>
                                                        <label class="form-check {{ $value->superior_rating == 4 ? 'checked' : '' }}">
                                                            <input type="radio" name="superior_rating[{{ $key }}]" class="form-check-input proficiency" value="4" {{ $value->superior_rating == 4 ? 'checked' : '' }}>
                                                            <span class="form-check-label" data-eng="<?php echo str_replace("\n", "<br>", $value->proficiency_4_eng); ?>" data-bhs="<?php echo str_replace("\n", "<br>", $value->proficiency_4_bhs); ?>"><?php echo str_replace("\n", "<br>", $value->proficiency_4_bhs); ?></span>
                                                        </label>
                                                        <small class="text-danger"></small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <div class="row mt-3">
                                    <div class="form-group col-md-9">
                                        <label class="form-label col-form-label" data-eng="Overall Comments on Employee's Competency" data-bhs="Komentar Keseluruhan terhadap Kompetensi">Komentar Keseluruhan terhadap Kompetensi</label>
                                        <textarea name="competency_comment" class="form-control" rows="7" data-pl_eng="Type overall comments on employee's competency.." data-pl_bhs="Isi komentar keseluruhan terhadap kompetensi.." placeholder="Isi komentar keseluruhan terhadap kompetensi..">{{ $appraisal->competency_comment }}</textarea>
                                        <small class="text-danger"></small>
                                    </div>
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
                                                <textarea name="objective_next_description[]" class="form-control" rows="5" data-pl_eng="Type objective description.." data-pl_bhs="Isi deskripsi objective.." placeholder="Isi deskripsi objective..">{{ $value->objective_next_description }}</textarea>
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
                                        <div class="form-group" style="flex: 0 0 auto; width: 96%;">
                                            <label class="form-label">Objective / KPI</label>
                                            <textarea name="objective_next_description[]" class="form-control" rows="5" data-pl_eng="Type objective description.." data-pl_bhs="Isi deskripsi objective.." placeholder="Isi deskripsi objective.."></textarea>
                                        </div>
                                    </div>
                                @endif
                                <div class="added-objective-next-point"></div>
                                <a href="javascript:;" class="btn btn-secondary btn-add-point-next mt-2">
                                    <i class="fa fa-plus"></i>
                                    <span data-eng="Add More Point" data-bhs="Tambah Point"> Tambah Point </span>
                                </a>
                            </div>
                            <div class="tab-pane fade" id="personal_development">
                                <div class="form-group">
                                <label class="form-label mb-0" data-eng="Skills Development Needs for Employees" data-bhs="Kebutuhan Pengembangan Keahlian/Keterampilan bagi Karyawan">Kebutuhan Pengembangan Keahlian/Keterampilan bagi Karyawan</label>
                                    <div class="row" style="width: 99%; margin-left: auto;">
                                        <div class="col-md-6">
                                            <label class="form-label mt-2" data-eng="By Employee" data-bhs="Dari Karyawan">Dari Karyawan</label>
                                            <textarea name="training_employee" class="form-control mt-2" rows="7" data-pl_eng="Type skills development needs for employees.." data-pl_bhs="Isi kebutuhan pengembangan keahlian/keterampilan bagi karyawan.." placeholder="Isi kebutuhan pengembangan keahlian/keterampilan bagi karyawan.." readonly>{{ $appraisal->training_employee }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label mt-2" data-eng="By Superior" data-bhs="Dari Atasan">Dari Atasan</label>
                                            <textarea name="training_superior" class="form-control mt-2" rows="7" data-pl_eng="Type skills development needs for employees.." data-pl_bhs="Isi kebutuhan pengembangan keahlian/keterampilan bagi karyawan.." placeholder="Isi kebutuhan pengembangan keahlian/keterampilan bagi karyawan..">{{ $appraisal->training_superior }}</textarea>
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-0" data-eng="Career Development for Employees" data-bhs="Pengembangan Karir Karyawan">Pengembangan Karir Karyawan</label>
                                    <div class="row" style="width: 99%; margin-left: auto;">
                                        <div class="col-md-6">
                                            <label class="form-label mt-2" data-eng="By Employee" data-bhs="Dari Karyawan">Dari Karyawan</label>
                                            <textarea name="career_development_employee" class="form-control mt-2" rows="7" data-pl_eng="Type career development for employees.." data-pl_bhs="Isi pengembangan karir karyawan.." placeholder="Isi pengembangan karir karyawan.." readonly>{{ $appraisal->career_development_employee }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label mt-2" data-eng="By Superior" data-bhs="Dari Atasan">Dari Atasan</label>
                                            <textarea name="career_development_superior" class="form-control mt-2" rows="7" data-pl_eng="Type career development for employees.." data-pl_bhs="Isi pengembangan karir karyawan.." placeholder="Isi pengembangan karir karyawan..">{{ $appraisal->career_development_superior }}</textarea>
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="performance_review">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label class="form-label col-form-label" data-eng="Summary of Performance Appraisal" data-bhs="Kesimpulan Penilaian Kinerja">Kesimpulan Penilaian Kinerja</label>
                                        <small class="text-muted" data-eng="Please give summary of appraisal identifying any special circumstances influencing performance and areas for further development/improvement" data-bhs="Harap berikan ringkasan penilaian yang mengidentifikasi keadaan khusus yang memengaruhi kinerja dan bidang untuk pengembangan / peningkatan lebih lanjut">Harap berikan ringkasan penilaian yang mengidentifikasi keadaan khusus yang memengaruhi kinerja dan bidang untuk pengembangan / peningkatan lebih lanjut</small>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea name="appraisal_summary" class="form-control" rows="7" data-pl_eng="Type appraisal summary.." data-pl_bhs="Isi kesimpulan penilaian kinerja.." placeholder="Isi kesimpulan penilaian kinerja..">{{ $appraisal->appraisal_summary }}</textarea>
                                        <small class="text-danger"></small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-6 form-label col-form-label" data-eng="OVERALL OBJECTIVE RATING" data-bhs="NILAI OBJECTIVE KESELURUHAN">NILAI OBJECTIVE KESELURUHAN</label>
                                            <div class="col-md-4">
                                                <input type="text" name="overall_objective_score" class="form-control font-weight-bold" value="{{ $appraisal->overall_objective_score }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-6 form-label col-form-label" data-eng="OVERALL COMPETENCIES RATING" data-bhs="NILAI KOMPETENSI KESELURUHAN">NILAI KOMPETENSI KESELURUHAN</label>
                                            <div class="col-md-4">
                                                <input type="text" name="overall_competency_score" class="form-control font-weight-bold" value="{{ $appraisal->overall_competency_score }}" readonly>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                            <label class="col-md-6 form-label col-form-label" data-eng="OVERALL JOB PERFORMANCE RATING" data-bhs="NILAI KESELURUHAN KINERJA">NILAI KESELURUHAN KINERJA</label>
                                            <div class="col-md-4">
                                                <input type="text" name="overall_performance_score" class="form-control font-weight-bold" readonly>
                                            </div>
                                        </div> -->
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label class="form-label col-form-label pb-0" data-eng="OVERALL JOB PERFORMANCE RATING" data-bhs="NILAI KESELURUHAN KINERJA">NILAI KESELURUHAN KINERJA</label>
                                                <small class="text-muted" data-eng="(recommended by superior)" data-bhs="(rekomendasi dari atasan)">(rekomendasi dari atasan)</small>
                                            </div>
                                            <div class="col-md-4">
                                                <select name="overall_performance_score_rounded" class="form-control select2-hide-search" data-pl_eng="Select A Rating" data-pl_bhs="Pilih Nilai" data-placeholder="Pilih Nilai" style="width: 100%;">
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
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                            <label class="col-md-6 form-label col-form-label" data-eng="Recommended Salary Increment (%)" data-bhs="Rekomendasi Penambahan Salary (%)">Rekomendasi Penambahan Salary (%)</label>
                                            <div class="col-md-4">
                                                <input type="text" name="increment" class="form-control numbers" value="{{ $appraisal->increment }}">
                                                <small class="text-danger"></small>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="font-weight-bold mt-2 mb-1" data-eng="Guide to Overall Performance Rating :" data-bhs="Petunjuk Pengisian Nilai Keseluruhan Kerja :">Petunjuk Pengisian Nilai Keseluruhan Kerja :</h5>
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
                            </div>
                            <input type="hidden" name="appraisal_approval_reject_note">
                            <input type="hidden" name="approval_type">
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-primary pt-3 pb-3" id="btn-draft" style="width: 175px;">Save as Draft</button>
                                </div>
                                <div class="col-md-8 text-right">
                                    <button type="button" class="btn btn-danger ml-auto pt-3 pb-3" id="btn-reject" style="width: 175px;">Reject</button>
                                    <button type="button" class="btn btn-success ml-3 pt-3 pb-3" id="btn-approve" style="width: 175px;">Approve</button>
                                </div>
                            </div>
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
            onText : 'ENG',
            offText : 'INA',
            offColor : 'primary'
        });

        $('.select2-hide-search').select2({
            theme : 'bootstrap4',
            minimumResultsForSearch : Infinity
        });

        $('.numbers').autoNumeric('init');

        var objective = parseFloat($('input[name=overall_objective_score]').val());
        var competency = parseFloat($('input[name=overall_competency_score]').val());

        if(objective != null && competency != null) {
            var overall = (objective + competency) / 2;

            if(isNaN(overall) || overall == undefined) {
                $('input[name=overall_performance_score]').val('-').change();
            } else {
                $('input[name=overall_performance_score]').val(overall.toFixed(2)).change();
            }
        }

        $(document).on('switchChange.bootstrapSwitch', '#language', function(event, state) {
            if(!state) {
                $('input[name=language]').val('ina');
                $('.nav-tabs .nav-link, .competency-name, .proficiency, th, h5, label, small, span, button').each(function(index) {
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
                $('.nav-tabs .nav-link, .competency-name, .proficiency, th, h5, label, small, span, button').each(function(index) {
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

        $(document).on('change input keyup', 'input, select, textarea', function(e) {
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

        $(document).on('change', 'select[name="superior_score[]"]', function(e) {
            var score = [];

            $.each($('select[name="superior_score[]"]'), function(index) {
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
                $('input[name=overall_objective_score]').val('-').change();
            } else {
                $('input[name=overall_objective_score]').val(overall.toFixed(2)).change();
            }
        });

        $(document).on('change', 'select[name=overall_competency_score]', function(e) {
            $('input[name=overall_competency_score]').val($(this).val()).change();
        });

        $(document).on('change', 'input[name=overall_objective_score], input[name=overall_competency_score]', function(e) {
            var objective = parseFloat($('input[name=overall_objective_score]').val());
            var competency = parseFloat($('input[name=overall_competency_score]').val());

            var overall = (objective + competency) / 2;
            
            if(isNaN(overall) || overall == undefined) {
                $('input[name=overall_performance_score]').val('-').change();
            } else {
                $('input[name=overall_performance_score]').val(overall.toFixed(2)).change();
            }
        });

        $(document).on('click', '#btn-draft', function(e) {
            e.preventDefault();

            $('input[name=approval_type]').val('DRAFT');

            $('#approvalForm').submit();
        });

        $(document).on('click', '#btn-reject', function(e) {
            var modal = $('#rejectModal');

            modal.modal('show');
        });

        $(document).on('submit', '#rejectModal form', function(e) {
            e.preventDefault();

            $('input[name=appraisal_approval_reject_note]').val($('textarea[name=note]').val());
            $('input[name=approval_type]').val('REJECT');

            $.ajax({
                url : "{{ url('/appraisal/approve-staff') }}",
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

            $.each($('textarea[name="superior_assessment[]"]'), function(index) {
                if($(this).val() == '') {
                    $(this).addClass('is-invalid');
                    $(this).closest('.form-group').find('.text-danger').html('Please Fill Your Assessment');
                    $('a[href="#objective"]').tab('show');
                    status = 'err';
                }
            });
            
            $.each($('select[name="superior_score[]"]'), function(index) {
                if($(this).val() == '') {
                    $(this).addClass('is-invalid');
                    $(this).closest('.form-group').find('.text-danger').html('Please Select a Rating');
                    $('a[href="#objective"]').tab('show');
                    status = 'err';
                }
            });

            if($('textarea[name=objective_comment]').val() == '') {
                $('textarea[name=objective_comment]').addClass('is-invalid');
                $('textarea[name=objective_comment]').parents('.form-group').find('.text-danger').html('Please Fill Overall Comment for Objective');

                if(status == 'ok') {
                    $('a[href="#objective"]').tab('show');
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

            if($('textarea[name=competency_comment]').val() == '') {
                $('textarea[name=competency_comment]').addClass('is-invalid');
                $('textarea[name=competency_comment]').parents('.form-group').find('.text-danger').html('Please Fill Overall Comment for Competency');

                if(status == 'ok') {
                    $('a[href="#competencies"]').tab('show');
                }

                status = 'err';
            }

            if($('select[name=overall_competency_score]').val() == '') {
                $('select[name=overall_competency_score]').addClass('is-invalid');
                $('select[name=overall_competency_score]').parents('.form-group').find('.text-danger').html('Please Select a Rating');

                if(status == 'ok') {
                    $('a[href="#competencies"]').tab('show');
                }

                status = 'err';
            }

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

            if($('textarea[name=training_superior]').val() == '') {
                $('textarea[name=training_superior]').addClass('is-invalid');
                $('textarea[name=training_superior]').parents('.form-group').find('.text-danger').html('Please Fill Training Needs for Employee');

                if(status == 'ok') {
                    $('a[href="#personal_development"]').tab('show');
                }

                status = 'err';
            }

            if($('textarea[name=career_development_superior]').val() == '') {
                $('textarea[name=career_development_superior]').addClass('is-invalid');
                $('textarea[name=career_development_superior]').parents('.form-group').find('.text-danger').html('Please Fill Career Development for Employee');

                if(status == 'ok') {
                    $('a[href="#personal_development"]').tab('show');
                }

                status = 'err';
            }

            if($('textarea[name=appraisal_summary]').val() == '') {
                $('textarea[name=appraisal_summary]').addClass('is-invalid');
                $('textarea[name=appraisal_summary]').parents('.form-group').find('.text-danger').html('Please Fill Appraisal Summary');

                if(status == 'ok') {
                    $('a[href="#performance_review"]').tab('show');
                }

                status = 'err';
            }

            if($('select[name=overall_performance_score_rounded]').val() == '') {
                $('select[name=overall_performance_score_rounded]').addClass('is-invalid');
                $('select[name=overall_performance_score_rounded]').parents('.form-group').find('.text-danger').html('Please Select a Rating');

                if(status == 'ok') {
                    $('a[href="#performance_review"]').tab('show');
                }

                status = 'err';
            }

            if($('input[name=increment]').val() == '') {
                $('input[name=increment]').addClass('is-invalid');
                $('input[name=increment]').parents('.form-group').find('.text-danger').html('Please Fill Recommended Increment');

                if(status == 'ok') {
                    $('a[href="#performance_review"]').tab('show');
                }

                status = 'err';
            }

            if(status == 'ok') {
                $('input[name=approval_type]').val('APPROVE');

                Swal.fire({
                    title : 'Approve this Appraisal?',
                    type : 'warning',
                    showCancelButton : true,
                    confirmButtonText : 'Yes, Approve',
                    reverseButtons : true
                }).then((result) => {
                    if(result.value) {
                        $('#approvalForm').submit();
                    }
                });
            }
        });

        $(document).on('submit', '#approvalForm', function(e) {
            e.preventDefault();

            $.ajax({
                type : "POST",
                url : "{{ url('/appraisal/approve-staff') }}",
                data : $('#approvalForm').serialize(),
                beforeSend : function() {
                    $('.se-pre-con').fadeIn();
                },
                success : function(res) {
                    $('.se-pre-con').fadeOut();

                    if(res.appraisal_status == 'DRAFT') {
                        toastr.success('Saved as Draft!', 'Success', { "closeButton": true });
                    } else if(res.appraisal_status == 'IN PROGRESS') {
                        Swal.fire({
                            title : 'Approved',
                            type : 'success'
                        }).then((result) => {
                            window.location.href = "{{ url('/appraisal/approval') }}";
                        });
                    } else if(res.appraisal_status == 'CLOSED') {
                        Swal.fire({
                            title : 'Approved and Closed',
                            type : 'success'
                        }).then((result) => {
                            window.location.href = "{{ url('/appraisal/approval') }}";
                        });
                    } else if(res.appraisal_status == 'REJECTED') {
                        Swal.fire({
                            title : 'Rejected',
                            type : 'success'
                        }).then((result) => {
                            window.location.href = "{{ url('/appraisal/approval') }}";
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