{{--
    The server-rendered part of a mohalla page (/lucknow-circle-rate/{sro}/{mohalla}): the mohalla's rates from the
    DM list, worked stamp-duty examples, and links to nearby mohallas. Variables come from pages/lucknow-circle-rate.
    Every rate is printed straight from the JSON; examples use App\Support\CircleRates (same arithmetic as the calculator).
--}}
@php
    use App\Support\CircleRates as CRS;
    $sqft = fn ($v) => '₹' . CRS::inr($v * CRS::SQFT_SQM) . '/sq ft';
    $wid = ['lt9' => 'Road under 9 m', '9_12' => 'Road 9–12 m', '12_18' => 'Road 12–18 m', 'gt18' => 'Road above 18 m'];
    $acol = ['general' => 'सामान्य भूमि (other fields)', 'district_road' => 'जनपदीय मार्ग से सटी (district road)', 'link_road' => 'सम्पर्क मार्ग से सटी (link road)', 'near_abadi' => 'आबादी से सटी (next to abadi)'];
    $waMsg = 'Hi, I think a rate on your ' . $M['en'] . ' (' . $L['sro'] . ') circle rate page may be wrong: ';
@endphp
<div class="lcr-m">
    <div class="lcr-box">
        <h2>{{ $M['en'] }} circle rates (₹ per sq m)</h2>
        <table class="lcr-rates">
            <tr class="h"><td colspan="2">Residential plot (non-agricultural)</td></tr>
            @foreach($wid as $k => $t)
                @if($p[$k] !== null)
                <tr><td>{{ $t }}</td><td>₹{{ CRS::inr($p[$k]) }} <small>{{ $sqft($p[$k]) }}</small></td></tr>
                @endif
            @endforeach
            @if($a)
            <tr class="h"><td colspan="2">Agricultural land (₹ lakh per hectare · per bigha)</td></tr>
            @foreach($acol as $k => $t)
                <tr><td>{{ $t }}</td><td>₹{{ $a[$k] }} L <small>{{ CRS::money($bigha($a[$k])) }}/bigha</small></td></tr>
            @endforeach
            @endif
            <tr class="h"><td colspan="2">Flat construction rate</td></tr>
            <tr><td>Ordinary · Premium</td><td>₹{{ CRS::inr($M['flat']['ordinary']) }} · ₹{{ CRS::inr($M['flat']['premium']) }}</td></tr>
            @if(!empty($M['commercial']))
            <tr class="h"><td colspan="2">Commercial carpet area</td></tr>
            <tr><td>Shop · Office · Godown</td><td>₹{{ CRS::inr($M['commercial']['shop']) }} · ₹{{ CRS::inr($M['commercial']['office']) }} · ₹{{ CRS::inr($M['commercial']['godown']) }}</td></tr>
            @endif
        </table>
        @foreach($M['roads'] as $rd)
            <div class="lcr-road"><strong>On {{ $rd['segment_en'] ?? $rd['segment'] }}</strong>{{ !empty($rd['segment_en']) ? ' (' . $rd['segment'] . ')' : '' }}: plot ₹{{ CRS::inr($rd['plot']) }}/sq m · shop ₹{{ CRS::inr($rd['shop']) }} · office ₹{{ CRS::inr($rd['office']) }} · godown ₹{{ CRS::inr($rd['godown']) }}@if(!empty($rd['agri'])) · agricultural ₹{{ $rd['agri'] }} lakh/ha ({{ CRS::money($bigha($rd['agri'])) }}/bigha)@endif</div>
        @endforeach
        @if(count($L['general_roads'] ?? []))
            <p class="lcr-hint">Property on one of the <a href="#main-roads">{{ count($L['general_roads']) }} main roads of {{ $L['sro'] }}</a> takes that road's rate instead.</p>
        @endif
        @if(!empty($M['amended']))
            <div class="lcr-note">Rates for this {{ $isVillage ? 'village' : 'mohalla' }} were revised by DM Lucknow order 1952 dated 04.06.2026; the figures above are the revised ones.</div>
        @endif
        @if(!empty($M['note']))
            <div class="lcr-note">{{ $M['note'] }}</div>
        @endif
    </div>
    <div class="lcr-box">
        <h2>Stamp duty in {{ $M['en'] }}: worked examples</h2>
        <ul class="lcr-ex">
            @foreach($ex as [$label, $val])
                @php $d = CRS::duty($val); $dw = CRS::duty($val, true); @endphp
                <li data-ex="{{ round($val) }}"><b>{{ $label }}</b><br>
                    Circle-rate value <b>{{ CRS::money($val) }}</b> · stamp duty {{ CRS::money($d['sd']) }} (7%) + registration {{ CRS::money($d['reg']) }} = <b>{{ CRS::money($d['total']) }}</b>
                    @if($dw['rate'] < $d['rate'])<br><small>Woman buyer: stamp duty {{ CRS::money($dw['sd']) }} (6%) + registration {{ CRS::money($dw['reg']) }} = {{ CRS::money($dw['total']) }}</small>@endif
                </li>
            @endforeach
        </ul>
        <p class="lcr-hint">Use the calculator below for your exact size, road, flat or house. Stamp duty is on the circle-rate value or the sale price, whichever is higher.</p>
        <p class="lcr-report">See a rate that does not match the official list? <a href="https://wa.me/918595002933?text={{ rawurlencode($waMsg) }}" target="_blank" rel="noopener">Tell us on WhatsApp</a> · <a href="{{ $lists[0]['pdf'] }}" target="_blank" rel="noopener">official PDF</a></p>
    </div>
</div>
@if(count($nearby))
<div class="lcr-box" style="margin:0 0 26px">
    <h2 style="font-size:17px;margin:0">Nearby in {{ $M['ward_name'] }} and {{ $L['sro'] }}</h2>
    <div class="lcr-near">
        @foreach($nearby as $r)<a href="{{ CRS::url($sel, $r) }}">{{ $r['en'] }} · {{ $r['hi'] }}</a>@endforeach
        <a href="{{ $sroUrl }}#all-rates">All {{ $count }} mohallas of {{ $L['sro'] }} →</a>
    </div>
</div>
@endif
