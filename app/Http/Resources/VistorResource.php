<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class VistorResource extends Resource
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
            'mark' => $this->mark,
            'name' => $this->name,
            'ip' => $this->ip,
            'browser' => $this->browser,
            'time' => $this->updated_at->diffForHumans(),
        ];
    }
}
