<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('ValidateToken')->get('getall/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'Api\ApiLoginController@login');

Route::group(['middleware' => ['JwtVerify']], function () {
    Route::get('getall/user', 'Management\ManagementUserController@getAllUser')->name('getAllUser');
    Route::get('user/{id}', 'Management\ManagementUserController@getUserById');
    Route::get('getall/departement', 'Management\ManagementDepartController@AllDepartment')->name('getAllDepartement');
    Route::get('access/regven', 'RegisterVendor\AccessController@index');
    Route::get('access-position/regven', 'RegisterVendor\AccessPositionController@index');
    Route::get('test', 'Api\ApiLoginController@test');

    /** GetAdminModuel */
    Route::post('admin/module', function (Request $request) {
        return \Response::success(["result"=>\Helper::instance()->checkNIKByAPI($request)]);
    });

    /** API TICKETING */
    Route::get('ticket/ticketType', 'Ticketing\TypeTicketingController@index');
    Route::post('ticket/request-po', 'Ticketing\RequestTicketingController@store');
    Route::get('ticket/status/proceed', 'Ticketing\StatusController@TicketingDataById');
    Route::get('ticket/status/unproceed', 'Ticketing\StatusController@TicketingDataByIdUnproceed');
    Route::post('ticket/detail', 'Ticketing\StatusController@DetailTicketing');
    Route::get('ticket/all/proceed', 'Ticketing\StatusController@TicketingAllData');
    Route::get('ticket/all/unproceed', 'Ticketing\StatusController@TicketingAllDataUnproceed');
    Route::put('ticket/status/update','Ticketing\StatusController@Update');

});
