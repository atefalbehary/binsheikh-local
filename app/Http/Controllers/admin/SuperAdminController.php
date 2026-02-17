<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SuperAdminController extends Controller
{
    public function __construct()
    {
        // Ensure only Super Admin or those with manage_users permission can access
        $this->middleware(function ($request, $next) {
            if (!\Auth::user()->hasPermission('manage_users')) {
                abort(403);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $users = User::with('role_details')->get();
        return view('admin.superadmin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.superadmin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'role' => '2', // Default to normal user type for backward compatibility, or specific map if needed
            'verified' => 1,
            'active' => 1,
        ]);

        // Map legacy role column if needed
        $role = Role::find($request->role_id);
        if ($role->name == 'Super Admin' || $role->name == 'Admin') {
            $user->role = '1';
            $user->save();
        }

        return redirect()->route('admin.superadmin.users.index')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.superadmin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Prevent downgrading the last Super Admin if needed (logic can be added here)
        // For now, updating legacy role
        $role = Role::find($request->role_id);
        if ($role->name == 'Super Admin' || $role->name == 'Admin') {
            $user->role = '1';
        } else {
            $user->role = '2';
        }

        $user->save();

        return redirect()->route('admin.superadmin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting self
        if ($user->id == \Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete yourself.');
        }

        // Prevent deleting the last Super Admin
        if ($user->hasRole('Super Admin') && User::whereHas('role_details', function($q){ $q->where('name', 'Super Admin'); })->count() <= 1) {
            return redirect()->back()->with('error', 'Cannot delete the last Super Admin.');
        }

        $user->delete();

        return redirect()->route('admin.superadmin.users.index')->with('success', 'User deleted successfully.');
    }
}
