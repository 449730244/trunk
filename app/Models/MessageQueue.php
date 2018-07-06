<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageQueue extends Model
{
    //
    protected $table ="message_queues";
    protected $fillable = [
        'user_id', 'content', 'from_id','name','type','unread'
    ];

}
