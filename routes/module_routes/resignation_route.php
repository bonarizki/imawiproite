<?php
/**
 * Define the "web" routes for the application.
 * 
 * These routes all receive session state, CSRF protection, etc.
 *
 * RESIGNATION ROUTE
 */

 /** Breadcumb */
Route::get('breadcumResignation','HomeController@breadcumResignation')->name('breadcumResignation');

Route::get('/resignation', 'Resignation\DashboardController@index')->middleware('access');
Route::get('/resignation/analytics', 'Resignation\DashboardController@analytics');
Route::get('api/resignation/dashboard/count', 'Resignation\DashboardController@getResignCount');
Route::get('api/resignation/dashboard/talent', 'Resignation\DashboardController@getAttritionTalent');
Route::get('api/resignation/dashboard/initiation', 'Resignation\DashboardController@getAttritionInitiation');
Route::get('api/resignation/dashboard/department', 'Resignation\DashboardController@getResignationByDept');
Route::get('api/resignation/dashboard/reason', 'Resignation\DashboardController@getAttritionReason');
Route::get('api/resignation/dashboard/years', 'Resignation\DashboardController@getAttritionYears');
Route::get('api/resignation/dashboard/gradeGroup', 'Resignation\DashboardController@getResignationByGradeGroup');
Route::get('api/resignation/dashboard/ageCategory', 'Resignation\DashboardController@getResignationByAgeCategory');


/**ROUTE VIEW */
Route::middleware(['access'])->group(function () {
    Route::view('resignation/menu', 'resignation/menu'); // Resignation Menu
    Route::view('resignation/access', 'resignation/access'); //Resignation Access
    Route::view('resignation/access-position', 'resignation/accessPosition'); //Resignation Access Position
    Route::view('resignation/resign', 'resignation/resign'); // Resign Request
    Route::view('resignation/status', 'resignation/status'); // Resign Status
    Route::view('resignation/clearance', 'resignation/ManagementClearance'); // Resign Clearance Master
    Route::view('resignation/approval/clearance', 'resignation/ApprovalClearance'); // Clearance Approval
    Route::view('resignation/approval', 'resignation/approval'); // Resign Approval
    Route::view('resignation/report/AR', 'resignation/report/AttritionRate'); // Resignantaion Report AR
    Route::view('resignation/report/AR/talent', 'resignation/report/Talent'); // Resignantaion Report Talent
    Route::view('resignation/report/AR/initiation', 'resignation/report/Initiation'); // Resignantaion Report Initation
    Route::view('resignation/report/feedback', 'resignation/report/feedback'); // Resignantaion Report Feedback
});

/** Resignation Master Menu */
Route::get('/resignation/all/menu','Resignation\MenuController@getAllMenu')->name('ResignationGetMenu');
Route::get('/resignation/all/menuChild/{id}','Resignation\MenuController@getChildMenu')->name('ResignationGetMenuChild');
Route::get('/resignation/all/menuGrandChild/{id}','Resignation\MenuController@getGrandChildMenu')->name('ResignationGetMenuGrandChild');
Route::post('/resignation/insert/menu','Resignation\MenuController@store')->name('ResignationInsertMenu');
Route::get('/resignation/detail/menu','Resignation\MenuController@show')->name('ResignationGetDetailMenu');
Route::put('/resignation/update/menu','Resignation\MenuController@update')->name('ResignationUpdateMenu');
Route::delete('/resignation/delete/menu','Resignation\MenuController@destroy')->name('ResignationDeleteMenu');

/** Resignation Master Access */
Route::get('/resgination/all/access/user','Resignation\AccessController@getAllAcces')->name('ResignationGetAccess');
Route::get('/resignation/detail/access/{id}','Resignation\AccessController@show')->name('ResignationGetDetailAccess');
Route::get('/resignation/menu/access','Resignation\AccessController@getMenu')->name('ResignationGetAllMenu');
Route::put('/resignation/access/update','Resignation\AccessController@update')->name('ResignationAccessUpdate');

/** Resignation Master Access Position */
Route::get('resgination/all/access-position/data','Resignation\AccessPositionController@show')->name('Resignationshow');
Route::get('resgination/all/access-position/{id}','Resignation\AccessPositionController@detail')->name('Resignationdetail');
Route::put('resgination/all/access-position','Resignation\AccessPositionController@update')->name('Resignationupdate');

/** Resignation Resign */
Route::post('/resignation/request/resign','Resignation\ResignController@store')->name('insertResign');

