<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Thumbnail
{
    protected $image;
    protected $info;
    protected $width;
    protected $height;

    public function __construct($image)
    {
        $this->image = $image;

        $this->info = (object) pathinfo(Str::of($this->image)->replace(config('filesystems.disks.uploads.root'), ''));
    }

    /**
     * Make an instance of the image
     *
     * @param  string  $image
     *
     */
    public static function make($image)
    {
        return new Thumbnail($image);
    }

    /**
     * Resize the image
     *
     * @param  int  $width
     * @param  int or null  $height  (if null, the height will be adjusted automatically)
     *
     */
    public function resize($width, $height = null)
    {
        $this->width = $width;
        $this->height = $height;

        /**
         * Check if already resized
         */
        if (!$this->isResized() and $this->fileExists()) {

            /**
             * Just copy the SVG file
             */
            if ($this->info->extension == 'svg') {
                Storage::disk('images')->put($this->relativeResizedName(), Storage::disk('uploads')->get($this->relativeResizedName()));
            } else {

                /**
                 * Generate and put the thumbnail
                 */
                $resized = Image::make($this->image)->resize($this->width, $this->height, function ($constraint) {
                    $constraint->aspectRatio();
                });

                /**
                 * Put the resized thumbnail on disk
                 */
                Storage::disk('images')->put($this->relativeResizedName(), $resized->stream());
            }
        }

        return $this;
    }

    /**
     * Return the absolute URL of the generated thumbnail
     *
     */
    public function url()
    {
        if ($this->fileExists()) {
            return Storage::disk('images')->url($this->relativeResizedName());
        } else {
            return null;
        }
    }

    /**
     * Get the resized name of the image
     *
     */
    public function resizedName()
    {
        $name = Str::of(basename($this->image));

        if ($this->info->extension != 'svg') {
            $name = $name->replaceLast('.', '-' . $this->width . 'x' . $this->height . '.');
        }

        return $name;
    }

    /**
     * Get the relative resized name of the image
     *
     */
    public function relativeResizedName()
    {
        return Str::of($this->info->dirname)->finish('/') . $this->resizedName();
    }

    /**
     * Check if the source image exists
     *
     */
    public function fileExists()
    {
        return File::exists($this->image);
    }

    /**
     * Check if the thumbnail has been generated before
     *
     */
    public function isResized()
    {
        return Storage::disk('images')->exists($this->relativeResizedName());
    }
}