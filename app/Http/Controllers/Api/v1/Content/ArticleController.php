<?php

namespace App\Http\Controllers\Api\v1\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Content\ArticleRequest;
use App\Http\Resources\Api\Content\ArticleAutocompleteResource;
use App\Http\Resources\Api\Content\ArticleResource;
use App\Models\Activity;
use App\Models\Article;
use App\Models\Relationship;
use App\Models\Slug;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
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
        $articles = Article::with(['category'])->orderBy($this->sortable[request('sorted')] ?? $this->sorted, request('ordered', $this->ordered));


        /**
         * Filters
         */
        $articles->where('content_type_id', (int) Request::input('content_type_id'));

        if (Request::filled('keyword')) {
            $articles->where('title', 'LIKE', '%' . Request::input('keyword') . '%');
        }
        if (Request::filled('language')) {
            $articles->where('language_code', Request::input('language'));
        } else {
            $articles->where('language_code', config('settings.default_language_code'));
        }
        if (Request::filled('status')) {
            $articles->where('is_active', (int) Request::input('status'));
        }
        if (Request::filled('date-start')) {
            $articles->whereDate('created_at', '>=', Request::input('date-start'));
        }
        if (Request::filled('date-end')) {
            $articles->whereDate('created_at', '<=', Request::input('date-end'));
        }


        /**
         * Query
         */
        $articles = $articles->paginate(10);


        /**
         * Response structure
         */
        return ArticleResource::collection($articles)->additional([
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
        $item = Article::with(['translation', 'translations', 'categories'])->findOrFail($id);


        /**
         * Response structure
         */
        return new ArticleResource($item);
    }

    /**
     * Create the new item
     *
     * @param  \App\Http\Requests\Api\Content\ArticleRequest  $request
     *
     */
    public function create(ArticleRequest $request)
    {
        /**
         * Store the item
         */
        $item = new Article();
        $item->title = request('title');
        $item->content = request('content');
        $item->image = request('image');
        $item->primary_category_id = request('categories.0', null);
        $item->meta_title = request('meta_title');
        $item->meta_description = request('meta_description');
        $item->meta_keywords = request('meta_keywords');
        $item->content_type_id = request('content_type_id');
        $item->is_active = request('is_active', true);
        $item->is_indexable = request('is_indexable', true);
        $item->language_code = request('language_code');
        $item->user_id = Auth::user()->id;
        $item->save();


        /**
         * Attach the translation
         */
        if (Request::filled('translation_id')) {

            // For the default langauge
            Article::attachTranslation($item->id, request('translation_id'), config('settings.default_language_code'));

            // For the updated item
            Article::attachTranslation(request('translation_id'), $item->id, $item->language_code);


            /**
             * For the other translations
             */
            foreach (Article::find(request('translation_id'))->translations as $translation) {
                Article::attachTranslation($translation->id, $item->id, $item->language_code);
                Article::attachTranslation($item->id, $translation->id, $translation->language_code);
            }
        }


        /**
         * Category relationships
         */
        foreach (request('categories') as $key => $category_id) {
            Relationship::create([
                'source_id' => $item->id,
                'target_id' => $category_id,
                'key'       => config('constants.relationships.category.article'),
            ]);
        }


        /**
         * Store the slug
         */
        $slug = new Slug();
        $slug->language_code = request('language_code');
        $slug->module = config('constants.slugs.module.article');
        $slug->keyword = request('slug', Str::slug($item->title) . $item->id);
        $slug->value = $item->id;
        $slug->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.article.create', [
            'title' => $item->title
        ]);
        $activity->save();

        return new ArticleResource($item);
    }

    /**
     * Update the existing item
     *
     * @param  \App\Http\Requests\Api\Content\ArticleRequest  $request
     * @param $id
     *
     */
    public function update(ArticleRequest $request, $id)
    {
        /**
         * Save the item data
         */
        $item = Article::findOrFail($id);
        $item->title = request('title');
        $item->content = request('content');
        $item->image = request('image');
        $item->primary_category_id = request('categories.0', null);
        $item->meta_title = request('meta_title');
        $item->meta_description = request('meta_description');
        $item->meta_keywords = request('meta_keywords');
        $item->is_indexable = request('is_indexable');
        $item->is_active = request('is_active');
        $item->save();


        /**
         * Attach the translation
         */
        if (Request::filled('translation_id')) {

            // For the default langauge
            Article::attachTranslation($item->id, request('translation_id'), config('settings.default_language_code'));

            // For the updated item
            Article::attachTranslation(request('translation_id'), $item->id, $item->language_code);


            /**
             * For the other translations
             */
            foreach (Article::find(request('translation_id'))->translations as $translation) {
                Article::attachTranslation($translation->id, $item->id, $item->language_code);
                Article::attachTranslation($item->id, $translation->id, $translation->language_code);
            }
        } elseif (Request::exists('translation_id')) {
            Article::detachTranslation($item);
        }


        /**
         * Remove category relationships
         */
        Relationship::where('source_id', $item->id)
            ->where('key', config('constants.relationships.category.article'))
            ->delete();


        /**
         * Category relationships
         */
        foreach (request('categories') as $key => $category_id) {
            Relationship::create([
                'source_id' => $item->id,
                'target_id' => $category_id,
                'key'       => config('constants.relationships.category.article'),
            ]);
        }


        /**
         * Save the slug
         */
        Slug::updateOrCreate(
            [
                'value'         => $item->id,
                'module'        => config('constants.slugs.module.article'),
                'language_code' => $item->language_code
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
        $activity->description = trans('api/activitiy.article.update', [
            'title' => request('title')
        ]);
        $activity->save();

        return new ArticleResource($item);
    }

    /**
     * Search results for the autocompletes
     *
     */
    public function autocomplete()
    {
        $items = Article::where('title', 'LIKE', '%' . request('keyword') . '%');


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
        return ArticleAutocompleteResource::collection($items);
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
        $item = Article::with('category')->findOrFail($id);
        $item->is_active = true;
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.article.activate', [
            'title' => $item->title,
        ]);
        $activity->save();

        return new ArticleResource($item);
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
        $item = Article::with('category')->findOrFail($id);
        $item->is_active = false;
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.article.deactivate', [
            'title' => $item->title,
        ]);
        $activity->save();

        return new ArticleResource($item);
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
        $item = Article::findOrFail($id);
        $item->delete();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.article.remove', [
            'title' => $item->title,
        ]);
        $activity->save();

        return new ArticleResource($item);
    }
}
