<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\SeoSetting;
use App\Models\SeoRedirect;
use App\Models\Seo404Log;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Blog;
use App\Models\Properties;
use App\Models\Projects;

class SeoController extends Controller
{
    public function index()
    {
        $settings = SeoSetting::all()->pluck('value', 'key')->toArray();
        return view('admin.seo.index', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->except('_token');
        foreach ($data as $key => $value) {
            SeoSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        return redirect()->back()->with('success', 'SEO Settings updated successfully.');
    }

    public function redirects()
    {
        $redirects = SeoRedirect::latest()->get();
        return view('admin.seo.redirects', compact('redirects'));
    }

    public function storeRedirect(Request $request)
    {
        $request->validate([
            'old_url' => 'required',
            'new_url' => 'required',
            'status_code' => 'required|in:301,302',
        ]);

        SeoRedirect::create($request->all());
        return redirect()->back()->with('success', 'Redirect added successfully.');
    }

    public function destroyRedirect($id)
    {
        SeoRedirect::find($id)->delete();
        return response()->json(['status' => 1, 'message' => 'Redirect deleted successfully.']);
    }

    public function monitor404()
    {
        $logs = Seo404Log::latest()->get();
        return view('admin.seo.404', compact('logs'));
    }

    public function generateSitemap()
    {
        try {
            $sitemap = Sitemap::create();

            // Static pages
            $staticPages = [
                '/',
                '/about-us',
                '/contact-us',
                '/services',
                '/blogs',
                '/property-listing',
                '/project-listing',
                '/photos',
                '/videos',
            ];

            foreach ($staticPages as $page) {
                $sitemap->add(Url::create($page)->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
            }

            // Mobile/Web handling for manual addition requires full URL or relative if configured correctly.
            // Spatie Sitemap defaults to config('app.url') as base if relative URL is passed to create().

            // Properties
            Properties::all()->each(function (Properties $property) use ($sitemap) {
                $sitemap->add(Url::create("/property-details/{$property->slug}")
                    ->setLastModificationDate($property->updated_at)
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
            });

            // Projects
            Projects::all()->each(function (Projects $project) use ($sitemap) {
                $sitemap->add(Url::create("/project-details/{$project->slug}")
                    ->setLastModificationDate($project->updated_at)
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
            });

            // Blogs
            Blog::all()->each(function (Blog $blog) use ($sitemap) {
                $sitemap->add(Url::create("/blog-details/{$blog->slug}")
                    ->setLastModificationDate($blog->updated_at)
                    ->setPriority(0.7)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
            });

            $sitemap->writeToFile(public_path('sitemap.xml'));
            return redirect()->back()->with('success', 'Sitemap generated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to generate sitemap: ' . $e->getMessage());
        }
    }
}

