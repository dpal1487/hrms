<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Http\Resources\SubscriptionsResource;
use DB;

class SubscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $subscriptions = new Subscription();
        if ($request->q) {
            $subscriptions = $subscriptions->where('name', 'like', "%{$request->q}%");
        }
        $subscriptions = $subscriptions
            ->paginate(10)
            ->onEachSide(1)
            ->appends(request()->query());
        // $data = User::latest()->paginate(10);
        $subscriptions = SubscriptionsResource::collection($subscriptions);

        // return $subscriptions;

        return view('pages.subscriptions.index', ['result' => $subscriptions]);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
