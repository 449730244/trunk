<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Group extends Model
{
    protected $table = 'groups';

    protected $fillable=[
      'user_id','name'
    ];

    public function users(){
        return $this->belongsToMany(User::class, 'group_users');
    }

    public function messages(){
        return $this->hasMany(GroupMessage::class);
    }


    public function getUserGroupList($uid)
    {
        return Group::where('user_id',$uid)->get()->toArray();
    }
}
