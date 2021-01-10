<?php

namespace App\Http\Controllers\Api\v1\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Content\UploadFileRequest;
use App\Http\Requests\Content\UploadFolderRequest;
use App\Http\Resources\Content\UploadResource;
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
        $this->absolute_path = Str::finish(config('filesystems.disks.public.root'), '/');

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


        /**
         * Folders
         */
        $folders = collect($finder->directories()->name('*' . request('keyword') . '*')->in($this->absolute_path)->depth(0)->sortByChangedTime()->reverseSorting());


        /**
         * Files
         */
        $files = collect($finder->files()->name('*' . request('keyword') . '*')->ignoreDotFiles(true)->ignoreVCS(true)->in($this->absolute_path)->depth(0)->sortByModifiedTime()->reverseSorting());


        /**
         * Operations for files
         */
        $files->each(function ($item) {
            /*
             * Generate thumbnail
             * */
            if (in_array($item->getExtension(), ['svg', 'jpg', 'jpeg', 'png'])) {
                $item->thumbnail = Storage::disk('public')->url($this->relative_path . $item->getBasename());
            }

            /*
             * Preview link
             * */
            if (in_array($item->getExtension(), ['pdf', 'txt', 'svg', 'jpg', 'jpeg', 'png'])) {
                $item->preview = Storage::disk('public')->url($this->relative_path . $item->getBasename());
            }
        });


        /**
         * All items
         */
        $items = $folders->merge($files);


        /**
         * Response structure
         */
        return UploadResource::collection($items->values()->paginate(50));
    }

    /**
     * Save the new files
     *
     * @param  \App\Http\Requests\Content\UploadFileRequest  $request
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
            if (Storage::disk('public')->exists($this->relative_path . $filename)) {
                $filename = Str::of($filename)->replaceLast('.', '-' . Str::random(3) . '.')->lower();
            }


            /**
             * Put the file on disk
             */
            Storage::disk('public')->put($this->relative_path . $filename, File::get($file));


            /**
             * Record the activity
             */
            $activity = new Activity;
            $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
            $activity->description = trans('admin/activitiy.upload.create.file', [
                'name' => $filename
            ]);
            $activity->save();
        });

        return true;
    }

    /**
     * Create the new folder
     *
     * @param  \App\Http\Requests\Content\UploadFolderRequest  $request
     * @param $id
     *
     */
    public function createFolder(UploadFolderRequest $request)
    {
        $finder = new Finder();


        /**
         * Create the folder
         */
        Storage::disk('public')->makeDirectory($this->relative_path . request('name'), 0777, true, true);


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('admin/activitiy.upload.create.folder', [
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
        $finder = new Finder();


        /**
         * Item
         */
        $item = json_decode(request('item'));


        /**
         * Remove
         */
        if ($item->type == 'dir') {
            Storage::disk('public')->deleteDirectory($this->relative_path . $item->name);
        } else {
            Storage::disk('public')->delete($this->relative_path . $item->name);
        }


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('admin/activitiy.upload.remove.' . $item->type, [
            'name' => $item->name,
        ]);
        $activity->save();

        return true;
    }
}
