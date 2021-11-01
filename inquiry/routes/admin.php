<?php


Auth::routes();

Route::get('/', 'HomeController@index')->name('dashboard');
Route::get('/home', 'HomeController@index')->name('dashboard');
Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('about', 'HomeController@index');

Route::resource('roles', 'RoleController');

Route::resource('modules', 'ModuleController');

Route::get('/module/step1/{id?}', 'ModuleController@getStep1')->name('modules.create');
Route::get('/module/step2/{tablename?}', 'ModuleController@getStep2')->name('modules.create');
Route::get('/getJoinFields/{tablename?}', 'ModuleController@getJoinFields');
Route::get('/module/step3/{tablename?}', 'ModuleController@getStep3')->name('modules.create');

Route::post('/step1', 'ModuleController@postStep1');
Route::post('/step2', 'ModuleController@postStep2');
Route::post('/step3', 'ModuleController@postStep3');


Route::resource('users', 'UserController');

Route::resource('permissions', 'PermissionController');

//Route::resource('profile', 'UserController');

Route::get('user/profile', 'UserController@profile')->name('users.profile');
Route::get('profiles', 'UserController@profile')->name('profiles');
//Route::patch('users/profile-update/{id}', 'UserController@profileUpdate')->name('users.profile-update');

Route::resource('languages', 'LanguageController');

Route::resource('pages', 'PageController');

Route::resource('contactus', 'ContactUsController');

Route::resource('notifications', 'NotificationController');

Route::resource('menus', 'MenuController');

//Menu #TODO need to be fixed
Route::get('statusChange/{id}', 'MenuController@statusChange');

Route::resource('settings', 'SettingController');


Route::resource('projects', 'ProjectController');

Route::resource('descriptions', 'DescriptionController');

Route::resource('project-types', 'ProjectTypeController');

Route::resource('project-attributes', 'ProjectAttributeController');

Route::resource('questions', 'QuestionController');

Route::resource('expertises', 'ExpertiseController');

Route::resource('budgets', 'BudgetController');

Route::resource('categories', 'CategoryController');

Route::resource('orders', 'OrderController');

Route::resource('customers', 'CustomerController');

Route::get('sendinvoice/{id}', 'OrderController@invoice')->name('invoice');
Route::get('coinbase/{id}', 'OrderController@coinbase')->name('coinbase');


Route::resource('estimates', 'EstimateController');

Route::resource('estimate-details', 'EstimateDetailController');

Route::resource('invoices', 'InvoiceController');

Route::resource('mailers', 'MailerController');

Route::resource('receivers', 'ReceiverController');

Route::resource('templates', 'TemplateController');

Route::get('template/send/{id}', 'TemplateController@send')->name('send');
Route::get('send', 'TemplateController@sending')->name('sending');
Route::post('forward', 'TemplateController@forward')->name('forward');