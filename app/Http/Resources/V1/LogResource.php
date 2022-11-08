<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class LogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'token' => $this->token,
            'user_id' => $this->user_id,
            'ip' => $this->ip,
            'isp' => $this->isp,
            'location' => $this->location,
            'created_at' => date_format($this->created_at, 'Y-m-d H:i:s'),
        ];
    }
}
