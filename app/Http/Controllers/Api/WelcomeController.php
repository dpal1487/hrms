<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Models\Category;
use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\BannerResource;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\ItemResource;
use App\Models\Banner;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $banners = Banner::where('status', '1')->with('image')->get();
        $categories = Category::orderBy('name')->where(['parent_id' => null])->get();
        return [
            'banners' => BannerResource::collection($banners),
            'categories' => CategoryResource::collection($categories),
            'itemsByList' => [
                [
                    'title' => 'New Arrives',
                    'slug' => '/new-arrives',
                    'data' => $this->newItems($request)
                ],
                [
                    'title' => 'Featured Items',
                    'slug' => '/feature-ads',
                    'data' => $this->featureItems($request)
                ]
            ]
        ];
    }
    public function banners()
    {
        $banners = Banner::where('status', '1')->with('image')->get();
        return BannerResource::collection($banners);
    }
    public function cameras()
    {
        return ItemResource::collection(Item::take(12)->where(['is_deleted' => 0])->WhereIn('status_id', [4])->get());
    }
    public function newItems()
    {
        return ItemResource::collection(Item::take(12)->where(['is_deleted' => 0])->orderBy('created_at', 'desc')->get());
    }
    public function featureItems()
    {
        return ItemResource::collection(Item::take(12)->where(['is_deleted' => 0])->orderBy('created_at', 'desc')->get());
    }
}
