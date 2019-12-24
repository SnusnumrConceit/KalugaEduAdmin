<?php
declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserService
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) : JsonResponse
    {
        $users = User::paginate();

        return response()->json([
            'users' => $users
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() : JsonResponse
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request) : JsonResponse
    {
        $user = $request->validated();
        unset($user['password_confirmation']);

        User::create($user);

        return response()->json([
            'status' => 'success',
            'msg' => __('user_msg_success_create')
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) : JsonResponse
    {
        return response()->json([
            'user' => $user
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) : JsonResponse
    {
        return response()->json([
            'user' => $user
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user) : JsonResponse
    {
        $user->update($request->validated());

        return response()->json([
            'status' => 'success',
            'msg' => __('user_msg_success_update')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) : JsonResponse
    {
        $user->delete($user->id);

        return response()->json([
            'status' => 'success',
            'msg' => __('user_msg_success_delete')
        ], 200);
    }

    public function search(Request $request) : JsonResponse
    {
        $users = User::when(! empty($request->keyword), function ($q) use ($request) {
            $q->where('login', 'LIKE', '%' . $request->keyword . '%')
                ->OrWhere('email', 'LIKE', '%' . $request->keyword . '%');
        })->paginate();

        return response()->json([
            'users' => $users
        ], 200);
    }
}