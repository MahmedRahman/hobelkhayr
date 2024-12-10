<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForceUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ForceUpdateController extends Controller
{
    public function index()
    {
        $updates = ForceUpdate::latest()->get();
        return view('admin.pages.force-update.index', compact('updates'));
    }

    public function check(Request $request)
    {
        // Validate the request input
        $validator = Validator::make($request->all(), [
            'platform' => 'required|in:android,ios',
            'current_version' => 'required|string'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
    
        // Fetch the latest force update record for the specified platform
        $forceUpdate = ForceUpdate::where('platform', $request->platform)
            ->latest()
            ->first();
    
        if (!$forceUpdate) {
            return response()->json([
                'status' => false,
                'message' => 'No update information available for the specified platform'
            ], 404);
        }
    
      
        // Determine the update URL based on the platform
        $updateUrl = $forceUpdate->platform === 'android' 
            ? config('app.android_store_url') 
            : config('app.ios_store_url');
    
        // Return the response with update details
        return response()->json([
            'status' => true,
            'data' => [
               
                'is_force_update' => $forceUpdate->is_force_update,
                'is_optional_update' => $forceUpdate->is_optional_update,
                'latest_version' => $forceUpdate->version_number,
                'update_description' => $forceUpdate->update_description,
                'update_url' => $updateUrl,
            ]
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'platform' => 'required|in:android,ios',
            'version_number' => 'required|string',
            'update_description' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $update = ForceUpdate::create([
                'platform' => $request->platform,
                'version_number' => $request->version_number,
                'is_force_update' => $request->has('is_force_update') && $request->is_force_update === "1",
                'is_optional_update' => $request->has('is_optional_update') && $request->is_optional_update === "1",
                'update_description' => $request->update_description
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Version added successfully',
                'data' => $update
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error adding version',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'platform' => 'required|in:android,ios',
            'version_number' => 'required|string',
            'update_description' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $update = ForceUpdate::findOrFail($id);
            $update->update([
                'platform' => $request->platform,
                'version_number' => $request->version_number,
                'is_force_update' => $request->has('is_force_update') && $request->is_force_update === "1",
                'is_optional_update' => $request->has('is_optional_update') && $request->is_optional_update === "1",
                'update_description' => $request->update_description
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Version updated successfully',
                'data' => $update
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error updating version',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $update = ForceUpdate::findOrFail($id);
            $update->delete();

            return response()->json([
                'status' => true,
                'message' => 'Version deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error deleting version',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
