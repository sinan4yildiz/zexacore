<?php

namespace App\Http\Controllers\Api\v1\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Content\UploadFolderRequest;
use App\Http\Resources\Content\UploadResource;
use App\Models\Activity;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * Listing data
     *
     */
    public function index()
    {
        $uploads = new Collection();

        $uploads->push((object) [
            'name' => 'abc.jpg',
            'type' => 'jpg',
        ]);

        /**
         * Response structure
         */
        return UploadResource::collection($uploads);
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
        /**
         * Item
         */
        $item = (object) [
            'name' => request('name'),
            'type' => 'folder',
        ];


        /**
         * Create the folder
         */
        Storage::makeDirectory('public/' . request('name'), 0777, true, true);


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('admin/activitiy.upload.create.folder', [
            'name' => request('name')
        ]);
        $activity->save();

        return new UploadResource($item);
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
