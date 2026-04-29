<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function login()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == '1' || $user->role_details) {
                return redirect()->route('admin.dashboard');
            }
        }
        // echo Hash::make('Hello@1985');
        return view('admin.login');
    }
    public function check_login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        // Validate request
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            // Allow login if user has legacy role 1 OR has an assigned RBAC role (assuming roles > 0 are admin-like)
            // Enhanced check: users with role_details are admin staff
            if ($user->role == '1' || $user->role_details) {
                $request->session()->put('user_id', $user->id);
                if ($request->timezone) {
                    $request->session()->put('user_timezone', $request->timezone);
                }
                return response()->json(['success' => true, 'message' => "Logged in successfully."]);
            } else {
                Auth::logout(); // Ensure logout if they don't meet criteria
                return response()->json(['success' => false, 'message' => "Unauthorized access!"]);
            }
        }

        return response()->json(['success' => false, 'message' => "Invalid Credentials!"]);
    }
    public function logout()
    {
        session()->pull("user_id");
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
