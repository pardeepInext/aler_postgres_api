<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $validator = Validator::Make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails())
            return response(['success' => false, 'errors' => $validator->errors()],401);

        $user = User::where('email', $request->email)->first();

        if (!$user)
            return response(['success' => false, 'errors' => ['email' =>
            "your email is not matched with our records"]]);

        if (Hash::check($request->password, $user->password))
            return response(['success' => false, 'errors' => ['password' =>
            "password is incorrect"]]);

        $user['token'] = $user->createToken($user->name)->plainTextToken;

        return response(['success' => true, 'user' => $user]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])/',
        ], [
            'password.regex' => "password must have atlease one numeric,spacial character,uppercase"
        ]);

        if ($validator->fails())
            return response(['success' => false, 'errors' => $validator->errors()]);

        $user = User::create($request->only('email', 'password', 'name'));

        $user['token'] = $user->createToken($user->name)->plainTextToken;
        return response(['success' => true, 'user' => $user]);
    }
}
