@extends('layouts.admin')

@section('content')
<style>
/* Parcel Management Page Specific Styles */
.page-header {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-strong) 100%);
    border-radius: 12px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    color: white;
    box-shadow: 0 4px 6px rgba(14, 165, 233, 0.2);
}

.page-header h1 {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
}

.page-header p {
    margin: 0;
    opacity: 0.9;
    font-size: 0.95rem;
}

.filter-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.filter-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 1rem;
}

.filter-row input,
.filter-row select {
    width: 100%;
}

.btn-create {
    background: var(--color-primary);
    color: white;
    border: none;
    padding: 0.65rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-create:hover {
    background: var(--color-primary-strong);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
}

.btn-search,
.btn-clear {
    padding: 0.65rem 1.25rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-search {
    background: var(--color-primary);
    color: white;
}

.btn-search:hover {
    background: var(--color-primary-strong);
}

.btn-clear {
    background: #f3f4f6;
    color: var(--color-text-muted);
}

.btn-clear:hover {
    background: var(--color-border);
}

.table-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.table-responsive {
    overflow-x: auto;
}

.parcels-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.875rem;
}

.parcels-table thead {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    color: white;
}

.parcels-table thead th {
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    white-space: nowrap;
}

.parcels-table tbody tr {
    border-bottom: 1px solid var(--color-surface-muted);
    transition: background-color 0.15s;
}

.parcels-table tbody tr:hover {
    background-color: #f8fafc;
}

.parcels-table tbody td {
    padding: 1rem;
    vertical-align: middle;
}

.tracking-id {
    font-family: 'Courier New', monospace;
    font-weight: 700;
    color: var(--color-primary);
    font-size: 0.85rem;
    white-space: nowrap;
}

.customer-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.customer-name {
    font-weight: 600;
    color: var(--color-text-strong);
    font-size: 0.875rem;
}

.customer-email {
    font-size: 0.75rem;
    color: var(--color-text-muted);
}

.address-block {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    min-width: 200px;
}

.address-item {
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
}

.address-icon {
    flex-shrink: 0;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    margin-top: 2px;
}

.address-icon.from {
    background: #dbeafe;
    color: #1e40af;
}

.address-icon.to {
    background: #fef3c7;
    color: #92400e;
}

.address-text {
    font-size: 0.8rem;
    color: var(--color-text);
    line-height: 1.4;
}

.agent-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    background: #f0f9ff;
    color: #0369a1;
    padding: 0.4rem 0.75rem;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
    white-space: nowrap;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.4rem 0.85rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.02em;
    white-space: nowrap;
}

.status-badge.pending {
    background: #fef3c7;
    color: #92400e;
}

.status-badge.in_transit {
    background: #dbeafe;
    color: #1e40af;
}

.status-badge.out_for_delivery {
    background: #e0e7ff;
    color: #4338ca;
}

.status-badge.delivered {
    background: #d1fae5;
    color: #065f46;
}

.status-badge.failed {
    background: #fee2e2;
    color: #991b1b;
}

.status-badge.cancelled {
    background: #f3f4f6;
    color: #4b5563;
}

.qr-code-cell {
    text-align: center;
}

.qr-code-btn {
    background: white;
    border: 2px solid var(--color-border);
    padding: 0.5rem;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: var(--color-text-muted);
}

.qr-code-btn:hover {
    border-color: var(--color-primary);
    color: var(--color-primary);
    background: #f0f9ff;
}

.qr-code-btn i {
    font-size: 1.25rem;
}

.btn-view-track {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-strong) 100%);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.8rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    transition: all 0.2s;
    white-space: nowrap;
}

.btn-view-track:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
    color: white;
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    padding: 1.5rem;
}

.no-results {
    text-align: center;
    padding: 3rem;
    color: var(--color-text-subtle);
}

.no-results i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.no-results p {
    margin: 0;
    font-size: 1.1rem;
}

/* QR Modal */
.modal-content {
    border-radius: 12px;
    border: none;
}

.modal-header {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-strong) 100%);
    color: white;
    border-radius: 12px 12px 0 0;
    border: none;
}

.modal-body {
    padding: 2rem;
    text-align: center;
}

#qrCodeContainer {
    display: flex;
    justify-content: center;
    margin: 1.5rem 0;
}

#qrCodeContainer img {
    max-width: 300px;
    border: 4px solid #f3f4f6;
    border-radius: 8px;
}
</style>

