<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CmsController;
use App\Http\Controllers\LanguageSwitcher;

Route::post('/language', LanguageSwitcher::class)->name('language.switch');

Route::get('/', function () {
    return view('welcome');
});

Route::fallback(CmsController::class)->name('cms.cms_model');
