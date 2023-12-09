<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

/**
 * @group Authentication
 */
class AuthController extends Controller
{
    /**
     * User Registration
     *
     * @bodyParam name string required The name of the user. Example: John Doe
     * @bodyParam email string required The email of the user. Example: johndoe@example.com
     * @bodyParam password string required The password of the user. Minimum 6 characters. Example: password
     * 
     * @response 200 scenario="success" {
     *  "user": {
     *      "name": "John Doe",
     *      "email": "johndoe@example.com"
     *  },
     *  "token": "2|FLkGJ329ucWJg5njvY5z78LZ3dOKxNEzr8zTHkSz"
     * }
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
    }

    /**
     * User Login
     *
     * @bodyParam email string required The email of the user. Example: johndoe@example.com
     * @bodyParam password string required The password of the user. Example: password
     * 
     * @response 200 scenario="success" {
     *  "user": {
     *      "name": "John Doe",
     *      "email": "johndoe@example.com"
     *  },
     *  "token": "2|FLkGJ329ucWJg5njvY5z78LZ3dOKxNEzr8zTHkSz"
     * }
     * @response 401 scenario="Unauthorized" {"message": "Invalid credentials"}
     */
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Check credentials
        if (!Auth::attempt($validatedData)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Issue token
        $token = $request->user()->createToken('API Token')->plainTextToken;

        // Response
        return response()->json([
            'user' => Auth::user(),
            'token' => $token
        ]);
    }

    /**
     * User Logout
     *
     * @authenticated
     * 
     * @response 200 scenario="success" {"message": "Successfully logged out"}
     */
    public function logout(Request $request)
    {
        // Revoke user's token
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
