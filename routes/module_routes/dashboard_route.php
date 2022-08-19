<?php
/**
 * Define the "web" routes for the application.
 * 
 * These routes all receive session state, CSRF protection, etc.
 *
 * DASHBOARD ROUTE
 */

/** Breadcumb */
Route::get('breadcum','HomeController@breadcum')->name('breadcum');

/** Module CRUD */ 
Route::get('/getAll/module','ModuleController@AllModule')->name('getAllModule');
Route::get('/get/moduleById/{id}','ModuleController@getModuleById')->name('getModule');
Route::post('/update/module','ModuleController@updateModule')->name('updateModuleById');
Route::post('/insert/insertModule','ModuleController@insertModule')->name('insertModule');
Route::post('/delete/moduleByid','ModuleController@deleteModule')->name('deleteModule');
Route::get('/get/moduleAccess', 'ModuleController@getModuleAccess');

// Admin Module
Route::post('/admin/module/{id}','ModuleAdminController@AdminByModule')->name('AdminByModule');
Route::get('/admin/module-detail/{id}','ModuleAdminController@edit')->name('edit');
Route::post('/admin/module','ModuleAdminController@create')->name('create');
Route::put('/admin/module','ModuleAdminController@update')->name('update');
Route::delete('/admin/module','ModuleAdminController@delete')->name('delete');

/**ROUTE VIEW */
Route::middleware(['access'])->group(function () {
    Route::get('/management/module','ModuleController@index')->name('Module'); // Module
    Route::view('management/menu', 'management/menu'); //Menu
    Route::get('management/user','Management\ManagementUserController@index')->name('allUser'); // User
    Route::get('management/departement','Management\ManagementDepartController@index')->name('Departement'); // Department
    Route::get('management/gradeGroup','Management\ManagementGradeGroupController@index')->name('GradeGroup'); // Grade Group
    Route::get('management/grade','Management\ManagementGradeController@index')->name('Grade'); // Grade
    Route::get('management/title','Management\ManagementTitleController@index')->name('Title'); //Tittle
    Route::get('management/type','Management\ManagementTypeController@index')->name('Type'); //Type
    Route::get('management/approval','Management\ManagementAprovalMatrixController@index')->name('approval'); //Approval Matrix
    Route::view('plugin', 'plugin/plugin'); // Plugin
});

/** Management Menu */ 
Route::get('/getAll/menu','Management\ManagementMenuController@getAllMenu')->name('DashboardGetAllMenu');
Route::post('/insert/Menu','Management\ManagementMenuController@insertMenu')->name('DashboardInsertMenu');
Route::get('/get/child/MenuById/{id}','Management\ManagementMenuController@getChildMenu')->name('DashboardChildMenu');
Route::get('/get/grandChild/MenuById/{id}','Management\ManagementMenuController@getGrandChildMenu')->name('DashboardGrandChildMenu');
Route::get('/get/detail/menu','Management\ManagementMenuController@getDetailMenuById')->name('DashboardGetDetailMenu');
Route::post('/delete/MenuByid','Management\ManagementMenuController@deleteMenu')->name('DashboardDeleteMenu');
Route::put('/update/data/menu','Management\ManagementMenuController@updateMenu')->name('DashboardUpdateDataMenu');

/** Management User */
Route::get('/getall/user','Management\ManagementUserController@getAllUser')->name('getAllUser');
Route::post('/delete/user','Management\ManagementUserController@deleteUser')->name('deleteUser');
Route::get('/getall/user/deleted','Management\ManagementUserController@getDeleteUser')->name('getAllUserDeleted');
Route::post('/restore/user','Management\ManagementUserController@restoreUser')->name('restoreUser');
Route::get('get/user/{id}','Management\ManagementUserController@getUserById')->name('getUser');
Route::post('/update/data/user','Management\ManagementUserController@updateUser')->name('updateDataUser');
Route::post('/insert/user','Management\ManagementUserController@insertUser')->name('insertUser');
Route::get('/get/option/user','Management\ManagementUserController@getAllOption')->name('getOptionUser');
Route::get('/get/access', 'Management\ManagementUserController@getUserAccess')->name('getUserAccess');
Route::post('refresh/password', 'Management\ManagementUserController@RefreshPassword')->name('RefreshPassword');
Route::post('/save/access', 'Management\ManagementUserController@saveUserAccess')->name('saveUserAccess');
Route::view('management/user-upload', 'management/userUpload'); // doesn't need middleware access
Route::post('management/user/uploadProses','Management\ManagementUserController@uploadUser')->name('upload');
Route::post('management/user/UploadSave','Management\ManagementUserController@UploadUserSave')->name('uploadSave');
Route::get('management/user/download','Management\ManagementUserController@downloadUser')->name('download');

