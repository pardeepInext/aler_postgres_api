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

    public function verifyPassword($id, Request $request)
    {
        $user = User::find($id);
        return ['status' => Hash::check($request->password, $user->password)];
    }

    public function updateProfile($id, Request $request)
    {

        $user =  User::find($id);

        $validateArr = ['name' => 'required'];
        $updateUser = $request->only('name');

        if ($request->has('email')) {
            $updateUser['email'] = $request->email;
            $validateArr['email'] = 'email|unique:users,email,' . $user->id;
        }
        $validator = Validator::make($request->all(), $validateArr);

        if ($validator->fails())
            return ['success' => false, 'errors' => $validator->errors()];

        
       



        if ($request->has('password'))
            $updateUser['password'] = Hash::make($request->password);

        if ($request->has('image')) {
            if ($user->image_name != "" && file_exists(public_path("uploads/" . $user->image_name)))
                unlink(public_path("uploads/" . $user->image_name));
            $updateUser['image_name']  = $user->id . "_profile_" . time() . "." . $request->image->extension();
            $request->image->move(public_path('uploads'), $updateUser['image_name']);
        }

        $update =  $user->update($updateUser);
        if ($update) {
            $updatedUser = User::find($id);
            return response(['success' => true, 'message' => "user is updated!", "user" => $updatedUser]);
        }
    }
}
