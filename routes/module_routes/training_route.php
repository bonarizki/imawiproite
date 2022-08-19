<?php 
/**
 * Define the "web" routes for the application.
 * 
 * These routes all receive session state, CSRF protection, etc.
 *
 * TRAINING ROUTE
 */

 /** Breadcumb */
Route::get('breadcumTraining','HomeController@breadcumTraining')->name('breadcumTraining');

/**ROUTE VIEW */
Route::middleware(['access'])->group(function () {
    Route::view('training','training/dashboard'); // Dashboard
    Route::view('training/menu','training/menu'); // Training Menu
    Route::view('training/access','training/access'); // Training Access
    Route::view('training/access-position','training/accessPosition'); // Training Access Position
    Route::view('training/vendor','training/vendor'); // Training Master Vendor
    Route::view('training/category','training/category'); // Training Master Category
    Route::view('training/method','training/method'); // Training Master Method
    Route::view('training/request','training/request'); // Training Request
    Route::view('training/status','training/status'); // Training Status
    Route::view('training/approval','training/approval'); // Training Approval
    Route::view('training/mytraining','training/mytraining'); // My Training
    Route::view('training/report/topic','training/report/ReportTopic'); //Training Report Topic
    Route::view('training/report/participant','training/report/ReportParticipant'); //Training Report Participant
    Route::view('training/report/mandays','training/report/ReportMandays'); //Training Report Mandays
    Route::view('training/report/expense','training/report/ReportExpense'); //Training Report Expense
    Route::view('training/report/expense-level','training/report/ReportExpenseLevel'); //Training Report Expense Level
    Route::view('training/report/feedback','training/report/ReportFeedback'); //Training Report Feedback
    
});

/** Training Dashboard */
Route::get('training/data-dashboard/{id}','Training\DashboardController@getAllData')->name('dataDashboard');

/** Training Participant Not Yet Give Feedback */
Route::get('training/participant-need-feedback/{id}','Training\DashboardController@feedbackParticipantNull')->name('participant-feedback-null');

/** Training Participant Give Feedback */
Route::get('training/participant-feedback/{id}','Training\DashboardController@feedbackParticipan')->name('participant-feedback');

/** Remind Feedback */
Route::post('training/remind/feedback','Training\DashboardController@remindParticipant')->name('remind-partipants');

/** Management Menu */
Route::get('training/all/menu','Training\MenuController@getAllMenu')->name('TrainingGetMenu');
Route::get('training/all/menuChild/{id}','Training\MenuController@getChildMenu')->name('TrainingGetMenuChild');
Route::get('training/all/menuGrandChild/{id}','Training\MenuController@getGrandChildMenu')->name('TrainingGetMenuGrandChild');
Route::post('training/insert/menu','Training\MenuController@store')->name('TrainingInsertMenu');
Route::get('training/detail/menu','Training\MenuController@show')->name('TrainingGetDetailMenu');
Route::put('training/update/menu','Training\MenuController@update')->name('TrainingUpdateMenu');
Route::delete('training/delete/menu','Training\MenuController@destroy')->name('TrainingTrainingeleteMenu');

/** Training Master Access */
Route::get('training/all/access/user','Training\AccessController@getAllAcces')->name('TrainingGetAccess');
Route::get('training/detail/access/{id}','Training\AccessController@show')->name('TrainingGetDetailAccess');
Route::get('training/menu/access','Training\AccessController@getMenu')->name('TrainingGetAllMenu');
Route::put('training/access/update','Training\AccessController@update')->name('TrainingAccessUpdate');

/** Training Master Access Position */
Route::get('training/all/access-position/data','Training\AccessPositionController@show')->name('TrainingAccess-position-show');
Route::get('training/all/access-position/{id}','Training\AccessPositionController@detail')->name('TrainingAccess-position-detail');
Route::put('training/all/access-position','Training\AccessPositionController@update')->name('TrainingAccess-position-update');

/** Training Master Vendor */
Route::get('training/all/vendor/data','Training\VendorController@show')->name('vendor-show');
Route::get('training/all/vendor/{id}','Training\VendorController@detail')->name('vendor-detail');
Route::post('training/all/vendor-update','Training\VendorController@update')->name('vendor-update');
Route::post('training/all/vendor','Training\VendorController@create')->name('vendor-create');
Route::delete('training/all/vendor','Training\VendorController@destroy')->name('vendor-destroy');
Route::get('training/all/vendor/data/by-type','Training\VendorController@vendorByType')->name('vendor-type');
Route::post('training/all/vendor-upload','Training\VendorController@upload')->name('vendor-upload');
Route::get('training/all/vendor-download','Training\VendorController@download')->name('vendor-download');
Route::get('training/download-vendor/{id}','Training\VendorController@downloadById')->name('vendor-pdf');

