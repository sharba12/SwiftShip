@extends('admin.layout')

@section('content')

<div class="dash-wrap">

    {{-- HEADER --}}
    <div class="dash-header fade-in">
        <div>
            <h1 class="dash-title">Agents</h1>
            <p class="dash-sub">Manage your delivery agent accounts</p>
        </div>
        <a href="{{ route('admin.agents.create') }}" class="btn-primary-action">
            <i class="bi bi-person-plus"></i> Add Agent
        </a>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
    <div class="alert-success-dark fade-in mt-3" style="animation-delay:0.05s">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- TABLE --}}
    <div class="admin-card mt-4 fade-in" style="animation-delay:0.1s">
        <div class="admin-card-header">
            <div>
                <h5 class="admin-card-title">Agent List</h5>
                <p class="admin-card-sub">{{ $agents->count() }} registered agent(s)</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="dark-table">
                <thead>
                    <tr>
                        <th style="width:60px">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($agents as $agent)
                    <tr>
                        <td class="id-col">{{ $agent->id }}</td>
                        <td>
                            <div class="agent-row">
                                <div class="agent-avatar">
                                    {{ strtoupper(substr($agent->name, 0, 1)) }}
                                </div>
                                <span class="agent-name">{{ $agent->name }}</span>
                            </div>
                        </td>
                        <td class="email-col">{{ $agent->email }}</td>
                        <td>
                            <span class="status-chip status-green">Active</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty-state">
                            <i class="bi bi-person-badge"></i>
                            <p>No agents found</p>
                            <a href="{{ route('admin.agents.create') }}" class="btn-primary-action mt-2" style="font-size:0.8rem;padding:0.45rem 1rem;">
                                Add your first agent
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<style>
.dash-wrap { max-width: 1100px; }
.dash-header { display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem; }
.dash-title { font-size:1.6rem;font-weight:800;color:#111827;letter-spacing:-0.03em;margin:0; }
.dash-sub { font-size:0.78rem;color:#6b7280;margin:4px 0 0; }

.btn-primary-action {
    background:#0ea5e9;color:#fff;border:none;
    border-radius:8px;padding:0.55rem 1.2rem;
    font-size:0.85rem;font-weight:600;
    text-decoration:none;cursor:pointer;
    display:inline-flex;align-items:center;gap:0.4rem;
    transition:background 0.2s;white-space:nowrap;
}
.btn-primary-action:hover { background:#0284c7;color:#fff; }

.alert-success-dark {
    background:rgba(52,211,153,0.08);
    border:1px solid rgba(52,211,153,0.2);
    border-radius:10px;padding:0.85rem 1.1rem;
    color:#34d399;font-size:0.875rem;font-weight:500;
    display:flex;align-items:center;gap:0.6rem;
}

.admin-card {
    background:#f8fafc;
    border:1px solid rgba(255,255,255,0.07);
    border-radius:16px;overflow:hidden;
}
.admin-card-header {
    padding:1.1rem 1.5rem;
    border-bottom:1px solid #f1f5f9;
    display:flex;align-items:center;justify-content:space-between;
}
.admin-card-title { font-size:0.95rem;font-weight:700;color:#111827;margin:0; }
.admin-card-sub { font-size:0.73rem;color:#6b7280;margin:2px 0 0; }

.dark-table { width:100%;border-collapse:collapse; }
.dark-table thead tr {
    background:#f9fafb;
    border-bottom:1px solid #e5e7eb;
}
.dark-table th {
    padding:0.85rem 1.25rem;
    font-size:0.72rem;font-weight:700;
    color:#64748b;
    text-transform:uppercase;letter-spacing:0.1em;text-align:left;
}
.dark-table tbody tr {
    border-bottom:1px solid #f1f5f9;
    transition:background 0.15s;
}
.dark-table tbody tr:hover { background:#f8fafc; }
.dark-table td {
    padding:0.9rem 1.25rem;
    font-size:0.875rem;color:#374151;
    vertical-align:middle;
}

.id-col { color:#9ca3af;font-size:0.78rem;font-family:'Courier New',monospace; }
.email-col { color:#6b7280;font-size:0.82rem; }

.agent-row { display:flex;align-items:center;gap:0.75rem; }
.agent-avatar {
    width:32px;height:32px;border-radius:50%;
    background:linear-gradient(135deg,#0ea5e9,#6366f1);
    display:flex;align-items:center;justify-content:center;
    font-size:0.75rem;font-weight:700;color:#fff;flex-shrink:0;
}
.agent-name { color:#111827;font-weight:500; }

.status-chip {
    display:inline-block;border-radius:20px;
    padding:0.22rem 0.85rem;
    font-size:0.73rem;font-weight:700;letter-spacing:0.04em;
}
.status-green { background:rgba(52,211,153,0.1);color:#34d399;border:1px solid rgba(52,211,153,0.2); }

.empty-state { text-align:center;padding:3rem 1rem !important; }
.empty-state i { font-size:2.5rem;color:#d1d5db;display:block;margin-bottom:0.75rem; }
.empty-state p { color:#9ca3af;margin:0;font-size:0.875rem; }

.fade-in { opacity:0;transform:translateY(16px);animation:fadeIn 0.6s ease forwards; }
@keyframes fadeIn { to { opacity:1;transform:translateY(0); } }
</style>

@endsection