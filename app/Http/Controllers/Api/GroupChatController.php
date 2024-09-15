<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResponse;
use App\Models\GroupChat;
use App\Models\GroupUser;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Validator;

class GroupChatController extends Controller
{
    public function index($id = null)
    {
        if ($id) {
            $Groups = GroupChat::with('service')
                ->where('create_by', $id)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $Groups = GroupChat::with('service')->orderBy('id', 'desc')->get();

        }
        $response = $Groups->map(function ($group) {
            return [
                'id' => $group->id,
                'name' => $group->name,
                'description' => $group->description,
                'type_id' => $group->type_id,
                'create_by' => $group->create_by,
                'service_image' => $group->service->service_image ?? 'No image available',

            ];
        });


        return new ApiResponse($response);



        // return response()->json($services);
    }



    public function getGroupByuser($id = null)
    {
        // Fetch groups either by user_id (create_by) or fetch all
        $Groups = GroupChat::with('service')
            ->when($id, function ($query, $id) {
                return $query->where('create_by', $id);
            })
            ->orderBy('id', 'desc')
            ->get();

        // Map the result to return a customized response
        $response = $Groups->map(function ($group) {
            return [
                'id' => $group->id,
                'name' => $group->name,
                'description' => $group->description,
                'type_id' => $group->type_id,
                'create_by' => $group->create_by,
                'service_image' => $group->service->service_image ?? 'No image available',
            ];
        });

        // Return the mapped response as an API response
        return new ApiResponse($response);
    }


    public function deleteGroup($id)
    {
        // Find the group by its ID
        $group = GroupChat::find($id);

        if (!$group) {
            // Return a response if the group is not found
            return response()->json([
                'status' => 'error',
                'message' => 'Group not found',
            ], 404);
        }

        // Delete the group
        $group->delete();

        // Return a success response
        return response()->json([
            'status' => 'success',
            'message' => 'Group deleted successfully',
        ], 200);
    }


    public function store(Request $request)
    {

        // Validate the request


        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255', // Updated validation for image
            'type_id' => 'required|string|max:255', // Updated validation for image
            'user_id' => 'required|integer|exists:users,id', // Check if 'create_by' is a valid 'user_id'
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

        // Create the service
        $Groupa = GroupChat::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'type_id' => $request->input('type_id'),
            'create_by' => $request->input('user_id'),
        ]);


        $user = GroupUser::create([
            'group_id' => $Groupa->id,
            'user_id' => $request->input('user_id'),
        ]);

        return new ApiResponse('Groupa created successfully!');



    }
}