<?php
namespace App\Observers;

use App\Models\User;
use Cache;

class UserObserver{

    // 在保存时清空 cache_key 对应的缓存
    public function saved(User $user){
        Cache::forget($user->cache_key);
    }

    public function deleted(User $User){
        \DB::table('message_queues')
            ->where('from_id', $User->id)
            ->where('type', 'user')
            ->delete();

        \DB::table('message_queues')
            ->where('user_id', $User->id)
            ->delete();
    }

}