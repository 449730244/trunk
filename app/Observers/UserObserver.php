<?php
namespace App\Observers;

use App\Models\User;
use Cache;

class UserObserver{

    // 在保存时清空 cache_key 对应的缓存
    public function saved(User $user){
        Cache::forget($user->cache_key);
    }

}