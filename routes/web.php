<?php

declare(strict_types=1);

use App\Http\Controllers\CmsController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::group(['prefix' => LaravelLocalization::setLocale()], function (): void {

    Route::get('/', [CmsController::class, 'home'])->name('cms.home');

    Route::get('/sitemap.xml', SitemapController::class);

    Route::fallback([CmsController::class, 'content'])->name('cms.content');
});
