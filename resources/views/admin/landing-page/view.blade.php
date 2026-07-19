@extends('admin.layouts.sidebar')

@section('title', 'Landing Page — ভিউ')
@section('breadcrumb', 'ল্যান্ডিং পেজ / ভিউ')

@push('styles')
<style>
  .lp-view-toolbar {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 1.25rem; flex-wrap: wrap; gap: 0.75rem;
  }
  .lp-view-title {
    font-size: 1.25rem; font-weight: 700;
  }
  .lp-view-title span { color: #94a3b8; font-weight: 400; font-size: 0.9rem; margin-left: 0.5rem; }
  .lp-toolbar-right { display: flex; gap: 0.625rem; }
  .lp-btn {
    display: inline-flex; align-items: center; gap: 0.375rem;
    padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.82rem; font-weight: 600;
    cursor: pointer; text-decoration: none; transition: all 0.2s; border: none;
    font-family: 'Inter', sans-serif;
  }
  .lp-btn-edit {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
  }
  .lp-btn-edit:hover { opacity: 0.9; transform: translateY(-1px); }
  .lp-btn-open {
    background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1);
    color: #f1f5f9;
  }
  .lp-btn-open:hover { background: rgba(255,255,255,0.12); transform: translateY(-1px); }

  /* Device preview tabs */
  .lp-device-tabs {
    display: flex; gap: 0.5rem; margin-bottom: 1rem; align-items: center;
  }
  .lp-device-tab {
    display: flex; align-items: center; gap: 0.375rem;
    padding: 0.375rem 0.875rem; border-radius: 20px; font-size: 0.78rem; font-weight: 600;
    cursor: pointer; border: 1px solid rgba(255,255,255,0.1);
    background: rgba(255,255,255,0.04); color: #94a3b8;
    transition: all 0.2s;
  }
  .lp-device-tab.active { background: rgba(99,102,241,0.15); border-color: rgba(99,102,241,0.4); color: #a5b4fc; }

  /* iframe wrapper */
  .lp-preview-shell {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 14px;
    overflow: hidden;
    transition: all 0.35s ease;
  }
  .lp-preview-bar {
    display: flex; align-items: center; gap: 0.5rem;
    padding: 0.625rem 1rem;
    background: rgba(255,255,255,0.04);
    border-bottom: 1px solid rgba(255,255,255,0.06);
  }
  .lp-preview-dots span {
    display: inline-block; width: 10px; height: 10px; border-radius: 50%;
    margin-right: 5px;
  }
  .lp-preview-dots .d1 { background: #f87171; }
  .lp-preview-dots .d2 { background: #fbbf24; }
  .lp-preview-dots .d3 { background: #34d399; }
  .lp-preview-url {
    flex: 1; background: rgba(255,255,255,0.06); border-radius: 6px;
    padding: 0.25rem 0.75rem; font-size: 0.75rem; color: #64748b;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  }
  #lp-iframe {
    width: 100%; border: none; display: block;
    height: calc(100vh - 220px); min-height: 500px;
    transition: width 0.35s ease, margin 0.35s ease;
  }
  /* Mobile device frame */
  .lp-preview-shell.mobile {
    max-width: 430px; margin: 0 auto;
    border-radius: 40px;
    border: 8px solid rgba(255,255,255,0.12);
    box-shadow: 0 0 0 2px rgba(255,255,255,0.06);
  }
  .lp-preview-shell.mobile #lp-iframe { height: 800px; border-radius: 32px; }
  .lp-preview-shell.mobile .lp-preview-bar { display: none; }
</style>
@endpush

@section('topbar-actions')
  <a href="{{ route('admin.landing-page.edit') }}" class="lp-btn lp-btn-edit">✏️ এডিট করুন</a>
@endsection

@section('content')

<div class="lp-view-toolbar">
  <div>
    <div class="lp-view-title">ল্যান্ডিং পেজ প্রিভিউ <span>Live Preview</span></div>
  </div>
  <div class="lp-toolbar-right">
    <div class="lp-device-tabs">
      <button class="lp-device-tab active" onclick="setDevice('desktop', this)">🖥 Desktop</button>
      <button class="lp-device-tab" onclick="setDevice('mobile', this)">📱 Mobile</button>
    </div>
    <a href="{{ route('admin.landing-page.serve') }}" target="_blank" class="lp-btn lp-btn-open">↗ নতুন ট্যাবে খুলুন</a>
  </div>
</div>

<div class="lp-preview-shell" id="lp-shell">
  <div class="lp-preview-bar">
    <div class="lp-preview-dots">
      <span class="d1"></span><span class="d2"></span><span class="d3"></span>
    </div>
    <div class="lp-preview-url" id="lp-url">{{ route('admin.landing-page.serve') }}</div>
  </div>
  <iframe id="lp-iframe" src="{{ route('admin.landing-page.serve') }}" title="Landing Page Preview" allowfullscreen></iframe>
</div>

@endsection

@push('scripts')
<script>
  function setDevice(device, btn) {
    document.querySelectorAll('.lp-device-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    const shell = document.getElementById('lp-shell');
    if (device === 'mobile') {
      shell.classList.add('mobile');
    } else {
      shell.classList.remove('mobile');
    }
  }
</script>
@endpush
