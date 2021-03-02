<?php

use App\Http\Controllers\Front\FrontEndController;
use App\Http\Controllers\NewsLetterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontEndController::class, 'home'])->name('index');
Route::resource('newsletter', NewsLetterController::class);
Route::get('/404', [FrontEndController::class, 'four']);
Route::get('/mail', [FrontEndController::class, 'mail']);
Route::get('/apps', [FrontEndController::class, 'appLink']);
Route::get('/blogs', [FrontEndController::class, 'blogs']);
Route::get('/blog/{slug}', [FrontEndController::class, 'blogdetail']);
Route::post('/contact-form', [FrontEndController::class, 'contactStore']);
