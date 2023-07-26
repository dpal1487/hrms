<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;


use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use App\Models\Country;
use App\Http\Resources\Api\CitiesResource;
use App\Http\Resources\Api\CodesResource;
use App\Http\Resources\Api\StateResource;

class LocationController extends Controller
{
    public function codes()
    {
        return CodesResource::collection(Country::all());
    }
    public function countries()
    {
        return Country::orderBy('name', 'asc')->get();
    }
    public function states()
    {
        return StateResource::collection(State::where('country_id', 101)->orderBy('name')->get());
    }
    public function cities(Request $request)
    {
        if (isset($request->parent)) {
            $states = State::where('name', $request->parent)->with('cities')->first();
        }
        return "satate not found";
        // return CitiesResource::collection($states);
    }
}
