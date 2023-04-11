<?php
namespace App\Events;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreateProject implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

	public $project;
	public $notification;

	public $message;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($notification,$project)
	{
		$this->message = [
			'title'=>$project->project_name,
			'sub_title'=>"{$project->client->latter} New Project Added",
			'source_url'=>"/project/{$project->id}?notif_id={$notification->id}",
			'created_at'=>$project->created_at->diffForHumans(),

		];
		$this->notification=NotificationResource::collection(Notification::get());
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return Channel|array
	 */
	public function broadcastOn()
	{
		return ['project-created'];
	}
}