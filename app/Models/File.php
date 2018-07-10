<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable=[
      'user_id','to_user_id','group_id','name','type','size','url',
    ];

    //获取文件发送者
    public function user(){
        return $this->belongsTo(User::class);
    }


}
