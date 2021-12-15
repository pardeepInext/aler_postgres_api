<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::query();

        if ($request->roleId != '')
            $user->where('role_id', $request->roleId);

        $user->with('role:id,name')->orderBy('id', 'desc');;
        return $user->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required',
        ]);

        if ($validator->fails())
            return ['success' => false, 'errors' => $validator->errors()];

        $insert = $request->only('name', 'email', 'role_id');
        $insert['password'] = Hash::make('12345678');
        $user = User::create($insert);

        if ($user)
            return ['success' => true, 'message' => "user is added"];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user->load('role:id,name');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required',
        ]);

        if ($validator->fails())
            return ['success' => false, 'errors' => $validator->errors()];

        $user->update($request->only('name', 'email', 'role_id'));

        if ($user)
            return ['success' => true, 'message' => "user is added"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $delete =  $user->delete();
        return ['success' => true];
    }
}
