<?php

namespace App\Http\Controllers\Api\v1\People;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\Users\UserRequest;
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
     * Activate an user
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
     * Deactivate an user
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
     * Remove an user
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Users\People\UserRequest  $request
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
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
     * Update the resource in storage
     *
     * @param  \App\Http\Requests\Users\UserRequest  $request
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if (!empty($request->password)) {
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $user->update($request->all());

        return $this->sendResponse($user, 'User Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('isAdmin');

        $user = User::findOrFail($id);
        // delete the user

        $user->delete();

        return $this->sendResponse([$user], 'User has been Deleted');
    }
}
