@extends('layouts.admin')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

<div class="dash-wrap">

    {{-- HEADER --}}
    <div class="dash-header fade-in">
        <div>
            <p class="breadcrumb-trail">
                <a href="{{ route('admin.parcels.index') }}">Parcels</a> &rsaquo; Create
            </p>
            <h1 class="dash-title">Create Parcel</h1>
            <p class="dash-sub">Register a new shipment and assign it to an agent</p>
        </div>
        <a href="{{ route('admin.parcels.index') }}" class="btn-ghost">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <form method="POST" action="{{ route('admin.parcels.store') }}">
        @csrf

        <div class="row g-4 mt-1">

            {{-- LEFT: MAIN FIELDS --}}
            <div class="col-lg-8">

                {{-- CUSTOMER & SENDER --}}
                <div class="form-section fade-in" style="animation-delay:0.08s">
                    <div class="form-section-header">
                        <div class="section-icon" style="background:rgba(14,165,233,0.12);color:var(--color-primary);">
                            <i class="bi bi-person"></i>
                        </div>
                        <div>
                            <h6 class="section-title">Customer & Sender</h6>
                            <p class="section-sub">Select customer — sender name fills automatically</p>
                        </div>
                    </div>

                    <div class="row g-3 mt-1">
                        <div class="col-12">
                            <label class="field-label">Customer</label>
                            <select name="customer_id" id="customer-select" class="select2-field" required>
                                <option value="">— Select Customer —</option>
                                @foreach($customers as $customer)
                                    <option
                                        value="{{ $customer->id }}"
                                        data-sender="{{ $customer->sender_name ?? $customer->name }}"
                                        data-phone="{{ $customer->phone ?? '' }}"
                                        data-address="{{ $customer->address ?? '' }}"
                                    >{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="field-label">Sender Name</label>
                            <div class="input-icon-wrap">
                                <i class="bi bi-person-fill input-icon"></i>
                                <input type="text" id="sender-name" name="sender_name"
                                       class="field-input" placeholder="Auto-filled" readonly required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="field-label">Weight (kg)</label>
                            <div class="input-icon-wrap">
                                <i class="bi bi-box input-icon"></i>
                                <input type="number" name="weight" step="0.01" min="0.01"
                                       class="field-input" placeholder="e.g. 2.50" required>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RECEIVER --}}
                <div class="form-section mt-3 fade-in" style="animation-delay:0.13s">
                    <div class="form-section-header">
                        <div class="section-icon" style="background:rgba(52,211,153,0.12);color:var(--color-success);">
                            <i class="bi bi-person-check"></i>
                        </div>
                        <div>
                            <h6 class="section-title">Receiver Details</h6>
                            <p class="section-sub">Who will receive this parcel?</p>
                        </div>
                    </div>

                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <label class="field-label">Receiver Name</label>
                            <div class="input-icon-wrap">
                                <i class="bi bi-person input-icon"></i>
                                <input type="text" name="receiver_name"
                                       class="field-input" placeholder="Full name" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="field-label">Receiver Contact</label>
                            <div class="input-icon-wrap">
                                <i class="bi bi-telephone input-icon"></i>
                                <input type="text" name="receiver_contact"
                                       class="field-input" placeholder="+91 XXXXX XXXXX" required>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ADDRESSES --}}
                <div class="form-section mt-3 fade-in" style="animation-delay:0.18s">
                    <div class="form-section-header">
                        <div class="section-icon" style="background:rgba(251,191,36,0.12);color:var(--color-warning);">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div>
                            <h6 class="section-title">Pickup & Delivery Addresses</h6>
                            <p class="section-sub">Where should we collect and deliver?</p>
                        </div>
                    </div>

                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <label class="field-label">Pickup Address</label>
                            <textarea name="address_from" class="field-textarea"
                                      rows="3" placeholder="Full pickup address…" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="field-label">Delivery Address</label>
                            <textarea name="address_to" class="field-textarea"
                                      rows="3" placeholder="Full delivery address…" required></textarea>
                        </div>
                    </div>
                </div>

            </div>

            {{-- RIGHT: AGENT + SUBMIT --}}
            <div class="col-lg-4">

                {{-- AGENT --}}
                <div class="form-section fade-in" style="animation-delay:0.2s">
                    <div class="form-section-header">
                        <div class="section-icon" style="background:rgba(167,139,250,0.12);color:var(--color-violet);">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <div>
                            <h6 class="section-title">Assign Agent</h6>
                            <p class="section-sub">Optional — can assign later</p>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="field-label">Delivery Agent</label>
                        <select name="agent_id" class="select2-field">
                            <option value="">— None —</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- SUMMARY BOX --}}
                <div class="summary-card mt-3 fade-in" style="animation-delay:0.25s">
                    <h6 class="summary-title">
                        <i class="bi bi-info-circle me-2" style="color:var(--color-primary);"></i>Before Submitting
                    </h6>
                    <ul class="summary-checklist">
                        <li><i class="bi bi-check2"></i> Customer selected &amp; sender filled</li>
                        <li><i class="bi bi-check2"></i> Receiver name &amp; contact added</li>
                        <li><i class="bi bi-check2"></i> Both addresses completed</li>
                        <li><i class="bi bi-check2"></i> Weight entered in kg</li>
                    </ul>
                </div>

                {{-- SUBMIT --}}
                <div class="mt-3 fade-in" style="animation-delay:0.3s">
                    <button type="submit" class="btn-submit w-100">
                        <i class="bi bi-box-seam me-2"></i> Create Parcel
                    </button>
                    <a href="{{ route('admin.parcels.index') }}" class="btn-cancel w-100 mt-2">
                        Cancel
                    </a>
                </div>

            </div>
        </div>
    </form>
