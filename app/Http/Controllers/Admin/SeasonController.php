<?php

namespace App\Http\Controllers\Admin;

use App\Models\Championship;
use Illuminate\Contracts\Support\Renderable;
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

    public function create(Championship $championship): Renderable
    {
        return view('admin.season.create')
            ->with('championship', $championship);
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
                __('The season :season has been added.', [
                    'season' => $season->year,
                ])
            );
    }

    public function edit(Championship $championship, Season $season): Renderable
    {
        return view('admin.season.edit')
            ->with(
                [
                    'championship' => $championship,
                    'season' => $season,
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
                'regenerate_token' => ['required', 'boolean'],
                'locations.*' => ['integer', 'exists:locations,id'],
            ]
        );

        $data = $request->only('year');

        if ($request->input('regenerate_token')) {
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
            ->with('success', __('The season :season has been edited.', ['season' => $season->year]));
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
