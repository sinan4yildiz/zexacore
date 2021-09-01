<?php

namespace App\Http\Controllers\Api\v1\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Content\UploadFileRequest;
use App\Http\Requests\Api\Content\UploadFolderRequest;
use App\Http\Resources\Api\Content\UploadResource;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class UploadController extends Controller
{
    protected $absolute_path;
    protected $relative_path;

    public function __construct()
    {
        /**
         * Root directory
         */
        $this->absolute_path = Str::finish(config('filesystems.disks.uploads.root'), '/');

        /**
         * Current directory
         */
        if (request('dir')) {
            $this->relative_path = Str::finish(request('dir'), '/');
            $this->absolute_path .= $this->relative_path;
        }
    }

    /**
     * Listing data
     *
     */
    public function index()
    {
        $finder = new Finder();
        $finder->name('*' . request('keyword') . '*');
        $finder->in($this->absolute_path)->depth(0);


        /**
         * Folders
         */
        $folders = collect($finder->directories()->sortByChangedTime()->reverseSorting());


        /**
         * Files
         */
        $files = collect($finder->files()->ignoreDotFiles(true)->ignoreVCS(true));


        /**
         * Operations for files
         */
        $files->each(function ($item, $key) use ($files) {
            /*
             * Filter files by kind
             * */
            if (
                array_key_exists(request('kind'), config('constants.uploads.kinds')) and
                !in_array($item->getExtension(), config('constants.uploads.kinds.' . request('kind')))
            ) {
                $files->pull($key);
            }
        });


        /**
         * All items
         */
        $items = $folders->merge($files);


        /**
         * Response structure
         */
        return UploadResource::collection($items->values()->paginate(40));
    }

    /**
     * Save the new files
     *
     * @param  \App\Http\Requests\Api\Content\UploadFileRequest  $request
     *
     */
    public function uploadFile(UploadFileRequest $request)
    {
        /**
         * Files
         */
        $files = collect($request->file('files'));


        /**
         * File operations
         */
        $files->each(function ($file) {

            /**
             * Clear filename
             */
            $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->extension();


            /**
             * Check the file if exists
             */
            if (Storage::disk('uploads')->exists($this->relative_path . $filename)) {
                $filename = Str::of($filename)->replaceLast('.', '-' . Str::random(3) . '.')->lower();
            }


            /**
             * Put the file on disk
             */
            Storage::disk('uploads')->put($this->relative_path . $filename, File::get($file));


            /**
             * Record the activity
             */
            $activity = new Activity;
            $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
            $activity->description = trans('api/activitiy.upload.create.file', [
                'name' => $filename
            ]);
            $activity->save();
        });

        return true;
    }

    /**
     * Create the new folder
     *
     * @param  \App\Http\Requests\Api\Content\UploadFolderRequest  $request
     * @param $id
     *
     */
    public function createFolder(UploadFolderRequest $request)
    {
        $finder = new Finder();


        /**
         * Create the folder
         */
        Storage::disk('uploads')->makeDirectory($this->relative_path . request('name'), 0777, true, true);


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.upload.create.folder', [
            'name' => request('name')
        ]);
        $activity->save();

        return new UploadResource(collect($finder->name(request('name'))->in($this->absolute_path))->first());
    }

    /**
     * Remove the item
     *
     *
     */
    public function remove()
    {
        /**
         * Item
         */
        $item = json_decode(request('item'));


        /**
         * Remove
         */
        if ($item->type == 'dir') {

            // Remove the original folder
            Storage::disk('uploads')->deleteDirectory($this->relative_path . $item->name);

            // Remove the folder containing resized items
            Storage::disk('images')->deleteDirectory($this->relative_path . $item->name);
        } else {

            /**
             * Get the resized images of the item
             */
            $resizeds = File::glob(Str::finish(config('filesystems.disks.images.root'), '/') . $this->relative_path . pathinfo($item->name, PATHINFO_FILENAME) . '-*');

            /**
             * Remove resized ones
             */
            File::delete($resizeds);

            /**
             * Remove original one
             */
            Storage::disk('uploads')->delete($this->relative_path . $item->name);
        }


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.upload.remove.' . $item->type, [
            'name' => $item->name,
        ]);
        $activity->save();

        return true;
    }
}
