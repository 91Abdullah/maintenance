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

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    //return view('welcome');
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('backend')->middleware(['auth'])->group(function () {
    Route::view('/', 'architect.index')->name('index');

    Route::namespace('Backend')->group(function () {

        Route::middleware(['can:admin-access'])->group(function () {
            Route::resource('users', 'UserController');
            Route::resource('maintenanceUsers', 'MaintenanceUserController');
            Route::resource('outlet', 'OutletController');
            Route::resource('department', 'DepartmentController');
            Route::resource('issue', 'IssueController');
            Route::resource('ticketStatus', 'TicketStatusController');
            Route::resource('messageRecipient', 'MessageRecipientController');

            Route::get('settings', 'SettingController@index')->name('settings.index');
            Route::patch('settings', 'SettingController@update')->name('settings.update');
            //Route::resource('smsRecipient', 'SmsRecipientController');
            //Route::resource('rating', 'RatingController');

            // Export Routes

        });

        // Search Route
        Route::get('/searchCustomer', 'SearchController@searchCustomer')->name('search.customer');

        Route::resource('customer', 'CustomerController');
        Route::get('/complain/search', 'ComplainController@showSearch')->name('complain.form');
        Route::post('/complain/search/query', 'ComplainController@search')->name('complain.search');
        Route::resource('complain', 'ComplainController')->except(['destroy']);

        //Widgets
        Route::get('/getWidgetData', 'WidgetController@getData')->name('widget.data');
        Route::get('/getChartLabels', 'WidgetController@getChartLabels')->name('chart.labels');
    });

    Route::namespace('Report')->middleware(['can:admin-access'])->prefix('reports')->group(function () {
        Route::prefix('complains')->group(function () {
            Route::view('/', 'architect.reports.complains')->name('report.complain.get');
            Route::post('report', 'ComplainReportController@report')->name('report.complain.post');
        });

        /*Route::prefix('ratings')->group(function () {
            Route::view('/', 'architect.reports.ratings')->name('report.rating.get');
            Route::post('report', 'RatingReportController@report')->name('report.rating.post');
        });*/

        Route::prefix('activity')->group(function () {
            Route::get('/', 'ActivityReportController@index')->name('report.activity');
        });

        Route::prefix('login')->group(function () {
            Route::get('/', 'LoginReportController@index')->name('report.login');
            Route::post('report', 'LoginReportController@report')->name('report.login.post');
        });
    });

});
