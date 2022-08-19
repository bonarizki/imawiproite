<?php

/**
 * Define the "web" routes for the application.
 * 
 * These routes all receive session state, CSRF protection, etc.
 *
 * KOPERASI ROUTE
 */

/**ROUTE VIEW */
Route::middleware(['access'])->group(function () {
    Route::get('koperasi', 'Koperasi\DashboardController@index'); // Dashboard
    Route::view('koperasi/menu','koperasi/menu'); // Koperasi Menu
    Route::view('koperasi/access','koperasi/access'); // Koperasi Access
    Route::view('koperasi/access-position','koperasi/accessPosition'); // Koperasi Access Position
    Route::view('koperasi/order-limit','koperasi/orderLimit'); // Koperasi order Limit
    Route::get('koperasi/banner-setting','Koperasi\BannerController@index'); // Koperasi banner setting
    Route::get('koperasi/product','Koperasi\ProductController@index'); // Koperasi Product
    Route::get('koperasi/order','Koperasi\OrderController@index'); // Koperasi Product
    Route::get('koperasi/history','Koperasi\HistoryController@index'); // Koperasi History
    Route::get('koperasi/member','Koperasi\MemberController@index'); // Koperasi Member
    Route::get('koperasi/product-setting','Koperasi\ProductSettingController@index'); // Koperasi Product Setting
});

 /** Breadcumb */
 Route::get('breadcumKoperasi','HomeController@breadcumKoperasi')->name('breadcumKoperasi');

/** Koperasi Management Menu */
Route::get('koperasi/all/menu','Koperasi\MenuController@getAllMenu')->name('KoperasiGetMenu');
Route::get('koperasi/all/menuChild/{id}','Koperasi\MenuController@getChildMenu')->name('KoperasiGetMenuChild');
Route::get('koperasi/all/menuGrandChild/{id}','Koperasi\MenuController@getGrandChildMenu')->name('KoperasiGetMenuGrandChild');
Route::post('koperasi/insert/menu','Koperasi\MenuController@store')->name('KoperasiInsertMenu');
Route::get('koperasi/detail/menu','Koperasi\MenuController@show')->name('KoperasiGetDetailMenu');
Route::put('koperasi/update/menu','Koperasi\MenuController@update')->name('KoperasiUpdateMenu');
Route::delete('koperasi/delete/menu','Koperasi\MenuController@destroy')->name('KoperasiDeleteMenu');

/** Koperasi Management Access */
Route::get('koperasi/all/access/user','Koperasi\AccessController@getAllAcces')->name('KoperasiGetAccess');
Route::get('koperasi/detail/access/{id}','Koperasi\AccessController@show')->name('KoperasiGetDetailAccess');
Route::get('koperasi/menu/access','Koperasi\AccessController@getMenu')->name('KoperasiGetAllMenu');
Route::put('koperasi/access/update','Koperasi\AccessController@update')->name('KoperasiAccessUpdate');

/** Koperasi Master Access Position */
Route::get('koperasi/all/access-position/data','Koperasi\AccessPositionController@show')->name('KoperasiAccess-position-show');
Route::get('koperasi/all/access-position/{id}','Koperasi\AccessPositionController@detail')->name('KoperasiAccess-position-detail');
Route::put('koperasi/all/access-position','Koperasi\AccessPositionController@update')->name('KoperasiAccess-position-update');

/** Koperasi Cart and Product */
Route::get('koperasi/product/cart' , 'Koperasi\ProductController@CountCart')->name('countCart');
Route::get('koperasi/product/cart/detail' , 'Koperasi\ProductController@detailCart')->name('detailCart');
Route::resource('koperasi/product', 'Koperasi\ProductController')->except(['index']); // di except karena index suda di pake di atas
// Route::get('koperasi/product/{id}','Koperasi\ProductController@edit')->name('ProductEdit');
// Route::post('koperasi/product/','Koperasi\ProductController@')->name('ProductEdit');

/** Koperasi Order Limit */
Route::get('koperasi/category', 'Koperasi\OrderLimitController@getCategory');
Route::resource('koperasi/order-limit/data', 'Koperasi\OrderLimitController');

/** Koperasi Order Process */
Route::patch('koperasi/order/reverse', 'Koperasi\OrderController@reverse');
Route::patch('koperasi/order/update', 'Koperasi\OrderController@UpdateOrder'); // mengupdate jumlah qty order by admin
Route::resource('koperasi/order', 'Koperasi\OrderController');

/** Koperasi Download */
Route::get('koperasi/download/history-order/{id}','Koperasi\DownloadController@downloadHistory');
Route::post('koperasi/download/report','Koperasi\DownloadController@downloadOrder');

/** Koperasi Member */
Route::post('koperasi/member-upload','Koperasi\MemberController@upload')->name('upload-member');
Route::resource('koperasi/member','Koperasi\MemberController');

/** Koperasi Product Setting */
Route::resource('koperasi/product-setting', 'Koperasi\ProductSettingController');

/** Koperasi Banner Setting */
Route::post('koperasi/banner-setting/update', 'Koperasi\BannerController@update');
Route::resource('koperasi/banner-setting', 'Koperasi\BannerController');

/** Koperasi Data Dashboard */
Route::post('koperasi/data-dashboard','Koperasi\DashboardController@data');