/** Management Departement */ 
Route::get('/getAll/departement','Management\ManagementDepartController@AllDepartment')->name('getAllDepartement');
Route::get('/get/departementById/{id}','Management\ManagementDepartController@getDepartmentById')->name('getDepartment');
Route::put('/update/departement','Management\ManagementDepartController@updateDepartment')->name('updateDepartmentById');
Route::delete('/delete/departmentByid','Management\ManagementDepartController@deleteDepartment')->name('deleteDepartment');
Route::post('/insert/insertDepartment','Management\ManagementDepartController@insertDepartment')->name('insertDepartment');
Route::get('/get/accessPosition', 'Management\ManagementDepartController@getAccessPosition');
Route::post('/save/accessPosition', 'Management\ManagementDepartController@saveAccessPosition');

/** Management GradeGroup */ 
Route::get('/getAll/gradeGroup','Management\ManagementGradeGroupController@AllGradeGroup')->name('getAllGradeGroup');
Route::get('/get/gradeGroupById/{id}','Management\ManagementGradeGroupController@getGradeGroupById')->name('getGradeGroup');
Route::put('/update/gradeGroup','Management\ManagementGradeGroupController@updateGradeGroup')->name('updateGradeGroupById');
Route::delete('/delete/gradeGroupByid','Management\ManagementGradeGroupController@deleteGradeGroup')->name('deleteGradeGroup');
Route::post('/insert/insertGradeGroup','Management\ManagementGradeGroupController@insertGradeGroup')->name('insertGradeGroup');

/** Management Grade */
Route::get('/getAll/grade','Management\ManagementGradeController@AllGrade')->name('getAllGrade');
Route::get('/get/gradeById/{id}','Management\ManagementGradeController@getGradeById')->name('getGrade');
Route::put('/update/grade','Management\ManagementGradeController@updateGrade')->name('updateGradeById');
Route::delete('/delete/gradeByid','Management\ManagementGradeController@deleteGrade')->name('deleteGrade');
Route::post('/insert/insertGrade','Management\ManagementGradeController@insertGrade')->name('insertGrade');

/** Management Title */ 
Route::get('/getAll/title','Management\ManagementTitleController@AllTitle')->name('getAllTitle');
Route::get('/get/titleById/{id}','Management\ManagementTitleController@getTitleById')->name('getTitle');
Route::put('/update/title','Management\ManagementTitleController@updateTitle')->name('updateTitleById');
Route::delete('/delete/titleByid','Management\ManagementTitleController@deleteTitle')->name('deleteTitle');
Route::post('/insert/insertTitle','Management\ManagementTitleController@insertTitle')->name('insertTitle');

/** Management Type */ 
Route::get('/getAll/type','Management\ManagementTypeController@AllType')->name('getAllType');
Route::get('/get/typeById/{id}','Management\ManagementTypeController@getTypeById')->name('getType');
Route::put('/update/type','Management\ManagementTypeController@updateType')->name('updateTypeById');
Route::delete('/delete/typeByid','Management\ManagementTypeController@deleteType')->name('deleteType');
Route::post('/insert/insertType','Management\ManagementTypeController@insertType')->name('insertType');

/** Management Aproval Metrix */ 
Route::get('/getAll/approval','Management\ManagementAprovalMatrixController@AllApproval')->name('getAllApproval');
Route::get('/get/approvalById/{id}','Management\ManagementAprovalMatrixController@getApprovalById')->name('getApproval');
Route::put('/update/approval','Management\ManagementAprovalMatrixController@updateApproval')->name('updateApprovalById');
Route::delete('/delete/ApprovalByid','Management\ManagementAprovalMatrixController@deleteApproval')->name('deleteApproval');
Route::post('/insert/insertApproval','Management\ManagementAprovalMatrixController@insertApproval')->name('insertApproval');

