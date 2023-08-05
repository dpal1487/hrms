<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;


use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Country;
use App\Http\Resources\Api\CitiesResource;
use App\Http\Resources\Api\CountryCodesResource;
use App\Http\Resources\Api\StatesResource;

class LocationController extends Controller
{
    public function codes(){
      return CountryCodesResource::collection(Country::all());
    }
    public function countries(){
        return Country::orderBy('name','asc')->get();
    }
    public function states(){
        return StatesResource::collection(State::where('country_id',101)->orderBy('name')->get());
    }
    public function cities(Request $request){
        if(isset($request->parent)){
            $states = State::where('id',$request->parent)->with('cities')->first();
        }
        return CitiesResource::collection($states->cities);
    }
}
