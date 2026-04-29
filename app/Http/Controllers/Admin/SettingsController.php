<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryCharge;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function settings()
    {
        $page_heading = "Settings";
        $page = Settings::first();
        if ($page == null) {
            $page = new Settings();
        }
        return view('admin.settings.index', compact('page_heading', 'page'));
    }

    public function setting_store(Request $request)
    {
        $settings = Settings::first();
        if ($settings == null) {
            $settings = new Settings();
            $message = 'Setting has been Created.';
        }
        $settings->month_count = $request->month_count;
        $settings->advance_perc = $request->advance_perc;
        $settings->service_charge_perc = $request->service_charge_perc;
        $settings->meta_title = $request->meta_title;
        $settings->meta_title_ar = $request->meta_title_ar;
        $settings->meta_description = $request->meta_description;
        $settings->meta_description_ar = $request->meta_description_ar;

        $settings->experience = $request->experience;
        $settings->clients = $request->clients;
        $settings->units = $request->units;
        $settings->branches = $request->branches;
        if ($settings->save()) {
            $message = 'Setting has been updated.';
            return redirect()->back()->with('success', $message);
        }
        return redirect()->back()->with('error', 'Unable to update Setting');
    }
}
