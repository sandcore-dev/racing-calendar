<?php

use App\Http\Controllers\Admin\Season\ImageController;
use App\Http\Controllers\Api\LocationsController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::patch('season/{season}/image', [ImageController::class, 'update'])
            ->name('season.update');
    });

Route::middleware('auth:api')
    ->group(function () {
        Route::prefix('locations')
            ->group(function () {
                Route::post('season/{season}', [LocationsController::class, 'getBySeason']);
                Route::post('search', [LocationsController::class, 'search']);
            });
    });
