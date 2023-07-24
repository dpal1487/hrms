<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Resources\Api\Categories;
use App\Http\Resources\Api\Items;
use App\Http\Resources\Api\States;
use App\Http\Resources\Api\Filters;
use App\Http\Controllers\Api\Controller;


class SearchController extends Controller
{
    public function index(Request $request){
        $keyword=$request->q;
    	$items = Item::whereIn('status_id',[1,4]);
        $items = new Item();
        if($keyword)
        {
        if($request->Categories){
            $items=$items->whereHas('categories', function($query) use ($keyword,$request) {
                if($request->Categories){
                    $query->whereIn('name',explode(',',$request->Categories));
                }
            });
        }
        if($request->States){
            $items=$items->whereHas('location', function($query) use ($keyword,$request) {
                if($request->States){
                    $query->whereIn('state',explode(',',$request->States));
                }
        });
        }
        if($request->sortBy){
            if($request->sortBy=='price_desc'){
                $items=$items->orderBy('price','desc');
            }
            if($request->sortBy=='price_asc'){
                $items=$items->orderBy('price','asc');
            }
            if($request->sortBy=='price_asc'){
                $items=$items->orderBy('id','desc');
            }
        }
        $items=$items->paginate(1)->setPath('/search')->appends($request->all());
        $sortOptions=array(
            'displayName'=>'Ratings',
            array(
            'label'=>'Popularity',
            'value'=>'popularity',
            'selected'=>$request->sortBy=='popularity',
            ),
            array(
                'label'=>'Price -- Low to High',
                'value'=>'price_asc',
                'selected'=>$request->sortBy=='price_asc',
            ),
            array(
                'label'=>'Price -- High to Low',
                'value'=>'price_desc',
                'selected'=>$request->sortBy=='price_desc',
            ),
            array(
                'label'=>'Newest First',
                'value'=>'recently_desc',
                'selected'=>$request->sortBy=='recently_desc',
            ),
        );
        if(count($items)>0){
            Items::collection($items);
            return [
                'data'=>$items,
                'pagination'=>$items,
                'filters'=>[
                    'filterCategories'=>Categories::collection(Category::where(['parent_id'=>null])->get()),
                    'filters'=>Filters::collection(Attribute::where(['parent_id'=>null])->get())->merge([$this->states()]),
                ],
                'sortOptions'=>$sortOptions,
            ];
        }
    }
        else{
            return response()->json(['data'=>null]);
        }
    }
    public function states(){
        return [
            'displayName'=>'States',
            'values'=>States::collection(State::orderBy('name','asc')->where(['country_id'=>101])->get())
        ];
    }
    public function searchSuggestion(Request $request)
    {
        $data=array();
    	$keyword = $request->keyword;
    	$results = Categories::select('name')->where('name', 'LIKE', "%{$keyword}%")->take(10)->get();
        $this->data['query'] = $keyword;
        foreach($results as $result)
        {
            $name = strtolower($result->name);
            $data[] = array('title'=>$name);
        }
    	return response()->json(['data'=>$data]);
    }
}
