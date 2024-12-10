<?php

namespace App\Http\Controllers;

use App\Models\ForceUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ForceUpdateController extends Controller
{
    /**
     * Get force update status for a specific platform
     */
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
    /**
     * Store a new force update record
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'version_number' => 'required|string',
            'platform' => 'required|in:android,ios',
            'is_force_update' => 'required|boolean',
            'is_optional_update' => 'required|boolean',
            'update_description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        $data['is_force_update'] = (bool)$request->is_force_update;
        $data['is_optional_update'] = (bool)$request->is_optional_update;

        $forceUpdate = ForceUpdate::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Force update record created successfully',
            'data' => $forceUpdate
        ], 201);
    }

    /**
     * Get all force update records
     */
    public function index()
    {
        $updates = ForceUpdate::latest()->get();

        return response()->json([
            'status' => true,
            'data' => $updates
        ]);
    }

    /**
     * Update a force update record
     */
    public function update(Request $request, $id)
    {
        $forceUpdate = ForceUpdate::find($id);

        if (!$forceUpdate) {
            return response()->json([
                'status' => false,
                'message' => 'Force update record not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'version_number' => 'string',
            'platform' => 'in:android,ios',
            'is_force_update' => 'boolean',
            'is_optional_update' => 'boolean',
            'update_description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        if (isset($data['is_force_update'])) {
            $data['is_force_update'] = (bool)$data['is_force_update'];
        }
        if (isset($data['is_optional_update'])) {
            $data['is_optional_update'] = (bool)$data['is_optional_update'];
        }

        $forceUpdate->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Force update record updated successfully',
            'data' => $forceUpdate
        ]);
    }

    /**
     * Delete a force update record
     */
    public function destroy($id)
    {
        $forceUpdate = ForceUpdate::find($id);

        if (!$forceUpdate) {
            return response()->json([
                'status' => false,
                'message' => 'Force update record not found'
            ], 404);
        }

        $forceUpdate->delete();

        return response()->json([
            'status' => true,
            'message' => 'Force update record deleted successfully'
        ]);
    }
}
