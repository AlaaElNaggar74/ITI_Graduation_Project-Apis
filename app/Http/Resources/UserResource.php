<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);

        return[
            "id"=>$this->id,
            "name"=>$this->name,
            "email"=>$this->email,
            "image"=>$this->image,
            "phone"=>$this->phone,
            "role"=>$this->role,
            "password"=>$this->password,
            "city_id"=>$this->city_id,
            "plan_id"=>$this->plan_id,
            "group_creator"=>GroupResource::collection($this->user_createGroup),
            "groups"=>GroupResource::collection($this->user_joinGroup),

            

        ];
    }
}
