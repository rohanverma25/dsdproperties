# Rebuilds storage/app/data/lda_demolitions.json from source-checked entries (20 Oct 2026).
# Every entry was read against its source article; dates are the action date where the
# article states the weekday, otherwise the publication date ("reported").
import json, datetime, os

E = []
def add(date, headline, location, area, category, description, impact, risk, source_name, source_url):
    E.append(dict(date=date, headline=headline, location=location, area=area, category=category,
                  description=description, impact=impact, risk_level=risk,
                  source_name=source_name, source_url=source_url))

# ───────────────────────── 2026 ─────────────────────────
add('2026-10-16', '5 Illegal Plottings on 65 Bigha Razed in Sushant Golf City; 6 Buildings Sealed',
    'Malukpur, Bakkas, Sarsawan & Ahimamau, Sushant Golf City', 'Sushant Golf City', 'Illegal Plotting & Sealing',
    'LDA enforcement teams bulldozed five illegal plottings spread over about 65 bighas in Malukpur, Bakkas, Sarsawan and Ahimamau villages (Sushant Golf City police station area). Six commercial constructions built without an approved map were sealed, including two multi-storey buildings in Gomti Nagar Extension and complexes in Indira Nagar (Pani Gaon), Khurram Nagar and on Ayodhya Road, Chinhat.',
    '65 bighas cleared · 6 buildings sealed', 'critical', 'Amar Ujala',
    'https://www.amarujala.com/lucknow/lucknow-news-lucknow-news-c-13-1-lko1069-1970557-2026-10-16')
add('2026-10-07', '8 Illegal Plottings on 45 Bigha Demolished in Chinhat and BKT',
    'Mehora (Chinhat); Indaurabagh & Rampur Deorai (BKT)', 'Chinhat / BKT', 'Illegal Plotting',
    'Zone-1 demolished six illegal plottings on about 35 bighas in Mehora village, Chinhat. Zone-4 demolished two more on about 10 bighas in Indaurabagh and Rampur Deorai, BKT. None of the layouts had LDA approval, and the prescribed authority court had ordered their demolition.',
    '45 bighas cleared · 8 plottings razed', 'high', 'The Sandesh Wahak',
    'https://www.thesandeshwahak.com/lucknow-lda-bulldozer-action-8-illegal-plottings-45-bigha/')
add('2026-10-06', '4 Illegal Plottings on 15 Bigha Razed in Mohanlalganj',
    'Devha & Ranikheda, Maurawan Road, Mohanlalganj', 'Mohanlalganj', 'Illegal Plotting',
    'LDA bulldozed four illegal plottings covering about 15 bighas in Devha and Ranikheda on Maurawan Road, Mohanlalganj. The prescribed authority court had already passed demolition orders against all four.',
    '15 bighas cleared · 4 plottings razed', 'high', 'Amar Ujala',
    'https://www.amarujala.com/lucknow/lucknow-news-lucknow-news-c-13-1-lko1069-1954421-2026-10-06')
add('2026-09-30', 'LDA to Demolish Entire 6-Storey SA Apartment in Golaganj',
    'Barudkhana, Golaganj', 'Golaganj', 'Demolition Notice',
    'LDA decided to demolish the whole six-storey SA Apartment in Barudkhana, Golaganj, after pillars cracked and construction quality was found unsafe. The map was passed in 2009, but compounding is not allowed because of the poor construction. The earlier order covered only an illegal penthouse on the roof. The builder gets a fresh notice with 15 days for a hearing.',
    'Whole apartment block to be demolished', 'high', 'Amar Ujala',
    'https://www.amarujala.com/lucknow/lucknow-illegal-sa-apartment-to-be-demolished-lda-to-issue-fresh-notice-2026-09-30')
add('2026-09-22', 'Supreme Court Receives SIT and Special-Team Reports on 51 Illegal Aliganj Buildings',
    'Aliganj & Gomti Nagar', 'Aliganj', 'Court Action',
    'The Aliganj fire SIT report was filed in a sealed cover in the Supreme Court. The court-appointed special team, which inspected the 51 identified illegal buildings in Aliganj and some in Gomti Nagar on 5–6 September, submitted its report. The matter is heard with the Loknathan vs State of Tamil Nadu PIL. The next hearing is on 23 November 2026.',
    '51 buildings under Supreme Court scrutiny', 'critical', 'Amar Ujala',
    'https://www.amarujala.com/lucknow/sit-report-filed-in-supreme-court-special-team-also-submits-report-on-51-illegal-buildings-2026-09-22')
add('2026-09-19', '5 Illegal Plottings on 25 Bigha Demolished in Kakori',
    'Behta village, Kakori', 'Kakori', 'Illegal Plotting',
    'Zone-3 bulldozed five illegal plottings on about 25 bighas in Behta village, Kakori. The layouts had no LDA approval, and the prescribed authority court had ordered demolition.',
    '25 bighas cleared · 5 plottings razed', 'high', 'Amar Ujala',
    'https://www.amarujala.com/lucknow/lda-taken-action-lucknow-news-c-13-1-lko1068-1928064-2026-09-19')
add('2026-09-15', 'UP Cabinet Clears Release of 2,747 Mortgaged Sushant Golf City Plots',
    'Sushant Golf City (Ansal API township)', 'Sushant Golf City', 'Township Takeover',
    'The UP cabinet approved LDA\'s proposal on plots Ansal sold while they were mortgaged to LDA. Ansal had mortgaged 3,489 plots as security and sold 2,747 of them without permission. LDA says registries of these 2,747 plots will not be cancelled. LDA will now take a proposal to the NCLT so the township\'s development can be completed.',
    '2,747 plot registries protected · NCLT approval pending', 'medium', 'Constro Facilitator',
    'https://constrofacilitator.com/?p=137735')
