<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RiderController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UserLogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AppSettingController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\admin\ImageCropController;
use App\Http\Controllers\AppNoticeController;
use App\Http\Controllers\ComplimentController;
use App\Http\Controllers\ProfileController;


Route::get('two-factor-recovery', [UserController::class, 'recovery'])->middleware('guest');
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('logout', [UserController::class, 'logout'])->name('user.logout');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('profile', ProfileController::class);
    Route::post('/ajax-upload', [ImageCropController::class, 'ajaxImageUpload'])->name('ajaxImageUpload');
    Route::post('/crop-image', [ImageCropController::class, 'uploadCropImage'])->name('uploadCropImage');


    // Route::get('profile', [UserController::class, 'profile'])->name('profile')->middleware('password.confirm');
    Route::put('{id}/changepassword', [UserController::class, 'updatePassword'])->name('update-password');
    Route::get('setting/sms', [AppSettingController::class, 'smsApi'])->name('smsApi.index')->middleware('password.confirm');
    Route::post('setting/sms', [AppSettingController::class, 'smsApiSave'])->name('smsApi.store');
    Route::put('setting/sms/{id}/update', [AppSettingController::class, 'smsApiUpdate'])->name('smsApi.update');
    Route::resource('setting', AppSettingController::class)->middleware('password.confirm');
    Route::post('/verify-rider/{rider_id}', [RiderController::class, 'verifyRider'])->name('verifyRider');
    Route::resource('slider', SliderController::class);
    Route::resource('feature', FeatureController::class);
    Route::resource('information', InformationController::class);
    Route::resource('compliment', ComplimentController::class);
    Route::resource('appnotice', AppNoticeController::class);
    Route::get('clear-log', [UserLogController::class, 'ClearAll'])->name('clear-log');
    Route::get('user-log', UserLogController::class)->name('user-log.index');
    Route::post('update',  [MenuController::class, 'updateMenuOrder'])->name('update.menu');
    Route::get('additional-menu/{id}', [MenuController::class, 'additional_menu'])->name('menu.additonal');
    Route::resource('menu', MenuController::class)->middleware('password.confirm');
});

Route::get('/content/{slug}', [SliderController::class, 'sliderDetail'])->name('sliderDetail');

/* Route::get('/map', function () {
    return view('admin.mapdashboard.map-dashboard');
})->name('map.dashbaord')->middleware('auth'); */

Route::group(['prefix' => 'rider', 'middleware' => ['auth']], function () {
    return 'hello';
});
