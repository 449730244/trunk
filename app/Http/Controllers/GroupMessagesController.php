<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MessageQueue;
use App\Models\GroupMessage;
use App\Http\Resources\GroupMessageResourceCollection;

class GroupMessagesController extends BaseController
{
    public function sendmessage(Request $request){

        $uid = $request->id;
        $queue = new MessageQueue();

        $from_id = $request->user()->id;
        $content =json_encode([
            'headimg' => $request->user()->avatar,
            'user_name' => $request->user()->name,
            'content' => '',
        ]);
        $type = 'group';
        $name = '';
        $queue->create([
            'user_id' => $uid,
            'content' => $content,
            'from_id' => $from_id,
            'name' => $name,
            'type' => $type,
            'unread' => 0,
        ]);
        //$queue->saveQueue($uid,$from_id,$name,$content,$type);

    }

    public function index(Request $request)
    {
        $group_id = $request->input('group_id');

        return new GroupMessageResourceCollection(GroupMessage::where('group_id',$group_id)->orderBy('created_at','desc')->paginate(10));
    }
}
