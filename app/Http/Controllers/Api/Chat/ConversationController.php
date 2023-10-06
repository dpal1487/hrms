<?php

namespace App\Http\Controllers\Api\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Api\Chat\ConversationResource;
use App\Models\Conversation;
use App\Models\Participant;

class ConversationController extends Controller
{
    private $data;
    public function index()
    {
        $uid = $this->uid();

        // return $uid;
        
        $participants = Participant::where(['user_id' => $this->uid()])->whereHas('messages', function ($query) use ($uid) {
            $query->where(['is_deleted' => 0])->orderBy('id', 'desc');
        })->get();

        // return $participants;
        if (count($participants) > 0) {
            foreach ($participants as $participant) {
                $conversation = Conversation::find($participant->conversation_id);
                $this->data[] = Participant::where('conversation_id', '=', $conversation->id)->where('user_id', '!=', $uid)->first();
            }
            return ConversationResource::collection($this->data);
        }
        return response()->json(['data' => []]);
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
    public function store(Request $request)
    {
        //
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
