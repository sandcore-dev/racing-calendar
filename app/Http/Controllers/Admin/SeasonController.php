<?php

namespace App\Http\Controllers\Admin;

use App\Championship;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Season;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SeasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Championship $championship
     * @return Renderable
     */
    public function index(Championship $championship)
    {
        return view('admin.season.index')->with([
            'championship' => $championship,
            'seasons' => $championship->seasons()->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Championship $championship
     * @return Renderable
     */
    public function create(Championship $championship)
    {
        return view('admin.season.create')
            ->with('championship', $championship);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Championship $championship
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Championship $championship)
    {
        $request->validate([
            'year' => [
                'required',
                'integer',
                'between:1970,9999',
                Rule::unique('seasons', 'year')
                    ->where('championship_id', $championship->id),
            ],
            'header_image' => ['nullable', 'image'],
            'footer_image' => ['nullable', 'image'],
        ]);

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
            ->with('success', __('The season :season has been added.', [
                'season' => $season->year,
            ]));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Season $season
     */
    public function show(Season $season)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Championship $championship
     * @param \App\Season $season
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Championship $championship, Season $season)
    {
        return view('admin.season.edit')
            ->with([
                'championship' => $championship,
                'season' => $season,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Championship $championship
     * @param \App\Season $season
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Championship $championship, Season $season)
    {
        $request->validate([
            'year' => [
                'required',
                'integer',
                'between:1970,9999',
                Rule::unique('seasons', 'year')
                    ->where('championship_id', $championship->id)
                    ->ignoreModel($season)
            ],
            'header_image' => ['nullable', 'image'],
            'footer_image' => ['nullable', 'image'],
            'regenerate_token' => ['required', 'boolean'],
            'locations.*' => ['integer', 'exists:locations,id'],
        ]);

        $data = $request->only('year');

        if ($request->input('regenerate_token')) {
            $data['access_token'] = $this->generateAccessToken();
        }

        foreach (['header_image', 'footer_image'] as $field) {
            if ($request->file($field)) {
                if ($data[$field] = $request->file($field)->store('public/images')) {
                    Storage::delete($season->{$field});
                }
            } elseif ($request->input('remove_' . $field)) {
                Storage::delete($season->{$field});
            }
        }

        $season->locations()->sync($request->input('locations'));

        $season->update($data);

        return redirect()
            ->route('admin.season.index', ['championship' => $championship])
            ->with('success', __('The season :season has been edited.', ['season' => $season->year]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Season $season
     */
    public function destroy(Season $season)
    {
        //
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
