<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::orderBy('id', 'desc')->get();
        $columns = [
            ['name' => 'ID', 'field' => 'id'],
            ['name' => 'Name', 'field' => 'name'],
            ['name' => 'Description', 'field' => 'description'],
            ['name' => 'Status', 'field' => 'status'],
            ['name' => 'Created At', 'field' => 'created_at'],
        ];

        return view('admin.pages.group.index', compact('groups', 'columns'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $group = new Group();
        $group->name = $request->name;
        $group->description = $request->description;
        $group->status = $request->status;
        $group->save();

        return redirect()->back()->with('success', 'Group added successfully!');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $group = Group::findOrFail($id);
        $group->name = $request->name;
        $group->description = $request->description;
        $group->status = $request->status;
        $group->save();

        return redirect()->back()->with('success', 'Group updated successfully!');
    }

    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        $group->delete();

        return redirect()->back()->with('success', 'Group deleted successfully!');
    }
}
