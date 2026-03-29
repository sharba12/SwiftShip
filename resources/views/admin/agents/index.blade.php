@extends('layouts.admin')

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
                        <th style="text-align:right">Actions</th>
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
                        <td style="text-align:right;white-space:nowrap;">
                            <a href="{{ route('admin.agent.ratings', $agent->id) }}" class="action-btn action-btn-purple" title="Ratings">
                                <i class="bi bi-star"></i>
                            </a>
                            <a href="{{ route('admin.agents.edit', $agent->id) }}" class="action-btn action-btn-blue" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.agents.destroy', $agent->id) }}" method="POST"
                                  style="display:inline"
                                  onsubmit="return confirm('Delete agent?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn action-btn-red" title="Delete">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty-state">
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
.dash-title { font-size:1.6rem;font-weight:800;color:var(--color-text-strong);letter-spacing:-0.03em;margin:0; }
.dash-sub { font-size:0.78rem;color:var(--color-text-muted);margin:4px 0 0; }

.btn-primary-action {
    background:var(--color-primary);color:var(--color-white);border:none;
    border-radius:8px;padding:0.55rem 1.2rem;
    font-size:0.85rem;font-weight:600;
    text-decoration:none;cursor:pointer;
    display:inline-flex;align-items:center;gap:0.4rem;
    transition:background 0.2s;white-space:nowrap;
}
.btn-primary-action:hover { background:var(--color-primary-strong);color:var(--color-white); }

.alert-success-dark {
    background:rgba(52,211,153,0.08);
    border:1px solid rgba(52,211,153,0.2);
    border-radius:10px;padding:0.85rem 1.1rem;
    color:var(--color-success);font-size:0.875rem;font-weight:500;
    display:flex;align-items:center;gap:0.6rem;
}

.admin-card {
    background:var(--color-surface-muted);
    border:1px solid rgba(255,255,255,0.07);
    border-radius:16px;overflow:hidden;
}
.admin-card-header {
    padding:1.1rem 1.5rem;
    border-bottom:1px solid var(--color-surface-muted);
    display:flex;align-items:center;justify-content:space-between;
}
.admin-card-title { font-size:0.95rem;font-weight:700;color:var(--color-text-strong);margin:0; }
.admin-card-sub { font-size:0.73rem;color:var(--color-text-muted);margin:2px 0 0; }

.dark-table { width:100%;border-collapse:collapse; }
.dark-table thead tr {
    background:var(--color-surface-soft);
    border-bottom:1px solid var(--color-border);
}
.dark-table th {
    padding:0.85rem 1.25rem;
    font-size:0.72rem;font-weight:700;
    color:var(--color-text-slate);
    text-transform:uppercase;letter-spacing:0.1em;text-align:left;
}
.dark-table tbody tr {
    border-bottom:1px solid var(--color-surface-muted);
    transition:background 0.15s;
}
.dark-table tbody tr:hover { background:var(--color-surface-muted); }
.dark-table td {
    padding:0.9rem 1.25rem;
    font-size:0.875rem;color:var(--color-text);
    vertical-align:middle;
}

.id-col { color:var(--color-text-subtle);font-size:0.78rem;font-family:'Courier New',monospace; }
.email-col { color:var(--color-text-muted);font-size:0.82rem; }

.agent-row { display:flex;align-items:center;gap:0.75rem; }
.agent-avatar {
    width:32px;height:32px;border-radius:50%;
    background:linear-gradient(135deg,var(--color-primary),var(--color-violet));
    display:flex;align-items:center;justify-content:center;
    font-size:0.75rem;font-weight:700;color:var(--color-white);flex-shrink:0;
}
.agent-name { color:var(--color-text-strong);font-weight:500; }

.status-chip {
    display:inline-block;border-radius:20px;
    padding:0.22rem 0.85rem;
    font-size:0.73rem;font-weight:700;letter-spacing:0.04em;
}
.status-green { background:rgba(52,211,153,0.1);color:var(--color-success);border:1px solid rgba(52,211,153,0.2); }

.empty-state { text-align:center;padding:3rem 1rem !important; }
.empty-state i { font-size:2.5rem;color:var(--color-border-soft);display:block;margin-bottom:0.75rem; }
.empty-state p { color:var(--color-text-subtle);margin:0;font-size:0.875rem; }

.fade-in { opacity:0;transform:translateY(16px);animation:fadeIn 0.6s ease forwards; }
@keyframes fadeIn { to { opacity:1;transform:translateY(0); } }

.action-btn { display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:7px;border:1px solid transparent;font-size:0.8rem;cursor:pointer;transition:all 0.15s;text-decoration:none;background:none;margin-left:3px; }
.action-btn-blue { border-color:rgba(14,165,233,0.25);color:var(--color-primary); } .action-btn-blue:hover { background:rgba(14,165,233,0.1); }
.action-btn-red { border-color:rgba(239,68,68,0.25);color:var(--color-danger); } .action-btn-red:hover { background:rgba(239,68,68,0.1); }
.action-btn-purple { border-color:rgba(167,139,250,0.25);color:var(--color-violet); } .action-btn-purple:hover { background:rgba(167,139,250,0.1); }
</style>

@endsection
