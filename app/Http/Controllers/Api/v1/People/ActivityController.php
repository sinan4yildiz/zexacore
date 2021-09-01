<?php

namespace App\Http\Controllers\Api\v1\People;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Http\Resources\Api\People\ActivityResource;
use Illuminate\Support\Facades\Request;

class ActivityController extends Controller
{
    protected $sortable = [
        'user'       => 'user',
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
        $activities = Activity::orderBy($this->sortable[request('sorted')] ?? $this->sorted, request('ordered', $this->ordered));


        /**
         * Filters
         */
        if (Request::filled('keyword')) {
            $activities->where(function ($query) {
                $query->orWhere('user', 'LIKE', '%' . Request::input('keyword') . '%')
                    ->orWhere('description', 'LIKE', '%' . Request::input('keyword') . '%');
            });
        }
        if (Request::filled('date-start')) {
            $activities->whereDate('created_at', '>=', Request::input('date-start'));
        }
        if (Request::filled('date-end')) {
            $activities->whereDate('created_at', '<=', Request::input('date-end'));
        }


        /**
         * Query
         */
        $activities = $activities->paginate(10);


        /**
         * Response structure
         */
        return ActivityResource::collection($activities)->additional([
            'meta' => [
                'sorting' => [
                    'sorted'   => request('sorted', $this->sorted),
                    'ordered'  => request('ordered', $this->ordered),
                    'sortable' => array_keys($this->sortable)
                ]
            ]
        ]);
    }
}
