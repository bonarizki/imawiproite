<?php

/**
 * Define the "web" routes for the application.
 * 
 * These routes all receive session state, CSRF protection, etc.
 *
 * SALES AWARDS ROUTE
 */

/**ROUTE VIEW */
Route::middleware(['access'])->group(function () {
    Route::view('awards','awards.dashboard');
    Route::view('awards/menu', 'awards/menu'); // Awards Menu
    Route::view('awards/access', 'awards/access'); //Awards Access
    Route::view('awards/approval-management', 'awards.managementApproval'); //Awards Approval
    Route::view('awards/question', 'awards.managementQuestion'); //Awards Question
    Route::view('awards/status', 'awards.StatusAwards'); //Awards Status
    Route::view('awards/approval', 'awards.ApprovalAwards'); //Awards Approval
});

/** Breadcumb */
Route::get('breadcumAwards','HomeController@breadcumAwards')->name('breadcumKoperasi');

/** Awards Master Menu */
Route::get('sales-awards/all/menu','Awards\MenuController@getAllMenu')->name('AwardsGetMenu');
Route::get('sales-awards/all/menuChild/{id}','Awards\MenuController@getChildMenu')->name('AwardsGetMenuChild');
Route::get('sales-awards/all/menuGrandChild/{id}','Awards\MenuController@getGrandChildMenu')->name('AwardsGetMenuGrandChild');
Route::post('sales-awards/insert/menu','Awards\MenuController@store')->name('AwardsInsertMenu');
Route::get('sales-awards/detail/menu','Awards\MenuController@show')->name('AwardsGetDetailMenu');
Route::put('sales-awards/update/menu','Awards\MenuController@update')->name('AwardsUpdateMenu');
Route::delete('sales-awards/delete/menu','Awards\MenuController@destroy')->name('AwardsDeleteMenu');

/** Awards Master Access */
Route::get('sales-awards/all/access/user','Awards\AccessController@getAllAcces')->name('AwardsGetAccess');
Route::get('sales-awards/detail/access/{id}','Awards\AccessController@show')->name('AwardsGetDetailAccess');
Route::get('sales-awards/menu/access','Awards\AccessController@getMenu')->name('AwardsGetAllMenu');
Route::put('sales-awards/access/update','Awards\AccessController@update')->name('AwardsAccessUpdate');

/**Award Management Approval */
Route::resource('sales-awards/approval-sales-awards', 'Awards\ManagementApprovalAwards');

/**Award Management Question */
Route::resource('sales-awards/question', 'Awards\ManagementQuestionController');

/**Award Status */
Route::resource('sales-awards/status', 'Awards\StatusAwardsController');

/**Award Approval */
Route::resource('sales-awards/approval', 'Awards\ApprovalController');


