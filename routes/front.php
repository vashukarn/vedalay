<?php

use App\Http\Controllers\Front\FrontEndController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontEndController::class, 'home'])->name('index');
Route::get('/mail', [FrontEndController::class, 'mail']);
Route::get('/apps', [FrontEndController::class, 'appLink']);
Route::get('/features/{slug}', [FrontEndController::class, 'featureDetail']);

Route::get('/register', [FrontEndController::class, 'register']);
Route::get('/blogs', [FrontEndController::class, 'blogs']);
Route::get('/blog/{slug}', [FrontEndController::class, 'blogdetail']);
Route::post('/contact-form', [FrontEndController::class, 'contactStore']);

Route::post('/registeruser', [FrontEndController::class, 'registeruser'])->name('registeruser');
// Route::get('/{page}', [FrontEndController::class, 'page'])->name('page');
