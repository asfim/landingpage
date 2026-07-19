@extends('admin.layouts.sidebar')

@section('title', 'Orders — Admin Panel')
@section('breadcrumb', 'Orders')

@push('styles')
<style>
  .orders-container {
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 16px;
    padding: 1.5rem;
    overflow-x: auto;
  }
  .orders-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
    font-size: 0.9rem;
  }
  .orders-table th {
    background: rgba(255, 255, 255, 0.06);
    color: #94a3b8;
    font-weight: 600;
    padding: 12px 16px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
  }
  .orders-table td {
    padding: 14px 16px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    color: #f1f5f9;
  }
  .orders-table tr:hover td {
    background: rgba(255, 255, 255, 0.02);
  }
  .status-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    color: #fff;
  }
  .btn-action {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 6px 12px;
    background: rgba(99, 102, 241, 0.15);
    border: 1px solid rgba(99, 102, 241, 0.3);
    border-radius: 8px;
    color: #a5b4fc;
    text-decoration: none;
    font-size: 0.8rem;
    font-weight: 500;
    transition: all 0.2s;
  }
  .btn-action:hover {
    background: rgba(99, 102, 241, 0.25);
    transform: translateY(-1px);
  }
  .pagination-wrap {
    margin-top: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  /* Simple custom pagination design to match dark layout */
  .pagination-wrap .pagination {
    display: flex;
    gap: 5px;
    list-style: none;
  }
  .pagination-wrap .page-item .page-link {
    display: block;
    padding: 6px 12px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.08);
    color: #94a3b8;
    text-decoration: none;
    border-radius: 6px;
    font-size: 0.85rem;
  }
  .pagination-wrap .page-item.active .page-link {
    background: #6366f1;
    border-color: #6366f1;
    color: #fff;
  }
  .pagination-wrap .page-item.disabled .page-link {
    opacity: 0.4;
    cursor: not-allowed;
  }
</style>
@endpush

@section('content')
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
  <div>
    <h2 style="font-size: 1.5rem; font-weight: 700;">Orders</h2>
    <p style="color: #94a3b8; font-size: 0.9rem; margin-top: 0.25rem;">List of all customer orders submitted from the landing page.</p>
  </div>
</div>

<div class="orders-container">
  @if($orders->count() > 0)
    <table class="orders-table">
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Customer Name</th>
          <th>Phone Number</th>
          <th>Package</th>
          <th>Total Price</th>
          <th>Status</th>
          <th>Order Time</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($orders as $order)
          <tr>
            <td style="font-family: monospace; font-weight: bold; color: #a5b4fc;">#{{ $order->id }}</td>
            <td>{{ $order->customer_name }}</td>
            <td>{{ $order->phone }}</td>
            <td>{{ $order->package_name }}</td>
            <td style="font-weight: 600; color: #34d399;">৳ {{ number_format($order->total_price, 2) }}</td>
            <td>
              <span class="status-badge" style="background-color: {{ $order->statusColor() }}">
                {{ $order->statusLabel() }}
              </span>
            </td>
            <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
            <td>
              <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-action">
                👁 Details
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="pagination-wrap">
      <div style="color: #94a3b8; font-size: 0.85rem;">
        Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} orders
      </div>
      <div>
        {{ $orders->links('pagination::bootstrap-4') }}
      </div>
    </div>
  @else
    <div style="text-align: center; padding: 3rem 0; color: #94a3b8;">
      <span style="font-size: 3rem; display: block; margin-bottom: 1rem;">📦</span>
      <p>No orders received yet.</p>
    </div>
  @endif
</div>
@endsection
