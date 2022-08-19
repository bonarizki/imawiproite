<!-- BEGIN MODAL VIEW APPRAISAL CLOSED -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="viewAppraisalConfidential">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">View Appraisal</h3>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-9 col-sm-12">
                        <div class="row mb-1">
                            <div class="col-md-3">Employee NIK</div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-8 employee_nik"></div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-3">Employee Name</div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-8 employee_name"></div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-3">Department</div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-8 department"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">Level</div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-8 level"></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <div class="w-100 text-center">
                            <h2 class="font-weight-bold period"></h2>
                            <h2 class="font-weight-bold appraisal_status"></h2>
                        </div>
                    </div>
                </div>
                <h3 class="font-weight-bold">SECTION I : PERSONAL MILESTONES AND ASSESSMENT</h3>
                <h5 class="mt-3">Your Milestones must be set and agreed with your superior and each milestone shall consist the following elements :</h5>
                <div class="row m-0">
                    <small style="flex: 0 0 auto; width: 3%;">I.</small>
                    <small style="flex: 0 0 auto; width: 90%;">How does the milestone links to your department/business strategies.</small>
                </div>
                <div class="row m-0">
                    <small style="flex: 0 0 auto; width: 3%;">II.</small>
                    <small style="flex: 0 0 auto; width: 90%;">Each milestone must be SMART (Specific, Measurement, Actionable, Reasonable, Time bounded), you must specify the Quantitative Measurement (e.g. financial results) and the Timeline for each milestone.</small>
                </div>
                <h5 class="mt-2">Guide to Milestone Rating</h5>
                <table class="table table-bordered mb-2">
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
                <div class="table-milestone mt-3"></div>
                <div class="beyond_milestone"></div>
                <h4 class="font-weight-bold">Overall Feedback on Employee's Milestone</h4>
                <table class="table table-striped table-bordered">
                    <td class="milestone_feedback"></td>
                </table>
                <table class="table table-striped table-bordered">
                    <td class="font-weight-bold" style="width: 85%;">OVERALL MILESTONES RATING</td>
                    <td class="font-weight-bold text-center overall_milestone_score"></td>
                </table>

                <h3 class="font-weight-bold"> SECTION II : COMPETENCY </h3>
                <h5 class="font-weight-bold mb-1">Guide to Competencies Review :</h5>
                <div class="row m-0">
                    <small style="flex: 0 0 auto; width: 3%;">I.</small>
                    <small style="flex: 0 0 auto; width: 90%;">Self Assessment of competency is filled with reference to the 4 levels of proficiency in the options provided.</small>
                </div>
                <div class="row m-0">
                    <small style="flex: 0 0 auto; width: 3%;">II.</small>
                    <small style="flex: 0 0 auto; width: 90%;">Proficiency levels are arranged by category Basic (first choice) and Expert (last choice).</small>
                </div>
                <div class="row m-0">
                    <small style="flex: 0 0 auto; width: 3%;">III.</small>
                    <small style="flex: 0 0 auto; width: 90%;">Assessment is done by looking at the suitability of your abilities/skills in completing the work.</small>
                </div>
                <div class="row m-0">
                    <small style="flex: 0 0 auto; width: 3%;">IV.</small>
                    <small style="flex: 0 0 auto; width: 90%;">In the competency section provided by norm description and order through proficiency level (from top to down).</small>
                </div>
                <table class="table table-bordered table-striped table-competency mt-2">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 50px;"> No </th>
                            <th style="width: 35%;"> Competency </th>
                            <th style="width: 30%;"> Proficiency Level Assessment from Employee </th>
                            <th> Proficiency Level Assessment from Superior </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <h4 class="font-weight-bold">Overall Feedback on Employee's Competency</h4>
                <table class="table table-striped table-bordered">
                    <td class="competency_feedback"></td>
                </table>
                <h5 class="mt-0 mb-1">Guide to Overall Competency Rating</h5>
                <small>Overall competency assessment, filled in by superiors referring to the definition of rating (1-5).</small>
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
                    <td class="font-weight-bold" style="width: 85%;">OVERALL COMPETENCY RATING</td>
                    <td class="font-weight-bold text-center overall_competency_score"></td>
                </table>

                <h3 class="font-weight-bold">SECTION III : PERSONAL DEVELOPMENT</h3>
                <h4 class="font-weight-bold mb-0">Job & Personal Development</h4>
                <small>List any areas, which with management’s help or specific training, could improve your overall performance and develop your competences and skills.</small>
                <table class="table table-bordered mt-2">
                    <thead>
                        <tr><th>By Employee</th><th>By Superior</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="personal_development_employee"></td>
                            <td class="personal_development_superior"></td>
                        </tr>
                    </tbody>
                </table>
                <h4 class="font-weight-bold mb-0">Career Development & Ambitions</h4>
                <small>Looking ahead, please indicate how you would like to see your present job and career development over the next five years' time frame.</small>
                <table class="table table-bordered mt-2">
                    <thead>
                        <tr><th>By Employee</th><th>By Superior</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="career_development_employee"></td>
                            <td class="career_development_superior"></td>
                        </tr>
                    </tbody>
                </table>

                <h3 class="font-weight-bold">SECTION IV : PERSONAL MILESTONES FOR NEXT YEAR</h3>
                <small>To be completed by Employee and agreed by Superiors</small><br>
                <small>You must specify the Quantitative measurements & Timeline for each milestone.</small>
                <div class="table-milestone_next mt-2"></div>
                <h3 class="font-weight-bold">SECTION V : PERFORMANCE REVIEW</h3>
                <h4 class="font-weight-bold mb-0">Strength & Area Improvements</h4>
                <small>Summary of appraisal identifying any special circumstances influencing performance and areas for further development/improvement</small>
                <table class="table table-striped table-bordered mt-2">
                    <td class="improvement"></td>
                </table>
                <h4 class="font-weight-bold">Feedback from Superior and Superior's Superior</h4>
                <table class="table table-striped table-bordered">
                    <td class="superior_feedback"></td>
                </table>
                <table class="table table-striped table-bordered mb-0">
                    <td class="font-weight-bold" style="width: 85%;">OVERALL MILESTONES RATING</td>
                    <td class="font-weight-bold text-center overall_milestone_score"></td>
                </table>
                <table class="table table-striped table-bordered mb-0">
                    <td class="font-weight-bold" style="width: 85%;">OVERALL COMPETENCIES RATING</td>
                    <td class="font-weight-bold text-center overall_competency_score"></td>
                </table>
                <table class="table table-striped table-bordered">
                    <td class="font-weight-bold" style="width: 85%;">OVERALL JOB PERFORMANCE RATING</td>
                    <td class="font-weight-bold text-center overall_performance_score"></td>
                </table>
                <h5 class="mt-2">Guide to Overall Job Performance Rating</h5>
                <table class="table table-bordered mb-2">
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
                                        <div>
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
                    <div class="col-md-9">
                        <table class="table table-bordered table-signature" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th colspan="3" style="text-align: center;"> APPROVED BY </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center" style="width: 33.3%;">
                                        <div>
                                            <span class="position_approval_1"></span><br>
                                            <span class="image_approval_1"></span><br>
                                            <span class="name_approval_1"></span><br>
                                            <span class="nik_approval_1"></span><br>
                                            <span class="date_approval_1"></span>
                                        </div>
                                    </td>
                                    <td class="text-center" style="width: 33.3%;">
                                        <div>
                                            <span class="position_approval_2"></span><br>
                                            <span class="image_approval_2"></span><br>
                                            <span class="name_approval_2"></span><br>
                                            <span class="nik_approval_2"></span><br>
                                            <span class="date_approval_2"></span>
                                        </div>
                                    </td>
                                    <td class="text-center" style="width: 33.3%;">
                                        <div>
                                            <span class="position_approval_3"></span><br>
                                            <span class="image_approval_3"></span><br>
                                            <span class="name_approval_3"></span><br>
                                            <span class="nik_approval_3"></span><br>
                                            <span class="date_approval_3"></span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <table class="table table-bordered table-signature" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th colspan="3" style="text-align: center;"> APPROVED BY </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center" style="width: 33.3%;">
                                        <div>
                                            <span class="position_approval_4"></span><br>
                                            <span class="image_approval_4"></span><br>
                                            <span class="name_approval_4"></span><br>
                                            <span class="nik_approval_4"></span><br>
                                            <span class="date_approval_4"></span>
                                        </div>
                                    </td>
                                    <td class="text-center" style="width: 33.3%;">
                                        <div>
                                            <span class="position_approval_5"></span><br>
                                            <span class="image_approval_5"></span><br>
                                            <span class="name_approval_5"></span><br>
                                            <span class="nik_approval_5"></span><br>
                                            <span class="date_approval_5"></span>
                                        </div>
                                    </td>
                                    <td class="text-center" style="width: 33.3%;">
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
            </div>
            <div class="modal-footer text-right">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL VIEW APPRAISAL CLOSED -->

