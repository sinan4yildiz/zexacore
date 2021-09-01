<?php

namespace App\Http\Controllers\Api\v1\Tools;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Tools\RedirectionRequest;
use App\Http\Resources\Api\Tools\RedirectionResource;
use App\Models\Activity;
use App\Models\Redirection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class RedirectionController extends Controller
{
    protected $sortable = [
        'from'       => 'from',
        'count'      => 'count',
        'updated_at' => 'updated_at',
    ];

    protected $sorted = 'updated_at';
    protected $ordered = 'desc';

    /**
     * Listing data
     *
     */
    public function index()
    {
        $redirections = Redirection::orderBy($this->sortable[request('sorted')] ?? $this->sorted, request('ordered', $this->ordered));


        /**
         * Filters
         */
        if (Request::filled('keyword')) {
            $redirections->where(function ($query) {
                $query->orWhere('from', 'LIKE', '%' . Request::input('keyword') . '%')
                    ->orWhere('to', 'LIKE', '%' . Request::input('keyword') . '%');
            });
        }


        /**
         * Query
         */
        $redirections = $redirections->paginate(10);


        /**
         * Response structure
         */
        return RedirectionResource::collection($redirections)->additional([
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
     * @param  \App\Http\Requests\Api\Tools\RedirectionRequest  $request
     *
     */
    public function create(RedirectionRequest $request)
    {
        /**
         * Store the item
         */
        $item = new Redirection;
        $item->from = request('from');
        $item->to = request('to');
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.redirection.create', [
            'url' => request('from'),
        ]);
        $activity->save();

        return new RedirectionResource($item);
    }

    /**
     * Update the existing item
     *
     * @param  \App\Http\Requests\Api\Tools\RedirectionRequest  $request
     * @param $id
     *
     */
    public function update(RedirectionRequest $request, $id)
    {
        /**
         * Save the item data
         */
        $item = Redirection::findOrFail($id);
        $item->to = request('to');
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.redirection.update', [
            'url' => request('from'),
        ]);
        $activity->save();

        return new RedirectionResource($item);
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
        $item = Redirection::findOrFail($id);
        $item->delete();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.redirection.remove', [
            'url' => request('from'),
        ]);
        $activity->save();

        return new RedirectionResource($item);
    }
}