<div class="page-header">
    <h1><i class="bi bi-box-seam"></i> Parcel Management</h1>
    <p>Track and manage all parcels</p>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ route('admin.parcels.create') }}" class="btn-create">
        <i class="bi bi-plus-circle"></i> Create New Parcel
    </a>
</div>

<!-- Filters -->
<div class="filter-card">
    <form method="GET" action="{{ route('admin.parcels.index') }}">
        <div class="filter-row">
            <div>
                <label class="form-label">Tracking ID</label>
                <input type="text" 
                       name="tracking_id" 
                       class="form-control" 
                       placeholder="Search by tracking ID"
                       value="{{ request('tracking_id') }}">
            </div>
            
            <div>
                <label class="form-label">Customer</label>
                <select name="customer_id" class="form-select">
                    <option value="">All Customers</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" 
                                {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_transit" {{ request('status') == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                    <option value="out_for_delivery" {{ request('status') == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
        </div>
        
        <div class="d-flex gap-2">
            <button type="submit" class="btn-search">
                <i class="bi bi-search"></i> Search
            </button>
            <a href="{{ route('admin.parcels.index') }}" class="btn-clear">
                <i class="bi bi-x-circle"></i> Clear
            </a>
        </div>
    </form>
</div>

<!-- Parcels Table -->
<div class="table-card">
    <div class="table-responsive">
        <table class="parcels-table">
            <thead>
                <tr>
                    <th>Tracking ID</th>
                    <th>Customer</th>
                    <th>From → To</th>
                    <th>Agent</th>
                    <th>Status</th>
                    <th>QR Code</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($parcels as $parcel)
                <tr>
                    <td>
                        <span class="tracking-id">{{ $parcel->tracking_id }}</span>
                    </td>
                    
                    <td>
                        <div class="customer-info">
                            <span class="customer-name">{{ $parcel->customer->name }}</span>
                            <span class="customer-email">{{ $parcel->customer->email }}</span>
                        </div>
                    </td>
                    
                    <td>
                        <div class="address-block">
                            <div class="address-item">
                                <div class="address-icon from">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <div class="address-text">{{ $parcel->sender_address }}</div>
                            </div>
                            <div class="address-item">
                                <div class="address-icon to">
                                    <i class="bi bi-geo-fill"></i>
                                </div>
                                <div class="address-text">{{ $parcel->receiver_address }}</div>
                            </div>
                        </div>
                    </td>
                    
                    <td>
                        @if($parcel->agent)
                            <span class="agent-badge">
                                <i class="bi bi-person-badge"></i>
                                {{ $parcel->agent->name }}
                            </span>
                        @else
                            <span class="text-muted" style="font-size: 0.8rem;">Not assigned</span>
                        @endif
                    </td>
                    
                    <td>
                        <span class="status-badge {{ $parcel->status }}">
                            {{ str_replace('_', ' ', $parcel->status) }}
                        </span>
                    </td>
                    
                    <td class="qr-code-cell">
                        <button class="qr-code-btn" 
                                onclick="showQRCode('{{ $parcel->tracking_id }}')"
                                title="View QR Code">
                            <i class="bi bi-qr-code"></i>
                        </button>
                    </td>
                    
                    <td>
                        <a href="{{ url('/track/' . $parcel->tracking_id) }}" 
                           class="btn-view-track"
                           target="_blank">
                            <i class="bi bi-eye"></i> View Track
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="no-results">
                        <i class="bi bi-inbox"></i>
                        <p>No parcels found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($parcels->hasPages())
    <div class="pagination">
        {{ $parcels->links() }}
    </div>
    @endif
</div>

<!-- QR Code Modal -->
<div class="modal fade" id="qrModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-qr-code"></i> Parcel QR Code
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="qrCodeContainer"></div>
                <p class="text-muted mb-0" style="font-size: 0.85rem;">
                    Scan this QR code to track the parcel
                </p>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('vendor/qrcodejs/qrcode.min.js') }}"></script>
<script>
function showQRCode(trackingId) {
    const container = document.getElementById('qrCodeContainer');
    container.innerHTML = '';
    
    new QRCode(container, {
        text: '{{ url("/track") }}/' + trackingId,
        width: 300,
        height: 300,
        colorDark: "#111827",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });
    
    const modal = new bootstrap.Modal(document.getElementById('qrModal'));
    modal.show();
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = bootstrap.Modal.getInstance(document.getElementById('qrModal'));
        if (modal) modal.hide();
    }
});
</script>
@endsection
