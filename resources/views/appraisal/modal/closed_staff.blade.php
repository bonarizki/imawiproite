<!-- BEGIN MODAL VIEW APPRAISAL IN PROGRESS -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="viewAppraisalClosedStaff">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">View Appraisal</h3>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-9 col-sm-12 pt-2" style="font-size: 1rem;">
                        <div class="row mb-1">
                            <div class="col-md-3"><span data-eng="Employee NIK" data-bhs="NIK Karyawan"> NIK Karyawan </span></div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-8 employee_nik"></div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-3"><span data-eng="Employee Name" data-bhs="Nama Karyawan"> Nama Karyawan </span></div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-8 employee_name"></div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-3"><span data-eng="Department" data-bhs="Departemen"> Departemen </span></div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-8 department"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"> Level </div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-8 level"></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <div class="w-100 text-center">
                            <input type="checkbox" id="language" value="1" data-bootstrap-switch>
                            <input type="hidden" name="language" value="ina">
                            <h2 class="font-weight-bold mt-3 mb-1 period"></h2>
                            <h2 class="font-weight-bold appraisal_status"></h2>
                        </div>
                    </div>
                </div>

                <h3 class="font-weight-bold" data-eng="SECTION I : KPI/OBJECTIVE" data-bhs="BAGIAN I : KPI/OBJECTIVE"> BAGIAN I : KPI/OBJECTIVE </h3>
                <h5 class="font-weight-bold mb-1" data-eng="Guide to Objective Review :" data-bhs="Petunjuk Penilaian Objective :">Petunjuk Penilaian Objective :</h5>
                <div class="row m-0">
                    <small class="font-weight-bold" style="flex: 0 0 auto; width: 3%;">I.</small>
                    <small class="font-weight-bold" style="flex: 0 0 auto; width: 90%;" data-eng="Objective / Work Area" data-bhs="Objective / Area Kerja">Objective / Area Kerja</small>
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
                <table class="table table-bordered table-striped table-objective">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 50px;"> No </th>
                            <th data-eng="Objective / Work Area" data-bhs="Objective / Area Kerja"> Objective / Area Kerja </th>
                            <th data-eng="Employee's Assessment Regarding<br>Achievement of Objective / Work Area" data-bhs="Penilaian Karyawan Mengenai<br>Pencapaian Objective / Area Kerja">Penilaian Karyawan Mengenai<br>Pencapaian Objective / Area Kerja</th>
                            <th data-eng="Superior's Assessment Regarding<br>Achievement of Objective / Work Area" data-bhs="Penilaian Atasan Mengenai<br>Pencapaian Objective / Area Kerja">Penilaian Atasan Mengenai<br>Pencapaian Objective / Area Kerja</th>
                            <th data-eng="Rating" data-bhs="Nilai" style="text-align: center;"> Nilai </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <h4 class="font-weight-bold" data-eng="Overall Comments on Employee's Objective" data-bhs="Komentar Keseluruhan terhadap Objective">Komentar Keseluruhan terhadap Objective</h4>
                <table class="table table-striped table-bordered">
                    <td class="objective_comment"></td>
                </table>
                <table class="table table-striped table-bordered">
                    <td class="font-weight-bold" data-eng="OVERALL OBJECTIVE RATING" data-bhs="NILAI OBJECTIVE KESELURUHAN" style="width: 85%;">NILAI OBJECTIVE KESELURUHAN</td>
                    <td class="font-weight-bold text-center overall_objective_score"></td>
                </table>

                <h3 class="font-weight-bold" data-eng="SECTION II : COMPETENCY" data-bhs="BAGIAN II : KOMPETENSI"> BAGIAN II : KOMPETENSI </h3>
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
                <table class="table table-bordered table-striped table-competency mt-2">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 50px;"> No </th>
                            <th style="width: 35%;" data-eng="Competency" data-bhs="Kompetensi"> Kompetensi </th>
                            <th style="width: 30%;" data-eng="Proficiency Level Assessment from Employee" data-bhs="Penilaian Tingkat Kemahiran dari Karyawan"> Penilaian Tingkat Kemahiran dari Karyawan </th>
                            <th data-eng="Proficiency Level Assessment from Superior" data-bhs="Penilaian Tingkat Kemahiran dari Atasan"> Penilaian Tingkat Kemahiran dari Atasan </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <h4 class="font-weight-bold" data-eng="Overall Comments on Employee's Competency" data-bhs="Komentar Keseluruhan terhadap Kompetensi">Komentar Keseluruhan terhadap Kompetensi</h4>
                <table class="table table-striped table-bordered">
                    <td class="competency_comment"></td>
                </table>
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
                <table class="table table-striped table-bordered">
                    <td class="font-weight-bold" data-eng="OVERALL COMPETENCY RATING" data-bhs="NILAI KOMPETENSI KESELURUHAN" style="width: 85%;">NILAI KOMPETENSI KESELURUHAN</td>
                    <td class="font-weight-bold text-center overall_competency_score"></td>
                </table>

                <h3 class="font-weight-bold" data-eng="SECTION III : KPI/OBJECTIVE FOR NEXT YEAR" data-bhs="BAGIAN III : KPI/OBJECTIVE UNTUK TAHUN DEPAN"> BAGIAN III : KPI/OBJECTIVE UNTUK TAHUN DEPAN </h3>
                <h5 class="font-weight-bold mb-1" data-eng="Guide to Objective / KPI Next Year :" data-bhs="Petunjuk Pengisian Objective / KPI Tahun Depan :">Petunjuk Pengisian Objective / KPI Tahun Depan :</h5>
                <small data-eng="To be filled out by the employee based on the main work area / main job description to be carried out / target for next year." data-bhs="Diisi oleh karyawan yang bersangkutan berdasarkan area kerja utama / uraian kerja utama yang akan dilakukan / target untuk tahun depan.">Diisi oleh karyawan yang bersangkutan berdasarkan area kerja utama / uraian kerja utama yang akan dilakukan / target untuk tahun depan.</small>
                <table class="table table-bordered table-striped table-objective_next mt-2">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 50px;"> No </th>
                            <th> KPI / Objective </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <h3 class="font-weight-bold" data-eng="SECTION IV : PERSONAL DEVELOPMENT" data-bhs="BAGIAN IV : PENGEMBANGAN DIRI"> BAGIAN IV : PENGEMBANGAN DIRI </h3>
                <h4 class="font-weight-bold mb-0" data-eng="Skills Development Needs for Employees" data-bhs="Kebutuhan Pengembangan Keahlian/Keterampilan bagi Karyawan"> Kebutuhan Pengembangan Keahlian/Keterampilan bagi Karyawan </h4>
                <table class="table table-bordered mt-2">
                    <thead>
                        <tr>
                            <th data-eng="By Employee" data-bhs="Dari Karyawan">Dari Karyawan</th>
                            <th data-eng="By Superior" data-bhs="Dari Atasan">Dari Atasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="training_employee"></td>
                            <td class="training_superior"></td>
                        </tr>
                    </tbody>
                </table>
                <h4 class="font-weight-bold mb-0" data-eng="Career Development for Employees" data-bhs="Pengembangan Karir Karyawan"> Pengembangan Karir Karyawan </h4>
                <table class="table table-bordered mt-2">
                    <thead>
                        <tr>
                            <th data-eng="By Employee" data-bhs="Dari Karyawan">Dari Karyawan</th>
                            <th data-eng="By Superior" data-bhs="Dari Atasan">Dari Atasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="career_development_employee"></td>
                            <td class="career_development_superior"></td>
                        </tr>
                    </tbody>
                </table>

                <h3 class="font-weight-bold" data-eng="SECTION V : PERFORMANCE REVIEW" data-bhs="BAGIAN V : ULASAN KINERJA"> BAGIAN V : ULASAN KINERJA </h3>
                <h4 class="font-weight-bold mb-0" data-eng="Summary of Performance Appraisal" data-bhs="Kesimpulan Penilaian Kinerja"> Kesimpulan Penilaian Kinerja </h4>
                <table class="table table-bordered mt-2">
                    <td class="appraisal_summary"></td>
                </table>
                <table class="table table-striped table-bordered mb-0">
                    <td class="font-weight-bold" data-eng="OVERALL OBJECTIVE RATING" data-bhs="NILAI OBJECTIVE KESELURUHAN" style="width: 85%;">NILAI OBJECTIVE KESELURUHAN</td>
                    <td class="font-weight-bold text-center overall_objective_score"></td>
                </table>
                <table class="table table-striped table-bordered mb-0">
                    <td class="font-weight-bold" data-eng="OVERALL COMPETENCIES RATING" data-bhs="NILAI KOMPETENSI KESELURUHAN" style="width: 85%;">NILAI KOMPETENSI KESELURUHAN</td>
                    <td class="font-weight-bold text-center overall_competency_score"></td>
                </table>
                <table class="table table-striped table-bordered">
                    <td class="font-weight-bold" data-eng="OVERALL JOB PERFORMANCE RATING" data-bhs="NILAI KESELURUHAN KINERJA" style="width: 85%;">NILAI KESELURUHAN KINERJA</td>
                    <td class="font-weight-bold text-center overall_performance_score"></td>
                </table>

                <table class="table table-bordered mt-2 mb-3">
                    <tbody>
                        <tr>
                            <td style="width: 20%;"><small class="text-muted"><b>OSC</b> : Outstanding Contribution</small></td>
                            <td style="width: 20%;"><small class="text-muted"><b>ECC</b> : Excellent Contribution</small></td>
                            <td style="width: 20%;"><small class="text-muted"><b>HVC</b> : Highly Valued Contribution</small></td>
                            <td style="width: 20%;"><small class="text-muted"><b>MCE</b> : More Contribution Expected</small></td>
                            <td style="width: 20%;"><small class="text-muted"><b>USC</b> : Unsatisfactory Contribution</small></td>
                        </tr>
                    </tbody>
                </table>

                <div class="employee_feedback"></div>

                <div class="row">
                    <div class="col-md-3">
                        <table class="table table-bordered table-signature" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="text-align: center;"> PROPOSED BY </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">
                                        <div style="min-height: 126px;">
                                            <span class="position_proposed"></span><br>
                                            <img src="{{ asset('images/approved.png') }}" style="max-height: 100%; max-width: 75%;"><br>
                                            <span class="name_proposed"></span><br>
                                            <span class="nik_proposed"></span><br>
                                            <span class="date_proposed"></span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered table-signature" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th colspan="2" style="text-align: center;"> APPROVED BY </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center" style="width: 50%;">
                                        <div style="min-height: 126px;">
                                            <span class="position_approval_1"></span><br>
                                            <span class="image_approval_1"></span><br>
                                            <span class="name_approval_1"></span><br>
                                            <span class="nik_approval_1"></span><br>
                                            <span class="date_approval_1"></span>
                                        </div>
                                    </td>
                                    <td class="text-center" style="width: 50%;">
                                        <div style="min-height: 126px;">
                                            <span class="position_approval_2"></span><br>
                                            <span class="image_approval_2"></span><br>
                                            <span class="name_approval_2"></span><br>
                                            <span class="nik_approval_2"></span><br>
                                            <span class="date_approval_2"></span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-3">
                        <table class="table table-bordered table-signature" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="text-align: center;"> REVIEWED BY HR </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">
                                        <div style="min-height: 126px;">
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
            </div>
            <div class="modal-footer text-right">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL VIEW APPRAISAL IN PROGRESS -->

