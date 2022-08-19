<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'LoginController@showLogin')->name('showLogin');
Route::post('/login', 'LoginController@postLogin');
Route::get('/logout','LoginController@logout')->name('logout');

Route::get('/forgot/password', 'ChangePasswordController@showForm')->name('show_form');
Route::post('/forgot/password/', 'ChangePasswordController@getEmail')->name('email');
Route::post('/reset/password','ChangePasswordController@changePassword')->name('reset');
Route::get('/new/password', 'ChangePasswordController@newPassword')->name('new_password');
Route::get('/ChangeDefault/Password/{mail}', 'ChangePasswordController@ChangeDefaultPassword')->name('ChangeDefaultPassword');
Route::post('/resetDefault/password','ChangePasswordController@resetDefaultPassword')->name('reset');

Route::get('/locked', 'LoginController@locked')->name('login.locked');
Route::post('login/locked', 'LoginController@unlock')->name('login.unlock');

Route::get('refreshcaptcha', 'ChaptchaController@refreshCaptcha')->name('refreshcaptcha');

Route::group(['middleware' => 'auth:user'], function(){

    // Auth::routes();
    Route::get('/home', 'HomeController@index')->name('home');

    // AUTH MAIL
    Route::post('resignation/send-mail/resign','Resignation\ResignController@sendMailResign')->name('ResignMail');

    Route::post('recruitment/send-mail', 'Recruitment\RecruitController@sendMail');

    // Profile
    Route::view('profile','profile');
    Route::get('profile/{nik}','ProfileControlller@getDataProfile')->name('profile');
    Route::put('profile','ProfileControlller@updateProfile')->name('updateProfile');
    Route::put('profile/password','ProfileControlller@updatePassword')->name('updatePassword');
    
});
