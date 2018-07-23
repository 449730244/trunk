<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class VistorMessage extends Model
{
    protected $fillable=['auth','to','content','read','sn'];
    protected $casts=['read'];
    protected $table = 'vistor_messages';

    public function createSn($mark, $service_id){
        return md5($mark.$service_id);
    }

    public function vistor(){
        return $this->belongsTo(Vistor::class,'auth','mark');
    }

    public function service(){
        return $this->belongsTo(CustomerService::class,'auth','id');
    }
}
