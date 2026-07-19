@extends('admin.layouts.sidebar')

@section('title', 'Landing Page — View')
@section('breadcrumb', 'Landing Page / View')

@push('styles')
<style>
  .page-content { padding: 0 !important; }

  /* Sub topbar */
  .view-topbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 0.625rem 1.5rem;
    background: rgba(15,15,26,0.95);
    border-bottom: 1px solid rgba(255,255,255,0.08);
    gap: 0.75rem; flex-wrap: wrap;
  }
  .view-topbar-left { display: flex; align-items: center; gap: 0.75rem; }
  .view-topbar-title {
    font-size: 0.95rem; font-weight: 700; color: #f1f5f9;
    display: flex; align-items: center; gap: 0.5rem;
  }
  .view-topbar-badge {
    font-size: 0.68rem; font-weight: 600; padding: 0.2rem 0.6rem;
    background: rgba(52,211,153,0.12); border: 1px solid rgba(52,211,153,0.25);
    color: #34d399; border-radius: 20px; letter-spacing: 0.5px;
  }
  .view-topbar-right { display: flex; align-items: center; gap: 0.5rem; }

  .vtb-btn {
    display: inline-flex; align-items: center; gap: 0.35rem;
    padding: 0.45rem 0.9rem; border-radius: 7px; font-size: 0.78rem; font-weight: 600;
    cursor: pointer; border: none; font-family: 'Inter', sans-serif;
    transition: all 0.2s; text-decoration: none; white-space: nowrap;
  }
  .vtb-btn-open {
    background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1);
    color: #f1f5f9;
  }
  .vtb-btn-open:hover { background: rgba(255,255,255,0.14); transform: translateY(-1px); }

  /* Device toggle bar */
  .view-device-bar {
    display: flex; align-items: center; gap: 0.5rem;
    padding: 0.5rem 1.5rem;
    background: rgba(0,0,0,0.2);
    border-bottom: 1px solid rgba(255,255,255,0.06);
  }
  .device-label { font-size: 0.72rem; color: #64748b; font-weight: 600; margin-right: 0.25rem; }
  .dev-tab {
    display: inline-flex; align-items: center; gap: 0.3rem;
    padding: 0.3rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600;
    cursor: pointer; border: 1px solid rgba(255,255,255,0.1);
    background: rgba(255,255,255,0.04); color: #94a3b8;
    transition: all 0.2s;
  }
  .dev-tab.active {
    background: rgba(99,102,241,0.15); border-color: rgba(99,102,241,0.4); color: #a5b4fc;
  }
  .dev-divider { width: 1px; height: 22px; background: rgba(255,255,255,0.08); margin: 0 0.25rem; }
  .dev-url {
    flex: 1; font-size: 0.72rem; color: #475569;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    margin-left: 0.5rem;
  }

  /* iframe area */
  .view-frame-area {
    width: 100%;
    height: calc(100vh - var(--topbar-h) - 38px - 42px);
    background: #1a1a2e;
    display: flex; align-items: flex-start; justify-content: center;
    overflow-y: auto;
    padding: 0;
    transition: background 0.3s;
  }
  .view-frame-area.mobile-bg {
    background: #111;
    padding: 2rem 1rem;
    align-items: flex-start;
  }

  /* Phone shell for mobile */
  .phone-shell {
    display: none;
    flex-direction: column;
    background: #1e1e2e;
    border-radius: 44px;
    border: 6px solid #2d2d3d;
    box-shadow:
      0 0 0 1px rgba(255,255,255,0.06),
      0 30px 80px rgba(0,0,0,0.6);
    overflow: hidden;
    width: 390px;
    flex-shrink: 0;
  }
  .phone-shell.visible { display: flex; }
  .phone-notch {
    height: 28px; background: #1e1e2e;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .phone-notch-pill {
    width: 110px; height: 10px; background: #0f0f1a;
    border-radius: 20px;
  }
  .phone-iframe-wrap {
    flex: 1; overflow: hidden; border-radius: 0 0 38px 38px;
  }
  .phone-home-bar {
    height: 20px; background: #1e1e2e;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .phone-home-pill {
    width: 100px; height: 4px; background: rgba(255,255,255,0.15);
    border-radius: 20px;
  }

  #view-iframe {
    width: 100%; border: none; display: block;
    height: calc(100vh - var(--topbar-h) - 38px - 42px);
    min-height: 500px;
  }
  #view-iframe-mobile {
    width: 390px; height: 844px; border: none; display: block;
  }

  /* Desktop: full width iframe */
  #desktop-wrap { width: 100%; height: 100%; }
</style>
@endpush

@section('topbar-actions')
  <a href="{{ route('admin.landing-page.serve') }}" target="_blank" class="vtb-btn vtb-btn-open">↗ View in New Tab</a>
@endsection

@section('content')

<!-- Sub topbar -->
<div class="view-topbar">
  <div class="view-topbar-left">
    <div class="view-topbar-title">
      👁 Landing Page Preview
      <span class="view-topbar-badge">LIVE VIEW</span>
    </div>
  </div>
  <div class="view-topbar-right">
    <a href="{{ route('admin.landing-page.serve') }}" target="_blank" class="vtb-btn vtb-btn-open">↗ New Tab</a>
  </div>
</div>

<!-- Device toggle bar -->
<div class="view-device-bar">
  <span class="device-label">Device:</span>
  <button class="dev-tab active" id="tab-desktop" onclick="setDevice('desktop')">🖥 Desktop</button>
  <button class="dev-tab" id="tab-mobile" onclick="setDevice('mobile')">📱 Mobile</button>
  <div class="dev-divider"></div>
  <span class="dev-url">{{ route('admin.landing-page.serve') }}</span>
</div>

<!-- View area -->
<div class="view-frame-area" id="view-frame-area">

  <!-- Desktop view -->
  <div id="desktop-wrap">
    <iframe
      id="view-iframe"
      src="{{ route('admin.landing-page.serve') }}"
      title="Landing Page Preview"
      allowfullscreen
    ></iframe>
  </div>

  <!-- Mobile phone shell (hidden by default) -->
  <div class="phone-shell" id="phone-shell">
    <div class="phone-notch"><div class="phone-notch-pill"></div></div>
    <div class="phone-iframe-wrap">
      <iframe
        id="view-iframe-mobile"
        title="Mobile Preview"
        allowfullscreen
      ></iframe>
    </div>
    <div class="phone-home-bar"><div class="phone-home-pill"></div></div>
  </div>

</div>

@endsection

@push('scripts')
<script>
  let mobileLoaded = false;

  function setDevice(device) {
    const desktopWrap = document.getElementById('desktop-wrap');
    const phoneShell  = document.getElementById('phone-shell');
    const frameArea   = document.getElementById('view-frame-area');
    const tabD = document.getElementById('tab-desktop');
    const tabM = document.getElementById('tab-mobile');

    if (device === 'mobile') {
      tabD.classList.remove('active');
      tabM.classList.add('active');
      desktopWrap.style.display = 'none';
      phoneShell.classList.add('visible');
      frameArea.classList.add('mobile-bg');

      // Lazy load mobile iframe
      if (!mobileLoaded) {
        document.getElementById('view-iframe-mobile').src = '{{ route('admin.landing-page.serve') }}';
        mobileLoaded = true;
      }
    } else {
      tabD.classList.add('active');
      tabM.classList.remove('active');
      desktopWrap.style.display = 'block';
      phoneShell.classList.remove('visible');
      frameArea.classList.remove('mobile-bg');
    }
  }
</script>
@endpush
