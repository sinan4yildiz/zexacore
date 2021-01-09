<?php

namespace App\Http\Controllers\Api\v1\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Content\UploadFolderRequest;
use App\Http\Resources\Content\UploadResource;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;

class UploadController extends Controller
{
    protected $directory = null;

    public function __construct()
    {
        /**
         * Current directory
         */
        $this->directory = public_path('uploads/');

        if (request('dir')) {
            $this->directory .= request('dir') . '/';
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
        $folders = collect($finder->directories()->name('*' . request('keyword') . '*')->in($this->directory)->depth(0)->sortByModifiedTime());


        /**
         * Files
         */
        $files = collect($finder->files()->name('*' . request('keyword') . '*')->ignoreDotFiles(true)->ignoreVCS(true)->in($this->directory)->depth(0)->sortByModifiedTime());


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
     * Save the new file
     *
     * @param  \App\Http\Requests\Content\UploadFileRequest  $request
     *
     */
    public function uploadFile(UploadFileRequest $request)
    {
        /**
         * Save the item
         */
        $item = [];


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('admin/activitiy.upload.create', [
            'name' => request('name')
        ]);
        $activity->save();

        return new LanguageResource($item);
    }

    /**
     * Create the new folder
     *
     * @param  \App\Http\Requests\Content\UploadFileRequest  $request
     * @param $id
     *
     */
    public function createFolder(UploadFolderRequest $request)
    {
        $finder = new Finder();


        /**
         * Create the folder
         */
        File::makeDirectory($this->directory . request('name'), 0777, true, true);


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('admin/activitiy.upload.create.folder', [
            'name' => request('name')
        ]);
        $activity->save();

        return new UploadResource(collect($finder->name(request('name'))->in($this->directory))->first());
    }

    /**
     * Remove the item
     *
     * @param $id
     *
     */
    public function remove($id)
    {
        /**
         * Remove
         */
        $item = Language::findOrFail($id);
        $item->delete();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('admin/activitiy.language.remove', [
            'name' => $item->name,
        ]);
        $activity->save();

        return new LanguageResource($item);
    }
}
