<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\MessageResource;
use App\Models\Activity;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class MessageController extends Controller
{
    protected $sortable = [
        'subject'    => 'subject',
        'unread'     => 'unread',
        'created_at' => 'created_at'
    ];

    protected $sorted = 'unread';
    protected $ordered = 'desc';

    /**
     * Listing data
     *
     */
    public function index()
    {
        $messages = Message::orderBy($this->sortable[request('sorted')] ?? $this->sorted, request('ordered', $this->ordered))->orderBy('created_at', 'desc');


        /**
         * Filters
         */
        if (Request::filled('keyword')) {
            $messages->where(function ($query) {
                $query->orWhere('subject', 'LIKE', '%' . Request::input('keyword') . '%')
                    ->orWhere('name', 'LIKE', '%' . Request::input('keyword') . '%')
                    ->orWhere('email', 'LIKE', '%' . Request::input('keyword') . '%')
                    ->orWhere('telephone', 'LIKE', '%' . Request::input('keyword') . '%');
            });
        }
        if (Request::filled('unread')) {
            $messages->where('unread', (int) Request::input('unread'));
        }
        if (Request::filled('date-start')) {
            $messages->whereDate('created_at', '>=', Request::input('date-start'));
        }
        if (Request::filled('date-end')) {
            $messages->whereDate('created_at', '<=', Request::input('date-end'));
        }


        /**
         * Query
         */
        $messages = $messages->paginate(10);


        /**
         * Response structure
         */
        return MessageResource::collection($messages)->additional([
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
     * Mark as unread
     *
     * @param $id
     *
     */
    public function markAsUnread($id)
    {
        /**
         * Update
         */
        $item = Message::findOrFail($id);
        $item->unread = true;
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.message.unread', [
            'subject' => $item->subject,
        ]);
        $activity->save();

        return new MessageResource($item);
    }

    /**
     * Mark as read
     *
     * @param $id
     *
     */
    public function markAsRead($id)
    {
        /**
         * Update
         */
        $item = Message::findOrFail($id);
        $item->unread = false;
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.message.read', [
            'subject' => $item->subject,
        ]);
        $activity->save();

        return new MessageResource($item);
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
        $item = Message::findOrFail($id);
        $item->delete();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('api/activitiy.message.remove', [
            'subject' => $item->subject,
        ]);
        $activity->save();

        return new MessageResource($item);
    }
}
