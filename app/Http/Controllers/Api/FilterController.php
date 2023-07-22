<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;
use App\Models\Brand;
use App\Models\State;
use App\Models\Attribute;
use App\Http\Resources\Attributes;

class FilterController extends Controller
{
    public $data;
	public function index(Request $request)
    {
        $data =$this->leftNavGroup($request);
        return response()->json(['data'=>$data,'success'=>true]);
    }
    public function leftNavGroup(Request $request)
    {   
        $minPrice = Item::where('name', 'like', '%' . $request->q . '%')->min('rent_price');
        $maxPrice = Item::where('name', 'like', '%' . $request->q . '%')->max('rent_price');
        $data[] = array('displayName'=>'Categories','displayType'=>'checkbox','displayValues'=>$this->getCategories($request),'filterName'=>'Categories','name'=>'Categories');
        //$data[] = array('displayName'=>'Price','displayType'=>'rangeSlider','displayValues'=>[],'filterName'=>'Price','name'=>'Price','rangeEnd'=>$maxPrice,'rangeEndSelected'=>26299,'rangeStart'=>$minPrice,'rangeStartSelected'=>111);        
        $data[] = array('displayName'=>'States','displayType'=>'checkbox','displayValues'=>$this->getStates($request),'filterName'=>'States','name'=>'States'); 
        if(count($this->getBrands($request))>0){
            $data[] = array('displayName'=>'Brands','displayType'=>'checkbox','displayValues'=>$this->getBrands($request),'filterName'=>'Brands','name'=>'Brands');
        }
        //$data = $this->getAttributes($request);
        return $data;
    }
    public function getCategories($request)
    {
        $values = Category::with(['image','childrens.image'])->orderBy('name','asc')->get();
        $data = array();
        foreach($values as $value)
        {
            $data[]=array('applicable'=>true,'displayValue'=>$value->name,'popularity'=>0,'selected'=>in_array($value->name,explode(',', $request->input('categories'))) ? true : false,'value'=>$value->name);
        }
        return $data;
    }
    // public function getAttributes($request){
    //     $attributes = Attribute::with('values')->get();
    //     $data = array();
    //     foreach($attributes as $attribute){
    //         foreach($attribute->values as $value)
    //         {
    //             $data[]=array('applicable'=>true,'displayValue'=>$value->name,'popularity'=>0,'selected'=>in_array($value->name,explode(',', $request->input('attribute'))) ? true : false,'value'=>$value->name);
    //         }
    //         $data[]=array('displayName'=>'Categories','displayType'=>'checkbox','displayValues'=>$data,'filterName'=>'Categories','name'=>'Categories');
    //     }
    //     return $data;
    // }
    public function getBrands(Request $request)
    {
        $values =new Brand();
        if($request->Categories)
        {
            $categories = Category::whereIn('name',explode(',', $request->Categories))->first();
            $values = $values->where('category_id',$categories)->orderBy('name','asc')->get();
            $data = array();
            if($values)
            {
                foreach($values as $value)
                {
                    $data[]=array('applicable'=>true,'displayValue'=>$value->name,'popularity'=>0,'selected'=>in_array($value->name,explode(',', $request->Brands)) ? true : false,'value'=>$value->name);
                }   
            }
            return $data;
        }
        else{
            $data = array();
            if($values->get())
            {
                foreach($values->orderBy('name','asc')->get() as $value)
                {
                    $data[]=array('applicable'=>true,'displayValue'=>$value->name,'popularity'=>0,'selected'=>in_array($value->name,explode(',', $request->Brands)) ? true : false,'value'=>$value->name);
                }   
            }
            return $data;
        }
    }
    public function getStates($request)
    {
        $values = State::where(['country_id'=>101])->get();
        $data = array();
        foreach($values as $value)
        {
            $data[]=array('applicable'=>true,'displayValue'=>$value->name,'popularity'=>0,'selected'=>in_array($value->name,explode(',', $request->States)) ? true : false,'value'=>$value->name);
        }
        return $data;
    }
}
