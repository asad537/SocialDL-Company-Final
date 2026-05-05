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
        $faqs = DB::table('faqs')->orderBy('sort_order')->get();
        return view('admin.homepage', compact('settings', 'faqs'));
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

    // ── FAQ Methods (Home) ────────────────────────────────────────────
    public function faqIndex()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $faqs = DB::table('faqs')->where('page', 'home')->orderBy('sort_order')->get();
        return view('admin.faqs', compact('faqs'));
    }

    public function faqStore(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $request->validate([
            'question' => 'required|string',
            'answer'   => 'required|string',
        ]);
        $maxOrder = DB::table('faqs')->where('page', 'home')->max('sort_order') ?? 0;
        DB::table('faqs')->insert([
            'question'   => $request->question,
            'answer'     => $request->answer,
            'page'       => 'home',
            'sort_order' => $maxOrder + 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back()->with('success', 'FAQ added to Home Page!');
    }

    public function faqDelete($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        DB::table('faqs')->where('id', $id)->delete();
        return back()->with('success', 'FAQ deleted!');
    }

    // ── FAQ Page Methods (Dedicated) ──────────────────────────────────
    public function faqPageSettings()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $faqs = DB::table('faqs')->where('page', 'faq_page')->orderBy('category')->orderBy('sort_order')->get();
        $categories = DB::table('faqs')->where('page', 'faq_page')->distinct()->pluck('category')->filter()->values();
        $settings = DB::table('homepage_settings')->first();
        return view('admin.faq_page', compact('faqs', 'categories', 'settings'));
    }

    public function faqPageStore(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $request->validate([
            'question' => 'required|string',
            'answer'   => 'required|string',
            'category' => 'required|string',
        ]);
        $maxOrder = DB::table('faqs')->where('page', 'faq_page')->where('category', $request->category)->max('sort_order') ?? 0;
        DB::table('faqs')->insert([
            'question'   => $request->question,
            'answer'     => $request->answer,
            'category'   => $request->category,
            'page'       => 'faq_page',
            'sort_order' => $maxOrder + 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back()->with('success', 'FAQ added to FAQ Page!');
    }

    public function faqPageSeoSave(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        DB::table('homepage_settings')->where('id', 1)->update([
            'faq_meta_title'       => $request->faq_meta_title,
            'faq_meta_description' => $request->faq_meta_description,
            'faq_meta_keywords'    => $request->faq_meta_keywords,
            'updated_at'           => now(),
        ]);
        return back()->with('success', 'FAQ Page SEO settings updated!');
    }

    public function faqPageDelete($id)
    {
        return $this->faqDelete($id);
    }

    public function publicFaqs()
    {
        $faqs = DB::table('faqs')->where('page', 'faq_page')->where('is_active', 1)->orderBy('sort_order')->get()->groupBy('category');
        $settings = DB::table('homepage_settings')->first();
        return view('faqs', compact('faqs', 'settings'));
    }

    public function uploadEditorImage(Request $request)
    {
        if (!session('admin_logged_in')) return response()->json(['success' => 0, 'message' => 'Unauthorized'], 401);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images'), $filename);

            return response()->json([
                'success' => 1,
                'file' => [
                    'url' => asset('assets/images/' . $filename),
                ]
            ]);
        }

        return response()->json(['success' => 0, 'message' => 'No image uploaded']);
    }
}
