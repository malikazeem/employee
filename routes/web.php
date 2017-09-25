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


Route::get('/', function () {
	
    return view('dashboard');
})->middleware('auth');*/
Route::get('/', 'EmployeeManagementController@index')->middleware('auth');
Auth::routes();

Route::get('/dashboard', 'EmployeeManagementController@index');
 //Route::get('/system-management', 'SystemMgmtController@index');
Route::get('/profile', 'ProfileController@index');

Route::post('user-management/search', 'UserManagementController@search')->name('user-management.search');
Route::resource('user-management', 'UserManagementController');

Route::resource('employee-management', 'EmployeeManagementController');
Route::post('employee-management/search', 'EmployeeManagementController@search')->name('employee-management.search');

Route::resource('files', 'FilesController');
Route::post('files/search', 'FilesController@search')->name('files.search');

Route::resource('system-management/company', 'CompanyController');
Route::post('system-management/company/search', 'CompanyController@search')->name('company.search');

Route::resource('system-management/city', 'CityController');
Route::post('system-management/city/search', 'CityController@search')->name('city.search');

Route::resource('system-management/project', 'ProjectController');
Route::post('system-management/project/search', 'ProjectController@search')->name('project.search');

Route::resource('system-management/timelog', 'TimelogController');
Route::post('system-management/timelog/search', 'TimelogController@search')->name('timelog.search');

Route::get('system-management/report', 'ReportController@index');
Route::get('system-management/report/search', 'ReportController@search')->name('report.search');
Route::post('system-management/report/search', 'ReportController@search')->name('report.search');
Route::post('system-management/report/excel', 'ReportController@exportExcel')->name('report.excel');
Route::post('system-management/report/pdf', 'ReportController@exportPDF')->name('report.pdf');

Route::get('avatars/{name}', 'EmployeeManagementController@load');