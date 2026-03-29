@extends('layouts.admin')

@section('content')

<div class="dash-wrap">

    {{-- HEADER --}}
    <div class="dash-header fade-in">
        <div>
            <p class="breadcrumb-trail">
                <a href="{{ route('admin.agents.index') }}">Agents</a> &rsaquo; Edit
            </p>
            <h1 class="dash-title">Edit Agent</h1>
            <p class="dash-sub">Update details for {{ $agent->name }}</p>
        </div>
        <a href="{{ route('admin.agents.index') }}" class="btn-ghost">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="row g-4 mt-1">

        {{-- FORM --}}
        <div class="col-lg-7">
            <form action="{{ route('admin.agents.update', $agent->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- ERRORS --}}
                @if($errors->any())
                <div class="alert-error-dark mb-3 fade-in">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            <p class="mb-0">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="form-section fade-in" style="animation-delay:0.08s">
                    <div class="form-section-header">
                        <div class="section-icon" style="background:rgba(251,191,36,0.12);color:#fbbf24;">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <div>
                            <h6 class="section-title">Agent Information</h6>
                            <p class="section-sub">Update name, email, or reset password</p>
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-12">
                            <label class="field-label">Full Name</label>
                            <div class="input-icon-wrap">
                                <i class="bi bi-person input-icon"></i>
                                <input type="text" name="name"
                                       class="field-input {{ $errors->has('name') ? 'is-error' : '' }}"
                                       placeholder="Agent's full name"
                                       value="{{ old('name', $agent->name) }}" required>
                            </div>
                            @error('name')<p class="field-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="col-12">
                            <label class="field-label">Email Address</label>
                            <div class="input-icon-wrap">
                                <i class="bi bi-envelope input-icon"></i>
                                <input type="email" name="email"
                                       class="field-input {{ $errors->has('email') ? 'is-error' : '' }}"
                                       placeholder="agent@swiftship.in"
                                       value="{{ old('email', $agent->email) }}" required>
                            </div>
                            @error('email')<p class="field-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="field-label">New Password <span style="color:#9ca3af;font-weight:400;">(leave blank to keep current)</span></label>
                            <div class="input-icon-wrap">
                                <i class="bi bi-lock input-icon"></i>
                                <input type="password" name="password"
                                       class="field-input {{ $errors->has('password') ? 'is-error' : '' }}"
                                       placeholder="Min. 6 characters">
                            </div>
                            @error('password')<p class="field-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="field-label">Confirm New Password</label>
                            <div class="input-icon-wrap">
                                <i class="bi bi-lock-fill input-icon"></i>
                                <input type="password" name="password_confirmation"
                                       class="field-input"
                                       placeholder="Repeat password">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3 fade-in" style="animation-delay:0.15s">
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check-lg me-2"></i> Update Agent
                    </button>
                    <a href="{{ route('admin.agents.index') }}" class="btn-cancel">Cancel</a>
                </div>

            </form>
        </div>

        {{-- INFO PANEL --}}
        <div class="col-lg-5 fade-in" style="animation-delay:0.12s">
            <div class="info-card">
                <p class="info-label">Current Record</p>
                <div class="agent-preview-row">
                    <div class="preview-avatar">{{ strtoupper(substr($agent->name, 0, 1)) }}</div>
                    <div>
                        <p class="preview-name">{{ $agent->name }}</p>
                        <p class="preview-email">{{ $agent->email }}</p>
                    </div>
                    <span class="status-chip status-green ms-auto">Active</span>
                </div>
                <hr class="divider">
                <p class="info-label">Member Since</p>
                <p class="preview-email">{{ $agent->created_at->format('d M Y') }}</p>
            </div>

            {{-- DANGER ZONE --}}
            <div class="danger-card mt-3">
                <h6 class="danger-title"><i class="bi bi-exclamation-triangle me-1"></i> Danger Zone</h6>
                <p class="danger-sub">Permanently removes this agent and all associated data.</p>
                <form action="{{ route('admin.agents.destroy', $agent->id) }}" method="POST"
                      onsubmit="return confirm('Delete agent {{ addslashes($agent->name) }}? This cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger-sm">
                        <i class="bi bi-trash3 me-1"></i> Delete Agent
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<style>
.dash-wrap { max-width: 1100px; }
.dash-header { display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:1rem; }
.dash-title { font-size:1.6rem;font-weight:800;color:#111827;letter-spacing:-0.03em;margin:0; }
.dash-sub { font-size:0.78rem;color:#6b7280;margin:4px 0 0; }
.breadcrumb-trail { font-size:0.78rem;color:#6b7280;margin:0 0 4px; }
.breadcrumb-trail a { color:#0284c7;text-decoration:none; }
.breadcrumb-trail a:hover { color:#0ea5e9; }

.btn-ghost {
    background:#f3f4f6;border:1px solid #e5e7eb;
    color:#374151;border-radius:8px;padding:0.55rem 1.1rem;
    font-size:0.85rem;font-weight:500;text-decoration:none;
    display:inline-flex;align-items:center;gap:0.4rem;transition:all 0.2s;
}
.btn-ghost:hover { background:#e5e7eb;color:#111827; }

.btn-submit {
    background:#0ea5e9;color:#fff;border:none;border-radius:10px;
    padding:0.75rem 1.75rem;font-size:0.9rem;font-weight:700;
    cursor:pointer;transition:background 0.2s;display:inline-flex;align-items:center;
}
.btn-submit:hover { background:#0284c7; }

.btn-cancel {
    display:inline-flex;align-items:center;justify-content:center;
    background:#f9fafb;border:1px solid #e5e7eb;
    color:#6b7280;border-radius:10px;padding:0.75rem 1.25rem;
    font-size:0.875rem;font-weight:500;text-decoration:none;transition:all 0.2s;
}
.btn-cancel:hover { background:#e5e7eb;color:#374151; }

.form-section {
    background:#fff;border:1px solid #e5e7eb;
    border-radius:14px;padding:1.5rem;
}
.form-section-header { display:flex;align-items:flex-start;gap:0.9rem; }
.section-icon { width:40px;height:40px;border-radius:10px;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:1rem; }
.section-title { font-size:0.9rem;font-weight:700;color:#111827;margin:0 0 2px; }
.section-sub { font-size:0.75rem;color:#9ca3af;margin:0; }

.field-label { display:block;font-size:0.72rem;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.4rem; }
.input-icon-wrap { position:relative; }
.input-icon { position:absolute;left:0.85rem;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:0.85rem;pointer-events:none; }
.field-input {
    width:100%;background:#f9fafb;border:1px solid #e5e7eb;
    border-radius:8px;padding:0.65rem 0.9rem 0.65rem 2.3rem;color:#111827;font-size:0.875rem;
    outline:none;transition:border-color 0.2s,box-shadow 0.2s;
}
.field-input::placeholder { color:#9ca3af; }
.field-input:focus { border-color:#0ea5e9;box-shadow:0 0 0 3px rgba(14,165,233,0.12); }
.field-input.is-error { border-color:rgba(239,68,68,0.5);box-shadow:0 0 0 3px rgba(239,68,68,0.1); }
.field-error { color:#dc2626;font-size:0.75rem;margin:4px 0 0; }

.alert-error-dark {
    background:rgba(248,113,113,0.08);border:1px solid rgba(248,113,113,0.2);
    border-radius:10px;padding:0.85rem 1.1rem;
    color:#ef4444;font-size:0.875rem;
    display:flex;align-items:flex-start;gap:0.6rem;
}
.alert-error-dark p { font-size:0.82rem; }

/* INFO CARD */
.info-card {
    background:#fff;border:1px solid #e5e7eb;
    border-radius:14px;padding:1.4rem;
}
.info-label { font-size:0.68rem;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#9ca3af;margin:0 0 0.6rem; }
.divider { border-color:#e5e7eb;margin:1rem 0; }

.agent-preview-row { display:flex;align-items:center;gap:0.75rem; }
.preview-avatar {
    width:38px;height:38px;border-radius:50%;
    background:linear-gradient(135deg,#0ea5e9,#6366f1);
    display:flex;align-items:center;justify-content:center;
    font-size:0.85rem;font-weight:700;color:#fff;flex-shrink:0;text-transform:uppercase;
}
.preview-name { font-size:0.875rem;font-weight:600;color:#111827;margin:0; }
.preview-email { font-size:0.75rem;color:#64748b;margin:0; }

.status-chip { display:inline-block;border-radius:20px;padding:0.22rem 0.85rem;font-size:0.73rem;font-weight:700; }
.status-green { background:rgba(52,211,153,0.1);color:#34d399;border:1px solid rgba(52,211,153,0.2); }

/* DANGER ZONE */
.danger-card {
    background:#fff;border:1px solid #fee2e2;
    border-radius:14px;padding:1.2rem;
}
.danger-title { font-size:0.875rem;font-weight:700;color:#dc2626;margin:0 0 0.4rem; }
.danger-sub { font-size:0.78rem;color:#9ca3af;margin:0 0 1rem; }
.btn-danger-sm {
    background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.25);
    color:#dc2626;border-radius:8px;padding:0.5rem 1rem;
    font-size:0.82rem;font-weight:600;cursor:pointer;transition:all 0.2s;
    display:inline-flex;align-items:center;
}
.btn-danger-sm:hover { background:rgba(239,68,68,0.15); }

.fade-in { opacity:0;transform:translateY(16px);animation:fadeIn 0.6s ease forwards; }
@keyframes fadeIn { to { opacity:1;transform:translateY(0); } }
</style>

@endsection
