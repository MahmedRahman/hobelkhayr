<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Psy\Readline\Hoa\Console;

class AuthController extends Controller
{
    /**
     * Handle user login.
     */


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('admin')->with('swal-success', 'Login Successful!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ])->with('swal-error', 'The provided credentials do not match our records.'); // Use this line
    }


    public function otp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|exists:users,phone',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Generate a 4-digit OTP
        $otp = mt_rand(1000, 9999);

        // Update the user's password with the OTP
        $user->password = Hash::make($otp);
        $user->save();

        // Return the OTP
        return response()->json([
            'message' => 'OTP generated and password updated successfully',
            'otp' => $otp
        ]);
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

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user
            ]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    /**
     * Get the authenticated User.
     */
    public function user()
    {
        return response()->json(Auth::user());
    }
}