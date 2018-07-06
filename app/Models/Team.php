<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
      'name','user_id'
    ];

    //搜索相关
    public function scopeSearchTeamUserId($query, $user_id)
    {
        if ($user_id){
            return $query->where('user_id', $user_id);
        }else{
            return $query;
        }

    }

    public function users(){
        return $this->belongsToMany(User::class, 'team_users');
    }
}
