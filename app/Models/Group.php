<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Group extends Model
{
    protected $fillable=[
      'user_id','name','count'
    ];

    public function users(){
        return $this->belongsToMany(User::class, 'group_users')->withTimestamps()->withPivot('isadmin');
    }

    public function messages(){
        return $this->hasMany(GroupMessage::class);
    }

    public function getGroupNameAttribute(){
        return "chat_".$this->id;
    }
}
