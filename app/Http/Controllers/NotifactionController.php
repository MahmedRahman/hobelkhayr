<?php

namespace App\Http\Controllers;

use Auth;
use Exception;
use App\Models\User;
use App\Models\Notifaction;
use App\Services\FCMService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotifactionController extends Controller
{
    protected $fcmService;

    public function __construct(FCMService $fcmService)
    {
        $this->fcmService = $fcmService;
    }

    public function index(Request $request)
    {
        $notifications = Notifaction::latest()->get();
        $users = User::where('role', 'user')->get();
        
        return view('admin.pages.notifaction.index', compact('notifications', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'user_ids' => 'required_if:send_to_all,0|array',
            'user_ids.*' => 'exists:users,id',
            'send_to_all' => 'required|boolean',
            'data' => 'nullable|json',
        ]);

        try {
            DB::beginTransaction();

            $notification = Notifaction::create([
                'title' => $request->title,
                'body' => $request->body,
                'user_ids' => $request->send_to_all ? null : $request->user_ids,
                'send_to_all' => $request->send_to_all,
                'data' => $request->data ?? '{}',
                'status' => 'pending'
            ]);

            // Get target users
            if ($request->send_to_all) {
                $users = User::whereNotNull('device_token')->get();
            } else {
                $users = User::whereIn('id', $request->user_ids)
                            ->whereNotNull('device_token')
                            ->get();
            }

            // Collect device tokens
            $deviceTokens = $users->pluck('device_token')->filter()->values()->toArray();

            if (!empty($deviceTokens)) {
                // Send FCM notification to all devices
                $success = $this->fcmService->sendToMultipleDevices(
                    $deviceTokens,
                    $request->title,
                    $request->body,
                    json_decode($request->data ?? '{}', true)
                );

                if ($success) {
                    $notification->update([
                        'status' => 'sent',
                        'sent_at' => now()
                    ]);
                } else {
                    $notification->update([
                        'status' => 'failed',
                        'sent_at' => now()
                    ]);
                    throw new Exception('Failed to send FCM notification');
                }
            } else {
                $notification->update([
                    'status' => 'failed',
                    'sent_at' => now()
                ]);
                throw new Exception('No valid device tokens found');
            }

            DB::commit();
            return redirect()->back()->with('success', 'Notification sent successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to send notification: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $notification = Notifaction::findOrFail($id);
            $notification->delete();
            return response()->json([
                'success' => true,
                'message' => 'Notification deleted successfully!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete notification: ' . $e->getMessage()
            ], 500);
        }
    }

    public function sendToAllUsers(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'data' => 'nullable|json',
        ]);

        try {
            DB::beginTransaction();

            $notification = Notifaction::create([
                'title' => $request->title,
                'body' => $request->body,
                'send_to_all' => true,
                'data' => $request->data ?? '{}',
                'status' => 'pending'
            ]);

            // Get all users with device tokens
            $users = User::whereNotNull('device_token')->get();
            $deviceTokens = $users->pluck('device_token')->filter()->values()->toArray();

            if (!empty($deviceTokens)) {
                // Send FCM notification to all devices
                $success = $this->fcmService->sendToMultipleDevices(
                    $deviceTokens,
                    $request->title,
                    $request->body,
                    json_decode($request->data ?? '{}', true)
                );

                if ($success) {
                    $notification->update([
                        'status' => 'sent',
                        'sent_at' => now()
                    ]);
                } else {
                    $notification->update([
                        'status' => 'failed',
                        'sent_at' => now()
                    ]);
                    throw new Exception('Failed to send FCM notification');
                }
            } else {
                $notification->update([
                    'status' => 'failed',
                    'sent_at' => now()
                ]);
                throw new Exception('No valid device tokens found');
            }

            DB::commit();
            return redirect()->back()->with('success', 'Notification sent to all users successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to send notification: ' . $e->getMessage());
        }
    }

    public function destroyAllByUserId($userId)
    {
        try {
            $notifications = Notifaction::where(function($query) use ($userId) {
                $query->where('user_ids', 'like', "%\"$userId\"%")
                      ->orWhere('send_to_all', true);
            })->get();

            foreach ($notifications as $notification) {
                $notification->delete();
            }

            return redirect()->back()->with('success', 'All notifications deleted successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete notifications: ' . $e->getMessage());
        }
    }
}