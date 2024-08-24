<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {

        $users = User::where('role', 'user')->get();


        if ($request->wantsJson()) {
            return response()->json($users);
        }


        $columns = [
            ['name' => 'ID', 'field' => 'id'],
            ['name' => 'Name', 'field' => 'name'],
            ['name' => 'Email', 'field' => 'email'],
            ['name' => 'Phone', 'field' => 'phone'],
            // Add more columns as needed
        ];
        // compact($users, $columns)
        return view('admin.pages.user', compact('users', 'columns'));
        // return view('admin.pages.user', ['users' => $users]);


    }

    /**
     * Display the specified user.
     */
    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['message' => 'User not found!'], 404);
        }
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|string|min:6',
            'role' => 'nullable|string|in:user,admin'
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json($validator->errors(), 400);
            }
            return redirect()->route('users.index')->with('fauiler', $validator->errors());

        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role', 'user') // Default to 'user' if not provided
        ]);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'User created successfully!', 'user' => $user]);
        }

        return redirect()->route('users.index')->with('success', 'Service added successfully!');


        //return response()->json(['message' => 'User created successfully!', 'user' => $user], 201);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:6',
            'role' => 'sometimes|nullable|string|in:user,admin'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::find($id);
        if ($user) {
            $user->name = $request->input('name', $user->name);
            $user->email = $request->input('email', $user->email);
            if ($request->has('password')) {
                $user->password = bcrypt($request->input('password'));
            }
            $user->role = $request->input('role', $user->role);
            $user->save();

            return response()->json(['message' => 'User updated successfully!', 'user' => $user]);
        } else {
            return response()->json(['message' => 'User not found!'], 404);
        }
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully!']);
        } else {
            return response()->json(['message' => 'User not found!'], 404);
        }
    }
}