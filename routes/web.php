<?php

use Illuminate\Support\Facades\Route;

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


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('timesheet/clock-out', 'TimeSheetController@clockOut')->name('timesheet.clockOut');
Route::resource('timesheet', 'TimeSheetController')->only(['index', 'store']);
Route::get('timesheet-list/{employee}', 'TimeSheetListController@showEmployeeTimesheet')->name('timesheet-list.show');
Route::post('timesheet-list/{employee}/search', 'TimeSheetListController@showEmployeeTimesheet')->name('timesheet-list.search.show');
Route::get('timesheet-list', 'TimeSheetListController@index')->name('timesheet-list.index');
Route::resource('user', 'UserController');
Route::resource('employee.rate', 'Employee\EmployeeRateController');