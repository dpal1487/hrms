<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewResource;
use App\Models\Item;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ItemReviewsResource;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function reviews($id)
     {
         $title = "Item Reviews";
         $item = Item::where(['id' => $id])->first();

        //  return new ItemReviewsResource($item);

         return view('pages.item.reviews' , ['title' => $title ,'itemreview' =>new ItemReviewsResource($item)]);
     }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
    }
}
