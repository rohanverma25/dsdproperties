{{--
    The server-rendered part of a mohalla page (/lucknow-circle-rate/{sro}/{mohalla}): the mohalla's rates from the
    DM list and worked stamp-duty examples. Nearby mohallas sit under the calculator (pages/lucknow-circle-rate). Variables come from pages/lucknow-circle-rate.
    Every rate is printed straight from the JSON; examples use App\Support\CircleRates (same arithmetic as the calculator).
--}}
@php
    use App\Support\CircleRates as CRS;
    $wid = ['lt9' => 'Road under 9 m', '9_12' => 'Road 9–12 m', '12_18' => 'Road 12–18 m', 'gt18' => 'Road above 18 m'];
    $acol = ['general' => 'सामान्य भूमि (other fields)', 'district_road' => 'जनपदीय मार्ग से सटी (district road)', 'link_road' => 'सम्पर्क मार्ग से सटी (link road)', 'near_abadi' => 'आबादी से सटी (next to abadi)'];
    $waMsg = 'Hi, I think a rate on your ' . $M['en'] . ' (' . $L['sro'] . ') circle rate page may be wrong: ';
@endphp
<div class="lcr-m">
    <div class="lcr-box lcr-ratebox">
        <h2>{{ $M['en'] }} circle rates (₹ per sq m)</h2>
        @php
            $row = fn ($t, $v) => '<tr><td>' . e($t) . '</td><td>₹' . CRS::inr($v) . '</td><td>₹' . CRS::inr($v * CRS::SQFT_SQM) . '</td></tr>';
        @endphp
        <div class="lcr-rt-wrap">
        <table class="lcr-rt" id="lcr-rt">
            <thead><tr><th scope="col">Property type</th><th scope="col">₹ per sq m</th><th scope="col">₹ per sq ft</th></tr></thead>
            <tbody>
            {{-- Villages: agricultural land first, it is what most visitors to these pages look for (user, 28 Oct 2026) --}}
            @if($a)
            <tr class="h"><th colspan="3" scope="rowgroup">Agricultural land <span>(₹ lakh per hectare · per bigha)</span></th></tr>
            @foreach($acol as $k => $t)
                <tr><td>{{ $t }}</td><td>₹{{ $a[$k] }} L/ha</td><td>{{ CRS::money($bigha($a[$k])) }}/bigha</td></tr>
            @endforeach
            @endif
            <tr class="h"><th colspan="3" scope="rowgroup">Residential plot (non-agricultural)</th></tr>
            @foreach($wid as $k => $t)
                @if($p[$k] !== null){!! $row($t, $p[$k]) !!}@endif
            @endforeach
            <tr class="h"><th colspan="3" scope="rowgroup">Flat construction rate</th></tr>
            {!! $row('Flat · ordinary', $M['flat']['ordinary']) !!}
            {!! $row('Flat · premium', $M['flat']['premium']) !!}
            @if(!empty($M['commercial']))
            <tr class="h"><th colspan="3" scope="rowgroup">Commercial carpet area</th></tr>
            {!! $row('Shop', $M['commercial']['shop']) !!}
            {!! $row('Office', $M['commercial']['office']) !!}
            {!! $row('Godown', $M['commercial']['godown']) !!}
            @endif
            @foreach($M['roads'] as $rd)
            <tr class="h road"><th colspan="3" scope="rowgroup">On {{ $rd['segment_en'] ?? $rd['segment'] }}@if(!empty($rd['segment_en'])) <span>({{ $rd['segment'] }})</span>@endif</th></tr>
            {!! $row('Plot', $rd['plot']) !!}
            {!! $row('Shop', $rd['shop']) !!}
            {!! $row('Office', $rd['office']) !!}
            {!! $row('Godown', $rd['godown']) !!}
            @if(!empty($rd['agri']))<tr><td>Agricultural land</td><td>₹{{ $rd['agri'] }} L/ha</td><td>{{ CRS::money($bigha($rd['agri'])) }}/bigha</td></tr>@endif
            @endforeach
            </tbody>
        </table>
        </div>
        <script>
        (function () {
            var t = document.getElementById('lcr-rt');
            if (!t) return;
            t.addEventListener('click', function (e) {
                var tr = e.target.closest('tbody tr');
                if (!tr || tr.classList.contains('h')) return;
                var on = tr.classList.contains('on');
                t.querySelectorAll('tr.on').forEach(function (r) { r.classList.remove('on'); });
                if (!on) tr.classList.add('on');
            });
        })();
        </script>
        @if(count($L['general_roads'] ?? []))
            <p class="lcr-hint">On a <a href="#main-roads" onclick="document.getElementById('main-roads').open=true">main road of {{ $L['sro'] }}</a>? That road's rate applies instead.</p>
        @endif
        @if(!empty($M['amended']))
            <div class="lcr-note">Revised rates (DM order 1952, 4 June 2026).</div>
        @endif
        @if(!empty($M['note']))
            <div class="lcr-note">{{ $M['note'] }}</div>
        @endif
    </div>
    <div class="lcr-box">
        <h2>Registry cost in {{ $M['en'] }}</h2>
        <ul class="lcr-ex">
            @foreach($ex as [$label, $val, $short])
                @php $d = CRS::duty($val); $dw = CRS::duty($val, true); @endphp
                <li data-ex="{{ round($val) }}" title="{{ $label }}">
                    <div class="lcr-ex-top"><span>{{ $short }}</span><b>{{ CRS::money($d['total']) }}</b></div>
                    <small>Value {{ CRS::money($val) }} · stamp duty 7% {{ CRS::money($d['sd']) }} · registration 1% {{ CRS::money($d['reg']) }}</small>
                    @if($dw['rate'] < $d['rate'])<small>Woman buyer (6%): <b>{{ CRS::money($dw['total']) }}</b></small>@endif
                </li>
            @endforeach
        </ul>
        <a class="lcr-go" href="#calculator">Calculate for your size, flat or house ↓</a>
        <p class="lcr-report">Rate looks wrong? <a href="https://wa.me/918595002933?text={{ rawurlencode($waMsg) }}" target="_blank" rel="noopener">Tell us</a></p>
    </div>
</div>
