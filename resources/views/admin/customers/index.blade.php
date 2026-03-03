@extends('admin.layout')

@section('content')

<div class="dash-wrap">

    {{-- HEADER --}}
    <div class="dash-header fade-in">
        <div>
            <h1 class="dash-title">Customers</h1>
            <p class="dash-sub">{{ $customers->total() }} registered customer(s)</p>
        </div>
        <button class="btn-primary-action" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
            <i class="bi bi-person-plus"></i> Add Customer
        </button>
    </div>

    @if(session('success'))
    <div class="alert-success-dark fade-in mt-3" style="animation-delay:0.05s">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert-error-dark fade-in mt-3" style="animation-delay:0.05s">
        <i class="bi bi-exclamation-circle-fill"></i>
        <div>@foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach</div>
    </div>
    @endif

    {{-- TABLE CARD --}}
    <div class="admin-card mt-4 fade-in" style="animation-delay:0.1s">
        <div class="admin-card-header">
            <div>
                <h5 class="admin-card-title">Customer List</h5>
                <p class="admin-card-sub">Search, edit or remove customers</p>
            </div>
            <div class="input-icon-wrap" style="width:220px;">
                <i class="bi bi-search input-icon"></i>
                <input type="text" id="customerSearch" class="field-input"
                       placeholder="Search customers…">
            </div>
        </div>

        <div class="table-responsive">
            <table id="customerTable" class="dark-table">
                <thead>
                    <tr>
                        <th style="width:50px">#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th style="width:100px;text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td class="id-col">
                            {{ $loop->iteration + ($customers->currentPage()-1) * $customers->perPage() }}
                        </td>
                        <td>
                            <div class="customer-row">
                                <div class="customer-avatar">
                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                </div>
                                <span class="customer-name">{{ $customer->name }}</span>
                            </div>
                        </td>
                        <td>
                            <a href="tel:{{ $customer->phone }}" class="table-link">
                                {{ $customer->phone }}
                            </a>
                        </td>
                        <td>
                            <a href="mailto:{{ $customer->email }}" class="table-link">
                                {{ $customer->email }}
                            </a>
                        </td>
                        <td class="address-col">{{ $customer->address }}</td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.customers.edit', $customer->id) }}"
                                   class="action-btn edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button onclick="confirmDelete({{ $customer->id }})"
                                        class="action-btn delete" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <form id="delete-form-{{ $customer->id }}"
                                      method="POST"
                                      action="{{ route('admin.customers.destroy', $customer->id) }}"
                                      class="d-none">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            <i class="bi bi-people"></i>
                            <p>No customers found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($customers->hasPages())
        <div class="pagination-wrap">
            {{ $customers->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>

</div>

{{-- ADD CUSTOMER MODAL --}}
<div class="modal fade" id="addCustomerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content dark-modal">

            <div class="dark-modal-header">
                <h5 class="dark-modal-title">
                    <i class="bi bi-person-plus me-2" style="color:#0ea5e9;"></i>Add Customer
                </h5>
                <button type="button" class="modal-close-btn" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.customers.store') }}">
                @csrf
                <div class="dark-modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="field-label">Full Name</label>
                            <div class="input-icon-wrap">
                                <i class="bi bi-person input-icon"></i>
                                <input name="name" type="text" class="field-input"
                                       placeholder="Customer full name"
                                       value="{{ old('name') }}">
                            </div>
                            @error('name')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="field-label">Email</label>
                            <div class="input-icon-wrap">
                                <i class="bi bi-envelope input-icon"></i>
                                <input name="email" type="email" class="field-input"
                                       placeholder="email@example.com"
                                       value="{{ old('email') }}">
                            </div>
                            @error('email')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="field-label">Phone</label>
                            <div class="input-icon-wrap">
                                <i class="bi bi-telephone input-icon"></i>
                                <input name="phone" type="text" class="field-input"
                                       placeholder="+91 XXXXX XXXXX"
                                       value="{{ old('phone') }}">
                            </div>
                            @error('phone')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="col-12">
                            <label class="field-label">Address</label>
                            <textarea name="address" class="field-textarea" rows="3"
                                      placeholder="Complete address…">{{ old('address') }}</textarea>
                            @error('address')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
                <div class="dark-modal-footer">
                    <button type="button" class="btn-ghost" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-action">
                        <i class="bi bi-check-lg"></i> Save Customer
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<style>
.dash-wrap { max-width: 1300px; }
.dash-header { display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem; }
.dash-title { font-size:1.6rem;font-weight:800;color:#111827;letter-spacing:-0.03em;margin:0; }
.dash-sub { font-size:0.78rem;color:#6b7280;margin:4px 0 0; }

.btn-primary-action {
    background:#0ea5e9;color:#fff;border:none;border-radius:8px;
    padding:0.55rem 1.2rem;font-size:0.85rem;font-weight:600;
    text-decoration:none;cursor:pointer;
    display:inline-flex;align-items:center;gap:0.4rem;
    transition:background 0.2s;white-space:nowrap;
}
.btn-primary-action:hover { background:#0284c7;color:#fff; }

.btn-ghost {
    background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);
    color:#374151;border-radius:8px;padding:0.55rem 1.1rem;
    font-size:0.85rem;font-weight:500;text-decoration:none;cursor:pointer;
    display:inline-flex;align-items:center;gap:0.4rem;transition:all 0.2s;
}
.btn-ghost:hover { background:#f3f4f6;color:#111827; }

.alert-success-dark {
    background:rgba(52,211,153,0.08);border:1px solid rgba(52,211,153,0.2);
    border-radius:10px;padding:0.85rem 1.1rem;color:#34d399;
    font-size:0.875rem;font-weight:500;display:flex;align-items:center;gap:0.6rem;
}
.alert-error-dark {
    background:rgba(248,113,113,0.08);border:1px solid rgba(248,113,113,0.2);
    border-radius:10px;padding:0.85rem 1.1rem;color:#f87171;
    font-size:0.875rem;display:flex;align-items:flex-start;gap:0.6rem;
}

/* TABLE */
.admin-card { background:#fff;border:1px solid #e5e7eb;border-radius:16px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,0.05); }
.admin-card-header {
    padding:1.1rem 1.5rem;border-bottom:1px solid #f1f5f9;
    display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;
}
.admin-card-title { font-size:0.95rem;font-weight:700;color:#111827;margin:0; }
.admin-card-sub { font-size:0.73rem;color:#6b7280;margin:2px 0 0; }

.input-icon-wrap { position:relative; }
.input-icon { position:absolute;left:0.85rem;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:0.85rem;pointer-events:none; }
.field-input {
    width:100%;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.09);
    border-radius:8px;padding:0.62rem 0.9rem 0.62rem 2.3rem;
    color:#fff;font-size:0.875rem;outline:none;transition:border-color 0.2s,box-shadow 0.2s;
}
.field-input::placeholder { color:rgba(255,255,255,0.2); }
.field-input:focus { border-color:#0ea5e9;box-shadow:0 0 0 3px rgba(14,165,233,0.12); }

.dark-table { width:100%;border-collapse:collapse; }
.dark-table thead tr { background:#f9fafb;border-bottom:1px solid #e5e7eb; }
.dark-table th {
    padding:0.85rem 1.25rem;font-size:0.72rem;font-weight:700;
    color:#64748b;text-transform:uppercase;letter-spacing:0.1em;text-align:left;
}
.dark-table tbody tr { border-bottom:1px solid #f1f5f9;transition:background 0.15s; }
.dark-table tbody tr:hover { background:#f8fafc; }
.dark-table td { padding:0.9rem 1.25rem;font-size:0.875rem;color:#374151;vertical-align:middle; }

.id-col { color:#9ca3af;font-size:0.78rem;font-family:'Courier New',monospace; }
.customer-row { display:flex;align-items:center;gap:0.75rem; }
.customer-avatar {
    width:32px;height:32px;border-radius:50%;
    background:linear-gradient(135deg,#0ea5e9,#6366f1);
    display:flex;align-items:center;justify-content:center;
    font-size:0.75rem;font-weight:700;color:#fff;flex-shrink:0;
}
.customer-name { color:#111827;font-weight:500; }
.table-link { color:#0284c7;text-decoration:none;font-size:0.82rem; }
.table-link:hover { color:#0369a1;text-decoration:underline; }
.address-col { color:#6b7280;font-size:0.8rem;max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis; }

.action-btns { display:flex;align-items:center;justify-content:center;gap:0.4rem; }
.action-btn {
    width:30px;height:30px;border-radius:7px;border:none;cursor:pointer;
    display:flex;align-items:center;justify-content:center;font-size:0.8rem;
    transition:all 0.2s;background:transparent;
}
.action-btn.edit { background:#fef9c3;color:#ca8a04;border:1px solid #fde68a; }
.action-btn.edit:hover { background:#fde68a;color:#92400e; }
.action-btn.delete { background:#fee2e2;color:#dc2626;border:1px solid #fecaca; }
.action-btn.delete:hover { background:#fecaca;color:#991b1b; }

.empty-state { text-align:center;padding:3rem 1rem !important; }
.empty-state i { font-size:2.5rem;color:#d1d5db;display:block;margin-bottom:0.75rem; }
.empty-state p { color:#9ca3af;margin:0;font-size:0.875rem; }

/* PAGINATION */
.pagination-wrap { padding:1rem 1.5rem;border-top:1px solid #f1f5f9; }
.pagination-wrap .pagination { margin:0;gap:4px; }
.pagination-wrap .page-link {
    background:#f9fafb;border:1px solid rgba(255,255,255,0.08);
    color:#6b7280;border-radius:7px;padding:0.35rem 0.75rem;font-size:0.82rem;
    transition:all 0.2s;
}
.pagination-wrap .page-link:hover { background:#f3f4f6;color:#111827;border-color:rgba(255,255,255,0.15); }
.pagination-wrap .page-item.active .page-link { background:#0ea5e9;border-color:#0ea5e9;color:#fff; }
.pagination-wrap .page-item.disabled .page-link { opacity:0.3;cursor:not-allowed; }

/* MODAL */
.dark-modal {
    background:#0c1120;border:1px solid rgba(255,255,255,0.08);
    border-radius:16px;overflow:hidden;
}
.dark-modal-header {
    padding:1.25rem 1.5rem;border-bottom:1px solid #e5e7eb;
    display:flex;align-items:center;justify-content:space-between;
}
.dark-modal-title { font-size:1rem;font-weight:700;color:#111827;margin:0; }
.modal-close-btn {
    background:#f9fafb;border:1px solid #e5e7eb;
    color:#6b7280;width:30px;height:30px;border-radius:7px;
    display:flex;align-items:center;justify-content:center;cursor:pointer;
    font-size:0.8rem;transition:all 0.2s;
}
.modal-close-btn:hover { background:#f3f4f6;color:#111827; }
.dark-modal-body { padding:1.5rem; }
.dark-modal-footer {
    padding:1rem 1.5rem;border-top:1px solid #f1f5f9;
    display:flex;align-items:center;justify-content:flex-end;gap:0.75rem;
}

.field-label {
    display:block;font-size:0.72rem;font-weight:600;
    color:#6b7280;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.4rem;
}
.field-textarea {
    width:100%;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.09);
    border-radius:8px;padding:0.65rem 0.9rem;color:#fff;font-size:0.875rem;
    outline:none;resize:vertical;transition:border-color 0.2s,box-shadow 0.2s;
}
.field-textarea::placeholder { color:rgba(255,255,255,0.2); }
.field-textarea:focus { border-color:#0ea5e9;box-shadow:0 0 0 3px rgba(14,165,233,0.12); }
.field-error { color:#f87171;font-size:0.75rem;margin:4px 0 0; }

.fade-in { opacity:0;transform:translateY(16px);animation:fadeIn 0.6s ease forwards; }
@keyframes fadeIn { to { opacity:1;transform:translateY(0); } }
</style>

<script>
// Live search
document.getElementById('customerSearch').addEventListener('input', function(){
    const q = this.value.toLowerCase();
    document.querySelectorAll('#customerTable tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});

// Delete confirm
function confirmDelete(id){
    if(confirm('Delete this customer? This action cannot be undone.')){
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>

@endsection