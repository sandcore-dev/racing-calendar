<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use Countries;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;
use Monarobase\CountryList\CountryNotFoundException;

class CountryController extends Controller
{
    public function index(): Response
    {
        return Inertia::render(
            'Admin/Country/Index',
            [
                'title' => Lang::get('Admin')
                    . ' - ' . Lang::get('Countries'),

                'labels' => [
                    'title' => Lang::get('Countries'),
                    'country' => Lang::get('Country'),
                    'code' => Lang::get('Code'),
                ],

                'adminAddUrl' => route('admin.country.create'),

                'countries' => Country::paginate(),
            ]
        );
    }

    public function create(): Response
    {
        return Inertia::render(
            'Admin/Country/Create',
            [
                'title' => Lang::get('Admin')
                    . ' - ' . Lang::get('Add country'),

                'header' => Lang::get('Add country'),

                'url' => route('admin.country.store'),

                'labels' => [
                    'code' => Lang::get('Code'),
                    'submit' => Lang::get('Add'),
                ],

                'codes' => (new Collection(Countries::getList(config('app.locale'))))
                    ->map(function (string $name, string $id) {
                        return [
                            'id' => $id,
                            'name' => $name,
                        ];
                    })
                    ->values(),
            ]
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'code' => ['required', 'size:2', 'unique:countries'],
            ]
        );

        $country = Country::create(
            [
                'code' => $request->input('code'),
                'name' => Countries::getOne($request->input('code'), config('app.locale')),
            ]
        );

        return Redirect::route('admin.country.index')
            ->with('success', __('The country :name has been added.', ['name' => $country->name]));
    }

    public function edit(Country $country): Response
    {
        return Inertia::render(
            'Admin/Country/Edit',
            [
                'title' => Lang::get('Admin')
                    . ' - ' . Lang::get('Edit country :country', ['country' => $country->name]),

                'header' => Lang::get('Edit country :country', ['country' => $country->name]),

                'edit' => true,
                'url' => route('admin.country.update', ['country' => $country]),

                'labels' => [
                    'name' => Lang::get('Name'),
                    'code' => Lang::get('Code'),
                    'submit' => Lang::get('Edit'),
                ],

                'data' => $country->only(
                    [
                        'name',
                        'code',
                    ]
                ),
            ]
        );
    }

    public function update(Request $request, Country $country): RedirectResponse
    {
        $request->validate(
            [
                'name' => ['required', 'min:2', 'unique:countries,name,' . $country->id],
                'code' => ['required', 'size:2', 'unique:countries,code,' . $country->id],
            ]
        );

        $country->update($request->only('name', 'code'));

        return Redirect::route('admin.country.index')
            ->with('success', __('The country :name has been updated.', ['name' => $country->name]));
    }
}