<script>

$(document).on('click', '.btn-view_closed', function(e) {
    var modal = $('#viewAppraisalConfidential');

    $.ajax({
        type : "GET",
        url : "{{ url('api/appraisal/detail') }}?id="+e.currentTarget.dataset.id,
        dataType : "JSON",
        success : function(res) {
            modal.find('.employee_nik').html(res.appraisal.user_nik);
            modal.find('.employee_name').html(res.appraisal.user_name);
            modal.find('.department').html(res.appraisal.department_name);
            modal.find('.level').html(res.appraisal.grade_group_name);
            modal.find('.period').html(res.period.period_name);
            modal.find('.appraisal_status').html(res.appraisal.appraisal_status);

            var milestone = '';
            var milestone_count = 1;
            $.each(res.milestone, function(key, val) {
                if(key > 0 && val['milestone_id'] == res.milestone[(key-1)]['milestone_id']) {
                    milestone += ''+
                        '<tr>'+
                            '<td style="text-align: center; vertical-align: middle;">'+milestone_count+'</td>'+
                            '<td>'+val['milestone_description'].replace(/\n/g, '<br>')+'</td>'+
                            '<td>'+val['milestone_measurement'].replace(/\n/g, '<br>')+'</td>'+
                            '<td>'+val['employee_assessment'].replace(/\n/g, '<br>')+'</td>'+
                            '<td>'+val['superior_assessment'].replace(/\n/g, '<br>')+'</td>'+
                            '<td style="text-align: center; vertical-align: middle;">'+val['superior_score']+'</td>'+
                        '</tr>';
                } else {
                    milestone += ''+
                        '<table class="table table-bordered">'+
                            '<thead>'+
                                '<tr><th colspan="6" style="text-align: center;">'+val['milestone_eng']+'</th></tr>'+
                                '<tr>'+
                                    '<th style="text-align: center; width: 50px;"> No </th>'+
                                    '<th> Milestone Description </th>'+
                                    '<th> Milestone Measurement </th>'+
                                    '<th> Employee\'s Assessment </th>'+
                                    '<th> Superior\'s Assessment </th>'+
                                    '<th style="text-align: center;"> Superior\'s Score </th>'+
                                '</tr>'+
                            '</thead><tbody>'+
                                '<tr>'+
                                    '<td style="text-align: center; vertical-align: middle;">'+milestone_count+'</td>'+
                                    '<td>'+val['milestone_description'].replace(/\n/g, '<br>')+'</td>'+
                                    '<td>'+val['milestone_measurement'].replace(/\n/g, '<br>')+'</td>'+
                                    '<td>'+val['employee_assessment'].replace(/\n/g, '<br>')+'</td>'+
                                    '<td>'+val['superior_assessment'].replace(/\n/g, '<br>')+'</td>'+
                                    '<td style="text-align: center; vertical-align: middle;">'+val['superior_score']+'</td>'+
                                '</tr>';
                }

                milestone_count++;

                if(key < (res.milestone.length-1) && val['milestone_id'] != res.milestone[(key+1)]['milestone_id']) {
                    milestone += ''+
                        '</tbody>'+
                        '<thead><tr>'+
                            '<th colspan="5"> Total Score </th>'+
                            '<th style="text-align: center; font-size: 13px;">'+val['overall_score']+'</th>'+
                        '</tr></thead>'+
                    '</table>';
                    milestone_count = 1;
                } else if(key == (res.milestone.length-1)) {
                    milestone += ''+
                        '</tbody>'+
                        '<thead><tr>'+
                            '<th colspan="5"> Total Score </th>'+
                            '<th style="text-align: center; font-size: 13px;">'+val['overall_score']+'</th>'+
                        '</tr></thead>'+
                    '</table>';
                    milestone_count = 1;
                }
            });

            modal.find('.table-milestone').html(milestone);

            var beyond_milestone = '';
            if(res.appraisal.beyond_milestone != null) {
                beyond_milestone = ''+
                    '<table class="table table-bordered">'+
                        '<thead>'+
                            '<tr>'+
                                '<th> Achievement Beyond Milestone </th>'+
                                '<th style="text-align: center;"> Superior\'s Score </th>'+
                            '</tr>'+
                        '</thead>'+
                        '<tbody>'+
                            '<tr>'+
                                '<td>'+res.appraisal.beyond_milestone.replace(/\r\r/g, '<br>')+'</td>'+
                                '<td style="text-align: center; vertical-align: middle;">'+res.appraisal.beyond_milestone_score+'</td>'+
                            '</tr>'+
                        '</tbody>'+
                    '</table>';
            }

            modal.find('.beyond_milestone').html(beyond_milestone);

            modal.find('.milestone_feedback').html(res.appraisal.milestone_feedback.replace(/\n/g, '<br>'));
            modal.find('.overall_milestone_score').html(res.appraisal.overall_milestone_score);

            var competency = '';
            $.each(res.competency, function(key, val) {
                competency += '<tr>'+
                    '<td style="text-align: center; vertical-align: middle;">'+(key+1)+'</td>'+
                    '<td><b>'+val['competency_title']+'</b><br>'+val['competency_eng'].replace(/\n/g, '<br>')+'</td>'+
                    '<td>'+val['proficiency_'+val['employee_rating']+'_eng'].replace(/\n/g, '<br>')+'</td>'+
                    '<td>'+val['proficiency_'+val['superior_rating']+'_eng'].replace(/\n/g, '<br>')+'</td>'+
                '</tr>';
            });

            modal.find('.table-competency tbody').html(competency);

            modal.find('.competency_feedback').html(res.appraisal.competency_feedback.replace(/\n/g, '<br>'));
            modal.find('.overall_competency_score').html(res.appraisal.overall_competency_score);

            modal.find('.personal_development_employee').html(res.appraisal.personal_development_employee.replace(/\n/g, '<br>'));
            modal.find('.personal_development_superior').html(res.appraisal.personal_development_superior.replace(/\n/g, '<br>'));
            modal.find('.career_development_employee').html(res.appraisal.career_development_employee.replace(/\n/g, '<br>'));
            modal.find('.career_development_superior').html(res.appraisal.career_development_superior.replace(/\n/g, '<br>'));

            var milestone_next = '';
            var milestone_next_count = 1;
            $.each(res.milestone_next, function(key, val) {
                if(key > 0 && val['milestone_id'] == res.milestone_next[(key-1)]['milestone_id']) {
                    milestone_next += ''+
                        '<tr>'+
                            '<td style="text-align: center; vertical-align: middle;">'+milestone_next_count+'</td>'+
                            '<td>'+val['milestone_description'].replace(/\n/g, '<br>')+'</td>'+
                            '<td>'+val['milestone_measurement'].replace(/\n/g, '<br>')+'</td>'+
                        '</tr>';
                } else {
                    milestone_next += ''+
                        '<table class="table table-bordered">'+
                            '<thead>'+
                                '<tr><th colspan="3" style="text-align: center;">'+val['milestone_eng']+'</th></tr>'+
                                '<tr>'+
                                    '<th style="text-align: center; width: 50px;"> No </th>'+
                                    '<th> Milestone Description </th>'+
                                    '<th> Milestone Measurement </th>'+
                                '</tr>'+
                            '</thead><tbody>'+
                                '<tr>'+
                                    '<td style="text-align: center; vertical-align: middle;">'+milestone_next_count+'</td>'+
                                    '<td>'+val['milestone_description'].replace(/\n/g, '<br>')+'</td>'+
                                    '<td>'+val['milestone_measurement'].replace(/\n/g, '<br>')+'</td>'+
                                '</tr>';
                }

                milestone_next_count++;

                if(key < (res.milestone_next.length-1) && val['milestone_id'] != res.milestone_next[(key+1)]['milestone_id']) {
                    milestone_next += '</tbody></table>';
                    milestone_next_count = 1;
                }
            });

            modal.find('.table-milestone_next').html(milestone_next);

            modal.find('.improvement').html(res.appraisal.improvement.replace(/\n/g, '<br>'));
            modal.find('.superior_feedback').html(res.appraisal.superior_feedback.replace(/\n/g, '<br>'));
            modal.find('.overall_performance_score').html(res.appraisal.overall_performance_score);

            var employee_feedback = '';
            if(res.appraisal.employee_feedback != null) {
                employee_feedback += ''+
                    '<h4 class="font-weight-bold mb-0 mt-3">Employee\'s Comments On Appraisal</h4>'+
                    '<small>To be completed by employee after superior shares the performance rating with employee</small>'+
                    '<table class="table table-bordered mt-2">'+
                        '<td>'+res.appraisal.employee_feedback.replace(/\n/g, '<br>')+'</td>'+
                    '</table>';
            }

            modal.find('.employee_feedback').html(employee_feedback);

            modal.find('.position_proposed').html(res.appraisal.user_title);
            modal.find('.name_proposed').html(res.appraisal.user_name);
            modal.find('.nik_proposed').html(res.appraisal.user_nik);
            modal.find('.date_proposed').html(moment(res.appraisal.created_at).format('DD MMM YYYY'));

            var image = '<img src="{{ asset("images/approved.png") }}" style="max-height: 100%; max-width: 75%;">';

            if(res.appraisal.appraisal_approval_nik_1 != null) {
                if(res.appraisal.appraisal_approval_status_1 == '1') {
                    modal.find('.position_approval_1').html(res.appraisal.approval1_title);
                    modal.find('.image_approval_1').html(image);
                    modal.find('.name_approval_1').html(res.appraisal.appraisal_approval_name_1);
                    modal.find('.nik_approval_1').html(res.appraisal.appraisal_approval_nik_1);
                    modal.find('.date_approval_1').html(moment(res.appraisal.appraisal_approval_date_1).format('DD MMM YYYY'));
                } else {
                    modal.find('.position_approval_1').html('Waiting for Approval');
                    modal.find('.name_approval_1').html(res.appraisal.appraisal_approval_name_1);
                    modal.find('.nik_approval_1').html(res.appraisal.appraisal_approval_nik_1);
                }
            } else {
                modal.find('.position_approval_1').html('');
                modal.find('.image_approval_1').html('');
                modal.find('.name_approval_1').html('');
                modal.find('.nik_approval_1').html('');
                modal.find('.date_approval_1').html('');
            }

            if(res.appraisal.appraisal_approval_nik_2 != null) {
                if(res.appraisal.appraisal_approval_status_2 == '1') {
                    modal.find('.position_approval_2').html(res.appraisal.approval2_title);
                    modal.find('.image_approval_2').html(image);
                    modal.find('.name_approval_2').html(res.appraisal.appraisal_approval_name_2);
                    modal.find('.nik_approval_2').html(res.appraisal.appraisal_approval_nik_2);
                    modal.find('.date_approval_2').html(moment(res.appraisal.appraisal_approval_date_2).format('DD MMM YYYY'));
                } else {
                    modal.find('.position_approval_2').html('Waiting for Approval');
                    modal.find('.name_approval_2').html(res.appraisal.appraisal_approval_name_2);
                    modal.find('.nik_approval_2').html(res.appraisal.appraisal_approval_nik_2);
                }
            } else {
                modal.find('.position_approval_2').html('');
                modal.find('.image_approval_2').html('');
                modal.find('.name_approval_2').html('');
                modal.find('.nik_approval_2').html('');
                modal.find('.date_approval_2').html('');
            }

            if(res.appraisal.appraisal_approval_nik_3 != null) {
                if(res.appraisal.appraisal_approval_status_3 == '1') {
                    modal.find('.position_approval_3').html(res.appraisal.approval3_title);
                    modal.find('.image_approval_3').html(image);
                    modal.find('.name_approval_3').html(res.appraisal.appraisal_approval_name_3);
                    modal.find('.nik_approval_3').html(res.appraisal.appraisal_approval_nik_3);
                    modal.find('.date_approval_3').html(moment(res.appraisal.appraisal_approval_date_3).format('DD MMM YYYY'));
                } else {
                    modal.find('.position_approval_3').html('Waiting for Approval');
                    modal.find('.name_approval_3').html(res.appraisal.appraisal_approval_name_3);
                    modal.find('.nik_approval_3').html(res.appraisal.appraisal_approval_nik_3);
                }
            } else {
                modal.find('.position_approval_3').html('');
                modal.find('.image_approval_3').html('');
                modal.find('.name_approval_3').html('');
                modal.find('.nik_approval_3').html('');
                modal.find('.date_approval_3').html('');
            }

            if(res.appraisal.appraisal_approval_nik_4 != null) {
                if(res.appraisal.appraisal_approval_status_4 == '1') {
                    modal.find('.position_approval_4').html(res.appraisal.approval4_title);
                    modal.find('.image_approval_4').html(image);
                    modal.find('.name_approval_4').html(res.appraisal.appraisal_approval_name_4);
                    modal.find('.nik_approval_4').html(res.appraisal.appraisal_approval_nik_4);
                    modal.find('.date_approval_4').html(moment(res.appraisal.appraisal_approval_date_4).format('DD MMM YYYY'));
                } else {
                    modal.find('.position_approval_4').html('Waiting for Approval');
                    modal.find('.name_approval_4').html(res.appraisal.appraisal_approval_name_4);
                    modal.find('.nik_approval_4').html(res.appraisal.appraisal_approval_nik_4);
                }
            } else {
                modal.find('.position_approval_4').html('');
                modal.find('.image_approval_4').html('');
                modal.find('.name_approval_4').html('');
                modal.find('.nik_approval_4').html('');
                modal.find('.date_approval_4').html('');
            }

            if(res.appraisal.appraisal_approval_nik_5 != null) {
                if(res.appraisal.appraisal_approval_status_5 == '1') {
                    modal.find('.position_approval_5').html(res.appraisal.approval5_title);
                    modal.find('.image_approval_5').html(image);
                    modal.find('.name_approval_5').html(res.appraisal.appraisal_approval_name_5);
                    modal.find('.nik_approval_5').html(res.appraisal.appraisal_approval_nik_5);
                    modal.find('.date_approval_5').html(moment(res.appraisal.appraisal_approval_date_5).format('DD MMM YYYY'));
                } else {
                    modal.find('.position_approval_5').html('Waiting for Approval');
                    modal.find('.name_approval_5').html(res.appraisal.appraisal_approval_name_5);
                    modal.find('.nik_approval_5').html(res.appraisal.appraisal_approval_nik_5);
                }
            } else {
                modal.find('.position_approval_5').html('');
                modal.find('.image_approval_5').html('');
                modal.find('.name_approval_5').html('');
                modal.find('.nik_approval_5').html('');
                modal.find('.date_approval_5').html('');
            }

            if(res.appraisal.appraisal_approval_nik_6 != null) {
                if(res.appraisal.appraisal_approval_status_6 == '1') {
                    modal.find('.position_approval_6').html(res.appraisal.approval6_title);
                    modal.find('.image_approval_6').html(image);
                    modal.find('.name_approval_6').html(res.appraisal.appraisal_approval_name_6);
                    modal.find('.nik_approval_6').html(res.appraisal.appraisal_approval_nik_6);
                    modal.find('.date_approval_6').html(moment(res.appraisal.appraisal_approval_date_6).format('DD MMM YYYY'));
                } else {
                    modal.find('.position_approval_6').html('Waiting for Approval');
                    modal.find('.name_approval_6').html(res.appraisal.appraisal_approval_name_6);
                    modal.find('.nik_approval_6').html(res.appraisal.appraisal_approval_nik_6);
                }
            } else {
                modal.find('.position_approval_6').html('');
                modal.find('.image_approval_6').html('');
                modal.find('.name_approval_6').html('');
                modal.find('.nik_approval_6').html('');
                modal.find('.date_approval_6').html('');
            }

            if(res.appraisal.appraisal_approval_status_hr == '1') {
                modal.find('.position_approval_hr').html(res.appraisal.hr_title);
                modal.find('.image_approval_hr').html(image);
                modal.find('.name_approval_hr').html(res.appraisal.appraisal_approval_name_hr);
                modal.find('.nik_approval_hr').html(res.appraisal.appraisal_approval_nik_hr);
                modal.find('.date_approval_hr').html(moment(res.appraisal.appraisal_approval_date_hr).format('DD MMM YYYY'));
            } else {
                modal.find('.position_approval_hr').html('Waiting for Approval');
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

</script>
