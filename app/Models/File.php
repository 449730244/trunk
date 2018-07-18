<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use \App\Models\Traits\clearFiles;

    protected $fillable=[
     'id', 'user_id','to_user_id','group_id','name','type','size','url',
    ];

    //获取文件发送者
    public function user(){
        return $this->belongsTo(User::class);
    }
}
