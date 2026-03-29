@extends('layouts.admin')

@section('content')

{{-- PAGE HEADER --}}
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h1 style="font-size:1.5rem;font-weight:800;color:var(--color-text-strong);margin:0;">Agent Ratings</h1>
        <p style="font-size:0.85rem;color:var(--color-text-muted);margin:4px 0 0;">
            Ratings for <strong style="color:var(--color-primary);">{{ $agent->name }}</strong>
        </p>
    </div>
    <a href="{{ route('admin.agents.index') }}"
       style="background:var(--color-surface-soft);color:var(--color-text);border:1px solid var(--color-border);border-radius:8px;padding:0.5rem 1.2rem;font-size:0.85rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;transition:background 0.2s;">
        ← Back to Agents
    </a>
</div>

{{-- SUMMARY CARDS --}}
@php
    $avgRating = $ratings->count() > 0 ? round($ratings->avg('rating'), 1) : 0;
    $totalRatings = $ratings->total();
@endphp
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div style="background:var(--color-white);border:1px solid var(--color-border);border-radius:12px;padding:1.5rem;">
            <p style="font-size:0.72rem;font-weight:600;color:var(--color-text-subtle);text-transform:uppercase;letter-spacing:0.08em;margin:0 0 4px;">Average Rating</p>
            <div class="d-flex align-items-center gap-2">
                <h2 style="font-size:2rem;font-weight:800;color:var(--color-warning);margin:0;">{{ $avgRating }}</h2>
                <div>
                    @for($i = 1; $i <= 5; $i++)
                    <span style="color:{{ $i <= round($avgRating) ? 'var(--color-warning)' : 'var(--color-border-soft)' }};font-size:1.1rem;">★</span>
                    @endfor
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div style="background:var(--color-white);border:1px solid var(--color-border);border-radius:12px;padding:1.5rem;">
            <p style="font-size:0.72rem;font-weight:600;color:var(--color-text-subtle);text-transform:uppercase;letter-spacing:0.08em;margin:0 0 4px;">Total Ratings</p>
            <h2 style="font-size:2rem;font-weight:800;color:var(--color-text-strong);margin:0;">{{ $totalRatings }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div style="background:var(--color-white);border:1px solid var(--color-border);border-radius:12px;padding:1.5rem;">
            <p style="font-size:0.72rem;font-weight:600;color:var(--color-text-subtle);text-transform:uppercase;letter-spacing:0.08em;margin:0 0 4px;">Agent Email</p>
            <p style="font-size:0.95rem;font-weight:600;color:var(--color-text);margin:0;">{{ $agent->email }}</p>
        </div>
    </div>
</div>

{{-- RATINGS TABLE --}}
<div style="background:var(--color-white);border:1px solid var(--color-border);border-radius:14px;overflow:hidden;">
    <div style="padding:1.25rem 1.5rem;border-bottom:1px solid var(--color-border);">
        <h5 style="font-size:1rem;font-weight:700;color:var(--color-text-strong);margin:0;">All Ratings</h5>
    </div>

    @if($ratings->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover mb-0" style="font-size:0.875rem;">
            <thead>
                <tr style="background:var(--color-surface-soft);">
                    <th style="padding:0.8rem 1.5rem;font-weight:600;color:var(--color-text-muted);font-size:0.75rem;text-transform:uppercase;letter-spacing:0.06em;">Parcel</th>
                    <th style="padding:0.8rem;font-weight:600;color:var(--color-text-muted);font-size:0.75rem;text-transform:uppercase;letter-spacing:0.06em;">Rating</th>
                    <th style="padding:0.8rem;font-weight:600;color:var(--color-text-muted);font-size:0.75rem;text-transform:uppercase;letter-spacing:0.06em;">Customer</th>
                    <th style="padding:0.8rem;font-weight:600;color:var(--color-text-muted);font-size:0.75rem;text-transform:uppercase;letter-spacing:0.06em;">Feedback</th>
                    <th style="padding:0.8rem 1.5rem;font-weight:600;color:var(--color-text-muted);font-size:0.75rem;text-transform:uppercase;letter-spacing:0.06em;">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ratings as $rating)
                <tr>
                    <td style="padding:0.8rem 1.5rem;vertical-align:middle;">
                        <span style="color:var(--color-primary);font-weight:600;">{{ $rating->parcel->tracking_id ?? '—' }}</span>
                    </td>
                    <td style="padding:0.8rem;vertical-align:middle;">
                        @for($i = 1; $i <= 5; $i++)
                        <span style="color:{{ $i <= $rating->rating ? 'var(--color-warning)' : 'var(--color-border)' }};font-size:0.9rem;">★</span>
                        @endfor
                    </td>
                    <td style="padding:0.8rem;vertical-align:middle;">
                        <div>
                            <p style="font-weight:600;color:var(--color-text-strong);margin:0;">{{ $rating->customer_name }}</p>
                            @if($rating->customer_email)
                            <p style="font-size:0.78rem;color:var(--color-text-subtle);margin:0;">{{ $rating->customer_email }}</p>
                            @endif
                        </div>
                    </td>
                    <td style="padding:0.8rem;vertical-align:middle;max-width:300px;">
                        <p style="color:var(--color-text);margin:0;line-height:1.5;">{{ $rating->feedback ?? '—' }}</p>
                    </td>
                    <td style="padding:0.8rem 1.5rem;vertical-align:middle;">
                        <span style="color:var(--color-text-subtle);font-size:0.82rem;">{{ $rating->created_at->format('d M Y') }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    @if($ratings->hasPages())
    <div style="padding:1rem 1.5rem;border-top:1px solid var(--color-border);">
        {{ $ratings->links() }}
    </div>
    @endif

    @else
    <div style="padding:3rem;text-align:center;">
        <div style="font-size:3rem;">⭐</div>
        <p style="color:var(--color-text-muted);margin:1rem 0 0;font-size:0.9rem;">No ratings found for this agent yet.</p>
    </div>
    @endif
</div>

@endsection
