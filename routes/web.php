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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Employees
Route::get('employees', function(){
	return view('employees/index');
});
Route::get('/employees/create', 'EmployeesController@create')->name('createEmployee')->middleware('auth');
Route::post('/employees/update', 'EmployeesController@update')->name('updateEmployee')->middleware('auth');
Route::post('/employees', 'EmployeesController@store')->middleware('auth');
Route::get('/getEmployees', 'EmployeesController@listEmployees')->name('getEmployees')->middleware('auth');