add('2026-09-05', '11 Illegal Plottings on 140 Bigha Razed Near Indira Canal and Kisan Path',
    'Bagulha & Sikandarpur Khurd, BBD', 'BBD / Kisan Path', 'Mega Demolition Drive',
    'Zone-1 demolished 11 illegal plottings covering about 140 bighas in Bagulha and Sikandarpur Khurd (BBD police station area), near the Indira Canal and Kisan Path. Three illegal constructions, including row houses, were sealed in Laulai, Hasemau and Bharwara. Zone-7 sealed five illegal commercial buildings in Chowk, Bazarkhala, Saadatganj and Dubagga.',
    '140 bighas cleared · 8 buildings sealed', 'critical', 'Amrit Vichar',
    'https://www.amritvichar.com/article/592704/span-classt-redlucknow-span-ldas-bulldozer-runs-on-illegal-plotting-near')
add('2026-09-03', 'Day 3 in Aliganj: 4 Complexes Sealed; 11 Plottings Razed in Dubagga & Golf City',
    'Chandralok Colony (Aliganj); Mastemau, Bakkas (SGC); Dubagga', 'Aliganj', 'Demolition & Sealing',
    'On the third straight day of action against commercial buildings on residential land in Aliganj, four buildings in Chandralok Colony (Sectors E, F, J) running showrooms, shops and a hospital were sealed. Two plottings (about 10 and 5 bighas) in Mastemau and shops on 1,000 sqm in Fatehpur, Bakkas (Sushant Golf City) were demolished. Nine plottings on 15 bighas were razed in Barawan Kala, Dashahri and Amethia Salempur, Dubagga.',
    '4 sealed · 11 plottings + 1 complex razed', 'high', 'ETV Bharat',
    'https://www.etvbharat.com/hi/state/lda-takes-action-again-in-lucknow-four-complexes-sealed-and-11-illegal-plotted-developments-demolished-aliganj-ups26090400513')
add('2026-09-02', 'Aliganj Day 2: 6 Complexes Sealed Amid Protest; 13 Plottings Razed',
    'Chandralok Colony (Aliganj); Chinhat; Gomti Nagar; Gosainganj; Bijnor; Dubagga', 'Aliganj', 'Demolition & Sealing',
    'Despite local protests, LDA sealed six commercial buildings in Chandralok Colony, Aliganj, housing showrooms, a restaurant, a private bank, a godown and a sports centre. Eight illegal constructions were sealed in Chinhat villages and Viraat Khand, Gomti Nagar. Thirteen illegal plottings on about 30 bighas were bulldozed in Gosainganj (Daud Nagar), Bijnor (Himanchal Nagar) and Dubagga.',
    '14 buildings sealed · 13 plottings razed', 'high', 'ETV Bharat',
    'https://www.etvbharat.com/hi/state/lda-lucknow-takes-action-14-illegal-constructions-sealed-aliganj-chinhat-gomti-nagar-ups26090300439')
add('2026-09-01', 'LDA Begins Sealing 51 Illegal Aliganj Buildings — 7 Sealed on Day One',
    'Chandralok Colony & Sectors B, C, E, Aliganj', 'Aliganj', 'Commercial Sealing',
    'Ahead of the Supreme Court team\'s visit, LDA began sealing the 51 Aliganj buildings it found built against the permitted land use. Seven buildings were sealed on the first day amid protests, after owners had been served notices. The listed buildings house showrooms, hospitals and pathology labs.',
    '7 of 51 identified buildings sealed', 'critical', 'Amar Ujala',
    'https://www.amarujala.com/lucknow/lucknow-seven-illegal-buildings-sealed-in-aliganj-lda-initiates-action-against-51-identified-structures-2026-09-02')
add('2026-08-22', '3 Illegal Plottings on 30 Bigha Razed in Mohanlalganj & PGI; 5 Complexes Sealed',
    'Khujauli & Tikra (Mohanlalganj); Jagatkheda (PGI); Krishna Nagar; Para', 'Mohanlalganj / PGI', 'Illegal Plotting & Sealing',
    'Zone-2 demolished three illegal plottings on about 30 bighas in Khujauli and Tikra (Mohanlalganj) and Jagatkheda (PGI), all developed without an approved layout. Zone-3 sealed an illegal complex in Indralok Colony, Krishna Nagar, and four commercial constructions in the Para police station area.',
    '30 bighas cleared · 5 buildings sealed', 'high', 'Amar Ujala',
    'https://www.amarujala.com/lucknow/lda-bulldozes-three-illegal-plotting-sites-seals-five-lucknow-news-c-13-lko1070-1887108-2026-08-23')
add('2026-08-21', '9 Illegal Plottings Razed in Naimish Nagar Scheme Area — VC Warns Buyers',
    'Shivri (Kakori); BKT & Sairpur', 'Kakori / Sairpur', 'Illegal Plotting',
    'Zone-3 demolished five illegal plottings on about 35 bighas in Shivri village, Kakori. Zone-4 demolished four more on about 20 bighas in the BKT and Sairpur police station areas. LDA is bringing its Naimish Nagar scheme to this area. VC Prathamesh Kumar appealed to people not to buy land here or build without LDA permission.',
    '55 bighas cleared · 9 plottings razed', 'critical', 'ETV Bharat',
    'https://www.etvbharat.com/hi/state/lda-lucknow-bulldozer-action-demolished-illegal-plotting-kakori-bkt-sairpur-ups26082200473')
