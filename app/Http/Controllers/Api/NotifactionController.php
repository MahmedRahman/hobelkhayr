<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResponse;
use App\Models\Notifaction;
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
}