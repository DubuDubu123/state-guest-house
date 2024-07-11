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
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Web\Admin\PDFController;

/*
 * These routes use the root namespace 'App\Http\Controllers\Web'.
 */
Route::namespace('Web')->group(function () {

    // All the folder based web routes
    include_route_files('web'); 


    // Website home route
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/register', 'HomeController@register');
    Route::post('/register', 'HomeController@register_user');
    Route::get('/get-user-details', 'HomeController@get_user_details');
    Route::post('/send-email', 'HomeController@send_email');
    Route::post('/send-forget-mail', 'HomeController@send_forget_email');
    Route::post('/resend-otp-mail', 'HomeController@resend_forget_email');
    Route::get('/forget-userid', 'HomeController@forget_user');
    Route::get('/forget-password', 'HomeController@forget_password');
    Route::get('/verify-otp/{token}', 'HomeController@reset_password');
    Route::get('/reset-password', 'HomeController@set_password');
    Route::post('/verify-otp', 'HomeController@validateMobileOTP');
    Route::get('/register-confirmation', 'HomeController@register_confirmation');
    Route::get('/check-user-exists', 'HomeController@check_user_exists');
    
});

