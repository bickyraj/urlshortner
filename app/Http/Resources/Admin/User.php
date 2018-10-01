<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\Resource;

class User extends Resource
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
            'id' => $this->id,
            'name' => $this->name,
            'firstname' => $this->firstname,
            'register_date' => $this->register_date,
            'role_id' => $this->role_id,
            'status' => $this->status,
            'role' => [
                'id' => $this->role->id,
                'name' => $this->role->name,
            ],
            'client' => [
                'id' => $this->client->id,
                'company_name' => $this->client->company_name,
                'category_id' => $this->client->category_id
            ]
        ];
    }
}
