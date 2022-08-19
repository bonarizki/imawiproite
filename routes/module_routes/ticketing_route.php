<?php

/**
 * Define the "web" routes for the application.
 * 
 * These routes all receive session state, CSRF protection, etc.
 *
 * TICKETING ROUTE
 */

/**ROUTE VIEW */
Route::middleware(['access'])->group(function () {
    Route::view('ticketing', 'ticketing/dashboard'); // Dashboard
    Route::view('ticketing/menu', 'ticketing/menu'); // Menu
    Route::view('ticketing/access', 'ticketing/access'); // Access
    Route::view('ticketing/access-position', 'ticketing/accessPosition'); // Access Position
    Route::view('ticketing/priority', 'ticketing/priority'); // Ticketing Priority
    Route::view('ticketing/type', 'ticketing/type'); // Ticketing Type
    Route::view('ticketing/approval/type', 'ticketing/approval-type'); // Ticketing Type Approval
    Route::view('ticketing/request', 'ticketing/request-form'); // Ticketing Request
    Route::view('ticketing/status', 'ticketing/status'); // Ticketing Request
    Route::view('ticketing/approval', 'ticketing/approval'); // Ticketing approval
    Route::view('ticketing/system/applications/view', 'ticketing/systemApplications'); // Ticketing managemen system applications
    Route::view('ticketing/report-view', 'ticketing/report');
});

/** Breadcumb */
Route::get('breadcumTicketing', 'HomeController@breadcumTicketing')->name('breadcumTicketing');


/** Ticketing Management Menu */
Route::get('ticketing/all/menu', 'Ticketing\MenuController@getAllMenu')->name('TicketingGetMenu');
Route::get('ticketing/all/menuChild/{id}', 'Ticketing\MenuController@getChildMenu')->name('TicketingGetMenuChild');
Route::get('ticketing/all/menuGrandChild/{id}', 'Ticketing\MenuController@getGrandChildMenu')->name('TicketingGetMenuGrandChild');
Route::post('ticketing/insert/menu', 'Ticketing\MenuController@store')->name('TicketingInsertMenu');
Route::get('ticketing/detail/menu', 'Ticketing\MenuController@show')->name('TicketingGetDetailMenu');
Route::put('ticketing/update/menu', 'Ticketing\MenuController@update')->name('TicketingUpdateMenu');
Route::delete('ticketing/delete/menu', 'Ticketing\MenuController@destroy')->name('TicketingDeleteMenu');

/** Ticketing Management Access */
Route::get('ticketing/all/access/user', 'Ticketing\AccessController@getAllAcces')->name('TicketingGetAccess');
Route::get('ticketing/detail/access/{id}', 'Ticketing\AccessController@show')->name('TicketingGetDetailAccess');
Route::get('ticketing/menu/access', 'Ticketing\AccessController@getMenu')->name('TicketingGetAllMenu');
Route::put('ticketing/access/update', 'Ticketing\AccessController@update')->name('TicketingAccessUpdate');

/** Ticketing Master Access Position */
Route::get('ticketing/all/access-position/data', 'Ticketing\AccessPositionController@show')->name('TicketingAccess-position-show');
Route::get('ticketing/all/access-position/{id}', 'Ticketing\AccessPositionController@detail')->name('TicketingAccess-position-detail');
Route::put('ticketing/all/access-position', 'Ticketing\AccessPositionController@update')->name('TicketingAccess-position-update');

/** Ticketing Master Priority */
Route::resource('ticketing/all/priority', 'Ticketing\PriorityController');

/** Ticketing Master Type */
Route::resource('ticketing/all/type', 'Ticketing\TypeTicketingController');

/** Ticketing Master Approval Type */
Route::resource('ticketing/all/approval/type', 'Ticketing\ApprovalTypeController');

Route::resource('ticketing/request/resource', 'Ticketing\RequestTicketingController');

/** Ticketing Status */
Route::delete('ticketing/status', 'Ticketing\StatusController@CancelTicketing')->name('CancelTicketing');
// Route::get('ticketing/all/{period_id}', 'Ticketing\StatusController@TicketingAll')->name('TicketingAll');

/** Ticketing status proceed */
Route::get('ticketing/status/data', 'Ticketing\StatusController@TicketingAllData')->name('TicketingAllData');
Route::get('ticketing/status/data/ById', 'Ticketing\StatusController@TicketingDataById')->name('TicketingDataById');
Route::get('ticketing/status/data-id', 'Ticketing\StatusController@DetailTicketing')->name('DetailTicketing');

/** Ticketing status unproceed */
Route::get('ticketing/status/data/uproceed', 'Ticketing\StatusController@TicketingAllDataUnproceed')->name('TicketingAllDataUnproceed');
Route::get('ticketing/status/data/ById/unproceed', 'Ticketing\StatusController@TicketingDataByIdUnproceed')->name('TicketingDataByIdUnproceed');
Route::get('ticketing/status/data/detail-po/{id}', 'Ticketing\StatusController@DetailPOById')->name('DetailPOById');

/** Ticket Update Status */
Route::patch('ticketing/status/data', 'Ticketing\StatusController@update')->name('TicketingUpdate');

/** Ticketing Approval */
Route::get('ticketing/approval/data', 'Ticketing\ApproveController@index')->name('ApprovalData');
Route::patch('ticketing/approval/data', 'Ticketing\ApproveController@update')->name('UpdateTicketingPO');
Route::get('ticketing/approval/update-accept','Ticketing\ApproveController@updateAccept');


/**Ticketing Report */
Route::get('ticketing/download','Ticketing\DownloadController@download');
Route::get('ticketing/downloadByIdPDF/{id}','Ticketing\DownloadController@downloadByIdPDF');
Route::get('ticketing/downloadByIdRequestAccessUser/{id}','Ticketing\DownloadController@downloadRequestAccessUser');
Route::get('ticketing/downloadByIdRequestCRA/{id}','Ticketing\DownloadController@downloadRequestCRA');

/**Ticketing Dashboard */
Route::get('ticketing/dashboard/data', 'Ticketing\DashboardController@getData');
Route::get('ticketing/dashboard/data/table', 'Ticketing\DashboardController@getTable');
Route::get('ticketing/dashboard/data/chart', 'Ticketing\DashboardController@getChart');

/**Ticketing Upload File Status */
Route::post('ticketing/status/uploadFile','Ticketing\UploadFileController@upload');

/** Ticketing Management Product Category IT PO */
Route::resource('ticketing/product/category', 'Ticketing\ProductCategoryController');

/** Ticketing Management Product Sub Category IT PO */
Route::resource('ticketing/product/category-sub', 'Ticketing\ProductSubCategoryController');

/** Ticketing Management System Applications */
Route::resource('ticketing/system/applications', 'Ticketing\SystemApplicationsController');
Route::get('ticketing/system/applications-pic/{name}', 'Ticketing\SystemApplicationsController@getPIC');

/**Ticketing Report */
Route::get('ticketing/report', 'Ticketing\TicketingReportController@getData');
Route::get('ticketing/report-download', 'Ticketing\TicketingReportController@download');