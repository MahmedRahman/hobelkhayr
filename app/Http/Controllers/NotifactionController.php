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
        $columns = [
            ['name' => 'ID', 'field' => 'id'],
            ['name' => 'Title', 'field' => 'title'],
            ['name' => 'Body', 'field' => 'body'],
        ];
        return view('admin.pages.notifaction.index', compact('Notifications', 'columns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
        ]);

        try {
            Notifaction::create([
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'user_id' => $request->input('user_id'),
            ]);


            return redirect()->back()->with('success', 'Service added successfully!');
        } catch (Exception $e) {


            return redirect()->back()->with('error', 'Notifaction not found!');
        }
    }


    public function destroy($id, Request $request)
    {
        try {
            $Notifaction = Notifaction::findOrFail($id);
            $Notifaction->delete();



            return redirect()->back()->with('success', 'Notifaction deleted successfully!');

        } catch (Exception $e) {


            return redirect()->back()->with('error', 'Notifaction not found!');
        }
    }



}