<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'user_id','to_user_id','content','file_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
