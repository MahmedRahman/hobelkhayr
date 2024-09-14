<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Kreait\Firebase\Factory;
use Illuminate\Http\Request;

class FirestoreController extends Controller
{
    protected $firestore;

    public function __construct()
    {
        // Initialize Firestore
        $this->firestore = (new Factory)
            ->withServiceAccount(config('services.firebase.credentials_file'))
            ->createFirestore()
            ->database();
    }

    public function addGroup(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
        ]);

        try {
            // Reference the chat_group collection
            $chatGroupCollection = $this->firestore->collection('chat_group');

            // Add a new document to the collection
            $newGroup = $chatGroupCollection->add([
                'group_name' => $validated['group_name'],
                'created_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Document added successfully!',
                'document_id' => $newGroup->id(),
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add document: ' . $e->getMessage(),
            ], 500);
        }
    }
}