<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth;
use App\Http\Controllers\CalendarController;
use Illuminate\Support\Facades\Route;

Route::get('login', [Auth\LoginController::class, 'showLoginForm'])
    ->name('login');

Route::post('login', [Auth\LoginController::class, 'login'])
    ->name('login.submit');

Route::get('logout', [Auth\LoginController::class, 'logout'])
    ->name('logout');

Route::prefix('admin')
    ->as('admin.')
    ->middleware('auth')
    ->group(function () {
        Route::resource('championship', Admin\ChampionshipController::class)
            ->except(['show', 'destroy']);

        Route::prefix('championship/{championship}')
            ->group(function () {
                Route::resource('season', Admin\SeasonController::class)
                    ->only(['index', 'create', 'store', 'edit', 'update']);

                Route::prefix('season/{season:id}')
                    ->group(function () {
                        Route::resource('image', Admin\Season\ImageController::class)
                            ->only(['index']);

                        Route::resource('race', Admin\RaceController::class);

                        Route::post('copy-season', [Admin\RaceController::class, 'copySeason'])
                            ->name('race.copy-season');

                        Route::prefix('race/{race:id}')
                            ->as('race.')
                            ->group(function () {
                                Route::resource('session', Admin\RaceSessionController::class);

                                Route::post(
                                    'session/apply-template',
                                    [Admin\RaceSessionController::class, 'applyTemplate']
                                )
                                    ->name('session.apply-template');
                            });
                    });
            });

        Route::resource('circuit', Admin\CircuitController::class);
        Route::resource('country', Admin\CountryController::class);
        Route::resource('location', Admin\LocationController::class);
        Route::resource('template', Admin\TemplateController::class);
        Route::resource('template.session', Admin\TemplateSessionController::class);
    });

Route::domain('{championship:domain}')
    ->where(['championship' => '[a-z0-9.-]+'])
    ->group(function () {
        Route::get('/', [CalendarController::class, 'index'])
            ->name('index');

        Route::prefix('{season:access_token}')
            ->group(function () {
                Route::get('/', [CalendarController::class, 'calendar'])
                    ->name('calendar');

                Route::prefix('{race:id}')
                    ->group(function () {
                        Route::get('location', [CalendarController::class, 'editLocation'])
                            ->name('calendar.location.edit');

                        Route::put('location', [CalendarController::class, 'updateLocation'])
                            ->name('calendar.location.update');
                    });
            });
    });
