<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminPanelAuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $email = strtolower(trim((string) $validated['email']));
        $user = User::where('email', $email)->where('deleted', 0)->first();

        if (!$user || !$user->password || !Hash::check((string) $validated['password'], (string) $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $isAdmin = (string) ($user->role ?? '') === '1' || (int) ($user->role_id ?? 0) > 0;
        if (!$isAdmin) {
            return response()->json(['error' => 'Not an admin user'], 403);
        }

        // Keep one token per admin panel session source.
        $user->tokens()->where('name', 'mobile-admin-panel')->delete();
        $token = $user->createToken('mobile-admin-panel')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => (string) $user->id,
                'email' => (string) ($user->email ?? ''),
                'name' => (string) ($user->name ?? ''),
            ],
        ]);
    }

    public function me(Request $request)
    {
        /** @var User|null $user */
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'id' => (string) $user->id,
            'email' => (string) ($user->email ?? ''),
            'name' => (string) ($user->name ?? ''),
        ]);
    }
}
