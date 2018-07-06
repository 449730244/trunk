<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MessageQueueResource extends Resource
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
            'from_id' => $this->from_id,
            'name' => $this->name,
            'content' => $this->content,
            'type'   => $this->type,
            'unread' => $this->unread,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString()
        ];
    }
}