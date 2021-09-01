<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'subject'        => $this->subject,
            'text'           => $this->text,
            'name'           => $this->name,
            'email'          => $this->email,
            'telephone'      => $this->telephone,
            'unread'         => $this->unread,
            'created_at'     => $this->created_at->diffForHumans(),
            'created_at_raw' => $this->created_at->format('d F Y, H:i'),
            'updated_at'     => $this->updated_at ? $this->updated_at->diffForHumans() : null,
            'updated_at_raw' => $this->updated_at ? $this->updated_at->format('d/m/Y H:i') : null,
        ];
    }
}

