<?php

namespace App\Http\Middleware;

use App\Models\Championship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param Request $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param Request $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'title' => config('app.name'),

            'navBarUrl' => URL::to('/'),

            'sessionAction' => fn() => Auth::check()
                ? ['url' => route('logout'), 'label' => Lang::get('Logout')]
                : ['url' => route('login'), 'label' => Lang::get('Login')],

            'adminItems' => function () {
                if (!Auth::check()) {
                    return [];
                }

                return array_map(
                    function (array $item) {
                        return [
                            'url' => route($item['url']),
                            'active' => Route::currentRouteNamed($item['active']),
                            'label' => Lang::get($item['label']),
                        ];
                    },
                    [
                        [
                            'url' => 'admin.championship.index',
                            'active' => 'admin.championship.*',
                            'label' => 'Championship',
                        ],
                        [
                            'url' => 'admin.circuit.index',
                            'active' => 'admin.circuit.*',
                            'label' => 'Circuit',
                        ],
                        [
                            'url' => 'admin.country.index',
                            'active' => 'admin.country.*',
                            'label' => 'Country',
                        ],
                        [
                            'url' => 'admin.location.index',
                            'active' => 'admin.location.*',
                            'label' => 'Location',
                        ],
                        [
                            'url' => 'admin.template.index',
                            'active' => 'admin.template.*',
                            'label' => 'Template',
                        ],
                    ]
                );
            },

            'dropdownTitle' => fn() => Auth::check()
                ? Auth::user()->name
                : Lang::get('Racing series'),

            'dropdownItems' => function () {
                return Championship::others()->get()
                    ->map(function (Championship $championship) {
                        return [
                            'id' => $championship->id,
                            'url' => $championship->url,
                            'label' => $championship->name,
                        ];
                    });
            },
        ]);
    }
}
