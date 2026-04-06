<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Properties;
use Carbon\Carbon;

class MobileAppController extends Controller
{
    public function index()
    {
        $page_heading = "Mobile App Management Center";

        // Mobile Users
        $mobile_users = \App\Models\MobileUser::count();
        $mobile_users_today = \App\Models\MobileUser::whereDate('created_at', Carbon::today())->count();

        // These will need actual model replacements if the tables exist, for now just mocking or base queries
        $active_conversations = 0; // TBD or mocked for now
        $notifications_sent_today = 0;

        // Favorites (If there's a favorites or user_properties table)
        // Adjusting table name to match database: favourite_properties
        $favorited_properties = \DB::table('favourite_properties')->count() ?? 0;
        $scheduled_properties = \DB::table('visit_schedules')->count() ?? 0;
        $scheduled_visits = \DB::table('visit_schedules')->count() ?? 0;

        // Fetch recent signed up mobile users
        $recent_users = \App\Models\MobileUser::orderBy('created_at', 'desc')->take(10)->get();

        return view('admin.mobile_app.dashboard', compact(
            'page_heading',
            'mobile_users',
            'mobile_users_today',
            'active_conversations',
            'notifications_sent_today',
            'favorited_properties',
            'scheduled_properties',
            'scheduled_visits',
            'recent_users'
        ));
    }
}
