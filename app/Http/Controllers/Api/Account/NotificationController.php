<?php

namespace App\Http\Controllers\Api\Account;

use App\Events\NotificationCreated;
use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\Account\NotificationsResource;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Report;
use App\Models\User;
use App\Notifications\UserFollowNotification;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
  public $data;
  public function index()
  {

    return  $notifications = Auth::user()->notifications()->get();
    $notifications = Notification::where(['recipient_id' => $this->uid(), 'deleted' => 0, 'is_read' => 0])->get();
    return NotificationsResource::collection($notifications);
  }

  public function notify(Request $request)
  {

    $createdResourceData = User::first();
    event(new NotificationCreated($createdResourceData));
    return response()->json(['message' => 'Notification created successfully']);

    if (Auth::user()) {
      $user = User::first();
      auth()->user()->notify(new UserFollowNotification($user));
    }

    return "done";
  }


  // public function store($sourceId, $recipient_id, $typeId)
  public function store(Request $request)
  {
    if ($notification = Notification::create(['type_id' => $request->type_id, 'recipient_id' => $request->recipient_id, 'sender_id' => $this->getTokenId(), 'source_id' => $request->source_id])) {
      return $notification;
    }
  }
  public function markAsRead(Request $request)
  {
    $user = Auth::user();
    $notification = $user->notifications()->where('id', $request->id)->first();
    if ($notification->read_at == null) {
      $notification->markAsRead();
      return response()->json(['success' => true, 'message' => 'Mark as read']);
    }
    return response()->json(['success' => false, 'Faild to Read Notification!'], 400);
  }
  public function markAsUnread(Request $request)
  {

    $user = Auth::user();
    $notification = $user->notifications()->where('id', $request->id)->first();


    if ($notification->read_at != null) {
      $notification->markAsUnRead();
      return response()->json(['success' => true , 'message' => 'Marked as unread']);
    }
    return response()->json(['success' => false, 'Faild to Unread Notification!'], 400);
  }
  public function destroy(Request $request)
  {
    $notification = Notification::where(['id' => $request->id, 'recipient_id' => $this->getTokenId()])->first();

    if ($notification) {
      Notification::where('id', $notification->id)->update(['deleted' => 1]);
      return response()->json(['success' => true, 'message' => 'Notification deleted successfully.']);
    }
    return response()->json(['false' => true, 'message' => 'looks like something went wrong.']);
  }
  public function report(Request $request)
  {
    $data = array('user_id' => $this->getTokenId(), 'type_id' => 4, 'source_id' => $request->id);
    $reviews = Report::updateOrCreate($data, $data);
    if ($reviews) {
      return response()->json(['message' => 'Thanks for reporting it. Our team will look into it at the earliest.', 'success' => true]);
    }
    return response()->json(['message' => 'Opps someting went wrong!.', 'success' => false]);
  }
}
