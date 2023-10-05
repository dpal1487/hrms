<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageSent;
use App\Http\Resources\Web\UserResource;
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
        $users = new User();
        if (!empty($request->q)) {
            $users = $users->where('first_name', 'like', "%{$request->q}%")
                ->orWhere('last_name', 'like', "%{$request->q}%")
                ->orWhere('email', 'like', "%{$request->q}%");
        }
        return Inertia::render('Chat/UserChat', [
            'users' => UserResource::collection($users->get()),
        ]);
    }

    public function userChat(Request $request)
    {
        $user = User::find($request->id);

        // event(new ChatMessageSent($message));


        return Inertia::render('Chat/Chat', [
            'user' => new UserResource($user),
            'users' => $this->users,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $message)
    {
        //

        event(new ChatMessageSent($message));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
