<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class VistorMessageResource extends Resource
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
            'auth' => $this->auth,
            'to' => $this->to,
            'content' => $this->content,
            'time' => $this->updated_at->toDateTimeString(),
        ];
    }
}
