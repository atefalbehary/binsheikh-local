<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Laravel\Socialite\Facades\Socialite;

Route::get('/clear', function () {

    Artisan::call('cache:clear');

    Artisan::call('config:cache');

    Artisan::call('config:clear');

    Artisan::call('view:clear');

    Artisan::call('optimize:clear');

    die('cleared');

});

Route::get('/', 'App\Http\Controllers\front\HomeController@index')->name('home');
Route::get('/google41802e3e0f5e94ab.html', function() {
    return File::get(public_path('google41802e3e0f5e94ab.html'));
});
Route::get('/property-details/{slug}', 'App\Http\Controllers\front\HomeController@property_details');
Route::get('/property-listing', 'App\Http\Controllers\front\HomeController@property_listing');
Route::post('/get-projects', 'App\Http\Controllers\front\HomeController@getProjects');
Route::post('/calculate_emi', 'App\Http\Controllers\front\HomeController@calculate_emi');
Route::post('/get_payment_dates', 'App\Http\Controllers\front\HomeController@get_payment_dates');
Route::get('/download-payment-plan/{id}', 'App\Http\Controllers\front\HomeController@downloadPaymentPlan');
Route::post('/download-calculator-result', 'App\Http\Controllers\front\HomeController@downloadCalculatorResult');


Route::get('/login/facebook', function () {
    return Socialite::driver('facebook')->redirect();
});
Route::get('/login/google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/google/callback', 'App\Http\Controllers\front\HomeController@google_callback');
Route::get('/facebook/callback', 'App\Http\Controllers\front\HomeController@facebook_callback');

Route::get('/project-details/{slug}', 'App\Http\Controllers\front\HomeController@project_details');
Route::get('/project-listing', 'App\Http\Controllers\front\HomeController@project_listing');
Route::get('/photos', 'App\Http\Controllers\front\HomeController@photos');
Route::get('/videos', 'App\Http\Controllers\front\HomeController@videos');
Route::get('/blog-details/{slug}', 'App\Http\Controllers\front\HomeController@blog_details');
Route::get('/blogs', 'App\Http\Controllers\front\HomeController@blogs');
Route::get('/folder/{id}', 'App\Http\Controllers\front\FolderController@folder');

Route::get('/service-details/{slug}', 'App\Http\Controllers\front\HomeController@service_details');
Route::get('/services', 'App\Http\Controllers\front\HomeController@services');
Route::get('contact-us', 'App\Http\Controllers\front\ContactUsController@index')->name('frontend.contact_us');
Route::get('about-us', 'App\Http\Controllers\front\AboutUsController@index')->name('frontend.about_us');
Route::get('privacy-policy', 'App\Http\Controllers\front\HomeController@privacy_policy')->name('frontend.privacy_policy');
Route::get('data-deletion', 'App\Http\Controllers\front\HomeController@data_deletion')->name('frontend.data_deletion');


Route::get('/qib', 'App\Http\Controllers\front\HomeController@qib');
Route::get('/qib_payment_status', 'App\Http\Controllers\front\HomeController@qib_payment_status');
Route::get('/qib_reserve_payment_status', 'App\Http\Controllers\front\HomeController@qib_reserve_payment_status');


Route::get('/admin', 'App\Http\Controllers\admin\LoginController@login')->name('admin.login');

Route::post('admin/check_login', 'App\Http\Controllers\admin\LoginController@check_login')->name('admin.check_login');

Route::post('/checkAvailability', 'App\Http\Controllers\front\HomeController@checkAvailability');

Route::post('/store_nearest_branch_details', 'App\Http\Controllers\front\HomeController@store_nearest_branch_details');

Route::get('/change_currency/{slug}', 'App\Http\Controllers\front\HomeController@change_currency');
Route::post('save_subscribe', 'App\Http\Controllers\front\HomeController@save_subscribe');