</div>

<style>
.dash-wrap { max-width: 1200px; }
.dash-header { display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:1rem; }
.dash-title { font-size:1.6rem;font-weight:800;color:var(--color-text-strong);letter-spacing:-0.03em;margin:0; }
.dash-sub { font-size:0.78rem;color:var(--color-text-muted);margin:4px 0 0; }
.breadcrumb-trail { font-size:0.78rem;color:var(--color-text-muted);margin:0 0 4px; }
.breadcrumb-trail a { color:var(--color-primary);text-decoration:none; }
.breadcrumb-trail a:hover { color:var(--color-primary); }

/* BUTTONS */
.btn-ghost {
    background:var(--color-surface-soft);
    border:1px solid var(--color-border);
    color:var(--color-text);
    border-radius:8px;padding:0.55rem 1.1rem;
    font-size:0.85rem;font-weight:500;
    text-decoration:none;
    display:inline-flex;align-items:center;gap:0.4rem;
    transition:all 0.2s;white-space:nowrap;
}
.btn-ghost:hover { background:var(--color-white);color:var(--color-text-strong); }

.btn-submit {
    background:var(--color-primary);color:var(--color-white);border:none;
    border-radius:10px;padding:0.85rem;
    font-size:0.9rem;font-weight:700;
    cursor:pointer;transition:background 0.2s;
    display:flex;align-items:center;justify-content:center;
}
.btn-submit:hover { background:var(--color-primary-strong); }

.btn-cancel {
    display:flex;align-items:center;justify-content:center;
    background:var(--color-surface-soft);
    border:1px solid var(--color-border);
    color:var(--color-text-muted);
    border-radius:10px;padding:0.75rem;
    font-size:0.875rem;font-weight:500;
    text-decoration:none;transition:all 0.2s;
}
.btn-cancel:hover { background:var(--color-white);color:var(--color-text-strong); }

