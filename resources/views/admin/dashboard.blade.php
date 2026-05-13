<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard — Video Saver Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Inter',sans-serif;background:#0F1117;color:#E2E8F0;display:flex;min-height:100vh;}
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
        .main{margin-left:220px;flex:1;display:flex;flex-direction:column;min-height:100vh;}
        .topbar{background:#161B27;border-bottom:1px solid rgba(255,255,255,0.06);padding:1rem 2rem;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50;}
        .topbar h1{font-size:1.2rem;font-weight:700;color:#fff;}
        .topbar-right{display:flex;align-items:center;gap:1rem;}
        .badge-live{background:rgba(34,197,94,0.15);border:1px solid rgba(34,197,94,0.3);color:#4ADE80;padding:0.3rem 0.8rem;border-radius:20px;font-size:0.75rem;font-weight:600;display:flex;align-items:center;gap:0.4rem;}
        .badge-live::before{content:'';width:7px;height:7px;background:#4ADE80;border-radius:50%;animation:pulse 1.5s infinite;}
        @keyframes pulse{0%,100%{opacity:1;}50%{opacity:0.4;}}
        .content{padding:2rem;flex:1;}
        .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.2rem;margin-bottom:2rem;}
        .stat-card{background:#161B27;border:1px solid rgba(255,255,255,0.06);border-radius:16px;padding:1.4rem;transition:transform 0.2s,border-color 0.2s;}
        .stat-card:hover{transform:translateY(-3px);border-color:rgba(255,184,0,0.2);}
        .stat-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;}
        .stat-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;}
        .stat-icon.yellow{background:rgba(255,184,0,0.15);color:#FFB800;}
        .stat-icon.green{background:rgba(34,197,94,0.15);color:#4ADE80;}
        .stat-icon.blue{background:rgba(99,102,241,0.15);color:#818CF8;}
        .stat-icon.red{background:rgba(239,68,68,0.15);color:#FCA5A5;}
        .stat-badge{font-size:0.72rem;font-weight:600;padding:0.2rem 0.5rem;border-radius:6px;background:rgba(34,197,94,0.1);color:#4ADE80;}
        .stat-value{font-size:1.9rem;font-weight:800;color:#fff;line-height:1;}
        .stat-label{font-size:0.78rem;color:rgba(255,255,255,0.4);margin-top:0.3rem;}
        .charts-row{display:grid;grid-template-columns:2fr 1fr;gap:1.2rem;margin-bottom:2rem;}
        .card{background:#161B27;border:1px solid rgba(255,255,255,0.06);border-radius:16px;padding:1.5rem;}
        .card-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.2rem;}
        .card-header h3{font-size:0.95rem;font-weight:700;color:#fff;}
        .card-header span{font-size:0.75rem;color:rgba(255,255,255,0.35);}
        .bar-chart{display:flex;align-items:flex-end;gap:0.6rem;height:140px;}
        .bar-wrap{flex:1;display:flex;flex-direction:column;align-items:center;gap:0.4rem;}
        .bar{width:100%;border-radius:6px 6px 0 0;background:linear-gradient(180deg,#FFB800,#FF8C00);min-height:4px;transition:height 0.5s;}
        .bar-label{font-size:0.65rem;color:rgba(255,255,255,0.3);}
        .bar-count{font-size:0.6rem;color:rgba(255,255,255,0.25);margin-bottom:2px;}
        .platform-list{display:flex;flex-direction:column;gap:0.75rem;}
        .platform-item{display:flex;align-items:center;gap:0.8rem;}
        .platform-dot{width:10px;height:10px;border-radius:3px;flex-shrink:0;}
        .platform-name{font-size:0.82rem;color:rgba(255,255,255,0.7);flex:1;}
        .platform-bar-wrap{width:80px;height:6px;background:rgba(255,255,255,0.06);border-radius:3px;overflow:hidden;}
        .platform-bar{height:100%;border-radius:3px;transition:width 0.6s ease;}
        .platform-pct{font-size:0.75rem;color:rgba(255,255,255,0.4);min-width:30px;text-align:right;}
        .table-card{background:#161B27;border:1px solid rgba(255,255,255,0.06);border-radius:16px;overflow:hidden;}
        .table-head{display:flex;align-items:center;justify-content:space-between;padding:1.2rem 1.5rem;border-bottom:1px solid rgba(255,255,255,0.06);}
        .table-head h3{font-size:0.95rem;font-weight:700;color:#fff;}
        .btn-sm{background:rgba(255,184,0,0.12);border:1px solid rgba(255,184,0,0.2);color:#FFB800;padding:0.35rem 0.9rem;border-radius:8px;font-size:0.75rem;cursor:pointer;font-family:'Inter',sans-serif;font-weight:600;transition:all 0.2s;display:inline-flex;align-items:center;gap:0.4rem;}
        .btn-sm:hover{background:rgba(255,184,0,0.2);}
        .btn-sm.spinning i{animation:spin 1s linear infinite;}
        @keyframes spin{from{transform:rotate(0deg);}to{transform:rotate(360deg)}}
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
        .tag-other{background:rgba(107,114,128,0.15);color:#9CA3AF;}
        .status-dot{width:8px;height:8px;border-radius:50%;display:inline-block;margin-right:0.4rem;}
        .status-ok{background:#4ADE80;}
        .status-fail{background:#FCA5A5;}
        .quick-row{display:grid;grid-template-columns:repeat(3,1fr);gap:1.2rem;margin-top:1.2rem;}
        .quick-card{background:#161B27;border:1px solid rgba(255,255,255,0.06);border-radius:16px;padding:1.2rem 1.5rem;display:flex;align-items:center;gap:1rem;}
        .quick-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0;}
        .quick-card h4{font-size:1.1rem;font-weight:700;color:#fff;}
        .quick-card p{font-size:0.75rem;color:rgba(255,255,255,0.35);margin-top:1px;}
        .empty-row td{text-align:center;color:rgba(255,255,255,0.25);padding:2rem;font-size:0.85rem;}
    </style>
</head>
<body>

@include('partials.admin_sidebar')

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
                    <span class="stat-badge">Total</span>
                </div>
                <div class="stat-value" id="stat-total-downloads">{{ number_format($stats['total_downloads']) }}</div>
                <div class="stat-label">Total Downloads</div>
            </div>
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon green"><i class="fas fa-calendar-day"></i></div>
                    <span class="stat-badge">Today</span>
                </div>
                <div class="stat-value" id="stat-today-downloads">{{ number_format($stats['today_downloads']) }}</div>
                <div class="stat-label">Today's Downloads</div>
            </div>
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon blue"><i class="fas fa-search"></i></div>
                    <span class="stat-badge">Total</span>
                </div>
                <div class="stat-value" id="stat-extractions">{{ number_format($stats['total_extractions']) }}</div>
                <div class="stat-label">Total Extractions</div>
            </div>
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon red"><i class="fas fa-users"></i></div>
                    <span class="stat-badge">30 min</span>
                </div>
                <div class="stat-value" id="stat-active-users">{{ number_format($stats['active_users']) }}</div>
                <div class="stat-label">Active Users</div>
            </div>
        </div>

        <!-- CHARTS -->
        <div class="charts-row">
            <!-- Bar Chart -->
            <div class="card">
                <div class="card-header">
                    <h3>Downloads (Last 7 Days)</h3>
                    <span>Weekly overview</span>
                </div>
                <div class="bar-chart" id="bar-chart">
                    @php $maxVal = max(array_column($weeklyData, 'count') ?: [1]); @endphp
                    @foreach($weeklyData as $day)
                    <div class="bar-wrap">
                        <div class="bar-count">{{ $day['count'] > 0 ? $day['count'] : '' }}</div>
                        <div class="bar"
                             style="height:{{ $maxVal > 0 ? round(($day['count'] / $maxVal) * 120) : 4 }}px;"
                             title="{{ $day['count'] }} on {{ $day['label'] }}"></div>
                        <div class="bar-label">{{ $day['label'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Platform Breakdown -->
            <div class="card">
                <div class="card-header">
                    <h3>By Platform</h3>
                    <span>Top sources</span>
                </div>
                <div class="platform-list" id="platform-list">
                    @foreach($platformData as $p)
                    <div class="platform-item">
                        <div class="platform-dot" style="background:{{ $p['color'] }};"></div>
                        <span class="platform-name">{{ $p['name'] }}</span>
                        <div class="platform-bar-wrap">
                            <div class="platform-bar" style="width:{{ $p['pct'] }}%;background:{{ $p['color'] }};"></div>
                        </div>
                        <span class="platform-pct">{{ $p['pct'] }}%</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- RECENT DOWNLOADS TABLE -->
        <div class="table-card">
            <div class="table-head">
                <h3>Recent Download Activity</h3>
                <button class="btn-sm" id="refreshBtn" onclick="refreshDashboard()">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Platform</th>
                        <th>Type</th>
                        <th>Format</th>
                        <th>Quality</th>
                        <th>IP Address</th>
                        <th>Status</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody id="activity-tbody">
                    @forelse($recentLogs as $i => $log)
                    <tr>
                        <td style="color:rgba(255,255,255,0.25);">{{ $i + 1 }}</td>
                        <td>
                            @php
                                $platformKey = strtolower($log->platform ?? '');
                                switch($platformKey) {
                                    case 'youtube':   $tagClass = 'tag-youtube';   $fabIcon = 'fa-youtube'; break;
                                    case 'instagram': $tagClass = 'tag-instagram'; $fabIcon = 'fa-instagram'; break;
                                    case 'tiktok':    $tagClass = 'tag-tiktok';    $fabIcon = 'fa-tiktok'; break;
                                    case 'facebook':  $tagClass = 'tag-facebook';  $fabIcon = 'fa-facebook'; break;
                                    case 'twitter':   $tagClass = 'tag-twitter';   $fabIcon = 'fa-twitter'; break;
                                    default:          $tagClass = 'tag-other';     $fabIcon = 'fa-globe'; break;
                                }
                            @endphp
                            <span class="platform-tag {{ $tagClass }}">
                                <i class="fab {{ $fabIcon }}"></i> {{ $log->platform }}
                            </span>
                        </td>
                        <td style="text-transform:capitalize;font-size:0.78rem;color:rgba(255,255,255,0.4);">{{ $log->type }}</td>
                        <td>{{ $log->format }}</td>
                        <td>{{ $log->quality }}</td>
                        <td style="font-family:monospace;font-size:0.8rem;">{{ $log->ip_address }}</td>
                        <td>
                            <span class="status-dot {{ $log->status ? 'status-ok' : 'status-fail' }}"></span>
                            {{ $log->status ? 'Success' : 'Failed' }}
                        </td>
                        <td style="color:rgba(255,255,255,0.35);" title="{{ $log->created_at }}">
                            {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="8">
                            <i class="fas fa-inbox" style="font-size:1.5rem;display:block;margin-bottom:0.5rem;"></i>
                            No activity yet. Downloads and extractions will appear here.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- QUICK STATS -->
        <div class="quick-row">
            <div class="quick-card">
                <div class="quick-icon" style="background:rgba(255,184,0,0.12);color:#FFB800;"><i class="fas fa-bolt"></i></div>
                <div>
                    <h4 id="quick-success-rate">
                        @php
                            $total = count($recentLogs);
                            $success = collect($recentLogs)->where('status', 1)->count();
                            echo $total > 0 ? round(($success / $total) * 100, 1) . '%' : '—';
                        @endphp
                    </h4>
                    <p>Success Rate (Recent)</p>
                </div>
            </div>
            <div class="quick-card">
                <div class="quick-icon" style="background:rgba(34,197,94,0.12);color:#4ADE80;"><i class="fas fa-calendar-week"></i></div>
                <div>
                    <h4 id="quick-week-total">{{ array_sum(array_column($weeklyData, 'count')) }}</h4>
                    <p>Events This Week</p>
                </div>
            </div>
            <div class="quick-card">
                <div class="quick-icon" style="background:rgba(99,102,241,0.12);color:#818CF8;"><i class="fas fa-layer-group"></i></div>
                <div>
                    <h4 id="quick-top-platform">{{ $platformData[0]['name'] ?? '—' }}</h4>
                    <p>Top Platform</p>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
const tagMap = {
    youtube:   ['tag-youtube',   'fa-youtube'],
    instagram: ['tag-instagram', 'fa-instagram'],
    tiktok:    ['tag-tiktok',    'fa-tiktok'],
    facebook:  ['tag-facebook',  'fa-facebook'],
    twitter:   ['tag-twitter',   'fa-twitter'],
};

function platformTag(name) {
    const key = (name || '').toLowerCase();
    const [cls, icon] = tagMap[key] || ['tag-other', 'fa-globe'];
    return `<span class="platform-tag ${cls}"><i class="fab ${icon}"></i> ${name}</span>`;
}

function timeAgo(dateStr) {
    const diff = Math.floor((Date.now() - new Date(dateStr)) / 1000);
    if (diff < 60)  return diff + 's ago';
    if (diff < 3600) return Math.floor(diff/60) + ' min ago';
    if (diff < 86400) return Math.floor(diff/3600) + 'h ago';
    return Math.floor(diff/86400) + 'd ago';
}

async function refreshDashboard() {
    const btn = document.getElementById('refreshBtn');
    btn.classList.add('spinning');
    btn.disabled = true;

    try {
        const res = await fetch('/admin/dashboard-data', {
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        });
        const d = await res.json();

        // Update stat cards
        document.getElementById('stat-total-downloads').textContent = d.stats.total_downloads.toLocaleString();
        document.getElementById('stat-today-downloads').textContent = d.stats.today_downloads.toLocaleString();
        document.getElementById('stat-extractions').textContent     = d.stats.total_extractions.toLocaleString();
        document.getElementById('stat-active-users').textContent    = d.stats.active_users.toLocaleString();

        // Update bar chart
        const maxVal = Math.max(...d.weeklyData.map(x => x.count), 1);
        const chart  = document.getElementById('bar-chart');
        chart.innerHTML = d.weeklyData.map(day => `
            <div class="bar-wrap">
                <div class="bar-count">${day.count > 0 ? day.count : ''}</div>
                <div class="bar" style="height:${Math.max(4, Math.round((day.count / maxVal) * 120))}px;"
                     title="${day.count} on ${day.label}"></div>
                <div class="bar-label">${day.label}</div>
            </div>`).join('');

        // Update platform list
        const pl = document.getElementById('platform-list');
        pl.innerHTML = d.platformData.map(p => `
            <div class="platform-item">
                <div class="platform-dot" style="background:${p.color};"></div>
                <span class="platform-name">${p.name}</span>
                <div class="platform-bar-wrap">
                    <div class="platform-bar" style="width:${p.pct}%;background:${p.color};"></div>
                </div>
                <span class="platform-pct">${p.pct}%</span>
            </div>`).join('');

        // Update activity table
        const tbody = document.getElementById('activity-tbody');
        if (!d.recentLogs.length) {
            tbody.innerHTML = `<tr class="empty-row"><td colspan="8"><i class="fas fa-inbox" style="font-size:1.5rem;display:block;margin-bottom:0.5rem;"></i>No activity yet.</td></tr>`;
        } else {
            tbody.innerHTML = d.recentLogs.map((log, i) => `
                <tr>
                    <td style="color:rgba(255,255,255,0.25);">${i+1}</td>
                    <td>${platformTag(log.platform)}</td>
                    <td style="text-transform:capitalize;font-size:0.78rem;color:rgba(255,255,255,0.4);">${log.type}</td>
                    <td>${log.format}</td>
                    <td>${log.quality}</td>
                    <td style="font-family:monospace;font-size:0.8rem;">${log.ip_address || '—'}</td>
                    <td><span class="status-dot ${log.status ? 'status-ok' : 'status-fail'}"></span>${log.status ? 'Success' : 'Failed'}</td>
                    <td style="color:rgba(255,255,255,0.35);">${timeAgo(log.created_at)}</td>
                </tr>`).join('');
        }

        // Update quick stats
        const total   = d.recentLogs.length;
        const success = d.recentLogs.filter(l => l.status).length;
        document.getElementById('quick-success-rate').textContent  = total > 0 ? Math.round((success/total)*100) + '%' : '—';
        document.getElementById('quick-week-total').textContent    = d.weeklyData.reduce((a,x) => a+x.count, 0);
        document.getElementById('quick-top-platform').textContent  = d.platformData[0]?.name || '—';

    } catch(e) {
        console.error('Refresh failed:', e);
    } finally {
        btn.classList.remove('spinning');
        btn.disabled = false;
    }
}

// Auto-refresh every 60 seconds
setInterval(refreshDashboard, 60000);
</script>
</body>
</html>
