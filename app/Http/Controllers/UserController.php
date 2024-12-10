<?php
namespace App\Http\Controllers;
use App\Http\Resources\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Traits\ToStringFormat;
use Dotenv\Exception\ValidationException;
use Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        // Apply search if provided
        if ($request->has('search')) {
            $query->search($request->search);
        }

        // Always sort by ID in descending order to show newest users first
        $users = $query->orderBy('id', 'desc')->get();

        // Format location data for display
        $users = $users->map(function($user) {
            if ($user->latitude && $user->longitude) {
                $user->location = view('components.location-link', [
                    'latitude' => $user->latitude,
                    'longitude' => $user->longitude
                ])->render();
            } else {
                $user->location = "Not available";
            }
            
            // Format join time only if it exists
            if ($user->join_time) {
                $user->formatted_join_time = $user->join_time->format('Y-m-d H:i:s');
            } else {
                $user->formatted_join_time = 'N/A';
            }
            
            return $user;
        });

        $columns = [
            ['name' => 'ID', 'field' => 'id'],
            ['name' => 'Name', 'field' => 'name'],
            ['name' => 'Phone', 'field' => 'phone'],
            ['name' => 'Email', 'field' => 'email'],
            ['name' => 'Status', 'field' => 'status'],
            ['name' => 'Join Time', 'field' => 'formatted_join_time'],
            ['name' => 'Last Location', 'field' => 'location'],
        ];

        return view('admin.pages.user.index', compact('users', 'columns'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|string|min:4',
            'role' => 'nullable|string|in:user,admin'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('phone') . "@gmail.com";
        $user->phone = $request->input('phone');
        $user->password = bcrypt($request->input('password'));
        $user->role = $request->input('role', 'user');
        $user->status = 'active';
        $user->join_time = now(); // Explicitly set join_time
        $user->save();

        return redirect()->back()->with('success', 'User added successfully!');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:users,phone,' . $id,
            'email' => 'nullable|email|unique:users,email,' . $id,
            'role' => 'required|string|in:user,admin',
            'status' => 'required|string|in:active,inactive',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $user = User::findOrFail($id);
        
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->status = $request->status;

        // Only update location if provided
        if ($request->has('latitude') && $request->has('longitude')) {
            $user->latitude = $request->latitude;
            $user->longitude = $request->longitude;
        }

        $user->save();

        return redirect()->back()->with('success', 'User updated successfully!');
    }

    public function updateLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = Auth::user();
        if (!$user instanceof User) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->save();

        return response()->json(['message' => 'Location updated successfully']);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->back()->with('success', 'User Delete successfully!');
        } else {
            return redirect()->back()->withErrors('Errors', 'User Delete Errors!');
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('admin');
        }

        return redirect()->back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}