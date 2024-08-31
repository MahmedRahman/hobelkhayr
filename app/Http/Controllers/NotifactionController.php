<?php

namespace App\Http\Controllers;
use Auth;
use Exception;
use Illuminate\Http\Request;
use App\Models\Notifaction;

class NotifactionController extends Controller
{
    //

    public function index(Request $request)
    {

        $Notifications = Notifaction::all();


        if ($request->wantsJson()) {
            // If the request expects JSON, return a JSON response
            return response()->json($Notifications);
        }


        $columns = [
            ['name' => 'ID', 'field' => 'id'],
            ['name' => 'Title', 'field' => 'title'],
            ['name' => 'Body', 'field' => 'body'],
            // Add more columns as needed
        ];

        return view('admin.pages.notifaction', compact('Notifications', 'columns'));

        // return response()->json($services);
    }

    public function store(Request $request)
    {

        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:255', // Updated validation for image
        ]);

        try {


            $userid = Auth::id();
            // if (Request::has('user_id')) {
            //     $userid = $request->input('user_id');
            // }

            // Create the Notification


            $Notification = Notifaction::create([
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'user_id' => $userid,
            ]);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Notification created successfully!', 'Notification' => $Notification]);
            }

            return redirect()->route('Notifactions.index')->with('success', 'Service added successfully!');

        } catch (Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Failed to create service! ' . $e], 500);
            }

            return redirect()->back()->with('error', 'Failed to create service!');
        }
    }


    public function destroy($id, Request $request)
    {
        try {
            $Notifaction = Notifaction::findOrFail($id);
            $Notifaction->delete();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Notifaction deleted successfully!']);
            }

            return redirect()->back()->with('success', 'Notifaction deleted successfully!');

        } catch (Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Notifaction not found!'], 404);
            }

            return redirect()->back()->with('error', 'Notifaction not found!');
        }
    }



}