/** Resignation Status */
Route::get('/resignation/statusById','Resignation\StatusController@getData')->name('getData');
Route::get('resignation/statusAll','Resignation\StatusController@geDataAll')->name('geDataAll');
Route::get('resignation/statusById/unproceed','Resignation\StatusController@getDataUnproceed')->name('getDataUnproceed');
Route::get('resignation/statusAll/unproceed','Resignation\StatusController@geDataAllUnproceed')->name('geDataAllUnproceed');
Route::get('resignation/user/department','Resignation\StatusController@getUserByDepartment')->name('getUserByDepartment');
Route::get('resignation/user/department-all','Resignation\StatusController@getUserAll')->name('getUserAll');
Route::get('resignation/user/nik','Resignation\StatusController@getUserByNik')->name('getUserByNik');
Route::put('resignation/cancel/resign','Resignation\StatusController@cancelResign')->name('cancelResign');
Route::put('resignation/handover/resign','Resignation\StatusController@handoverResign')->name('handoverResign');
Route::post('resignation/insert/feedback','Resignation\StatusController@insertFeedback')->name('insertFeedback');
Route::get('resignation/status/remind-feedback/{id}','Resignation\StatusController@remindFeedBack')->name('insertFeedback');

/** Resignation Clearance management */
Route::get('resignation/clearance/data','Resignation\ClearanceController@show')->name('showClearance');
Route::post('resignation/clearance','Resignation\ClearanceController@store')->name('insertClearance');
Route::get('resignation/clearance/{id}','Resignation\ClearanceController@detail')->name('detailClearance');
Route::put('resignation/clearance','Resignation\ClearanceController@update')->name('updateClearance');
Route::delete('resignation/clearance','Resignation\ClearanceController@delete')->name('deleteClearance');

/** Resignation Clearance Approval */
Route::get('resignation/approva/clearance/data','Resignation\ClearanceController@GetData')->name('getDataApprovalClearance');
Route::post('resignation/approval/clearance','Resignation\ClearanceController@storeAnswer')->name('insertClearance');
Route::get('resignation/approval/clearance/answer','Resignation\ClearanceController@showAnswer')->name('answerClearance');

/** Resignation Approval */
Route::get('resignation/getDataForApprove','Resignation\ApproveController@show')->name('getDataForApprove');
Route::put('resignation/update/Approval','Resignation\ApproveController@updateApproval')->name('updateApproval');
Route::get('resignation/detail','Resignation\ApproveController@getDetailResign')->name('getDetailResign');
Route::put('resignation/update/Resign','Resignation\ApproveController@UpdateResign')->name('UpdateResign');

/** Resignation Report */
Route::get('resignation/report/reference_letter/{id}','Resignation\ReportContorller@ReferenceLetter')->name('ReferenceLetter');
Route::get('resignation/report/clearance/{id}','Resignation\ReportContorller@Clearance')->name('clearance');
Route::get('resignation/report/feedback/{id}','Resignation\ReportContorller@feedbackByID')->name('FeedBacKID');

/** By Attrition Rate */
Route::get('resignation/report/AR/download','Resignation\ReportContorller@ARDownload')->name('ARPeriod');
Route::post('resignation/report/AR/data','Resignation\ReportContorller@getDataForview')->name('getDataForview');

/** resignation report atritiion rate base on talent */
Route::get('resignation/report/AR/talent/download','Resignation\ReportContorller@ARTalentDownload')->name('ARTalentPeriod');
Route::post('resignation/report/AR/talent/data','Resignation\ReportContorller@getDataTalentForview')->name('getDataTalentForview');

/** resignation report atritiion rate base on initiation */
Route::get('resignation/report/AR/initiation/download','Resignation\ReportContorller@ARInitiationDownload')->name('ARTalentPeriod');
Route::post('resignation/report/AR/initiation/data','Resignation\ReportContorller@getDataInitiationForview')->name('getDataInitiationForview');
Route::get('resignation/report/AR/initiation/download','Resignation\ReportContorller@ARInitiationDownload')->name('ARInitiationPeriod');

/** resignation report feedback */
Route::post('resignation/report/feedback/data','Resignation\ReportContorller@getDataFeedbackForview')->name('getDataFeedbackForview');
Route::get('resignation/report/feedback-download','Resignation\ReportContorller@downloadFeedback')->name('downloadFeedback');


Route::get('resignation/report/reason', 'Resignation\ReportContorller@AttritionBasedOnReason')->middleware('access');
Route::get('api/resignation/report/reason', 'Resignation\ReportContorller@getAttritionBasedOnReason');
Route::get('resignation/report/reason/export', 'Resignation\ReportContorller@exportAttritionBasedOnReason');

Route::get('resignation/report/department', 'Resignation\ReportContorller@AttritionDepartment')->middleware('access');
Route::get('api/resignation/report/department', 'Resignation\ReportContorller@getAttritionDepartment');
Route::get('resignation/report/department/export', 'Resignation\ReportContorller@exportAttritionDepartment');

Route::get('resignation/report/years', 'Resignation\ReportContorller@AttritionBasedOnYears')->middleware('access');
Route::get('api/resignation/report/years', 'Resignation\ReportContorller@getAttritionBasedOnYears');
Route::get('resignation/report/years/export', 'Resignation\ReportContorller@exportAttritionBasedOnYears');