add('2026-08-14', 'LDA Lists 101 Illegal Buildings for Demolition, Including 51 in Aliganj',
    'Aliganj and other parts of Lucknow', 'Aliganj', 'Demolition List',
    'LDA prepared a list of 101 illegal buildings, including multi-storey apartments built without an approved map, with demolition planned from 17 August. Fifty-one of them are in Aliganj and were identified after Supreme Court directions. LDA asked the Police Commissioner for force and formed special teams for the drive.',
    '101 buildings on demolition list', 'critical', 'TV9 UP',
    'https://www.tv9up.com/cities/lucknow/lda-bulldozer-action-101-illegal-buildings-demolition-drive-august-17-aliganj-in-focus-article-35168.html')
add('2026-07-28', '5 Illegal Plottings on 30 Bigha Razed in BKT; 2 Para Buildings Sealed',
    'Bhaisamau (BKT); Para', 'BKT / Para', 'Illegal Plotting & Sealing',
    'LDA bulldozed five illegal plottings on about 30 bighas in Bhaisamau village, BKT. In Para, it sealed two constructions built without a map: one on about 2,000 sqm beyond the Agra Expressway zero point, and shops with rooms on about 800 sqm in Purvideen Kheda.',
    '30 bighas cleared · 2 buildings sealed', 'high', 'ETV Bharat',
    'https://www.etvbharat.com/hi/state/lda-5-illegal-plotted-developments-demolished-in-bkt-2-commercial-structures-sealed-in-para-ups26072900496')
add('2026-07-17', '8 Illegal Plottings on 40 Bigha Demolished in BKT and Para',
    'Hanskheda & Sadrauna (Para); Rajpur Indaur (BKT)', 'BKT / Para', 'Illegal Plotting',
    'Zone-3 demolished three illegal plottings on about 15 bighas in Hanskheda and Sadrauna, Para. Zone-4 demolished five on 25 bighas in Rajpur Indaur village, BKT. Roads and other works built by private developers were razed.',
    '40 bighas cleared · 8 plottings razed', 'high', 'ETV Bharat',
    'https://www.etvbharat.com/hi/state/lda-bulldozers-crack-illegal-plotting-lucknow-bkt-and-para-areas-ups26071800453')
add('2026-07-10', 'Aliganj Fire Building Declared Illegal; Demolition Ordered Within 15 Days',
    'Plot MS-102, Sector-D, Aliganj', 'Aliganj', 'Targeted Demolition',
    'LDA served a Section 27(1) notice on 23 June. After hearings on 7–8 July, the prescribed authority declared the whole commercial building illegal on 10 July and ordered the owners to demolish it themselves by 25 July. The owners began dismantling it on 20 July under the watch of LDA Zone-4.',
    'Fire-site building ordered demolished', 'critical', 'TV9 UP',
    'https://www.tv9up.com/cities/lucknow/aliganj-fire-lda-demolition-illegal-building-fire-tragedy-building-demolition-article-33994.html')
add('2026-06-22', '15 Killed in Fire at Illegal Commercial Building in Aliganj',
    'Sector-D, Aliganj', 'Aliganj', 'Fatal Fire',
    'A fire in a three-storey building on a residential plot in Aliganj, used commercially and housing an animation centre, killed at least 15 people, mostly students, and injured nine. A demolition order for unauthorised construction had been issued in 2016 but was revoked less than two months later. LDA issued a fresh demolition notice and started an inquiry against its own officials.',
    '15 deaths · Inquiry against LDA officials', 'critical', 'The Tribune (PTI)',
    'https://www.tribuneindia.com/news/uttar-pradesh/demolition-notice-issued-for-aliganj-building-after-lucknow-fire-as-sit-begins-probe/')
add('2026-06-06', 'Land Deals Banned in Phase-1 of IT City and Wellness City',
    'Sultanpur Road (IT City & Wellness City villages)', 'Sultanpur Road', 'Land Transaction Ban',
    'After a Section 11 gazette notification, buying or selling land in Phase-1 of LDA\'s IT City (about 686.66 ha in 10 villages, including Sonai Kanjehra, Bakkas and Khujauli) and Wellness City (about 1,197.98 acres in 7 villages, including Chaurasi, Mastemau and Dularamau) is barred without the collector\'s permission. Only landowners already in the revenue records can benefit from land pooling.',
    'Phase-1 land frozen · Pooling only for recorded owners', 'high', 'Hindustan Times',
    'https://www.hindustantimes.com/cities/lucknow-news/lda-prohibits-land-deals-in-phase-1-of-it-city-wellness-city-projects-101780758619729.html')
add('2026-05-19', 'Illegal Plotting Along Kisan Path Razed in PGI Area; Mohanlalganj Building Sealed',
    'Dalauna (PGI); Harkanshgarhi (Mohanlalganj)', 'PGI / Mohanlalganj', 'Illegal Plotting & Sealing',
    'Zone-2 demolished an illegal colony on about 2 bighas along Kisan Path in Dalauna village (PGI area), on the prescribed authority court\'s order. An illegal commercial building beside Kisan Path in Harkanshgarhi, Mohanlalganj, built without an approved map, was sealed.',
    '2 bighas cleared · 1 building sealed', 'medium', 'Dainik Jagran',
    'https://www.jagran.com/uttar-pradesh/lucknow-city-lucknow-lda-demolishes-illegal-plotting-seals-commercial-building-40244864.html')
add('2026-04-29', '6 Illegal Plottings on ~85 Bigha Razed in Dubagga and Sushant Golf City',
    'Jehta (Dubagga); Sector-H (Sushant Golf City)', 'Dubagga / Sushant Golf City', 'Illegal Plotting',
    'Zone-7 demolished five illegal plottings on about 80 bighas in Jehta village, Dubagga. In Sushant Golf City Sector-H, Zone-2 razed boundary walls and plotting on about 5,000 sqm of land reserved for public facilities near the railway line, on the prescribed authority court\'s order.',
    '~85 bighas cleared · 6 plottings razed', 'critical', 'Dainik Jagran',
    'https://www.jagran.com/uttar-pradesh/lucknow-city-lda-demolishes-6-illegal-plots-in-lucknows-sushant-golf-city-40223717.html')
