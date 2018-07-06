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
            'create_at' => $this->create_at,
            'update_at' => $this->update_at
        ];
    }
}