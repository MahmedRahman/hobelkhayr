<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResponse;
use App\Models\GroupChat;
use Auth;
use Exception;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255', // Updated validation for image
            'type_id' => 'required|string|max:255', // Updated validation for image
            'user_id' => 'required|string|max:255', // Updated validation for image

        ]);

        try {



            // Create the service
            $Groupa = GroupChat::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'type_id' => $request->input('type_id'),
                'create_by' => $request->input('user_id'),
            ]);


            return new ApiResponse('Groupa created successfully!');


        } catch (Exception $e) {

            return new ApiResponse(['error' => 'Failed to create Group Chat', 'code' => 500]);

        }
    }
}