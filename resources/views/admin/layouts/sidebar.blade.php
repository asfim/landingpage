<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Admin Panel')</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
  :root {
    --primary: #6366f1;
    --primary-dark: #4f46e5;
    --bg-dark: #0f0f1a;
    --bg-card: rgba(255,255,255,0.04);
    --bg-sidebar: rgba(15,15,26,0.95);
    --border: rgba(255,255,255,0.08);
    --text-primary: #f1f5f9;
    --text-secondary: #94a3b8;
    --sidebar-w: 260px;
    --topbar-h: 64px;
  }
  html, body { height: 100%; }
  body {
    font-family: 'Inter', sans-serif;
    background: var(--bg-dark);
    color: var(--text-primary);
    display: flex;
    min-height: 100vh;
  }

  /* ── BG Gradient ─────────────────────────────── */
  .bg-gradient {
    position: fixed; inset: 0; z-index: 0; pointer-events: none;
    background:
      radial-gradient(ellipse 60% 40% at 10% 10%, rgba(99,102,241,0.10) 0%, transparent 60%),
      radial-gradient(ellipse 40% 60% at 90% 90%, rgba(139,92,246,0.08) 0%, transparent 60%);
  }

  /* ── Sidebar ─────────────────────────────────── */
  .sidebar {
    position: fixed; top: 0; left: 0;
    width: var(--sidebar-w); height: 100vh;
    background: var(--bg-sidebar);
    border-right: 1px solid var(--border);
    backdrop-filter: blur(20px);
    display: flex; flex-direction: column;
    z-index: 100;
    transition: transform 0.3s ease;
  }
  .sidebar-brand {
    height: var(--topbar-h);
    display: flex; align-items: center; gap: 0.75rem;
    padding: 0 1.25rem;
    border-bottom: 1px solid var(--border);
    flex-shrink: 0;
  }
  .sidebar-brand-icon {
    width: 36px; height: 36px; border-radius: 10px;
    background: linear-gradient(135deg, var(--primary), #8b5cf6);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .sidebar-brand-text { font-weight: 700; font-size: 1rem; }
  .sidebar-brand-sub  { font-size: 0.7rem; color: var(--text-secondary); }

  .sidebar-nav { flex: 1; overflow-y: auto; padding: 1rem 0; }
  .sidebar-section-label {
    font-size: 0.65rem; font-weight: 700; letter-spacing: 1.5px;
    text-transform: uppercase; color: var(--text-secondary);
    padding: 0.75rem 1.25rem 0.25rem;
  }

  .nav-item { position: relative; }
  .nav-link {
    display: flex; align-items: center; gap: 0.75rem;
    padding: 0.6rem 1.25rem;
    color: var(--text-secondary);
    text-decoration: none; font-size: 0.875rem; font-weight: 500;
    border-radius: 0;
    transition: color 0.2s, background 0.2s;
    cursor: pointer; user-select: none;
    border: none; background: none; width: 100%; text-align: left;
    font-family: 'Inter', sans-serif;
  }
  .nav-link:hover { color: var(--text-primary); background: rgba(255,255,255,0.05); }
  .nav-link.active { color: var(--primary); background: rgba(99,102,241,0.1); }
  .nav-link .nav-icon { width: 18px; height: 18px; flex-shrink: 0; opacity: 0.8; }
  .nav-link .nav-chevron {
    margin-left: auto;
    width: 14px; height: 14px; opacity: 0.6;
    transition: transform 0.2s;
  }
  .nav-link.open .nav-chevron { transform: rotate(90deg); }

  /* Sub-menu */
  .nav-submenu {
    max-height: 0; overflow: hidden;
    transition: max-height 0.3s ease;
    background: rgba(0,0,0,0.15);
  }
  .nav-submenu.open { max-height: 200px; }
  .nav-submenu .nav-link {
    padding-left: 3.25rem; font-size: 0.82rem;
  }
  .nav-submenu .nav-link .sub-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: var(--text-secondary); flex-shrink: 0;
    transition: background 0.2s;
  }
  .nav-submenu .nav-link.active .sub-dot,
  .nav-submenu .nav-link:hover .sub-dot { background: var(--primary); }

  /* Sidebar footer */
  .sidebar-footer {
    padding: 1rem 1.25rem;
    border-top: 1px solid var(--border);
    display: flex; align-items: center; gap: 0.75rem;
  }
  .sidebar-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), #8b5cf6);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.875rem; font-weight: 700; color: white; flex-shrink: 0;
  }
  .sidebar-user-info { flex: 1; min-width: 0; }
  .sidebar-user-name { font-size: 0.875rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .sidebar-user-role { font-size: 0.7rem; color: var(--text-secondary); }
  .sidebar-logout-btn {
    display: flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 8px;
    background: rgba(248,113,113,0.1); border: 1px solid rgba(248,113,113,0.2);
    color: #f87171; cursor: pointer; transition: all 0.2s;
    flex-shrink: 0;
  }
  .sidebar-logout-btn:hover { background: rgba(248,113,113,0.2); }

  /* ── Top-bar ─────────────────────────────────── */
  .topbar {
    position: fixed; top: 0; left: var(--sidebar-w); right: 0;
    height: var(--topbar-h);
    background: rgba(15,15,26,0.85); backdrop-filter: blur(16px);
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 2rem; z-index: 90;
  }
  .topbar-breadcrumb { display: flex; align-items: center; gap: 0.5rem; }
  .topbar-breadcrumb span { font-size: 0.875rem; color: var(--text-secondary); }
  .topbar-breadcrumb .sep { opacity: 0.4; }
  .topbar-breadcrumb .current { color: var(--text-primary); font-weight: 600; }
  .topbar-actions { display: flex; align-items: center; gap: 0.75rem; }
  .topbar-badge {
    display: flex; align-items: center; gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    background: rgba(52,211,153,0.1); border: 1px solid rgba(52,211,153,0.2);
    border-radius: 20px; font-size: 0.75rem; color: #34d399; font-weight: 500;
  }
  .topbar-badge .dot { width: 6px; height: 6px; border-radius: 50%; background: #34d399; }

  /* ── Main Content ─────────────────────────────── */
  .admin-layout {
    margin-left: var(--sidebar-w);
    padding-top: var(--topbar-h);
    flex: 1; min-height: 100vh;
    position: relative; z-index: 1;
  }
  .page-content { padding: 2rem; }

  /* ── Mobile toggle ────────────────────────────── */
  .sidebar-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,0.5); z-index: 99;
  }
  .mobile-menu-btn {
    display: none; background: none; border: none;
    color: var(--text-primary); cursor: pointer; padding: 0.5rem;
  }

  @media (max-width: 768px) {
    .sidebar { transform: translateX(-100%); }
    .sidebar.open { transform: translateX(0); }
    .sidebar-overlay { display: block; }
    .admin-layout { margin-left: 0; }
    .topbar { left: 0; }
    .mobile-menu-btn { display: flex; }
  }
