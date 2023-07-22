<?php


namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use App\Models\Country;
use App\Http\Resources\Api\States;
use App\Http\Resources\Api\Cities;
use App\Http\Resources\Api\Codes;
class LocationController extends Controller
{
    public function codes(){
      return Codes::collection(Country::all());
    }
    public function countries(){
        return Country::orderBy('name','asc')->get();
    }
    public function states(){
        return States::collection(State::where('country_id',101)->orderBy('name')->get());
    }
    public function cities(Request $request){
        if(isset($request->parent)){
            $states = State::where('name',$request->parent)->with('cities')->first();
        }
        return Cities::collection($states->cities);
    }
}
