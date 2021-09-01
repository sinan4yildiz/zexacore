<?php

namespace App\Http\Resources\Api\System\Maintenance;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BackupResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name'           => $this->name,
            'created_at'     => Carbon::createFromTimestamp($this->created_at)->diffForHumans(),
            'created_at_raw' => Carbon::createFromTimestamp($this->created_at)->format('d F Y, H:i'),
        ];
    }
}

