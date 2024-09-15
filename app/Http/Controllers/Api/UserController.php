<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResponse;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $users = User::where('role', 'user')->get();
        return new ApiResponse($users);
    }

    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['message' => 'User not found!'], 404);
        }
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|string|min:4',
            'role' => 'nullable|string|in:user,admin'
        ]);

        if ($validator->fails()) {
            $firstError = $validator->errors()->first();

            $errorResponse = [
                'error' => $firstError,  // Get detailed error messages
                'code' => 400  // Bad Request
            ];
            // Return error response
            return new ApiResponse($errorResponse);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('phone') . "@gmail.com",
            'phone' => $request->input('phone'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role', 'user') // Default to 'user' if not provided
        ]);




        return new ApiResponse($user);




    }





    public function otp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return new ApiResponse(['error' => $validator->errors()->first(), 'code' => 422]);


        }

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {

            $user = User::create([
                'name' => $request->input('phone'),
                'email' => $request->input('phone') . "@gmail.com",
                'phone' => $request->input('phone'),
                'password' => bcrypt("1234"),
                'role' => $request->input('role', 'user') // Default to 'user' if not provided
            ]);



            //return new ApiResponse(['error' => 'User not found', 'code' => 404]);

        }

        // Generate a 4-digit OTP
        $otp = mt_rand(1000, 9999);

        // Update the user's password with the OTP
        $user->password = Hash::make($otp);
        $user->save();


        return new ApiResponse($otp);

    }

    public function loginWithPhone(Request $request)
    {
        $credentials = $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['phone' => $credentials['phone'], 'password' => $credentials['password']])) {
            $user = Auth::user();
            // Assuming you are using Sanctum for API token management
            $token = $user->createToken('authToken')->plainTextToken;


            return new ApiResponse([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user
            ]);



        }
        return new ApiResponse(['error' => 'Invalid credentials', 'code' => 401]);
    }


    // Method to get user info by token
    public function getUserInfoByToken(Request $request)
    {
        // This will return the authenticated user's info based on the token
        $user = $request->user(); // Uses Sanctum token

        if ($user) {
            return response()->json([
                'status' => 'success',
                'user' => $user,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated',
            ], 401);
        }
    }

    // Another example method (e.g., update user info)
    public function updateUserInfo(Request $request)
    {
        $user = $request->user();

        if ($user) {
            // Validate and update user data
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
            ]);

            $user->update($request->only('name', 'email'));

            return response()->json([
                'status' => 'success',
                'message' => 'User info updated successfully',
                'user' => $user,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated',
            ], 401);
        }
    }


    // Method to log out a user by invalidating their token
    public function logout(Request $request)
    {
        // Get the current token of the authenticated user
        $token = $request->user()->currentAccessToken();

        // Revoke/Delete the token
        $token->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully',
        ], 200);
    }

}