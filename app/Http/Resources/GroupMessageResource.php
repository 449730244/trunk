<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class GroupMessageResource extends Resource
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
            'group_id' => $this->group_id,
            'user_id' => $this->user_id,
            'content' => $this->content,
            'created_at' => $this->create_at->toDateTimeString()
        ];
    }
}