add('2026-04-18', '80 Bigha of Illegal Plotting Razed in Naimish Nagar Scheme Area and Kakori',
    'Saidapur, Kamlapur, Farrukhabad & Bhauli; Shivri (Kakori)', 'Naimish Nagar / Kakori', 'Illegal Plotting',
    'Zone-4 demolished seven illegal plottings on about 50 bighas in Saidapur, Kamlapur, Farrukhabad and Bhauli, inside the proposed Naimish Nagar scheme on Sitapur Road. Zone-3 razed five plottings on about 30 bighas in Shivri, Kakori, and sealed two illegal commercial constructions in Behta.',
    '80 bighas cleared · 12 plottings razed · 2 sealed', 'critical', 'Navbharat Live',
    'https://navbharatlive.com/uttar-pradesh/lda-bulldozer-action-lucknow-illegal-plotting-demolished-80-bigha-2026-1681757.html')
add('2026-04-07', '4 Illegal Plottings on 15 Bigha Razed in BKT and Chinhat Despite Protest',
    'Bikamau Kala (BKT); Goila (Chinhat)', 'Chinhat / BKT', 'Illegal Plotting',
    'LDA demolished four illegal plottings covering about 15 bighas, including about 5 bighas in Bikamau Kala, BKT, where the prescribed court had ordered demolition and locals protested. Two plottings on 10 bighas were razed in Goila village, Chinhat.',
    '15 bighas cleared · 4 plottings razed', 'high', 'Dainik Jagran',
    'https://www.jagran.com/uttar-pradesh/lucknow-city-lda-demolishes-15-bigha-illegal-plotting-in-lucknow-amidst-protests-40198549.html')
add('2026-03-30', '14 Illegal Plottings on ~60 Bigha Demolished in Kakori, Chinhat, Indira Nagar and Dubagga',
    'Shivri (Kakori); Goila & Rasoolpur Sadat; Maura (Dubagga)', 'Kakori / Dubagga', 'Illegal Plotting',
    'LDA demolished seven illegal plottings on 30 bighas in Shivri, Kakori, and two on 10 bighas in Goila (Chinhat) and Rasoolpur Sadat (Indira Nagar). It also razed five on 20 bighas in Maura, Dubagga. None had an approved layout.',
    '~60 bighas cleared · 14 plottings razed', 'critical', 'Dainik Jagran',
    'https://www.jagran.com/uttar-pradesh/lucknow-city-lucknow-lda-demolishes-14-illegal-plotting-sites-40189427.html')
add('2026-03-19', '100 Bigha Drive: 13 Plottings Including \'Om Sai Green City\' Razed',
    'Rasoolpur Sadat (Indira Nagar); Sarai Premraj (Dubagga)', 'Indira Nagar / Dubagga', 'Mega Demolition Drive',
    'Zone-5 demolished nine illegal plottings, including \'Om Sai Green City\', on about 70 bighas in Rasoolpur Sadat, Indira Nagar. Zone-7 razed four plottings on about 30 bighas in Sarai Premraj, Dubagga.',
    '100 bighas cleared · 13 plottings razed', 'critical', 'ETV Bharat',
    'https://www.etvbharat.com/hi/state/bulldozer-action-in-lucknow-illegal-plotting-being-done-in-100-bighas-in-indira-nagar-was-demolished-uttar-pradesh-news-ups26031906415')
add('2026-02-21', '40 Bigha of Illegal Colonies Razed; Hazratganj Complex Sealed',
    'Kasimpur Biruha (Gosainganj); Kakori; Sairpur; Hazratganj', 'Gosainganj / Kakori / Sairpur', 'Illegal Plotting & Sealing',
    'LDA demolished an illegal colony on about 10 bighas near Chand Sarai crossing in Kasimpur Biruha, Gosainganj. It razed four plottings on about 20 bighas in Ibrahimganj, Khudaint and Palehda (Kakori), and three on about 10 bighas in Palhari, Baurumau and Kodri Bhauli (Sairpur). An illegal three-storey commercial complex in Hazratganj was sealed.',
    '40 bighas cleared · 1 complex sealed', 'high', '4tvNews',
    'https://4tvnews.com/lda-bulldozer-action-in-lucknow-illegal-plotting-on-40-bigha-land-demolished-commercial-complex-sealed/')
add('2026-02-20', '5,103 Homes Used Commercially on 24-m Roads Face Sealing or Demolition',
    '24-metre-wide roads, city-wide', 'City-Wide', 'Commercial Demolition Warning',
    'A survey for LDA found 5,103 residential properties on 24-m-wide roads used commercially without approval. Owners get notices and must regularise under the 2025 building bylaws or stop the commercial use. Otherwise they face sealing or demolition under the UP Urban Planning and Development Act, 1973. Banquet halls, large restaurants, bars, big retail and basement commercial use stay banned.',
    '5,103 properties flagged', 'high', 'The Times of India',
    'https://timesofindia.indiatimes.com/city/lucknow/over-5000-property-owners-may-face-sealing-demolition/articleshow/128575372.cms')
