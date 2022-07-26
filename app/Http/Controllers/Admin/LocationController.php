<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class LocationController extends Controller
{
    public function index(): Response
    {
        return Inertia::render(
            'Admin/Location/Index',
            [
                'title' => Lang::get('Admin')
                    . ' - ' . Lang::get('Locations'),

                'labels' => [
                    'title' => Lang::get('Locations'),
                    'location' => Lang::get('Location'),
                ],

                'adminAddUrl' => route('admin.location.create'),

                'locations' => Location::paginate(),
            ]
        );
    }

    public function create(): Response
    {
        return Inertia::render(
            'Admin/Location/Form',
            [
                'title' => Lang::get('Admin')
                    . ' - ' . Lang::get('Add location'),

                'header' => Lang::get('Add location'),

                'url' => route('admin.location.store'),

                'labels' => [
                    'name' => Lang::get('Name'),
                    'submit' => Lang::get('Add'),
                ],
            ]
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'name' => ['required', 'min:2', 'unique:locations'],
            ]
        );

        $location = Location::create($request->only('name'));

        return Redirect::route('admin.location.index')
            ->with('success', __('The location :name has been added.', ['name' => $location->name]));
    }

    public function edit(Location $location): Response
    {
        return Inertia::render(
            'Admin/Location/Form',
            [
                'title' => Lang::get('Admin')
                    . ' - ' . Lang::get('Edit location :location', ['location' => $location->name]),

                'header' => Lang::get('Edit location :location', ['location' => $location->name]),

                'edit' => true,
                'url' => route('admin.location.update', ['location' => $location]),

                'labels' => [
                    'name' => Lang::get('Name'),
                    'submit' => Lang::get('Edit'),
                ],

                'data' => $location->only(['name']),
            ]
        );
    }

    public function update(Request $request, Location $location): RedirectResponse
    {
        $request->validate(
            [
                'name' => ['required', 'min:2', 'unique:locations,name,' . $location->id],
            ]
        );

        $location->update($request->only(['name', 'code']));

        return Redirect::route('admin.location.index')
            ->with('success', __('The location :name has been updated.', ['name' => $location->name]));
    }
}
