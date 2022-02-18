<?php

use App\Http\Controllers\Api\LocationsController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')
    ->group(function () {
        Route::prefix('locations')
            ->group(function () {
                Route::post('season/{season}', [LocationsController::class, 'getBySeason']);
                Route::post('search', [LocationsController::class, 'search']);
            });
    });
