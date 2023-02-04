<?php

namespace App\Http\Controllers\Admin;

use App\Models\Championship;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Season;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class SeasonController extends Controller
{
    protected array $acceptedMimeTypes = [
        'image/jpg',
        'image/jpeg',
        'image/png',
    ];

    public function index(Championship $championship): Response
    {
        return Inertia::render(
            'Admin/Season/Index',
            [
                'title' => Lang::get('Admin')
                    . ': ' . $championship->name
                    . ' - ' . Lang::get('Seasons'),

                'labels' => [
                    'title' => $championship->name,
                    'year' => Lang::get('Year'),
                    'back' => Lang::get('Back to championship index'),
                ],

                'adminAddUrl' => route('admin.season.create', ['championship' => $championship]),

                'adminBackUrl' => route('admin.championship.index'),

                'seasons' => $championship->seasons()
                    ->with(['championship:id,name'])
                    ->select(['id', 'year', 'championship_id'])
                    ->paginate(),
            ]
        );
    }

    public function create(Championship $championship): Response
    {
        return Inertia::render(
            'Admin/Season/Form',
            [
                'title' => Lang::get('Admin')
                    . ': ' . $championship->name
                    . ' - ' . Lang::get('Add season'),

                'header' => Lang::get('Add season for :name', ['name' => $championship->name]),

                'url' => route('admin.season.store', ['championship' => $championship]),

                'labels' => [
                    'year' => Lang::get('Year'),
                    'headerImage' => Lang::get('Header image'),
                    'footerImage' => Lang::get('Footer image'),
                    'noFileChosen' => Lang::get('No file chosen'),
                    'browse' => Lang::get('Browse'),
                    'submit' => Lang::get('Add'),
                ],

                'acceptedMimeTypes' => implode(',', $this->acceptedMimeTypes),
            ]
        );
    }

    public function store(Request $request, Championship $championship): RedirectResponse
    {
        $request->validate(
            [
                'year' => [
                    'required',
                    'integer',
                    'between:1970,9999',
                    Rule::unique('seasons', 'year')
                        ->where('championship_id', $championship->id),
                ],
                'header_image' => ['nullable', 'image'],
                'footer_image' => ['nullable', 'image'],
            ]
        );

        $data = $request->only('year');

        foreach (['header_image', 'footer_image'] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('public/images');
            }
        }

        /** @var Season $season */
        $season = $championship->seasons()->create($data);

        return redirect()
            ->route('admin.season.index', ['championship' => $championship])
            ->with(
                'success',
                Lang::get('The season :season has been added.', [
                    'season' => $season->year,
                ])
            );
    }

    public function edit(Championship $championship, Season $season): Response
    {
        return Inertia::render(
            'Admin/Season/Form',
            [
                'title' => Lang::get('Admin')
                    . ': ' . $championship->name
                    . ' - ' . Lang::get('Edit season'),

                'header' => Lang::get(
                    'Edit season :year for :name',
                    [
                        'name' => $championship->name,
                        'year' => $season->year,
                    ]
                ),

                'seasonId' => $season->id,

                'edit' => true,
                'url' => route('admin.season.update', ['championship' => $championship, 'season' => $season]),

                'labels' => [
                    'year' => Lang::get('Year'),
                    'headerImage' => Lang::get('Header image'),
                    'footerImage' => Lang::get('Footer image'),
                    'noFileChosen' => Lang::get('No file chosen'),
                    'browse' => Lang::get('Browse'),
                    'accessToken' => Lang::get('Toegangstoken'),
                    'regenerateToken' => Lang::get('Generate a new access token'),
                    'locations' => Lang::get('Locations'),
                    'searchForLocation' => Lang::get('Search for a location'),
                    'submit' => Lang::get('Change'),
                ],

                'acceptedMimeTypes' => implode(',', $this->acceptedMimeTypes),

                'images' => $season->only(
                    [
                        'header_url',
                        'footer_url',
                    ]
                ),

                'locations' => $season->locations->map(function (Location $location) {
                    return $location->only(
                        [
                            'id',
                            'name',
                        ]
                    );
                }),

                'data' => [
                    'year' => $season->year,
                    'access_token' => $season->access_token,
                    'regenerate_token' => null,
                    'locations' => $season->locations->pluck('id'),
                ],
            ]
        );
    }

    public function update(Request $request, Championship $championship, Season $season): RedirectResponse
    {
        $request->validate(
            [
                'year' => [
                    'required',
                    'integer',
                    'between:1970,9999',
                    Rule::unique('seasons', 'year')
                        ->where('championship_id', $championship->id)
                        ->ignoreModel($season),
                ],
                'header_image' => ['nullable', 'image'],
                'footer_image' => ['nullable', 'image'],
                'regenerate_token' => ['nullable', 'boolean'],
                'locations.*' => ['integer', 'exists:locations,id'],
            ]
        );

        $data = $request->only('year');

        if ($request->boolean('regenerate_token')) {
            $data['access_token'] = $this->generateAccessToken();
        }

        foreach (['header_image', 'footer_image'] as $field) {
            if ($request->file($field)) {
                if (($data[$field] = $request->file($field)->store('public/images')) && $season->{$field}) {
                    Storage::delete($season->{$field});
                }
            } elseif ($request->input('remove_' . $field) && $season->{$field}) {
                Storage::delete($season->{$field});
            }
        }

        $season->locations()->sync($request->input('locations'));

        $season->update($data);

        return redirect()
            ->route('admin.season.index', ['championship' => $championship])
            ->with('success', Lang::get('The season :season has been edited.', ['season' => $season->year]));
    }

    protected function generateAccessToken(): string
    {
        $existingAccessTokens = Season::pluck('access_token');

        do {
            $accessToken = Str::random(10);
        } while ($existingAccessTokens->contains($accessToken));

        return $accessToken;
    }
}
