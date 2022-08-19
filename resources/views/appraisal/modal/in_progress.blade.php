<!-- BEGIN MODAL VIEW APPRAISAL IN PROGRESS -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="viewAppraisalInProgress">
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
                <div class="table-milestone mt-3"></div>

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
                            <th> Proficiency Level Assessment from Employee </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <h3 class="font-weight-bold">SECTION III : PERSONAL DEVELOPMENT</h3>
                <h4 class="font-weight-bold mb-0">Job & Personal Development</h4>
                <small>List any areas, which with management’s help or specific training, could improve your overall performance and develop your competences and skills.</small>
                <table class="table table-bordered mt-2">
                    <td class="personal_development_employee"></td>
                </table>
                <h4 class="font-weight-bold mb-0">Career Development & Ambitions</h4>
                <small>Looking ahead, please indicate how you would like to see your present job and career development over the next five years' time frame.</small>
                <table class="table table-bordered mt-2">
                    <td class="career_development_employee"></td>
                </table>
                <h3 class="font-weight-bold">SECTION IV : PERSONAL MILESTONES FOR NEXT YEAR</h3>
                <small>To be completed by Employee and agreed by Superiors</small><br>
                <small>You must specify the Quantitative measurements & Timeline for each milestone.</small>
                <div class="table-milestone_next mt-2"></div>
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
                                        <div style="min-height: 130px;">
                                            <span class="position_approval_1"></span><br>
                                            <span class="image_approval_1"></span><br>
                                            <span class="name_approval_1"></span><br>
                                            <span class="nik_approval_1"></span><br>
                                            <span class="date_approval_1"></span>
                                        </div>
                                    </td>
                                    <td class="text-center" style="width: 33.3%;">
                                        <div style="min-height: 130px;">
                                            <span class="position_approval_2"></span><br>
                                            <span class="image_approval_2"></span><br>
                                            <span class="name_approval_2"></span><br>
                                            <span class="nik_approval_2"></span><br>
                                            <span class="date_approval_2"></span>
                                        </div>
                                    </td>
                                    <td class="text-center" style="width: 33.3%;">
                                        <div style="min-height: 130px;">
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
                                        <div style="min-height: 130px;">
                                            <span class="position_approval_4"></span><br>
                                            <span class="image_approval_4"></span><br>
                                            <span class="name_approval_4"></span><br>
                                            <span class="nik_approval_4"></span><br>
                                            <span class="date_approval_4"></span>
                                        </div>
                                    </td>
                                    <td class="text-center" style="width: 33.3%;">
                                        <div style="min-height: 130px;">
                                            <span class="position_approval_5"></span><br>
                                            <span class="image_approval_5"></span><br>
                                            <span class="name_approval_5"></span><br>
                                            <span class="nik_approval_5"></span><br>
                                            <span class="date_approval_5"></span>
                                        </div>
                                    </td>
                                    <td class="text-center" style="width: 33.3%;">
                                        <div style="min-height: 130px;">
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
                                        <div style="min-height: 130px;">
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

