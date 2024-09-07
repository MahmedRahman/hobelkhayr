<?php

namespace App\Http\Controllers;
use Auth;
use Exception;

use App\Models\GroupChat;
use Illuminate\Http\Request;

class GroupChatController extends Controller
{

    public function index(Request $request)
    {

        //$Groups = GroupChat::orderBy('id', 'desc')->get();
        $Groups = GroupChat::with('service')->orderBy('id', 'desc')->get();

        if ($request->wantsJson()) {
            // If the request expects JSON, return a JSON response
            // return response()->json($Groups);

            $response = $Groups->map(function ($group) {
                return [
                    'id' => $group->id,
                    'name' => $group->name,
                    'description' => $group->description,
                    'type_id' => $group->type_id,
                    //'service_id' => $group->type_id,
                    'service_image' => $group->service->service_image ?? 'No image available',
                    // Include other necessary fields
                ];
            });
            return response()->json($response);

        }

        $columns = [
            ['name' => 'ID', 'field' => 'id'],
            ['name' => 'Name', 'field' => 'name'],
            ['name' => 'Des', 'field' => 'descriptions'],
            // Add more columns as needed
        ];

        return view('admin.pages.group.index', compact('Groups', 'columns'));

        // return response()->json($services);
    }
    //


    public function store(Request $request)
    {

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255', // Updated validation for image
            'type_id' => 'required|string|max:255', // Updated validation for image
        ]);

        try {

            $userId = Auth::id();

            // Create the service
            $Groupa = GroupChat::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'type_id' => $request->input('type_id'),
                'create_by' => $userId,
            ]);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Groupa created successfully!', 'Groupa' => $Groupa]);
            }

            return redirect()->route('GroupChat.index')->with('success', 'Group Chat added successfully!');

        } catch (Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Failed to create Group Chat!'], 500);
            }

            return redirect()->back()->with('error', 'Failed to create Group Chat!');
        }
    }



    public function destroy($id)
    {
        try {
            $Groups = GroupChat::findOrFail($id);
            $Groups->delete();

            return redirect()->back()->with('success', 'Groups deleted successfully!');

        } catch (Exception $e) {


            return redirect()->back()->with('error', 'Groups not found!');
        }
    }
}