<?php

use App\Http\Controllers\Admin\AdvanceFeeController;
use App\Http\Controllers\Admin\AdvanceSalaryController;
use App\Http\Controllers\Admin\AppSettingController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChartController;
use App\Http\Controllers\Admin\CkeditorController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FeeController;
use App\Http\Controllers\Admin\FeePaymentController;
use App\Http\Controllers\Admin\HomePageController;
use App\Http\Controllers\Admin\InformationController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\InventoryItemController;
use App\Http\Controllers\Admin\LeaveController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\NoticeboardController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PWAController;
use App\Http\Controllers\Admin\RazorpayController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SalaryController;
use App\Http\Controllers\Admin\SessionController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserLogController;
use App\Http\Controllers\Admin\VacancyController;
use Illuminate\Support\Facades\Route;

Route::post('ckeditor/upload', [CkeditorController::class, 'upload'])->name('ckeditor.upload');
Route::get('two-factor-recovery', [UserController::class, 'recovery'])->middleware('guest');
Route::group(['prefix' => 'user', 'middleware' => ['auth', 'verified']], function () {
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('feeadvance', AdvanceFeeController::class);
    Route::resource('feepayment', FeePaymentController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('profile', ProfileController::class);
    Route::resource('news', NewsController::class);
    Route::resource('setting', AppSettingController::class)->middleware('password.confirm');
    Route::resource('slider', SliderController::class);
    Route::resource('content', ContentController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('tag', TagController::class);
    Route::resource('blog', BlogController::class);
    Route::resource('level', LevelController::class);
    Route::resource('session', SessionController::class);
    Route::resource('testimonial', TestimonialController::class);
    Route::resource('faq', FaqController::class);
    Route::resource('information', InformationController::class);
    Route::resource('subject', SubjectController::class);
    Route::resource('feature', FeatureController::class);
    Route::resource('fee', FeeController::class);
    Route::resource('vacancy', VacancyController::class);
    Route::resource('exam', ExamController::class);
    Route::resource('result', ResultController::class);
    Route::resource('team', TeamController::class);
    Route::resource('inventory', InventoryController::class);
    Route::resource('inventoryitem', InventoryItemController::class);
    Route::resource('homepage', HomePageController::class);
    Route::resource('salary', SalaryController::class);
    Route::resource('advancesalary', AdvanceSalaryController::class);
    Route::resource('student', StudentController::class);
    Route::resource('teacher', TeacherController::class);
    Route::resource('staff', StaffController::class);
    Route::resource('attendance', AttendanceController::class);
    Route::resource('leave', LeaveController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('task', TaskController::class);
    Route::resource('noticeboard', NoticeboardController::class);
    Route::resource('expense', ExpenseController::class);
    Route::resource('assignment', AssignmentController::class);
    Route::resource('payment', PaymentController::class);
    Route::resource('razorpay', RazorpayController::class);
    Route::resource('menu', MenuController::class)->middleware('password.confirm');
    Route::resource('setting', AppSettingController::class)->middleware('password.confirm');

    // Charts
    Route::get('expenseIncomeChart', [ChartController::class, 'expenseIncomeChart'])->name('chart.incomeexpense');

    Route::get('clearNotification/{id}', [DashboardController::class, 'clearNotification'])->name('clearNotification');
    Route::get('publishNotice/{id}', [NoticeboardController::class, 'publishNotice'])->name('publishNotice');
    Route::get('paysuccess', [RazorpayController::class, 'store']);
    Route::get('admission', [StudentController::class, 'admission'])->name('admission');
    Route::get('admissionshow/{id}', [StudentController::class, 'admissionshow'])->name('admissionshow');
    Route::post('addExam', [ExamController::class, 'addExam'])->name('addExam');
    Route::post('addResult', [ResultController::class, 'addResult'])->name('addResult');
    Route::get('publishExam/{id}', [ExamController::class, 'publishExam'])->name('publishExam');
    Route::get('publishResult/{id}', [ResultController::class, 'publishResult'])->name('publishResult');
    Route::get('jobapplicant/{fee}', [VacancyController::class, 'jobapplicant'])->name('jobapplicant');
    Route::post('rollbackTransaction/{fee}', [FeeController::class, 'rollbackTransaction'])->name('rollbackTransaction');
    Route::post('rollbackSalary/{salary}', [SalaryController::class, 'rollbackSalary'])->name('rollbackSalary');
    Route::post('getSubjectExam', [ResultController::class, 'getSubjectExam'])->name('getSubjectExam');
    Route::post('getResultData', [ResultController::class, 'getResultData'])->name('getResultData');
    Route::post('getStudents', [FeeController::class, 'getStudents'])->name('getStudents');
    Route::post('getSubjects', [ExamController::class, 'getSubjects'])->name('getSubjects');
    Route::post('getFeeDetails', [FeePaymentController::class, 'getFeeDetails'])->name('getFeeDetails');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('changeTaskStatus', [TaskController::class, 'changeTaskStatus'])->name('changeTaskStatus');
    Route::post('feeadvance/{id}', [AdvanceFeeController::class, 'pay'])->name('feeadvance.pay');
    Route::get('profiledetail', [UserController::class, 'profiledetail'])->name('profiledetail')->middleware('password.confirm');
    Route::post('getSalary', [SalaryController::class, 'getData'])->name('getSalary');
    Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
    Route::get('contact/view/{contact}', [ContactController::class, 'view'])->name('contact.show');
    Route::post('logout', [UserController::class, 'logout'])->name('user.logout');
    Route::put('{id}/changepassword', [UserController::class, 'updatePassword'])->name('update-password');
    Route::get('setting/sms', [AppSettingController::class, 'smsApi'])->name('smsApi.index')->middleware('password.confirm');
    Route::post('setting/sms', [AppSettingController::class, 'smsApiSave'])->name('smsApi.store');
    Route::put('setting/sms/{id}/update', [AppSettingController::class, 'smsApiUpdate'])->name('smsApi.update');
    Route::get('clear-log', [UserLogController::class, 'ClearAll'])->name('clear-log');
    Route::get('user-log', UserLogController::class)->name('user-log.index');
    Route::post('update',  [MenuController::class, 'updateMenuOrder'])->name('update.menu');
    Route::get('additional-menu/{id}', [MenuController::class, 'additional_menu'])->name('menu.additonal');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::put('{id}/changepassword', [UserController::class, 'updatePassword'])->name('update-password');
});
