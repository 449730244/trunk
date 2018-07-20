<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class CustomerService extends Model
{
    protected $fillable=['user_id','name','avatar','ison'];
    protected $casts = ['ison'];

    public function user(){
       return $this->belongsTo(User::class);
    }

    public function vistors(){
        return $this->belongsToMany(Vistor::class,'service_vistors','service_id','vistor_id')
            ->withTimestamps()
            ->orderBy('updated_at','desc');
    }
}
