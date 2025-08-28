<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TripsTwoController;
use App\Http\Controllers\Web\backend\RoleController;
use App\Http\Controllers\Web\backend\UserController;
use App\Http\Controllers\Web\backend\SettingController;
use App\Http\Controllers\API\TourListsDetailsController;
use App\Http\Controllers\Web\backend\BookingsController;
use App\Http\Controllers\Web\backend\CategoryController;
use App\Http\Controllers\Web\backend\admin\FAQController;
use App\Http\Controllers\Web\backend\DashboardController;
use App\Http\Controllers\Web\backend\PremissionController;
use App\Http\Controllers\Web\backend\BookingsTwoController;
use App\Http\Controllers\Web\backend\CruiseBookingController;
use App\Http\Controllers\Web\backend\settings\DynamicPagesController;
use App\Http\Controllers\Web\backend\settings\ProfileSettingController;



// Dashboard
Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'index')->name('dashboard');
});

// ====================================================
// CMS Routes
// ====================================================

// FAQ Route
Route::controller(FAQController::class)->group(function () {
    Route::get('/faq', 'index')->name('faq.index');
    Route::get('/faq/get', 'get')->name('faq.get');
    Route::post('/faq/priorities', 'priority')->name('faq.priority');
    Route::get('/faq/status', 'status')->name('faq.status');
    Route::post('/faq/store', 'store')->name('faq.store');
    Route::post('/faq/update', 'update')->name('faq.update');
    Route::get('/faq/destroy/{id}', 'destroy')->name('faq.destroy');
});

// Dynamic Pages Route
Route::controller(DynamicPagesController::class)->group(function () {
    Route::get('/dynamicpages', 'index')->name('dynamicpages.index');
    Route::get('/dynamicpages/create', 'create')->name('dynamicpages.create');
    Route::get('/dynamicpages/edit/{id}', 'edit')->name('dynamicpages.edit');
    Route::post('/dynamicpages/store', 'store')->name('dynamicpages.store');
    Route::post('/dynamicpages/update/{id}', 'update')->name('dynamicpages.update');
    Route::delete('/dynamicpages/destroy/{id}', 'destroy')->name('dynamicpages.destroy');
    Route::post('/dynamicpages/status/{id}', 'changeStatus')->name('dynamicpages.status');
    Route::post('/dynamicpages/bulk-delete', 'bulkDelete')->name('dynamicpages.bulk-delete');
});

// Settings Route
Route::controller(SettingController::class)->group(function () {
    Route::get('/general/setting', 'create')->name('general.setting');
    Route::post('/system/update', 'update')->name('system.update');
    Route::get('/system/setting', 'systemSetting')->name('system.setting');
    Route::post('/system/setting/update', 'systemSettingUpdate')->name('system.settingupdate');
    Route::get('/setting', 'adminSetting')->name('admin.setting');
    Route::get('/stripe', 'stripe')->name('admin.setting.stripe');
    Route::post('/stripe', 'stripestore')->name('admin.setting.stripestore');
    Route::get('/paypal', 'paypal')->name('admin.setting.paypal');
    Route::post('/paypal', 'paypalstore')->name('admin.setting.paypalstore');
    Route::get('/mail', 'mail')->name('admin.setting.mail');
    Route::post('/mail', 'mailstore')->name('admin.setting.mailstore');
    Route::post('/setting/update', 'adminSettingUpdate')->name('admin.settingupdate');
});

// Permission Route
// Route::prefix('permissions')->controller(PremissionController::class)->group(function () {
//     Route::get('/list', 'index')->name('admin.permissions.list');
//     Route::get('/create', 'create')->name('admin.permissions.create');
// });

// Role Route
Route::prefix('role')->controller(RoleController::class)->group(function () {
    Route::get('/list', 'index')->name('admin.role.list');
    Route::get('/create', 'create')->name('admin.role.create');
    Route::post('/store', 'store')->name('admin.role.store');
    Route::get('/edit/{id}', 'edit')->name('admin.role.edit');
    Route::post('/update/{id}', 'update')->name('admin.role.update');
    Route::delete('/destroy/{id}', 'destroy')->name('admin.role.destroy');
});

