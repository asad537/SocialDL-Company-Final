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

        $data = $this->getDashboardData();
        $stats      = $data['stats'];
        $recentLogs = $data['recentLogs'];
        $weeklyData = $data['weeklyData'];
        $platformData = $data['platformData'];

        return view('admin.dashboard', compact('stats', 'recentLogs', 'weeklyData', 'platformData'));
    }

    /**
     * AJAX endpoint — returns fresh dashboard data as JSON.
     */
    public function dashboardData()
    {
        if (!session('admin_logged_in')) return response()->json(['error' => 'Unauthorized'], 401);
        return response()->json($this->getDashboardData());
    }

    /**
     * Build all dashboard stats from the download_logs table.
     */
    private function getDashboardData(): array
    {
        // ── Top stats ────────────────────────────────────────────────────
        $totalDownloads   = DB::table('download_logs')->where('type', 'download')->count();
        $todayDownloads   = DB::table('download_logs')->where('type', 'download')->whereDate('created_at', today())->count();
        $totalExtractions = DB::table('download_logs')->where('type', 'extraction')->count();
        $activeUsers      = DB::table('download_logs')
            ->where('created_at', '>=', now()->subMinutes(30))
            ->distinct('ip_address')
            ->count('ip_address');

        $stats = [
            'total_downloads'   => $totalDownloads,
            'today_downloads'   => $todayDownloads,
            'total_extractions' => $totalExtractions,
            'active_users'      => $activeUsers,
        ];

        // ── Last 7 days bar chart ────────────────────────────────────────
        $weeklyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date  = now()->subDays($i);
            $count = DB::table('download_logs')
                ->whereDate('created_at', $date->toDateString())
                ->count();
            $weeklyData[] = [
                'label' => $date->format('D'),
                'count' => $count,
            ];
        }

        // ── Platform breakdown ───────────────────────────────────────────
        $platformColors = [
            'YouTube'    => '#FF0000',
            'Instagram'  => '#E4405F',
            'TikTok'     => '#00F2EA',
            'Facebook'   => '#1877F2',
            'Twitter'    => '#1DA1F2',
            'Pinterest'  => '#E60023',
            'Vimeo'      => '#1AB7EA',
            'Dailymotion'=> '#0066DC',
            'Other'      => '#6B7280',
        ];

        $total = DB::table('download_logs')->count() ?: 1;
        $rawPlatforms = DB::table('download_logs')
            ->select('platform', DB::raw('COUNT(*) as cnt'))
            ->groupBy('platform')
            ->orderByDesc('cnt')
            ->limit(5)
            ->get();

        $platformData = $rawPlatforms->map(function ($row) use ($total, $platformColors) {
            return [
                'name'  => $row->platform,
                'color' => $platformColors[$row->platform] ?? '#6B7280',
                'pct'   => (int) round(($row->cnt / $total) * 100),
            ];
        })->values()->toArray();

        // If no data yet, show placeholder
        if (empty($platformData)) {
            $platformData = [
                ['name' => 'YouTube',   'color' => '#FF0000', 'pct' => 0],
                ['name' => 'Instagram', 'color' => '#E4405F', 'pct' => 0],
                ['name' => 'TikTok',    'color' => '#00F2EA', 'pct' => 0],
                ['name' => 'Facebook',  'color' => '#1877F2', 'pct' => 0],
                ['name' => 'Twitter',   'color' => '#1DA1F2', 'pct' => 0],
            ];
        }

        // ── Recent 20 activity logs ──────────────────────────────────────
        $recentLogs = DB::table('download_logs')
            ->orderByDesc('created_at')
            ->limit(20)
            ->get()
            ->toArray();

        return compact('stats', 'weeklyData', 'platformData', 'recentLogs');
    }

    public function homepageEdit()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $settings = DB::table('homepage_settings')->first();
        $faqs = DB::table('faqs')->orderBy('sort_order')->get();
        
        // Decode platforms or provide defaults
        $platforms = [];
        if ($settings && $settings->platforms_data) {
            $platforms = json_decode($settings->platforms_data, true);
        }
        
        if (empty($platforms)) {
            $platforms = [
                ['name' => 'YouTube', 'icon' => 'fab fa-youtube'],
                ['name' => 'Instagram', 'icon' => 'fab fa-instagram'],
                ['name' => 'TikTok', 'icon' => 'fab fa-tiktok'],
                ['name' => 'Facebook', 'icon' => 'fab fa-facebook'],
                ['name' => 'Twitter', 'icon' => 'fab fa-twitter'],
            ];
        }

        $allIcons = [
            'fab fa-youtube', 'fab fa-instagram', 'fab fa-tiktok', 'fab fa-facebook', 
            'fab fa-twitter', 'fab fa-pinterest', 'fab fa-vimeo-v', 'fab fa-dailymotion', 
            'fas fa-video', 'fas fa-download', 'fas fa-link', 'fas fa-globe'
        ];

        return view('admin.homepage', compact('settings', 'faqs', 'platforms', 'allIcons'));
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

    public function faqEdit($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $faq = DB::table('faqs')->where('id', $id)->first();
        if (!$faq) abort(404);
        return view('admin.faqs_edit', compact('faq'));
    }

    public function faqUpdate(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $request->validate([
            'question' => 'required|string',
            'answer'   => 'required|string',
        ]);
        
        $updateData = [
            'question' => $request->question,
            'answer'   => $request->answer,
            'updated_at' => now(),
        ];
        
        // If editing an FAQ that has a category, allow updating it
        if ($request->has('category')) {
            $updateData['category'] = $request->category;
        }

        DB::table('faqs')->where('id', $id)->update($updateData);

        // Redirect back to the appropriate page based on the FAQ's origin
        $faq = DB::table('faqs')->where('id', $id)->first();
        if ($faq && $faq->page === 'faq_page') {
            return redirect()->route('admin.faq_page')->with('success', 'FAQ updated!');
        }
        return redirect()->route('admin.faqs')->with('success', 'FAQ updated!');
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
