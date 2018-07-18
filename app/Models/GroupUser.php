<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    protected $fillable = [
        'group_id','user_id'
    ];


    public function groupFiles(){
        return $this->hasMany(File::class,'group_id','group_id');
    }
}
