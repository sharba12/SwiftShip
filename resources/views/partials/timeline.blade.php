<h5 class="mb-3">Status Timeline</h5>
<div class="live-timeline-container-compact">
    <div class="live-timeline-compact">
        <div id="progressLine"></div>
        <div id="movingDot"></div>

        @php
            $stepOrder = ['pending', 'in_transit', 'out_for_delivery', 'delivered'];
            $stepIndex = array_search($parcel->status, $stepOrder);
        @endphp

        @foreach($stepOrder as $i => $key)
            <div class="live-step-compact {{ $i <= $stepIndex ? 'active' : '' }}">
                <span>{{ ucwords(str_replace('_', ' ', $key)) }}</span>

                @php
                    $timestamp = $parcel->{$key . '_at'};
                @endphp

                @if($timestamp)
                    <small>{{ \Carbon\Carbon::parse($timestamp)->format('d M, H:i') }}</small>
                @endif
            </div>
        @endforeach
    </div>
</div>
