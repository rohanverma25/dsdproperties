@extends('layouts.user-app')
@section('title', 'Property Valuation Methodology | How DSD Calculates Lucknow Prices')
@section('meta_description', 'Jaanein DSD Properties kaise Lucknow mein property ka sahi market rate calculate karta hai — 9-step process, real listing data, koi agent bias nahi.')
@section('content')
<div class="cs-page">

{{-- ============================================================
     HERO
============================================================ --}}
<section class="cs-hero">
    <div class="cs-hero__bg-grid"></div>
    <div class="cs-hero__orb cs-hero__orb--1"></div>
    <div class="cs-hero__orb cs-hero__orb--2"></div>
    <div class="cs-hero__orb cs-hero__orb--3"></div>

    <div class="cs-container cs-hero__inner">

        <div class="cs-hero__badge cs-reveal">
            <span class="cs-hero__badge-dot"></span>
            AI MODEL v2.4 &nbsp;·&nbsp; Live &amp; Updated
        </div>

        <h1 class="cs-hero__title cs-reveal cs-reveal--delay-1">
            हम Property का<br>
            <span class="cs-hero__title-accent">Price कैसे तय करते हैं?</span>
        </h1>

        <p class="cs-hero__sub cs-reveal cs-reveal--delay-2">
            Lucknow की हर गली का सही Market Rate — बिना किसी Agent की ज़रूरत।<br>
            हमारा AI <strong>9 transparent steps</strong> में real data process करता है।
        </p>

        <div class="cs-hero__stats cs-reveal cs-reveal--delay-3">
            <div class="cs-hero__stat">
                <span class="cs-hero__stat-val" data-count="9">0</span>
                <span class="cs-hero__stat-lbl">Steps की Process</span>
            </div>
            <div class="cs-hero__stat-sep"></div>
            <div class="cs-hero__stat">
                <span class="cs-hero__stat-val" data-count="50">0</span>
                <span class="cs-hero__stat-lbl">Lucknow Localities</span>
            </div>
            <div class="cs-hero__stat-sep"></div>
            <div class="cs-hero__stat">
                <span class="cs-hero__stat-val" data-count="95">0</span>
                <span class="cs-hero__stat-lbl">% Accuracy Rate</span>
            </div>
        </div>

        <div class="cs-hero__trust cs-reveal cs-reveal--delay-4">
            <span>✅ 100% Free</span>
            <span>✅ No Agent Bias</span>
            <span>✅ Lucknow-Specific Data</span>
        </div>

        <div class="cs-hero__scroll cs-reveal cs-reveal--delay-4">
            <span>Process देखें</span>
            <div class="cs-hero__scroll-arrow"></div>
        </div>
    </div>
</section>

{{-- ============================================================
     WHY TRUST US
============================================================ --}}
<section class="cs-why">
    <div class="cs-container">
        <div class="cs-why__card cs-reveal">
            <div class="cs-why__icon">💡</div>
            <div>
                <p class="cs-why__text">
                    <strong>Lucknow में property खरीदना या बेचना एक बड़ा फैसला है।</strong>
                    अक्सर लोग agent की बात पर भरोसा करते हैं — लेकिन agent का interest अपनी commission में होता है, आपकी सही कीमत में नहीं।
                    DSD Properties इसीलिए बनाया गया — ताकि आप खुद देख सकें कि आपकी property का असली market rate क्या है।
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     MAP LEGEND
============================================================ --}}
<section class="cs-legend">
    <div class="cs-container">
        <div class="cs-section-label cs-reveal">Price Map Guide</div>
        <h2 class="cs-section-title cs-reveal cs-reveal--delay-1">Map पर रंगों का मतलब</h2>
        <p class="cs-section-sub cs-reveal cs-reveal--delay-2">जब आप हमारे price map पर किसी area का dot देखें — उसका रंग बताता है कि वो area किस price segment में आता है।</p>

        <div class="cs-legend__grid cs-reveal cs-reveal--delay-2">
            <div class="cs-legend__item cs-legend__item--red">
                <div class="cs-legend__dot"></div>
                <div class="cs-legend__name">Premium</div>
                <div class="cs-legend__price">₹7,000+ / sqft</div>
                <div class="cs-legend__eg">Hazratganj, Gomti Nagar</div>
            </div>
            <div class="cs-legend__item cs-legend__item--orange">
                <div class="cs-legend__dot"></div>
                <div class="cs-legend__name">Upper Mid</div>
                <div class="cs-legend__price">₹5,000–7,000 / sqft</div>
                <div class="cs-legend__eg">Aliganj, Shaheed Path</div>
            </div>
            <div class="cs-legend__item cs-legend__item--green">
                <div class="cs-legend__dot"></div>
                <div class="cs-legend__name">Mid-Segment</div>
                <div class="cs-legend__price">₹3,500–5,000 / sqft</div>
                <div class="cs-legend__eg">Jankipuram, Rajajipuram</div>
            </div>
            <div class="cs-legend__item cs-legend__item--blue">
                <div class="cs-legend__dot"></div>
                <div class="cs-legend__name">Affordable</div>
                <div class="cs-legend__price">₹2,500–3,500 / sqft</div>
                <div class="cs-legend__eg">Alambagh, Dubagga</div>
            </div>
            <div class="cs-legend__item cs-legend__item--black">
                <div class="cs-legend__dot"></div>
                <div class="cs-legend__name">Budget</div>
                <div class="cs-legend__price">₹2,500 से कम / sqft</div>
                <div class="cs-legend__eg">Mohanlalganj, Malihabad</div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     9-STEP PIPELINE
