<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class VistorMessage extends Model
{
    protected $fillable=['auth','to','content','read','sn'];
    protected $casts=['read'];

    public function createSn($mark, $service_id){
        return md5($mark.$service_id);
    }
}
