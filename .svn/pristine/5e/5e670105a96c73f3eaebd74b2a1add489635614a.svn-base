<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageQueue extends Model
{
    protected $fillable =[
      'user_id','content','from_id','name','type','unread'
    ];
    protected $table ="message_queues";

    /**
     * save queue
     * $uid     接收消息用户ID
     * $content 发送休息内容
     * $form_id 发送人获取群ID
     * $name    发送人名称或群名称
     * $type    消息类型：group 群,user 私聊
     */
    public function saveUserQueue($uid,$from_id,$name,$content,$type)
    {
        $my_res   = MessageQueue::where(['user_id'=>$uid,'from_id'=>$from_id,'type' =>$type])->first();
        $user_res = MessageQueue::where(['user_id'=>$from_id,'from_id'=>$uid,'type' =>$type])->first();
        if(!$my_res && !$user_res)
        {
            //自己消息队列
            $data['user_id'] = $uid;
            $data['content'] = $content;
            $data['from_id'] = $from_id;
            $data['name']    = $name;
            $data['type']    = $type;

            //接收人消息队列
            $data1['user_id'] = $from_id;
            $data1['content'] = $content;
            $data1['from_id'] = $uid;
            $data1['name']    = \Auth::user()->name;
            $data1['type']    = $type;
            $data1['unread']   = 1;
            MessageQueue::create($data);
            MessageQueue::create($data1);
        }else{
            $data['content'] = $content;
            $data['unread']  = $user_res->unread + 1;
            MessageQueue::where(['user_id'=>$uid,'from_id'=>$from_id,'type' =>$type])->update(['content'=>$content]);
            MessageQueue::where(['user_id'=>$from_id,'from_id'=>$uid,'type' =>$type])->update(['content'=>$content,'unread'=> $user_res->unread+1]);
        }
    }

    /**
     * save queue
     * $uid     接收消息用户ID
     * $content 发送消息内容
     * $form_id 发送人获取群ID
     * $type    消息类型：group 群,user 私聊
     */
    public function saveGroupQueue($uid,$from_id,$name,$content,$type)
    {
            $user = GroupUser::where(['group_id'=>$from_id])->get(['user_id'])->toArray();
            foreach($user as $key => $val)
            {
                $res = MessageQueue::where(['user_id'=>$val['user_id'],'from_id'=>$from_id,'type'=>$type])->first();
                if($res)
                {
                    if($res->user_id != $uid){
                        MessageQueue::where(['user_id'=>$val['user_id'],'from_id'=>$from_id,'type'=>$type])->increment('unread',1);
                    }
                    MessageQueue::where(['user_id'=>$val['user_id'],'from_id'=>$from_id,'type'=>$type])->update(['content'=>$content]);
                }else{
                    MessageQueue::create(
                        [
                            'user_id'=>$val['user_id'],
                            'from_id'=>$from_id,
                            'content'=>$content,
                            'name' =>$name,
                            'type' =>$type,
                            'unread' => 1
                        ]
                    );
                }
            }
    }


    /**
     * 修改消息队列未读数量
     */

    public function updateQueueReadNum($user_id,$from_id,$type)
    {
        return MessageQueue::where(['user_id'=>$user_id,'from_id'=>$from_id,'type' =>$type])->update(['unread' => 0]);
    }

    /**
     * 获取队列信息
     */
    public function getGroupList($uid)
    {
        return GroupUser::where(['user_id' => $uid])->get(['group_id'])->toArray();
    }
}