$(document).on('click', '.btn-view_in_progress', function(e) {
    var modal = $('#viewAppraisalInProgress');

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
                        '</tr>';
                } else {
                    milestone += ''+
                        '<table class="table table-bordered">'+
                            '<thead>'+
                                '<tr><th colspan="4" style="text-align: center;">'+val['milestone_eng']+'</th></tr>'+
                                '<tr>'+
                                    '<th style="text-align: center; width: 50px;"> No </th>'+
                                    '<th> Milestone Description </th>'+
                                    '<th> Milestone Measurement </th>'+
                                    '<th> Employee Assessment </th>'+
                                '</tr>'+
                            '</thead><tbody>'+
                                '<tr>'+
                                    '<td style="text-align: center; vertical-align: middle;">'+milestone_count+'</td>'+
                                    '<td>'+val['milestone_description'].replace(/\n/g, '<br>')+'</td>'+
                                    '<td>'+val['milestone_measurement'].replace(/\n/g, '<br>')+'</td>'+
                                    '<td>'+val['employee_assessment'].replace(/\n/g, '<br>')+'</td>'+
                                '</tr>';
                }

                milestone_count++;
                
                if(key < (res.milestone.length-1) && val['milestone_id'] != res.milestone[(key+1)]['milestone_id']) {
                    milestone += '</tbody></table>';
                    milestone_count = 1;
                }
            });

            modal.find('.table-milestone').html(milestone);

            var competency = '';
            $.each(res.competency, function(key, val) {
                competency += '<tr>'+
                    '<td style="text-align: center; vertical-align: middle;">'+(key+1)+'</td>'+
                    '<td><b>'+val['competency_title']+'</b><br>'+val['competency_eng'].replace(/\n/g, '<br>')+'</td>'+
                    '<td>'+val['proficiency_'+val['employee_rating']+'_eng'].replace(/\n/g, '<br>')+'</td>'+
                '</tr>';
            });

            modal.find('.table-competency tbody').html(competency);

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

            modal.find('.personal_development_employee').html(res.appraisal.personal_development_employee.replace(/\n/g, '<br>'));
            modal.find('.career_development_employee').html(res.appraisal.career_development_employee.replace(/\n/g, '<br>'));

            modal.find('.position_proposed').html(res.appraisal.appraisal_user_title);
            modal.find('.name_proposed').html(res.appraisal.appraisal_user_name);
            modal.find('.nik_proposed').html(res.appraisal.appraisal_user_nik);
            modal.find('.date_proposed').html(moment(res.appraisal.created_at).format('DD MMM YYYY'));

            var image = '<img src="{{ asset("images/approved.png") }}" style="max-height: 100%; max-width: 75%;">';

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
                if(res.approval_matrix.approval_nik_2 != null) {
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

            if(res.appraisal.appraisal_approval_status_3 != null) {
                modal.find('.position_approval_3').html(res.appraisal.appraisal_approval_title_3);
                modal.find('.image_approval_3').html((res.appraisal.appraisal_approval_status_3 == '1' ? approved : rejected));
                modal.find('.name_approval_3').html(res.appraisal.appraisal_approval_name_3);
                modal.find('.nik_approval_3').html(res.appraisal.appraisal_approval_nik_3);
                modal.find('.date_approval_3').html(moment(res.appraisal.appraisal_approval_date_3).format('DD MMM YYYY'));
            } else {
                if(res.approval_matrix.approval_nik_3 != null) {
                    modal.find('.position_approval_3').html('<p class="mt-4 mb-3"><i>Waiting for Approval</i></p>');
                    modal.find('.name_approval_3').html(res.approval_matrix.approval_name_3);
                    modal.find('.nik_approval_3').html(res.approval_matrix.approval_nik_3);
                } else {
                    modal.find('.position_approval_3').html('');
                    modal.find('.image_approval_3').html('');
                    modal.find('.name_approval_3').html('');
                    modal.find('.nik_approval_3').html('');
                    modal.find('.date_approval_3').html('');
                }
            }

            if(res.appraisal.appraisal_approval_status_4 != null) {
                modal.find('.position_approval_4').html(res.appraisal.appraisal_approval_title_4);
                modal.find('.image_approval_4').html((res.appraisal.appraisal_approval_status_4 == '1' ? approved : rejected));
                modal.find('.name_approval_4').html(res.appraisal.appraisal_approval_name_4);
                modal.find('.nik_approval_4').html(res.appraisal.appraisal_approval_nik_4);
                modal.find('.date_approval_4').html(moment(res.appraisal.appraisal_approval_date_4).format('DD MMM YYYY'));
            } else {
                if(res.approval_matrix.approval_nik_4 != null) {
                    modal.find('.position_approval_4').html('<p class="mt-4 mb-3"><i>Waiting for Approval</i></p>');
                    modal.find('.name_approval_4').html(res.approval_matrix.approval_name_4);
                    modal.find('.nik_approval_4').html(res.approval_matrix.approval_nik_4);
                } else {
                    modal.find('.position_approval_4').html('');
                    modal.find('.image_approval_4').html('');
                    modal.find('.name_approval_4').html('');
                    modal.find('.nik_approval_4').html('');
                    modal.find('.date_approval_4').html('');
                }
            }

            if(res.appraisal.appraisal_approval_status_5 != null) {
                modal.find('.position_approval_5').html(res.appraisal.appraisal_approval_title_5);
                modal.find('.image_approval_5').html((res.appraisal.appraisal_approval_status_5 == '1' ? approved : rejected));
                modal.find('.name_approval_5').html(res.appraisal.appraisal_approval_name_5);
                modal.find('.nik_approval_5').html(res.appraisal.appraisal_approval_nik_5);
                modal.find('.date_approval_5').html(moment(res.appraisal.appraisal_approval_date_5).format('DD MMM YYYY'));
            } else {
                if(res.approval_matrix.approval_nik_5 != null) {
                    modal.find('.position_approval_5').html('<p class="mt-4 mb-3"><i>Waiting for Approval</i></p>');
                    modal.find('.name_approval_5').html(res.approval_matrix.approval_name_5);
                    modal.find('.nik_approval_5').html(res.approval_matrix.approval_nik_5);
                } else {
                    modal.find('.position_approval_5').html('');
                    modal.find('.image_approval_5').html('');
                    modal.find('.name_approval_5').html('');
                    modal.find('.nik_approval_5').html('');
                    modal.find('.date_approval_5').html('');
                }
            }

            if(res.appraisal.appraisal_approval_status_6 != null) {
                modal.find('.position_approval_6').html(res.appraisal.appraisal_approval_title_6);
                modal.find('.image_approval_6').html((res.appraisal.appraisal_approval_status_6 == '1' ? approved : rejected));
                modal.find('.name_approval_6').html(res.appraisal.appraisal_approval_name_6);
                modal.find('.nik_approval_6').html(res.appraisal.appraisal_approval_nik_6);
                modal.find('.date_approval_6').html(moment(res.appraisal.appraisal_approval_date_6).format('DD MMM YYYY'));
            } else {
                if(res.approval_matrix.approval_nik_6 != null) {
                    modal.find('.position_approval_6').html('<p class="mt-4 mb-3"><i>Waiting for Approval</i></p>');
                    modal.find('.name_approval_6').html(res.approval_matrix.approval_name_6);
                    modal.find('.nik_approval_6').html(res.approval_matrix.approval_nik_6);
                } else {
                    modal.find('.position_approval_6').html('');
                    modal.find('.image_approval_6').html('');
                    modal.find('.name_approval_6').html('');
                    modal.find('.nik_approval_6').html('');
                    modal.find('.date_approval_6').html('');
                }
            }

            if(res.appraisal_approval_status_hr != null) {
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

</script>