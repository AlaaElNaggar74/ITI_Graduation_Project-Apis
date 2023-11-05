<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupUserResource extends JsonResource
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
            "name"=>$this->name,
            "posts"=>PostResource::collection($this->hasPost),
            "users"=>UserForGroupResource::collection($this->user_join),
                       
        ];
    }
}
