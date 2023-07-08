<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    public $users;
    public function __construct()
    {
        $this->users = UserResource::collection(User::get());
    }
    public function index(Request $request)
    {
        return Inertia::render('Chat/UserChat', [
            'users' => $this->users,
        ]);
    }

    public function userChat(Request $request, $user)
    {
        $user = User::find($user);
        return Inertia::render('Chat/Chat', [
            'user' => new UserResource($user),
            'users' => $this->users,

        ]);
    }
}
