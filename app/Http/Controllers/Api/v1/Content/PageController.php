<?php

namespace App\Http\Controllers\Api\v1\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Content\PageRequest;
use App\Http\Resources\Content\PageAutocompleteResource;
use App\Http\Resources\Content\PageResource;
use App\Models\Activity;
use App\Models\Page;
use App\Models\Relationship;
use App\Models\Slug;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    protected $sortable = [
        'title'      => 'title',
        'views'      => 'views',
        'language'   => 'language_code',
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
        if (Request::filled('language_code')) {
            $pages->where('language_code', Request::input('language_code'));
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
        $item->title = request('title');
        $item->content = request('content');
        $item->image = request('image');
        $item->meta_title = request('meta_title');
        $item->meta_description = request('meta_description');
        $item->meta_keywords = request('meta_keywords');
        $item->is_active = request('is_active', true);
        $item->is_indexable = request('is_indexable', true);
        $item->user_id = Auth::user()->id;
        $item->language_code = request('language_code');
        $item->save();


        /**
         * Attach the translation
         */
        if (Request::filled('translation_id')) {
            $relationship = new Relationship();
            $relationship->sid = $item->id;
            $relationship->gid = request('translation_id');
            $relationship->key = config('constants.relationships.translation.page');
            $relationship->value = $item->language_code;
            $relationship->save();
        }


        /**
         * Store the slug
         */
        $slug = new Slug();
        $slug->language_code = request('language_code');
        $slug->module = config('constants.slugs.module.page');
        $slug->keyword = request('slug', Str::slug($item->title) . $item->id);
        $slug->value = $item->id;
        $slug->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('admin/activitiy.page.create', [
            'title' => $item->title
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
        $activity->description = trans('admin/activitiy.content_type.update', [
            'title' => request('title')
        ]);
        $activity->save();

        return new PageResource($item);
    }

    /**
     * Search results for the autocompletes
     *
     */
    public function autocomplete()
    {
        $items = Page::where('title', 'LIKE', '%' . request('keyword') . '%');


        /**
         * Filters
         */
        if (Request::filled('language_code')) {
            $items->where('language_code', request('language_code'));
        }


        /**
         * Query
         */
        $items = $items->paginate(5);


        /**
         * Response structure
         */
        return PageAutocompleteResource::collection($items);
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
        $activity->description = trans('admin/activitiy.page.activate', [
            'title' => $item->title,
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
        $activity->description = trans('admin/activitiy.page.deactivate', [
            'title' => $item->title,
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
        $item = Page::findOrFail($id);
        $item->delete();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('admin/activitiy.page.remove', [
            'title' => $item->title,
        ]);
        $activity->save();

        return new PageResource($item);
    }
}
