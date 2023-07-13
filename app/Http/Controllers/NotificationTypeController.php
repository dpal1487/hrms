<?php

namespace App\Http\Controllers;

use App\Models\NotificationType;
use App\Http\Resources\NotificationTypeResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class NotificationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $notificationtypes = new NotificationType();
        if ($request->q) {
            $notificationtypes = $notificationtypes->where('label', 'like', "%{$request->q}%");
        }
        $notificationtypes = $notificationtypes->paginate(10)->onEachSide(1)->appends(request()->query());
        $notificationtypes = NotificationTypeResource::collection($notificationtypes);
        return view('pages.notification-type.index', compact('notificationtypes'));
    }
    // public function statusUdate(Request $request)
    // {

    //     if (Attribute::where(['id' => $request->id])->update(['status' => $request->status ? 1 : 0])) {
    //         $status = $request->status == 0  ? "Inactive" : "Active";
    //         return response()->json(['message' => "Your Status has been " . $status, 'success' => true]);
    //     }
    //     return response()->json(['message' => 'Opps! something went wrong.', 'success' => false]);
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.notification-type.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'label' => 'required',
            'status' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ],
                400,
            );
        }

        $notificationtype = NotificationType::create([
            'label' => $request->label,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return response()->json(['success' => true, 'message' => 'Notification Type created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(NotificationType $notificationType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NotificationType $notificationType, $id)
    {
        $notificationType = NotificationType::find($id);
        $notificationType = new NotificationTypeResource($notificationType);
        return view('pages.notification-type.edit', ['notificationType' => $notificationType]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NotificationType $notificationType , $id)
    {
        $validator = Validator::make($request->all(), [
            'label' => 'required',
            'status' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all(),
            ]);
        }
        $notificationType = NotificationType::find($id);
        if ($notificationType) {
            $notificationType = NotificationType::where(['id' => $id])->update([
                'label' => $request->label,
                'slug' => Str::slug($request->label),
                'status' => $request->status,
                'description' => $request->description,
            ]);

            return response()->json(['success' => true, 'message' => 'Notification Type Updated successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NotificationType $notificationType , $id)
    {
        $notificationType = NotificationType::find($id);
        $notificationType = new NotificationTypeResource($notificationType);
        if ($notificationType->delete()) {
            return response()->json(['success' => true, 'message' => 'Notification Type has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
