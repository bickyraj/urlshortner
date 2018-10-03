<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\Resource;

class Link extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'url' => $this->url,
            'code' => $this->code,
            'counter' => $this->counter,
            'status' => $this->status,
            'expiration_time' => $this->expiration_time,
        ];
    }
}
