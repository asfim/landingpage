@extends('admin.layouts.sidebar')

@section('title', 'Admin Dashboard')
@section('breadcrumb', 'ড্যাশবোর্ড')

@push('styles')
<style>
  .page-header { margin-bottom: 2rem; }
  .page-header h2 { font-size: 1.5rem; font-weight: 700; }
  .page-header p  { color: #94a3b8; margin-top: 0.25rem; font-size: 0.9rem; }

  .welcome-card {
    background: linear-gradient(135deg, rgba(99,102,241,0.15) 0%, rgba(139,92,246,0.1) 100%);
    border: 1px solid rgba(99,102,241,0.2);
    border-radius: 16px; padding: 2rem;
    display: flex; align-items: center; gap: 1.5rem;
    margin-bottom: 2rem;
  }
  .welcome-text h3 { font-size: 1.25rem; font-weight: 600; }
  .welcome-text p  { color: #94a3b8; margin-top: 0.25rem; }
  .welcome-emoji   { font-size: 3rem; }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem; margin-bottom: 2rem;
  }
  .stat-card {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px; padding: 1.5rem;
    transition: border-color 0.2s, transform 0.2s;
  }
  .stat-card:hover { border-color: rgba(99,102,241,0.3); transform: translateY(-2px); }
  .stat-icon {
    width: 44px; height: 44px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 1rem;
  }
  .stat-value { font-size: 1.75rem; font-weight: 700; }
  .stat-label { font-size: 0.875rem; color: #94a3b8; margin-top: 0.25rem; }

  /* Quick actions */
  .quick-actions {
    display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
  }
  .qa-card {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 14px; padding: 1.5rem;
    text-decoration: none; color: #f1f5f9;
    display: flex; flex-direction: column; gap: 0.75rem;
    transition: all 0.25s; cursor: pointer;
  }
  .qa-card:hover {
    border-color: rgba(99,102,241,0.35);
    background: rgba(99,102,241,0.07);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(99,102,241,0.15);
  }
  .qa-icon { font-size: 1.75rem; }
  .qa-title { font-size: 0.95rem; font-weight: 600; }
  .qa-desc  { font-size: 0.8rem; color: #94a3b8; line-height: 1.4; }
  .qa-arrow { color: #6366f1; font-size: 0.85rem; font-weight: 600; margin-top: auto; }
  .section-label {
    font-size: 0.8rem; font-weight: 700; letter-spacing: 1px;
    text-transform: uppercase; color: #64748b; margin-bottom: 1rem;
  }
</style>
@endpush

@section('content')

<div class="page-header">
  <h2>Dashboard</h2>
  <p>Welcome! You have logged in successfully.</p>
</div>

<!-- Welcome Banner -->
<div class="welcome-card">
  <div class="welcome-emoji">👋</div>
  <div class="welcome-text">
    <h3>Hello, {{ Auth::user()->name }}!</h3>
    <p>You are in the Admin Panel. Manage your landing page from here.</p>
  </div>
</div>

<!-- Stats -->
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon" style="background: rgba(99,102,241,0.15);">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="#6366f1"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
    </div>
    <div class="stat-value">1</div>
    <div class="stat-label">Total Users</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background: rgba(52,211,153,0.15);">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="#34d399"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
    </div>
    <div class="stat-value" style="color:#34d399;">Active</div>
    <div class="stat-label">System Status</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background: rgba(251,191,36,0.15);">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="#fbbf24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>
    </div>
    <div class="stat-value" style="color:#fbbf24;">Secure</div>
    <div class="stat-label">Security</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background: rgba(249,115,22,0.15);">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="#f97316"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z"/></svg>
    </div>
    <div class="stat-value">{{ now()->format('H:i') }}</div>
    <div class="stat-label">Current Time</div>
  </div>
</div>

<!-- Quick Actions -->
<div class="section-label">Quick Actions</div>
<div class="quick-actions">
  <a href="{{ route('admin.landing-page.view') }}" class="qa-card">
    <div class="qa-icon">👁</div>
    <div class="qa-title">View Landing Page</div>
    <div class="qa-desc">View your landing page in live preview</div>
    <div class="qa-arrow">→ View</div>
  </a>
  <a href="{{ route('admin.landing-page.edit') }}" class="qa-card">
    <div class="qa-icon">✏️</div>
    <div class="qa-title">Edit Landing Page</div>
    <div class="qa-desc">Customize page in the HTML code editor</div>
    <div class="qa-arrow">→ Edit</div>
  </a>
  <a href="{{ route('admin.landing-page.serve') }}" target="_blank" class="qa-card">
    <div class="qa-icon">🚀</div>
    <div class="qa-title">View Live Page</div>
    <div class="qa-desc">Open public landing page in a new tab</div>
    <div class="qa-arrow">→ Live Page</div>
  </a>
</div>

<!-- Meta Pixel Settings -->
<div class="section-label" style="margin-top: 2.5rem;">Meta Marketing Settings (Pixel & Access Token)</div>
<div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 2rem;">
  @if (session('success'))
    <div style="background: rgba(52,211,153,0.15); border: 1px solid rgba(52,211,153,0.3); color: #34d399; padding: 12px; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
      {{ session('success') }}
    </div>
  @endif

  <form action="{{ route('admin.landing-page.update-meta') }}" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem;">
    @csrf

    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
      <label for="meta_pixel_id" style="font-size: 0.9rem; font-weight: 600; color: #f1f5f9; display: flex; align-items: center; gap: 0.5rem;">
        <span>🔵 Meta Pixel ID</span>
        <span style="font-size: 0.75rem; color: #94a3b8; font-weight: normal;">(e.g., 123456789012345)</span>
      </label>
      <input 
        type="text" 
        name="meta_pixel_id" 
        id="meta_pixel_id" 
        value="{{ old('meta_pixel_id', $landingPage->meta_pixel_id) }}" 
        placeholder="Enter your Facebook Pixel ID"
        style="width: 100%; background: rgba(15,23,42,0.6); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; padding: 10px 14px; color: #f1f5f9; font-size: 0.9rem; outline: none; transition: border-color 0.2s;"
        onfocus="this.style.borderColor='#6366f1'"
        onblur="this.style.borderColor='rgba(255,255,255,0.1)'"
      >
    </div>

    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
      <label for="meta_access_token" style="font-size: 0.9rem; font-weight: 600; color: #f1f5f9; display: flex; align-items: center; gap: 0.5rem;">
        <span>🔑 Conversions API Access Token</span>
        <span style="font-size: 0.75rem; color: #94a3b8; font-weight: normal;">(for server-side tracking)</span>
      </label>
      <textarea 
        name="meta_access_token" 
        id="meta_access_token" 
        rows="4" 
        placeholder="EAAW..."
        style="width: 100%; background: rgba(15,23,42,0.6); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; padding: 10px 14px; color: #f1f5f9; font-size: 0.9rem; font-family: monospace; outline: none; resize: vertical; transition: border-color 0.2s;"
        onfocus="this.style.borderColor='#6366f1'"
        onblur="this.style.borderColor='rgba(255,255,255,0.1)'"
      >{{ old('meta_access_token', $landingPage->meta_access_token) }}</textarea>
    </div>

    <div>
      <button 
        type="submit" 
        style="background: #6366f1; color: #fff; font-weight: 600; border: none; border-radius: 8px; padding: 10px 20px; font-size: 0.9rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; transition: background 0.2s;"
        onmouseover="this.style.background='#4f46e5'"
        onmouseout="this.style.background='#6366f1'"
      >
        💾 Save Settings
      </button>
    </div>
  </form>
</div>

@endsection
