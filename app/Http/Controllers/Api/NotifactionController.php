<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResponse;
use App\Models\Notifaction;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class NotifactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id = null) // Default to null if no ID is provided
    {
        if ($id) {
            // Fetch notifications for a specific user
            $notifications = Notifaction::where('user_id', $id)->get();
        } else {
            // Fetch all notifications
            $notifications = Notifaction::all();
        }
        return new ApiResponse($notifications);
    }

    public function store(Request $request)
    {
        // Validate the request input
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:255',
            'data' => 'required|string|max:255', // Add validation for the data field
            'user_id' => 'required|string|max:255',
        ]);

        try {
            // Create the notification

            Notifaction::create([
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'data' => $request->input(key: 'data'), // Ensure you include the data field
                'user_id' => $request->input('user_id'),
            ]);
            // Return success response
            return response()->json([
                'success' => 'Notification added successfully!'
            ], 201); // 201 Created
        } catch (Exception $e) {
            // Log the exception for debugging purposes (optional)
            \Log::error('Notification creation failed: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'error' => $e,
                'code' => 500  // Internal Server Error
            ], 500);
        }
    }


    public function destroy(string $id)
    {
        try {
            $Notifaction = Notifaction::findOrFail($id);
            $Notifaction->delete();

            return new ApiResponse('Notification deleted successfully');

        } catch (Exception $e) {
            return new ApiResponse(['error' => 'Notification deleted Failed', 'code' => 404]);
        }
    }



    public function destroyAllByUserId($userId)
    {
        try {
            // Delete all notifications for the specific user
            Notifaction::where('user_id', $userId)->delete();

            return response()->json([
                'success' => 'All notifications for the user deleted successfully.'
            ], 200);
        } catch (Exception $e) {
            // Return error response
            return response()->json([
                'error' => 'Failed to delete notifications.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function sendToAllUsers(Request $request)
    {
        // Validate the request input
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:255',
            'data' => 'required|string|max:255', // Data field validation
        ]);

        try {
            // Get all users
            $users = User::all(); // Assuming you have a User model

            // Send notification to each user
            foreach ($users as $user) {
                Notifaction::create([
                    'title' => $request->input('title'),
                    'body' => $request->input('body'),
                    'data' => $request->input('data'),
                    'user_id' => $user->id,
                ]);
            }

            return response()->json([
                'success' => 'Notification sent to all users successfully.'
            ], 200);

        } catch (Exception $e) {
            // Log the error for debugging purposes
            \Log::error('Failed to send notification to all users: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'error' => 'Failed to send notifications.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

}