/* FORM SECTIONS */
.form-section {
    background:var(--color-white);
    border:1px solid var(--color-border);
    border-radius:14px;padding:1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.form-section-header { display:flex;align-items:flex-start;gap:0.9rem; }
.section-icon {
    width:40px;height:40px;border-radius:10px;flex-shrink:0;
    display:flex;align-items:center;justify-content:center;font-size:1rem;
}
.section-title { font-size:0.9rem;font-weight:700;color:var(--color-text-strong);margin:0 0 2px; }
.section-sub { font-size:0.75rem;color:var(--color-text-muted);margin:0; }

/* FIELDS */
.field-label {
    display:block;font-size:0.72rem;font-weight:600;
    color:var(--color-text-muted);
    text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.4rem;
}
.input-icon-wrap { position:relative; }
.input-icon {
    position:absolute;left:0.85rem;top:50%;transform:translateY(-50%);
    color:var(--color-text-subtle);font-size:0.85rem;pointer-events:none;
}
.field-input {
    width:100%;background:var(--color-surface-soft);
    border:1px solid var(--color-border);
    border-radius:8px;padding:0.65rem 0.9rem 0.65rem 2.3rem;
    color:var(--color-text-strong);font-size:0.875rem;outline:none;
    transition:border-color 0.2s,box-shadow 0.2s;
}
.field-input[readonly] { color:var(--color-text-muted);cursor:default; background:#f3f4f6; }
.field-input::placeholder { color:var(--color-text-subtle); }
.field-input:focus {
    border-color:var(--color-primary);
    box-shadow:0 0 0 3px rgba(14,165,233,0.12);
}
.field-textarea {
    width:100%;background:var(--color-surface-soft);
    border:1px solid var(--color-border);
    border-radius:8px;padding:0.65rem 0.9rem;
    color:var(--color-text-strong);font-size:0.875rem;outline:none;resize:vertical;
    transition:border-color 0.2s,box-shadow 0.2s;
}
.field-textarea::placeholder { color:var(--color-text-subtle); }
.field-textarea:focus {
    border-color:var(--color-primary);box-shadow:0 0 0 3px rgba(14,165,233,0.12);
}

/* SUMMARY */
.summary-card {
    background:var(--color-info-soft);
    border:1px solid rgba(14,165,233,0.2);
    border-radius:12px;padding:1.2rem;
}
.summary-title { font-size:0.85rem;font-weight:700;color:var(--color-text-strong);margin:0 0 0.75rem; }
.summary-checklist { list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:0.5rem; }
.summary-checklist li {
    display:flex;align-items:center;gap:0.5rem;
    font-size:0.8rem;color:var(--color-text);
}
.summary-checklist i { color:var(--color-success);font-size:0.85rem;flex-shrink:0; }

/* SELECT2 LIGHT THEME */
.select2-field { width:100% !important; }
.select2-container--default .select2-selection--single {
    background:var(--color-surface-soft) !important;
    border:1px solid var(--color-border) !important;
    border-radius:8px !important;
    height:40px !important;
    display:flex;align-items:center;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color:var(--color-text-strong) !important;
    padding-left:0.9rem !important;
    line-height:38px !important;
    font-size:0.875rem;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height:38px !important;
}
.select2-container--default .select2-selection--single .select2-selection__arrow b {
    border-color:var(--color-text-subtle) transparent transparent transparent !important;
}
.select2-container--default.select2-container--open .select2-selection--single {
    border-color:var(--color-primary) !important;
    box-shadow:0 0 0 3px rgba(14,165,233,0.12) !important;
}
.select2-dropdown {
    background:var(--color-white) !important;
    border:1px solid var(--color-border) !important;
    border-radius:10px !important;
}
.select2-container--default .select2-results__option {
    color:var(--color-text) !important;
    font-size:0.875rem;padding:0.55rem 0.9rem;
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background:var(--color-primary) !important;color:var(--color-white) !important;
}
.select2-search--dropdown { padding:0.5rem !important; }
.select2-search--dropdown input {
    background:var(--color-surface-soft) !important;
    border:1px solid var(--color-border) !important;
    border-radius:6px !important;color:var(--color-text-strong) !important;
    padding:0.4rem 0.7rem;outline:none;
}

/* ANIMATION */
.fade-in { opacity:0;transform:translateY(16px);animation:fadeIn 0.6s ease forwards; }
@keyframes fadeIn { to { opacity:1;transform:translateY(0); } }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function(){
    $('.select2-field').select2({ width:'100%', placeholder:'Search…', allowClear:true });

    $('#customer-select').on('change', function(){
        const sender = $(this).find(':selected').data('sender') || '';
        $('#sender-name').val(sender);
    });
});
</script>

@endsection
