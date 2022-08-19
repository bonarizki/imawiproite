<?php
/**
 * Define the "web" routes for the application.
 * 
 * These routes all receive session state, CSRF protection, etc.
 *
 * RECRUITMENT ROUTE
 */

Route::get('/recruitment', 'Recruitment\DashboardController@index')->middleware('access');
Route::get('/recruitment/analytics', 'Recruitment\DashboardController@analytics')->middleware('access');
Route::get('api/recruitment/chart/count', 'Recruitment\DashboardController@getRecruitCount');
Route::get('api/recruitment/chart/resource', 'Recruitment\DashboardController@getHiringResource');
Route::get('api/recruitment/chart/request', 'Recruitment\DashboardController@getRequestByDept');
Route::get('api/recruitment/chart/leadtime', 'Recruitment\DashboardController@getAverageLeadTime');
Route::get('api/recruitment/chart/costhire', 'Recruitment\DashboardController@getAverageCostHire');

Route::get('/recruitment/recruit', 'Recruitment\RecruitController@index')->middleware('access');
Route::post('/recruitment/recruit', 'Recruitment\RecruitController@store');
Route::post('/recruitment/recruit/update', 'Recruitment\RecruitController@update');
Route::get('/recruitment/status', 'Recruitment\RecruitController@status')->middleware('access');
Route::post('/recruitment/cancel', 'Recruitment\RecruitController@cancel');
Route::get('/recruitment/approval', 'Recruitment\RecruitController@approval')->middleware('access');
Route::post('/recruitment/approve', 'Recruitment\RecruitController@approve');
Route::post('/recruitment/reject', 'Recruitment\RecruitController@reject');
Route::get('/recruitment/export/{id}', 'Recruitment\RecruitController@export');
Route::get('/recruitment/export-fulfilled/{id}', 'Recruitment\RecruitController@exportFulfilled');
Route::post('/recruitment/process', 'Recruitment\RecruitController@process');
Route::get('api/recruitment/recruit', 'Recruitment\RecruitController@getRecruit');
Route::get('api/recruitment/get-recruit', 'Recruitment\RecruitController@getRecruitById');
Route::post('/recruitment/temp/osa', 'Recruitment\RecruitController@tempOSA');

Route::get('/recruitment/report', 'Recruitment\ReportController@index')->middleware('access');
Route::get('api/recruitment/report', 'Recruitment\ReportController@getReport');
Route::get('/recruitment/report/export', 'Recruitment\ReportController@reportExport');
Route::get('/recruitment/rate', 'Recruitment\ReportController@rate')->middleware('access');
Route::get('api/recruitment/rate-by-level', 'Recruitment\ReportController@getRateByLevel');
Route::get('api/recruitment/rate-by-dept', 'Recruitment\ReportController@getRateByDepartment');
Route::get('/recruitment/rate/export', 'Recruitment\ReportController@rateExport');
Route::get('/recruitment/resource', 'Recruitment\ReportController@resource')->middleware('access');
Route::get('api/recruitment/resource-by-level', 'Recruitment\ReportController@getResourceByLevel');
Route::get('api/recruitment/resource-by-dept', 'Recruitment\ReportController@getResourceByDepartment');
Route::get('/recruitment/resource/export', 'Recruitment\ReportController@resourceExport');

Route::get('/recruitment/poh', 'Recruitment\PointOfHireController@index')->middleware('access');
Route::get('api/recruitment/poh', 'Recruitment\PointOfHireController@getPoH');
Route::post('api/recruitment/poh', 'Recruitment\PointOfHireController@store');
Route::post('api/recruitment/poh/update', 'Recruitment\PointOfHireController@update');
Route::post('api/recruitment/poh/delete', 'Recruitment\PointOfHireController@delete');

Route::get('/recruitment/lead-time', 'Recruitment\LeadTimeController@index')->middleware('access');
Route::post('/recruitment/lead-time', 'Recruitment\LeadTimeController@update');
Route::get('api/recruitment/lead-time', 'Recruitment\LeadTimeController@getLeadTime');

Route::get('/recruitment/menu', 'Recruitment\MenuController@index')->middleware('access');
Route::get('api/recruitment/menu', 'Recruitment\MenuController@getMenuParent');
Route::get('api/recruitment/menu/child', 'Recruitment\MenuController@getMenuChild');
Route::get('api/recruitment/menu/grand-child', 'Recruitment\MenuController@getMenuGrandChild');
Route::post('api/recruitment/menu', 'Recruitment\MenuController@store');
Route::post('api/recruitment/menu/update', 'Recruitment\MenuController@update');
Route::post('api/recruitment/menu/delete', 'Recruitment\MenuController@delete');

Route::get('/recruitment/access', 'Recruitment\AccessController@index')->middleware('access');
Route::get('api/recruitment/access', 'Recruitment\AccessController@getAccess');
Route::post('api/recruitment/access/update', 'Recruitment\AccessController@update');

Route::get('/recruitment/access-position', 'Recruitment\AccessPositionController@index')->middleware('access');
Route::get('api/recruitment/access-position', 'Recruitment\AccessPositionController@getAccessPosition');
Route::post('api/recruitment/access-position', 'Recruitment\AccessPositionController@store');
Route::post('api/recruitment/access-position/update', 'Recruitment\AccessPositionController@update');