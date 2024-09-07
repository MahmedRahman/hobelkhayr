<?php
namespace App\Http\Controllers;
use App\Http\Resources\ApiResponse;
use Auth;
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
        $users = User::where('role', 'user')->get();
        $columns = [
            ['name' => 'ID', 'field' => 'id'],
            ['name' => 'Name', 'field' => 'name'],
            ['name' => 'Phone', 'field' => 'phone'],
            ['name' => 'Email', 'field' => 'email'],
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

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('phone') . "@gmail.com",
            'phone' => $request->input('phone'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role', 'user') // Default to 'user' if not provided
        ]);

        return redirect()->back()->with('success', 'User added successfully!');
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
            'email' => 'required|email',  // Ensure the email field is validated properly as an email.
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();  // Regenerate the session to prevent session fixation
            return redirect()->intended('admin');  // Redirects to the dashboard, or to the intended URL before login was required
        }

        // If authentication fails, redirect back with more detailed error message
        return redirect()->back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }



    public function logout(Request $request)
    {
        Auth::logout();  // Log the user out

        $request->session()->invalidate();  // Invalidate the session
        $request->session()->regenerateToken();  // Regenerate the CSRF token

        return redirect('/login');  // Redirect to login page
    }
}