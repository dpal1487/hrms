<?php

namespace App\Http\Controllers\Web;


use App\Models\NotificationType;
use App\Http\Resources\Web\NotificationTypeResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $notificationtypes = new NotificationType();
        if (!empty($request->q)) {
            $notificationtypes = $notificationtypes->where('label', 'like', "%{$request->q}%")->orWhere('description', 'like', "%{$request->q}%");
        }
        if (!empty($request->s) || $request->s != '') {
            $notificationtypes = $notificationtypes->where('status', $request->s);
        }
        return Inertia::render('NotificationTypes/Index', [
            'notificationtypes' => NotificationTypeResource::collection($notificationtypes->paginate(10)->onEachSide(1)->appends(request()->query()))
        ]);
    }
    public function statusUdate(Request $request)
    {
        if (NotificationType::where(['id' => $request->id])->update(['status' => $request->status ? 1 : 0])) {
            $status = $request->status == 0  ? "Inactive" : "Active";
            return response()->json(['message' => StatusMessage('Notification Type', $status), 'success' => true]);
        }
        return response()->json(['message' => 'Opps! something went wrong.', 'success' => false]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('NotificationTypes/Form');
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

        if ($notificationtype) {
            return redirect()->route('notification-types.index')->with('flash', ['success' => true, 'message' => CreateMessage('Notification Type')]);
        }
        return redirect()->route('notification-types.index')->with('flash', ['success' => false, 'message' => ErrorMessage()]);
    }


    public function edit($id)
    {
        return Inertia::render('NotificationTypes/Form', [
            'notification_type' => new NotificationTypeResource(NotificationType::find($id))
        ]);
    }

    public function update(Request $request, NotificationType $notificationType, $id)
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
            return redirect()->route('notification-types.index')->with('flash', ['success' => true, 'message' => CreateMessage('Notification Type')]);
        }
        return redirect()->route('notification-types.index')->with('flash', ['success' => false, 'message' => ErrorMessage()]);
    }

    public function destroy($id)
    {
        $notificationType = NotificationType::find($id);
        if ($notificationType->delete()) {
            return response()->json(['success' => true, 'message' => DeleteMessage('Notification Type')]);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
