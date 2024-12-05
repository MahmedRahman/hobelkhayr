<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResponse;
use App\Models\GroupUser;
use Illuminate\Http\Request;
use Validator;

class GroupUserController extends Controller
{
    public function index(Request $request)
    {
        $GroupUser = GroupUser::all();
        $response = $GroupUser->map(function ($GroupUser) {
            return [

                "group_id" => $GroupUser->group_id,
                "group" => $GroupUser->group,
                "user_id" => $GroupUser->user_id,
                "user" => $GroupUser->user,

            ];
        });
        return new ApiResponse($response);
    }


    public function getGroupByUserId($userId)
    {

        // Check if a user_id is provided, and apply the filter if so
        $GroupUser = GroupUser::when($userId, function ($query, $userId) {
            return $query->where('user_id', $userId);
        })->orderBy('created_at', 'desc') // Sort by created_at in descending order
        ->get();

        $response = $GroupUser->map(function ($GroupUser) {
            return [
                "group_id" => $GroupUser->group->id,
                "name" => $GroupUser->group->name,
                "description" => $GroupUser->group->description,
                "type_id" => $GroupUser->group->type_id,
                'service_image' => $GroupUser->group->service->service_image ?? 'No image available',
                "user_id" => $GroupUser->group,
            ];
        });
        return new ApiResponse($response);
    }

    public function getUsersByGroupId($groupId)
    {
        // Validate that the group ID exists
        // $groupExists = GroupUser::find($groupId);

        // if (!$groupExists) {
        //     return new ApiResponse(['error' => 'Group not found', 'code' => 404]);
        // }

        // Retrieve the users associated with the group ID
        $users = GroupUser::where('group_id', $groupId)
            ->with('user') // Eager load the user relationship
            ->get()
            ->map(function ($groupUser) {
                return [
                    'id' => $groupUser->user->id,
                    'name' => $groupUser->user->name,
                    'email' => $groupUser->user->email,
                    'role' => $groupUser->role, // Optionally include the role if needed
                ];
            });

        // Return the list of users
        return new ApiResponse($users);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'group_id' => 'required|integer|exists:group_chats,id', // Assuming 'group_chats' is your groups table name
            'user_id' => 'required|integer|exists:users,id',
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


        // Check if the user is already in the group
        $existingGroupUser = GroupUser::where([
            ['group_id', '=', $request->input('group_id')],
            ['user_id', '=', $request->input('user_id')],
        ])->first();

        if ($existingGroupUser) {
            $errorResponse = [
                'error' => 'User is already in the group.',
                'code' => 409  // Conflict
            ];
            // Return error response
            return new ApiResponse($errorResponse);
        }

        $user = GroupUser::create([
            'group_id' => $request->input('group_id'),
            'user_id' => $request->input('user_id'),
        ]);




        return new ApiResponse($user);




    }

    public function destroy(Request $request)
    {

        // $user = GroupUser::find(1);
        // $user->delete(); //returns true/false

        // Validate the request inputs
        $validator = Validator::make($request->all(), [
            'group_id' => 'required|integer|exists:group_chats,id',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            $firstError = $validator->errors()->first();

            $errorResponse = [
                'error' => $firstError,
                'code' => 400
            ];
            return new ApiResponse($errorResponse);
        }

        // Check if the user is in the group
        $existingGroupUser = GroupUser::where([
            ['group_id', '=', $request->input('group_id')],
            ['user_id', '=', $request->input('user_id')],
        ])->first();

        if ($existingGroupUser) {
            // Get the row details before deleting
            $groupUserDetails = $existingGroupUser->toArray();


            // Attempt to delete the user from the group
            $deleted = $existingGroupUser->delete();

            if ($deleted) {
                return new ApiResponse("User has been removed from the group.");
            } else {
                return new ApiResponse([
                    'error' => 'Failed to delete user from the group.',
                    'code' => 500
                ]);
            }
        }

        // User not found in the group
        return new ApiResponse([
            'error' => 'User not found in the group.',
            'code' => 404
        ]);
    }


}