add('2026-02-18', 'Parsvnath Planet Told to Remove Park and Gazebo Built on Open Space',
    'Parsvnath Planet, Vibhuti Khand, Gomti Nagar', 'Gomti Nagar', 'Civic Demolition Notice',
    'LDA told the society to remove, within a week, about 4,000 sq ft of additional construction in the open space (a children\'s park and gazebo built by the RWA), saying it is not part of the approved layout. Residents protested the notice.',
    '~4,000 sq ft targeted', 'medium', 'The Times of India',
    'https://timesofindia.indiatimes.com/city/lucknow/residents-protest-lda-notice-to-demolish-park-and-gazebo/articleshow/128478575.cms')
add('2026-01-28', '12 Illegal Plottings on 38 Bigha Razed in BKT & Gosainganj; 9 Buildings Sealed',
    'Saraiya (BKT); Bakkas (Gosainganj); Sushant Golf City', 'BKT / Gosainganj', 'Illegal Plotting & Sealing',
    'LDA demolished four illegal plottings on 18 bighas in Bakkas, Gosainganj, and eight on 20 bighas in Saraiya village, BKT. Nine commercial buildings built against norms were sealed: seven in Sushant Golf City and two in Khujauli and Sikandarpur Amolia.',
    '38 bighas cleared · 9 buildings sealed', 'high', 'ETV Bharat',
    'https://www.etvbharat.com/hi/state/bulldozer-action-in-lucknow-bahraich-lada-bakt-gosainganj-uttar-pradesh-news-ups26012900454')
add('2026-01-22', '7 Illegal Plottings on 50 Bigha Razed in Gosainganj & Kakori; 4 Buildings Sealed',
    'Sonai Kajehra (Gosainganj); Bhadoi (Kakori); Aliganj; Madiyaon', 'Gosainganj / Kakori', 'Illegal Plotting & Sealing',
    'LDA demolished illegal plotting on about 30 bighas in Sonai Kajehra, Gosainganj, and five plottings on 20 bighas in Bhadoi, Kakori. Four commercial constructions without an approved map were sealed: one in Bada Chandganj, Aliganj, and three in Bhagwati Vihar, Madiyaon.',
    '50 bighas cleared · 4 buildings sealed', 'critical', 'ETV Bharat',
    'https://www.etvbharat.com/hi/state/bulldozer-action-in-lucknow-seven-illegal-plating-demolished-uttar-pradesh-news-ups26012207886')
add('2026-01-05', '12 Illegal Sites on 43.75 Acres Cleared in Gudamba and Kakori',
    'Kapasi (Gudamba); Jaliyamau, Kathingra, Fatehganj & Nathora (Kakori)', 'Gudamba / Kakori', 'Mega Demolition Drive',
    'Zone-5 demolished boundary walls, site offices and temporary structures on four illegal plots of about 12.5 acres in Kapasi, Gudamba. Zone-3 cleared eight illegal plots of about 31.25 acres in Jaliyamau, Kathingra, Fatehganj and Nathora, Kakori.',
    '43.75 acres cleared · 12 sites razed', 'critical', 'The Realty Today',
    'https://therealtytoday.com/news/trending/lda-clears-4375-acres-of-illegal-development-in-anti-encroachment-drive/')

# ───────────────────────── 2025 ─────────────────────────
add('2025-12-16', '8 Illegal Plottings on 87 Bigha Demolished in Dubagga and Sairpur',
    'Jilhapur Maura (Dubagga); Paschim Gaon (Sairpur)', 'Dubagga / Sairpur', 'Mega Demolition Drive',
    'Zone-7 demolished four illegal plottings on 82 bighas in Jilhapur Maura, Dubagga. Zone-4 razed four more on 5 bighas in Paschim Gaon, Sairpur. All were developed without an approved layout.',
    '87 bighas cleared · 8 plottings razed', 'critical', 'Dainik Jagran',
    'https://www.jagran.com/uttar-pradesh/lucknow-city-lucknow-illegal-plotting-demolished-by-lda-40074780.html')
add('2025-12-10', 'Anant Nagar Possession Drive: Residents Allege No Prior Notice',
    'Anant Nagar scheme, Mohaan Road', 'Anant Nagar', 'Residential Demolition',
    'LDA demolished boundary walls and temporary structures to take possession of land for its Anant Nagar scheme. About 35 houses stand in the project alignment. Residents were told to vacate within seven days and collect compensation. They said they got no prior intimation. The court had earlier ruled that LDA could take possession while paying compensation.',
    '~35 houses in alignment · 7-day vacate notice', 'high', 'Hindustan Times',
    'https://www.hindustantimes.com/cities/lucknow-news/lda-launches-demolition-drive-residents-allege-sudden-action-101765383570261.html')
add('2025-11-12', '14 Illegal Plottings on 150 Bigha Razed; 17 Buildings Sealed',
    'Chinhat; Jilhapur Maura, Amethia Salempur, Jehta (Dubagga); Kakrabad (Mal)', 'Chinhat / Dubagga', 'Illegal Plotting & Sealing',
    'Zone-1 demolished four plottings on 30 bighas in Sikandarpur Khurd, Bagulha and Kumharanpurwa (Chinhat). Zone-7 razed ten on 120 bighas in Jilhapur Maura, Amethia Salempur and Jehta (Dubagga) and Kakrabad (Mal). Seventeen illegal constructions, including a car workshop, row houses and commercial complexes, were sealed in Chinhat, Gomti Nagar, Indira Nagar and Gudamba.',
    '150 bighas cleared · 17 sealed', 'critical', 'ETV Bharat',
    'https://www.etvbharat.com/hi/state/lda-has-taken-action-in-chinhat-kakori-and-mal-and-has-run-bulldozer-on-illegal-plotting-in-lucknow-uttar-pradesh-news-ups25111300453')
