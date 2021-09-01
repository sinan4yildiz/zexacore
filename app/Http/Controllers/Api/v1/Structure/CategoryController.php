<?php

namespace App\Http\Controllers\Api\v1\Structure;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Structure\CategoryRequest;
use App\Http\Resources\Api\Structure\CategoryAutocompleteResource;
use App\Http\Resources\Api\Structure\CategoryResource;
use App\Models\Activity;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Slug;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
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
        $items = Category::with('translations');


        /**
         * Parent filter
         */
        $items->where('parent_id', (int) Request::input('parent_id') ?? 0);


        /**
         * Content type filter
         */
        if (!Request::filled('parent_id')) {
            $items->where('content_type_id', (int) Request::input('content_type_id'));
        }


        /**
         * Query
         */
        $items = $items->orderBy($this->sortable[request('sorted')] ?? $this->sorted, request('ordered', $this->ordered))->paginate(10);


        /**
         * Response structure
         */
        return CategoryResource::collection($items)->additional([
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
        $item = Category::with(['translations', 'parent'])->findOrFail($id);


        /**
         * Response structure
         */
        return new CategoryResource($item);
    }

    /**
     * Get the parent category with all parents of itself
     *
     */
    public function parent($id)
    {
        /**
         * Query
         */
        $item = Category::findOrFail($id);


        /**
         * With all parents of itself
         */
        $item->with_parents = true;


        /**
         * Response structure
         */
        return new CategoryResource($item);
    }

    /**
     * Create the new item
     *
     * @param  \App\Http\Requests\Api\Structure\CategoryRequest  $request
     *
     */
    public function create(CategoryRequest $request)
    {
        /**
         * Store the item
         */
        $item = new Category();
        $item->parent_id = request('parent_id', 0);
        $item->content_type_id = request('content_type_id');
        $item->is_active = request('is_active', true);
        $item->sort_order = Category::max('sort_order') + 1;
        $item->save();


        /**
         * Store the translation
         */
        $translation = new CategoryTranslation();
        $translation->category_id = $item->id;
        $translation->language_code = request('language_code');
        $translation->title = request('title');
        $translation->description = request('description');
        $translation->meta_title = request('meta_title');
        $translation->meta_description = request('meta_description');
        $translation->meta_keywords = request('meta_keywords');
        $translation->save();


        /**
         * Load translations relationship
         */
        $item->load('translations');


        /**
         * Store the slug
         */
        $slug = new Slug();
        $slug->language_code = request('language_code');
        $slug->module = config('constants.slugs.module.category');
        $slug->keyword = request('slug', Str::slug($translation->title) . $item->id);
        $slug->value = $item->id;
        $slug->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.category.create', [
            'title' => request('title')
        ]);
        $activity->save();

        return new CategoryResource($item);
    }

    /**
     * Update the existing item
     *
     * @param  \App\Http\Requests\Api\Structure\CategoryRequest  $request
     * @param $id
     *
     */
    public function update(CategoryRequest $request, $id)
    {
        /**
         * Save the item data
         */
        $item = Category::with('translations')->findOrFail($id);

        if (Request::filled('parent_id')) {
            $item->parent_id = (int) request('parent_id');
        }

        $item->is_active = request('is_active', true);
        $item->save();


        /**
         * Save or create a new translation
         */
        $translation = CategoryTranslation::updateOrCreate(
            [
                'category_id'   => $item->id,
                'language_code' => request('language_code')
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
         * Save the slug
         */
        Slug::updateOrCreate(
            [
                'value'         => $item->id,
                'module'        => config('constants.slugs.module.category'),
                'language_code' => $translation->language_code
            ],
            [
                'keyword' => request('slug'),
            ]
        );


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.category.update', [
            'title' => request('title')
        ]);
        $activity->save();

        return new CategoryResource($item->refresh());
    }

    /**
     * Search results for the autocompletes
     *
     */
    public function autocomplete()
    {
        $items = Category::orderBy('parent_id', 'ASC');

        $items->whereHas('translation', function ($query) {
            if (Request::filled('keyword')) {
                $query->where('title', 'LIKE', '%' . Request::input('keyword') . '%');
            } else {
                $query->where('parent_id', 0);
            }
        });


        /**
         * Content type filter
         */
        if (Request::filled('content_type_id')) {
            $items->where('content_type_id', (int) Request::input('content_type_id'));
        }


        /**
         * Query
         */
        $items = $items->paginate(5);


        /**
         * Response structure
         */
        return CategoryAutocompleteResource::collection($items);
    }

    /**
     * Order the items
     *
     */
    public function order()
    {
        collect(request('orders'))->each(function ($order) {
            $item = Category::find($order['id']);

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
        $item = Category::with('translations')->findOrFail($id);
        $item->is_active = true;
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.category.activate', [
            'title' => $item->translation->title,
        ]);
        $activity->save();

        return new CategoryResource($item);
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
        $item = Category::with('translations')->findOrFail($id);
        $item->is_active = false;
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.category.deactivate', [
            'title' => $item->translation->title,
        ]);
        $activity->save();

        return new CategoryResource($item);
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
        $item = Category::with('translation')->findOrFail($id);
        $item->delete();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.category.remove', [
            'title' => $item->translation->title,
        ]);
        $activity->save();

        return new CategoryResource($item);
    }
}
