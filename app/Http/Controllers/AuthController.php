<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    //


    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request) {
        if (!$token = auth()->attempt($request->all())) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        return $this->createNewToken($token);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => ['email', 'required', 'unique:users', 'string'],
            'password' => ['min:8', 'max:64', 'required', 'string'],
            'number' => ['min:6', 'max:16', 'required', 'string'],
            'last_name' => ['required', 'max:128', 'min:2'],
            'first_name' => ['required', 'max:128', 'min:2']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
            $validator->validate(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'success' => 'true',
            'user' => $user
        ], 201);
    }

    public function logout() {
        auth()->logout();

        return response()->json([
            'success' => 'true'
        ]);
    }

    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    protected function createNewToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