add('2025-09-29', '7 Illegal Plottings Razed in Gosainganj; 6 Commercial Buildings Sealed',
    'Dularmau & New Jail Road (Gosainganj)', 'Gosainganj', 'Illegal Plotting & Sealing',
    'Zone-1 demolished two illegal colonies on about 20 and 12 bighas in Dularmau, Gosainganj. Zone-2 razed five plottings on 10 bighas along New Jail Road. Six commercial constructions without approved maps were sealed in South City, Sultanpur Road (Khurdahi Bazar), Nagram Road, Saadatganj and Dubagga.',
    '~42 bighas cleared · 6 buildings sealed', 'high', 'ETV Bharat',
    'https://www.etvbharat.com/hi/!state/lda-demolished-7-illegal-plots-in-gosaingaj-lucknow-uttar-pradesh-news-ups25092906091')
add('2025-09-23', '17 Illegal Plottings on ~180 Bigha Razed Across the City',
    'BBD & Sushant Golf City; Dubagga; Madiyaon; Gudamba', 'Multiple Zones', 'Mega Demolition Drive',
    'LDA demolished five plottings on 90 bighas in Sikandarpur Amolia, Sikandarpur Khurd, Deoria and Bakkas (BBD and Sushant Golf City area). It razed five on about 56,000 sqm in Kusmaura Haluapur (Dubagga), three on about 60 bighas in Gaurbhit and Ghazipur Balram (Madiyaon), and plotting on 18,000 sqm in Achramau (Gudamba).',
    '~180 bighas cleared · 17 plottings razed', 'critical', 'ETV Bharat',
    'https://www.etvbharat.com/hi/!state/lda-lucknow-team-demolished-17-illegal-plots-bbd-sushant-golf-city-uttar-pradesh-news-ups25092400426')
add('2025-09-20', 'Illegal Chicken Market on LDA Land Razed in Gomti Nagar Extension',
    'Sector-1, behind Gayatripuram, Gomti Nagar Extension', 'Gomti Nagar Extension', 'Encroachment Removal',
    'A joint acquisition-enforcement team, with police, demolished about 20 tin-shed shops of an illegal chicken market on land LDA had acquired from Ujariyaon village, freeing about 2,500 sqm.',
    '~2,500 sqm freed · ~20 shops razed', 'medium', 'ETV Bharat',
    'https://www.etvbharat.com/hi/!state/lda-demolished-20-shops-of-illegal-chicken-market-with-bulldozer-in-lucknow-uttar-pradesh-news-ups25092004774')
add('2025-08-29', '14 Plottings Razed, Including \'Saubhagya City\' and Sites Inside Varun Vihar & Naimish Nagar',
    'Sakra (Kakori); Palhari (Sairpur); Mohanlalganj; Gosainganj; Dubagga', 'Multiple Zones', 'Illegal Plotting',
    'Six illegal plottings inside proposed LDA schemes were razed: four on about 12 bighas in Sakra, Kakori (Varun Vihar) and two on about 4 bighas in Palhari, Sairpur (Naimish Nagar). Eight more were demolished in Mohanlalganj, Gosainganj and Dubagga, including the ~15-bigha \'Saubhagya City\' colony at Dharmavatkheda on New Jail Road.',
    '14 plottings razed', 'critical', 'ETV Bharat',
    'https://www.etvbharat.com/hi/!state/ldas-bulldozer-runs-on-illegal-plots-in-lucknow-14-illegal-plots-demolished-in-one-day-uttar-pradesh-news-ups25082906313')
add('2025-08-28', '10 Illegal Plottings on 70+ Bigha Razed in BBD, Gosainganj, Sairpur and Kakori',
    'Noorpur Behta (BBD); Dhakwa (Gosainganj); Mehndinagar, Bahru, Gahlwara (Kakori); Palhari (Sairpur)', 'Multiple Zones', 'Illegal Plotting',
    'LDA razed roads, drains, boundary walls and site offices of 10 illegal plottings covering over 70 bighas. These included two sites (8 and 10 bighas) in Noorpur Behta, BBD; about 4 bighas in Dhakwa, Gosainganj; sites of 8, 3, 6 and 20 bighas in Kakori; and three sites in Palhari, Sairpur.',
    '70+ bighas cleared · 10 plottings razed', 'critical', 'Dainik Jagran',
    'https://www.jagran.com/uttar-pradesh/lucknow-city-lucknow-lda-demolishes-10-illegal-plotting-sites-across-70-bighas-24028478.html')
add('2025-08-26', '2 Illegal Plottings on 7 Bigha Razed in Sairpur',
    'Palhari village, Sairpur', 'Sairpur', 'Illegal Plotting',
    'Zone-4 demolished an illegal colony being developed at two spots on seven bighas in Palhari village, Sairpur.',
    '7 bighas cleared · 2 plottings razed', 'medium', 'Amar Ujala',
    'https://www.amarujala.com/lucknow/lda-demolished-plotting-lucknow-news-c-13-1-lko1068-1355416-2025-08-26')
add('2025-08-05', 'LDA Team Faces Protest at Bhauli; MLA Brokers Settlement at Police Station',
    'Vishrampur & Bhauli, BKT', 'BKT', 'Halted Operation',
    'After demolishing illegal plotting in Vishrampur, the LDA team reached Bhauli, where the plot owner and villagers confronted it, alleging no notice had been given. The team went to BKT police station with a complaint, and MLA Yogesh Shukla mediated a settlement there.',
    'Demolition contested · Protest at site', 'medium', 'Amar Ujala',
    'https://www.amarujala.com/lucknow/protest-against-lda-team-which-went-to-demolish-illegal-plotting-uproar-lucknow-news-c-13-knp1050-1326737-2025-08-06')
