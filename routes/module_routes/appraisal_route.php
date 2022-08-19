<?php
/**
 * Define the "web" routes for the application.
 * 
 * These routes all receive session state, CSRF protection, etc.
 *
 * Appraisal Routes
 */

Route::get('/appraisal', 'Appraisal\DashboardController@index')->middleware('access');
Route::get('api/appraisal/dashboard/count', 'Appraisal\DashboardController@appraisalCount');
Route::get('api/appraisal/dashboard/info', 'Appraisal\DashboardController@getAppraisalInfo');
Route::get('api/appraisal/dashboard/participation', 'Appraisal\DashboardController@getEmployeeParticipation');
Route::get('api/appraisal/dashboard/level', 'Appraisal\DashboardController@getEmployeeLevel');
Route::get('api/appraisal/dashboard/years', 'Appraisal\DashboardController@getEmployeeYearsService');
Route::get('api/appraisal/dashboard/staff-participation', 'Appraisal\DashboardController@getStaffParticipation');
Route::get('api/appraisal/dashboard/staff-gender', 'Appraisal\DashboardController@getStaffGender');
Route::get('api/appraisal/dashboard/staff-years', 'Appraisal\DashboardController@getStaffYearsService');

Route::get('/appraisal/form', 'Appraisal\AppraisalFormController@index')->middleware('access');
Route::post('api/appraisal/form', 'Appraisal\AppraisalFormController@store');
Route::post('api/appraisal/form/milestone', 'Appraisal\AppraisalFormController@storeMilestone');
Route::post('api/appraisal/form-staff', 'Appraisal\AppraisalFormController@storeAppraisalStaff');
Route::post('/appraisal/milestone/send-mail', 'Appraisal\AppraisalFormController@sendMilestoneMail');
Route::post('/appraisal/send-mail', 'Appraisal\AppraisalFormController@sendMail');
Route::post('/appraisal/send-feedback-mail', 'Appraisal\AppraisalFormController@sendMailFeedback');

Route::get('/appraisal/status', 'Appraisal\AppraisalStatusController@index')->middleware('access');
Route::post('/appraisal/feedback', 'Appraisal\AppraisalStatusController@feedback');
Route::post('/appraisal/final-score', 'Appraisal\AppraisalStatusController@finalScore');
Route::get('api/appraisal/status', 'Appraisal\AppraisalStatusController@getAppraisal');
Route::get('api/appraisal/detail', 'Appraisal\AppraisalStatusController@appraisalDetail');
Route::get('api/appraisal/detail-staff', 'Appraisal\AppraisalStatusController@appraisalDetailStaff');
Route::post('/appraisal/export', 'Appraisal\AppraisalStatusController@export');

Route::get('/appraisal/approval', 'Appraisal\AppraisalApprovalController@index')->middleware('access');
Route::post('/appraisal/approval', 'Appraisal\AppraisalApprovalController@approvalForm');
Route::get('api/appraisal/approval', 'Appraisal\AppraisalApprovalController@getAppraisal');
Route::post('/appraisal/milestone/approve', 'Appraisal\AppraisalApprovalController@approveMilestone');
Route::post('/appraisal/milestone/reject', 'Appraisal\AppraisalApprovalController@rejectMilestone');
Route::post('/appraisal/draft', 'Appraisal\AppraisalApprovalController@saveAsDraft');
Route::post('/appraisal/approve', 'Appraisal\AppraisalApprovalController@approve');
Route::post('/appraisal/reject', 'Appraisal\AppraisalApprovalController@reject');
Route::post('/appraisal/approve-staff', 'Appraisal\AppraisalApprovalController@approveStaff');
Route::post('/appraisal/send-reject-mail', 'Appraisal\AppraisalApprovalController@sendMailReject');
Route::post('/appraisal/send-approved-mail', 'Appraisal\AppraisalApprovalController@sendMailApproved');

