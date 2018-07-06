<?php
/**
 * 单聊消息处理
 */
namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Http\Resources\GroupResourceCollection;
use App\Http\Resources\MessageQueueResourceCollection;
use App\Http\Resources\MessageResourceCollection;
use App\Models\Group;
use App\Models\GroupMessage;
use App\Models\Message;
use App\Models\MessageQueue;
use Illuminate\Http\Request;
use Auth;
use GatewayClient\Gateway;

class MessageController extends BaseController
{

    /**
     * 获取消息队列列表
     * $uid 当前登录的用户ID
     */
    public function getQueueList()
    {
        return new MessageQueueResourceCollection(MessageQueue::where('user_id',Auth::id())->get());
    }

    /**
     *根据群ID获取当前群下所有消息
     */
    public function getGroupMessageList(Request $request)
    {
        //$group_id = $request->input('group_id');
        $group_id = 1;
        return new GroupResourceCollection(Group::where('id',$group_id)->get());
    }

    /**
     * $user_id 私聊用户ID
     * $uid     当前登录用户的ID
     * @return MessageResourceCollection
     */
    public function getUserMessageList(Request $request)
    {
        $user_id = $request->input('user_id');
        $uid = Auth::id();
        return new MessageResourceCollection(Message::whereIn('user_id',[$user_id,$uid])->get());
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
        //$user_id = $request->input('user_id');
        //$group_id = $request->input('group_id');
        //$content = $request->input('content');
        //$name = $request->input('group_name');
        //$type = $request->input('type');
        $user_id  = 3;
        $group_id = 2;
        $name     ='aLIEz的群';
        $type     = 'group';
        $data = [
            'user_name' => 'aLIEz',
            'headimg' => '',
            'content' => '和哦哦拉发送',
            'file_id' => '',
            'file_size' => '',
            'file_url' => '',
            'file_type' => ''
        ];
        $content  = json_encode($data);

        $groupMessage->user_id  = $user_id;
        $groupMessage->group_id = $group_id;
        $groupMessage->content  = $content;
        $groupMessage->save();
        //推送数据封装
        $send_data = [
            'type'     => 'group',
            'user_id'  => $user_id,
            'group_id' => $group_id,
            'content'  => $content
        ];
        //添加消息队列
        $this->saveQueue($user_id,$group_id,$name,$content,$type);
        //推送消息
        Gateway::joinGroup(session('client_id'),$group_id);
        Gateway::sendToGroup(session('client_id'),json_encode($send_data,JSON_FORCE_OBJECT));
    }

    /**
     * 群消息撤回
     *
     */
    public function groupWithdraw()
    {

    }


    /**
     *发送私聊消息
     */
    public function sendPrivateMessage(Request $request)
    {
        $message  = new Message();
        //$user_id = $request->input('user_id');
        //$group_id = $request->input('group_id');
        //$content = $request->input('content');
        //$type = $request->input('type');
        $user_id = 4;
        $to_user_id = 1;
        $data = [
            'user_name' => '小明',
            'headimg' => '',
            'content' => '叽叽叽叽叽叽叽叽',
            'file_id' => '',
            'file_size' => '',
            'file_url' => '',
            'file_type' => ''
        ];
        $content  = json_encode($data);
        $type  = 'user';
        $username = Auth::user()->username;
        $message->user_id  = $user_id;
        $message->to_user_id = $to_user_id;
        $message->content  = $content;
        $message->save();
        //推送数据封装
        $send_data = [
            'type'     => $type,
            'user_id'  => $user_id,
            'username' => $username,
            'to_user_id' => $to_user_id,
            'content'  => $content,
            'msg_id'   => $message->id
        ];
        //添加消息队列
        $this->saveQueue($user_id,$to_user_id,$username,$content,$type);
        //推送消息
        Gateway::sendToUid($to_user_id,json_encode($send_data,JSON_FORCE_OBJECT));
    }

    /**
     * 私聊消息撤回
     */
    public function privateWithdraw()
    {

    }

    /**
     * save queue
     * $uid     接收消息用户ID
     * $content 发送休息内容
     * $form_id 发送人获取群ID
     * $name    发送人名称或群名称
     * $type    消息类型：group 群,user 私聊
     */
    public function saveQueue($uid,$from_id,$name,$content,$type)
    {
        $res = MessageQueue::where(['user_id'=>$uid,'from_id'=>$from_id,'type' =>$type])->first();
        if(!$res)
        {
            $data['user_id'] = $uid;
            $data['content'] = $content;
            $data['from_id'] = $from_id;
            $data['name']    = $name;
            $data['type']    = $type;
            $data['unread']   = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            MessageQueue::insert($data);
        }else{
            $data['content'] = $content;
            $data['unread']  = $res->unread + 1;
            MessageQueue::where(['user_id'=>$uid,'from_id'=>$from_id,'type' =>$type])->update($data);
        }
    }


}