============================================================ --}}
<section class="cs-pipeline">
    <div class="cs-pipeline__bg-line"></div>
    <div class="cs-container">
        <div class="cs-section-label cs-reveal">हमारा Process</div>
        <h2 class="cs-section-title cs-reveal cs-reveal--delay-1">Data से सही Price तक — 9 Steps</h2>
        <p class="cs-section-sub cs-reveal cs-reveal--delay-2">हम आपको बताते हैं कि हमारा AI exactly क्या करता है — कोई hidden magic नहीं, पूरी transparency।</p>

        <div class="cs-steps">

            <div class="cs-step cs-reveal">
                <div class="cs-step__num-wrap">
                    <div class="cs-step__num">01</div>
                    <div class="cs-step__line"></div>
                </div>
                <div class="cs-step__card">
                    <div class="cs-step__icon" style="background:rgba(0,128,128,.12);color:#008080"><i class="fas fa-database"></i></div>
                    <h3 class="cs-step__title">Data इकट्ठा करना</h3>
                    <p class="cs-step__desc">हम Lucknow की properties का data तीन जगहों से लेते हैं — Government circle rates, active property listings, और local broker networks से मिले real transactions।</p>
                    <div class="cs-step__tags"><span>Listings</span><span>Circle Rates</span><span>Broker Data</span></div>
                </div>
            </div>

            <div class="cs-step cs-reveal cs-reveal--delay-1">
                <div class="cs-step__num-wrap">
                    <div class="cs-step__num">02</div>
                    <div class="cs-step__line"></div>
                </div>
                <div class="cs-step__card">
                    <div class="cs-step__icon" style="background:rgba(239,68,68,.1);color:#ef4444"><i class="fas fa-filter"></i></div>
                    <h3 class="cs-step__title">Fake &amp; Inflated Prices हटाना</h3>
                    <p class="cs-step__desc">कुछ listings में sellers ज़रूरत से ज़्यादा कीमत मांगते हैं। हमारा AI ऐसे unusual prices को automatically filter करता है ताकि result हमेशा realistic रहे।</p>
                    <div class="cs-step__viz cs-step__viz--bars">
                        <div class="b" style="height:32px;background:#008080;border-radius:4px 4px 0 0;width:14px"></div>
                        <div class="b" style="height:48px;background:#008080;border-radius:4px 4px 0 0;width:14px"></div>
                        <div class="b" style="height:44px;background:#008080;border-radius:4px 4px 0 0;width:14px"></div>
                        <div class="b" style="height:50px;background:#008080;border-radius:4px 4px 0 0;width:14px"></div>
                        <div class="b" style="height:24px;background:#ef4444;opacity:.5;border-radius:4px 4px 0 0;width:14px"></div>
                        <div class="b" style="height:8px;background:#ef4444;opacity:.5;border-radius:4px 4px 0 0;width:14px"></div>
                    </div>
                </div>
            </div>

            <div class="cs-step cs-reveal cs-reveal--delay-2">
                <div class="cs-step__num-wrap">
                    <div class="cs-step__num">03</div>
                    <div class="cs-step__line"></div>
                </div>
                <div class="cs-step__card">
                    <div class="cs-step__icon" style="background:rgba(59,130,246,.1);color:#3b82f6"><i class="fas fa-chart-line"></i></div>
                    <h3 class="cs-step__title">Price Range बनाना</h3>
                    <p class="cs-step__desc">सभी valid prices को IQR (Interquartile Range) method से एक realistic band में convert किया जाता है — जैसे "₹9,000 से ₹14,000 per sqft।"</p>
                    <div class="cs-step__range-viz">
                        <div class="cs-step__range-label"><span>Fair Range</span><strong>₹9k – ₹14k</strong></div>
                        <div class="cs-step__range-track"><div class="cs-step__range-fill" style="width:65%;margin-left:15%"></div></div>
                    </div>
                </div>
            </div>

            <div class="cs-step cs-reveal">
                <div class="cs-step__num-wrap">
                    <div class="cs-step__num">04</div>
                    <div class="cs-step__line"></div>
                </div>
                <div class="cs-step__card">
                    <div class="cs-step__icon" style="background:rgba(168,85,247,.1);color:#a855f7"><i class="fas fa-road"></i></div>
                    <h3 class="cs-step__title">Location &amp; Infrastructure का असर</h3>
                    <p class="cs-step__desc">Metro station, highway, hospital, या school के पास होने से property की value बढ़ती है। हमारा model हर area के लिए यह automatically calculate करता है।</p>
                    <div class="cs-step__infra">
                        <div class="cs-step__infra-row"><span>Metro Proximity</span><div class="cs-step__infra-bar"><div style="width:85%;background:#a855f7"></div></div><b>85%</b></div>
                        <div class="cs-step__infra-row"><span>Highway Access</span><div class="cs-step__infra-bar"><div style="width:60%;background:#a855f7"></div></div><b>60%</b></div>
                        <div class="cs-step__infra-row"><span>Schools/Hospitals</span><div class="cs-step__infra-bar"><div style="width:72%;background:#a855f7"></div></div><b>72%</b></div>
                    </div>
                </div>
            </div>

            <div class="cs-step cs-reveal cs-reveal--delay-1">
                <div class="cs-step__num-wrap">
                    <div class="cs-step__num">05</div>
                    <div class="cs-step__line"></div>
                </div>
                <div class="cs-step__card">
                    <div class="cs-step__icon" style="background:rgba(255,92,0,.1);color:#FF5C00"><i class="fas fa-balance-scale"></i></div>
                    <h3 class="cs-step__title">Demand &amp; Supply देखना</h3>
                    <p class="cs-step__desc">जिस area में ज़मीन कम है और खरीदार ज़्यादा हैं — वहाँ price naturally ऊपर जाता है। हमारा model inventory pressure और buyer intent को analyze करता है।</p>
                    <div class="cs-step__viz cs-step__viz--bars" style="padding-top:12px">
                        <div style="height:30px;background:#FF5C00;opacity:.7;border-radius:4px 4px 0 0;width:14px"></div>
                        <div style="height:48px;background:#FF5C00;border-radius:4px 4px 0 0;width:14px"></div>
                        <div style="height:22px;background:#FF5C00;opacity:.7;border-radius:4px 4px 0 0;width:14px"></div>
                        <div style="height:40px;background:#FF5C00;opacity:.85;border-radius:4px 4px 0 0;width:14px"></div>
                        <div style="height:18px;background:#FF5C00;opacity:.6;border-radius:4px 4px 0 0;width:14px"></div>
                    </div>
                </div>
            </div>

            <div class="cs-step cs-reveal cs-reveal--delay-2">
                <div class="cs-step__num-wrap">
                    <div class="cs-step__num">06</div>
                    <div class="cs-step__line"></div>
                </div>
                <div class="cs-step__card">
                    <div class="cs-step__icon" style="background:rgba(0,128,128,.12);color:#008080"><i class="fas fa-robot"></i></div>
                    <h3 class="cs-step__title">Area Segment तय करना</h3>
                    <p class="cs-step__desc">AI हर locality को उसकी liquidity और price depth के हिसाब से segment में रखता है — Premium, Upper Mid, Mid, Affordable, या Budget।</p>
                    <div class="cs-step__seg-strip">
                        <div style="background:#7c3aed">Premium</div>
                        <div style="background:#2563eb">Upper</div>
                        <div style="background:#16a34a">Mid</div>
                        <div style="background:#d97706">Afford.</div>
                        <div style="background:#6b7280">Budget</div>
                    </div>
                </div>
            </div>

            <div class="cs-step cs-reveal">
                <div class="cs-step__num-wrap">
                    <div class="cs-step__num">07</div>
                    <div class="cs-step__line"></div>
                </div>
                <div class="cs-step__card cs-step__card--highlight">
                    <div class="cs-step__icon" style="background:rgba(22,163,74,.1);color:#16a34a"><i class="fas fa-chart-bar"></i></div>
                    <h3 class="cs-step__title">Growth Score — Future Value का अंदाज़ा</h3>
                    <p class="cs-step__desc">हर locality को 10 में से एक Growth Score मिलता है जो बताता है कि आगे उस area की value बढ़ने के कितने chances हैं।</p>
                    <div class="cs-step__growth">
                        <div class="cs-step__growth-row"><span>Infrastructure Development</span><strong>25%</strong></div>
                        <div class="cs-step__growth-row"><span>Connectivity</span><strong>20%</strong></div>
                        <div class="cs-step__growth-row"><span>Demand Stability</span><strong>15%</strong></div>
                        <div class="cs-step__growth-row"><span>Price Momentum (3-yr)</span><strong>10%</strong></div>
                        <div class="cs-step__growth-row"><span>Developer Activity</span><strong>10%</strong></div>
                        <div class="cs-step__growth-row"><span>Commercial Expansion</span><strong>10%</strong></div>
                        <div class="cs-step__growth-row"><span>Scarcity Outlook</span><strong>10%</strong></div>
                    </div>
                    <p class="cs-step__note">यह score speculation नहीं है — structured data पर based probability है।</p>
                </div>
            </div>

            <div class="cs-step cs-reveal cs-reveal--delay-1">
                <div class="cs-step__num-wrap">
                    <div class="cs-step__num">08</div>
                    <div class="cs-step__line"></div>
                </div>
                <div class="cs-step__card">
                    <div class="cs-step__icon" style="background:rgba(14,165,233,.1);color:#0ea5e9"><i class="fas fa-signal"></i></div>
                    <h3 class="cs-step__title">Confidence Score — हम कितने Sure हैं?</h3>
                    <p class="cs-step__desc">हर area को एक Confidence Score (0–100) मिलता है। जिस area में ज़्यादा transactions और data होता है, उसका score ज़्यादा होता है।</p>
                    <div class="cs-step__conf">
                        <div class="cs-step__conf-row">
                            <span>Vibhuti Khand</span>
                            <div class="cs-step__conf-bar"><div class="cs-step__conf-fill" data-w="88" style="background:#16a34a"></div></div>
                            <b class="cs-conf-high">High</b>
                        </div>
                        <div class="cs-step__conf-row">
                            <span>Peripheral Zones</span>
                            <div class="cs-step__conf-bar"><div class="cs-step__conf-fill" data-w="54" style="background:#d97706"></div></div>
                            <b class="cs-conf-mod">Moderate</b>
                        </div>
                    </div>
                    <p class="cs-step__note">यह feature इसलिए है ताकि हम आपको कभी झूठी certainty न दें।</p>
                </div>
            </div>

            <div class="cs-step cs-reveal cs-reveal--delay-2">
                <div class="cs-step__num-wrap">
                    <div class="cs-step__num">09</div>
                </div>
                <div class="cs-step__card">
                    <div class="cs-step__icon" style="background:rgba(99,102,241,.1);color:#6366f1"><i class="fas fa-sync-alt"></i></div>
                    <h3 class="cs-step__title">Regular Update — Data कभी पुराना नहीं</h3>
                    <p class="cs-step__desc">Market बदलता रहता है। हमारा model regularly review होता है — price bands, segment shifts, growth probabilities, और infrastructure weighting सब update होते हैं।</p>
                    <div class="cs-step__update-grid">
                        <div>📊 Price Bands</div>
                        <div>📍 Segment Shifts</div>
                        <div>📈 Growth Scores</div>
                        <div>🏗️ Infra Re-weighting</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ============================================================
     VERIFIED DATA TABLE — all 50 localities
