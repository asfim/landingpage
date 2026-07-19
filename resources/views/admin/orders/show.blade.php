@extends('admin.layouts.sidebar')

@section('title', 'Order Details — Admin Panel')
@section('breadcrumb', 'Orders / Details')

@push('styles')
<style>
  .detail-card {
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
  }
  .section-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #6366f1;
    margin-bottom: 1.25rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    padding-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
  }
  .info-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
  }
  .info-label {
    font-size: 0.78rem;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .info-value {
    font-size: 0.95rem;
    color: #f1f5f9;
    font-weight: 500;
  }
  .price-summary {
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid rgba(255, 255, 255, 0.04);
    border-radius: 12px;
    padding: 1.25rem;
    max-width: 400px;
  }
  .price-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    font-size: 0.9rem;
    color: #94a3b8;
  }
  .price-row.total {
    border-top: 1px dashed rgba(255, 255, 255, 0.15);
    margin-top: 8px;
    padding-top: 12px;
    font-weight: 700;
    color: #34d399;
    font-size: 1.1rem;
  }
  .btn-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    color: #f1f5f9;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 600;
    transition: all 0.2s;
  }
  .btn-back:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-1px);
  }
  .status-updater {
    background: rgba(255,255,255,0.02);
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
  }
  .status-select {
    padding: 8px 12px;
    background: #0f0f1a;
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 8px;
    color: #f1f5f9;
    outline: none;
    font-family: inherit;
    font-size: 0.9rem;
    cursor: pointer;
  }
  .status-badge-lg {
    font-size: 0.9rem;
    padding: 6px 14px;
    border-radius: 20px;
    font-weight: 600;
  }
  #update-msg {
    font-size: 0.85rem;
    font-weight: 500;
    display: none;
  }
</style>
@endpush

@section('content')
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
  <div>
    <h2 style="font-size: 1.5rem; font-weight: 700;">Order #{{ $order->id }}</h2>
    <p style="color: #94a3b8; font-size: 0.9rem; margin-top: 0.25rem;">Customize order and update status.</p>
  </div>
  <a href="{{ route('admin.orders.index') }}" class="btn-back">⬅ Back</a>
</div>

<!-- Status Updater Card -->
<div class="status-updater">
  <div style="display: flex; align-items: center; gap: 12px;">
    <span class="info-label" style="text-transform: none; font-size: 0.9rem;">Current Status:</span>
    <span id="current-status-badge" class="status-badge-lg" style="background-color: {{ $order->statusColor() }}; color: white;">
      {{ $order->statusLabel() }}
    </span>
  </div>
  <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
    <span id="update-msg"></span>
    <select id="status-dropdown" class="status-select" onchange="updateOrderStatus({{ $order->id }})">
      <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
      <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
      <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
      <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>
  </div>
</div>

<div class="detail-card">
  <!-- Customer Info -->
  <div class="section-title">👤 Customer & Delivery Info</div>
  <div class="info-grid">
    <div class="info-item">
      <span class="info-label">Customer Name</span>
      <span class="info-value">{{ $order->customer_name }}</span>
    </div>
    <div class="info-item">
      <span class="info-label">Phone Number</span>
      <span class="info-value" style="font-family: monospace; font-weight: 600;">{{ $order->phone }}</span>
    </div>
    <div class="info-item" style="grid-column: span 2;">
      <span class="info-label">Delivery Address</span>
      <span class="info-value">{{ $order->address }}</span>
    </div>
    @if($order->note)
      <div class="info-item" style="grid-column: span 2;">
        <span class="info-label">Special Instructions (Note)</span>
        <span class="info-value" style="color: #fbbf24;">{{ $order->note }}</span>
      </div>
    @endif
  </div>

  <!-- Package Info -->
  <div class="section-title">📦 Product Details & Billing</div>
  <div class="info-grid" style="margin-bottom: 1.5rem;">
    <div class="info-item">
      <span class="info-label">Selected Package</span>
      <span class="info-value" style="color: #f2621f; font-weight: 700;">{{ $order->package_name }}</span>
    </div>
    <div class="info-item">
      <span class="info-label">Order Time</span>
      <span class="info-value">{{ $order->created_at->format('d M Y, h:i A') }}</span>
    </div>
  </div>

  <div class="price-summary">
    <div class="price-row">
      <span>Product Price</span>
      <span>৳ {{ number_format($order->product_price, 2) }}</span>
    </div>
    <div class="price-row">
      <span>Delivery Charge</span>
      <span>৳ {{ number_format($order->delivery_charge, 2) }}</span>
    </div>
    <div class="price-row total">
      <span>Total Bill</span>
      <span>৳ {{ number_format($order->total_price, 2) }}</span>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  async function updateOrderStatus(orderId) {
    const dropdown = document.getElementById('status-dropdown');
    const badge = document.getElementById('current-status-badge');
    const msg = document.getElementById('update-msg');
    const newStatus = dropdown.value;

    dropdown.disabled = true;
    msg.style.display = 'inline';
    msg.style.color = '#94a3b8';
    msg.textContent = '⏳ Updating...';

    try {
      const response = await fetch(`/admin/orders/${orderId}/status`, {
        method: 'PATCH',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json'
        },
        body: JSON.stringify({ status: newStatus })
      });

      const data = await response.json();

      if (data.success) {
        badge.style.backgroundColor = data.color;
        badge.textContent = data.label;
        msg.style.color = '#34d399';
        msg.textContent = '✅ Status updated successfully!';
      } else {
        throw new Error();
      }
    } catch(err) {
      msg.style.color = '#f87171';
      msg.textContent = '❌ Status update failed!';
    } finally {
      dropdown.disabled = false;
      setTimeout(() => {
        msg.style.display = 'none';
      }, 3000);
    }
  }
</script>
@endpush