// User Route
Route::controller(UserController::class)->group(function () {
    Route::get('/users/create', 'create')->name('user.create');
    Route::post('/users/store', 'store')->name('user.store');
    Route::get('/edit/users/{id}', 'edit')->name('user.edit');
    Route::post('/update/user', 'update')->name('user.update');
    Route::get('/users/list', 'index')->name('user.list');
    Route::get('/view/users/{id}', 'show')->name('show.user');
    Route::get('/status/users/{id}', 'status')->name('user.status');
    Route::post('/users/delete', 'destroy')->name('user.destroy');
});

// Category Routes
Route::controller(CategoryController::class)->group(function () {
    Route::get('/category/get', 'get')->name('category.get');
    Route::post('/category/priorities', 'priority')->name('category.priority');
    Route::get('/category/status', 'status')->name('category.status');
    Route::get('/category', 'index')->name('category.index');
    Route::post('/category/store', 'store')->name('category.store');
    Route::post('/category/update', 'update')->name('category.update');
    Route::get('/category/destroy/{id}', 'destroy')->name('category.destroy');
});

// Profile Settings Routes
Route::controller(ProfileSettingController::class)->group(function () {
    Route::get('/profile', 'index')->name('profile');
    Route::post('/profile/update', 'updateProfile')->name('profile.update');
    Route::post('/profile/update/password', 'updatePassword')->name('profile.update.password');
    Route::post('/profile/update/profile-picture', 'updateProfilePicture')->name('profile.update.profile.picture');
    Route::get('/checkusername', 'checkusername')->name('checkusername');
});

/**
 * Routes for Trips and Cruise
 */
Route::controller(TourListsDetailsController::class)->group(function () {
    Route::get('/home/trip/index', 'index')->name('trips.list');
    Route::get('/home/trip/getDataList', 'getDataList')->name('trips.getDataList');
    Route::get('/home/trip/show/{id}', 'show')->name('trips.show');
    //Import trips from API
    Route::get('/trips/import', 'importTrips')->name('trips.import');
    //cruise lists
    Route::get('/cruise/lists', 'cruiseLists')->name('cruise.list');
    Route::get('/cruise/getData', 'getData')->name('cruise.getData');
    Route::get('/cruise/import', 'importCruise')->name('cruise.import');
    Route::get('/cruise/show/{id}', 'showDetails')->name('cruise.show');
    // New proxy route
    // Route::get('/image-proxy', 'imageProxy')->name('image.proxy');
});

/**
 * Routes for Trips twos Data Import via API
 */
Route::controller(TripsTwoController::class)->group(function () {
    Route::get('/trip/two/index', 'index')->name('trips.two.list');
    Route::get('/trip/two/getData', 'getData')->name('trips.two.getData');
    Route::get('/trip/two/show/{id}', 'show')->name('trips.two.show');
    Route::get('/trips/two/import', 'importTrips')->name('trips.two.import');
});

/**
 * Routes for Trips Booking
 */
Route::controller(BookingsController::class)->group(function () {
    Route::get('/bookings/one', 'index')->name('bookings.index');
    Route::post('/booking/status/{id}', 'updateStatus')->name('bookings.status');
    Route::get('/booking/show/{id}', 'show')->name('bookings.show');
    Route::delete('/bookings/del/{id}',  'destroy')->name('bookings.destroy');
});

/**
 * Routes for Trips Booking Two
 */
Route::controller(BookingsTwoController::class)->group(function () {
    Route::get('/bookings-two', 'index')->name('booking-two.index');
    Route::post('/booking-two/status/{id}', 'updateStatus')->name('booking-two.status');
    Route::get('/booking-two/show/{id}', 'show')->name('booking-two.show');
    Route::delete('/bookings-two/del/{id}',  'destroy')->name('booking-two.destroy');
});

/**
 * Routes for Cruise Booking
 */
Route::controller(CruiseBookingController::class)->group(function () {
    Route::get('/bookings/cruise', 'index')->name('booking.cruise.index');
    Route::post('/booking/cruise/status/{id}', 'updateStatus')->name('booking.cruise.status');
    Route::get('/booking/cruise/show/{id}', 'show')->name('booking.cruise.show');
    Route::delete('/bookings/cruise/del/{id}',  'destroy')->name('booking.cruise.destroy');
});
