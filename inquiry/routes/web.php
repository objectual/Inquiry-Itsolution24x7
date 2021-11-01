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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::resource('users', 'UserController');
Route::get('/', 'HomeController@index')->name('1');
Route::get('description/project_id/{project_id}/', 'HomeController@description')->name('2');
Route::get('detail/project_id/{project_id}/', 'HomeController@detail')->name('3');
Route::get('question/project_id/{project_id}/', 'HomeController@question')->name('4');
Route::get('expertise/project_id/{project_id}/', 'HomeController@expertise')->name('5');
Route::get('budget/project_id/{project_id}/', 'HomeController@budget')->name('6');
Route::get('title/email/{email}/', 'HomeController@title')->name('7');
Route::get('home', 'HomeController@home')->name('8');
Route::get('review/project_id/{project_id}', 'HomeController@reviews')->name('9');
Route::get('thanks', 'HomeController@thanks')->name('10');
Route::post('ProjectStore', 'HomeController@projectStore');
Route::post('DescriptionStore', 'HomeController@descriptionStore');
Route::post('DetailStore', 'HomeController@detailStore');
Route::post('QuestionStore', 'HomeController@questionStore');
Route::post('ExpertiseStore', 'HomeController@expertiseStore');
Route::post('BudgetStore', 'HomeController@budgetStore');
Route::post('ReviewStore', 'HomeController@reviewStore');
Route::get('order', 'HomeController@order')->name('order');
Auth::routes();