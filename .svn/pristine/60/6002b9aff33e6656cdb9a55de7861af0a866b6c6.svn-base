<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/18
 * Time: 15:57
 */


namespace App\Models\Traits;
use App\Models\Message;
use App\Models\GroupMessage;
use Carbon\Carbon;

trait clearMessage{

    public function clear()
    {
        $time = Carbon::now()->month(-3)->toTimeString();
        Message::where('created_at','<=',$time)->delete();
        GroupMessage::where('created_at','<=',$time)->delete();
    }
}