============================================================ --}}
<section class="cs-data">
    <div class="cs-container">
        <div class="cs-section-label cs-reveal">Verified Market Data</div>
        <h2 class="cs-section-title cs-reveal cs-reveal--delay-1">Lucknow — 50 Localities का Price Data</h2>
        <p class="cs-section-sub cs-reveal cs-reveal--delay-2">AI-generated price bands — हर locality का segment और confidence score।</p>

        <div class="cs-data__tabs cs-reveal cs-reveal--delay-2">
            <button class="cs-data__tab active" data-seg="All">All (50)</button>
            <button class="cs-data__tab" data-seg="Premium">🔴 Premium</button>
            <button class="cs-data__tab" data-seg="Upper Mid">🟠 Upper Mid</button>
            <button class="cs-data__tab" data-seg="Mid">🟢 Mid</button>
            <button class="cs-data__tab" data-seg="Affordable">🔵 Affordable</button>
            <button class="cs-data__tab" data-seg="Budget">⚫ Budget</button>
        </div>

        <div class="cs-data__wrap cs-reveal cs-reveal--delay-3">
            <div class="cs-data__header-row">
                <div class="cs-data__updated"><i class="fas fa-clock"></i> Updated: {{ date('F Y') }}</div>
            </div>
            <div class="cs-data__table-wrap">
                <table class="cs-data__table" id="localityTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Locality</th>
                            <th>Segment</th>
                            <th>Price / sqft</th>
                            <th class="cs-hide-mobile">Confidence</th>
                        </tr>
                    </thead>
                    <tbody id="localityBody">
                    @php
                    $localities = [
                        ["Hazratganj","Central Lucknow","Premium","₹9,000 – ₹14,000","High",92],
                        ["Butler Colony","Old Lucknow","Premium","₹10,000 – ₹15,000","High",88],
                        ["Vibhuti Khand","Gomti Nagar Ext.","Premium","₹8,000 – ₹11,000","High",90],
                        ["Gomti Nagar (Central)","Central","Premium","₹8,000 – ₹12,000","High",94],
                        ["Gomti Nagar Extension","East","Premium","₹7,000 – ₹9,500","High",85],
                        ["Mahanagar","North","Premium","₹7,500 – ₹10,000","High",82],
                        ["Nirala Nagar","North","Premium","₹7,000 – ₹9,500","Good",78],
                        ["New Hyderabad","Central","Premium","₹7,000 – ₹9,000","Good",76],
                        ["Sushant Golf City","South","Premium","₹6,500 – ₹8,500","Good",80],
                        ["Ashiyana (Sector I–M)","West","Premium","₹6,500 – ₹9,000","Good",79],
                        ["Aliganj","North","Upper Mid","₹5,500 – ₹7,500","Good",75],
                        ["Vrindavan Yojna","South","Upper Mid","₹5,000 – ₹7,000","Good",72],
                        ["Amar Shaheed Path","Corridor","Upper Mid","₹5,500 – ₹7,500","Good",74],
                        ["Faizabad Road","Northeast","Upper Mid","₹5,000 – ₹7,000","Good",70],
                        ["Raebareli Road (PGI Belt)","South","Upper Mid","₹4,800 – ₹6,800","Good",71],
                        ["Kursi Road","North","Upper Mid","₹4,800 – ₹6,500","Moderate",65],
                        ["Indira Nagar (A–Block)","Northeast","Upper Mid","₹5,000 – ₹7,000","Good",73],
                        ["Krishna Nagar","West","Upper Mid","₹4,800 – ₹6,800","Good",69],
                        ["Telibagh","Central","Upper Mid","₹4,800 – ₹6,500","Good",68],
                        ["Chinhat (Highway Belt)","East","Upper Mid","₹5,000 – ₹7,200","Good",71],
                        ["IIM Road","Northwest","Mid","₹4,200 – ₹6,200","Good",67],
                        ["Jankipuram Extension","North","Mid","₹4,000 – ₹5,800","Good",66],
                        ["Sitapur Road","North","Mid","₹4,000 – ₹5,500","Moderate",62],
                        ["Balaganj","West","Mid","₹3,800 – ₹5,200","Moderate",60],
                        ["Thakurganj","West","Mid","₹4,000 – ₹5,800","Moderate",63],
                        ["Rajajipuram (Main Blocks)","West","Mid","₹4,000 – ₹5,500","Moderate",61],
                        ["Para","West","Mid","₹3,800 – ₹5,200","Moderate",59],
                        ["Matiyari","East","Mid","₹4,200 – ₹5,800","Moderate",62],
                        ["South City","South","Mid","₹4,500 – ₹6,000","Good",65],
                        ["Engineering College Road","North","Mid","₹4,800 – ₹6,500","Good",66],
                        ["Sarojini Nagar","Southwest","Affordable","₹3,500 – ₹5,000","Moderate",55],
                        ["Alambagh (Interior)","Southwest","Affordable","₹3,800 – ₹5,200","Moderate",57],
                        ["Kakori Road","West","Affordable","₹3,000 – ₹4,500","Moderate",50],
                        ["Dubagga","West","Affordable","₹3,000 – ₹4,800","Moderate",52],
                        ["Bijnor Road","South","Affordable","₹3,200 – ₹4,800","Moderate",53],
                        ["Kisan Path Belt","East","Affordable","₹3,000 – ₹4,800","Moderate",51],
                        ["Kamta","East","Affordable","₹4,000 – ₹5,500","Moderate",58],
                        ["Deva Road","Northeast","Affordable","₹3,500 – ₹5,200","Moderate",54],
                        ["LDA Colony (Kanpur Road)","Southwest","Affordable","₹3,800 – ₹5,500","Moderate",56],
                        ["Transport Nagar Extension","West","Affordable","₹3,500 – ₹5,000","Moderate",53],
                        ["Mohanlalganj","South Outer","Budget","₹2,800 – ₹4,200","Moderate",48],
                        ["Gosainganj","Southeast Outer","Budget","₹2,500 – ₹3,800","Low",40],
                        ["Banthra (Airport Belt)","Southwest","Budget","₹2,800 – ₹4,000","Moderate",45],
                        ["Malihabad","West Outer","Budget","₹2,500 – ₹3,500","Low",38],
                        ["Barabanki Road Fringe","Northeast","Budget","₹2,800 – ₹4,000","Moderate",44],
                        ["Kisan Path Outer Zone","East Outer","Budget","₹2,800 – ₹4,200","Moderate",46],
                        ["Outer Ring Road West","West Outer","Budget","₹3,000 – ₹4,500","Moderate",47],
                        ["Hardoi Road Fringe","Northwest","Budget","₹2,800 – ₹4,000","Low",42],
                        ["Raebareli Road Outer","South Outer","Budget","₹2,800 – ₹4,200","Moderate",45],
                        ["Sultanpur Road Outer","Southeast","Budget","₹3,000 – ₹4,500","Moderate",46],
                    ];
                    $segColors = [
                        "Premium"    => ["bg"=>"#f3e8ff","text"=>"#7c3aed","dot"=>"#ef4444"],
                        "Upper Mid"  => ["bg"=>"#eff6ff","text"=>"#1d4ed8","dot"=>"#f97316"],
                        "Mid"        => ["bg"=>"#f0fdf4","text"=>"#15803d","dot"=>"#22c55e"],
                        "Affordable" => ["bg"=>"#eff6ff","text"=>"#1e40af","dot"=>"#3b82f6"],
                        "Budget"     => ["bg"=>"#f9fafb","text"=>"#374151","dot"=>"#111827"],
                    ];
                    $confMap = ["High"=>"#16a34a","Good"=>"#2563eb","Moderate"=>"#d97706","Low"=>"#dc2626"];
                    @endphp
                    @foreach($localities as $i => $loc)
                    @php
                        $seg = $loc[2];
                        $sc  = $segColors[$seg];
                        $conf = $loc[4];
                        $pct  = $loc[5];
                    @endphp
                    <tr class="cs-data__row{{ $i >= 10 ? ' cs-row-extra' : '' }}" data-seg="{{ $seg }}" style="{{ $i >= 10 ? 'display:none' : '' }}">
                        <td class="cs-data__num">{{ $i+1 }}</td>
                        <td>
                            <div class="cs-data__name">{{ $loc[0] }}</div>
                            <div class="cs-data__zone">{{ $loc[1] }}</div>
                        </td>
                        <td>
                            <span class="cs-data__seg-badge" style="background:{{ $sc['bg'] }};color:{{ $sc['text'] }}">
                                <span class="cs-data__seg-dot" style="background:{{ $sc['dot'] }}"></span>{{ $seg }}
                            </span>
                        </td>
                        <td class="cs-data__price">{{ $loc[3] }}</td>
                        <td class="cs-hide-mobile">
                            <div class="cs-data__conf-wrap">
                                <div class="cs-data__conf-bar">
                                    <div class="cs-data__conf-fill" data-w="{{ $pct }}" style="background:{{ $confMap[$conf] }};width:0"></div>
                                </div>
                                <span style="color:{{ $confMap[$conf] }};font-size:11px;font-weight:600">{{ $conf }}</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="cs-data__show-more" id="showMoreWrap">
                <button class="cs-btn cs-btn--outline" id="showMoreBtn">
                    <i class="fas fa-chevron-down"></i> और 40 Localities देखें
                </button>
            </div>
            <div class="cs-data__disclaimer">
                ⚠️ यह data केवल reference के लिए है। Actual transaction price कई factors पर depend करती है। अपनी specific property का free valuation पाने के लिए ऊपर दिए tool का use करें।
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     TRANSPARENCY PROMISE
============================================================ --}}
<section class="cs-promise">
    <div class="cs-promise__bg"></div>
    <div class="cs-container cs-promise__inner">
        <div class="cs-promise__icon cs-reveal">🛡️</div>
        <h2 class="cs-promise__title cs-reveal cs-reveal--delay-1">हमारा वादा — पूरी Transparency</h2>
        <p class="cs-promise__sub cs-reveal cs-reveal--delay-2">हम guarantee नहीं देते कि आपकी property इतने में ही बिकेगी — market conditions बदलती रहती हैं। लेकिन हम यह ज़रूर guarantee देते हैं कि हमारा data honest है, process transparent है, और हमारा कोई hidden agenda नहीं है।</p>
        <div class="cs-promise__cards cs-reveal cs-reveal--delay-3">
            <div class="cs-promise__card">
                <div class="cs-promise__card-icon"><i class="fas fa-sync-alt"></i></div>
                <h4>Regular Updates</h4>
                <p>Model समय-समय पर retrain होता है — data पुराना नहीं रहता</p>
            </div>
            <div class="cs-promise__card">
                <div class="cs-promise__card-icon"><i class="fas fa-code"></i></div>
                <h4>No Black Box</h4>
                <p>हर step यहाँ explain किया गया है — कोई छुपी बात नहीं</p>
            </div>
            <div class="cs-promise__card">
                <div class="cs-promise__card-icon"><i class="fas fa-user-check"></i></div>
                <h4>Broker Validated</h4>
                <p>Lucknow के active brokers से data verify किया जाता है</p>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     CTA
