<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CmsController;
use App\Http\Controllers\LanguageSwitcher;

Route::post('/language', LanguageSwitcher::class)->name('language.switch');

Route::get('/', [CmsController::class,'home'])->name('cms.home');

Route::fallback([CmsController::class,'content'])->name('cms.content');
