<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class FileResource extends Resource
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
            'user_name'=>$this->user->name,
            'name'=>$this->name,
            'type'=>$this->type,
            'size'=>$this->size,
            'url'=>$this->url,
            'created_at'=>$this->created_at->toDateTimeString(),
        ];
    }


}