add('2025-07-22', '7 Illegal Plottings on ~37 Bigha Razed in Gosainganj and Kakori',
    'Sithauli Khurd (Gosainganj); Maunda, Digiya & Samda (Kakori)', 'Gosainganj / Kakori', 'Illegal Plotting',
    'Zone-2 carried out court demolition orders on three plottings (about 2, 2 and 4 bighas) in Sithauli Khurd, Gosainganj. Zone-3 razed four in Kakori: about 3 and 20 bighas in Maunda/Digiya, about 2 bighas by Golden City Group, and about 4.5 bighas in Samda.',
    '~37.5 bighas cleared · 7 plottings razed', 'high', 'Dainik Jagran',
    'https://www.jagran.com/uttar-pradesh/lucknow-city-lucknow-lda-demolishes-7-illegal-plotting-sites-in-gosainganj-and-kakori-23991699.html')
add('2025-07-15', '43 Bigha of Illegal Plotting Razed in Golf City and Gosainganj',
    'Malauli (Gosainganj); Golf City area', 'Gosainganj / Sushant Golf City', 'Illegal Plotting',
    'Zones 1 and 2 demolished illegal plotting across about 43 bighas in the Golf City and Gosainganj areas. In Malauli village, Gosainganj, colonies on about 16, 3, 8 and 6 bighas were razed, all developed without an approved layout.',
    '~43 bighas cleared', 'critical', 'ABP News',
    'https://www.abplive.com/states/up-uk/lucknow-lda-demolished-4-illegal-plotting-on-43-bigha-land-in-golf-city-and-gosaiganj-ann-2979983')
add('2025-07-14', '15 Illegal Plottings Razed in Sairpur, Gudamba, Chinhat, Dubagga and Kakori',
    'Maunda (Kakori); Kamlabad (Sairpur); Palka & Seevan (Gudamba); Naubasta Kalan (Chinhat)', 'Multiple Zones', 'Mega Demolition Drive',
    'LDA demolished 15 illegal plottings in a single day. They included four near Nahariya Road and the Outer Ring Road in Maunda, Kakori; four small sites in Kamlabad, Sairpur; sites of 7,500, 2,500 and 12,000 sqm in Palka and Seevan, Gudamba; and about 20,000 sqm in Naubasta Kalan, Chinhat.',
    '15 plottings razed', 'critical', 'ETV Bharat',
    'https://www.etvbharat.com/hi/!state/lucknow-lda-demolished-15-illegal-plots-gudamba-chinhat-sairpur-dubagga-kakori-uttar-pradesh-news-ups25071500524')
add('2025-06-30', '6 Illegal Colonies Razed in Kakori and BKT, Including \'Shagun City\'',
    'Kathingra & Chakauli (Kakori); Achramau (BKT)', 'Kakori / BKT', 'Illegal Colony',
    'In Kakori, Zone-3 razed plotting on about 8 bighas and the 1.5-bigha \'Shagun City\' colony in Kathingra, plus 2 bighas in Chakauli. In Achramau, BKT, Zone-5 demolished three colonies of 5,000, 7,000 and 5,000 sqm on court orders.',
    '6 colonies razed · 17,000 sqm cleared in BKT', 'high', 'ETV Bharat',
    'https://www.etvbharat.com/hi/!state/bulldozer-run-on-illegal-plotting-in-kakori-and-bkt-of-lucknow-six-colonies-demolished-uttar-pradesh-news-ups25063006762')
add('2025-06-24', '6 Illegal Plottings Razed in Mohanlalganj and Gudamba',
    'Shivdhara (Mohanlalganj); Paikamau & Palka (Gudamba)', 'Mohanlalganj / Gudamba', 'Illegal Plotting',
    'Zone-2 demolished three plottings of 15, 3 and 5 bighas in Shivdhara, Mohanlalganj. Zone-5 razed 12,000 sqm on Kursi Road in Paikamau and 5,000 and 10,000 sqm sites in Palka, Gudamba.',
    '23 bighas + 27,000 sqm cleared · 6 plottings razed', 'high', 'ETV Bharat',
    'https://www.etvbharat.com/hi/!state/lucknow-development-authority-demolished-6-illegal-plots-with-the-help-of-bulldozers-uttar-pradesh-news-ups25062406872')
add('2025-05-25', 'Illegal Colonies Razed in Asti (BKT) and Ganeshpur Rahmanpur (Chinhat)',
    'Asti (BKT); Ganeshpur Rahmanpur (Chinhat)', 'BKT / Chinhat', 'Illegal Colony',
    'On orders from the prescribed court, Zone-5 demolished an illegal colony on about 8,000 sqm near the Shiv Shakti temple in Asti, BKT. It also razed plotting on about 5,000 sqm opposite Akbari Begum Law College in Ganeshpur Rahmanpur, Chinhat.',
    '~13,000 sqm cleared · 2 colonies razed', 'medium', 'Patrika',
    'https://www.patrika.com/lucknow-news/lda-bulldozer-action-illegal-colonies-demolished-in-chinhat-and-bkt-19622219')
add('2025-04-11', '~97 Bigha of Illegal Plotting Razed on Maurawan Road, Incl. \'Sparsh City\' & \'Upvan City\'',
    'Bhasanda & Ranikheda-Dehwa, Maurawan Road, Mohanlalganj', 'Mohanlalganj', 'Illegal Colony',
    'Zone-2 demolished three illegal plottings in Mohanlalganj. They were \'Sparsh City\' on about 40 bighas at Bhasanda (demolished earlier, then rebuilt to sell plots), a 7-bigha site nearby, and \'Upvan City\' on about 50 bighas at Ranikheda-Dehwa.',
    '~97 bighas cleared · 3 colonies razed', 'critical', 'OB News',
    'https://www.obnews.co/Flow/News/id/9875485.html')

