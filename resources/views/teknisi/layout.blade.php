<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Dashboard Teknisi') | HomeFix</title>
<style>
:root{--navy:#0f172a;--green:#166534;--green2:#15803d;--pale:#dcfce7;--bg:#f8fafc;--text:#1e293b;--muted:#64748b;--line:#e2e8f0;--white:#fff}
*{box-sizing:border-box}body{margin:0;background:var(--bg);font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif;color:var(--text)}
.sidebar{position:fixed;inset:0 auto 0 0;width:250px;background:var(--navy);color:#cbd5e1;padding:25px 16px;display:flex;flex-direction:column;z-index:5}
.brand{display:flex;align-items:center;gap:11px;padding:0 10px 27px;border-bottom:1px solid #263246}.brand-mark{display:grid;place-items:center;width:40px;height:40px;background:#166534;border-radius:12px;color:#fff;font-size:21px;font-weight:800}.brand strong{display:block;color:#fff;font-size:19px}.brand small{display:block;color:#94a3b8;margin-top:3px}
.nav-label{font-size:10px;letter-spacing:1.5px;color:#64748b;font-weight:800;padding:25px 12px 10px}.nav-link{display:flex;align-items:center;gap:12px;padding:12px;border-radius:10px;color:#cbd5e1;text-decoration:none;font-size:14px;margin:3px 0}.nav-link .ico{width:20px;text-align:center;font-size:17px}.nav-link.active,.nav-link:hover{background:#166534;color:white;font-weight:700}
.side-bottom{margin-top:auto;border-top:1px solid #263246;padding-top:15px}.user-mini{display:flex;align-items:center;gap:10px;padding:10px}.avatar{width:38px;height:38px;border-radius:50%;display:grid;place-items:center;background:#dcfce7;color:#166534;font-weight:800}.user-mini strong{display:block;color:white;font-size:13px}.user-mini small{color:#94a3b8;font-size:11px}
.main{margin-left:250px;padding:28px 32px 40px;max-width:1800px}.topbar{display:flex;justify-content:space-between;align-items:center;gap:18px;margin-bottom:25px}.eyebrow{font-size:12px;color:var(--muted);margin:0 0 6px}.topbar h1{font-size:26px;letter-spacing:-.5px;margin:0;color:#0f172a}.date-chip{background:white;border:1px solid var(--line);border-radius:10px;padding:10px 13px;font-size:12px;color:#475569}
.welcome{background:linear-gradient(110deg,#14532d,#166534 60%,#15803d);border-radius:16px;color:white;padding:24px 26px;display:flex;align-items:center;justify-content:space-between;gap:20px;margin-bottom:22px;box-shadow:0 8px 22px #16653418}.welcome h2{font-size:21px;margin:0 0 7px}.welcome p{font-size:13px;color:#dcfce7;margin:0;line-height:1.6}.welcome-icon{font-size:43px;opacity:.9;padding:0 12px}
.stats{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px;margin-bottom:25px}.stat{background:white;border:1px solid var(--line);border-radius:14px;padding:19px;min-width:0}.stat-head{display:flex;align-items:center;justify-content:space-between;gap:8px}.stat-label{font-size:12px;color:var(--muted);font-weight:700}.stat-icon{width:37px;height:37px;display:grid;place-items:center;background:#f0fdf4;color:#15803d;border-radius:11px;font-size:18px}.stat-number{font-size:29px;font-weight:800;letter-spacing:-.7px;margin:14px 0 5px;color:#0f172a}.stat-note{font-size:11px;color:#94a3b8}
.panel{background:white;border:1px solid var(--line);border-radius:14px;overflow:hidden;margin-bottom:20px}.panel-head{display:flex;justify-content:space-between;align-items:center;gap:12px;padding:21px 22px;border-bottom:1px solid var(--line)}.panel-head h2{font-size:16px;margin:0}.panel-head p{font-size:12px;color:var(--muted);margin:5px 0 0}.count-pill{font-size:11px;background:#f1f5f9;color:#475569;border-radius:20px;padding:7px 10px;white-space:nowrap}
.table-wrap{overflow-x:auto}table{width:100%;border-collapse:collapse;min-width:750px}th{text-align:left;background:#f8fafc;color:#64748b;font-size:10px;letter-spacing:.6px;text-transform:uppercase;padding:13px 18px;font-weight:800}td{padding:15px 18px;border-top:1px solid #f1f5f9;font-size:12px;vertical-align:middle}tbody tr:hover{background:#fcfdfc}.booking-code{font-weight:800;color:#166534;font-size:12px}.customer{font-weight:700;color:#1e293b;font-size:12px}.subtext{display:block;font-size:11px;color:#94a3b8;margin-top:4px}.price{font-weight:800;white-space:nowrap}.status{display:inline-flex;border-radius:20px;padding:6px 9px;font-size:10px;font-weight:800;white-space:nowrap}.status.menunggu{background:#fef3c7;color:#92400e}.status.dikonfirmasi{background:#dbeafe;color:#1d4ed8}.status.diproses,.status.sedang_dikerjakan{background:#dbeafe;color:#1e40af}.status.selesai{background:#dcfce7;color:#166534}.status.dibatalkan{background:#fee2e2;color:#991b1b}
.empty{text-align:center;padding:44px 20px;color:#64748b}.empty-icon{font-size:35px;margin-bottom:10px}.empty strong{display:block;color:#334155;margin-bottom:5px}.empty p{font-size:12px;margin:0}.pagination{padding:16px 20px;border-top:1px solid var(--line);font-size:12px}
.alert{padding:13px 16px;border-radius:10px;margin-bottom:18px;font-size:13px}.alert.success{background:#dcfce7;color:#166534}.alert.error{background:#fee2e2;color:#991b1b}.form-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:13px;align-items:end;padding:18px 22px}.field label{display:block;font-size:11px;font-weight:700;color:#475569;margin-bottom:7px}.field input,.field select{width:100%;border:1px solid #cbd5e1;border-radius:8px;padding:10px 11px;background:white;font:inherit;font-size:12px}.btn{display:inline-block;border:0;border-radius:8px;padding:10px 13px;background:#166534;color:#fff;font-weight:700;font-size:12px;text-decoration:none;cursor:pointer}.btn.secondary{background:#e2e8f0;color:#334155}.btn.danger{background:#fee2e2;color:#991b1b}.btn.small{padding:7px 9px;font-size:11px}.inline-form{display:flex;gap:6px;align-items:center}.inline-form select{max-width:155px;border:1px solid #cbd5e1;border-radius:7px;padding:7px;font-size:11px}.day-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}.day-card{background:white;border:1px solid var(--line);border-radius:14px;padding:18px}.day-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px}.day-top h3{margin:0;font-size:15px}.switch-label{display:flex;align-items:center;gap:7px;font-size:11px;color:#475569}.day-fields{display:grid;grid-template-columns:1fr 1fr;gap:12px}.day-fields .field{min-width:0}.day-card .btn{margin-top:15px;width:100%}.footer-note{text-align:center;color:#94a3b8;font-size:11px;padding:22px 0 0}
@media(max-width:1100px){.stats{grid-template-columns:repeat(2,minmax(0,1fr))}.main{padding:24px 22px}.form-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:720px){.sidebar{position:relative;width:100%;height:auto;padding:15px 14px}.brand{padding-bottom:14px}.nav-label{padding-top:13px}.sidebar nav{display:flex;overflow:auto;gap:5px}.nav-link{white-space:nowrap;padding:10px}.nav-link .ico{display:none}.side-bottom{display:none}.main{margin-left:0;padding:22px 15px 30px}.topbar{align-items:flex-start}.topbar h1{font-size:22px}.date-chip{font-size:10px;padding:8px}.welcome{padding:20px}.welcome-icon{display:none}.stats{gap:10px}.stat{padding:14px}.stat-number{font-size:25px}.stat-label{font-size:10px}.panel-head{padding:17px}.day-grid{grid-template-columns:1fr}.form-grid{grid-template-columns:1fr 1fr}}
@media(max-width:390px){.stats{grid-template-columns:1fr 1fr}.stat-number{font-size:22px}.form-grid{grid-template-columns:1fr}}
</style>
</head>
<body>
<aside class="sidebar">
    <div class="brand"><div class="brand-mark">H</div><div><strong>HomeFix</strong><small>Technician Panel</small></div></div>
    <div class="nav-label">MENU UTAMA</div>
    <nav>
        <a class="nav-link {{ request()->routeIs('teknisi.dashboard') ? 'active' : '' }}" href="{{ route('teknisi.dashboard') }}"><span class="ico">▦</span>Dashboard</a>
        <a class="nav-link {{ request()->routeIs('teknisi.pesanan*') ? 'active' : '' }}" href="{{ route('teknisi.pesanan') }}"><span class="ico">▤</span>Pesanan</a>
        <a class="nav-link {{ request()->routeIs('teknisi.jadwal*') ? 'active' : '' }}" href="{{ route('teknisi.jadwal') }}"><span class="ico">◷</span>Jadwal</a>
    </nav>
    <div class="nav-label">AKUN</div>
    <nav><a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}"><span class="ico">◎</span>Profil Saya</a></nav>
    <div class="side-bottom">
        <div class="user-mini"><div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'T', 0, 1)) }}</div><div><strong>{{ auth()->user()->name }}</strong><small>Teknisi HomeFix</small></div></div>
        <form method="POST" action="{{ route('logout') }}" style="padding:0 10px">@csrf<button type="submit" style="width:100%;border:0;background:#1e293b;color:#e2e8f0;padding:11px;border-radius:9px;text-align:left;cursor:pointer;font-weight:700">↪ &nbsp; Keluar</button></form>
    </div>
</aside>
<main class="main">
    <header class="topbar"><div><p class="eyebrow">HomeFix / Panel Teknisi</p><h1>@yield('heading', 'Dashboard')</h1></div><div class="date-chip">◷ &nbsp; {{ now()->locale('id')->translatedFormat('l, d F Y') }}</div></header>
    @if (session('success'))<div class="alert success">{{ session('success') }}</div>@endif
    @if (session('error'))<div class="alert error">{{ session('error') }}</div>@endif
    @if ($errors->any())<div class="alert error">@foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
    @yield('content')
    <div class="footer-note">© {{ date('Y') }} HomeFix · Panel Teknisi</div>
</main>
</body>
</html>
