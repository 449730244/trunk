<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
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
            'name' => $this->name,
            'username' => $this->username,
            'avatar' => $this->avatar ? '/uploads/'.$this->avatar : '/chat/img/avatar.png',
            'isadmin' => $this->whenPivotLoaded('group_users', function () {
                return $this->pivot->isadmin;
            }),
        ];
    }
}