<script>

$(document).on('click', '.btn-view_closed_staff', function(e) {
    var modal = $('#viewAppraisalClosedStaff');

    modal.find('#language').bootstrapSwitch({
        onText : 'ENG',
        offText : 'INA',
        offColor : 'primary'
    });

    $.ajax({
        type : "GET",
        url : "{{ url('api/appraisal/detail-staff') }}?id="+e.currentTarget.dataset.id+"&type=view",
        dataType : "JSON",
        success : function(res) {
            modal.find('.employee_nik').html(res.appraisal.appraisal_user_nik);
            modal.find('.employee_name').html(res.appraisal.appraisal_user_name);
            modal.find('.department').html(res.appraisal.department_name);
            modal.find('.level').html(res.appraisal.grade_group_name);
            modal.find('.period').html(res.period.period_name);
            modal.find('.appraisal_status').html(res.appraisal.appraisal_status);

            var objective = '';
            $.each(res.objective, function(key, val) {
                objective += '<tr>'+
                    '<td style="text-align: center; vertical-align: middle;">'+(key+1)+'</td>'+
                    '<td>'+val['objective_description'].replace(/\n/g, '<br>')+'</td>'+
                    '<td>'+val['employee_assessment'].replace(/\n/g, '<br>')+'</td>'+
                    '<td>'+val['superior_assessment'].replace(/\n/g, '<br>')+'</td>'+
                    '<td style="text-align: center; vertical-align: middle;">'+val['superior_score']+'</td>'+
                '</tr>';
            });

            modal.find('.table-objective tbody').html(objective);

            modal.find('.objective_comment').html(res.appraisal.objective_comment.replace(/\n/g, '<br>'));
            modal.find('.overall_objective_score').html(res.appraisal.overall_objective_score);

            var competency = '';
            $.each(res.competency, function(key, val) {
                competency += '<tr>'+
                    '<td style="text-align: center; vertical-align: middle;">'+(key+1)+'</td>'+
                    '<td class="competency-name" data-eng="<b>'+val['competency_title_eng']+'</b><br>'+val['competency_eng'].replace(/\n/g, '<br>')+'" data-bhs="<b>'+val['competency_title_eng']+'</b><br>'+val['competency_bhs'].replace(/\n/g, '<br>')+'"><b>'+val['competency_title_eng']+'</b><br>'+val['competency_bhs'].replace(/\n/g, '<br>')+'</td>'+
                    '<td data-eng="'+val['proficiency_'+val['employee_rating']+'_eng'].replace(/\n/g, '<br>')+'" data-bhs="'+val['proficiency_'+val['employee_rating']+'_bhs'].replace(/\n/g, '<br>')+'">'+val['proficiency_'+val['employee_rating']+'_bhs'].replace(/\n/g, '<br>')+'</td>'+
                    '<td data-eng="'+val['proficiency_'+val['superior_rating']+'_eng'].replace(/\n/g, '<br>')+'" data-bhs="'+val['proficiency_'+val['superior_rating']+'_bhs'].replace(/\n/g, '<br>')+'">'+val['proficiency_'+val['superior_rating']+'_bhs'].replace(/\n/g, '<br>')+'</td>'+
                '</tr>';
            });

            modal.find('.table-competency tbody').html(competency);

            modal.find('.competency_comment').html(res.appraisal.competency_comment.replace(/\n/g, '<br>'));
            modal.find('.overall_competency_score').html(res.appraisal.overall_competency_score);

            var objective_next = '';
            $.each(res.objective_next, function(key, val) {
                objective_next += '<tr>'+
                    '<td style="text-align: center; vertical-align: middle;">'+(key+1)+'</td>'+
                    '<td>'+val['objective_next_description'].replace(/\n/g, '<br>')+'</td>'+
                '</tr>';
            });

            modal.find('.table-objective_next tbody').html(objective_next);

            modal.find('.training_employee').html(res.appraisal.training_employee.replace(/\n/g, '<br>'));
            modal.find('.training_superior').html(res.appraisal.training_superior.replace(/\n/g, '<br>'));
            modal.find('.career_development_employee').html(res.appraisal.career_development_employee.replace(/\n/g, '<br>'));
            modal.find('.career_development_superior').html(res.appraisal.career_development_superior.replace(/\n/g, '<br>'));

            modal.find('.appraisal_summary').html(res.appraisal.appraisal_summary.replace(/\n/g, '<br>'));
            modal.find('.overall_performance_score').html(res.appraisal.overall_performance_score);

            var employee_feedback = '';
            if(res.appraisal.employee_feedback != null) {
                employee_feedback += ''+
                    '<h4 class="font-weight-bold mb-0 mt-3" data-eng="Employee\'s Comments On Appraisal" data-bhs="Komentar Karyawan terhadap Appraisal">Komentar Karyawan terhadap Appraisal</h4>'+
                    '<table class="table table-bordered mt-2">'+
                        '<td>'+res.appraisal.employee_feedback.replace(/\n/g, '<br>')+'</td>'+
                    '</table>';
            }

            modal.find('.employee_feedback').html(employee_feedback);

            modal.find('.position_proposed').html(res.appraisal.appraisal_user_title);
            modal.find('.name_proposed').html(res.appraisal.appraisal_user_name);
            modal.find('.nik_proposed').html(res.appraisal.appraisal_user_nik);
            modal.find('.date_proposed').html(moment(res.appraisal.created_at).format('DD MMM YYYY'));

            var approved = '<img src="{{ asset("images/approved.png") }}" style="max-height: 100%; max-width: 75%;">';
            var rejected = '<img src="{{ asset("images/rejected.png") }}" style="max-height: 100%; max-width: 63%;">';

            if(res.appraisal.appraisal_approval_status_1 != null) {
                modal.find('.position_approval_1').html(res.appraisal.appraisal_approval_title_1);
                modal.find('.image_approval_1').html((res.appraisal.appraisal_approval_status_1 == '1' ? approved : rejected));
                modal.find('.name_approval_1').html(res.appraisal.appraisal_approval_name_1);
                modal.find('.nik_approval_1').html(res.appraisal.appraisal_approval_nik_1);
                modal.find('.date_approval_1').html(moment(res.appraisal.appraisal_approval_date_1).format('DD MMM YYYY'));
            } else {
                if(res.approval_matrix.approval_nik_1 != null) {
                    modal.find('.position_approval_1').html('<p class="mt-4 mb-3"><i>Waiting for Approval</i></p>');
                    modal.find('.name_approval_1').html(res.approval_matrix.approval_name_1);
                    modal.find('.nik_approval_1').html(res.approval_matrix.approval_nik_1);
                } else {
                    modal.find('.position_approval_1').html('');
                    modal.find('.image_approval_1').html('');
                    modal.find('.name_approval_1').html('');
                    modal.find('.nik_approval_1').html('');
                    modal.find('.date_approval_1').html('');
                }
            }

            if(res.appraisal.appraisal_approval_status_2 != null) {
                modal.find('.position_approval_2').html(res.appraisal.appraisal_approval_title_2);
                modal.find('.image_approval_2').html((res.appraisal.appraisal_approval_status_2 == '1' ? approved : rejected));
                modal.find('.name_approval_2').html(res.appraisal.appraisal_approval_name_2);
                modal.find('.nik_approval_2').html(res.appraisal.appraisal_approval_nik_2);
                modal.find('.date_approval_2').html(moment(res.appraisal.appraisal_approval_date_2).format('DD MMM YYYY'));
            } else {
                if(res.approval_matrix.approval_nik_2 != null || res.appraisal.appraisal_status == 'REJECTED') {
                    modal.find('.position_approval_2').html('<p class="mt-4 mb-3"><i>Waiting for Approval</i></p>');
                    modal.find('.name_approval_2').html(res.approval_matrix.approval_name_2);
                    modal.find('.nik_approval_2').html(res.approval_matrix.approval_nik_2);
                } else {
                    modal.find('.position_approval_2').html('');
                    modal.find('.image_approval_2').html('');
                    modal.find('.name_approval_2').html('');
                    modal.find('.nik_approval_2').html('');
                    modal.find('.date_approval_2').html('');
                }
            }

            if(res.appraisal.appraisal_approval_status_hr != null) {
                modal.find('.position_approval_hr').html(res.appraisal.appraisal_approval_title_hr);
                modal.find('.image_approval_hr').html((res.appraisal.appraisal_approval_status_hr == '1' ? approved : rejected));
                modal.find('.name_approval_hr').html(res.appraisal.appraisal_approval_name_hr);
                modal.find('.nik_approval_hr').html(res.appraisal.appraisal_approval_nik_hr);
                modal.find('.date_approval_hr').html(moment(res.appraisal.appraisal_approval_date_hr).format('DD MMM YYYY'));
            } else {
                modal.find('.position_approval_hr').html(res.appraisal.appraisal_status == 'REJECTED' ? '' : '<p class="mt-4 mb-3"><i>Waiting for Approval</i></p>');
                modal.find('.image_approval_hr').html('');
                modal.find('.name_approval_hr').html('');
                modal.find('.nik_approval_hr').html('');
                modal.find('.date_approval_hr').html('');
            }
        },
        error : function(jqXhr, errorThrown, textStatus) {
            console.log(errorThrown);
        }
    });

    modal.modal('show');
});

$(document).on('switchChange.bootstrapSwitch', '#language', function(event, state) {
    if(!state) {
        $('#viewAppraisalInProgressStaff input[name=language]').val('ina');
        $('.nav-tabs .nav-link, .competency-name, .proficiency, th, td, h5, label, small, span, button').each(function(index) {
            $(this).html($(this).data('bhs'));
        });
    } else {
        $('#viewAppraisalInProgressStaff input[name=language]').val('eng');
        $('.nav-tabs .nav-link, .competency-name, .proficiency, th, td, h5, label, small, span, button').each(function(index) {
            $(this).html($(this).data('eng'));
        });
    }
});

</script>