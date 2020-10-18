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
Route::post('timesheet/clock-out', 'TimeSheet\TimeSheetController@clockOut')->name('timesheet.clockOut');
Route::resource('timesheet', 'TimeSheet\TimeSheetController')->only(['index', 'store', 'edit', 'update']);
Route::resource('payment', 'Payment\PaymentController')->only(['index', 'show', 'store', 'edit', 'update']);
Route::get('timesheet-list/{employee}', 'TimeSheet\TimeSheetListController@showEmployeeTimesheet')->name('timesheet-list.show');
Route::get('timesheet-list/{employee}/export', 'TimeSheet\TimeSheetExportController@index')->name('timesheet-list.export.index');
Route::get('timesheet-list/{employee}/search', 'TimeSheet\TimeSheetListController@showEmployeeTimesheet')->name('timesheet-list.search.show');
Route::get('timesheet-list', 'TimeSheet\TimeSheetListController@index')->name('timesheet-list.index');
Route::resource('user', 'UserController');
Route::resource('employee/rate', 'Employee\EmployeeRateController')->parameters(["rate" => "employee"])->only(["show", "update"]);