</style>
@stack('styles')
</head>
<body>
<div class="bg-gradient"></div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-brand">
    <div class="sidebar-brand-icon">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="white"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
    </div>
    <div>
      <div class="sidebar-brand-text">Admin Panel</div>
      <div class="sidebar-brand-sub">Mystery Box</div>
    </div>
  </div>

  <nav class="sidebar-nav">
    <div class="sidebar-section-label">মেইন মেনু</div>

    <!-- Dashboard -->
    <div class="nav-item">
      <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
        ড্যাশবোর্ড
      </a>
    </div>

    <div class="sidebar-section-label" style="margin-top:0.5rem;">ল্যান্ডিং পেজ</div>

    <!-- Landing Page (expandable) -->
    <div class="nav-item">
      <button
        class="nav-link {{ request()->routeIs('admin.landing-page.*') ? 'active open' : '' }}"
        id="lp-toggle"
        onclick="toggleLandingMenu()"
        aria-expanded="{{ request()->routeIs('admin.landing-page.*') ? 'true' : 'false' }}"
      >
        <svg class="nav-icon" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
        ল্যান্ডিং পেজ
        <svg class="nav-chevron" viewBox="0 0 24 24" fill="currentColor"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
      </button>
      <div class="nav-submenu {{ request()->routeIs('admin.landing-page.*') ? 'open' : '' }}" id="lp-submenu">
        <a href="{{ route('admin.landing-page.view') }}" class="nav-link {{ request()->routeIs('admin.landing-page.view') ? 'active' : '' }}">
          <span class="sub-dot"></span>
          👁 ভিউ (View)
        </a>
        <a href="{{ route('admin.landing-page.edit') }}" class="nav-link {{ request()->routeIs('admin.landing-page.edit') ? 'active' : '' }}">
          <span class="sub-dot"></span>
          ✏️ এডিট (Edit)
        </a>
      </div>
    </div>

  </nav>

  <!-- User / Logout -->
  <div class="sidebar-footer">
    <div class="sidebar-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
    <div class="sidebar-user-info">
      <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
      <div class="sidebar-user-role">Administrator</div>
    </div>
    <form method="POST" action="{{ route('admin.logout') }}">
      @csrf
      <button type="submit" class="sidebar-logout-btn" title="লগআউট">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
      </button>
    </form>
  </div>
</aside>

<!-- Overlay (mobile) -->
<div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()" style="display:none;"></div>

<!-- Top Bar -->
<div class="topbar">
  <div style="display:flex; align-items:center; gap:0.75rem;">
    <button class="mobile-menu-btn" onclick="openSidebar()" aria-label="মেনু খুলুন">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
    </button>
    <div class="topbar-breadcrumb">
      <span>Admin</span>
      <span class="sep">/</span>
      <span class="current">@yield('breadcrumb', 'ড্যাশবোর্ড')</span>
    </div>
  </div>
  <div class="topbar-actions">
    <div class="topbar-badge">
      <span class="dot"></span>
      অনলাইন
    </div>
    @yield('topbar-actions')
  </div>
</div>

<!-- Main Content -->
<div class="admin-layout">
  <div class="page-content">
    @yield('content')
  </div>
</div>

<script>
  function toggleLandingMenu() {
    const btn    = document.getElementById('lp-toggle');
    const menu   = document.getElementById('lp-submenu');
    const isOpen = menu.classList.contains('open');
    menu.classList.toggle('open', !isOpen);
    btn.classList.toggle('open', !isOpen);
    btn.setAttribute('aria-expanded', !isOpen);
  }

  function openSidebar() {
    document.getElementById('sidebar').classList.add('open');
    document.getElementById('sidebar-overlay').style.display = 'block';
  }
  function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebar-overlay').style.display = 'none';
  }

  // Auto-open submenu if a child route is active
  document.addEventListener('DOMContentLoaded', () => {
    const active = document.querySelector('.nav-submenu .nav-link.active');
    if (active) {
      document.getElementById('lp-submenu').classList.add('open');
      document.getElementById('lp-toggle').classList.add('open');
    }
  });
</script>

@stack('scripts')
</body>
</html>