Route::namespace('App\Http\Controllers\admin')->prefix('admin')->middleware('admin')->name('admin.')->group(function () {

    Route::get('change-password', 'AdminController@changePassword')->name('change.password');

    Route::post('change-password', 'AdminController@changePasswordSave')->name('change.password.save');

    Route::match(array('GET', 'POST'), 'change_password', 'UsersController@change_password');

    Route::get('logout', 'LoginController@logout')->name('logout');

    Route::get('dashboard', 'DashboardController@dashboard')->name('dashboard');

    Route::get('bookings', 'DashboardController@bookings')->name('bookings');

    Route::get("categories", "CategoryController@index");

    Route::get("categories/create", "CategoryController@create");

    Route::post("categories/change_status", "CategoryController@change_status");

    Route::get("categories/edit/{id}", "CategoryController@edit");

    Route::delete("categories/delete/{id}", "CategoryController@destroy");

    Route::post("save_categories", "CategoryController@store");

    Route::get("amenities", "AmenitiesController@index");

    Route::get("amenities/create", "AmenitiesController@create");

    Route::post("amenities/change_status", "AmenitiesController@change_status");

    Route::get("amenities/edit/{id}", "AmenitiesController@edit");

    Route::delete("amenities/delete/{id}", "AmenitiesController@destroy");

    Route::post("save_amenities", "AmenitiesController@store");

    Route::get("properties", "PropertyController@index");

    Route::get("property/create", "PropertyController@create");

    Route::post("property/change_status", "PropertyController@change_status");

    Route::get("property/edit/{id}", "PropertyController@edit");

    Route::delete("property/delete/{id}", "PropertyController@destroy");

    Route::post("save_property", "PropertyController@store");

    Route::delete("property/delete_image/{id}", "PropertyController@delete_image");
    Route::delete('properties/deleteAll', "PropertyController@deleteAll")->name('properties.deleteAll');

    Route::get("blog", "BlogController@index");

    Route::get("blog/create", "BlogController@create");

    Route::post("blog/change_status", "BlogController@change_status");

    Route::get("blog/edit/{id}", "BlogController@edit");

    Route::delete("blog/delete/{id}", "BlogController@destroy");

    Route::post("save_blog", "BlogController@store");


    Route::get("photos", "GalleryController@index");

    Route::get("photos/create", "GalleryController@create");

    Route::post("photos/change_status", "GalleryController@change_status");

    Route::delete("photos/delete/{id}", "GalleryController@destroy");

    Route::post("save_photos", "GalleryController@store");
    Route::delete('photos/deleteAll', "GalleryController@deleteAll")->name('photos.deleteAll');


    Route::get("videos", "VideoController@index");
    Route::get("videos/create", "VideoController@create");
    Route::post("videos/change_status", "VideoController@change_status");
    Route::get("videos/edit/{id}", "VideoController@edit");
    Route::delete("videos/delete/{id}", "VideoController@destroy");
    Route::post("save_videos", "VideoController@store");
    Route::delete('videos/deleteAll', "VideoController@deleteAll")->name('videos.deleteAll');

    Route::get("folders", "FolderController@index");
    Route::get("folders/create", "FolderController@create");
    Route::post("folders/change_status", "FolderController@change_status");
    Route::get("folders/edit/{id}", "FolderController@edit");
    Route::delete("folders/delete/{id}", "FolderController@destroy");
    Route::post("save_folders", "FolderController@store");
    Route::delete('folders/deleteAll', "FolderController@deleteAll")->name('folders.deleteAll');

    Route::get("projects", "ProjectController@index");

    Route::get("project/create", "ProjectController@create");

    Route::post("project/change_status", "ProjectController@change_status");

    Route::get("project/edit/{id}", "ProjectController@edit");

    Route::delete("project/delete/{id}", "ProjectController@destroy");

    Route::post("save_project", "ProjectController@store");

    Route::delete("project/delete_image/{id}", "ProjectController@delete_image");


    Route::get("services", "ServiceController@index");

    Route::get("service/create", "ServiceController@create");

    Route::post("service/change_status", "ServiceController@change_status");

    Route::get("service/edit/{id}", "ServiceController@edit");

    Route::delete("service/delete/{id}", "ServiceController@destroy");

    Route::post("save_service", "ServiceController@store");

    Route::get("subscribers", "SubscriberController@index");

    Route::delete("subscribers/delete/{id}", "SubscriberController@destroy");

    Route::get("pages", "PageController@index");

    Route::get("page/edit/{id}", "PageController@edit");

    Route::delete("page/delete/{id}", "PageController@destroy");

    Route::post("save_page", "PageController@store");

    Route::post("page/change_status", "PageController@change_status");

    Route::get('settings', 'SettingsController@settings')->name('settings');
    Route::post("setting_store", "SettingsController@setting_store")->name('setting_store');

    Route::get("project_countries", "ProjectCountriesController@index");

    Route::get("project_countries/create", "ProjectCountriesController@create");

    Route::post("project_countries/change_status", "ProjectCountriesController@change_status");

    Route::get("project_countries/edit/{id}", "ProjectCountriesController@edit");

    Route::delete("project_countries/delete/{id}", "ProjectCountriesController@destroy");

    Route::post("save_project_countries", "ProjectCountriesController@store");

    Route::get("reviews", "ReviewsController@index");

    Route::get("reviews/create", "ReviewsController@create");

    Route::post("reviews/change_status", "ReviewsController@change_status");

    Route::get("reviews/edit/{id}", "ReviewsController@edit");

    Route::delete("reviews/delete/{id}", "ReviewsController@destroy");

    Route::post("save_reviews", "ReviewsController@store");


    Route::get("career", "CareerController@index");

    Route::get("career/create", "CareerController@create");

    Route::post("career/change_status", "CareerController@change_status");

    Route::get("career/edit/{id}", "CareerController@edit");

    Route::delete("career/delete/{id}", "CareerController@destroy");

    Route::post("save_career", "CareerController@store");
    Route::get("job_application", "CareerController@applications");
    Route::delete('job_application/deleteAll', "CareerController@deleteAll")->name('job_application.deleteAll');
    Route::post('job_application/downloadCSV', "CareerController@downloadCSV")->name('job_application.downloadCSV');
    Route::delete("career/delete_application/{id}", "CareerController@delete_application");



    Route::get("customer/{role?}", "CustomerController@index");

    Route::get("customer/create", "CustomerController@create");

    Route::post("customer/change_status", "CustomerController@change_status");

    Route::get("customer/edit/{id}", "CustomerController@edit");

    Route::get("customer/download-document/{filename}", "CustomerController@downloadDocument");
    Route::delete("customer/delete/{id}", "CustomerController@destroy");

    Route::delete('customer/deleteAll', "CustomerController@deleteAll")->name('customer.deleteAll');

    Route::get('customer/details/{id}', 'CustomerController@details')->name('admin.customer.details');
    Route::get('customer/approve/{id}', 'CustomerController@approve')->name('admin.customer.approve');
    Route::post('customer/update-commission', 'CustomerController@updateCommission')->name('admin.customer.update-commission');
    Route::post('customer/update-discount', 'CustomerController@updateDiscount')->name('admin.customer.update-discount');
    Route::post('customer/update-apartments', 'CustomerController@updateApartments')->name('admin.customer.update-apartments');

});