============================================================ --}}
<section class="cs-cta">
    <div class="cs-container cs-cta__inner cs-reveal">
        <h2 class="cs-cta__title">अब अपनी Property Check करें</h2>
        <p class="cs-cta__sub">आपने समझ लिया कि हम data कैसे process करते हैं। अब बस अपनी property की details डालें — हम 30 seconds में आपको free valuation report भेज देंगे।</p>
        <a href="/#estimate" class="cs-btn cs-btn--primary cs-btn--lg">
            <i class="fas fa-home"></i> Free Property Valuation पाएं
        </a>
        <p class="cs-cta__note">100% Free &nbsp;·&nbsp; कोई hidden charge नहीं &nbsp;·&nbsp; Lucknow के लिए specifically built</p>
    </div>
</section>

</div>

{{-- ============================================================
     STYLES
============================================================ --}}
<style>
.cs-page{font-family:'Poppins',sans-serif;overflow-x:hidden}
.cs-container{max-width:1100px;margin:0 auto;padding:0 24px}

/* reveal */
.cs-reveal{opacity:0;transform:translateY(28px);transition:opacity .65s ease,transform .65s ease}
.cs-reveal--delay-1{transition-delay:.12s}
.cs-reveal--delay-2{transition-delay:.24s}
.cs-reveal--delay-3{transition-delay:.36s}
.cs-reveal--delay-4{transition-delay:.48s}
.cs-reveal.in-view{opacity:1;transform:translateY(0)}

