<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AgentAgencyController extends Controller
{
    public function index(Request $request)
    {
        $page_heading = "Find Agent & Agency";
        
        $query = User::whereIn('role', [3, 4])->where('deleted', 0); // 3: Agent, 4: Agency

        // Keyword search
        if ($request->filled('keywords')) {
            $keywords = $request->keywords;
            $query->where(function($q) use ($keywords) {
                $q->where('name', 'like', "%{$keywords}%")
                  ->orWhere('email', 'like', "%{$keywords}%")
                  ->orWhere('phone', 'like', "%{$keywords}%");
            });
        }

        // Type filter
        if ($request->filled('type')) {
            if ($request->type == 'agent') {
                $query->where('role', 3);
            } elseif ($request->type == 'agency') {
                $query->where('role', 4);
            }
        }

        $agents_agencies = $query->orderBy('created_at', 'desc')->paginate(12);

        // Enrich each record with computed stats from real data
        $agents_agencies->getCollection()->transform(function ($user) {
            // Image handling: use user_image if available, otherwise fallback
            if (empty($user->user_image) || $user->user_image == get_uploaded_image_url('', 'user_image_upload_dir')) {
                $user->logo_image = asset('front-assets/images/avatar/1.jpg');
            } else {
                $user->logo_image = $user->user_image;
            }

            // For Agencies (role 4): calculate real agent counts
            if ($user->role == 4) {
                $agencyAgents = User::where('agency_id', $user->id)->where('deleted', 0);
                $user->agents_count = $agencyAgents->count();
                $user->super_agents_count = (clone $agencyAgents)->where('super_agent', 1)->count();
            } else {
                // For individual Agents
                $user->agents_count = 0;
                $user->super_agents_count = $user->super_agent ?? 0;
            }

            // Property counts - currently no direct relationship in DB
            $user->for_sale_count = 0;
            $user->for_rent_count = 0;

            return $user;
        });

        return view('front_end.agent_agency.index', compact('page_heading', 'agents_agencies'));
    }
}
