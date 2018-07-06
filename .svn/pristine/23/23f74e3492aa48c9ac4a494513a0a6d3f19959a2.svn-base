<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function teams(){
        return $this->belongsToMany(Team::class, 'team_users');
    }
        //搜索相关
    public function scopeSearchUserId($query, $suser_id)
    {
        if ($suser_id){
            return $query->where('id', $suser_id);
        }else{
            return $query;
        }

    }
}