/* hero */
.cs-hero{position:relative;min-height:92vh;background:linear-gradient(135deg,#011f4b 0%,#013a70 40%,#008080 100%);display:flex;align-items:center;overflow:hidden}
.cs-hero__bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);background-size:48px 48px}
.cs-hero__orb{position:absolute;border-radius:50%;filter:blur(80px);pointer-events:none}
.cs-hero__orb--1{width:520px;height:520px;background:rgba(0,128,128,.3);top:-120px;left:-120px;animation:orbFloat 8s ease-in-out infinite}
.cs-hero__orb--2{width:400px;height:400px;background:rgba(255,92,0,.2);bottom:-80px;right:-80px;animation:orbFloat 10s ease-in-out infinite reverse}
.cs-hero__orb--3{width:280px;height:280px;background:rgba(1,31,75,.5);top:50%;left:50%;transform:translate(-50%,-50%);animation:orbFloat 12s ease-in-out infinite 2s}
@keyframes orbFloat{0%,100%{transform:translateY(0)}50%{transform:translateY(-24px)}}
.cs-hero__orb--3{animation-name:orbFloat3}
@keyframes orbFloat3{0%,100%{transform:translate(-50%,-50%) translateY(0)}50%{transform:translate(-50%,-50%) translateY(-20px)}}

