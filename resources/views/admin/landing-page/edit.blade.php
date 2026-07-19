@extends('admin.layouts.sidebar')

@section('title', 'Landing Page — Edit')
@section('breadcrumb', 'Landing Page / Edit')

@push('styles')
<style>
  /* Remove default page padding for full-screen edit */
  .page-content {
    padding: 0 !important;
  }

  .edit-topbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 0.625rem 1.5rem;
    background: rgba(15,15,26,0.95);
    border-bottom: 1px solid rgba(255,255,255,0.08);
    gap: 0.75rem; flex-wrap: wrap;
  }
  .edit-topbar-left {
    display: flex; align-items: center; gap: 0.75rem;
  }
  .edit-topbar-title {
    font-size: 0.95rem; font-weight: 700; color: #f1f5f9;
    display: flex; align-items: center; gap: 0.5rem;
  }
  .edit-topbar-badge {
    font-size: 0.68rem; font-weight: 600; padding: 0.2rem 0.6rem;
    background: rgba(242,98,31,0.15); border: 1px solid rgba(242,98,31,0.3);
    color: #f2621f; border-radius: 20px; letter-spacing: 0.5px;
  }
  .edit-topbar-right {
    display: flex; align-items: center; gap: 0.5rem;
  }
  .etb-btn {
    display: inline-flex; align-items: center; gap: 0.35rem;
    padding: 0.45rem 0.9rem; border-radius: 7px; font-size: 0.78rem; font-weight: 600;
    cursor: pointer; border: none; font-family: 'Inter', sans-serif;
    transition: all 0.2s; text-decoration: none; white-space: nowrap;
  }
  .etb-btn-view {
    background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1);
    color: #f1f5f9;
  }
  .etb-btn-view:hover { background: rgba(255,255,255,0.14); transform: translateY(-1px); }
  .etb-btn-fullscreen {
    background: rgba(99,102,241,0.15); border: 1px solid rgba(99,102,241,0.3);
    color: #a5b4fc;
  }
  .etb-btn-fullscreen:hover { background: rgba(99,102,241,0.25); transform: translateY(-1px); }

  /* Info bar */
  .edit-info-bar {
    display: flex; align-items: center; gap: 0.75rem;
    padding: 0.5rem 1.5rem;
    background: rgba(242,98,31,0.06);
    border-bottom: 1px solid rgba(242,98,31,0.12);
    font-size: 0.75rem; color: #94a3b8;
  }
  .edit-info-bar .info-icon { font-size: 0.9rem; }
  .edit-info-bar strong { color: #fbbf24; }

  /* iframe container */
  .edit-iframe-wrap {
    width: 100%;
    height: calc(100vh - var(--topbar-h) - 38px - 38px);
    /* topbar(64) + etb topbar(38) + info bar(38) */
    min-height: 500px;
    position: relative;
    background: #f2621f;
  }
  #edit-iframe {
    width: 100%; height: 100%;
    border: none; display: block;
  }
</style>
@endpush

@section('topbar-actions')
  <a href="{{ route('admin.landing-page.view') }}" class="etb-btn etb-btn-view">👁 View Page</a>
@endsection

@section('content')

<!-- Sub-topbar -->
<div class="edit-topbar">
  <div class="edit-topbar-left">
    <div class="edit-topbar-title">
      ✏️ Landing Page Editor
      <span class="edit-topbar-badge">EDIT MODE</span>
    </div>
  </div>
  <div class="edit-topbar-right">
    <a href="{{ route('admin.landing-page.view') }}" class="etb-btn etb-btn-view">👁 View Page</a>
    <a href="{{ route('admin.landing-page.serve-editable') }}" target="_blank" class="etb-btn etb-btn-fullscreen">↗ Full Screen Editor</a>
  </div>
</div>

<!-- Info bar -->
<div class="edit-info-bar">
  <span class="info-icon">💡</span>
  <span>The page has loaded below. <strong>Double-click</strong> on any text to edit it. Use the <strong>Colors</strong> picker to change styles. Click <strong>"Export Clean Page"</strong> to download the modified clean HTML.</span>
</div>

<!-- Full editor iframe -->
<div class="edit-iframe-wrap">
  <iframe
    id="edit-iframe"
    src="{{ route('admin.landing-page.serve-editable') }}"
    title="Landing Page Editor"
    allowfullscreen
    allow="downloads"
  ></iframe>
</div>

@endsection
