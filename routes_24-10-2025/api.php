<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('App\Http\Controllers\Api\V1')->prefix("v1/auth")->name("api.v1.auth")->group(function(){
   Route::post('login', 'AuthController@login')->name('login');
   Route::post('social_login', 'AuthController@social_login')->name('social_login');
   Route::post('signup', 'AuthController@signup')->name('signup');
});
Route::namespace('App\Http\Controllers\Api\V1')->prefix("v1")->middleware('auth:sanctum')->name("api.v1")->group(function(){
   Route::post('logout', 'AuthController@logout')->name('logout');
   Route::post('change_password', 'AuthController@change_password')->name('change_password');
   Route::get('my_profile', 'HomeController@my_profile');
   Route::post('update_profile', 'HomeController@update_profile');
   Route::post('fav_unfav_property', 'HomeController@fav_unfav_property');
   Route::get('favorite', 'HomeController@favorite');
   Route::get('my_bookings', 'HomeController@my_bookings');
   Route::post('book-now', 'HomeController@book_now');
   Route::get('get_agency_details', 'HomeController@get_agency_details');
   Route::post('get_reservation_by_id', 'HomeController@get_reservation_by_id');
   Route::get('get_reservations_list', 'HomeController@get_reservations_list');
   Route::get('get_visit_schedules_list', 'HomeController@get_visit_schedules_list');
   Route::post('get_visit_schedule_by_id', 'HomeController@get_visit_schedule_by_id');
   Route::post('add_visit_schedule', 'HomeController@add_visit_schedule');
   Route::get('get_agents_by_agency', 'HomeController@get_agents_by_agency');
//    Route::post('reset_password', 'HomeController@reset_password');
  });
  Route::namespace('App\Http\Controllers\Api\V1')->prefix("v1")->name("api.v1")->group(function(){
   Route::get('projects', 'HomeController@projects');
   Route::post('project_details', 'HomeController@project_details');
   Route::post('properties', 'HomeController@properties');
   Route::post('property_details', 'HomeController@property_details');
   Route::get('countries', 'HomeController@countries');
   Route::get('project_countries', 'HomeController@project_countries');
   Route::get('property_types', 'HomeController@property_types');
   Route::post('save_contact_us', 'HomeController@save_contact_us');
   Route::get('qib-init/{any}', 'HomeController@qibInit');
   Route::post('send_login_otp', 'AuthController@send_login_otp')->name('send_login_otp');
   Route::post('verify_login_otp', 'AuthController@verify_login_otp')->name('verify_login_otp');
   Route::get('/qib_payment_status', 'HomeController@qib_payment_status');
   Route::post('send_forgot_password_otp', 'AuthController@send_forgot_password_otp');
   Route::post('reset_forgot_password', 'AuthController@reset_forgot_password')->name('reset_forgot_password');

  });


