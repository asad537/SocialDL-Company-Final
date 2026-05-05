<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Video Saver Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Inter',sans-serif;background:#0F1117;color:#E2E8F0;display:flex;min-height:100vh;}

        /* SIDEBAR */
        .sidebar{width:220px;background:#161B27;border-right:1px solid rgba(255,255,255,0.06);display:flex;flex-direction:column;flex-shrink:0;position:fixed;height:100vh;z-index:100;}
        .sidebar-logo{padding:1.5rem 1.2rem;border-bottom:1px solid rgba(255,255,255,0.06);}
        .sidebar-logo .logo-wrap{display:flex;align-items:center;gap:0.6rem;}
        .sidebar-logo .icon{width:38px;height:38px;background:linear-gradient(135deg,#FFB800,#FF8C00);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1rem;color:#fff;box-shadow:0 6px 20px rgba(255,184,0,0.35);}
        .sidebar-logo h2{font-size:0.95rem;font-weight:700;color:#fff;}
        .sidebar-logo p{font-size:0.68rem;color:rgba(255,255,255,0.35);margin-top:1px;}
        .sidebar-nav{padding:1rem 0.6rem;flex:1;}
        .nav-label{font-size:0.6rem;font-weight:600;color:rgba(255,255,255,0.2);text-transform:uppercase;letter-spacing:0.1em;padding:0.5rem 0.7rem;margin-top:0.5rem;}
        .nav-item{display:flex;align-items:center;gap:0.7rem;padding:0.6rem 0.8rem;border-radius:8px;color:rgba(255,255,255,0.45);font-size:0.82rem;font-weight:500;cursor:pointer;transition:all 0.2s;text-decoration:none;margin-bottom:2px;}
        .nav-item:hover{background:rgba(255,255,255,0.04);color:#fff;}
        .nav-item.active{background:linear-gradient(135deg,rgba(255,184,0,0.12),rgba(255,140,0,0.08));color:#FFB800;border:1px solid rgba(255,184,0,0.1);}
        .nav-item i{width:16px;text-align:center;font-size:0.85rem;}
        .sidebar-footer{padding:0.8rem 1rem;border-top:1px solid rgba(255,255,255,0.06);}
        .admin-badge{display:flex;align-items:center;gap:0.6rem;}
        .admin-avatar{width:32px;height:32px;background:linear-gradient(135deg,#FFB800,#FF8C00);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:0.75rem;color:#fff;font-weight:700;}
        .admin-info p{font-size:0.78rem;font-weight:600;color:#fff;}
        .admin-info span{font-size:0.68rem;color:rgba(255,255,255,0.25);}
        .logout-btn{margin-left:auto;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);color:#FCA5A5;padding:0.3rem 0.6rem;border-radius:6px;font-size:0.7rem;cursor:pointer;text-decoration:none;transition:all 0.2s;}
        .logout-btn:hover{background:rgba(239,68,68,0.2);}

        /* MAIN */
        .main{margin-left:220px;flex:1;display:flex;flex-direction:column;min-height:100vh;}
        .topbar{background:#161B27;border-bottom:1px solid rgba(255,255,255,0.06);padding:1rem 2rem;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50;}
        .topbar h1{font-size:1.2rem;font-weight:700;color:#fff;}
        .topbar-right{display:flex;align-items:center;gap:1rem;}
        .badge-live{background:rgba(34,197,94,0.15);border:1px solid rgba(34,197,94,0.3);color:#4ADE80;padding:0.3rem 0.8rem;border-radius:20px;font-size:0.75rem;font-weight:600;display:flex;align-items:center;gap:0.4rem;}
        .badge-live::before{content:'';width:7px;height:7px;background:#4ADE80;border-radius:50%;animation:pulse 1.5s infinite;}
        @keyframes pulse{0%,100%{opacity:1;}50%{opacity:0.4;}}
        .content{padding:2rem;flex:1;}

        /* STATS CARDS */
        .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.2rem;margin-bottom:2rem;}
        .stat-card{background:#161B27;border:1px solid rgba(255,255,255,0.06);border-radius:16px;padding:1.4rem;transition:transform 0.2s,border-color 0.2s;}
        .stat-card:hover{transform:translateY(-3px);border-color:rgba(255,184,0,0.2);}
        .stat-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;}
        .stat-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;}
        .stat-icon.yellow{background:rgba(255,184,0,0.15);color:#FFB800;}
        .stat-icon.green{background:rgba(34,197,94,0.15);color:#4ADE80;}
        .stat-icon.blue{background:rgba(99,102,241,0.15);color:#818CF8;}
        .stat-icon.red{background:rgba(239,68,68,0.15);color:#FCA5A5;}
        .stat-badge{font-size:0.72rem;font-weight:600;padding:0.2rem 0.5rem;border-radius:6px;}
        .stat-badge.up{background:rgba(34,197,94,0.1);color:#4ADE80;}
        .stat-badge.down{background:rgba(239,68,68,0.1);color:#FCA5A5;}
        .stat-value{font-size:1.9rem;font-weight:800;color:#fff;line-height:1;}
        .stat-label{font-size:0.78rem;color:rgba(255,255,255,0.4);margin-top:0.3rem;}

        /* CHARTS ROW */
        .charts-row{display:grid;grid-template-columns:2fr 1fr;gap:1.2rem;margin-bottom:2rem;}
        .card{background:#161B27;border:1px solid rgba(255,255,255,0.06);border-radius:16px;padding:1.5rem;}
        .card-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.2rem;}
        .card-header h3{font-size:0.95rem;font-weight:700;color:#fff;}
        .card-header span{font-size:0.75rem;color:rgba(255,255,255,0.35);}

        /* BAR CHART */
        .bar-chart{display:flex;align-items:flex-end;gap:0.6rem;height:140px;}
        .bar-wrap{flex:1;display:flex;flex-direction:column;align-items:center;gap:0.4rem;}
        .bar{width:100%;border-radius:6px 6px 0 0;background:linear-gradient(180deg,#FFB800,#FF8C00);min-height:4px;transition:height 0.5s;}
        .bar-label{font-size:0.65rem;color:rgba(255,255,255,0.3);}

        /* PLATFORM DONUT */
        .platform-list{display:flex;flex-direction:column;gap:0.75rem;}
        .platform-item{display:flex;align-items:center;gap:0.8rem;}
        .platform-dot{width:10px;height:10px;border-radius:3px;flex-shrink:0;}
        .platform-name{font-size:0.82rem;color:rgba(255,255,255,0.7);flex:1;}
        .platform-bar-wrap{width:80px;height:6px;background:rgba(255,255,255,0.06);border-radius:3px;overflow:hidden;}
        .platform-bar{height:100%;border-radius:3px;}
        .platform-pct{font-size:0.75rem;color:rgba(255,255,255,0.4);min-width:30px;text-align:right;}

        /* TABLE */
        .table-card{background:#161B27;border:1px solid rgba(255,255,255,0.06);border-radius:16px;overflow:hidden;}
        .table-head{display:flex;align-items:center;justify-content:space-between;padding:1.2rem 1.5rem;border-bottom:1px solid rgba(255,255,255,0.06);}
        .table-head h3{font-size:0.95rem;font-weight:700;color:#fff;}
        .btn-sm{background:rgba(255,184,0,0.12);border:1px solid rgba(255,184,0,0.2);color:#FFB800;padding:0.35rem 0.9rem;border-radius:8px;font-size:0.75rem;cursor:pointer;font-family:'Inter',sans-serif;font-weight:600;transition:all 0.2s;}
        .btn-sm:hover{background:rgba(255,184,0,0.2);}
        table{width:100%;border-collapse:collapse;}
        th{text-align:left;font-size:0.72rem;font-weight:600;color:rgba(255,255,255,0.3);text-transform:uppercase;letter-spacing:0.06em;padding:0.75rem 1.5rem;background:rgba(255,255,255,0.02);}
        td{padding:0.9rem 1.5rem;font-size:0.83rem;color:rgba(255,255,255,0.7);border-top:1px solid rgba(255,255,255,0.04);}
        tr:hover td{background:rgba(255,255,255,0.02);}
        .platform-tag{display:inline-flex;align-items:center;gap:0.4rem;padding:0.25rem 0.7rem;border-radius:6px;font-size:0.75rem;font-weight:600;}
        .tag-youtube{background:rgba(255,0,0,0.12);color:#FF6B6B;}
        .tag-instagram{background:rgba(228,64,95,0.12);color:#E4405F;}
        .tag-tiktok{background:rgba(0,242,234,0.12);color:#00F2EA;}
        .tag-facebook{background:rgba(24,119,242,0.12);color:#1877F2;}
        .tag-twitter{background:rgba(29,161,242,0.12);color:#1DA1F2;}
        .status-dot{width:8px;height:8px;border-radius:50%;display:inline-block;margin-right:0.4rem;}
        .status-ok{background:#4ADE80;}
        .status-fail{background:#FCA5A5;}

        /* QUICK STATS BOTTOM */
        .quick-row{display:grid;grid-template-columns:repeat(3,1fr);gap:1.2rem;margin-top:1.2rem;}
        .quick-card{background:#161B27;border:1px solid rgba(255,255,255,0.06);border-radius:16px;padding:1.2rem 1.5rem;display:flex;align-items:center;gap:1rem;}
        .quick-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0;}
        .quick-card h4{font-size:1.1rem;font-weight:700;color:#fff;}
        .quick-card p{font-size:0.75rem;color:rgba(255,255,255,0.35);margin-top:1px;}
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-wrap">
            <div class="icon"><i class="fas fa-download"></i></div>
            <div>
                <h2>Video Saver</h2>
                <p>Admin Dashboard</p>
            </div>
        </div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item active"><i class="fas fa-th-large"></i> Dashboard</a>
        <a href="{{ route('admin.homepage') }}" class="nav-item"><i class="fas fa-home"></i> Home Page</a>
        <a href="{{ route('admin.faqs') }}" class="nav-item"><i class="fas fa-question-circle"></i> Home FAQs</a>
        <a href="{{ route('admin.faq_page') }}" class="nav-item"><i class="fas fa-list-ul"></i> FAQ Page</a>
        <a href="{{ route('admin.blogs.index') }}" class="nav-item {{ Request::is('admin/blogs*') ? 'active' : '' }}"><i class="fas fa-blog"></i> Blogs</a>
        <a href="{{ route('admin.guides.index') }}" class="nav-item {{ Request::is('admin/guides*') ? 'active' : '' }}"><i class="fas fa-book"></i> Guides</a>
        <div class="nav-label">Platforms</div>
        <a href="#" class="nav-item"><i class="fab fa-youtube"></i> YouTube</a>
        <a href="#" class="nav-item"><i class="fab fa-instagram"></i> Instagram</a>
        <a href="#" class="nav-item"><i class="fab fa-tiktok"></i> TikTok</a>
        <a href="#" class="nav-item"><i class="fab fa-facebook"></i> Facebook</a>
        <div class="nav-label">System</div>
        <a href="#" class="nav-item"><i class="fas fa-cog"></i> Settings</a>
        <a href="#" class="nav-item"><i class="fas fa-shield-alt"></i> Security</a>
    </nav>
    <div class="sidebar-footer">
        <div class="admin-badge">
            <div class="admin-avatar">A</div>
            <div class="admin-info">
                <p>Administrator</p>
                <span>Super Admin</span>
            </div>
            <a href="{{ route('admin.logout') }}" class="logout-btn"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </div>
</aside>

<!-- MAIN -->
<div class="main">
    <div class="topbar">
        <h1><i class="fas fa-th-large" style="color:#FFB800;margin-right:0.5rem;"></i> Dashboard Overview</h1>
        <div class="topbar-right">
            <div class="badge-live">System Live</div>
            <span style="font-size:0.8rem;color:rgba(255,255,255,0.3);">{{ now()->format('D, d M Y') }}</span>
        </div>
    </div>

    <div class="content">

        <!-- STATS -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon yellow"><i class="fas fa-download"></i></div>
                    <span class="stat-badge up">↑ 12%</span>
                </div>
                <div class="stat-value">{{ number_format($stats['total_downloads']) }}</div>
                <div class="stat-label">Total Downloads</div>
            </div>
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon green"><i class="fas fa-calendar-day"></i></div>
                    <span class="stat-badge up">↑ 8%</span>
                </div>
                <div class="stat-value">{{ number_format($stats['today_downloads']) }}</div>
                <div class="stat-label">Today's Downloads</div>
            </div>
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon blue"><i class="fas fa-search"></i></div>
                    <span class="stat-badge up">↑ 5%</span>
                </div>
                <div class="stat-value">{{ number_format($stats['total_extractions']) }}</div>
                <div class="stat-label">Total Extractions</div>
            </div>
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon red"><i class="fas fa-users"></i></div>
                    <span class="stat-badge up">↑ 3%</span>
                </div>
                <div class="stat-value">{{ number_format($stats['active_users']) }}</div>
                <div class="stat-label">Active Users</div>
            </div>
        </div>

        <!-- CHARTS -->
        <div class="charts-row">
            <div class="card">
                <div class="card-header">
                    <h3>Downloads (Last 7 Days)</h3>
                    <span>Weekly overview</span>
                </div>
                <div class="bar-chart">
                    @php
                        $days = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
                        $vals = [45,72,58,91,67,110,88];
                        $max = max($vals);
                    @endphp
                    @foreach($days as $i => $day)
                    <div class="bar-wrap">
                        <div class="bar" style="height:{{ round(($vals[$i]/$max)*120) }}px;" title="{{ $vals[$i] }} downloads"></div>
                        <div class="bar-label">{{ $day }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>By Platform</h3>
                    <span>Top sources</span>
                </div>
                <div class="platform-list">
                    @php
                        $platforms = [
                            ['YouTube','#FF0000',72],
                            ['Instagram','#E4405F',58],
                            ['TikTok','#00F2EA',44],
                            ['Facebook','#1877F2',31],
                            ['Twitter','#1DA1F2',18],
                        ];
                    @endphp
                    @foreach($platforms as $p)
                    <div class="platform-item">
                        <div class="platform-dot" style="background:{{ $p[1] }};"></div>
                        <span class="platform-name">{{ $p[0] }}</span>
                        <div class="platform-bar-wrap">
                            <div class="platform-bar" style="width:{{ $p[2] }}%;background:{{ $p[1] }};"></div>
                        </div>
                        <span class="platform-pct">{{ $p[2] }}%</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- RECENT DOWNLOADS TABLE -->
        <div class="table-card">
            <div class="table-head">
                <h3>Recent Download Activity</h3>
                <button class="btn-sm"><i class="fas fa-sync-alt"></i> Refresh</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Platform</th>
                        <th>Format</th>
                        <th>Quality</th>
                        <th>IP Address</th>
                        <th>Status</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sample = [
                            ['YouTube','MP4','1080p','192.168.1.1','ok','2 min ago'],
                            ['Instagram','MP4','720p','10.0.0.5','ok','5 min ago'],
                            ['TikTok','MP3','Audio','172.16.0.3','ok','8 min ago'],
                            ['Facebook','MP4','480p','192.168.2.10','fail','12 min ago'],
                            ['YouTube','MP4','4K','10.0.1.7','ok','15 min ago'],
                            ['Twitter','MP4','720p','172.16.1.2','ok','18 min ago'],
                        ];
                        $tagMap = ['YouTube'=>'tag-youtube','Instagram'=>'tag-instagram','TikTok'=>'tag-tiktok','Facebook'=>'tag-facebook','Twitter'=>'tag-twitter'];
                    @endphp
                    @foreach($sample as $i => $row)
                    <tr>
                        <td style="color:rgba(255,255,255,0.25);">{{ $i+1 }}</td>
                        <td><span class="platform-tag {{ $tagMap[$row[0]] }}"><i class="fab fa-{{ strtolower($row[0]) }}"></i> {{ $row[0] }}</span></td>
                        <td>{{ $row[1] }}</td>
                        <td>{{ $row[2] }}</td>
                        <td style="font-family:monospace;font-size:0.8rem;">{{ $row[3] }}</td>
                        <td>
                            <span class="status-dot {{ $row[4]==='ok' ? 'status-ok' : 'status-fail' }}"></span>
                            {{ $row[4]==='ok' ? 'Success' : 'Failed' }}
                        </td>
                        <td style="color:rgba(255,255,255,0.35);">{{ $row[5] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- QUICK STATS -->
        <div class="quick-row">
            <div class="quick-card">
                <div class="quick-icon" style="background:rgba(255,184,0,0.12);color:#FFB800;"><i class="fas fa-bolt"></i></div>
                <div><h4>99.2%</h4><p>Uptime (30 days)</p></div>
            </div>
            <div class="quick-card">
                <div class="quick-icon" style="background:rgba(34,197,94,0.12);color:#4ADE80;"><i class="fas fa-tachometer-alt"></i></div>
                <div><h4>1.2s</h4><p>Avg. Extract Time</p></div>
            </div>
            <div class="quick-card">
                <div class="quick-icon" style="background:rgba(99,102,241,0.12);color:#818CF8;"><i class="fas fa-hdd"></i></div>
                <div><h4>4.3 GB</h4><p>Bandwidth Served</p></div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
