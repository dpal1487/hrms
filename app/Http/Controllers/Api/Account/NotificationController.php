<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\Notifications;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Reports;
use JWTAuth;

class NotificationController extends Controller
{
  public $data;
  public function index()
  {
    $notifications = Notification::where(['recipient_id' => $this->uid(), 'deleted' => 0, 'is_read' => 0])->get();
    return Notifications::collection($notifications);
  }
  public function create($sourceId, $recipient_id, $typeId)
  {
    if ($notification = Notification::create(['type_id' => $typeId, 'recipient_id' => $recipient_id, 'sender_id' => $this->getTokenId(), 'source_id' => $sourceId])) {
      return $notification;
    }
  }
  public function markAsRead(Request $request)
  {
    if ($notification = Notification::where(['id' => $request->id, 'recipient_id' => $this->getTokenId()])->first()) {
      if ($notification->is_read == 1) {
        if (Notification::where(['id' => $request->id, 'recipient_id' => $this->getTokenId()])->update(['is_read' => 0])) {
          return response()->json(['success' => true]);
        }
      }
    }
    return response()->json(['success' => false, 'Faild to Read Notification!'], 400);
  }
  public function markAsUnread(Request $request)
  {
    if ($notification = Notification::where(['id' => $request->id, 'recipient_id' => $this->getTokenId()])->first()) {
      if ($notification->is_read == 0) {
        if (Notification::where(['id' => $request->id, 'recipient_id' => $this->getTokenId()])->update(['is_read' => 0])) {
          return response()->json(['success' => true]);
        }
      }
    }
    return response()->json(['success' => false, 'Faild to Unread Notification!'], 400);
  }
  public function delete(Request $request)
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
    $reviews = Reports::updateOrCreate($data, $data);
    if ($reviews) {
      return response()->json(['message' => 'Thanks for reporting it. Our team will look into it at the earliest.', 'success' => true]);
    }
    return response()->json(['message' => 'Opps someting went wrong!.', 'success' => false]);
  }
}