/** Training Master Category */
Route::get('training/all/category/data','Training\CategoryController@show')->name('category-show');
Route::get('training/all/category/{id}','Training\CategoryController@detail')->name('category-detail');
Route::patch('training/all/category','Training\CategoryController@update')->name('category-update');
Route::post('training/all/category','Training\CategoryController@create')->name('category-create');
Route::delete('training/all/category','Training\CategoryController@destroy')->name('category-destroy');

/** Training Master Method */
Route::get('training/all/method/data','Training\TrainingMethodController@show')->name('method-show');
Route::get('training/all/method/{id}','Training\TrainingMethodController@detail')->name('method-detail');
Route::patch('training/all/method','Training\TrainingMethodController@update')->name('method-update');
Route::post('training/all/method','Training\TrainingMethodController@create')->name('method-create');
Route::delete('training/all/method','Training\TrainingMethodController@destroy')->name('method-destroy');

/** Training Request */
Route::get('training/get-participant','Training\TrainingRequestController@getParticipant')->name('training-request-participant'); // by department
Route::get('training/get-participant-all','Training\TrainingRequestController@getParticipantAll')->name('training-request-participant-all'); // all user
Route::post('training/request','Training\TrainingRequestController@create')->name('training-request-create');
Route::patch('training/request','Training\TrainingRequestController@update')->name('training-request-udpate');

/** Training Status */
Route::delete('training/status','Training\TrainingStatusController@CancelTraining')->name('CancelTraining');
Route::get('training/all/{period_id}','Training\TrainingStatusController@TrainingAll')->name('TrainingAll');

/** Training status proceed */
Route::get('training/status/data','Training\TrainingStatusController@TrainingAllData')->name('TrainingAllData');
Route::get('training/status/data/ById','Training\TrainingStatusController@TrainingDataById')->name('TrainingDataById');
Route::get('training/status/data-id','Training\TrainingStatusController@DetailTraining')->name('DetailTraining');

/** Training status unproceed */
Route::get('training/status/data/uproceed','Training\TrainingStatusController@TrainingAllDataUnproceed')->name('TrainingAllDataUnproceed');
Route::get('training/status/data/ById/unproceed','Training\TrainingStatusController@TrainingDataByIdUnproceed')->name('TrainingDataByIdUnproceed');

/** Training Approval */
Route::get('training/approval/data','Training\TrainingApprovalController@getDataApproval')->name('getDataApproval');
Route::post('training/approval/data','Training\TrainingApprovalController@approveTraining')->name('approveTraining');
Route::post('training/approval/data/reject','Training\TrainingApprovalController@rejectTraining')->name('rejectTraining');

/** My Training */
Route::get('training/mytraining/data','Training\MyTrainingController@myTraining')->name('myTraining');
Route::post('training/mytraining/feedback','Training\MyTrainingController@insFeedbackTraining')->name('feedback-training');

/** Training Report */
Route::get('training/report/request/{id}','Training\TrainingReportController@downloadRequest')->name('download-request-id');

// by topic
Route::post('training/report/topic/view','Training\TrainingReportController@ViewReportTopic')->name('view-report-topic');
Route::get('training/report/topic/download','Training\TrainingReportController@DownloadReportTopic')->name('download-report-topic');

// by participant
Route::post('training/report/participant/view','Training\TrainingReportController@ViewReportParticipant')->name('view-report-participant');
Route::get('training/report/participant/download','Training\TrainingReportController@DownloadReportParticipant')->name('download-report-participant');

// by mandays
Route::post('training/report/mandays/view','Training\TrainingReportController@ViewReportMandays')->name('view-report-mandays');
Route::get('training/report/mandays/download','Training\TrainingReportController@DownloadReportMandays')->name('download-report-mandays');

// by expense
Route::post('training/report/expense/view','Training\TrainingReportController@ViewReportExpense')->name('view-report-expense');
Route::get('training/report/expense/download','Training\TrainingReportController@DownloadReportExpense')->name('download-report-expense');

// by expense level
Route::post('training/report/expense-level/view','Training\TrainingReportController@ViewReportExpenseLevel')->name('view-report-expense-level');
Route::get('training/report/expense-level/download','Training\TrainingReportController@DownloadReportExpenseLevel')->name('download-report-expense-level');

// by feedback
Route::post('training/report/feedback/view','Training\TrainingReportController@ViewReportFeedback')->name('view-report-feedback');
Route::get('training/report/feedback/download','Training\TrainingReportController@DownloadReportFeedback')->name('download-report-feedback');

/** Training Participant */
Route::get('training/participant/{id}','Training\MyTrainingController@getDetailParticipant')->name('detail-participant');

/** Training Upload Participant */
Route::post('training/upload-participant/validate','Training\TrainingRequestController@validateParticipantTraining');







