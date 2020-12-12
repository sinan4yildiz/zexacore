<?php

namespace App\Http\Resources\Content;

use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UploadResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name'        => $this->getBasename(),
            'extension'   => $this->getExtension(),
            'type'        => $this->getType(),
            'size'        => Helper::sizeForHuman($this->getSize()),
            'modified_at' => Carbon::createFromTimestamp($this->getMTime())->diffForHumans(),
        ];
    }
}

