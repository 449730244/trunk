<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class GroupResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'count' => $this->count,
            'groupAvatar' => '/chat/img/grouphead.png',
            'created_at' => $this->created_at->toDateTimeString(),
            'users' => UserResource::collection($this->users),
        ];
    }
}