# ───────────────────────── 2024 ─────────────────────────
add('2024-12-02', '6.75 Lakh Sq Ft Razed in Palm Paradise Colony; 9 Engineers Face Action',
    'Chandan village, Indira Nagar; Jankipuram Extension; Hazratganj', 'Indira Nagar / Jankipuram', 'Mega Demolition Drive',
    'LDA razed roads, drains, boundary walls and electricity poles over about 6.75 lakh sq ft in Palm Paradise Title Colony, Chandan village, where 29 row houses were built between January 2022 and May 2023 (26 occupied). About 1.08 lakh sq ft of plotting was demolished in Jankipuram Extension. Action was recommended against nine Zone-5 engineers, and seven junior engineers over unchecked construction in Hazratganj.',
    '~7.8 lakh sq ft cleared · 16 engineers face action', 'critical', 'Hindustan Times',
    'https://www.hindustantimes.com/cities/lucknow-news/lda-cracks-down-on-illegal-structures-engineers-face-action-101733162020883.html')
add('2024-08-14', 'Illegal Plotting Razed in BKT; Vipul Khand Commercial Building Sealed',
    'Devrai Kala (BKT); Vipul Khand, Gomti Nagar', 'BKT / Gomti Nagar', 'Demolition & Sealing',
    'On the prescribed court\'s order, LDA demolished illegal plotting on about 3 bighas in Devrai Kala, Chandrika Devi Road, BKT. A commercial construction on about 200 sqm in Vipul Khand, Gomti Nagar, that violated its approved map was sealed.',
    '3 bighas cleared · 1 building sealed', 'medium', 'ETV Bharat',
    'https://www.etvbharat.com/hi/!state/lda-bulldozer-demolish-on-illegal-plotting-in-lucknow-commercial-construction-sealed-in-gomti-nagar-uttar-pradesh-news-ups24081408457')
add('2024-06-19', 'Akbar Nagar Clearance Completed: 1,320+ Structures Razed on Kukrail Riverbed',
    'Akbar Nagar, Kukrail riverbed', 'Akbar Nagar', 'Mega Demolition Drive',
    'LDA said demolition on the Kukrail riverbed was complete: about 1,169 illegal residential and more than 100 commercial properties razed, and over 1,320 structures in total since December 2023, on 24.5 acres. More than 1,800 families were given alternative housing under PM Awas Yojana. An eco-tourism hub is proposed on the site.',
    '1,320+ structures razed · 24.5 acres · 1,800+ families rehoused', 'critical', 'The Hindu',
    'https://www.thehindu.com/news/national/uttar-pradesh/demolition-drive-in-lucknow-more-than-1200-illegal-structures-razed-in-akbarnagar/article68307067.ece')
add('2024-06-10', 'Akbar Nagar Demolition Begins After Supreme Court Upholds High Court Ruling',
    'Akbar Nagar, Kukrail riverbed', 'Akbar Nagar', 'Legal Clearance / Mega Demolition',
    'With eight PAC companies and RAF on watch, LDA began demolishing houses and shops in Akbar Nagar. On 10 May, a Supreme Court bench had upheld the Allahabad High Court ruling on the drive. About 1,679 affected people were allotted housing on Hardoi Road.',
    '1,679 people allotted alternative housing', 'critical', 'The Hindu',
    'https://www.thehindu.com/news/national/uttar-pradesh/demolition-drive-begins-in-lucknows-akbar-nagar-amid-heavy-security/article68274540.ece')
add('2024-03-10', 'Stone-Pelting in Akbar Nagar After Debris Damages 7 Houses',
    'Akbar Nagar', 'Akbar Nagar', 'Halted Operation',
    'Debris from a commercial building being demolished fell on seven adjacent houses, and residents pelted police and the LDA squad with stones. The LDA VC said only commercial establishments were being razed. Following High Court orders, residential properties would not be touched until 31 March.',
    '7 houses damaged · Residential action deferred to 31 Mar', 'high', 'Hindustan Times',
    'https://www.hindustantimes.com/cities/lucknow-news/akbar-nagar-police-pelted-with-stones-after-seven-houses-damaged-in-demolition-drive-101710095587576.html')
add('2024-01-12', '15 Illegal Colonies on 250 Bigha Razed for Mohan Road Scheme',
    'Kakori & Para', 'Kakori / Para', 'Mega Demolition Drive',
    'Over a five-day drive with six JCBs, LDA demolished 15 illegal colonies on 250 bighas in the Kakori and Para areas. This cleared the way for the 785-acre Mohan Road Housing Scheme on land acquired from Kalia Kheda and Pyarepur.',
    '250 bighas cleared · 15 colonies razed', 'critical', 'The Times of India',
    'https://timesofindia.indiatimes.com/city/lucknow/lda-clears-way-for-mohan-road-scheme/articleshow/106798383.cms')

# ids + month labels, newest first
E.sort(key=lambda x: x['date'], reverse=True)
out = []
for i, x in enumerate(E, 1):
    d = datetime.date.fromisoformat(x['date'])
    out.append({'id': i, 'date': x['date'], 'month': d.strftime('%B %Y'), **{k: v for k, v in x.items() if k != 'date'}})

assert len({(o['date'], o['headline']) for o in out}) == len(out)
assert len({o['source_url'] for o in out}) == len(out), 'duplicate source url'
root = os.path.abspath(os.path.join(os.path.dirname(__file__), '..', '..'))
dst = os.path.join(root, 'storage', 'app', 'data', 'lda_demolitions.json')
json.dump(out, open(dst, 'w', encoding='utf-8'), ensure_ascii=False, indent=2)
print(len(out), 'entries written')
