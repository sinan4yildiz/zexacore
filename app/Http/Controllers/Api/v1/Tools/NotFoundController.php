<?php

namespace App\Http\Controllers\Api\v1\Tools;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Tools\NotFoundResource;
use App\Models\Activity;
use App\Models\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class NotFoundController extends Controller
{
    protected $sortable = [
        'uri'        => 'uri',
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
        $not_founds = NotFound::orderBy($this->sortable[request('sorted')] ?? $this->sorted, request('ordered', $this->ordered));


        /**
         * Filters
         */
        if (Request::filled('keyword')) {
            $not_founds->where('uri', 'LIKE', '%' . Request::input('keyword') . '%');
        }


        /**
         * Query
         */
        $not_founds = $not_founds->paginate(10);


        /**
         * Response structure
         */
        return NotFoundResource::collection($not_founds)->additional([
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
        $item = NotFound::findOrFail($id);
        $item->delete();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.not_found.remove', [
            'url' => Str::start($item->uri, '/'),
        ]);
        $activity->save();

        return new NotFoundResource($item);
    }
}
