<?php

namespace App\Http\Controllers\Api\v1\Tools;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Slug;
use App\Http\Requests\Api\Tools\SlugRequest;
use App\Http\Resources\Api\Tools\SlugResource;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class SlugController extends Controller
{
    protected $sortable = [
        'keyword'  => 'keyword',
        'language' => 'language_code',
        'module'   => 'module',
    ];

    protected $sorted = 'id';
    protected $ordered = 'desc';

    /**
     * Listing data
     *
     */
    public function index()
    {
        $slugs = Slug::orderBy($this->sortable[request('sorted')] ?? $this->sorted, request('ordered', $this->ordered));


        /**
         * Filters
         */
        if (Request::filled('keyword')) {
            $slugs->where('keyword', 'LIKE', '%' . Request::input('keyword') . '%');
        }


        /**
         * Query
         */
        $slugs = $slugs->paginate(10);


        /**
         * Response structure
         */
        return SlugResource::collection($slugs)->additional([
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
     * Update the existing item
     *
     * @param  \App\Http\Requests\Api\Tools\SlugRequest  $request
     * @param $id
     *
     */
    public function update(SlugRequest $request, $id)
    {
        /**
         * Save the item data
         */
        $item = Slug::findOrFail($id);
        $item->keyword = request('keyword');
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.slug.update', [
            'keyword' => $item->keyword,
        ]);
        $activity->save();

        return new SlugResource($item);
    }
}
