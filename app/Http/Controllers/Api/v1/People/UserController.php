<?php

namespace App\Http\Controllers\Api\v1\People;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\People\UserRequest;
use App\Http\Resources\People\UserResource;
use Illuminate\Support\Facades\Request;

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


    public function index()
    {
        $users = User::orderBy(
            $this->sortable[request('sorted')] ?? $this->sorted,
            request('ordered') ?? $this->ordered
        );

        if (Request::has('keyword')) {
            $users->where(function ($query) {
                $query->orWhere('firstname', 'LIKE', '%' . Request::input('keyword') . '%')
                    ->orWhere('lastname', 'LIKE', '%' . Request::input('keyword') . '%')
                    ->orWhere('email', 'LIKE', '%' . Request::input('keyword') . '%');
            });
        }

        if (Request::has('status')) {
            $users->where('is_active', (int) Request::input('status'));
        }

        if (Request::has('date-start')) {
            $users->whereDate('created_at', '>=', Request::input('date-start'));
        }

        if (Request::has('date-end')) {
            $users->whereDate('created_at', '<=', Request::input('date-end'));
        }

        $users = $users->paginate(10);

        /*sleep(3);*/

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
     * Store the new user
     *
     * @param  \App\Http\Requests\People\UserRequest  $request
     * @param $id
     *
     */
    public function store(UserRequest $request)
    {
        $user = User::create([
            'name'     => $request['name'],
            'email'    => $request['email'],
            'password' => Hash::make($request['password']),
            'type'     => $request['type'],
        ]);

        return $this->sendResponse($user, 'User Created Successfully');
    }

    /**
     * Update the existing user
     *
     * @param  \App\Http\Requests\People\UserRequest  $request
     * @param $id
     *
     */
    public function update(UserRequest $request, $id)
    {
        $item = User::findOrFail($id);

        if (Request::filled('password')) {
            $item->password = Hash::make($request->password);
        }

        $item->firstname = $request->firstname;
        $item->lastname = $request->lastname;
        $item->email = $request->email;
        $item->title = $request->title;
        $item->save();

        return new UserResource($item);
    }

    /**
     * Activate the user
     *
     * @param $id
     *
     */
    public function activate($id)
    {
        $item = User::findOrFail($id);
        $item->is_active = true;
        $item->save();

        return new UserResource($item);
    }

    /**
     * Deactivate the user
     *
     * @param $id
     *
     */
    public function deactivate($id)
    {
        $item = User::findOrFail($id);
        $item->is_active = false;
        $item->save();

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
        $item = User::findOrFail($id);
        $item->delete();

        return new UserResource($item);
    }
}
