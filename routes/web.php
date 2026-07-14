<?php

declare(strict_types=1);

use App\Http\Controllers\FormSubmissionController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SiteMetaController;
use App\Models\Site;
use Illuminate\Support\Facades\Route;

Route::post('/forms/{key}', FormSubmissionController::class)
    ->where('key', '[a-z0-9-]+')
    ->name('forms.submit');

Route::get('/robots.txt', fn () => app(SiteMetaController::class)->robots(app(Site::class)));
Route::get('/sitemap.xml', fn () => app(SiteMetaController::class)->sitemap(app(Site::class)));

// Lowest priority: every other GET resolves to a page template of the current site.
Route::get('/{path?}', PageController::class)->where('path', '.*');
