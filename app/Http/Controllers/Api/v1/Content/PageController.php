<?php

namespace App\Http\Controllers\Api\v1\Content;

use App\Http\Controllers\Controller;
use App\Http\Resources\Content\PageResource;
use App\Models\Activity;
use App\Models\Page;
use App\Models\Slug;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    protected $sortable = [
        'title'      => 'title',
        'views'      => 'views',
        'status'     => 'is_active',
        'created_at' => 'created_at'
    ];

    protected $sorted = 'created_at';
    protected $ordered = 'desc';

    /**
     * Listing data
     *
     */
    public function index()
    {
        $pages = Page::orderBy($this->sortable[request('sorted')] ?? $this->sorted, request('ordered', $this->ordered));


        /**
         * Filters
         */
        if (Request::filled('keyword')) {
            $pages->where('title', 'LIKE', '%' . Request::input('keyword') . '%');
        }
        if (Request::filled('status')) {
            $pages->where('is_active', (int) Request::input('status'));
        }
        if (Request::filled('date-start')) {
            $pages->whereDate('created_at', '>=', Request::input('date-start'));
        }
        if (Request::filled('date-end')) {
            $pages->whereDate('created_at', '<=', Request::input('date-end'));
        }


        /**
         * Query
         */
        $pages = $pages->paginate(10);


        /**
         * Response structure
         */
        return PageResource::collection($pages)->additional([
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
        $item = Page::with('translations')->findOrFail($id);


        /**
         * Response structure
         */
        return new PageResource($item);
    }

    /**
     * Create the new item
     *
     * @param  \App\Http\Requests\Content\PageRequest  $request
     *
     */
    public function create(PageRequest $request)
    {
        /**
         * Store the item
         */
        $item = new Page();
        $item->has_listing = request('has_listing', false);
        $item->is_indexable = request('is_indexable', true);
        $item->is_active = request('is_active', true);
        $item->sort_order = Page::max('sort_order') + 1;
        $item->save();


        /**
         * Store the translation
         */
        $translation = new PageTranslation();
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
            $slug->module = config('constant.slugs.module.content_type');
            $slug->keyword = request('slug', Str::slug($translation->title) . $item->id);
            $slug->value = $item->id;
            $slug->save();
        }


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('admin/activitiy.content_type.create', [
            'title' => request('title')
        ]);
        $activity->save();

        return new PageResource($item);
    }

    /**
     * Update the existing item
     *
     * @param  \App\Http\Requests\Content\PageRequest  $request
     * @param $id
     *
     */
    public function update(PageRequest $request, $id)
    {
        /**
         * Save the item data
         */
        $item = Page::findOrFail($id);
        $item->has_listing = request('has_listing', false);
        $item->is_indexable = request('is_indexable', true);
        $item->is_active = request('is_active', true);
        $item->save();


        /**
         * Save or create a new translation
         */
        $translation = PageTranslation::updateOrCreate(
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
            ['module', config('constant.slugs.module.content_type')],
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
            $slug->module = config('constant.slugs.module.content_type');
            $slug->keyword = request('slug', Str::slug($translation->title) . $item->id);
            $slug->value = $item->id;
            $slug->save();
        }


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('admin/activitiy.content_type.update', [
            'title' => request('title')
        ]);
        $activity->save();

        return new PageResource($item);
    }

    /**
     * Order the items
     *
     */
    public function order()
    {
        collect(request('orders'))->each(function ($order) {
            $item = Page::find($order['id']);

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
        $item = Page::findOrFail($id);
        $item->is_active = true;
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('admin/activitiy.content_type.activate', [
            'title' => $item->translation->title,
        ]);
        $activity->save();

        return new PageResource($item);
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
        $item = Page::findOrFail($id);
        $item->is_active = false;
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('admin/activitiy.content_type.deactivate', [
            'title' => $item->translation->title,
        ]);
        $activity->save();

        return new PageResource($item);
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
        $item = Page::with('translation')->findOrFail($id);
        $item->delete();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('admin/activitiy.content_type.remove', [
            'title' => $item->translation->title,
        ]);
        $activity->save();

        return new PageResource($item);
    }
}
