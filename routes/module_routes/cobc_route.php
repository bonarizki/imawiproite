<?php
/**
 * Define the "web" routes for the application.
 * 
 * These routes all receive session state, CSRF protection, etc.
 *
 * COBC ROUTE
 */

Route::get('/cobc', 'COBC\DashboardController@index')->middleware('access');
Route::get('api/cobc/my-score', 'COBC\DashboardController@myScore');
Route::get('api/cobc/chart1', 'COBC\DashboardController@employeeParticipation');
Route::get('api/cobc/chart2', 'COBC\DashboardController@passingRate');
Route::get('api/cobc/chart3', 'COBC\DashboardController@topScore');

Route::get('/cobc/report', 'COBC\ReportController@index')->middleware('access');
Route::get('/cobc/report/export', 'COBC\ReportController@reportExport');
Route::get('api/cobc/report', 'COBC\ReportController@getReport');
Route::get('api/cobc/report/detail', 'COBC\ReportController@getReportDetail');

Route::get('/cobc/question', 'COBC\QuestionController@index')->middleware('access');
Route::get('api/cobc/question', 'COBC\QuestionController@getQuestion');
Route::post('api/cobc/question', 'COBC\QuestionController@store');
Route::post('api/cobc/question/update', 'COBC\QuestionController@update');
Route::post('api/cobc/question/delete', 'COBC\QuestionController@delete');
Route::get('api/cobc/question/get-question', 'COBC\QuestionController@getQuestionById');

Route::get('/cobc/menu', 'COBC\MenuController@index')->middleware('access');
Route::get('api/cobc/menu', 'COBC\MenuController@getMenuParent');
Route::get('api/cobc/menu/child', 'COBC\MenuController@getMenuChild');
Route::get('api/cobc/menu/grand-child', 'COBC\MenuController@getMenuGrandChild');
Route::post('api/cobc/menu', 'COBC\MenuController@store');
Route::post('api/cobc/menu/update', 'COBC\MenuController@update');
Route::post('api/cobc/menu/delete', 'COBC\MenuController@delete');

Route::get('/cobc/access', 'COBC\AccessController@index')->middleware('access');
Route::get('api/cobc/access', 'COBC\AccessController@getAccess');
Route::post('api/cobc/access/update', 'COBC\AccessController@update');

Route::get('/cobc/access-position', 'COBC\AccessPositionController@index')->middleware('access');
Route::get('api/cobc/access-position', 'COBC\AccessPositionController@getAccessPosition');
Route::post('api/cobc/access-position', 'COBC\AccessPositionController@store');
Route::post('api/cobc/access-position/update', 'COBC\AccessPositionController@update');

Route::get('/cobc/period', 'COBC\PeriodController@index')->middleware('access');
Route::get('api/cobc/period', 'COBC\PeriodController@getPeriod');
Route::post('api/cobc/period/update', 'COBC\PeriodController@update');

Route::get('/cobc/quiz', 'COBC\QuizController@index');
Route::get('api/cobc/generate', 'COBC\QuizController@generateQuestion');
Route::post('api/cobc/save', 'COBC\QuizController@saveQuiz');
Route::get('api/cobc/submit', 'COBC\QuizController@submitQuiz');