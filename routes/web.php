<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CmsController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    
    Route::get('/', [CmsController::class, 'home'])->name('cms.home');

    Route::fallback([CmsController::class, 'content'])->name('cms.content');
});