/** Plugin Year */ 
Route::get('/getall/plugin/year','Plugin\PluginYearController@getAllPluginYear')->name('getPluginYear');
Route::get('/getall/plugin/year/active','Plugin\PluginYearController@getAllPluginYearActive')->name('getPluginYear');
Route::get('/get/plugin/yearById/{id}','Plugin\PluginYearController@getPluginYearId')->name('getPluginYearById');
Route::put('/update/plugin/yearById','Plugin\PluginYearController@updatePluginYearId')->name('updatePluginYearById');
Route::post('/insert/plugin/year','Plugin\PluginYearController@insertPluginYear')->name('insertPluginYear');
Route::delete('/delete/plugin/yearByid','Plugin\PluginYearController@deletePluginYear')->name('deletePluginYear');

/** Plugin Month */
Route::get('/getall/plugin/month','Plugin\PluginMonthController@getAllPluginMonth')->name('getPluginMonth');
Route::get('/get/plugin/monthById/{id}','Plugin\PluginMonthController@getPluginMonthId')->name('getPluginMonthById');
Route::put('/update/plugin/MonthById','Plugin\PluginMonthController@updatePluginMonthId')->name('updatePluginMonthById');
Route::post('/insert/plugin/Month','Plugin\PluginMonthController@insertPluginMonth')->name('insertPluginMonth');
Route::delete('/delete/plugin/MonthByid','Plugin\PluginMonthController@deletePluginMonth')->name('deletePluginMonth');

/** Plugin Periode */
Route::get('/getall/plugin/period','Plugin\PluginPeriodController@getAllPluginPeriod')->name('getPluginPeriod');
Route::get('/getall/plugin/period/active','Plugin\PluginPeriodController@getAllPluginPeriodActive')->name('getAllPluginPeriodActive');
Route::get('/get/plugin/periodById/{id}','Plugin\PluginPeriodController@getPluginPeriodId')->name('getPluginPeriodById');
Route::put('/update/plugin/PeriodById','Plugin\PluginPeriodController@updatePluginPeriodId')->name('updatePluginPeriodById');
Route::post('/insert/plugin/Period','Plugin\PluginPeriodController@insertPluginPeriod')->name('insertPluginPeriod');
Route::delete('/delete/plugin/PeriodByid','Plugin\PluginPeriodController@deletePluginPeriod')->name('deletePluginPeriod');

/** Plugin Version */
Route::get('/getall/plugin/version','Plugin\PluginVersionController@getAllPluginVersion')->name('getPluginVersion');
Route::get('/get/plugin/versionById/{id}','Plugin\PluginVersionController@getPluginVersionId')->name('getPluginVersionById');
Route::put('/update/plugin/VersionById','Plugin\PluginVersionController@updatePluginVersionId')->name('updatePluginVersionById');
Route::post('/insert/plugin/Version','Plugin\PluginVersionController@insertPluginVersion')->name('insertPlugin');
Route::delete('/delete/plugin/VersionByid','Plugin\PluginVersionController@deletePluginVersion')->name('deletePluginVersion');

/** Plugin SystemSetting */
Route::get('/getall/system/setting','Plugin\PluginSettingSystemController@getAllSystemSetting')->name('getSystemSetting');
Route::get('/get/plugin/systemSettingById/{id}','Plugin\PluginSettingSystemController@getPluginSystemSettingId')->name('getSystemSettingById');
Route::put('/update/plugin/systemSettingById','Plugin\PluginSettingSystemController@updatePluginSystemSettingId')->name('updateSystemSettingById');
Route::post('/insert/plugin/systemSetting','Plugin\PluginSettingSystemController@insertPluginSystemSetting')->name('insertSystemSetting');
Route::delete('/delete/plugin/systemSettingById','Plugin\PluginSettingSystemController@deletePluginSystemSetting')->name('deleteSystemSetting');

/** Management  Age Category */
Route::resource('management/age', 'AgeController');