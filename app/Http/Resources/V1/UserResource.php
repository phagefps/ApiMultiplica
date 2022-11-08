<?php

namespace App\Http\Resources\V1;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => date_format($this->created_at, 'Y-m-d H:i:s'),
            'transactions_api' => route('api-transactions', [$request->token, $this->id]),
            'transactions_client' => $request->token.'/transactions/'.$this->id,
            'user_information' => $request->token.'/'.$this->id,
        ];
    }
}