.cs-hero__inner{position:relative;z-index:2;text-align:center;padding:100px 24px 80px;width:100%}
.cs-hero__badge{display:inline-flex;align-items:center;gap:10px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.2);border-radius:99px;padding:8px 20px;margin-bottom:28px;color:rgba(255,255,255,.85);font-size:12px;font-weight:500;letter-spacing:.5px;backdrop-filter:blur(8px)}
.cs-hero__badge-dot{width:8px;height:8px;border-radius:50%;background:#4ade80;box-shadow:0 0 0 3px rgba(74,222,128,.3);animation:pulse 2s infinite}
@keyframes pulse{0%,100%{box-shadow:0 0 0 3px rgba(74,222,128,.3)}50%{box-shadow:0 0 0 6px rgba(74,222,128,.1)}}
.cs-hero__title{font-size:clamp(2rem,5.5vw,3.8rem);font-weight:800;color:#fff;line-height:1.15;margin-bottom:20px;letter-spacing:-.5px}
.cs-hero__title-accent{background:linear-gradient(90deg,#FF5C00,#ffb347);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.cs-hero__sub{font-size:clamp(.95rem,2vw,1.2rem);color:rgba(255,255,255,.75);max-width:640px;margin:0 auto 40px;line-height:1.75}
.cs-hero__sub strong{color:#fff}
.cs-hero__stats{display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);border-radius:16px;padding:24px 40px;max-width:560px;margin:0 auto 32px;backdrop-filter:blur(8px)}
.cs-hero__stat{text-align:center;flex:1}
.cs-hero__stat-val{display:block;font-size:2.4rem;font-weight:800;color:#FF5C00;line-height:1;margin-bottom:6px}
.cs-hero__stat-lbl{font-size:10px;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:1px}
.cs-hero__stat-sep{width:1px;height:48px;background:rgba(255,255,255,.15);margin:0 24px;flex-shrink:0}
.cs-hero__trust{display:flex;gap:20px;justify-content:center;flex-wrap:wrap;font-size:12px;color:rgba(255,255,255,.6);margin-bottom:48px}
.cs-hero__scroll{display:flex;flex-direction:column;align-items:center;gap:8px;font-size:11px;color:rgba(255,255,255,.4);letter-spacing:1px}
.cs-hero__scroll-arrow{width:20px;height:20px;border-right:2px solid rgba(255,255,255,.3);border-bottom:2px solid rgba(255,255,255,.3);transform:rotate(45deg);animation:bounceDown 1.5s ease-in-out infinite}
@keyframes bounceDown{0%,100%{transform:rotate(45deg) translateY(0)}50%{transform:rotate(45deg) translateY(6px)}}

/* section labels */
.cs-section-label{font-size:10px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:#008080;margin-bottom:10px;text-align:center}
.cs-section-title{font-size:clamp(1.6rem,3.5vw,2.4rem);font-weight:800;color:var(--text-primary,#111827);margin-bottom:12px;line-height:1.2;text-align:center}
.cs-section-sub{font-size:.9rem;color:var(--text-secondary,#4b5563);max-width:600px;margin:0 auto 48px;line-height:1.7;text-align:center}

/* why */
.cs-why{padding:40px 0;background:var(--bg-secondary,#f3f4f6)}
.cs-why__card{display:flex;gap:20px;align-items:flex-start;background:var(--card-bg,#fff);border:1px solid var(--border-color,#e5e7eb);border-left:4px solid #008080;border-radius:14px;padding:24px 28px;max-width:820px;margin:0 auto}
.cs-why__icon{font-size:28px;flex-shrink:0;line-height:1;margin-top:2px}
.cs-why__text{font-size:.9rem;color:var(--text-secondary,#4b5563);line-height:1.8;margin:0}
.cs-why__text strong{color:var(--text-primary,#111827)}

/* legend */
.cs-legend{padding:80px 0;background:var(--bg-primary,#fff)}
.cs-legend__grid{display:flex;gap:14px;justify-content:center;flex-wrap:wrap}
.cs-legend__item{display:flex;flex-direction:column;align-items:center;gap:6px;padding:20px 16px;border-radius:14px;background:var(--card-bg,#fff);border:2px solid transparent;min-width:130px;text-align:center;transition:transform .25s,border-color .25s,box-shadow .25s;cursor:default}
.cs-legend__item:hover{transform:translateY(-4px);box-shadow:0 12px 32px rgba(0,0,0,.1)}
.cs-legend__dot{width:20px;height:20px;border-radius:50%;margin-bottom:2px}
.cs-legend__item--red{border-color:rgba(239,68,68,.3);background:rgba(239,68,68,.04)}.cs-legend__item--red .cs-legend__dot{background:#ef4444}
.cs-legend__item--orange{border-color:rgba(249,115,22,.3);background:rgba(249,115,22,.04)}.cs-legend__item--orange .cs-legend__dot{background:#f97316}
.cs-legend__item--green{border-color:rgba(34,197,94,.3);background:rgba(34,197,94,.04)}.cs-legend__item--green .cs-legend__dot{background:#22c55e}
.cs-legend__item--blue{border-color:rgba(59,130,246,.3);background:rgba(59,130,246,.04)}.cs-legend__item--blue .cs-legend__dot{background:#3b82f6}
.cs-legend__item--black{border-color:rgba(17,24,39,.2);background:rgba(17,24,39,.03)}.cs-legend__item--black .cs-legend__dot{background:#111827}
.cs-legend__name{font-size:.8rem;font-weight:700;color:var(--text-primary,#111)}
.cs-legend__price{font-size:.72rem;font-weight:600;color:var(--text-secondary,#4b5563)}
.cs-legend__eg{font-size:.68rem;color:var(--text-tertiary,#9ca3af)}

/* pipeline */
.cs-pipeline{padding:100px 0;background:var(--bg-secondary,#f3f4f6);position:relative;overflow:hidden}
.cs-pipeline__bg-line{position:absolute;left:50%;top:160px;bottom:60px;width:2px;background:linear-gradient(to bottom,#008080,transparent);transform:translateX(-50%);opacity:.1}
.cs-steps{display:flex;flex-direction:column;gap:32px;margin-top:16px}
.cs-step{display:grid;grid-template-columns:72px 1fr;gap:0;align-items:flex-start}
.cs-step__num-wrap{display:flex;flex-direction:column;align-items:center;padding-top:24px}
.cs-step__num{width:52px;height:52px;border-radius:50%;background:linear-gradient(135deg,#011f4b,#008080);color:#fff;font-weight:800;font-size:15px;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 16px rgba(0,128,128,.35);position:relative;z-index:1}
.cs-step__line{width:2px;flex:1;min-height:40px;background:linear-gradient(to bottom,#008080,rgba(0,128,128,.1));margin-top:6px}
.cs-step__card{background:var(--card-bg,#fff);border:1px solid var(--border-color,#e5e7eb);border-radius:18px;padding:28px;margin-left:16px;transition:box-shadow .3s,transform .3s,border-color .3s;position:relative;overflow:hidden}
.cs-step__card::before{content:'';position:absolute;top:0;left:0;width:4px;height:0;background:linear-gradient(to bottom,#008080,#FF5C00);transition:height .35s ease;border-radius:0 0 4px 0}
.cs-step__card:hover::before{height:100%}
.cs-step__card:hover{box-shadow:0 16px 48px rgba(0,0,0,.1);transform:translateY(-3px);border-color:rgba(0,128,128,.3)}
.cs-step__card--highlight{border-color:rgba(22,163,74,.3);background:rgba(22,163,74,.02)}
.cs-step__icon{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:18px;margin-bottom:14px;transition:transform .25s}
.cs-step__card:hover .cs-step__icon{transform:scale(1.1) rotate(-4deg)}
.cs-step__title{font-size:1.1rem;font-weight:700;color:var(--text-primary,#111);margin-bottom:8px}
.cs-step__desc{font-size:.85rem;color:var(--text-secondary,#4b5563);line-height:1.75;margin-bottom:16px}
.cs-step__note{font-size:.75rem;color:var(--text-tertiary,#6b7280);font-style:italic;margin-top:12px}
.cs-step__tags{display:flex;gap:8px;flex-wrap:wrap}
.cs-step__tags span{background:rgba(0,128,128,.1);color:#008080;border-radius:6px;padding:3px 10px;font-size:.72rem;font-weight:600}
.cs-step__viz--bars{display:flex;align-items:flex-end;gap:5px;padding-top:10px}
.cs-step__range-viz{margin-top:12px}
.cs-step__range-label{display:flex;justify-content:space-between;font-size:.78rem;color:var(--text-secondary,#6b7280);margin-bottom:8px}
.cs-step__range-label strong{color:var(--text-primary,#111);font-weight:700}
.cs-step__range-track{height:8px;background:var(--bg-tertiary,#e5e7eb);border-radius:99px;overflow:hidden}
.cs-step__range-fill{height:100%;background:linear-gradient(90deg,#3b82f6,#008080);border-radius:99px}
.cs-step__infra{display:flex;flex-direction:column;gap:8px;margin-top:8px}
.cs-step__infra-row{display:flex;align-items:center;gap:10px;font-size:.78rem;color:var(--text-secondary,#6b7280)}
.cs-step__infra-row span{width:130px;flex-shrink:0}
.cs-step__infra-bar{flex:1;height:6px;background:var(--bg-tertiary,#e5e7eb);border-radius:99px;overflow:hidden}
.cs-step__infra-bar div{height:100%;border-radius:99px}
.cs-step__infra-row b{font-size:.72rem;width:32px;text-align:right;color:var(--text-primary,#111)}
.cs-step__growth{display:flex;flex-direction:column;gap:6px;margin:12px 0}
.cs-step__growth-row{display:flex;justify-content:space-between;align-items:center;font-size:.8rem;padding:5px 0;border-bottom:1px solid var(--bg-tertiary,#e5e7eb)}
.cs-step__growth-row:last-child{border-bottom:none}
.cs-step__growth-row span{color:var(--text-secondary,#4b5563)}
.cs-step__growth-row strong{color:#16a34a;font-size:.82rem}
.cs-step__conf{display:flex;flex-direction:column;gap:10px;margin-top:12px}
.cs-step__conf-row{display:flex;align-items:center;gap:10px;font-size:.78rem;color:var(--text-secondary,#6b7280)}
.cs-step__conf-row span{width:120px;flex-shrink:0}
.cs-step__conf-bar{flex:1;height:6px;background:var(--bg-tertiary,#e5e7eb);border-radius:99px;overflow:hidden}
.cs-step__conf-fill{height:100%;border-radius:99px;width:0;transition:width 1.2s cubic-bezier(.4,0,.2,1)}
.cs-conf-high{color:#16a34a;font-size:.72rem}
.cs-conf-mod{color:#d97706;font-size:.72rem}
.cs-step__seg-strip{display:flex;gap:4px;margin-top:12px;border-radius:8px;overflow:hidden}
.cs-step__seg-strip div{flex:1;height:28px;display:flex;align-items:center;justify-content:center;font-size:.6rem;font-weight:700;color:#fff}
.cs-step__update-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:12px}
.cs-step__update-grid div{background:var(--bg-secondary,#f3f4f6);border-radius:8px;padding:8px 12px;font-size:.78rem;color:var(--text-secondary,#4b5563)}

/* data table */
.cs-data{padding:100px 0;background:var(--bg-primary,#fff)}
.cs-data__tabs{display:flex;gap:8px;flex-wrap:wrap;justify-content:center;margin-bottom:32px}
.cs-data__tab{padding:8px 18px;border-radius:99px;border:1.5px solid var(--border-color,#e5e7eb);background:var(--card-bg,#fff);color:var(--text-secondary,#6b7280);font-family:'Poppins',sans-serif;font-size:.78rem;font-weight:600;cursor:pointer;transition:all .2s}
.cs-data__tab:hover{border-color:#008080;color:#008080}
.cs-data__tab.active{background:#008080;border-color:#008080;color:#fff}
.cs-data__wrap{background:var(--card-bg,#fff);border:1px solid var(--border-color,#e5e7eb);border-radius:20px;overflow:hidden;box-shadow:0 8px 40px rgba(0,0,0,.07)}
.cs-data__header-row{display:flex;justify-content:flex-end;padding:16px 24px;border-bottom:1px solid var(--border-color,#e5e7eb)}
.cs-data__updated{font-size:.75rem;color:var(--text-tertiary,#6b7280);display:flex;align-items:center;gap:6px}
.cs-data__table-wrap{overflow-x:auto}
.cs-data__table{width:100%;border-collapse:collapse;font-size:.85rem}
.cs-data__table thead tr{background:var(--bg-secondary,#f9fafb)}
.cs-data__table th{padding:14px 20px;text-align:left;font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--text-secondary,#6b7280);white-space:nowrap}
.cs-data__table tbody tr{border-top:1px solid var(--border-color,#e5e7eb);transition:background .15s}
.cs-data__table tbody tr:hover{background:var(--bg-secondary,#f9fafb)}
.cs-data__table td{padding:14px 20px;vertical-align:middle}
.cs-data__num{font-size:.75rem;color:var(--text-tertiary,#9ca3af);font-weight:600;width:36px}
.cs-data__name{font-weight:600;color:var(--text-primary,#111);font-size:.87rem}
.cs-data__zone{font-size:.72rem;color:var(--text-tertiary,#9ca3af);margin-top:2px}
.cs-data__price{font-family:'Courier New',monospace;font-weight:700;color:var(--text-primary,#111);font-size:.85rem;white-space:nowrap}
.cs-data__seg-badge{display:inline-flex;align-items:center;gap:6px;padding:4px 10px;border-radius:99px;font-size:.72rem;font-weight:700;white-space:nowrap}
.cs-data__seg-dot{width:7px;height:7px;border-radius:50%;flex-shrink:0}
.cs-data__conf-wrap{display:flex;align-items:center;gap:8px}
.cs-data__conf-bar{width:70px;height:5px;background:var(--bg-tertiary,#e5e7eb);border-radius:99px;overflow:hidden;flex-shrink:0}
.cs-data__conf-fill{height:100%;border-radius:99px;width:0;transition:width 1s ease}
.cs-data__show-more{text-align:center;padding:28px 24px;border-top:1px solid var(--border-color,#e5e7eb)}
.cs-data__disclaimer{padding:14px 24px;background:var(--bg-secondary,#f9fafb);border-top:1px solid var(--border-color,#e5e7eb);font-size:.74rem;color:var(--text-tertiary,#9ca3af);line-height:1.6}
@media(max-width:640px){.cs-hide-mobile{display:none}}

/* promise */
.cs-promise{position:relative;padding:100px 0;overflow:hidden}
.cs-promise__bg{position:absolute;inset:0;background:linear-gradient(135deg,#011f4b 0%,#013a70 50%,#008080 100%)}
.cs-promise__inner{position:relative;z-index:1;text-align:center}
.cs-promise__icon{font-size:48px;margin-bottom:16px;display:block;filter:drop-shadow(0 0 20px rgba(255,92,0,.4))}
.cs-promise__title{font-size:clamp(1.5rem,3vw,2.2rem);font-weight:800;color:#fff;margin-bottom:16px}
.cs-promise__sub{font-size:.9rem;color:rgba(255,255,255,.72);max-width:640px;margin:0 auto 56px;line-height:1.8}
.cs-promise__cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;max-width:800px;margin:0 auto}
.cs-promise__card{background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);border-radius:16px;padding:28px 24px;text-align:center;backdrop-filter:blur(8px);transition:transform .25s,background .25s}
.cs-promise__card:hover{background:rgba(255,255,255,.12);transform:translateY(-4px)}
.cs-promise__card-icon{width:56px;height:56px;background:rgba(255,255,255,.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:22px;color:#FF5C00}
.cs-promise__card h4{color:#fff;font-size:.95rem;font-weight:700;margin-bottom:8px}
.cs-promise__card p{color:rgba(255,255,255,.55);font-size:.8rem;line-height:1.6;margin:0}

/* cta */
.cs-cta{padding:90px 0;background:var(--bg-secondary,#f3f4f6)}
.cs-cta__inner{text-align:center}
.cs-cta__title{font-size:clamp(1.6rem,3vw,2.2rem);font-weight:800;color:var(--text-primary,#111);margin-bottom:14px}
.cs-cta__sub{font-size:.9rem;color:var(--text-secondary,#4b5563);max-width:560px;margin:0 auto 36px;line-height:1.75}
.cs-cta__note{font-size:.75rem;color:var(--text-tertiary,#9ca3af);margin-top:16px}

/* buttons */
.cs-btn{display:inline-flex;align-items:center;gap:10px;font-family:'Poppins',sans-serif;font-weight:700;border-radius:12px;text-decoration:none;cursor:pointer;transition:all .25s;border:none;padding:13px 28px;font-size:.9rem}
.cs-btn--primary{background:linear-gradient(135deg,#FF5C00,#ff8c42);color:#fff;box-shadow:0 6px 24px rgba(255,92,0,.35)}
.cs-btn--primary:hover{transform:translateY(-2px);box-shadow:0 10px 32px rgba(255,92,0,.45);color:#fff;text-decoration:none}
.cs-btn--outline{background:transparent;border:2px solid var(--border-color,#d1d5db);color:var(--text-primary,#111)}
.cs-btn--outline:hover{border-color:#008080;color:#008080}
.cs-btn--lg{padding:16px 36px;font-size:1rem;border-radius:14px}

/* responsive */
@media(max-width:640px){
    .cs-hero__stats{padding:18px 20px;flex-direction:column;gap:16px}
    .cs-hero__stat-sep{width:40px;height:1px;margin:0}
    .cs-step{grid-template-columns:48px 1fr}
    .cs-step__num{width:40px;height:40px;font-size:12px}
    .cs-step__card{padding:18px 14px;margin-left:8px}
    .cs-data__tabs{gap:6px}
    .cs-data__tab{padding:6px 12px;font-size:.72rem}
}
</style>

{{-- ============================================================
     SCRIPTS
============================================================ --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* reveal on scroll */
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (!e.isIntersecting) return;
            e.target.classList.add('in-view');
            e.target.querySelectorAll('.cs-step__conf-fill, .cs-data__conf-fill').forEach(b => {
                b.style.width = b.dataset.w + '%';
            });
            obs.unobserve(e.target);
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.cs-reveal').forEach(el => obs.observe(el));

    /* counter animation */
    const countObs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (!e.isIntersecting) return;
            const el = e.target, target = +el.dataset.count;
            let cur = 0, step = target / 45;
            const t = setInterval(() => {
                cur += step;
                if (cur >= target) { el.textContent = target; clearInterval(t); return; }
                el.textContent = Math.floor(cur);
            }, 30);
            countObs.unobserve(el);
        });
    }, { threshold: 0.5 });
    document.querySelectorAll('[data-count]').forEach(el => countObs.observe(el));

    /* segment filter */
    let showAll = false;
    document.querySelectorAll('.cs-data__tab').forEach(tab => {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.cs-data__tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            const seg = this.dataset.seg;
            const rows = document.querySelectorAll('#localityBody .cs-data__row');
            rows.forEach((row, i) => {
                const match = seg === 'All' || row.dataset.seg === seg;
                if (!match) {
                    row.style.display = 'none';
                } else {
                    if (seg === 'All' && i >= 10 && !showAll) {
                        row.style.display = 'none';
                    } else {
                        row.style.display = '';
                    }
                }
            });
            document.getElementById('showMoreWrap').style.display = (seg === 'All' && !showAll) ? '' : 'none';
            setTimeout(animateBars, 80);
        });
    });

    /* show more */
    document.getElementById('showMoreBtn').addEventListener('click', function () {
        showAll = !showAll;
        document.querySelectorAll('#localityBody .cs-row-extra').forEach(r => {
            r.style.display = showAll ? '' : 'none';
        });
        this.innerHTML = showAll
            ? '<i class="fas fa-chevron-up"></i> कम दिखाएं'
            : '<i class="fas fa-chevron-down"></i> और 40 Localities देखें';
        if (showAll) setTimeout(animateBars, 80);
    });

    function animateBars() {
        document.querySelectorAll('.cs-data__conf-fill').forEach(b => { b.style.width = b.dataset.w + '%'; });
    }
});
</script>

@endsection