Route::get('/appraisal/report/completed', 'Appraisal\ReportController@completed');
Route::get('api/appraisal/report/completed', 'Appraisal\ReportController@getAppraisalCompleted');
Route::get('api/appraisal/report/completed/export', 'Appraisal\ReportController@exportAppraisalCompleted');
Route::post('api/appraisal/report/upload/temp', 'Appraisal\ReportController@tempUpload');
Route::get('api/appraisal/report/upload/temp/reset', 'Appraisal\ReportController@resetFinalScoreTemp');
Route::post('api/appraisal/report/upload/submit', 'Appraisal\ReportController@submitFinalScore');
Route::get('api/appraisal/report/temp', 'Appraisal\ReportController@getFinalScoreTemp');
Route::post('/appraisal/export-confidential', 'Appraisal\ReportController@exportConfidential');

Route::get('/appraisal/report/score', 'Appraisal\ReportController@score');
Route::get('api/appraisal/report/score', 'Appraisal\ReportController@getAppraisalScore');
Route::get('api/appraisal/report/score/sum', 'Appraisal\ReportController@getAppraisalScoreSum');
Route::get('api/appraisal/report/score/export', 'Appraisal\ReportController@exportAppraisalScore');

Route::get('/appraisal/menu', 'Appraisal\MenuController@index')->middleware('access');
Route::get('api/appraisal/menu', 'Appraisal\MenuController@getMenuParent');
Route::get('api/appraisal/menu/child', 'Appraisal\MenuController@getMenuChild');
Route::get('api/appraisal/menu/grand-child', 'Appraisal\MenuController@getMenuGrandChild');
Route::post('api/appraisal/menu', 'Appraisal\MenuController@store');
Route::post('api/appraisal/menu/update', 'Appraisal\MenuController@update');
Route::post('api/appraisal/menu/delete', 'Appraisal\MenuController@delete');

Route::get('/appraisal/access', 'Appraisal\AccessController@index')->middleware('access');
Route::get('api/appraisal/access', 'Appraisal\AccessController@getAccess');
Route::post('api/appraisal/access/update', 'Appraisal\AccessController@update');

Route::get('/appraisal/access-position', 'Appraisal\AccessPositionController@index')->middleware('access');
Route::get('api/appraisal/access-position', 'Appraisal\AccessPositionController@getAccessPosition');
Route::post('api/appraisal/access-position', 'Appraisal\AccessPositionController@store');
Route::post('api/appraisal/access-position/update', 'Appraisal\AccessPositionController@update');

Route::get('/appraisal/period', 'Appraisal\PeriodController@index')->middleware('access');
Route::get('api/appraisal/period', 'Appraisal\PeriodController@getPeriod');
Route::post('api/appraisal/period/update', 'Appraisal\PeriodController@update');

Route::get('/appraisal/milestone', 'Appraisal\MilestoneController@index')->middleware('access');
Route::get('api/appraisal/milestone', 'Appraisal\MilestoneController@getMilestone');
Route::post('api/appraisal/milestone', 'Appraisal\MilestoneController@store');
Route::post('api/appraisal/milestone/update', 'Appraisal\MilestoneController@update');
Route::post('api/appraisal/milestone/activate', 'Appraisal\MilestoneController@activate');

Route::get('/appraisal/competency', 'Appraisal\CompetencyController@index')->middleware('access');
Route::get('api/appraisal/competency', 'Appraisal\CompetencyController@getCompetency');
Route::post('api/appraisal/competency', 'Appraisal\CompetencyController@store');
Route::post('api/appraisal/competency/update', 'Appraisal\CompetencyController@update');
Route::post('api/appraisal/competency/activate', 'Appraisal\CompetencyController@activate');
Route::post('api/appraisal/competency/upload/temp', 'Appraisal\CompetencyController@tempUpload');
Route::get('api/appraisal/competency/upload/temp/reset', 'Appraisal\CompetencyController@resetCompetencyTemp');
Route::post('api/appraisal/competency/upload/submit', 'Appraisal\CompetencyController@submitCompetency');
Route::get('api/appraisal/competency/temp', 'Appraisal\CompetencyController@getCompetencyTemp');

Route::get('/appraisal/competency-staff', 'Appraisal\CompetencyStaffController@index')->middleware('access');
Route::get('api/appraisal/competency-staff', 'Appraisal\CompetencyStaffController@getCompetencyStaff');
Route::post('api/appraisal/competency-staff', 'Appraisal\CompetencyStaffController@store');
Route::post('api/appraisal/competency-staff/update', 'Appraisal\CompetencyStaffController@update');
Route::post('api/appraisal/competency-staff/activate', 'Appraisal\CompetencyStaffController@activate');