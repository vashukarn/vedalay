<?php

use App\Http\Controllers\Admin\AdvanceSalaryController;
use App\Http\Controllers\Admin\AppSettingController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CkeditorController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FeeController;
use App\Http\Controllers\Admin\InformationController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SalaryController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
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

Route::post('ckeditor/upload', [CkeditorController::class, 'upload'])->name('ckeditor.upload');
Route::get('two-factor-recovery', [UserController::class, 'recovery'])->middleware('guest');
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'verified']], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('customers', CustomerController::class);

    Route::resource('profile', ProfileController::class);
    Route::get('profiledetail', [UserController::class, 'profiledetail'])->name('profiledetail')->middleware('password.confirm');

    Route::resource('news', NewsController::class);

    Route::put('{id}/changepassword', [UserController::class, 'updatePassword'])->name('update-password');
    Route::get('setting/sms', [AppSettingController::class, 'smsApi'])->name('smsApi.index')->middleware('password.confirm');
    Route::post('setting/sms', [AppSettingController::class, 'smsApiSave'])->name('smsApi.store');
    Route::put('setting/sms/{id}/update', [AppSettingController::class, 'smsApiUpdate'])->name('smsApi.update');
    Route::resource('setting', AppSettingController::class)->middleware('password.confirm');
    Route::resource('slider', SliderController::class);
    Route::resource('content', ContentController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('tag', TagController::class);
    Route::resource('blog', BlogController::class);
    Route::resource('testimonial', TestimonialController::class);
    Route::resource('faq', FaqController::class);
    Route::resource('information', InformationController::class);
    Route::resource('subject', SubjectController::class);
    Route::resource('fee', FeeController::class);
    Route::post('rollbackTransaction/{fee}', [FeeController::class, 'rollbackTransaction'])->name('rollbackTransaction');
    Route::post('rollbackSalary/{salary}', [SalaryController::class, 'rollbackSalary'])->name('rollbackSalary');
    Route::post('getStudents', [FeeController::class, 'getStudents'])->name('getStudents');

    Route::resource('salary', SalaryController::class);
    Route::resource('advancesalary', AdvanceSalaryController::class);
    Route::post('getSalary', [SalaryController::class, 'getData'])->name('getSalary');
    Route::resource('student', StudentController::class);
    Route::resource('teacher', TeacherController::class);
    Route::resource('staff', StaffController::class);
    Route::resource('attendance', AttendanceController::class);
    Route::get('takeAttendance/{id}', [AttendanceController::class, 'takeAttendance'])->name('takeAttendance');
    Route::get('attendanceList/{id}', [AttendanceController::class, 'attendanceList'])->name('attendanceList');
    Route::post('updateAttendance', [AttendanceController::class, 'updateAttendance'])->name('updateAttendance');
    
    Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
    Route::get('contact/view/{contact}', [ContactController::class, 'view'])->name('contact.show');

});
Route::get('/content/{slug}', [SliderController::class, 'sliderDetail'])->name('sliderDetail');
