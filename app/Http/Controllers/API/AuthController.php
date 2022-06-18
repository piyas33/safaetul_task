<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;

class AuthController extends BaseController
{

    public function register(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            $response = [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user_details' => $user
            ];

            return $this->sendResponse($response, 'Registration Successfuly.');
        } catch (\Exception $e) {

            return $this->sendError('Something Want Wrong!.', []);

        }


    }

    public function login(Request $request)
    {
        try {

            if (!Auth::attempt($request->only('email', 'password')))
            {
                return response()
                    ->json(['message' => 'Unauthorized'], 401);
            }

            $user = User::where('email', $request['email'])->firstOrFail();

            $token = $user->createToken('auth_token')->plainTextToken;

            $response = [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user_details' => $user
            ];
            return $this->sendResponse($response, 'Successful Login.');

        } catch (\Exception $e) {

            return $this->sendError('Something Want Wrong!.', []);

        }

    }

    // method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }

}
