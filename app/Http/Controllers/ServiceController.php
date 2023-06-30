<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceListResource;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Support\Str;
use League\OAuth1\Client\Server\Server;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services = new Service();
        if (!empty($request->q)) {
            $services = $services
                ->where('name', 'like', "%$request->q")
                ->orWhere('page', 'like', "%$request->q%")
                ->orWhere('description', 'like', "%$request->q%");
        }
        if ($request->expectsJson()) {
            if ($services) {
                return ServiceListResource::collection($services->paginate(10));
            } else {
                return response()->json(['data' => [], 'success' => true]);
            }
        }
        return Inertia::render('Service/Index', [
            'services' => ServiceResource::collection($services->paginate(10)->appends($request->all())),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Service/Form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image_id' => 'required',
            'page' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['message' => $validator->errors()->first(), 'success' => false]);
        }
        $service = Service::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image_id' => $request->image_id,
            'page' => $request->page,
            'description' => $request->description,
        ]);
        if ($service) {
            return redirect('service')->with('flash', [
                'success' => true,
                'message' => 'Service create successfully',
            ]);
        }
        return redirect('service')->with('flash', [
            'success' => true,
            'message' => 'Service not updated',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $service = Service::find($id);

        if ($request->expectsJson()) {
            
            $service = Service::where('slug', $request->slug)->first();

            if ($service) {
                return response()->json(['data' => new ServiceResource($service), 'success' => true]);
            } else {
                return response()->json(['data' => [], 'success' => true]);
            }
        }
        return Inertia::render('Service/Show', [
            'service' => new ServiceResource($service),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::find($id);
        return Inertia::render('Service/Form', [
            'service' => new ServiceResource($service),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image_id' => 'required',
            'page' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['message' => $validator->errors()->first(), 'success' => false]);
        }
        if ($request->image_id) {
            $service = Service::where(['id' => $id])->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'image_id' => $request->image_id,
                'page' => $request->page,
                'description' => $request->description,
            ]);
        } else {
            $service = Service::where(['id' => $id])->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'page' => $request->page,
                'description' => $request->description,
            ]);
        }

        if ($service) {
            return redirect('service')->with('flash', [
                'success' => true,
                'message' => 'Service updated successfully',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Industries not updated',
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::find($id);
        if ($service->delete()) {
            return response()->json(['success' => true, 'message' => 'Service has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
