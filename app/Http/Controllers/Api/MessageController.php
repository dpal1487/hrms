<?php


namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\MessageResource;
use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\Conversation;
use App\Models\User;
use App\Models\Message;
use App\Http\Resources\Api\Chat\Messages;
use App\Http\Resources\Api\Items;
use App\Models\Item;
use App\Http\Resources\Api\Users;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Api\Controller;

use App\Http\Resources\Api\ItemListResource;
use App\Http\Resources\Api\Account\UserResource;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $participant = Participant::where('conversation_id', '=', $request->uid)->where('users_id', '!=', $this->uid())->first();
        if($participant){
            Message::where(['conversation_id'=>$request->uid])->where('sender_id', '!=', $this->uid())->update(['is_read'=>1]);
            $messages = Message::where(['conversation_id'=>$request->uid])->get();
            return [
                'messages'=>MessageResource::collection($messages),
                'user'=>new UserResource(User::find($participant->users_id))
            ];
        }
        else
        {
            return [
                'messages'=>[],
                'user'=>new UserResource(User::find($request->uid)),
                'item'=>new ItemListResource(Item::find($request->pid)),
            ];
        }
    }
     public function compose(Request $request)
    {
        $participant = Participant::where(['user_id'=> $request->uid])->whereColumn('user_id', 'user_id')->get();
        if($participant){
            return $participant;
            Message::where(['conversation_id'=>$request->uid])->where('sender_id', '!=', $this->uid())->update(['is_read'=>1]);
            $messages = Message::where(['conversation_id'=>$request->uid])->get();
            return [
                'messages'=>MessageResource::collection($messages),
            ];
        }
        else
        {
            return [
                'messages'=>[],
                'item'=>new ItemListResource(Item::find($request->pid)),
            ];
        }
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required',
            'thread_id' => 'required',
        ]);
        if ($validator->fails()) {
          return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
        }
        if(count(Participant::where(['conversation_id'=>$request->thread_id,'users_id'=>$this->uid()])->get())>0){
            if(Message::create(['message'=>Crypt::encryptString($request->message),'sender_id'=>$this->uid(),'conversation_id'=>$request->thread_id]))
            {
                return response()->json(['success'=>true],200);
            }
        }
        return response()->json(['message'=>'Opps someting wrong.','success'=>false],400);

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
