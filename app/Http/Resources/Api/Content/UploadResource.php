<?php

namespace App\Http\Resources\Api\Content;

use App\Helpers\Helper;
use App\Helpers\Thumbnail;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name'        => $this->getBasename(),
            'path'        => Str::replaceFirst(config('filesystems.disks.uploads.root') . '/', '', $this->getPathname()),
            'extension'   => $this->getExtension(),
            'type'        => $this->getType(),
            'size'        => Helper::sizeForHuman($this->getSize()),
            'modified_at' => Carbon::createFromTimestamp($this->getMTime())->diffForHumans(),
            'thumbnail'   => in_array($this->getExtension(), config('constants.uploads.kinds.images')) ? Thumbnail::make($this->getPathname())->resize(320)->url() : false,
            'preview'     => in_array($this->getExtension(), config('constants.uploads.kinds.previewable')) ? Storage::disk('uploads')->url(Str::of($this->getPathname())->replace(config('filesystems.disks.uploads.root'), '')) : false,
        ];
    }
}

