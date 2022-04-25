<?php

namespace App\Http\Controllers\Admin;

use App\Models\Championship;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class ChampionshipController extends Controller
{
    public function index(): Response
    {
        return Inertia::render(
            'Admin/Championship/Index',
            [
                'title' => Lang::get('Admin') . ': ' . Lang::get('Championship'),

                'adminAddUrl' => route('admin.championship.create'),

                'championships' => Championship::select(['id', 'name'])
                    ->orderBy('name')
                    ->paginate(),
            ]
        );
    }

    public function create(): Response
    {
        return Inertia::render(
            'Admin/Championship/Form',
            [
                'title' => Lang::get('Admin')
                    . ': ' . Lang::get('Add championship'),

                'header' => Lang::get('Add championship'),

                'url' => route('admin.championship.store'),

                'labels' => [
                    'name' => Lang::get('Name'),
                    'domain' => Lang::get('Domain'),
                    'submit' => Lang::get('Add'),
                ],
            ]
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'unique:championships,name'],
                'domain' => ['required', 'string', 'unique:championships,domain'],
            ]
        );

        $championship = Championship::create($request->only('name', 'domain'));

        return redirect()
            ->route("admin.championship.index")
            ->with('success', Lang::get('The championship :name has been added.', ['name' => $championship->name]));
    }

    public function edit(Championship $championship): Response
    {
        return Inertia::render(
            'Admin/Championship/Form',
            [
                'title' => Lang::get('Admin')
                    . ': ' . Lang::get('Edit championship'),

                'header' => Lang::get('Edit championship'),

                'url' => route('admin.championship.update', ['championship' => $championship]),

                'edit' => true,

                'data' => $championship->only(['name', 'domain']),

                'labels' => [
                    'name' => Lang::get('Name'),
                    'domain' => Lang::get('Domain'),
                    'submit' => Lang::get('Change'),
                ],
            ]
        );
    }

    public function update(Request $request, Championship $championship): RedirectResponse
    {
        $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    Rule::unique('championships', 'name')
                        ->ignoreModel($championship),
                ],
                'domain' => [
                    'required',
                    'string',
                    Rule::unique('championships', 'domain')
                        ->ignoreModel($championship),
                ],
            ]
        );

        $championship->update($request->only('name', 'domain'));

        return redirect()
            ->route("admin.championship.index")
            ->with('success', Lang::get('The championship :name has been edited.', ['name' => $championship->name]));
    }
}
