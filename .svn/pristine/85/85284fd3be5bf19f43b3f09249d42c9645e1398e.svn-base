<?php
namespace App\Observers;

use App\Models\Group;
use Cache;

class GroupObserver{


    public function deleted(Group $group){
        \DB::table('message_queues')
            ->where('from_id', $group->id)
            ->where('type', 'group')
            ->delete();
    }

    public function updated(Group $group){
        \DB::table('message_queues')
            ->where('from_id', $group->id)
            ->where('type', 'group')
            ->update(['name'=>$group->name]);
    }

}