<?php
/**
 * 单聊消息处理
 */
namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Http\Resources\GroupMessageResourceCollection;
use App\Http\Resources\MessageQueueResourceCollection;
use App\Http\Resources\MessageResourceCollection;
use App\Models\Group;
use App\Models\GroupMessage;
use App\Models\Message;
use App\Models\MessageQueue;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class MessageController extends BaseController
{

    /**
     * 获取消息队列列表
     * $uid 当前登录的用户ID
     */
    public function getQueueList()
    {
        $messageQueue = new MessageQueue();
        //获取当前登录用户的所有群消息队列
        $group = $messageQueue->getGroupList(Auth::id(),'group');
        $group_queue = $messageQueue->where(['type'=>'group','user_id'=>Auth::id()])->whereIn('from_id',$group)->get()->toArray();
        //获取当前登录用户的所有私聊消息队列
        $user_queue = MessageQueue::where(['user_id'=>Auth::id(),'type'=>'user'])->get()->toArray();
        return array_merge($group_queue,$user_queue);
    }

    /**
     *根据群ID获取当前群下所有消息
     */
    public function getGroupMessageList(Request $request)
    {
        $messageQueue = new MessageQueue();
        $group_id = $request->input('group_id');
        $type    = $request->input('type');
        $uid = Auth::id();
        $messageQueue->updateQueueReadNum($uid,$group_id,$type);
        return new GroupMessageResourceCollection(GroupMessage::where('group_id',$group_id)->orderBy('updated_at','desc')->paginate(10));
    }

    /**
     * $user_id 私聊用户ID
     * $uid     当前登录用户的ID
     * @return MessageResourceCollection
     */
    public function getUserMessageList(Request $request)
    {
        $messageQueue = new MessageQueue();
        $user_id = $request->input('user_id');
        $type    = $request->input('type');
        $uid = Auth::id();
        $messageQueue->updateQueueReadNum($uid,$user_id,$type);
        return new MessageResourceCollection(Message::where(['user_id'=>$uid,'to_user_id'=>$user_id])->orderBy('updated_at','desc')->paginate(10));
    }

    /**
     *发送群消息
     * $send_id  发送人ID
     * $group_id 群ID
     * $content 消息内容
     */
    public function sendGroupMessage(Request $request)
    {
        $groupMessage  = new GroupMessage();
        $messageQueue = new MessageQueue();
        $user_id = Auth::id();
        $group_id = $request->input('group_id');
        $content = $request->input('content');
        $type = $request->input('type');
        $group = Group::findOrFail($group_id);
        $uid_arr = $group->users->pluck('id')->toArray();
        if(!in_array($user_id,$uid_arr))
        {
            throw new InvalidRequestException('你不在该群，不能发送消息',3002,400);
        }
        $data = [
            'user_name' => Auth::user()->name,
            'headimg' => Auth::user()->avatar,
            'content' => $content,
            'file_id' => '',
            'file_size' => '',
            'file_url' => '',
            'file_type' => ''
        ];
        $contents = json_encode($data);
        $groupMessage->user_id  = $user_id;
        $groupMessage->group_id = $group_id;
        $groupMessage->content  = $contents;
        $groupMessage->save();
        //推送数据封装
        $send_data = [
            'type'     => 'group',
            'user_id'  => $user_id,
            'group_id' => $group_id,
            'content'  => $data,
            'updated_at' => date('Y-m-d H:i:s',time()),
        ];
        //添加消息队列
        $messageQueue->saveGroupQueue($user_id,$group_id,$group->name,$contents,$type);
        //推送消息
        $this->sendToGroup($group->group_name,$send_data);
        return response()->json($send_data);
    }


    /**
     *发送私聊消息
     */
    public function sendPrivateMessage(Request $request)
    {
        $message  = new Message();
        $messageQueue = new MessageQueue();
        $user_id  = Auth::id();
        $to_user_id = $request->input('to_user_id');
        $content  = $request->input('content');
        $type     = $request->input('type');
        $username = Auth::user()->name;
        $avatar   = Auth::user()->avatar;
        $data = [
            'user_name' => $username,
            'headimg' => $avatar,
            'content' => $content,
            'file_id' => '',
            'file_size' => '',
            'file_url' => '',
            'file_type' => ''
        ];
        $contents  = json_encode($data);
        $message->user_id  = $user_id;
        $message->to_user_id = $to_user_id;
        $message->content  = $contents;
        $message->save();
        //推送数据封装
        $send_data = [
            'type'     => $type,
            'user_id'  => $user_id,
            'to_user_id' => $to_user_id,
            'content'  => $data,
            'updated_at' => date('Y-m-d H:i:s',time()),
            'msg_id'   => $message->id
        ];
        $user = User::findOrFail($to_user_id);
        //添加消息队列
        $messageQueue->saveUserQueue($user_id,$to_user_id,$user->name,$contents,$type);
        //推送消息
        $this->sendToUid([$to_user_id],$send_data);
        return response()->json($send_data);
    }


}
