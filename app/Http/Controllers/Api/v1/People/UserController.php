<?php

namespace App\Http\Controllers\Api\v1\People;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\People\UserRequest;
use App\Http\Resources\People\UserResource;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected $sortable = [
        'name'       => 'firstname',
        'email'      => 'email',
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
        $users = User::orderBy($this->sortable[request('sorted')] ?? $this->sorted, request('ordered', $this->ordered));


        /**
         * Filters
         */
        if (Request::filled('keyword')) {
            $users->where(function ($query) {
                $query->orWhere('firstname', 'LIKE', '%' . Request::input('keyword') . '%')
                    ->orWhere('lastname', 'LIKE', '%' . Request::input('keyword') . '%')
                    ->orWhere('email', 'LIKE', '%' . Request::input('keyword') . '%');
            });
        }
        if (Request::filled('status')) {
            $users->where('is_active', (int) Request::input('status'));
        }
        if (Request::filled('date-start')) {
            $users->whereDate('created_at', '>=', Request::input('date-start'));
        }
        if (Request::filled('date-end')) {
            $users->whereDate('created_at', '<=', Request::input('date-end'));
        }


        /**
         * Query
         */
        $users = $users->paginate(10);


        /**
         * Response structure
         */
        return UserResource::collection($users)->additional([
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
     * @param  \App\Http\Requests\People\UserRequest  $request
     *
     */
    public function create(UserRequest $request)
    {
        /**
         * Store the user
         */
        $item = new User;
        $item->firstname = request('firstname');
        $item->lastname = request('lastname');
        $item->email = request('email');
        $item->title = request('title');
        $item->password = Hash::make(request('password'));
        $item->api_token = Str::random(32);
        $item->is_active = true;
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('admin/activitiy.user.create', [
            'firstname' => request('firstname'),
            'lastname'  => request('lastname')
        ]);
        $activity->save();

        return new UserResource($item);
    }

    /**
     * Update the existing item
     *
     * @param  \App\Http\Requests\People\UserRequest  $request
     * @param $id
     *
     */
    public function update(UserRequest $request, $id)
    {
        /**
         * Save the item data
         */
        $item = User::findOrFail($id);
        if (Request::filled('password')) {
            $item->password = Hash::make(request('password'));
        }
        $item->firstname = request('firstname');
        $item->lastname = request('lastname');
        $item->email = request('email');
        $item->title = request('title');
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;

        if (Auth::user()->id == $id) {
            $activity->description = trans('admin/activitiy.user.update_own');
        } else {
            $activity->description = trans('admin/activitiy.user.update', [
                'firstname' => request('firstname'),
                'lastname'  => request('lastname')
            ]);
        }
        $activity->save();

        return new UserResource($item);
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
        $item = User::findOrFail($id);
        $item->is_active = true;
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('admin/activitiy.user.activate', [
            'firstname' => $item->firstname,
            'lastname'  => $item->lastname
        ]);
        $activity->save();

        return new UserResource($item);
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
        $item = User::findOrFail($id);
        $item->is_active = false;
        $item->save();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('admin/activitiy.user.deactivate', [
            'firstname' => $item->firstname,
            'lastname'  => $item->lastname
        ]);
        $activity->save();

        return new UserResource($item);
    }

    /**
     * Remove the user
     *
     * @param $id
     *
     */
    public function remove($id)
    {
        /**
         * Remove
         */
        $item = User::findOrFail($id);
        $item->delete();


        /**
         * Record the activity
         */
        $activity = new Activity;
        $activity->user = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $activity->description = trans('admin/activitiy.user.remove', [
            'firstname' => $item->firstname,
            'lastname'  => $item->lastname
        ]);
        $activity->save();

        return new UserResource($item);
    }
}
