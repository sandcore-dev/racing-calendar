<?php

namespace App\Http\Controllers\Api;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Season;
use App\Models\Location;

class LocationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getBySeason(Season $season): LengthAwarePaginator
    {
        return $season->locations()->paginate();
    }

    public function search(Request $request): LengthAwarePaginator
    {
        $request->validate(
            [
                'exclude_season' => ['nullable', 'numeric', 'exists:seasons,id'],
                'keywords' => ['required', 'string', 'min:3'],
            ]
        );

        $excludeSeason = $request->input('exclude_season');
        $keywords = preg_split('/\s+/', $request->input('keywords'), null, PREG_SPLIT_NO_EMPTY);

        return Location::query()
            ->select(['id', 'name'])
            ->whereDoesntHave('seasons', function (Builder $query) use ($excludeSeason) {
                $query->where('seasons.id', '=', $excludeSeason);
            })
            ->where(function (Builder $query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->orWhere(function (Builder $query) use ($keyword) {
                        $query->orWhere('name', 'like', '%' . $keyword . '%');
                    });
                }
            })
            ->paginate();
    }
}
