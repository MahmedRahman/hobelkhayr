<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class UserLocationController extends Controller
{
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'device_token' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Ensure we're working with a fresh model instance
            $user = User::findOrFail($user->id);

            $user->latitude = $request->latitude;
            $user->longitude = $request->longitude;
            $user->device_token = $request->device_token;
            
            // Explicitly check if the model can be saved
            if (!$user->save()) {
                throw new \Exception('Failed to save user location');
            }

            return response()->json([
                'status' => true,
                'message' => 'Location updated successfully',
                'data' => [
                    'latitude' => $user->latitude,
                    'longitude' => $user->longitude
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while updating location',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