Route::any('/check_sms', 'App\Http\Controllers\front\HomeController@check_sms')
;
Route::get('change-language/{lang}', 'App\Http\Controllers\front\HomeController@changeLang');

Route::post('frontend/check_login', 'App\Http\Controllers\front\HomeController@check_login')->name('frontend.check_login');
Route::post('frontend/signup', 'App\Http\Controllers\front\HomeController@signup')->name('frontend.signup');
Route::post('frontend/apply_career', 'App\Http\Controllers\front\ContactUsController@apply_career')->name('frontend.apply_career');
Route::middleware('user')->group(function () {
    Route::get('my-profile', 'App\Http\Controllers\front\HomeController@my_profile')->name('frontend.my_profile');
    Route::post('fav_property', 'App\Http\Controllers\front\HomeController@fav_property')->name('frontend.fav_property');
    Route::post('update_profile', 'App\Http\Controllers\front\HomeController@update_profile')->name('frontend.update_profile');
    Route::post('change_password', 'App\Http\Controllers\front\HomeController@change_password')->name('frontend.update_profile');
    Route::get('favorite', 'App\Http\Controllers\front\HomeController@favorite')->name('frontend.favorite');
    Route::get('my-bookings', 'App\Http\Controllers\front\HomeController@my_bookings')->name('frontend.my_bookings');
    Route::get('my-reservations', 'App\Http\Controllers\front\HomeController@my_reservations')->name('frontend.my_reservations');
    Route::get('book-now/{property}', 'App\Http\Controllers\front\HomeController@book_now')->name('frontend.book_now');
    Route::get('specific-book-now/{property}', 'App\Http\Controllers\front\HomeController@specific_book_now')->name('frontend.book_now');
    Route::get('book-rent-now/{property}', 'App\Http\Controllers\front\HomeController@book_rent_now')->name('frontend.book_rent_now');

    Route::get('/checkout/{property}', 'App\Http\Controllers\front\HomeController@checkout');

    Route::get('/specific-checkout/{property}', 'App\Http\Controllers\front\HomeController@specific_checkout');

    Route::get('user/logout', 'App\Http\Controllers\front\HomeController@logout')->name('frontend.logout');

});

Route::get('get-property-count', 'App\Http\Controllers\front\HomeController@getPropertyCount');
Route::get('/download-payment-plan/{id}', 'App\Http\Controllers\front\HomeController@downloadPaymentPlan');
