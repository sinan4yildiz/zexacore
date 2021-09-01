<?php

namespace App\Http\Controllers\Api\v1\Structure;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ContentTypeTranslation;
use App\Models\Slug;
use Illuminate\Support\Facades\Auth;
use App\Models\ContentType;
use App\Http\Requests\Api\Structure\ContentTypeRequest;
use App\Http\Resources\Api\Structure\ContentTypeResource;
use Illuminate\Support\Str;

class ContentTypeController extends Controller
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
        $items = ContentType::with('translation');


        /**
         * Query
         */
        $items = $items->orderBy($this->sortable[request('sorted')] ?? $this->sorted, request('ordered', $this->ordered))->paginate(10);


        /**
         * Response structure
         */
        return ContentTypeResource::collection($items)->additional([
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
     * Get a specific data
     *
     */
    public function single($id)
    {
        /**
         * Query
         */
        $item = ContentType::with('translations')->findOrFail($id);


        /**
         * Response structure
         */
        return new ContentTypeResource($item);
    }

    /**
     * Create the new item
     *
     * @param  \App\Http\Requests\Api\Structure\ContentTypeRequest  $request
     *
     */
    public function create(ContentTypeRequest $request)
    {
        /**
         * Store the item
         */
        $item = new ContentType();
        $item->has_listing = request('has_listing', false);
        $item->is_indexable = request('is_indexable', true);
        $item->is_active = request('is_active', true);
        $item->sort_order = ContentType::max('sort_order') + 1;
        $item->save();


        /**
         * Store the translation
         */
        $translation = new ContentTypeTranslation();
        $translation->content_type_id = $item->id;
        $translation->language_code = request('language_code');
        $translation->title = request('title');
        $translation->description = request('description');
        $translation->meta_title = request('meta_title');
        $translation->meta_description = request('meta_description');
        $translation->meta_keywords = request('meta_keywords');
        $translation->save();


        /**
         * Store the slug
         */
        if ($request->has_listing) {
            $slug = new Slug();
            $slug->language_code = request('language_code');
            $slug->module = config('constants.slugs.module.content_type');
            $slug->keyword = request('slug', Str::slug($translation->title) . $item->id);
            $slug->value = $item->id;
            $slug->save();
        }


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.content_type.create', [
            'title' => request('title')
        ]);
        $activity->save();

        return new ContentTypeResource($item);
    }

    /**
     * Update the existing item
     *
     * @param  \App\Http\Requests\Api\Structure\ContentTypeRequest  $request
     * @param $id
     *
     */
    public function update(ContentTypeRequest $request, $id)
    {
        /**
         * Save the item data
         */
        $item = ContentType::findOrFail($id);
        $item->has_listing = request('has_listing', false);
        $item->is_indexable = request('is_indexable', true);
        $item->is_active = request('is_active', true);
        $item->save();


        /**
         * Save or create a new translation
         */
        $translation = ContentTypeTranslation::updateOrCreate(
            [
                'content_type_id' => $item->id,
                'language_code'   => request('language_code')
            ],
            [
                'title'            => request('title'),
                'description'      => request('description'),
                'meta_title'       => request('meta_title'),
                'meta_description' => request('meta_description'),
                'meta_keywords'    => request('meta_keywords'),
            ]
        );


        /**
         * Remove the existing slug
         */
        $_slug = Slug::where([
            ['value', $item->id],
            ['module', config('constants.slugs.module.content_type')],
        ]);
        if ($item->has_listing) {
            $_slug->where('language_code', $translation->language_code);
        }
        $_slug->delete();

        /**
         * Save the slug
         */
        if ($request->has_listing) {
            $slug = new Slug();
            $slug->language_code = $translation->language_code;
            $slug->module = config('constants.slugs.module.content_type');
            $slug->keyword = request('slug', Str::slug($translation->title) . $item->id);
            $slug->value = $item->id;
            $slug->save();
        }


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.content_type.update', [
            'title' => request('title')
        ]);
        $activity->save();

        return new ContentTypeResource($item);
    }

    /**
     * Order the items
     *
     */
    public function order()
    {
        collect(request('orders'))->each(function ($order) {
            $item = ContentType::find($order['id']);

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
        $item = ContentType::findOrFail($id);
        $item->is_active = true;
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.content_type.activate', [
            'title' => $item->translation->title,
        ]);
        $activity->save();

        return new ContentTypeResource($item);
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
        $item = ContentType::findOrFail($id);
        $item->is_active = false;
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.content_type.deactivate', [
            'title' => $item->translation->title,
        ]);
        $activity->save();

        return new ContentTypeResource($item);
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
        $item = ContentType::with('translation')->findOrFail($id);
        $item->delete();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.content_type.remove', [
            'title' => $item->translation->title,
        ]);
        $activity->save();

        return new ContentTypeResource($item);
    }
}
