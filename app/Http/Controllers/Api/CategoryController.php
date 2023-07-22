<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(Request $request){
        $categories=new Category();
        if(!empty($request->parent)){
           $categories = $categories->where('parent_id',$request->parent);
        }
        elseif($request->parent==null){
           $categories = $categories->where('parent_id',null);
        }
        return CategoryResource::collection($categories->get());
    }
}
