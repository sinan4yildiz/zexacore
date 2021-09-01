<?php

namespace App\Http\Controllers\Api\v1\System;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use App\Models\Language;
use App\Http\Requests\Api\System\LanguageRequest;
use App\Http\Resources\Api\System\LanguageResource;

class LanguageController extends Controller
{
    protected $sortable = [];

    protected $sorted = 'sort_order';
    protected $ordered = 'asc';

    /**
     * Listing data
     *
     */
    public function index()
    {
        $languages = Language::orderBy($this->sortable[request('sorted')] ?? $this->sorted, request('ordered', $this->ordered));


        /**
         * Query
         */
        $languages = $languages->paginate(10);


        /**
         * Response structure
         */
        return LanguageResource::collection($languages)->additional([
            'meta' => [
                'sorting' => [
                    'sorted'   => request('sorted', $this->sorted),
                    'ordered'  => request('ordered', $this->ordered),
                    'sortable' => array_keys($this->sortable)
                ]
            ]
        ]);
    }

    /**
     * Create the new item
     *
     * @param  \App\Http\Requests\Api\System\LanguageRequest  $request
     *
     */
    public function create(LanguageRequest $request)
    {
        /**
         * Store the item
         */
        $item = new Language;
        $item->name = request('name');
        $item->native = request('native');
        $item->code = request('code');
        $item->locale = request('locale');
        $item->sort_order = request('sort_order', 1);
        $item->is_active = true;
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.language.create', [
            'name' => request('name')
        ]);
        $activity->save();

        return new LanguageResource($item);
    }

    /**
     * Update the existing item
     *
     * @param  \App\Http\Requests\Api\System\LanguageRequest  $request
     * @param $id
     *
     */
    public function update(LanguageRequest $request, $id)
    {
        /**
         * Save the item data
         */
        $item = Language::findOrFail($id);
        $item->name = request('name');
        $item->native = request('native');
        $item->code = request('code');
        $item->locale = request('locale');
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.language.update', [
            'name' => request('name')
        ]);
        $activity->save();

        return new LanguageResource($item);
    }

    /**
     * Order the languages
     *
     */
    public function order()
    {
        collect(request('orders'))->each(function ($order) {
            $item = Language::find($order['id']);

            if ($item) {
                $item->sort_order = $order['order'];
                $item->save();
            }
        });
    }

    /**
     * Activate the item
     *
     * @param $id
     *
     */
    public function activate($id)
    {
        /**
         * Activate
         */
        $item = Language::findOrFail($id);
        $item->is_active = true;
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.language.activate', [
            'name' => $item->name,
        ]);
        $activity->save();

        return new LanguageResource($item);
    }

    /**
     * Deactivate the item
     *
     * @param $id
     *
     */
    public function deactivate($id)
    {
        /**
         * Deactivate
         */
        $item = Language::findOrFail($id);
        $item->is_active = false;
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.language.deactivate', [
            'name' => $item->name,
        ]);
        $activity->save();

        return new LanguageResource($item);
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
        $activity->description = trans('api/activitiy.language.remove', [
            'name' => $item->name,
        ]);
        $activity->save();

        return new LanguageResource($item);
    }
}
