<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Circuit;
use App\Models\Country;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class CircuitController extends Controller
{
    public function index(): Response
    {
        return Inertia::render(
            'Admin/Circuit/Index',
            [
                'title' => Lang::get('Admin')
                    . ' - ' . Lang::get('Circuits'),

                'labels' => [
                    'title' => Lang::get('Circuits'),
                    'back' => Lang::get('Back to season index'),
                    'circuit' => Lang::get('Circuit'),
                    'city' => Lang::get('City'),
                    'area' => Lang::get('Area'),
                    'country' => Lang::get('Country'),
                ],

                'adminAddUrl' => route('admin.circuit.create'),

                'circuits' => Circuit::query()
                    ->with(
                        [
                            'country' => function (BelongsTo $query) {
                                return $query
                                    ->select(
                                        [
                                            'id',
                                            'code',
                                            'name',
                                        ]
                                    );
                            },
                        ]
                    )
                    ->paginate(),
            ]
        );
    }

    public function create(): Response
    {
        return Inertia::render(
            'Admin/Circuit/Form',
            [
                'title' => Lang::get('Admin')
                    . ' - ' . Lang::get('Add circuit'),

                'header' => Lang::get('Add circuit'),

                'url' => route('admin.circuit.store'),

                'labels' => [
                    'name' => Lang::get('Name'),
                    'city' => Lang::get('City'),
                    'area' => Lang::get('Area'),
                    'country' => Lang::get('Country'),
                    'submit' => Lang::get('Add'),
                ],

                'countries' => Country::select(['id', 'name'])->get(),
            ]
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'name' => ['required', 'min:2', 'unique:circuits'],
                'city' => ['required', 'min:2'],
                'area' => ['nullable', 'min:2'],
                'country_id' => ['required', 'integer', 'exists:countries,id'],
            ]
        );

        $circuit = Circuit::create($request->only('name', 'city', 'area', 'country_id'));

        return Redirect::route('admin.circuit.index')
            ->with('success', __('The circuit :name has been added.', ['name' => $circuit->name]));
    }

    public function edit(Circuit $circuit): Response
    {
        return Inertia::render(
            'Admin/Circuit/Form',
            [
                'title' => Lang::get('Admin')
                    . ' - ' . Lang::get('Edit circuit :name', ['name' => $circuit->name]),

                'header' => Lang::get('Edit circuit :name', ['name' => $circuit->name]),

                'edit' => true,
                'url' => route('admin.circuit.update', ['circuit' => $circuit]),

                'labels' => [
                    'name' => Lang::get('Name'),
                    'city' => Lang::get('City'),
                    'area' => Lang::get('Area'),
                    'country' => Lang::get('Country'),
                    'submit' => Lang::get('Edit'),
                ],

                'countries' => Country::select(['id', 'name'])->get(),

                'data' => $circuit->only(
                    [
                        'name',
                        'city',
                        'area',
                        'country_id',
                    ]
                ),
            ]
        );
    }

    public function update(Request $request, Circuit $circuit): RedirectResponse
    {
        $request->validate(
            [
                'name' => ['required', 'min:2', 'unique:circuits,name,' . $circuit->id],
                'city' => ['required', 'min:2'],
                'area' => ['nullable', 'min:2'],
                'country_id' => ['required', 'integer', 'exists:countries,id'],
            ]
        );

        $circuit->update($request->only('name', 'city', 'area', 'country_id'));

        return Redirect::route('admin.circuit.index')
            ->with('success', __('The circuit :name has been changed.', ['name' => $circuit->name]));
    }
}
