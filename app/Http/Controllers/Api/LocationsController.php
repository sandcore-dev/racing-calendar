<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Season;
use App\Location;

class LocationsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function getBySeason(Season $season)
    {
        return $season->locations()->paginate();
    }
    
    public function search(Request $request)
    {
        $search = $this->buildQuery($request);
        
        return $search->paginate();
    }
    
    protected function buildQuery(Request $request)
    {
        $excludeSeason = $request->input('exclude_season');
        
        $keywords = preg_split('/\s+/', $request->input('keywords'), null, PREG_SPLIT_NO_EMPTY);
        
        $location = new Location();
        
        $query = $location->newQuery();
        
        $query->whereDoesntHave('seasons', function (Builder $query) use ($excludeSeason) {
            $query->where('seasons.id', $excludeSeason);
        });
        
        $query->where(function (Builder $query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $query->orWhere(function (Builder $query) use ($keyword) {
                    $query->orWhere('name', 'like', '%' . $keyword . '%');
                });
            }
        });
        
        return $query;
    }
}
