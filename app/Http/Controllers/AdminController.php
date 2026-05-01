<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    private $adminPassword = 'admin@123';

    public function login()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        if ($request->password === $this->adminPassword) {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['password' => 'Invalid password.']);
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $stats = [
            'total_downloads'   => Cache::get('stat_total_downloads', 0),
            'today_downloads'   => Cache::get('stat_today_downloads', 0),
            'total_extractions' => Cache::get('stat_total_extractions', 0),
            'active_users'      => Cache::get('stat_active_users', 0),
        ];
        $recentLogs = Cache::get('recent_download_logs', []);
        return view('admin.dashboard', compact('stats', 'recentLogs'));
    }

    public function homepageEdit()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $settings = DB::table('homepage_settings')->first();
        return view('admin.homepage', compact('settings'));
    }

    public function homepageSave(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        DB::table('homepage_settings')->updateOrInsert(
            ['id' => 1],
            [
                'hero_heading'      => $request->hero_heading,
                'hero_button_text'  => $request->hero_button_text,
                'hero_button_url'   => $request->hero_button_url,
                'hero_description'  => $request->hero_description,
                'sites_heading'     => $request->sites_heading,
                'sites_description' => $request->sites_description,
                'platforms_data'    => $request->platforms_data,
                'updated_at'        => now(),
            ]
        );
        return back()->with('success', 'Homepage updated successfully!');
    }
}
