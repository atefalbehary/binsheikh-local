<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PendingApprovalsController extends Controller
{
    public function index()
    {
        $page_heading = "Pending Approvals";
        // Fetch Agencies (4) and Agents (3) who are not verified (0) and not deleted
        $pending_users = User::whereIn('role', [3, 4])
            ->where('verified', 0)
            ->where('deleted', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pending_approvals.index', compact('page_heading', 'pending_users'));
    }
}
