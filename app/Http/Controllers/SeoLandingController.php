<?php

namespace App\Http\Controllers;

use App\Models\PropertyListing;

class SeoLandingController extends Controller
{
    protected static array $manualPages = [

        'flats-in-lucknow' => [
            'title'            => 'Flats for Sale in Lucknow | Verified Apartments | DSD Properties',
            'meta_description' => 'Browse verified flats for sale in Lucknow. 1, 2, 3 & 4 BHK apartments in Gomti Nagar, Aliganj, Indiranagar. Expert advisory by DSD Properties.',
            'h1'               => 'Flats for Sale in Lucknow',
            'breadcrumb_label' => 'Flats for Sale',
            'canonical'        => '/flats-in-lucknow',
            'hero_color'       => '#011f4b',
            'intro'            => [
                "Lucknow's apartment market in 2025 offers something for every budget — from affordable 1 BHK flats in Alambagh starting around ₹25 lakhs to sprawling 4 BHK residences in Gomti Nagar Extension above ₹2 crore. The city's infrastructure push — Lucknow Metro Phase 2, Ring Road expansion, and Shaheed Path development — is driving strong demand for flats across all price segments.",
                "DSD Properties curates verified flats for sale across Lucknow's most sought-after localities: Gomti Nagar, Aliganj, Indiranagar, Vikas Nagar, Rajajipuram, and the emerging Sultanpur Road corridor. Our advisory team personally visits each property to verify condition, legal documents, and builder credibility before listing.",
                "Whether you are a first-time buyer exploring home loans, an NRI investor seeking rental-yield assets, or a family looking to upgrade, our team provides end-to-end support including document verification, stamp duty guidance, and loan introductions.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell'],
            'related_links' => [
                ['url' => '/2-bhk-flats-lucknow',           'text' => '2 BHK Flats in Lucknow'],
                ['url' => '/3-bhk-flats-lucknow',           'text' => '3 BHK Flats in Lucknow'],
                ['url' => '/flats-under-50-lakhs-lucknow',  'text' => 'Flats Under ₹50 Lakhs'],
                ['url' => '/flats-in-gomti-nagar',          'text' => 'Flats in Gomti Nagar'],
                ['url' => '/luxury-property-lucknow',       'text' => 'Luxury Flats in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the price range of flats for sale in Lucknow?',
                 'a' => 'Flats in Lucknow range from ₹25 lakhs for a 1 BHK in Alambagh to ₹2.5 crore+ for a 4 BHK in Gomti Nagar Extension. A 2 BHK typically costs ₹50–85 lakhs in established localities like Aliganj and Indiranagar.'],
                ['q' => 'Which areas have the best flats for sale in Lucknow?',
                 'a' => 'Gomti Nagar, Gomti Nagar Extension, Aliganj, Indiranagar, Sultanpur Road, and Shaheed Path are the best areas. These localities offer excellent connectivity, schools, hospitals, and strong price appreciation.'],
                ['q' => 'Are RERA-approved flats available in Lucknow?',
                 'a' => 'Yes, most new projects in Lucknow are UP RERA registered. DSD Properties helps you verify RERA compliance for any flat or project before purchase.'],
            ],
        ],

        'plots-for-sale-lucknow' => [
            'title'            => 'Plots for Sale in Lucknow | Residential & Commercial Land | DSD Properties',
            'meta_description' => 'Buy verified plots for sale in Lucknow. LDA-approved, residential & commercial land in Gomti Nagar, Sultanpur Road, Aliganj. Expert advisory.',
            'h1'               => 'Plots for Sale in Lucknow',
            'breadcrumb_label' => 'Plots for Sale',
            'canonical'        => '/plots-for-sale-lucknow',
            'hero_color'       => '#064e3b',
            'intro'            => [
                "Investing in a plot in Lucknow remains one of the most rewarding real estate decisions in UP. With land prices appreciating 15–25% annually in key corridors like Sultanpur Road, Shaheed Path, and Gomti Nagar Extension, buying a plot today offers both self-construction flexibility and strong long-term returns.",
                "DSD Properties lists verified plots for sale across Lucknow — from small 100 sq.yd residential plots in established localities to large 500+ sq.yd commercial plots along high-footfall roads. We carry LDA-approved plots, RERA-registered layouts, and freehold plots with clear titles.",
                "Before listing any plot, our team verifies ownership documents, land use classification (residential/commercial), and registry records. We guide buyers through the mutation, stamp duty, and registry process — ensuring a clean, dispute-free purchase.",
            ],
            'filters'       => ['type' => 'plot', 'transaction' => 'sell'],
            'related_links' => [
                ['url' => '/plots-in-lucknow',              'text' => 'All Plots in Lucknow'],
                ['url' => '/residential-plots-lucknow',     'text' => 'Residential Plots'],
                ['url' => '/lda-approved-plots-lucknow',    'text' => 'LDA Approved Plots'],
                ['url' => '/flats-in-lucknow',              'text' => 'Flats for Sale in Lucknow'],
                ['url' => '/buy-property-lucknow',          'text' => 'Buy Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the price of plots in Lucknow?',
                 'a' => 'Plot prices in Lucknow range from ₹15–20 lakh for a 100 sq.yd plot in developing areas to ₹2 crore+ for prime commercial land in Gomti Nagar. Sultanpur Road and Shaheed Path plots average ₹40–80 lakh for 200 sq.yd.'],
                ['q' => 'Are LDA-approved plots available in Lucknow?',
                 'a' => 'Yes, LDA (Lucknow Development Authority) releases plots through lottery schemes regularly. DSD Properties also lists resale LDA-approved plots with clear titles across Lucknow.'],
                ['q' => 'What documents should I check before buying a plot in Lucknow?',
                 'a' => 'Key documents include the Khasra/Khatauni (land record), Aakar Patra, registry/sale deed, and NOC from LDA or relevant authority. Our team assists with full document verification.'],
            ],
        ],

        '2-bhk-flats-lucknow' => [
            'title'            => '2 BHK Flats in Lucknow | Buy 2 BHK Apartment | DSD Properties',
            'meta_description' => 'Buy 2 BHK flats in Lucknow. Verified 2 bedroom apartments in Gomti Nagar, Aliganj, Indiranagar. Price starting ₹45 lakhs. DSD Properties.',
            'h1'               => '2 BHK Flats in Lucknow',
            'breadcrumb_label' => '2 BHK Flats',
            'canonical'        => '/2-bhk-flats-lucknow',
            'hero_color'       => '#1e3a5f',
            'intro'            => [
                "The 2 BHK flat is Lucknow's most popular residential choice, perfectly balancing space, comfort, and affordability. Ideal for young couples, small families, and working professionals, a well-located 2 BHK in Lucknow offers the sweet spot between budget and lifestyle — typically priced between ₹45 lakhs and ₹1.2 crore depending on the locality and amenities.",
                "DSD Properties lists verified 2 BHK flats across Lucknow's top residential areas including Gomti Nagar, Aliganj, Indiranagar, Vikas Nagar, Rajajipuram, and the fast-growing Sultanpur Road belt. We cover new construction projects, ready-to-move apartments, and resale flats in established societies.",
                "Every listed 2 BHK has been assessed for construction quality, legal title clarity, and fair pricing. Our advisors help you negotiate the best deal and navigate the home loan process with major banks and NBFCs.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'bedrooms' => 2],
            'related_links' => [
                ['url' => '/1-bhk-flats-lucknow',            'text' => '1 BHK Flats in Lucknow'],
                ['url' => '/3-bhk-flats-lucknow',            'text' => '3 BHK Flats in Lucknow'],
                ['url' => '/flats-under-50-lakhs-lucknow',   'text' => 'Flats Under ₹50 Lakhs'],
                ['url' => '/flats-in-gomti-nagar',           'text' => 'Flats in Gomti Nagar'],
                ['url' => '/flats-in-aliganj',               'text' => 'Flats in Aliganj'],
            ],
            'faq' => [
                ['q' => 'What is the price of a 2 BHK flat in Lucknow?',
                 'a' => 'A 2 BHK flat in Lucknow costs between ₹45 lakhs and ₹1.2 crore. In Aliganj and Indiranagar, prices are ₹55–80 lakhs, while in Gomti Nagar Extension, a 2 BHK can cost ₹80 lakhs to ₹1.1 crore.'],
                ['q' => 'What is the typical size of a 2 BHK flat in Lucknow?',
                 'a' => 'A standard 2 BHK flat in Lucknow is 850–1,200 sq.ft (super built-up area). Premium projects may offer larger 1,300–1,500 sq.ft 2 BHK units with extra utility or study room.'],
            ],
        ],

        '3-bhk-flats-lucknow' => [
            'title'            => '3 BHK Flats in Lucknow | Buy 3 BHK Apartment | DSD Properties',
            'meta_description' => 'Buy 3 BHK flats in Lucknow. Verified 3 bedroom apartments in Gomti Nagar, Shaheed Path, Sultanpur Road. Price starting ₹75 lakhs. DSD Properties.',
            'h1'               => '3 BHK Flats in Lucknow',
            'breadcrumb_label' => '3 BHK Flats',
            'canonical'        => '/3-bhk-flats-lucknow',
            'hero_color'       => '#1e3a5f',
            'intro'            => [
                "A 3 BHK flat in Lucknow is the preferred choice for growing families who want ample living space without compromising on connectivity or conveniences. With three bedrooms, a living room, and a dedicated kitchen-dining area, these apartments offer a comfortable lifestyle for families of 4–6. Prices range from ₹75 lakhs in Vikas Nagar to ₹2.5 crore in premium Gomti Nagar projects.",
                "DSD Properties brings you verified 3 BHK apartments across Lucknow's most desirable residential corridors — Gomti Nagar Extension, Shaheed Path, Sultanpur Road, Aliganj, and Sushant Golf City. Many listings are in gated societies with full amenities: club, gym, swimming pool, 24×7 security, and ample parking.",
                "Our property advisors help you compare carpet area vs. super built-up area, evaluate builder track records, check RERA compliance, and negotiate competitive prices — giving you confidence at every step of your 3 BHK purchase.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'bedrooms' => 3],
            'related_links' => [
                ['url' => '/2-bhk-flats-lucknow',        'text' => '2 BHK Flats in Lucknow'],
                ['url' => '/4-bhk-flats-lucknow',        'text' => '4 BHK Flats in Lucknow'],
                ['url' => '/luxury-property-lucknow',    'text' => 'Luxury Flats in Lucknow'],
                ['url' => '/flats-in-gomti-nagar',       'text' => 'Flats in Gomti Nagar'],
                ['url' => '/flats-in-lucknow',           'text' => 'All Flats in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the price of a 3 BHK flat in Lucknow?',
                 'a' => 'A 3 BHK flat in Lucknow costs ₹75 lakhs to ₹2.5 crore. Budget options in Vikas Nagar and Rajajipuram start around ₹75–90 lakhs, while premium 3 BHKs in Gomti Nagar Extension and Shaheed Path range ₹1.2–2 crore.'],
                ['q' => 'Which builders offer 3 BHK flats in Lucknow?',
                 'a' => 'Top builders offering 3 BHK flats in Lucknow include Eldeco, Omaxe, Antriksh, Shalimar, ATS, and Ansal. LDA also offers 3 BHK flats through periodic lottery schemes.'],
            ],
        ],

        '1-bhk-flats-lucknow' => [
            'title'            => '1 BHK Flats in Lucknow | Affordable Apartments | DSD Properties',
            'meta_description' => 'Buy 1 BHK flats in Lucknow. Affordable 1 bedroom apartments starting ₹20 lakhs in Alambagh, Rajajipuram, Indiranagar. DSD Properties.',
            'h1'               => '1 BHK Flats in Lucknow',
            'breadcrumb_label' => '1 BHK Flats',
            'canonical'        => '/1-bhk-flats-lucknow',
            'hero_color'       => '#1e3a5f',
            'intro'            => [
                "1 BHK flats in Lucknow are the entry point into property ownership for first-time buyers, young professionals, and investors seeking rental-generating assets. Compact yet functional, a 1 BHK typically spans 400–650 sq.ft and offers a bedroom, hall, kitchen, and bathroom — ideal for singles and couples. Prices start from ₹20 lakhs in peripheral areas and go up to ₹65 lakhs in central localities.",
                "DSD Properties lists 1 BHK flats across Lucknow's affordable and mid-range zones — Alambagh, Rajajipuram, Chinhat, Transport Nagar, and parts of Indiranagar. Many of these flats are in smaller residential complexes or builder floors, offering good value for money compared to large society projects.",
                "For investors, 1 BHK flats in Lucknow offer rental yields of 4–6% annually, making them attractive buy-to-let options. Our team helps you identify high-demand rental pockets and properties with strong appreciation potential.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'bedrooms' => 1],
            'related_links' => [
                ['url' => '/2-bhk-flats-lucknow',            'text' => '2 BHK Flats in Lucknow'],
                ['url' => '/affordable-flats-lucknow',       'text' => 'Affordable Flats in Lucknow'],
                ['url' => '/flats-under-50-lakhs-lucknow',   'text' => 'Flats Under ₹50 Lakhs'],
                ['url' => '/flats-in-lucknow',               'text' => 'All Flats in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the price of a 1 BHK flat in Lucknow?',
                 'a' => 'A 1 BHK flat in Lucknow costs between ₹20 lakhs and ₹65 lakhs. Affordable options in Alambagh and Rajajipuram start at ₹20–30 lakhs, while 1 BHKs in Gomti Nagar can cost ₹45–65 lakhs.'],
            ],
        ],

        '4-bhk-flats-lucknow' => [
            'title'            => '4 BHK Flats in Lucknow | Premium Apartments | DSD Properties',
            'meta_description' => 'Buy 4 BHK premium flats in Lucknow. Luxury 4 bedroom apartments in Gomti Nagar, Shaheed Path, Sultanpur Road. DSD Properties.',
            'h1'               => '4 BHK Flats in Lucknow',
            'breadcrumb_label' => '4 BHK Flats',
            'canonical'        => '/4-bhk-flats-lucknow',
            'hero_color'       => '#1e3a5f',
            'intro'            => [
                "A 4 BHK flat in Lucknow represents the pinnacle of apartment living — generous living spaces, premium finishes, and world-class amenities designed for discerning buyers. Typically 1,800–3,000 sq.ft in size, these apartments offer four bedrooms, a spacious drawing room, a formal dining area, and modern kitchens. Prices range from ₹1.5 crore to ₹5 crore in Lucknow's premium localities.",
                "The demand for 4 BHK flats is growing in Gomti Nagar Extension, Shaheed Path, Sushant Golf City, and the emerging IT City zone. Top builders like Eldeco, Omaxe, ATS, and Antriksh are developing premium township projects catering to senior executives, business families, and NRI buyers.",
                "DSD Properties provides exclusive advisory for 4 BHK property purchases in Lucknow — including private property tours, developer negotiation, legal due diligence, and interior design referrals. We are your trusted partner for high-value property transactions.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'bedrooms' => 4],
            'related_links' => [
                ['url' => '/3-bhk-flats-lucknow',        'text' => '3 BHK Flats in Lucknow'],
                ['url' => '/luxury-property-lucknow',    'text' => 'Luxury Property in Lucknow'],
                ['url' => '/villa-for-sale-lucknow',     'text' => 'Villas for Sale in Lucknow'],
                ['url' => '/flats-in-lucknow',           'text' => 'All Flats in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the price of a 4 BHK flat in Lucknow?',
                 'a' => 'A 4 BHK flat in Lucknow costs ₹1.5 crore to ₹5 crore. In Gomti Nagar Extension, premium 4 BHKs start at ₹2 crore, while ultra-luxury penthouses in Shaheed Path can exceed ₹4–5 crore.'],
            ],
        ],

        'villa-for-sale-lucknow' => [
            'title'            => 'Villa for Sale in Lucknow | Independent Houses | DSD Properties',
            'meta_description' => 'Buy villas and independent houses for sale in Lucknow. Premium bungalows in Gomti Nagar, Shaheed Path, Sultanpur Road. DSD Properties.',
            'h1'               => 'Villas & Independent Houses for Sale in Lucknow',
            'breadcrumb_label' => 'Villas for Sale',
            'canonical'        => '/villa-for-sale-lucknow',
            'hero_color'       => '#3b1d6e',
            'intro'            => [
                "For buyers seeking the ultimate in privacy, space, and exclusivity, villas and independent houses in Lucknow offer an unmatched lifestyle. A villa provides a private garden, dedicated parking, and complete ownership of the plot — benefits no apartment can match. Lucknow's villa market spans affordable duplex houses in Rajajipuram (₹80 lakhs) to 6,000 sq.ft bungalows in Gomti Nagar above ₹8 crore.",
                "DSD Properties lists premium villas, builder floors, and independent houses across Lucknow's most coveted addresses: Gomti Nagar, Gomti Nagar Extension, Mahanagar, Hazratganj, Kapoorthala, and the exclusive Sushant Golf City township. Whether you seek a sprawling bungalow or a modern duplex villa, we have options across all budget ranges.",
                "Our villa advisory service includes property inspection reports, structural assessment, legal title verification, and guidance on construction approvals — ensuring your independent house purchase is completely safe and transparent.",
            ],
            'filters'       => ['type' => 'villa', 'transaction' => 'sell'],
            'related_links' => [
                ['url' => '/house-for-sale-lucknow',     'text' => 'Houses for Sale in Lucknow'],
                ['url' => '/luxury-property-lucknow',    'text' => 'Luxury Property in Lucknow'],
                ['url' => '/plots-for-sale-lucknow',     'text' => 'Plots for Sale in Lucknow'],
                ['url' => '/buy-property-lucknow',       'text' => 'Buy Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the price of a villa in Lucknow?',
                 'a' => 'Villas in Lucknow are priced from ₹1.2 crore for a 3-bedroom duplex in developing areas to ₹8 crore+ for a premium bungalow in Gomti Nagar or Hazratganj. Gated villa township projects in Sushant Golf City average ₹2–4 crore.'],
            ],
        ],

        'house-for-sale-lucknow' => [
            'title'            => 'House for Sale in Lucknow | Independent Houses | DSD Properties',
            'meta_description' => 'Buy independent houses for sale in Lucknow. Verified homes in Aliganj, Indiranagar, Gomti Nagar. All budgets. DSD Properties.',
            'h1'               => 'Houses for Sale in Lucknow',
            'breadcrumb_label' => 'Houses for Sale',
            'canonical'        => '/house-for-sale-lucknow',
            'hero_color'       => '#3b1d6e',
            'intro'            => [
                "Buying an independent house in Lucknow gives you the freedom to live on your own terms — no society rules, full ownership of the land, and the flexibility to renovate or expand over time. Lucknow's independent house market ranges from compact 2-bedroom homes in Alambagh at ₹55 lakhs to sprawling multi-floor residences in Mahanagar and Hazratganj above ₹5 crore.",
                "DSD Properties lists houses for sale across established and emerging Lucknow localities — Aliganj, Indiranagar, Vikas Nagar, Rajajipuram, Mahanagar, Chinhat, and Transport Nagar. From single-storey pakka houses to modern 3-floor residences with parking, we cover the full spectrum of independent house types.",
                "Our team helps you assess the structural condition of any house, verify the property's land records, check for any encumbrances or litigation, and ensure the registry is clean — so your house purchase in Lucknow is worry-free.",
            ],
            'filters'       => ['type' => 'house', 'transaction' => 'sell'],
            'related_links' => [
                ['url' => '/villa-for-sale-lucknow',     'text' => 'Villas for Sale in Lucknow'],
                ['url' => '/flats-in-lucknow',           'text' => 'Flats for Sale in Lucknow'],
                ['url' => '/plots-for-sale-lucknow',     'text' => 'Plots for Sale in Lucknow'],
                ['url' => '/buy-property-lucknow',       'text' => 'Buy Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the price of an independent house in Lucknow?',
                 'a' => 'Independent houses in Lucknow range from ₹50 lakhs for a small 2-bedroom home in Rajajipuram to ₹5 crore+ for a large multi-floor residence in Gomti Nagar or Mahanagar.'],
            ],
        ],

        'commercial-property-lucknow' => [
            'title'            => 'Commercial Property in Lucknow | Shops, Offices & Showrooms | DSD Properties',
            'meta_description' => 'Buy or rent commercial property in Lucknow. Shops, office spaces, showrooms in Hazratganj, Gomti Nagar, Alambagh. Verified by DSD Properties.',
            'h1'               => 'Commercial Property in Lucknow',
            'breadcrumb_label' => 'Commercial Property',
            'canonical'        => '/commercial-property-lucknow',
            'hero_color'       => '#374151',
            'intro'            => [
                "Lucknow's rapidly expanding economy is creating strong demand for commercial property — from high-street retail shops in Hazratganj to modern office spaces in the IT City corridor and showrooms along the Shaheed Path expressway. With UP's business-friendly policies and Lucknow's growing status as a tier-1 commercial hub, commercial property here offers excellent investment potential.",
                "DSD Properties lists verified commercial properties for sale and lease in Lucknow's prime business zones: Hazratganj, Gomti Nagar, Alambagh, Mahanagar, Aminabad, and the developing IT-City and Vibhuti Khand corridors. We cover shops, showrooms, office floors, IT parks, warehouses, and mixed-use commercial spaces.",
                "Our commercial property advisory covers yield analysis, zoning verification, FSI compliance, and tenant sourcing for investment purchases. We help businesses find the perfect location and investors identify high-yield commercial assets.",
            ],
            'filters'       => ['type' => 'commercial'],
            'related_links' => [
                ['url' => '/buy-property-lucknow',   'text' => 'Buy Property in Lucknow'],
                ['url' => '/flats-in-lucknow',       'text' => 'Residential Flats in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the price of commercial property in Lucknow?',
                 'a' => 'Commercial property prices in Lucknow vary widely: a small shop in a high-street market may cost ₹30–80 lakhs, while an IT-grade office floor in Gomti Nagar can cost ₹1–5 crore. Commercial properties on Shaheed Path command premium prices.'],
            ],
        ],

        'buy-property-lucknow' => [
            'title'            => 'Buy Property in Lucknow | Flats, Plots & Houses | DSD Properties',
            'meta_description' => 'Buy property in Lucknow. Verified flats, plots, villas, and commercial spaces for sale. Expert advisory by DSD Properties. Browse all listings.',
            'h1'               => 'Buy Property in Lucknow',
            'breadcrumb_label' => 'Buy Property',
            'canonical'        => '/buy-property-lucknow',
            'hero_color'       => '#011f4b',
            'intro'            => [
                "Lucknow is emerging as one of north India's most attractive real estate investment destinations. The city's expanding metro network, world-class educational institutions, premium healthcare infrastructure, and booming IT sector are drawing buyers from across UP, Delhi-NCR, and the diaspora. Whether you're buying a first home, upgrading to a larger space, or investing for returns, Lucknow property offers unmatched value.",
                "DSD Properties is Lucknow's trusted property advisory, offering verified listings across all property types — flats, independent houses, villas, plots, and commercial spaces. Our database covers properties in Gomti Nagar, Aliganj, Indiranagar, Alambagh, Vikas Nagar, Sultanpur Road, Shaheed Path, and beyond.",
                "We are not just a listings portal — we are your partner throughout the purchase journey. From shortlisting and site visits to price negotiation, legal due diligence, home loan facilitation, and registry — our team handles every step so you buy with confidence.",
            ],
            'filters'       => ['transaction' => 'sell'],
            'related_links' => [
                ['url' => '/flats-in-lucknow',           'text' => 'Flats for Sale'],
                ['url' => '/plots-for-sale-lucknow',     'text' => 'Plots for Sale'],
                ['url' => '/villa-for-sale-lucknow',     'text' => 'Villas for Sale'],
                ['url' => '/commercial-property-lucknow','text' => 'Commercial Property'],
                ['url' => '/luxury-property-lucknow',    'text' => 'Luxury Property'],
            ],
            'faq' => [
                ['q' => 'Is it a good time to buy property in Lucknow?',
                 'a' => 'Yes, 2025 is an excellent time to buy property in Lucknow. Property prices are appreciating steadily, home loan rates are stabilising, and major infrastructure projects (Metro Phase 2, Ring Road, IT City) are boosting values across key corridors.'],
                ['q' => 'What are the best areas to buy property in Lucknow?',
                 'a' => 'The best areas to buy property in Lucknow in 2025 are Gomti Nagar Extension, Shaheed Path, Sultanpur Road, Sushant Golf City, and Aliganj for residential. For investment, Vibhuti Khand and IT City are rapidly appreciating.'],
            ],
        ],

        'flats-under-50-lakhs-lucknow' => [
            'title'            => 'Flats Under 50 Lakhs in Lucknow | Affordable Apartments | DSD Properties',
            'meta_description' => 'Find flats under 50 lakhs in Lucknow. Affordable 1 & 2 BHK apartments in Alambagh, Rajajipuram, Indiranagar. Verified by DSD Properties.',
            'h1'               => 'Flats Under ₹50 Lakhs in Lucknow',
            'breadcrumb_label' => 'Flats Under 50L',
            'canonical'        => '/flats-under-50-lakhs-lucknow',
            'hero_color'       => '#065f46',
            'intro'            => [
                "Buying a home in Lucknow under ₹50 lakhs is absolutely achievable if you know where to look. The city has multiple developing localities where well-built 1 BHK and 2 BHK flats are available at affordable prices — and with a 20% down payment of ₹10 lakhs and a home loan at 8.5%, your EMI would be just ₹30,000–35,000/month.",
                "DSD Properties lists verified flats under ₹50 lakhs across Lucknow's value zones — Alambagh, Rajajipuram, Aashiyana, Chinhat, Transport Nagar, and Kanpur Road areas. These localities have improving civic infrastructure, good bus connectivity, and proximity to key employment zones.",
                "All properties in this budget segment are personally verified by our team for construction quality, occupancy certificate status, and title clarity. We help first-time buyers navigate government schemes like PMAY (Pradhan Mantri Awas Yojana) to reduce costs further.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'max_price' => 5000000],
            'related_links' => [
                ['url' => '/1-bhk-flats-lucknow',        'text' => '1 BHK Flats in Lucknow'],
                ['url' => '/affordable-flats-lucknow',   'text' => 'Affordable Flats in Lucknow'],
                ['url' => '/flats-under-1-crore-lucknow','text' => 'Flats Under ₹1 Crore'],
                ['url' => '/flats-in-lucknow',           'text' => 'All Flats in Lucknow'],
            ],
            'faq' => [
                ['q' => 'Are there flats available under 50 lakhs in Lucknow?',
                 'a' => 'Yes, flats under ₹50 lakhs are available in localities like Alambagh, Rajajipuram, Aashiyana, and Chinhat. These are typically 1 BHK (450–600 sq.ft) or small 2 BHK apartments in builder complexes.'],
                ['q' => 'Can I get a home loan for a flat under 50 lakhs in Lucknow?',
                 'a' => 'Yes, banks readily offer home loans for properties under ₹50 lakhs. With a 20% down payment, you can get a loan of ₹40 lakhs at 8.5% interest for 20 years at an EMI of approximately ₹34,700/month.'],
            ],
        ],

        'flats-under-1-crore-lucknow' => [
            'title'            => 'Flats Under 1 Crore in Lucknow | Mid-Range Apartments | DSD Properties',
            'meta_description' => 'Flats under 1 crore in Lucknow. 2 & 3 BHK apartments in Gomti Nagar, Aliganj, Indiranagar. Verified, ready-to-move options. DSD Properties.',
            'h1'               => 'Flats Under ₹1 Crore in Lucknow',
            'breadcrumb_label' => 'Flats Under 1 Crore',
            'canonical'        => '/flats-under-1-crore-lucknow',
            'hero_color'       => '#065f46',
            'intro'            => [
                "The ₹50 lakhs to ₹1 crore budget segment is the most active in Lucknow's residential market, covering well-located 2 BHK and 3 BHK flats in established and aspirational localities. This budget comfortably gets you a 2 BHK in Gomti Nagar or a spacious 3 BHK in Aliganj or Indiranagar — localities with excellent schools, hospitals, markets, and metro access.",
                "DSD Properties lists a curated selection of flats under ₹1 crore in Lucknow — focusing on properties that offer good carpet area, solid construction, clear legal titles, and reliable builders. We include both ready-to-move flats and under-construction projects from RERA-registered developers.",
                "This budget also opens up options in newer growth corridors like Sultanpur Road and Shaheed Path, where larger apartments with premium amenities are available at prices that would only buy a 1 BHK in comparable Noida or Gurgaon zones.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'max_price' => 10000000],
            'related_links' => [
                ['url' => '/2-bhk-flats-lucknow',            'text' => '2 BHK Flats in Lucknow'],
                ['url' => '/3-bhk-flats-lucknow',            'text' => '3 BHK Flats in Lucknow'],
                ['url' => '/flats-under-50-lakhs-lucknow',   'text' => 'Flats Under ₹50 Lakhs'],
                ['url' => '/flats-in-lucknow',               'text' => 'All Flats in Lucknow'],
            ],
            'faq' => [
                ['q' => 'Which areas offer the best flats under 1 crore in Lucknow?',
                 'a' => 'Under ₹1 crore, you can buy a 2 BHK in Gomti Nagar (₹70–95 lakhs), a 3 BHK in Aliganj (₹80–95 lakhs), or a 2 BHK with amenities in Sultanpur Road or Shaheed Path (₹65–90 lakhs).'],
            ],
        ],

        'luxury-property-lucknow' => [
            'title'            => 'Luxury Property in Lucknow | Premium Flats & Villas | DSD Properties',
            'meta_description' => 'Explore luxury property in Lucknow. Premium 3 & 4 BHK apartments, villas, and penthouses above ₹1 crore in Gomti Nagar, Shaheed Path. DSD Properties.',
            'h1'               => 'Luxury Property in Lucknow',
            'breadcrumb_label' => 'Luxury Property',
            'canonical'        => '/luxury-property-lucknow',
            'hero_color'       => '#7c2d12',
            'intro'            => [
                "Lucknow's luxury real estate segment is experiencing unprecedented growth, driven by the city's expanding high-income professional class, returning NRIs, and business families seeking world-class residences. Premium properties in Lucknow now rival Noida and Gurgaon in terms of amenities, construction quality, and design — at a fraction of the price.",
                "DSD Properties curates exclusive luxury listings in Lucknow's most prestigious addresses — Gomti Nagar, Gomti Nagar Extension, Sushant Golf City, Shaheed Path, and the new IT City corridor. Our luxury portfolio includes 3 and 4 BHK apartments with 2,000–5,000 sq.ft carpet areas, penthouses with private terraces, and gated villa townships with resort-style amenities.",
                "For discerning buyers, we offer a private concierge advisory service — exclusive property previews, builder negotiations, interior design recommendations, and complete legal management. Your luxury purchase deserves the luxury of expert guidance.",
            ],
            'filters'       => ['transaction' => 'sell', 'min_price' => 10000000],
            'related_links' => [
                ['url' => '/4-bhk-flats-lucknow',        'text' => '4 BHK Flats in Lucknow'],
                ['url' => '/villa-for-sale-lucknow',     'text' => 'Villas for Sale in Lucknow'],
                ['url' => '/3-bhk-flats-lucknow',        'text' => '3 BHK Flats in Lucknow'],
                ['url' => '/buy-property-lucknow',       'text' => 'Buy Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What qualifies as luxury property in Lucknow?',
                 'a' => 'In Lucknow, luxury property generally means residential units priced above ₹1 crore — typically 3 BHK, 4 BHK, or villa formats in premium localities, offering amenities like clubhouse, pool, gym, smart home features, and high-end finishes.'],
            ],
        ],

        'property-in-gomti-nagar' => [
            'title'            => 'Property in Gomti Nagar Lucknow | Flats, Plots & Houses | DSD Properties',
            'meta_description' => 'Buy property in Gomti Nagar, Lucknow. Verified flats, plots, and houses. Lucknow\'s premium residential area. Expert advisory by DSD Properties.',
            'h1'               => 'Property in Gomti Nagar, Lucknow',
            'breadcrumb_label' => 'Gomti Nagar',
            'canonical'        => '/property-in-gomti-nagar',
            'hero_color'       => '#1a3a6b',
            'intro'            => [
                "Gomti Nagar is Lucknow's most prestigious residential address — a planned township on the eastern bank of the Gomti river, featuring wide tree-lined avenues, organised sector layout, and proximity to the Hazratganj CBD, high courts, and Lucknow University. Property in Gomti Nagar commands a premium and has consistently delivered 10–15% annual appreciation over the past decade.",
                "The locality is home to senior government officers, corporate executives, judges, and established business families. DSD Properties lists a range of verified properties in Gomti Nagar — luxury 3 and 4 BHK apartments in high-rise societies, independent floors in plotted colonies, commercial spaces in Vibhuti Khand, and prime plots in the older sectors.",
                "Gomti Nagar's USPs include excellent connectivity (Ring Road, Lucknow Metro's East-West Corridor), top-ranked schools (La Martiniere, Colvin Taluqdars'), and world-class healthcare (Sahara Hospital, Medanta, Max Hospital).",
            ],
            'filters'       => ['locality' => 'Gomti Nagar'],
            'related_links' => [
                ['url' => '/property-in-gomti-nagar-extension', 'text' => 'Gomti Nagar Extension'],
                ['url' => '/flats-in-gomti-nagar',              'text' => 'Flats in Gomti Nagar'],
                ['url' => '/luxury-property-lucknow',           'text' => 'Luxury Property in Lucknow'],
                ['url' => '/buy-property-lucknow',              'text' => 'Buy Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the property price in Gomti Nagar, Lucknow?',
                 'a' => 'Property prices in Gomti Nagar range from ₹5,000–8,500/sq.ft for flats. A 2 BHK (1,000 sq.ft) costs ₹65–90 lakhs, while a 3 BHK (1,500 sq.ft) costs ₹1–1.5 crore. Prime plots range ₹2,000–4,000/sq.yd.'],
                ['q' => 'Is Gomti Nagar a good area to buy property in Lucknow?',
                 'a' => 'Yes, Gomti Nagar is consistently Lucknow\'s top-rated residential area. Its planned layout, premium social infrastructure, Metro connectivity, and established community make it ideal for both end-use and investment.'],
            ],
        ],

        'property-in-gomti-nagar-extension' => [
            'title'            => 'Property in Gomti Nagar Extension Lucknow | New Projects | DSD Properties',
            'meta_description' => 'Buy property in Gomti Nagar Extension, Lucknow. New residential projects, flats, and plots. Fast-growing area with best amenities. DSD Properties.',
            'h1'               => 'Property in Gomti Nagar Extension, Lucknow',
            'breadcrumb_label' => 'Gomti Nagar Extension',
            'canonical'        => '/property-in-gomti-nagar-extension',
            'hero_color'       => '#1a3a6b',
            'intro'            => [
                "Gomti Nagar Extension is Lucknow's most exciting real estate growth story of the 2020s. This LDA-developed township, stretching from the Gomti River to the upcoming Lucknow Metro Phase 2 stations, is transforming from open plots into a premium residential corridor with luxury apartment projects, wide roads, and world-class amenities.",
                "Leading developers including Eldeco, ATS, Antriksh, Gaurs, and Shalimar Corp are active in Gomti Nagar Extension, offering 2, 3, and 4 BHK apartments in gated townships with swimming pools, clubhouses, and landscaped gardens. Property prices range from ₹4,500/sq.ft for new projects to ₹7,000+/sq.ft for premium addresses.",
                "DSD Properties has deep expertise in this market — helping buyers compare new vs. resale options, assess developer credibility, and identify the sub-sectors within Gomti Nagar Extension that offer the best combination of value and future appreciation.",
            ],
            'filters'       => ['locality' => 'Gomti Nagar Extension'],
            'related_links' => [
                ['url' => '/property-in-gomti-nagar', 'text' => 'Gomti Nagar Properties'],
                ['url' => '/new-projects-lucknow',    'text' => 'New Projects in Lucknow'],
                ['url' => '/3-bhk-flats-lucknow',     'text' => '3 BHK Flats in Lucknow'],
                ['url' => '/luxury-property-lucknow', 'text' => 'Luxury Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'Is Gomti Nagar Extension good for investment?',
                 'a' => 'Yes, Gomti Nagar Extension is one of Lucknow\'s best investment bets. With LDA-planned infrastructure, Metro Phase 2 connectivity, and rapid development, property prices here have appreciated 25–35% in the last 3 years and are expected to continue rising.'],
            ],
        ],

        'property-in-aliganj' => [
            'title'            => 'Property in Aliganj Lucknow | Flats & Houses for Sale | DSD Properties',
            'meta_description' => 'Buy property in Aliganj, Lucknow. Verified flats, houses, and plots in this popular residential area. DSD Properties advisory.',
            'h1'               => 'Property in Aliganj, Lucknow',
            'breadcrumb_label' => 'Aliganj',
            'canonical'        => '/property-in-aliganj',
            'hero_color'       => '#4c1d95',
            'intro'            => [
                "Aliganj is one of Lucknow's most established and sought-after residential localities, covering a large area in north Lucknow. Known for its excellent connectivity via Hardoi Road and the Outer Ring Road, proximity to Lucknow University, and a vibrant commercial market, Aliganj strikes the perfect balance between affordability and quality of life.",
                "DSD Properties lists a wide variety of properties in Aliganj — 1, 2, and 3 BHK flats in society apartments, independent floors, duplex houses, and residential plots across different Aliganj sub-sectors. Property prices in Aliganj are generally 15–20% more affordable than comparable Gomti Nagar options, making it attractive for budget-conscious buyers without compromising on location.",
                "The locality benefits from top schools (City Montessori School Aliganj), multiple hospitals, large banks, and easy access to Hazratganj and the proposed Metro stations — making it one of Lucknow's best-value residential addresses.",
            ],
            'filters'       => ['locality' => 'Aliganj'],
            'related_links' => [
                ['url' => '/flats-in-aliganj',           'text' => 'Flats in Aliganj'],
                ['url' => '/property-in-indiranagar',    'text' => 'Property in Indiranagar'],
                ['url' => '/2-bhk-flats-lucknow',        'text' => '2 BHK Flats in Lucknow'],
                ['url' => '/buy-property-lucknow',       'text' => 'Buy Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the property price in Aliganj, Lucknow?',
                 'a' => 'Property prices in Aliganj range from ₹4,000–6,500/sq.ft for flats. A 2 BHK (950 sq.ft) costs ₹45–65 lakhs. Independent houses start around ₹80 lakhs for a modest 3-bedroom home.'],
            ],
        ],

        'property-in-indiranagar' => [
            'title'            => 'Property in Indiranagar Lucknow | Flats & Houses | DSD Properties',
            'meta_description' => 'Buy property in Indiranagar, Lucknow. Verified flats, houses, and plots in this central locality. Expert advisory by DSD Properties.',
            'h1'               => 'Property in Indiranagar, Lucknow',
            'breadcrumb_label' => 'Indiranagar',
            'canonical'        => '/property-in-indiranagar',
            'hero_color'       => '#4c1d95',
            'intro'            => [
                "Indiranagar is a premium residential and commercial locality in central Lucknow, known for its upscale markets, tree-shaded lanes, and cosmopolitan character. Home to senior professionals, academics, and business families, Indiranagar commands consistently high property values and offers one of Lucknow's most walkable, self-contained neighbourhood experiences.",
                "DSD Properties lists properties in Indiranagar covering 2 and 3 BHK flats in residential societies, independent houses in the older plotted sections, and commercial properties along the main Indiranagar market road. The locality's proximity to KGMU, SGPGI, and multiple universities makes it particularly popular with medical professionals and academics.",
                "Property in Indiranagar has strong rental demand due to the locality's established infrastructure, making it equally attractive for investment buyers seeking stable rental income from medical and academic tenants.",
            ],
            'filters'       => ['locality' => 'Indiranagar'],
            'related_links' => [
                ['url' => '/property-in-aliganj',        'text' => 'Property in Aliganj'],
                ['url' => '/property-in-gomti-nagar',    'text' => 'Property in Gomti Nagar'],
                ['url' => '/flats-in-lucknow',           'text' => 'Flats in Lucknow'],
                ['url' => '/buy-property-lucknow',       'text' => 'Buy Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'Is Indiranagar good for buying property in Lucknow?',
                 'a' => 'Yes, Indiranagar is one of Lucknow\'s most premium and stable residential markets. Property prices are high but well-supported by rental demand and long-term appreciation trends.'],
            ],
        ],

        'property-in-alambagh' => [
            'title'            => 'Property in Alambagh Lucknow | Affordable Homes | DSD Properties',
            'meta_description' => 'Buy property in Alambagh, Lucknow. Affordable flats and houses near Lucknow Railway Station and Kanpur Road. DSD Properties advisory.',
            'h1'               => 'Property in Alambagh, Lucknow',
            'breadcrumb_label' => 'Alambagh',
            'canonical'        => '/property-in-alambagh',
            'hero_color'       => '#1e3a5f',
            'intro'            => [
                "Alambagh is Lucknow's most accessible and affordable residential hub, strategically located near the Lucknow Charbagh Railway Station and the Kanpur Road corridor. The locality is a major transit point for daily commuters and offers excellent bus and metro connectivity — making it the top choice for working-class professionals and budget-conscious homebuyers.",
                "DSD Properties lists properties in Alambagh across a wide price range — affordable 1 BHK flats from ₹20 lakhs, compact 2 BHK apartments at ₹35–55 lakhs, and independent houses at ₹60–90 lakhs. The area also has growing commercial activity along the Kanpur Road, creating investment opportunities in small shops and office spaces.",
                "For buyers targeting PMAY (Pradhan Mantri Awas Yojana) subsidy benefits, Alambagh has several qualifying properties with EWS and LIG flat options. Our team provides guidance on government housing scheme eligibility.",
            ],
            'filters'       => ['locality' => 'Alambagh'],
            'related_links' => [
                ['url' => '/flats-under-50-lakhs-lucknow', 'text' => 'Flats Under ₹50 Lakhs'],
                ['url' => '/affordable-flats-lucknow',     'text' => 'Affordable Flats in Lucknow'],
                ['url' => '/1-bhk-flats-lucknow',          'text' => '1 BHK Flats in Lucknow'],
                ['url' => '/buy-property-lucknow',         'text' => 'Buy Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the property price in Alambagh, Lucknow?',
                 'a' => 'Alambagh is one of Lucknow\'s most affordable areas. Flats are priced ₹2,800–4,200/sq.ft. A 1 BHK costs ₹18–28 lakhs and a 2 BHK costs ₹32–55 lakhs. Independent houses start around ₹55–70 lakhs.'],
            ],
        ],

        'property-in-hazratganj' => [
            'title'            => 'Property in Hazratganj Lucknow | Prime Location | DSD Properties',
            'meta_description' => 'Buy property in Hazratganj, Lucknow. Prime residential and commercial property in Lucknow\'s heart. Expert advisory by DSD Properties.',
            'h1'               => 'Property in Hazratganj, Lucknow',
            'breadcrumb_label' => 'Hazratganj',
            'canonical'        => '/property-in-hazratganj',
            'hero_color'       => '#1a3a6b',
            'intro'            => [
                "Hazratganj is Lucknow's most iconic neighbourhood — the city's cultural, commercial, and administrative centre since the Nawabi era. Properties in Hazratganj are extremely rare, highly coveted, and command some of the highest per-square-foot prices in all of Lucknow. Owning property here is as much a prestige statement as it is a financial investment.",
                "The area houses Lucknow's premier commercial establishments, the Vidhan Sabha, High Court, and Central Market. Residential properties in Hazratganj include heritage kothi conversions, modern apartments in small societies, and premium commercial spaces on the famous Hazratganj promenade.",
                "DSD Properties has expert knowledge of the Hazratganj micro-market, including Central Lucknow, Lalbagh, and Kaiserbagh — helping both buyers and sellers of ultra-premium properties navigate this specialised segment.",
            ],
            'filters'       => ['locality' => 'Hazratganj'],
            'related_links' => [
                ['url' => '/property-in-gomti-nagar',    'text' => 'Property in Gomti Nagar'],
                ['url' => '/luxury-property-lucknow',    'text' => 'Luxury Property in Lucknow'],
                ['url' => '/commercial-property-lucknow','text' => 'Commercial Property'],
                ['url' => '/buy-property-lucknow',       'text' => 'Buy Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the property price in Hazratganj, Lucknow?',
                 'a' => 'Hazratganj commands Lucknow\'s highest property prices. Commercial property rates are ₹15,000–30,000/sq.ft. Residential properties (very limited supply) start at ₹1.5 crore for a modest apartment.'],
            ],
        ],

        'property-in-vikas-nagar' => [
            'title'            => 'Property in Vikas Nagar Lucknow | Affordable Homes | DSD Properties',
            'meta_description' => 'Buy property in Vikas Nagar, Lucknow. Affordable flats and plots in this well-connected locality. DSD Properties advisory.',
            'h1'               => 'Property in Vikas Nagar, Lucknow',
            'breadcrumb_label' => 'Vikas Nagar',
            'canonical'        => '/property-in-vikas-nagar',
            'hero_color'       => '#1e3a5f',
            'intro'            => [
                "Vikas Nagar is a well-established residential locality in west Lucknow, offering affordable housing options with good civic amenities. Located near the Outer Ring Road and with easy access to the city centre, Vikas Nagar is popular among government employees, teachers, and middle-income families seeking value-for-money homes.",
                "DSD Properties lists 2 and 3 BHK flats, independent houses, and residential plots in Vikas Nagar at competitive prices. The locality has mature markets, schools, and healthcare facilities, making it a practical choice for end-use buyers who prioritise daily convenience.",
                "With the Ring Road expansion and improving public transport, Vikas Nagar is also attracting investor interest — particularly for small plots and affordable flats with strong rental demand from working professionals.",
            ],
            'filters'       => ['locality' => 'Vikas Nagar'],
            'related_links' => [
                ['url' => '/property-in-alambagh',       'text' => 'Property in Alambagh'],
                ['url' => '/affordable-flats-lucknow',   'text' => 'Affordable Flats in Lucknow'],
                ['url' => '/buy-property-lucknow',       'text' => 'Buy Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'Is Vikas Nagar a good place to buy property in Lucknow?',
                 'a' => 'Yes, Vikas Nagar offers good value for money with established infrastructure, reasonable prices (₹3,000–5,000/sq.ft for flats), and improving connectivity. It\'s ideal for budget buyers and investors.'],
            ],
        ],

        'flats-in-gomti-nagar' => [
            'title'            => 'Flats in Gomti Nagar Lucknow | Apartments for Sale | DSD Properties',
            'meta_description' => 'Buy flats in Gomti Nagar, Lucknow. Verified 2, 3 & 4 BHK apartments in Lucknow\'s most premium locality. DSD Properties advisory.',
            'h1'               => 'Flats in Gomti Nagar, Lucknow',
            'breadcrumb_label' => 'Flats in Gomti Nagar',
            'canonical'        => '/flats-in-gomti-nagar',
            'hero_color'       => '#1a3a6b',
            'intro'            => [
                "Gomti Nagar is where Lucknow's most desirable apartments are concentrated — high-rise societies with panoramic views of the Gomti River, premium builder projects from Eldeco, Antriksh, and Omaxe, and a vibrant social scene in the Vibhuti Khand business district. Buying a flat in Gomti Nagar means investing in the address that defines Lucknow's aspirational residential standard.",
                "DSD Properties specialises in Gomti Nagar flat sales — from resale 2 BHK apartments in older societies to new 3 and 4 BHK launches in upcoming towers. We cover Gomti Nagar Sectors A through K, Vibhuti Khand, and the Hazratganj border areas that carry Gomti Nagar prices.",
                "Our deep local knowledge of Gomti Nagar's street-level micro-markets — which buildings have better construction, which societies have well-managed maintenance, which units face east for morning light — helps buyers make truly informed choices.",
            ],
            'filters'       => ['type' => 'flat', 'locality' => 'Gomti Nagar'],
            'related_links' => [
                ['url' => '/property-in-gomti-nagar',            'text' => 'All Property in Gomti Nagar'],
                ['url' => '/property-in-gomti-nagar-extension',  'text' => 'Gomti Nagar Extension'],
                ['url' => '/3-bhk-flats-lucknow',                'text' => '3 BHK Flats in Lucknow'],
                ['url' => '/luxury-property-lucknow',            'text' => 'Luxury Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the price of flats in Gomti Nagar, Lucknow?',
                 'a' => 'Flats in Gomti Nagar cost ₹5,500–9,000/sq.ft depending on the building age and amenities. A 2 BHK (1,000 sq.ft) costs ₹65–85 lakhs and a 3 BHK (1,500 sq.ft) costs ₹95 lakhs to ₹1.5 crore.'],
            ],
        ],

        'flats-in-aliganj' => [
            'title'            => 'Flats in Aliganj Lucknow | Apartments for Sale | DSD Properties',
            'meta_description' => 'Buy flats in Aliganj, Lucknow. Verified 1, 2 & 3 BHK apartments in this popular north Lucknow locality. DSD Properties.',
            'h1'               => 'Flats in Aliganj, Lucknow',
            'breadcrumb_label' => 'Flats in Aliganj',
            'canonical'        => '/flats-in-aliganj',
            'hero_color'       => '#4c1d95',
            'intro'            => [
                "Aliganj offers one of the best value propositions for flat buyers in Lucknow — a central location with strong social infrastructure, at prices that are noticeably lower than Gomti Nagar or Indiranagar. Flats in Aliganj cater to a wide audience: budget-conscious first-time buyers, families wanting proximity to CMS schools, and investors seeking steady rental demand from the student and professional population.",
                "DSD Properties lists flats across Aliganj's various sub-localities — Aliganj proper, Sector A through J, and the boundaries with Indiranagar and Mahanagar. We cover affordable 1 BHK flats, practical 2 BHK apartments in multi-storey buildings, and spacious 3 BHK units in gated societies.",
                "With upcoming Metro Phase 2 stations planned in north Lucknow, Aliganj's connectivity advantage is set to strengthen further — making current flat prices in the area an attractive entry point for long-term investors.",
            ],
            'filters'       => ['type' => 'flat', 'locality' => 'Aliganj'],
            'related_links' => [
                ['url' => '/property-in-aliganj',    'text' => 'All Property in Aliganj'],
                ['url' => '/2-bhk-flats-lucknow',    'text' => '2 BHK Flats in Lucknow'],
                ['url' => '/flats-in-gomti-nagar',   'text' => 'Flats in Gomti Nagar'],
                ['url' => '/flats-in-lucknow',       'text' => 'All Flats in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the price of flats in Aliganj, Lucknow?',
                 'a' => 'Flats in Aliganj are priced at ₹3,800–6,200/sq.ft. A 2 BHK (900 sq.ft) costs ₹40–58 lakhs, and a 3 BHK (1,300 sq.ft) costs ₹60–85 lakhs.'],
            ],
        ],

        'plots-in-lucknow' => [
            'title'            => 'Plots in Lucknow | Buy Land for Sale | DSD Properties',
            'meta_description' => 'Buy plots in Lucknow. Residential and commercial land for sale. LDA-approved, clear-title plots. DSD Properties expert advisory.',
            'h1'               => 'Plots in Lucknow',
            'breadcrumb_label' => 'Plots in Lucknow',
            'canonical'        => '/plots-in-lucknow',
            'hero_color'       => '#064e3b',
            'intro'            => [
                "Land in Lucknow is arguably the most versatile investment you can make — giving you the option to build a custom home, hold for appreciation, sell when prices peak, or develop for commercial use. Lucknow's expanding city limits, LDA master plan expansions, and infrastructure investments are creating new plot appreciation corridors every year.",
                "DSD Properties lists plots for sale across Lucknow's entire geography — from established residential colonies in Aliganj, Vikas Nagar, and Mahanagar to developing corridors on Sultanpur Road, Faizabad Road, and Raebareli Road. We cover LDA-approved layouts, RERA-registered plotted townships, freehold private plots, and agricultural-to-residential conversion plots.",
                "Our plot advisory team specialises in verifying land ownership records (Khatauni), checking for government acquisition plans, and ensuring the plot's legal status is clear before you commit — because unlike flats, plot disputes can be complex and long-drawn.",
            ],
            'filters'       => ['type' => 'plot'],
            'related_links' => [
                ['url' => '/plots-for-sale-lucknow',     'text' => 'Plots for Sale in Lucknow'],
                ['url' => '/residential-plots-lucknow',  'text' => 'Residential Plots in Lucknow'],
                ['url' => '/lda-approved-plots-lucknow', 'text' => 'LDA Approved Plots'],
                ['url' => '/buy-property-lucknow',       'text' => 'Buy Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What are plot prices in Lucknow?',
                 'a' => 'Plot prices in Lucknow range from ₹8,000–15,000/sq.yd in developing areas to ₹40,000–80,000/sq.yd in prime localities like Gomti Nagar. A 200 sq.yd plot on Sultanpur Road costs approximately ₹60–90 lakhs.'],
            ],
        ],

        'residential-plots-lucknow' => [
            'title'            => 'Residential Plots in Lucknow | Build Your Dream Home | DSD Properties',
            'meta_description' => 'Buy residential plots in Lucknow. Build your own home on a verified, clear-title plot. All localities covered by DSD Properties.',
            'h1'               => 'Residential Plots in Lucknow',
            'breadcrumb_label' => 'Residential Plots',
            'canonical'        => '/residential-plots-lucknow',
            'hero_color'       => '#064e3b',
            'intro'            => [
                "Building your own home on a residential plot in Lucknow is the ultimate expression of personalised living. You design the layout, choose the materials, and create a space that perfectly fits your family's lifestyle — with no society rules, shared walls, or maintenance charges. Residential plots in Lucknow are available across all budget ranges and localities.",
                "DSD Properties lists residential plots in Lucknow's most desirable and growing areas — LDA-approved colonies, RERA-registered township projects, and individual freehold plots in established residential zones. Plot sizes range from 100 sq.yd compact plots for single-storey homes to 500+ sq.yd premium plots for multi-floor residences.",
                "Our team helps you navigate the complete process: plot selection, legal verification (registry, Khatauni, NOC), builder/contractor references, construction plan approval from LDA/nagar nigam, and bank loan on plot + construction. We are your partner from plot purchase to house completion.",
            ],
            'filters'       => ['type' => 'plot', 'transaction' => 'sell'],
            'related_links' => [
                ['url' => '/plots-in-lucknow',           'text' => 'All Plots in Lucknow'],
                ['url' => '/lda-approved-plots-lucknow', 'text' => 'LDA Approved Plots'],
                ['url' => '/plots-for-sale-lucknow',     'text' => 'Plots for Sale'],
                ['url' => '/house-for-sale-lucknow',     'text' => 'Houses for Sale in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the process to buy a residential plot in Lucknow?',
                 'a' => 'To buy a residential plot in Lucknow: (1) verify land records at the tehsil, (2) check for LDA/development authority sanction, (3) get legal opinion on title, (4) execute sale agreement and pay stamp duty, (5) complete registry at sub-registrar office. DSD Properties guides you through each step.'],
            ],
        ],

        'lda-approved-plots-lucknow' => [
            'title'            => 'LDA Approved Plots in Lucknow | Safe Land Investment | DSD Properties',
            'meta_description' => 'Buy LDA approved plots in Lucknow. Verified LDA scheme plots and resale LDA land. Safest land investment in Lucknow. DSD Properties.',
            'h1'               => 'LDA Approved Plots in Lucknow',
            'breadcrumb_label' => 'LDA Approved Plots',
            'canonical'        => '/lda-approved-plots-lucknow',
            'hero_color'       => '#064e3b',
            'intro'            => [
                "LDA (Lucknow Development Authority) approved plots are the gold standard of land investment in Lucknow. An LDA-approved plot guarantees legal land use, clear title, planned infrastructure (roads, drainage, parks), and ease of future construction approval — eliminating the most common risks of land purchase. These plots are available through direct LDA lottery schemes and on the resale market.",
                "DSD Properties maintains a curated database of resale LDA-approved plots across Lucknow's major LDA schemes — LDA Residential Colony, Janeshwar Misra Park area, Sector J Aliganj, Vrindavan Yojana, Kalyanpur, and upcoming schemes in Gomti Nagar Extension and Shaheed Path areas.",
                "Our team verifies the authenticity of LDA allotment letters, checks for transfer/mutation completion, and ensures there are no pending dues to LDA before you commit. We have a dedicated LDA expert on our team who has handled 200+ plot transactions since 2018.",
            ],
            'filters'       => ['type' => 'plot', 'locality' => 'LDA'],
            'related_links' => [
                ['url' => '/plots-in-lucknow',           'text' => 'All Plots in Lucknow'],
                ['url' => '/residential-plots-lucknow',  'text' => 'Residential Plots'],
                ['url' => '/plots-for-sale-lucknow',     'text' => 'Plots for Sale in Lucknow'],
                ['url' => '/lda-schemes',                'text' => 'LDA Schemes 2025'],
            ],
            'faq' => [
                ['q' => 'How do I buy an LDA plot in Lucknow?',
                 'a' => 'LDA plots can be purchased either through LDA\'s periodic lottery schemes (register at LDA office or lda.up.nic.in) or through the resale market. Resale LDA plots require verification of the original allotment letter, transfer deed, and clearance of any dues to LDA.'],
                ['q' => 'Are LDA plots safe to buy in Lucknow?',
                 'a' => 'Yes, LDA-approved plots are among the safest land investments in Lucknow. LDA provides legal sanction, planned infrastructure, and a clear dispute-resolution mechanism. Ensure you verify the allotment authenticity and check for any dues.'],
            ],
        ],

        'affordable-flats-lucknow' => [
            'title'            => 'Affordable Flats in Lucknow | Budget Apartments | DSD Properties',
            'meta_description' => 'Find affordable flats in Lucknow under ₹40 lakhs. Budget 1 & 2 BHK apartments for first-time buyers. PMAY eligible. DSD Properties.',
            'h1'               => 'Affordable Flats in Lucknow',
            'breadcrumb_label' => 'Affordable Flats',
            'canonical'        => '/affordable-flats-lucknow',
            'hero_color'       => '#065f46',
            'intro'            => [
                "Homeownership in Lucknow is more accessible than ever, with a range of affordable flats available for budget-conscious buyers. The city's peripheral localities and developing zones offer quality 1 BHK and 2 BHK flats under ₹40 lakhs — and with government subsidies under PMAY (Pradhan Mantri Awas Yojana), first-time buyers from EWS/LIG/MIG categories can get an additional ₹2.67 lakh subsidy on home loans.",
                "DSD Properties has a dedicated affordable housing advisory service, listing budget flats across Lucknow's value zones — Alambagh, Rajajipuram, Aashiyana, Chinhat, Sitapur Road, and Hardoi Road localities. We also track LDA's affordable housing lottery schemes (EWS flats at ₹8–15 lakhs) and help eligible buyers apply.",
                "Our team ensures every affordable flat listing meets quality and legal standards — because a low-price property should never mean cutting corners on construction quality or title clarity.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'max_price' => 4000000],
            'related_links' => [
                ['url' => '/flats-under-50-lakhs-lucknow', 'text' => 'Flats Under ₹50 Lakhs'],
                ['url' => '/1-bhk-flats-lucknow',          'text' => '1 BHK Flats in Lucknow'],
                ['url' => '/new-projects-lucknow',         'text' => 'New Projects in Lucknow'],
                ['url' => '/buy-property-lucknow',         'text' => 'Buy Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the cheapest flat available in Lucknow?',
                 'a' => 'The most affordable flats in Lucknow start at ₹15–20 lakhs for a compact 1 BHK (350–450 sq.ft) in peripheral areas like Aashiyana, Chinhat, or parts of Alambagh. LDA EWS flats under lottery schemes can be even cheaper.'],
            ],
        ],

        'new-projects-lucknow' => [
            'title'            => 'New Projects in Lucknow 2025 | Under Construction Flats | DSD Properties',
            'meta_description' => 'Explore new residential projects in Lucknow 2025. Under-construction and upcoming apartments from top builders. RERA registered. DSD Properties.',
            'h1'               => 'New Residential Projects in Lucknow 2025',
            'breadcrumb_label' => 'New Projects',
            'canonical'        => '/new-projects-lucknow',
            'hero_color'       => '#1e3a5f',
            'intro'            => [
                "Lucknow's real estate landscape is being reshaped by a wave of new residential projects launching across the city's growth corridors in 2025. From affordable group housing in developing areas to luxury township projects on Shaheed Path and Gomti Nagar Extension, new launches are offering buyers modern amenities, RERA compliance, and the financial advantage of booking at pre-launch prices.",
                "DSD Properties tracks all new project launches in Lucknow — covering RERA-registered projects from established builders like Eldeco, Omaxe, ATS, Antriksh, Shalimar, and newer developers making their mark. We provide buyers with detailed project comparisons including carpet area ratios, construction timelines, builder track records, and realistic possession date assessments.",
                "New construction properties allow buyers to customise finishes, choose preferred floors and units, and benefit from structured payment plans linked to construction milestones — spreading investment over 2–3 years. Our advisors help you navigate the fine print of builder-buyer agreements and protect your rights under RERA.",
            ],
            'filters'       => ['age' => 'new_construction'],
            'related_links' => [
                ['url' => '/flats-in-lucknow',                   'text' => 'All Flats in Lucknow'],
                ['url' => '/property-in-gomti-nagar-extension',  'text' => 'Gomti Nagar Extension'],
                ['url' => '/3-bhk-flats-lucknow',                'text' => '3 BHK Flats in Lucknow'],
                ['url' => '/rera-approved-projects-lucknow',     'text' => 'RERA Projects Lucknow'],
            ],
            'faq' => [
                ['q' => 'Are new construction projects in Lucknow RERA registered?',
                 'a' => 'All new construction projects with more than 8 units or 500 sq.m plot area must be registered with UP RERA before marketing to buyers. DSD Properties only lists RERA-registered new projects and helps buyers verify registration numbers.'],
                ['q' => 'What are the advantages of buying an under-construction flat in Lucknow?',
                 'a' => 'Under-construction flats offer lower launch prices (10–20% below market), customisation options, construction-linked payment plans, and the opportunity for capital appreciation during the construction period.'],
            ],
        ],

        'builder-floor-lucknow' => [
            'title'            => 'Builder Floor in Lucknow | Independent Floor Apartments | DSD Properties',
            'meta_description' => 'Buy builder floor in Lucknow. Independent floor apartments with individual ownership in Gomti Nagar, Aliganj, Indiranagar. DSD Properties.',
            'h1'               => 'Builder Floor Apartments in Lucknow',
            'breadcrumb_label' => 'Builder Floors',
            'canonical'        => '/builder-floor-lucknow',
            'hero_color'       => '#1e3a5f',
            'intro'            => [
                "A builder floor in Lucknow offers a compelling middle ground between the independence of a house and the convenience of a flat. You get an entire floor of a 3–4 storey building as your exclusive unit — private entry, individual electricity and water meters, and a proportionate share of the plot — at prices typically 15–25% below comparable society apartments.",
                "Builder floors in Lucknow are particularly popular in established localities like Gomti Nagar, Aliganj, Indiranagar, and Mahanagar, where land is scarce and independent house prices are prohibitively high. A ground floor unit often comes with a private garden, while upper floors enjoy better ventilation and views.",
                "DSD Properties lists verified builder floor apartments across Lucknow, with each listing including clear documentation of the individual floor's ownership, approved building plan, and occupancy certificate status.",
            ],
            'filters'       => ['type' => 'builder_floor'],
            'related_links' => [
                ['url' => '/flats-in-lucknow',           'text' => 'Flats in Lucknow'],
                ['url' => '/house-for-sale-lucknow',     'text' => 'Houses for Sale in Lucknow'],
                ['url' => '/2-bhk-flats-lucknow',        'text' => '2 BHK Flats in Lucknow'],
                ['url' => '/buy-property-lucknow',       'text' => 'Buy Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is a builder floor apartment in Lucknow?',
                 'a' => 'A builder floor is an individual floor of a 3–4 storey independent building where each floor is sold as a separate unit. Unlike society apartments, builder floors offer private entry, individual utility meters, and a proportionate share in the plot — giving more independence at lower prices than full independent houses.'],
            ],
        ],

        'investment-property-lucknow' => [
            'title'            => 'Investment Property in Lucknow | Best ROI Real Estate | DSD Properties',
            'meta_description' => 'Find the best investment property in Lucknow. High-appreciation areas, rental-yield properties. Expert investment advisory by DSD Properties.',
            'h1'               => 'Investment Property in Lucknow',
            'breadcrumb_label' => 'Investment Property',
            'canonical'        => '/investment-property-lucknow',
            'hero_color'       => '#7c2d12',
            'intro'            => [
                "Lucknow is increasingly on the radar of savvy property investors from across north India. The city offers an attractive combination of relatively affordable entry prices, steady 12–18% annual appreciation in key corridors, 4–6% rental yields in high-demand localities, and the macro tailwinds of Uttar Pradesh's accelerating economic development.",
                "The best investment bets in Lucknow real estate in 2025 include: (1) Plots and flats on Shaheed Path and Sultanpur Road — fastest appreciation due to commercial and infrastructure development; (2) 2 BHK flats in Gomti Nagar and Aliganj — strong rental demand from professionals; (3) Commercial property in Vibhuti Khand and IT City — premium tenants, 6–8% yields.",
                "DSD Properties provides data-driven investment advisory — analysing price trends, rental demand surveys, upcoming infrastructure projects, and risk factors for each micro-market. We help investors build a Lucknow property portfolio aligned with their return targets.",
            ],
            'filters'       => ['transaction' => 'sell'],
            'related_links' => [
                ['url' => '/plots-for-sale-lucknow',         'text' => 'Plots for Sale'],
                ['url' => '/commercial-property-lucknow',    'text' => 'Commercial Property'],
                ['url' => '/luxury-property-lucknow',        'text' => 'Luxury Property'],
                ['url' => '/new-projects-lucknow',           'text' => 'New Projects 2025'],
                ['url' => '/buy-property-lucknow',           'text' => 'Buy Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'Which areas give the best return on property investment in Lucknow?',
                 'a' => 'The highest-appreciation areas in Lucknow are Gomti Nagar Extension (25–35% over 3 years), Shaheed Path corridor (20–30%), and Sultanpur Road (18–25%). For rental yield, Gomti Nagar and Aliganj offer 4–5% annual returns.'],
                ['q' => 'Is commercial or residential property a better investment in Lucknow?',
                 'a' => 'Commercial property in prime Lucknow locations offers higher rental yields (6–9%) but requires more capital and has longer vacancy cycles. Residential property offers lower yields (3–5%) but is more liquid, easier to finance, and has a broader buyer base when reselling.'],
            ],
        ],

        // ─── Tag-based locality pages ─────────────────────────────────────

        'property-in-sultanpur-road' => [
            'title'            => 'Property in Sultanpur Road Lucknow | Plots & Flats | DSD Properties',
            'meta_description' => 'Buy property on Sultanpur Road, Lucknow. Plots, flats, and villas in this fast-growing corridor. Best investment in Lucknow 2025. DSD Properties.',
            'h1'               => 'Property on Sultanpur Road, Lucknow',
            'breadcrumb_label' => 'Sultanpur Road',
            'canonical'        => '/property-in-sultanpur-road',
            'hero_color'       => '#064e3b',
            'intro'            => [
                "Sultanpur Road is Lucknow's fastest-appreciating real estate corridor in 2025. Stretching south-east from the city, this expressway connects Lucknow to the Purvanchal Expressway and passes through the newly developing IT City zone — making it a magnet for both residential and commercial investment. Property prices on Sultanpur Road have appreciated 20–30% in the last three years alone.",
                "The corridor is seeing rapid development of plotted townships, affordable apartment projects, and commercial hubs. Key attractions include proximity to Lucknow International Airport (under 20 minutes), the upcoming IT City employment hub, and large green buffer zones that ensure low congestion and planned development.",
                "DSD Properties has extensive listings on Sultanpur Road — from 100 sq.yd residential plots at ₹25–40 lakhs to 2 and 3 BHK apartments in new township projects. Our advisors have first-hand knowledge of every project and plot colony on this corridor.",
            ],
            'filters'       => ['tag' => 'sultanpur-road'],
            'related_links' => [
                ['url' => '/plots-for-sale-lucknow',     'text' => 'Plots for Sale in Lucknow'],
                ['url' => '/property-in-it-city-lucknow','text' => 'IT City Properties'],
                ['url' => '/investment-property-lucknow','text' => 'Investment Property'],
                ['url' => '/buy-property-lucknow',       'text' => 'Buy Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'Is Sultanpur Road good for property investment in Lucknow?',
                 'a' => 'Yes, Sultanpur Road is one of Lucknow\'s top investment corridors for 2025. With IT City development, airport proximity, and expressway connectivity, plots and flats here are expected to appreciate 20–30% over the next 3 years.'],
                ['q' => 'What is the property price on Sultanpur Road, Lucknow?',
                 'a' => 'Plots on Sultanpur Road are priced at ₹12,000–22,000/sq.yd. Residential flats range from ₹3,500–5,500/sq.ft. A 2 BHK (1,000 sq.ft) costs approximately ₹40–60 lakhs in new projects.'],
            ],
        ],

        'property-in-it-city-lucknow' => [
            'title'            => 'Property in IT City Lucknow | Flats & Plots Near Tech Hub | DSD Properties',
            'meta_description' => 'Buy property in IT City, Lucknow. Residential flats and plots near Lucknow\'s IT hub on Sultanpur Road. High appreciation zone. DSD Properties.',
            'h1'               => 'Property in IT City, Lucknow',
            'breadcrumb_label' => 'IT City',
            'canonical'        => '/property-in-it-city-lucknow',
            'hero_color'       => '#1e3a5f',
            'intro'            => [
                "IT City is Lucknow's most ambitious infrastructure project — a dedicated technology and business park spanning hundreds of acres on the Sultanpur Road corridor. Designed to attract IT companies, startups, and knowledge industries, IT City is expected to create 50,000+ jobs and transform the surrounding area into a premium residential and commercial destination.",
                "Properties near IT City are attracting early investors who understand the Gurgaon-Noida story: buying near a major employment hub before it fully develops yields exceptional returns. Plots and flats within 5 km of IT City have already appreciated 25–40% since 2022 and the upward trend is expected to continue as the park fills with tenants.",
                "DSD Properties tracks every listing near IT City — from small residential plots to large commercial land parcels, and from affordable 1 BHK apartments to premium 3 BHK flats in gated societies targeting IT professionals.",
            ],
            'filters'       => ['tag' => 'it-city'],
            'related_links' => [
                ['url' => '/property-in-sultanpur-road', 'text' => 'Sultanpur Road Properties'],
                ['url' => '/investment-property-lucknow','text' => 'Investment Property'],
                ['url' => '/plots-for-sale-lucknow',     'text' => 'Plots for Sale'],
                ['url' => '/new-projects-lucknow',       'text' => 'New Projects 2025'],
            ],
            'faq' => [
                ['q' => 'Where is IT City located in Lucknow?',
                 'a' => 'IT City is located on Sultanpur Road in south-east Lucknow, approximately 15–20 km from the city centre and close to Lucknow International Airport. It is being developed as a dedicated IT and business park by the UP government.'],
                ['q' => 'Is it good to buy property near IT City Lucknow?',
                 'a' => 'Yes, properties near IT City are excellent long-term investments. As IT companies move in and employment grows, rental demand and property values in the surrounding area are expected to rise significantly — similar to how Gurgaon and Noida grew around their tech corridors.'],
            ],
        ],

        'property-in-rajajipuram' => [
            'title'            => 'Property in Rajajipuram Lucknow | Affordable Homes | DSD Properties',
            'meta_description' => 'Buy property in Rajajipuram, Lucknow. Affordable flats and plots in this well-connected west Lucknow locality. DSD Properties advisory.',
            'h1'               => 'Property in Rajajipuram, Lucknow',
            'breadcrumb_label' => 'Rajajipuram',
            'canonical'        => '/property-in-rajajipuram',
            'hero_color'       => '#1e3a5f',
            'intro'            => [
                "Rajajipuram is a large, well-established residential colony in west Lucknow — one of the oldest planned colonies developed by LDA, housing a substantial population of government employees, teachers, and middle-income families. The locality is self-sufficient with its own markets, schools, hospitals, and parks, making it a practical and affordable choice for homebuyers.",
                "DSD Properties lists a range of properties in Rajajipuram — affordable 1 and 2 BHK flats in multi-storey buildings, independent houses in the older plot sections, and residential plots in newer extension areas. Prices are significantly lower than comparable areas like Aliganj or Indiranagar, making Rajajipuram one of Lucknow's best-value residential zones.",
                "The locality's proximity to major roads (Kanpur Road, Ring Road), railways (Lucknow Junction is 8 km), and the proposed western Metro corridor makes it increasingly attractive for both end-use buyers and investors seeking rental income from the area's large tenant population.",
            ],
            'filters'       => ['tag' => 'rajajipuram'],
            'related_links' => [
                ['url' => '/property-in-alambagh',           'text' => 'Property in Alambagh'],
                ['url' => '/affordable-flats-lucknow',       'text' => 'Affordable Flats in Lucknow'],
                ['url' => '/flats-under-50-lakhs-lucknow',   'text' => 'Flats Under ₹50 Lakhs'],
                ['url' => '/buy-property-lucknow',           'text' => 'Buy Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the property price in Rajajipuram, Lucknow?',
                 'a' => 'Rajajipuram is one of Lucknow\'s most affordable established localities. Flats are priced at ₹3,000–4,500/sq.ft. A 2 BHK costs ₹30–50 lakhs. Independent houses range from ₹55–90 lakhs depending on plot size.'],
            ],
        ],

        'property-in-jankipuram' => [
            'title'            => 'Property in Jankipuram Lucknow | Flats & Plots | DSD Properties',
            'meta_description' => 'Buy property in Jankipuram, Lucknow. Verified flats, plots, and houses in this growing north Lucknow area. DSD Properties expert advisory.',
            'h1'               => 'Property in Jankipuram, Lucknow',
            'breadcrumb_label' => 'Jankipuram',
            'canonical'        => '/property-in-jankipuram',
            'hero_color'       => '#1a3a6b',
            'intro'            => [
                "Jankipuram is a rapidly growing residential area in north Lucknow, known for its affordable property prices, planned colony layout, and improving connectivity via Sitapur Road and the Outer Ring Road. The area is particularly popular among government employees, educators, and young families seeking spacious homes at budget-friendly prices.",
                "DSD Properties lists verified properties in Jankipuram — 2 BHK flats in multi-storey societies, builder floors in plotted colonies, independent houses with private courtyards, and residential plots for self-construction. Jankipuram's plot sizes tend to be more generous than central Lucknow areas, offering good value for families wanting ground-floor living.",
                "With the Lucknow Metro's upcoming north corridor expansion and the Outer Ring Road improving access to other parts of the city, Jankipuram is emerging as a smart mid-term investment area where current prices still offer room for appreciation.",
            ],
            'filters'       => ['tag' => 'jankipuram'],
            'related_links' => [
                ['url' => '/property-in-aliganj',        'text' => 'Property in Aliganj'],
                ['url' => '/affordable-flats-lucknow',   'text' => 'Affordable Flats'],
                ['url' => '/plots-in-lucknow',           'text' => 'Plots in Lucknow'],
                ['url' => '/buy-property-lucknow',       'text' => 'Buy Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the property price in Jankipuram, Lucknow?',
                 'a' => 'Jankipuram offers affordable property prices: flats at ₹3,200–5,000/sq.ft, independent houses at ₹60–1.2 crore, and residential plots at ₹10,000–18,000/sq.yd. A 2 BHK flat costs approximately ₹35–55 lakhs.'],
            ],
        ],

        'property-on-kanpur-road' => [
            'title'            => 'Property on Kanpur Road Lucknow | Plots & Commercial | DSD Properties',
            'meta_description' => 'Buy property on Kanpur Road, Lucknow. Residential plots, commercial spaces, and flats along this major highway. DSD Properties advisory.',
            'h1'               => 'Property on Kanpur Road, Lucknow',
            'breadcrumb_label' => 'Kanpur Road',
            'canonical'        => '/property-on-kanpur-road',
            'hero_color'       => '#374151',
            'intro'            => [
                "Kanpur Road (NH 27) is one of Lucknow's most important commercial arteries, connecting the city to Kanpur and the western UP heartland. The road passes through Alambagh, Kalyanpur, and Banthra — a mix of established residential colonies, large industrial estates, and growing commercial hubs. Property along Kanpur Road suits buyers seeking commercial plots, warehousing space, showrooms, and affordable residential options.",
                "DSD Properties lists commercial and residential properties along the Kanpur Road corridor — shops and showrooms in Alambagh and Kalyanpur markets, warehousing plots in the Banthra industrial zone, residential flats in societies set back from the main road, and investment plots in developing sub-sectors.",
                "With the four-lane expansion of the Kanpur Road and the Lucknow-Agra Expressway interchange nearby, commercial property along this corridor offers strong rental yields from logistics, retail, and manufacturing tenants.",
            ],
            'filters'       => ['tag' => 'kanpur-road'],
            'related_links' => [
                ['url' => '/property-in-alambagh',       'text' => 'Property in Alambagh'],
                ['url' => '/commercial-property-lucknow','text' => 'Commercial Property'],
                ['url' => '/plots-for-sale-lucknow',     'text' => 'Plots for Sale'],
                ['url' => '/buy-property-lucknow',       'text' => 'Buy Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'Is Kanpur Road good for property investment in Lucknow?',
                 'a' => 'Kanpur Road is strong for commercial property investment — shops, showrooms, and industrial plots offer 6–9% rental yields. For residential investment, properties in the quieter sub-sectors 500–1,000m back from the main road are better for end-use and long-term appreciation.'],
            ],
        ],

        'property-in-mohanlalganj' => [
            'title'            => 'Property in Mohanlalganj Lucknow | Affordable Plots | DSD Properties',
            'meta_description' => 'Buy property in Mohanlalganj, Lucknow. Affordable plots and homes on the outskirts of Lucknow. Good investment for future appreciation. DSD Properties.',
            'h1'               => 'Property in Mohanlalganj, Lucknow',
            'breadcrumb_label' => 'Mohanlalganj',
            'canonical'        => '/property-in-mohanlalganj',
            'hero_color'       => '#065f46',
            'intro'            => [
                "Mohanlalganj is a fast-developing township on the southern fringe of Lucknow, located along the Raebareli Road corridor. As Lucknow's urban boundary expands southward, Mohanlalganj is transitioning from a semi-rural tehsil to a planned residential and commercial zone — offering today's buyers the opportunity to enter at low prices before the area fully urbanises.",
                "DSD Properties lists residential plots, independent houses, and agricultural-to-residential conversion land in Mohanlalganj. The area attracts buyers who want larger plot sizes at lower prices — getting 300–500 sq.yd plots for the price of a 100–150 sq.yd plot in central Lucknow localities.",
                "With the Raebareli Road widening and the proposed Lucknow Ring Road alignment passing nearby, Mohanlalganj's connectivity is set to improve significantly over the next 5 years — making early investment here a compelling long-term proposition.",
            ],
            'filters'       => ['tag' => 'mohanlalganj'],
            'related_links' => [
                ['url' => '/plots-in-lucknow',           'text' => 'Plots in Lucknow'],
                ['url' => '/residential-plots-lucknow',  'text' => 'Residential Plots'],
                ['url' => '/investment-property-lucknow','text' => 'Investment Property'],
                ['url' => '/buy-property-lucknow',       'text' => 'Buy Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'Is Mohanlalganj good for property investment?',
                 'a' => 'Mohanlalganj is a good long-term investment for buyers with a 5–7 year horizon. Current land prices are low (₹5,000–12,000/sq.yd), and as Lucknow expands southward along Raebareli Road, values are expected to appreciate significantly.'],
            ],
        ],

        'property-in-vrindavan-yojna' => [
            'title'            => 'Property in Vrindavan Yojna Lucknow | LDA Township | DSD Properties',
            'meta_description' => 'Buy property in Vrindavan Yojna, Lucknow. LDA-approved plots and flats in this planned township. Safe and verified by DSD Properties.',
            'h1'               => 'Property in Vrindavan Yojna, Lucknow',
            'breadcrumb_label' => 'Vrindavan Yojna',
            'canonical'        => '/property-in-vrindavan-yojna',
            'hero_color'       => '#1a3a6b',
            'intro'            => [
                "Vrindavan Yojna is one of LDA's premium planned townships in east Lucknow, offering a well-laid-out colony with wide roads, green belts, and comprehensive civic infrastructure. The area is popular among buyers who value the safety of LDA-developed land with clear titles, approved maps, and strong re-sale liquidity.",
                "DSD Properties lists both original LDA allotment plots and resale properties in Vrindavan Yojna — including residential plots in various sector sizes (100–500 sq.yd), independent houses, and flats in the smaller societies that have come up within the township. The area is well-served by schools, markets, and healthcare facilities.",
                "Vrindavan Yojna's location in east Lucknow, with proximity to Gomti Nagar Extension and the proposed Metro Phase 2 stations, positions it as a mid-range investment with strong fundamentals and predictable appreciation.",
            ],
            'filters'       => ['tag' => 'vrindavan-yojna'],
            'related_links' => [
                ['url' => '/lda-approved-plots-lucknow',     'text' => 'LDA Approved Plots'],
                ['url' => '/property-in-gomti-nagar-extension', 'text' => 'Gomti Nagar Extension'],
                ['url' => '/residential-plots-lucknow',      'text' => 'Residential Plots'],
                ['url' => '/buy-property-lucknow',           'text' => 'Buy Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the property price in Vrindavan Yojna, Lucknow?',
                 'a' => 'Plots in Vrindavan Yojna are priced at ₹18,000–35,000/sq.yd depending on plot size and sector. Independent houses range from ₹80 lakhs to ₹2 crore. Resale LDA plots offer strong value compared to private developments.'],
            ],
        ],

        'property-in-wellness-city' => [
            'title'            => 'Property in Wellness City Lucknow | Township Flats | DSD Properties',
            'meta_description' => 'Buy property in Wellness City, Lucknow. Township flats and plots in this integrated wellness township. DSD Properties advisory.',
            'h1'               => 'Property in Wellness City, Lucknow',
            'breadcrumb_label' => 'Wellness City',
            'canonical'        => '/property-in-wellness-city',
            'hero_color'       => '#065f46',
            'intro'            => [
                "Wellness City is an integrated township concept in Lucknow that combines residential living with health, wellness, and lifestyle amenities — making it attractive to health-conscious buyers, retirees, and families who prioritise quality of life alongside property investment. The project features thoughtfully designed green spaces, walking tracks, and proximity to healthcare facilities.",
                "DSD Properties lists properties within the Wellness City development — ranging from 2 BHK flats with balcony gardens to larger 3 BHK apartments with club access and wellness amenities. The township format provides security, planned utilities, and a community-oriented living experience.",
                "As an integrated township, Wellness City properties benefit from the project's internal infrastructure investment — ensuring the value of units grows as the township matures and fully occupies.",
            ],
            'filters'       => ['tag' => 'wellness-city'],
            'related_links' => [
                ['url' => '/new-projects-lucknow',       'text' => 'New Projects in Lucknow'],
                ['url' => '/flats-in-lucknow',           'text' => 'Flats in Lucknow'],
                ['url' => '/luxury-property-lucknow',    'text' => 'Luxury Property'],
                ['url' => '/buy-property-lucknow',       'text' => 'Buy Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What amenities does Wellness City offer in Lucknow?',
                 'a' => 'Wellness City in Lucknow is designed as an integrated township offering health and wellness amenities, green walkways, security, club facilities, and proximity to healthcare infrastructure — catering to lifestyle-focused buyers and retirees.'],
            ],
        ],

        'property-in-saumitra-vihar' => [
            'title'            => 'Property in Saumitra Vihar Lucknow | Flats & Plots | DSD Properties',
            'meta_description' => 'Buy property in Saumitra Vihar, Lucknow. Verified flats and plots in this residential locality. Expert advisory by DSD Properties.',
            'h1'               => 'Property in Saumitra Vihar, Lucknow',
            'breadcrumb_label' => 'Saumitra Vihar',
            'canonical'        => '/property-in-saumitra-vihar',
            'hero_color'       => '#1e3a5f',
            'intro'            => [
                "Saumitra Vihar is a residential locality in Lucknow offering a calm, community-oriented living environment with good access to the city's main road network. The area attracts families and professionals seeking a quieter neighbourhood away from the bustle of central Lucknow while maintaining reasonable commute times to major employment centres.",
                "DSD Properties lists verified properties in Saumitra Vihar including residential flats, independent houses, and plots. The locality has been steadily developing its social infrastructure — new schools, clinics, and neighbourhood markets have come up in recent years, increasing the area's attractiveness for end-use buyers.",
                "Property prices in Saumitra Vihar represent good value compared to more established areas, offering buyers the opportunity to enter a growing neighbourhood at reasonable prices before it fully matures.",
            ],
            'filters'       => ['tag' => 'saumitra-vihar'],
            'related_links' => [
                ['url' => '/affordable-flats-lucknow',   'text' => 'Affordable Flats in Lucknow'],
                ['url' => '/plots-in-lucknow',           'text' => 'Plots in Lucknow'],
                ['url' => '/buy-property-lucknow',       'text' => 'Buy Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'Where is Saumitra Vihar located in Lucknow?',
                 'a' => 'Saumitra Vihar is a residential locality in Lucknow with access to major connecting roads. It offers affordable residential options including flats and plots for budget-conscious buyers seeking a peaceful neighbourhood.'],
            ],
        ],

        'property-in-kisan-path' => [
            'title'            => 'Property on Kisan Path Lucknow | Plots & Flats | DSD Properties',
            'meta_description' => 'Buy property on Kisan Path, Lucknow. Verified plots and flats on this important Lucknow road. Good connectivity. DSD Properties.',
            'h1'               => 'Property on Kisan Path, Lucknow',
            'breadcrumb_label' => 'Kisan Path',
            'canonical'        => '/property-in-kisan-path',
            'hero_color'       => '#1e3a5f',
            'intro'            => [
                "Kisan Path is an important arterial road in Lucknow that connects several key localities and serves as a crucial link in the city's east-west road network. Properties along and near Kisan Path benefit from excellent connectivity to Gomti Nagar, Shaheed Path, and the Lucknow Ring Road — making the corridor attractive for both residential and commercial investment.",
                "DSD Properties lists properties near Kisan Path — residential plots in colonies off the main road, 2 and 3 BHK flats in societies with Kisan Path frontage, and commercial properties catering to the road's high daily traffic. The area represents a mid-range investment zone with steady appreciation potential.",
                "The road's improving infrastructure and connectivity to multiple major Lucknow arteries make it a strategic location for buyers who value flexibility — the ability to reach any part of Lucknow quickly from their home or commercial premises.",
            ],
            'filters'       => ['tag' => 'kisan-path'],
            'related_links' => [
                ['url' => '/property-in-gomti-nagar',    'text' => 'Property in Gomti Nagar'],
                ['url' => '/plots-in-lucknow',           'text' => 'Plots in Lucknow'],
                ['url' => '/buy-property-lucknow',       'text' => 'Buy Property in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What type of properties are available near Kisan Path, Lucknow?',
                 'a' => 'Kisan Path area offers residential plots, 2–3 BHK flats in societies, independent houses, and commercial spaces. The road\'s good connectivity to Gomti Nagar and the Ring Road makes it a practical location for both end-use buyers and investors.'],
            ],
        ],

        'lda-park-view-apartments' => [
            'title'            => 'LDA Park View Apartments Lucknow | Basant Kunj Flats | DSD Properties',
            'meta_description' => 'Buy LDA Park View Apartments in Lucknow. Affordable LDA flats in Basant Kunj. Lottery and resale options. DSD Properties advisory.',
            'h1'               => 'LDA Park View Apartments, Lucknow',
            'breadcrumb_label' => 'Park View Apartments',
            'canonical'        => '/lda-park-view-apartments',
            'hero_color'       => '#1a3a6b',
            'intro'            => [
                "LDA Park View Apartments in Basant Kunj, Lucknow represent one of LDA's most popular affordable housing schemes — offering middle-income families quality government-built flats at subsidised prices. The scheme has attracted thousands of applicants through the LDA lottery process, and the project's location near established residential colonies makes it highly desirable.",
                "DSD Properties assists buyers with both new LDA scheme applications and resale Park View Apartments transactions. For resale units, we ensure complete documentation including original LDA allotment letter, transfer deed, occupancy certificate, and clearance of any dues — so your resale purchase is completely secure.",
                "The Park View Apartment project benefits from LDA's infrastructure standards — proper sanitation, water supply, electricity connections, and access roads — combined with the community atmosphere of a large housing society. These flats are excellent value and have consistent buyer demand.",
            ],
            'filters'       => ['tag' => 'park-view-apartment'],
            'related_links' => [
                ['url' => '/lda-approved-plots-lucknow', 'text' => 'LDA Approved Plots'],
                ['url' => '/affordable-flats-lucknow',   'text' => 'Affordable Flats in Lucknow'],
                ['url' => '/lda-schemes',                'text' => 'LDA Schemes 2025'],
                ['url' => '/flats-under-50-lakhs-lucknow','text' => 'Flats Under ₹50 Lakhs'],
            ],
            'faq' => [
                ['q' => 'How can I buy an LDA Park View Apartment in Lucknow?',
                 'a' => 'LDA Park View Apartments can be purchased through two routes: (1) Apply in the LDA lottery scheme when registration is open on lda.up.nic.in, or (2) Buy a resale unit from an existing allottee. DSD Properties assists with both routes, including documentation and legal verification.'],
                ['q' => 'What is the price of LDA Park View Apartments in Lucknow?',
                 'a' => 'LDA Park View Apartments in Basant Kunj are priced by LDA at subsidised rates for lottery allottees. Resale prices depend on the floor, facing, and market conditions — typically ₹25–45 lakhs for a 2 BHK unit.'],
            ],
        ],

        // ─── BHK × Locality combos ────────────────────────────────────────────

        // ── Gomti Nagar ──
        '1-bhk-flats-gomti-nagar' => [
            'title'            => '1 BHK Flats in Gomti Nagar Lucknow | Buy Apartment | DSD Properties',
            'meta_description' => 'Buy 1 BHK flats in Gomti Nagar, Lucknow. Compact apartments in Lucknow\'s premium area. Price ₹45–60 lakhs. Verified by DSD Properties.',
            'h1'               => '1 BHK Flats in Gomti Nagar, Lucknow',
            'breadcrumb_label' => '1 BHK in Gomti Nagar',
            'canonical'        => '/1-bhk-flats-gomti-nagar',
            'hero_color'       => '#1a3a6b',
            'intro'            => [
                "A 1 BHK flat in Gomti Nagar is a rare and highly sought-after asset — the combination of Lucknow's most prestigious address with a compact, affordable format makes these units ideal for young professionals, working couples, and investors seeking premium rental income. Priced between ₹45–60 lakhs, a Gomti Nagar 1 BHK commands a rental of ₹10,000–16,000/month, delivering strong yield.",
                "DSD Properties lists verified 1 BHK apartments across Gomti Nagar's various sectors — in both older established societies and newer builds near Vibhuti Khand. These units are scarce (most Gomti Nagar construction focuses on 2 and 3 BHK), so availability is limited and prices hold their value well.",
                "Our advisors help you identify well-maintained 1 BHK units with good rental history, check society maintenance records, and negotiate fair prices — ensuring your Gomti Nagar investment delivers consistent returns.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'bedrooms' => 1, 'locality' => 'Gomti Nagar'],
            'related_links' => [
                ['url' => '/2-bhk-flats-gomti-nagar',    'text' => '2 BHK in Gomti Nagar'],
                ['url' => '/flats-in-gomti-nagar',        'text' => 'All Flats in Gomti Nagar'],
                ['url' => '/1-bhk-flats-lucknow',         'text' => '1 BHK Flats in Lucknow'],
                ['url' => '/property-in-gomti-nagar',     'text' => 'All Property in Gomti Nagar'],
            ],
            'faq' => [
                ['q' => 'What is the price of a 1 BHK flat in Gomti Nagar?',
                 'a' => 'A 1 BHK flat in Gomti Nagar, Lucknow is priced between ₹45–60 lakhs depending on the society, floor, and amenities. These units are rare and tend to hold value well due to limited supply in the area.'],
            ],
        ],

        '2-bhk-flats-gomti-nagar' => [
            'title'            => '2 BHK Flats in Gomti Nagar Lucknow | Apartments for Sale | DSD Properties',
            'meta_description' => 'Buy 2 BHK flats in Gomti Nagar, Lucknow. Verified apartments ₹65–85 lakhs. Lucknow\'s top residential area. DSD Properties advisory.',
            'h1'               => '2 BHK Flats in Gomti Nagar, Lucknow',
            'breadcrumb_label' => '2 BHK in Gomti Nagar',
            'canonical'        => '/2-bhk-flats-gomti-nagar',
            'hero_color'       => '#1a3a6b',
            'intro'            => [
                "A 2 BHK flat in Gomti Nagar is the most popular residential choice for Lucknow's upwardly mobile professionals, dual-income couples, and small families. Situated in Lucknow's finest planned township, these apartments combine a prestigious address with practical living space — typically 950–1,200 sq.ft with two bedrooms, a hall, a well-designed kitchen, and parking. Prices range from ₹65 lakhs to ₹85 lakhs.",
                "DSD Properties has a strong inventory of 2 BHK Gomti Nagar flats across all price points — from competitively-priced resale units in mature societies to new construction flats in societies near Vibhuti Khand and Sector C-K with modern amenities including club access, gym, and 24×7 security.",
                "Gomti Nagar 2 BHKs are also excellent rental assets — monthly rents of ₹18,000–30,000 give investors a 4–5% annual yield, with capital appreciation of 8–12% annually over the past five years.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'bedrooms' => 2, 'locality' => 'Gomti Nagar'],
            'related_links' => [
                ['url' => '/3-bhk-flats-gomti-nagar',    'text' => '3 BHK in Gomti Nagar'],
                ['url' => '/1-bhk-flats-gomti-nagar',    'text' => '1 BHK in Gomti Nagar'],
                ['url' => '/flats-in-gomti-nagar',        'text' => 'All Flats in Gomti Nagar'],
                ['url' => '/2-bhk-flats-lucknow',         'text' => '2 BHK Flats in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the price of a 2 BHK flat in Gomti Nagar, Lucknow?',
                 'a' => 'A 2 BHK flat in Gomti Nagar costs ₹65–85 lakhs. Older societies on the main road are at the lower end, while newer societies with premium amenities near Vibhuti Khand command ₹80–90 lakhs for a 2 BHK.'],
                ['q' => 'Is buying a 2 BHK in Gomti Nagar a good investment?',
                 'a' => 'Yes. Gomti Nagar 2 BHKs have appreciated 8–12% annually for the past 5 years and command stable rents of ₹18,000–28,000/month. The area\'s premium infrastructure and limited new supply support continued price growth.'],
            ],
        ],

        '3-bhk-flats-gomti-nagar' => [
            'title'            => '3 BHK Flats in Gomti Nagar Lucknow | Premium Apartments | DSD Properties',
            'meta_description' => 'Buy 3 BHK flats in Gomti Nagar, Lucknow. Spacious apartments ₹95 lakhs to ₹1.5 crore in Lucknow\'s top locality. DSD Properties.',
            'h1'               => '3 BHK Flats in Gomti Nagar, Lucknow',
            'breadcrumb_label' => '3 BHK in Gomti Nagar',
            'canonical'        => '/3-bhk-flats-gomti-nagar',
            'hero_color'       => '#1a3a6b',
            'intro'            => [
                "A 3 BHK flat in Gomti Nagar represents the benchmark of comfortable family living in Lucknow — spacious 1,350–1,800 sq.ft layouts with three bedrooms, a formal drawing room, a dining area, a modern kitchen, and usually two or three bathrooms. At ₹95 lakhs to ₹1.5 crore, these flats attract established professionals, senior government officers, and business families who want the best Lucknow has to offer.",
                "DSD Properties lists 3 BHK flats across Gomti Nagar's most desirable sectors — from resale flats in well-maintained older societies to brand-new projects with floor-to-ceiling windows, branded fittings, and resort-style amenities. Many of our listings are in buildings with lifts, covered parking, security cameras, and society clubs.",
                "Gomti Nagar's 3 BHKs are long-term wealth-building assets. With La Martiniere, St. Francis, and other top schools within 5 km, and Sahara, Medanta, and Max hospitals nearby, these flats are perennially in demand for both purchase and rental.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'bedrooms' => 3, 'locality' => 'Gomti Nagar'],
            'related_links' => [
                ['url' => '/4-bhk-flats-gomti-nagar',    'text' => '4 BHK in Gomti Nagar'],
                ['url' => '/2-bhk-flats-gomti-nagar',    'text' => '2 BHK in Gomti Nagar'],
                ['url' => '/luxury-property-lucknow',    'text' => 'Luxury Property in Lucknow'],
                ['url' => '/3-bhk-flats-lucknow',        'text' => '3 BHK Flats in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the price of a 3 BHK flat in Gomti Nagar, Lucknow?',
                 'a' => 'A 3 BHK flat in Gomti Nagar costs ₹95 lakhs to ₹1.5 crore. Resale flats in older buildings start at ₹95 lakhs, while new construction with premium amenities can cost ₹1.2–1.5 crore for 1,500 sq.ft.'],
            ],
        ],

        '4-bhk-flats-gomti-nagar' => [
            'title'            => '4 BHK Flats in Gomti Nagar Lucknow | Luxury Apartments | DSD Properties',
            'meta_description' => 'Buy 4 BHK luxury flats in Gomti Nagar, Lucknow. Spacious premium apartments ₹1.5–2.5 crore. Gomti Nagar\'s finest. DSD Properties.',
            'h1'               => '4 BHK Flats in Gomti Nagar, Lucknow',
            'breadcrumb_label' => '4 BHK in Gomti Nagar',
            'canonical'        => '/4-bhk-flats-gomti-nagar',
            'hero_color'       => '#1a3a6b',
            'intro'            => [
                "A 4 BHK flat in Gomti Nagar is Lucknow's finest apartment living — expansive 1,800–2,800 sq.ft homes with four bedrooms, a formal living and dining area, a study or servant room, and premium finishes. These flats are the preserve of senior executives, industrialists, and established business families who want the social prestige of Gomti Nagar with the luxury of ample living space.",
                "DSD Properties offers exclusive advisory for 4 BHK Gomti Nagar flat transactions — often off-market, handled with complete discretion. Our listings include top-floor penthouses with terraces, corner units with dual aspects, and landmark society addresses that carry both lifestyle and resale value.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'bedrooms' => 4, 'locality' => 'Gomti Nagar'],
            'related_links' => [
                ['url' => '/3-bhk-flats-gomti-nagar',    'text' => '3 BHK in Gomti Nagar'],
                ['url' => '/luxury-property-lucknow',    'text' => 'Luxury Property in Lucknow'],
                ['url' => '/villa-for-sale-lucknow',     'text' => 'Villas for Sale'],
                ['url' => '/4-bhk-flats-lucknow',        'text' => '4 BHK Flats in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the price of a 4 BHK flat in Gomti Nagar?',
                 'a' => 'A 4 BHK flat in Gomti Nagar costs ₹1.5–2.5 crore. Penthouse units and corner flats with premium views and finishes can exceed ₹2.5 crore.'],
            ],
        ],

        // ── Aliganj ──
        '1-bhk-flats-aliganj' => [
            'title'            => '1 BHK Flats in Aliganj Lucknow | Affordable Apartments | DSD Properties',
            'meta_description' => 'Buy 1 BHK flats in Aliganj, Lucknow. Affordable 1 bedroom apartments ₹28–40 lakhs. Near CMS School. Verified by DSD Properties.',
            'h1'               => '1 BHK Flats in Aliganj, Lucknow',
            'breadcrumb_label' => '1 BHK in Aliganj',
            'canonical'        => '/1-bhk-flats-aliganj',
            'hero_color'       => '#4c1d95',
            'intro'            => [
                "1 BHK flats in Aliganj are the go-to choice for single working professionals, students attending nearby Lucknow University, and investors seeking affordable buy-to-let properties in a well-connected north Lucknow locality. Priced between ₹28–40 lakhs, these compact apartments offer excellent value with rental income potential of ₹8,000–12,000/month.",
                "DSD Properties lists 1 BHK flats across Aliganj's various sectors — both in smaller builder complexes offering privacy and affordability, and in larger societies with shared amenities. Aliganj's mature market means good resale liquidity and a steady pool of tenants from the student and professional community.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'bedrooms' => 1, 'locality' => 'Aliganj'],
            'related_links' => [
                ['url' => '/2-bhk-flats-aliganj',        'text' => '2 BHK in Aliganj'],
                ['url' => '/flats-in-aliganj',            'text' => 'All Flats in Aliganj'],
                ['url' => '/1-bhk-flats-lucknow',         'text' => '1 BHK Flats in Lucknow'],
                ['url' => '/affordable-flats-lucknow',    'text' => 'Affordable Flats in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the price of a 1 BHK flat in Aliganj, Lucknow?',
                 'a' => 'A 1 BHK flat in Aliganj costs ₹28–40 lakhs depending on location and amenities. Monthly rent for the same ranges from ₹8,000–12,000, giving investors a rental yield of approximately 4–5%.'],
            ],
        ],

        '2-bhk-flats-aliganj' => [
            'title'            => '2 BHK Flats in Aliganj Lucknow | Apartments for Sale | DSD Properties',
            'meta_description' => 'Buy 2 BHK flats in Aliganj, Lucknow. Verified 2 bedroom apartments ₹45–65 lakhs. Great connectivity and schools. DSD Properties.',
            'h1'               => '2 BHK Flats in Aliganj, Lucknow',
            'breadcrumb_label' => '2 BHK in Aliganj',
            'canonical'        => '/2-bhk-flats-aliganj',
            'hero_color'       => '#4c1d95',
            'intro'            => [
                "2 BHK flats in Aliganj are one of the best-value residential investments in Lucknow. This north Lucknow locality offers flats priced 20–25% below comparable Gomti Nagar options while delivering similar social infrastructure — CMS School Aliganj, multiple hospitals, banks, and supermarkets within walking distance. A 2 BHK here costs ₹45–65 lakhs with monthly rents of ₹12,000–20,000.",
                "DSD Properties has extensive listings of 2 BHK apartments in Aliganj — ranging from modest builder floors in plotted colonies to well-maintained multi-storey societies with security, lifts, and parking. We cover Aliganj Sector A through J, the Indiranagar boundary, and the Hardoi Road stretch.",
                "For first-time buyers, Aliganj 2 BHKs offer the ideal combination: a respectable address, good school catchment, manageable EMIs on a home loan, and strong resale liquidity because of constant buyer demand.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'bedrooms' => 2, 'locality' => 'Aliganj'],
            'related_links' => [
                ['url' => '/3-bhk-flats-aliganj',        'text' => '3 BHK in Aliganj'],
                ['url' => '/1-bhk-flats-aliganj',        'text' => '1 BHK in Aliganj'],
                ['url' => '/flats-in-aliganj',            'text' => 'All Flats in Aliganj'],
                ['url' => '/2-bhk-flats-lucknow',         'text' => '2 BHK Flats in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the price of a 2 BHK flat in Aliganj, Lucknow?',
                 'a' => 'A 2 BHK flat in Aliganj, Lucknow costs ₹45–65 lakhs. The lower end covers smaller builder floors in plotted colonies, while the upper range covers well-maintained multi-storey societies with amenities.'],
            ],
        ],

        '3-bhk-flats-aliganj' => [
            'title'            => '3 BHK Flats in Aliganj Lucknow | Spacious Apartments | DSD Properties',
            'meta_description' => 'Buy 3 BHK flats in Aliganj, Lucknow. Spacious 3 bedroom apartments ₹60–85 lakhs. Excellent schools and connectivity. DSD Properties.',
            'h1'               => '3 BHK Flats in Aliganj, Lucknow',
            'breadcrumb_label' => '3 BHK in Aliganj',
            'canonical'        => '/3-bhk-flats-aliganj',
            'hero_color'       => '#4c1d95',
            'intro'            => [
                "A 3 BHK flat in Aliganj is perfect for families of 4–6 who want generous living space in a well-established north Lucknow locality, without paying Gomti Nagar premiums. Priced at ₹60–85 lakhs, an Aliganj 3 BHK gives you 1,200–1,600 sq.ft of living space, three bedrooms, a spacious living-dining area, and a practical kitchen — often in a society with security and parking.",
                "DSD Properties lists 3 BHK flats in Aliganj that cater to families prioritising quality schooling (CMS School Aliganj campus is among UP's best), hospital proximity, and a neighbourhood with a strong sense of community. Many of our listings are in well-run housing societies with active maintenance committees.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'bedrooms' => 3, 'locality' => 'Aliganj'],
            'related_links' => [
                ['url' => '/2-bhk-flats-aliganj',        'text' => '2 BHK in Aliganj'],
                ['url' => '/flats-in-aliganj',            'text' => 'All Flats in Aliganj'],
                ['url' => '/3-bhk-flats-lucknow',         'text' => '3 BHK Flats in Lucknow'],
                ['url' => '/property-in-aliganj',         'text' => 'All Property in Aliganj'],
            ],
            'faq' => [
                ['q' => 'What is the price of a 3 BHK flat in Aliganj?',
                 'a' => 'A 3 BHK flat in Aliganj, Lucknow costs ₹60–85 lakhs. Mid-range 3 BHKs in good societies with amenities are available at ₹70–80 lakhs — significantly less than comparable flats in Gomti Nagar.'],
            ],
        ],

        // ── Indiranagar ──
        '1-bhk-flats-indiranagar' => [
            'title'            => '1 BHK Flats in Indiranagar Lucknow | Compact Apartments | DSD Properties',
            'meta_description' => 'Buy 1 BHK flats in Indiranagar, Lucknow. Compact apartments ₹35–50 lakhs in this premium central locality. DSD Properties.',
            'h1'               => '1 BHK Flats in Indiranagar, Lucknow',
            'breadcrumb_label' => '1 BHK in Indiranagar',
            'canonical'        => '/1-bhk-flats-indiranagar',
            'hero_color'       => '#4c1d95',
            'intro'            => [
                "1 BHK flats in Indiranagar are prime rental assets — this central Lucknow locality has the highest density of medical professionals and academics in the city (proximity to KGMU, SGPGI, and Lucknow University), creating a constant demand for quality compact apartments. Priced at ₹35–50 lakhs, Indiranagar 1 BHKs deliver monthly rents of ₹10,000–16,000.",
                "DSD Properties lists verified 1 BHK flats in Indiranagar's established residential lanes — in both older societies and newer builder constructions. The area's walkable markets, restaurants, and cafes add lifestyle value that appeals to young professionals and medical residents.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'bedrooms' => 1, 'locality' => 'Indiranagar'],
            'related_links' => [
                ['url' => '/2-bhk-flats-indiranagar',    'text' => '2 BHK in Indiranagar'],
                ['url' => '/flats-in-indiranagar',        'text' => 'All Flats in Indiranagar'],
                ['url' => '/1-bhk-flats-lucknow',         'text' => '1 BHK Flats in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the price of a 1 BHK flat in Indiranagar, Lucknow?',
                 'a' => 'A 1 BHK flat in Indiranagar, Lucknow is priced at ₹35–50 lakhs. The rental yield is strong at 4–5%, with monthly rents of ₹10,000–16,000 thanks to high demand from medical and academic professionals.'],
            ],
        ],

        '2-bhk-flats-indiranagar' => [
            'title'            => '2 BHK Flats in Indiranagar Lucknow | Apartments for Sale | DSD Properties',
            'meta_description' => 'Buy 2 BHK flats in Indiranagar, Lucknow. Verified apartments ₹55–75 lakhs in this premium residential area. DSD Properties.',
            'h1'               => '2 BHK Flats in Indiranagar, Lucknow',
            'breadcrumb_label' => '2 BHK in Indiranagar',
            'canonical'        => '/2-bhk-flats-indiranagar',
            'hero_color'       => '#4c1d95',
            'intro'            => [
                "2 BHK flats in Indiranagar are among Lucknow's most sought-after mid-range residential properties — combining a premium central address with practical family-friendly layouts. This affluent locality, known for its tree-lined lanes and upscale atmosphere, offers 2 BHKs at ₹55–75 lakhs — a significant value advantage over comparable Gomti Nagar properties at similar price points.",
                "DSD Properties lists 2 BHK flats throughout Indiranagar — from resale apartments in established societies to newer builder floors with modern interiors. The area's proximity to top medical institutions makes these flats particularly popular with doctors, hospital staff, and the families of medical students.",
                "Indiranagar 2 BHKs command healthy rents of ₹15,000–25,000/month, making them excellent buy-to-let investments with steady occupancy rates and quality tenants.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'bedrooms' => 2, 'locality' => 'Indiranagar'],
            'related_links' => [
                ['url' => '/3-bhk-flats-indiranagar',    'text' => '3 BHK in Indiranagar'],
                ['url' => '/flats-in-indiranagar',        'text' => 'All Flats in Indiranagar'],
                ['url' => '/2-bhk-flats-lucknow',         'text' => '2 BHK Flats in Lucknow'],
                ['url' => '/property-in-indiranagar',     'text' => 'All Property in Indiranagar'],
            ],
            'faq' => [
                ['q' => 'What is the price of a 2 BHK in Indiranagar, Lucknow?',
                 'a' => 'A 2 BHK flat in Indiranagar costs ₹55–75 lakhs. Premium-end units in well-maintained societies near the main Indiranagar market can touch ₹80 lakhs for larger 1,100+ sq.ft configurations.'],
            ],
        ],

        '3-bhk-flats-indiranagar' => [
            'title'            => '3 BHK Flats in Indiranagar Lucknow | Spacious Apartments | DSD Properties',
            'meta_description' => 'Buy 3 BHK flats in Indiranagar, Lucknow. Premium apartments ₹75 lakhs to ₹1.1 crore in Lucknow\'s most upscale locality. DSD Properties.',
            'h1'               => '3 BHK Flats in Indiranagar, Lucknow',
            'breadcrumb_label' => '3 BHK in Indiranagar',
            'canonical'        => '/3-bhk-flats-indiranagar',
            'hero_color'       => '#4c1d95',
            'intro'            => [
                "3 BHK flats in Indiranagar represent the upper tier of Lucknow's mid-premium apartment market. Spacious, well-designed, and located in one of the city's most sought-after neighbourhoods, these apartments appeal to successful professionals, established families, and discerning buyers who value Indiranagar's cosmopolitan character and walkable lifestyle.",
                "DSD Properties lists 3 BHK flats in Indiranagar priced between ₹75 lakhs and ₹1.1 crore — covering 1,300–1,700 sq.ft apartments with 3 bedrooms, drawing and dining rooms, well-sized kitchens, and balconies. Many listings are in societies with 24×7 security, parking, and access to the locality's vibrant food and entertainment scene.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'bedrooms' => 3, 'locality' => 'Indiranagar'],
            'related_links' => [
                ['url' => '/2-bhk-flats-indiranagar',    'text' => '2 BHK in Indiranagar'],
                ['url' => '/flats-in-indiranagar',        'text' => 'All Flats in Indiranagar'],
                ['url' => '/3-bhk-flats-lucknow',         'text' => '3 BHK Flats in Lucknow'],
                ['url' => '/luxury-property-lucknow',    'text' => 'Luxury Property'],
            ],
            'faq' => [
                ['q' => 'What is the price of a 3 BHK flat in Indiranagar?',
                 'a' => 'A 3 BHK flat in Indiranagar, Lucknow is priced at ₹75 lakhs to ₹1.1 crore. Premium units in top-floor positions or corners of well-managed societies with full amenities can touch ₹1.1 crore.'],
            ],
        ],

        // ── Gomti Nagar Extension ──
        '2-bhk-flats-gomti-nagar-extension' => [
            'title'            => '2 BHK Flats in Gomti Nagar Extension Lucknow | New Projects | DSD Properties',
            'meta_description' => 'Buy 2 BHK flats in Gomti Nagar Extension, Lucknow. New & resale apartments ₹55–80 lakhs. Fast-growing area. DSD Properties.',
            'h1'               => '2 BHK Flats in Gomti Nagar Extension, Lucknow',
            'breadcrumb_label' => '2 BHK in GNE',
            'canonical'        => '/2-bhk-flats-gomti-nagar-extension',
            'hero_color'       => '#1a3a6b',
            'intro'            => [
                "2 BHK flats in Gomti Nagar Extension are currently Lucknow's hottest residential investment, combining the aspirational Gomti Nagar brand with newer construction, bigger apartment sizes, and lower prices than old Gomti Nagar. Priced at ₹55–80 lakhs for 1,000–1,300 sq.ft, these flats in new township projects offer modern amenities — pools, gyms, club access — that older Gomti Nagar societies cannot match.",
                "DSD Properties tracks all active projects in Gomti Nagar Extension — from early-stage launches where pre-launch prices offer maximum upside, to near-possession projects where buyers can assess construction quality directly. We cover projects by Eldeco, ATS, Antriksh, Shalimar, and emerging builders entering this market.",
                "Buyers who purchased 2 BHKs in Gomti Nagar Extension in 2021–22 have seen 25–35% appreciation — making it one of the best-performing micro-markets in all of north India at the sub-₹1 crore price point.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'bedrooms' => 2, 'tag' => 'gomti-nagar-extension'],
            'related_links' => [
                ['url' => '/3-bhk-flats-gomti-nagar-extension', 'text' => '3 BHK in GNE'],
                ['url' => '/flats-in-gomti-nagar-extension',    'text' => 'All Flats in GNE'],
                ['url' => '/property-in-gomti-nagar-extension', 'text' => 'All Property in GNE'],
                ['url' => '/2-bhk-flats-lucknow',               'text' => '2 BHK Flats Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the price of a 2 BHK in Gomti Nagar Extension?',
                 'a' => 'A 2 BHK flat in Gomti Nagar Extension costs ₹55–80 lakhs. New launch projects start at ₹55–60 lakhs while near-possession or ready units with premium amenities are priced ₹70–80 lakhs.'],
            ],
        ],

        '3-bhk-flats-gomti-nagar-extension' => [
            'title'            => '3 BHK Flats in Gomti Nagar Extension Lucknow | Premium Projects | DSD Properties',
            'meta_description' => 'Buy 3 BHK flats in Gomti Nagar Extension, Lucknow. Premium apartments ₹80 lakhs to ₹1.3 crore. New & ready projects. DSD Properties.',
            'h1'               => '3 BHK Flats in Gomti Nagar Extension, Lucknow',
            'breadcrumb_label' => '3 BHK in GNE',
            'canonical'        => '/3-bhk-flats-gomti-nagar-extension',
            'hero_color'       => '#1a3a6b',
            'intro'            => [
                "3 BHK flats in Gomti Nagar Extension represent the best value premium apartment available in Lucknow today. For ₹80 lakhs to ₹1.3 crore, you get 1,400–2,000 sq.ft of carpet area in a new township project with world-class amenities — a far better deal than comparable 3 BHKs in old Gomti Nagar at similar prices and a fraction of the cost of Delhi-NCR equivalents.",
                "These apartments attract senior professionals, NRI investors, and families upgrading from central Lucknow — all drawn by the combination of premium construction standards, large apartment sizes, and Gomti Nagar Extension's rapid transformation into a fully-serviced township with schools, hospitals, and retail now operational.",
                "DSD Properties has dedicated expertise in the Gomti Nagar Extension market, helping buyers compare projects, assess possession timelines, verify RERA compliance, and negotiate payment plan terms with builders.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'bedrooms' => 3, 'tag' => 'gomti-nagar-extension'],
            'related_links' => [
                ['url' => '/2-bhk-flats-gomti-nagar-extension', 'text' => '2 BHK in GNE'],
                ['url' => '/property-in-gomti-nagar-extension', 'text' => 'All Property in GNE'],
                ['url' => '/3-bhk-flats-lucknow',               'text' => '3 BHK Flats Lucknow'],
                ['url' => '/new-projects-lucknow',              'text' => 'New Projects 2025'],
            ],
            'faq' => [
                ['q' => 'What is the price of a 3 BHK in Gomti Nagar Extension?',
                 'a' => 'A 3 BHK in Gomti Nagar Extension costs ₹80 lakhs to ₹1.3 crore. Under-construction projects offer lower launch prices while ready-to-move units in completed townships command a 10–15% premium.'],
            ],
        ],

        // ── Rajajipuram ──
        '2-bhk-flats-rajajipuram' => [
            'title'            => '2 BHK Flats in Rajajipuram Lucknow | Affordable Apartments | DSD Properties',
            'meta_description' => 'Buy 2 BHK flats in Rajajipuram, Lucknow. Affordable apartments ₹30–48 lakhs in this well-connected west Lucknow area. DSD Properties.',
            'h1'               => '2 BHK Flats in Rajajipuram, Lucknow',
            'breadcrumb_label' => '2 BHK in Rajajipuram',
            'canonical'        => '/2-bhk-flats-rajajipuram',
            'hero_color'       => '#1e3a5f',
            'intro'            => [
                "2 BHK flats in Rajajipuram offer Lucknow's best value for practical family living — a well-connected west Lucknow locality with all urban amenities, at prices significantly below the city average. At ₹30–48 lakhs for a 2 BHK, Rajajipuram delivers a full two-bedroom apartment with living room, kitchen, and parking, giving first-time buyers a real home at an achievable price point.",
                "DSD Properties lists 2 BHK flats across Rajajipuram's various sectors — covering both older LDA-era buildings that offer space at rock-bottom prices and newer builder constructions with better finishes. The locality's population of government employees, teachers, and service professionals creates a stable rental market for investors.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'bedrooms' => 2, 'tag' => 'rajajipuram'],
            'related_links' => [
                ['url' => '/flats-in-rajajipuram',           'text' => 'All Flats in Rajajipuram'],
                ['url' => '/property-in-rajajipuram',        'text' => 'All Property in Rajajipuram'],
                ['url' => '/affordable-flats-lucknow',       'text' => 'Affordable Flats in Lucknow'],
                ['url' => '/flats-under-50-lakhs-lucknow',   'text' => 'Flats Under ₹50 Lakhs'],
            ],
            'faq' => [
                ['q' => 'What is the price of a 2 BHK flat in Rajajipuram?',
                 'a' => 'A 2 BHK flat in Rajajipuram, Lucknow costs ₹30–48 lakhs. Older buildings offer ₹30–38 lakhs while newer builder constructions with better amenities are priced ₹38–48 lakhs.'],
            ],
        ],

        // ── Jankipuram ──
        '2-bhk-flats-jankipuram' => [
            'title'            => '2 BHK Flats in Jankipuram Lucknow | Affordable Apartments | DSD Properties',
            'meta_description' => 'Buy 2 BHK flats in Jankipuram, Lucknow. Affordable 2 bedroom apartments ₹35–52 lakhs in this growing north Lucknow area. DSD Properties.',
            'h1'               => '2 BHK Flats in Jankipuram, Lucknow',
            'breadcrumb_label' => '2 BHK in Jankipuram',
            'canonical'        => '/2-bhk-flats-jankipuram',
            'hero_color'       => '#1e3a5f',
            'intro'            => [
                "2 BHK flats in Jankipuram are an excellent entry point into Lucknow property ownership for budget-conscious families. This growing north Lucknow colony offers new and resale apartments at ₹35–52 lakhs — a price range that makes homeownership achievable for households with monthly incomes of ₹50,000+, especially with government home loan subsidies available for first-time buyers.",
                "Jankipuram is increasingly popular with young families, government employees, and buyers priced out of Aliganj and Indiranagar who still want a north Lucknow address. DSD Properties lists 2 BHK flats in well-maintained societies, builder complexes, and plotted colony buildings across Jankipuram.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'bedrooms' => 2, 'tag' => 'jankipuram'],
            'related_links' => [
                ['url' => '/flats-in-jankipuram',            'text' => 'All Flats in Jankipuram'],
                ['url' => '/property-in-jankipuram',         'text' => 'All Property in Jankipuram'],
                ['url' => '/affordable-flats-lucknow',       'text' => 'Affordable Flats'],
                ['url' => '/2-bhk-flats-lucknow',            'text' => '2 BHK Flats in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the price of a 2 BHK flat in Jankipuram?',
                 'a' => 'A 2 BHK flat in Jankipuram, Lucknow is priced between ₹35–52 lakhs. Newer builder constructions with better finishes are at the ₹45–52 lakh range while older resale units offer ₹35–42 lakhs.'],
            ],
        ],

        // ── Alambagh ──
        '1-bhk-flats-alambagh' => [
            'title'            => '1 BHK Flats in Alambagh Lucknow | Budget Apartments | DSD Properties',
            'meta_description' => 'Buy 1 BHK flats in Alambagh, Lucknow. Budget apartments from ₹18–28 lakhs near Railway Station. PMAY eligible. DSD Properties.',
            'h1'               => '1 BHK Flats in Alambagh, Lucknow',
            'breadcrumb_label' => '1 BHK in Alambagh',
            'canonical'        => '/1-bhk-flats-alambagh',
            'hero_color'       => '#1e3a5f',
            'intro'            => [
                "1 BHK flats in Alambagh are Lucknow's most affordable quality apartments — starting as low as ₹18 lakhs for a functional compact unit near the Lucknow Charbagh Railway Station. For first-generation homebuyers, economically weaker sections, and investors seeking budget rental assets, Alambagh 1 BHKs offer the lowest entry price into Lucknow property ownership.",
                "DSD Properties lists verified 1 BHK flats in Alambagh — in both small builder complexes along residential lanes and older LDA-era buildings. Monthly rents of ₹7,000–11,000 deliver reasonable yields. Many units in this price band qualify for PMAY (Pradhan Mantri Awas Yojana) interest subsidy, reducing effective loan costs significantly.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'bedrooms' => 1, 'locality' => 'Alambagh'],
            'related_links' => [
                ['url' => '/2-bhk-flats-alambagh',           'text' => '2 BHK in Alambagh'],
                ['url' => '/property-in-alambagh',           'text' => 'All Property in Alambagh'],
                ['url' => '/affordable-flats-lucknow',       'text' => 'Affordable Flats in Lucknow'],
                ['url' => '/1-bhk-flats-lucknow',            'text' => '1 BHK Flats in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the cheapest flat in Alambagh, Lucknow?',
                 'a' => 'The most affordable 1 BHK flats in Alambagh start at ₹18–22 lakhs for compact 350–450 sq.ft units. These are ideal for budget buyers and PMAY-eligible applicants looking for their first home.'],
            ],
        ],

        '2-bhk-flats-alambagh' => [
            'title'            => '2 BHK Flats in Alambagh Lucknow | Affordable Apartments | DSD Properties',
            'meta_description' => 'Buy 2 BHK flats in Alambagh, Lucknow. Affordable 2 bedroom apartments ₹32–50 lakhs near Lucknow Railway Station. DSD Properties.',
            'h1'               => '2 BHK Flats in Alambagh, Lucknow',
            'breadcrumb_label' => '2 BHK in Alambagh',
            'canonical'        => '/2-bhk-flats-alambagh',
            'hero_color'       => '#1e3a5f',
            'intro'            => [
                "2 BHK flats in Alambagh give first-time buyers a complete family home at one of Lucknow's most affordable price points — ₹32–50 lakhs for a full two-bedroom apartment in a metro-connected locality. With the Lucknow Metro's Alambagh station providing fast access to central Lucknow and Hazratganj, this locality combines transit convenience with budget pricing.",
                "DSD Properties lists 2 BHK flats in Alambagh suited to young families, working couples relocating to Lucknow, and investors targeting the large tenant pool of daily commuters. The Kanpur Road proximity gives good access to both the city centre and peripheral industrial employment zones.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'bedrooms' => 2, 'locality' => 'Alambagh'],
            'related_links' => [
                ['url' => '/1-bhk-flats-alambagh',           'text' => '1 BHK in Alambagh'],
                ['url' => '/property-in-alambagh',           'text' => 'All Property in Alambagh'],
                ['url' => '/flats-under-50-lakhs-lucknow',   'text' => 'Flats Under ₹50 Lakhs'],
                ['url' => '/2-bhk-flats-lucknow',            'text' => '2 BHK Flats in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the price of a 2 BHK flat in Alambagh, Lucknow?',
                 'a' => 'A 2 BHK flat in Alambagh costs ₹32–50 lakhs, making it one of Lucknow\'s most affordable options for a full-size 2-bedroom apartment in a metro-connected locality.'],
            ],
        ],

        // ── Sultanpur Road ──
        '2-bhk-flats-sultanpur-road' => [
            'title'            => '2 BHK Flats on Sultanpur Road Lucknow | New Projects | DSD Properties',
            'meta_description' => 'Buy 2 BHK flats on Sultanpur Road, Lucknow. New township apartments ₹38–55 lakhs near IT City and Airport. DSD Properties.',
            'h1'               => '2 BHK Flats on Sultanpur Road, Lucknow',
            'breadcrumb_label' => '2 BHK Sultanpur Road',
            'canonical'        => '/2-bhk-flats-sultanpur-road',
            'hero_color'       => '#064e3b',
            'intro'            => [
                "2 BHK flats on Sultanpur Road in Lucknow represent the investment sweet spot of 2025 — new township apartments at ₹38–55 lakhs in a corridor that is expected to deliver 20–30% appreciation over the next 3 years as IT City, the Airport expansion, and Purvanchal Expressway connectivity transform the area into a major urban employment hub.",
                "DSD Properties lists new 2 BHK apartments from multiple developers active on the Sultanpur Road corridor. These are RERA-registered projects offering construction-linked payment plans, modern amenities, and developer guarantees — giving buyers the security of formal development with the upside of early-stage pricing.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'bedrooms' => 2, 'tag' => 'sultanpur-road'],
            'related_links' => [
                ['url' => '/3-bhk-flats-sultanpur-road',     'text' => '3 BHK Sultanpur Road'],
                ['url' => '/property-in-sultanpur-road',     'text' => 'All Property Sultanpur Road'],
                ['url' => '/investment-property-lucknow',   'text' => 'Investment Property'],
                ['url' => '/new-projects-lucknow',           'text' => 'New Projects 2025'],
            ],
            'faq' => [
                ['q' => 'Are flats on Sultanpur Road a good investment?',
                 'a' => 'Yes, 2 BHK flats on Sultanpur Road at ₹38–55 lakhs are excellent investments for 2025–2028. IT City development, airport proximity, and expressway access are three simultaneous catalysts for price appreciation in this corridor.'],
            ],
        ],

        '3-bhk-flats-sultanpur-road' => [
            'title'            => '3 BHK Flats on Sultanpur Road Lucknow | New Township | DSD Properties',
            'meta_description' => 'Buy 3 BHK flats on Sultanpur Road, Lucknow. Spacious apartments ₹55–75 lakhs in new township projects near IT City. DSD Properties.',
            'h1'               => '3 BHK Flats on Sultanpur Road, Lucknow',
            'breadcrumb_label' => '3 BHK Sultanpur Road',
            'canonical'        => '/3-bhk-flats-sultanpur-road',
            'hero_color'       => '#064e3b',
            'intro'            => [
                "3 BHK flats on Sultanpur Road in Lucknow offer families the rare combination of large living space, modern township amenities, and an investment-grade location — all under ₹75 lakhs. In any comparable city-edge corridor in Noida or Gurgaon, a similar product would cost ₹1.5–2 crore, making Sultanpur Road the most compelling value proposition for quality-seeking families.",
                "DSD Properties lists 3 BHK township apartments from verified developers on the Sultanpur Road stretch — covering units of 1,200–1,600 sq.ft with three bedrooms, a large living-dining area, modular kitchen, and balconies. These projects are RERA registered with staggered payment plans to ease cash flow.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'bedrooms' => 3, 'tag' => 'sultanpur-road'],
            'related_links' => [
                ['url' => '/2-bhk-flats-sultanpur-road',     'text' => '2 BHK Sultanpur Road'],
                ['url' => '/property-in-sultanpur-road',     'text' => 'All Property Sultanpur Road'],
                ['url' => '/3-bhk-flats-lucknow',            'text' => '3 BHK Flats Lucknow'],
                ['url' => '/new-projects-lucknow',           'text' => 'New Projects 2025'],
            ],
            'faq' => [
                ['q' => 'What is the price of a 3 BHK flat on Sultanpur Road?',
                 'a' => 'A 3 BHK flat on Sultanpur Road, Lucknow is priced at ₹55–75 lakhs in new township projects. This makes it significantly more affordable than 3 BHKs in Gomti Nagar at comparable square footage.'],
            ],
        ],

        // ── Vikas Nagar ──
        '2-bhk-flats-vikas-nagar' => [
            'title'            => '2 BHK Flats in Vikas Nagar Lucknow | Affordable Apartments | DSD Properties',
            'meta_description' => 'Buy 2 BHK flats in Vikas Nagar, Lucknow. Affordable 2 bedroom apartments ₹35–52 lakhs in this well-established locality. DSD Properties.',
            'h1'               => '2 BHK Flats in Vikas Nagar, Lucknow',
            'breadcrumb_label' => '2 BHK in Vikas Nagar',
            'canonical'        => '/2-bhk-flats-vikas-nagar',
            'hero_color'       => '#1e3a5f',
            'intro'            => [
                "2 BHK flats in Vikas Nagar offer solid value for money in a well-established west Lucknow locality with full civic infrastructure. At ₹35–52 lakhs, these apartments cater to government employees, working families, and investors seeking budget flats in an area with stable rental demand. Vikas Nagar's self-sufficient character — with local markets, schools, clinics, and parks — makes daily life convenient.",
                "DSD Properties lists 2 BHK flats in Vikas Nagar across different sectors and building types. The area has been well-developed for over 20 years, meaning buyers get the advantage of established surroundings without paying the premiums of newer, trendier localities.",
            ],
            'filters'       => ['type' => 'flat', 'transaction' => 'sell', 'bedrooms' => 2, 'locality' => 'Vikas Nagar'],
            'related_links' => [
                ['url' => '/property-in-vikas-nagar',        'text' => 'All Property in Vikas Nagar'],
                ['url' => '/affordable-flats-lucknow',       'text' => 'Affordable Flats in Lucknow'],
                ['url' => '/2-bhk-flats-lucknow',            'text' => '2 BHK Flats in Lucknow'],
                ['url' => '/flats-under-50-lakhs-lucknow',   'text' => 'Flats Under ₹50 Lakhs'],
            ],
            'faq' => [
                ['q' => 'What is the price of a 2 BHK flat in Vikas Nagar, Lucknow?',
                 'a' => 'A 2 BHK flat in Vikas Nagar costs ₹35–52 lakhs. It is one of Lucknow\'s most affordable options for a complete 2-bedroom apartment in an established locality with full civic amenities.'],
            ],
        ],

        // ─── Flats-in-X pages (localities not yet covered) ────────────────────

        'flats-in-indiranagar' => [
            'title'            => 'Flats in Indiranagar Lucknow | Apartments for Sale | DSD Properties',
            'meta_description' => 'Buy flats in Indiranagar, Lucknow. Verified 1, 2 & 3 BHK apartments in Lucknow\'s most upscale central locality. DSD Properties.',
            'h1'               => 'Flats in Indiranagar, Lucknow',
            'breadcrumb_label' => 'Flats in Indiranagar',
            'canonical'        => '/flats-in-indiranagar',
            'hero_color'       => '#4c1d95',
            'intro'            => [
                "Indiranagar is Lucknow's most cosmopolitan residential neighbourhood — a premium central locality known for its upscale markets, restaurant culture, and highly educated, affluent resident community. Flats in Indiranagar are among the most desirable in Lucknow, combining a central location with a distinctive lifestyle character found nowhere else in the city.",
                "DSD Properties lists flats across all configurations in Indiranagar — compact 1 BHK units for professionals and investors, practical 2 BHK apartments for couples and small families, and spacious 3 BHK flats for established families who value the locality's premium character. All listings are personally verified by our advisory team.",
                "Indiranagar's proximity to KGMU, SGPGI, and multiple national institutions creates a captive rental market of high-quality tenants — making flats here excellent buy-to-let investments with yields of 4–5.5% annually.",
            ],
            'filters'       => ['type' => 'flat', 'locality' => 'Indiranagar'],
            'related_links' => [
                ['url' => '/2-bhk-flats-indiranagar',    'text' => '2 BHK in Indiranagar'],
                ['url' => '/3-bhk-flats-indiranagar',    'text' => '3 BHK in Indiranagar'],
                ['url' => '/property-in-indiranagar',    'text' => 'All Property in Indiranagar'],
                ['url' => '/flats-in-lucknow',           'text' => 'All Flats in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the price of flats in Indiranagar, Lucknow?',
                 'a' => 'Flats in Indiranagar are priced at ₹4,500–7,000/sq.ft. A 1 BHK costs ₹35–50 lakhs, a 2 BHK costs ₹55–75 lakhs, and a 3 BHK costs ₹75 lakhs to ₹1.1 crore.'],
            ],
        ],

        'flats-in-alambagh' => [
            'title'            => 'Flats in Alambagh Lucknow | Affordable Apartments | DSD Properties',
            'meta_description' => 'Buy flats in Alambagh, Lucknow. Affordable 1 & 2 BHK apartments near Lucknow Railway Station and Metro. PMAY eligible. DSD Properties.',
            'h1'               => 'Flats in Alambagh, Lucknow',
            'breadcrumb_label' => 'Flats in Alambagh',
            'canonical'        => '/flats-in-alambagh',
            'hero_color'       => '#1e3a5f',
            'intro'            => [
                "Alambagh is Lucknow's transit hub locality — home to the Charbagh Railway Station, major bus terminals, and the Alambagh Metro station — making it the first choice for buyers who prioritise connectivity above all else. Flats in Alambagh are the most affordable in Lucknow's accessible zones, with 1 BHK units from ₹18 lakhs and 2 BHK apartments from ₹32 lakhs.",
                "DSD Properties lists flats across Alambagh's residential areas — away from the main road noise, in quieter colonies and builder complexes where families live comfortably. The area's large workforce population creates a steady rental market for investors.",
                "Alambagh is also one of the best areas for PMAY (Pradhan Mantri Awas Yojana) eligible buyers — several ongoing projects qualify for the EWS/LIG interest subsidy scheme that can reduce effective loan costs by ₹2.67 lakhs.",
            ],
            'filters'       => ['type' => 'flat', 'locality' => 'Alambagh'],
            'related_links' => [
                ['url' => '/1-bhk-flats-alambagh',           'text' => '1 BHK in Alambagh'],
                ['url' => '/2-bhk-flats-alambagh',           'text' => '2 BHK in Alambagh'],
                ['url' => '/property-in-alambagh',           'text' => 'All Property in Alambagh'],
                ['url' => '/affordable-flats-lucknow',       'text' => 'Affordable Flats in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the price of flats in Alambagh, Lucknow?',
                 'a' => 'Flats in Alambagh are priced at ₹2,800–4,200/sq.ft — the most affordable in metro-connected Lucknow. A 1 BHK costs ₹18–28 lakhs and a 2 BHK costs ₹32–50 lakhs.'],
            ],
        ],

        'flats-in-vikas-nagar' => [
            'title'            => 'Flats in Vikas Nagar Lucknow | Apartments for Sale | DSD Properties',
            'meta_description' => 'Buy flats in Vikas Nagar, Lucknow. Affordable 2 & 3 BHK apartments in this well-established west Lucknow locality. DSD Properties.',
            'h1'               => 'Flats in Vikas Nagar, Lucknow',
            'breadcrumb_label' => 'Flats in Vikas Nagar',
            'canonical'        => '/flats-in-vikas-nagar',
            'hero_color'       => '#1e3a5f',
            'intro'            => [
                "Vikas Nagar is a mature, self-sufficient residential colony in west Lucknow offering affordable flats in an established neighbourhood with full civic infrastructure. Developed over the last 25+ years, the locality has a settled community character, good local markets, schools, and parks — making it a practical, no-frills choice for families prioritising value over prestige.",
                "DSD Properties lists flats in Vikas Nagar across 1, 2, and 3 BHK configurations — in multi-storey societies, builder floors, and smaller residential complexes. Prices are 30–40% lower than similar-sized apartments in Aliganj or Indiranagar, making Vikas Nagar a compelling option for budget buyers.",
            ],
            'filters'       => ['type' => 'flat', 'locality' => 'Vikas Nagar'],
            'related_links' => [
                ['url' => '/2-bhk-flats-vikas-nagar',    'text' => '2 BHK in Vikas Nagar'],
                ['url' => '/property-in-vikas-nagar',    'text' => 'All Property in Vikas Nagar'],
                ['url' => '/affordable-flats-lucknow',   'text' => 'Affordable Flats in Lucknow'],
                ['url' => '/flats-in-lucknow',           'text' => 'All Flats in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the flat price in Vikas Nagar, Lucknow?',
                 'a' => 'Flats in Vikas Nagar are priced at ₹3,000–4,800/sq.ft. A 2 BHK (850 sq.ft) costs ₹35–50 lakhs — among the most affordable full-size apartments in an established Lucknow locality.'],
            ],
        ],

        'flats-in-gomti-nagar-extension' => [
            'title'            => 'Flats in Gomti Nagar Extension Lucknow | New Apartments | DSD Properties',
            'meta_description' => 'Buy flats in Gomti Nagar Extension, Lucknow. New & resale 2/3 BHK apartments in Lucknow\'s fastest-growing locality. DSD Properties.',
            'h1'               => 'Flats in Gomti Nagar Extension, Lucknow',
            'breadcrumb_label' => 'Flats in GNE',
            'canonical'        => '/flats-in-gomti-nagar-extension',
            'hero_color'       => '#1a3a6b',
            'intro'            => [
                "Gomti Nagar Extension is the most dynamic residential locality in Lucknow today — a rapidly developing LDA township that is transitioning from open plots to a premium apartment corridor at an astonishing pace. Flats here combine the prestige of the Gomti Nagar address with newer construction, larger carpet areas, and lower prices than old Gomti Nagar.",
                "DSD Properties has comprehensive coverage of Gomti Nagar Extension — tracking every project from pre-launch to possession-ready, and maintaining a database of verified resale flats in completed societies. We cover 2 BHK apartments from ₹55 lakhs, 3 BHK flats from ₹80 lakhs, and premium 4 BHK units above ₹1.2 crore.",
                "With Metro Phase 2 stations planned for this corridor and Lucknow's eastward expansion firmly on track, GNE flats purchased today are positioned for strong capital gains over the next 5 years.",
            ],
            'filters'       => ['type' => 'flat', 'tag' => 'gomti-nagar-extension'],
            'related_links' => [
                ['url' => '/2-bhk-flats-gomti-nagar-extension', 'text' => '2 BHK in GNE'],
                ['url' => '/3-bhk-flats-gomti-nagar-extension', 'text' => '3 BHK in GNE'],
                ['url' => '/property-in-gomti-nagar-extension', 'text' => 'All Property in GNE'],
                ['url' => '/new-projects-lucknow',              'text' => 'New Projects 2025'],
            ],
            'faq' => [
                ['q' => 'What is the flat price in Gomti Nagar Extension?',
                 'a' => 'Flat prices in Gomti Nagar Extension range from ₹4,200–7,000/sq.ft. A 2 BHK costs ₹55–80 lakhs and a 3 BHK costs ₹80 lakhs to ₹1.3 crore depending on the project and amenities.'],
            ],
        ],

        'flats-in-rajajipuram' => [
            'title'            => 'Flats in Rajajipuram Lucknow | Affordable Apartments | DSD Properties',
            'meta_description' => 'Buy flats in Rajajipuram, Lucknow. Affordable 1, 2 & 3 BHK apartments in west Lucknow. Low-cost homes for first-time buyers. DSD Properties.',
            'h1'               => 'Flats in Rajajipuram, Lucknow',
            'breadcrumb_label' => 'Flats in Rajajipuram',
            'canonical'        => '/flats-in-rajajipuram',
            'hero_color'       => '#1e3a5f',
            'intro'            => [
                "Rajajipuram is one of Lucknow's oldest and largest planned residential colonies — a sprawling LDA township in west Lucknow that has been home to generations of government employees, teachers, and middle-class families. Flats in Rajajipuram are among Lucknow's most affordable, with 1 BHKs starting at ₹22 lakhs and 2 BHKs available from ₹30 lakhs.",
                "DSD Properties lists flats throughout Rajajipuram's sectors — covering both older construction that offers generous space at low prices and newer builder projects with modern finishes at still-affordable price points. The locality's established community and self-sufficient infrastructure make daily life convenient.",
                "For investors, Rajajipuram flats deliver steady rental income from the area's large tenant base of government staff and industrial workers. Monthly rents of ₹7,000–15,000 give respectable yields on affordable entry prices.",
            ],
            'filters'       => ['type' => 'flat', 'tag' => 'rajajipuram'],
            'related_links' => [
                ['url' => '/2-bhk-flats-rajajipuram',    'text' => '2 BHK in Rajajipuram'],
                ['url' => '/property-in-rajajipuram',    'text' => 'All Property in Rajajipuram'],
                ['url' => '/affordable-flats-lucknow',   'text' => 'Affordable Flats in Lucknow'],
                ['url' => '/flats-in-lucknow',           'text' => 'All Flats in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the price of flats in Rajajipuram, Lucknow?',
                 'a' => 'Flats in Rajajipuram are priced at ₹3,000–4,500/sq.ft — some of Lucknow\'s most affordable. A 1 BHK costs ₹22–32 lakhs and a 2 BHK costs ₹30–48 lakhs.'],
            ],
        ],

        'flats-in-jankipuram' => [
            'title'            => 'Flats in Jankipuram Lucknow | Apartments for Sale | DSD Properties',
            'meta_description' => 'Buy flats in Jankipuram, Lucknow. Affordable 2 & 3 BHK apartments in this growing north Lucknow colony. DSD Properties.',
            'h1'               => 'Flats in Jankipuram, Lucknow',
            'breadcrumb_label' => 'Flats in Jankipuram',
            'canonical'        => '/flats-in-jankipuram',
            'hero_color'       => '#1e3a5f',
            'intro'            => [
                "Jankipuram is a growing residential colony in north Lucknow offering practical, affordable flats for families who value space, community living, and good connectivity to the city. Located along the Sitapur Road corridor with access to the Outer Ring Road, Jankipuram provides a quieter, more spacious alternative to the dense central localities at a fraction of the price.",
                "DSD Properties lists flats in Jankipuram across 1, 2, and 3 BHK configurations — in both new builder constructions and established residential societies. The area is particularly popular with government employees posted in north Lucknow and families with children, given the availability of multiple schools within the colony.",
            ],
            'filters'       => ['type' => 'flat', 'tag' => 'jankipuram'],
            'related_links' => [
                ['url' => '/2-bhk-flats-jankipuram',     'text' => '2 BHK in Jankipuram'],
                ['url' => '/property-in-jankipuram',     'text' => 'All Property in Jankipuram'],
                ['url' => '/affordable-flats-lucknow',   'text' => 'Affordable Flats'],
                ['url' => '/flats-in-lucknow',           'text' => 'All Flats in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the flat price in Jankipuram, Lucknow?',
                 'a' => 'Flats in Jankipuram are priced at ₹3,200–5,000/sq.ft. A 2 BHK (900 sq.ft) costs ₹35–50 lakhs, making it one of north Lucknow\'s most affordable areas for a full-size family apartment.'],
            ],
        ],

        'flats-in-sultanpur-road' => [
            'title'            => 'Flats on Sultanpur Road Lucknow | New Township Apartments | DSD Properties',
            'meta_description' => 'Buy flats on Sultanpur Road, Lucknow. New township apartments near IT City & Airport. Best investment 2025. DSD Properties.',
            'h1'               => 'Flats on Sultanpur Road, Lucknow',
            'breadcrumb_label' => 'Flats Sultanpur Road',
            'canonical'        => '/flats-in-sultanpur-road',
            'hero_color'       => '#064e3b',
            'intro'            => [
                "Sultanpur Road is emerging as Lucknow's most compelling residential investment corridor — a stretch where new township projects are delivering modern apartments at below-city-average prices, backed by the dual catalysts of IT City development and proximity to Lucknow International Airport. Flats here range from 1 BHK at ₹28 lakhs to 3 BHK at ₹70 lakhs.",
                "DSD Properties tracks all residential projects along Sultanpur Road — ensuring buyers can compare RERA-registered developers, assess construction progress, evaluate payment plan terms, and identify the units offering the best combination of price, location within the project, and builder credibility.",
                "Early buyers in this corridor (2022–23) have already seen 20–30% appreciation. New buyers in 2025 are still entering at attractive prices before the area fully urbanises over the next 5–7 years.",
            ],
            'filters'       => ['type' => 'flat', 'tag' => 'sultanpur-road'],
            'related_links' => [
                ['url' => '/2-bhk-flats-sultanpur-road',     'text' => '2 BHK Sultanpur Road'],
                ['url' => '/3-bhk-flats-sultanpur-road',     'text' => '3 BHK Sultanpur Road'],
                ['url' => '/property-in-sultanpur-road',     'text' => 'All Property Sultanpur Road'],
                ['url' => '/investment-property-lucknow',   'text' => 'Investment Property'],
            ],
            'faq' => [
                ['q' => 'Are flats on Sultanpur Road good for investment in 2025?',
                 'a' => 'Yes, Sultanpur Road flats are among Lucknow\'s best investments in 2025. IT City employment, airport proximity, and expressway connectivity are three simultaneous catalysts that should drive 20–30% appreciation over 3–5 years.'],
            ],
        ],

        // ─── Plots-in-X pages ──────────────────────────────────────────────────

        'plots-in-gomti-nagar' => [
            'title'            => 'Plots in Gomti Nagar Lucknow | Premium Land for Sale | DSD Properties',
            'meta_description' => 'Buy plots in Gomti Nagar, Lucknow. Prime residential and commercial land in Lucknow\'s most prestigious locality. DSD Properties.',
            'h1'               => 'Plots in Gomti Nagar, Lucknow',
            'breadcrumb_label' => 'Plots in Gomti Nagar',
            'canonical'        => '/plots-in-gomti-nagar',
            'hero_color'       => '#064e3b',
            'intro'            => [
                "Plots in Gomti Nagar are Lucknow's most prestigious and scarce land assets. In a fully-planned, built-up township where almost all original plots have been developed, resale plots appear infrequently and command a significant premium. Owning a plot in Gomti Nagar means the ultimate flexibility — build your dream home on one of Lucknow's most coveted addresses.",
                "DSD Properties maintains a watch list for Gomti Nagar plot opportunities — alerting buyers when resale plots in Sectors A–K or Vibhuti Khand come to market. Plot sizes in Gomti Nagar typically range from 150 sq.yd to 500+ sq.yd, with prices reflecting the sector and road frontage.",
            ],
            'filters'       => ['type' => 'plot', 'locality' => 'Gomti Nagar'],
            'related_links' => [
                ['url' => '/plots-in-gomti-nagar-extension', 'text' => 'Plots in GN Extension'],
                ['url' => '/property-in-gomti-nagar',        'text' => 'All Property in Gomti Nagar'],
                ['url' => '/residential-plots-lucknow',      'text' => 'Residential Plots Lucknow'],
                ['url' => '/luxury-property-lucknow',        'text' => 'Luxury Property'],
            ],
            'faq' => [
                ['q' => 'What is the plot rate in Gomti Nagar, Lucknow?',
                 'a' => 'Plots in Gomti Nagar are priced at ₹35,000–80,000/sq.yd depending on sector, frontage, and size. A 200 sq.yd plot in a prime sector can cost ₹1–1.5 crore. These are extremely scarce assets with strong long-term value.'],
            ],
        ],

        'plots-in-gomti-nagar-extension' => [
            'title'            => 'Plots in Gomti Nagar Extension Lucknow | Residential Land | DSD Properties',
            'meta_description' => 'Buy plots in Gomti Nagar Extension, Lucknow. Residential land in LDA\'s fastest-growing township. Best investment 2025. DSD Properties.',
            'h1'               => 'Plots in Gomti Nagar Extension, Lucknow',
            'breadcrumb_label' => 'Plots in GNE',
            'canonical'        => '/plots-in-gomti-nagar-extension',
            'hero_color'       => '#064e3b',
            'intro'            => [
                "Plots in Gomti Nagar Extension are among Lucknow's most sought-after land investments — combining the Gomti Nagar address brand with newer, still-affordable land prices in a rapidly developing LDA township. As the area transitions from open plots to a fully-built premium township, land values are rising steadily.",
                "DSD Properties lists both original LDA allotted plots and resale private plots in Gomti Nagar Extension — covering sizes from 100 sq.yd starter plots to 500+ sq.yd family plots. The area's planned infrastructure (wide roads, underground utilities, parks) makes self-construction straightforward and future sale easy.",
            ],
            'filters'       => ['type' => 'plot', 'tag' => 'gomti-nagar-extension'],
            'related_links' => [
                ['url' => '/plots-in-gomti-nagar',           'text' => 'Plots in Gomti Nagar'],
                ['url' => '/property-in-gomti-nagar-extension', 'text' => 'All Property in GNE'],
                ['url' => '/lda-approved-plots-lucknow',     'text' => 'LDA Approved Plots'],
                ['url' => '/residential-plots-lucknow',      'text' => 'Residential Plots Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the plot price in Gomti Nagar Extension?',
                 'a' => 'Plots in Gomti Nagar Extension are priced at ₹18,000–40,000/sq.yd depending on location within the township, road width, and plot size. A 200 sq.yd plot costs ₹50–80 lakhs.'],
            ],
        ],

        'plots-in-sultanpur-road' => [
            'title'            => 'Plots on Sultanpur Road Lucknow | Investment Land | DSD Properties',
            'meta_description' => 'Buy plots on Sultanpur Road, Lucknow. Residential and commercial land near IT City. Best land investment 2025. DSD Properties.',
            'h1'               => 'Plots on Sultanpur Road, Lucknow',
            'breadcrumb_label' => 'Plots Sultanpur Road',
            'canonical'        => '/plots-in-sultanpur-road',
            'hero_color'       => '#064e3b',
            'intro'            => [
                "Plots on Sultanpur Road represent Lucknow's most compelling land investment narrative in 2025. This corridor — running from Lucknow's city limits toward the Purvanchal Expressway — is being transformed by the IT City development, airport expansion, and planned Ring Road alignment into one of UP's most important emerging commercial-residential corridors.",
                "DSD Properties lists residential and commercial plots along the Sultanpur Road belt — from 100 sq.yd residential plots in RERA-registered colonies at ₹25–40 lakhs to large commercial land parcels above 1,000 sq.yd for institutional buyers. All plots are verified for clear title, proper land-use classification, and development authority approval.",
                "Buyers who acquired Sultanpur Road plots in 2021–22 have seen 25–35% appreciation already. Today's prices still represent early-stage value compared to what this corridor will look like in 5–7 years.",
            ],
            'filters'       => ['type' => 'plot', 'tag' => 'sultanpur-road'],
            'related_links' => [
                ['url' => '/property-in-sultanpur-road',     'text' => 'All Property Sultanpur Road'],
                ['url' => '/property-in-it-city-lucknow',   'text' => 'IT City Properties'],
                ['url' => '/residential-plots-lucknow',      'text' => 'Residential Plots Lucknow'],
                ['url' => '/investment-property-lucknow',   'text' => 'Investment Property'],
            ],
            'faq' => [
                ['q' => 'What is the plot rate on Sultanpur Road, Lucknow?',
                 'a' => 'Plot rates on Sultanpur Road range from ₹12,000–22,000/sq.yd for residential plots and ₹20,000–45,000/sq.yd for commercial plots. A 200 sq.yd residential plot costs ₹28–45 lakhs.'],
            ],
        ],

        'plots-in-aliganj' => [
            'title'            => 'Plots in Aliganj Lucknow | Residential Land for Sale | DSD Properties',
            'meta_description' => 'Buy plots in Aliganj, Lucknow. Residential plots in this popular north Lucknow locality. Clear title, verified. DSD Properties.',
            'h1'               => 'Plots in Aliganj, Lucknow',
            'breadcrumb_label' => 'Plots in Aliganj',
            'canonical'        => '/plots-in-aliganj',
            'hero_color'       => '#064e3b',
            'intro'            => [
                "Plots in Aliganj are increasingly rare — as one of Lucknow's most established residential localities, most of Aliganj's original plotted land has been developed into houses or flats over the decades. When plots do come up for resale, they command a premium reflecting the area's consistent demand, established infrastructure, and the strong buyer pool for this locality.",
                "DSD Properties maintains active relationships with plot owners in Aliganj and alerts buyers when resale plots become available. We cover plots in Aliganj's various sectors, offering sizes from small 100 sq.yd plots suitable for builder floors to larger 250–400 sq.yd plots for full independent houses.",
            ],
            'filters'       => ['type' => 'plot', 'locality' => 'Aliganj'],
            'related_links' => [
                ['url' => '/flats-in-aliganj',           'text' => 'Flats in Aliganj'],
                ['url' => '/property-in-aliganj',        'text' => 'All Property in Aliganj'],
                ['url' => '/residential-plots-lucknow',  'text' => 'Residential Plots Lucknow'],
                ['url' => '/plots-in-lucknow',           'text' => 'All Plots in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the plot rate in Aliganj, Lucknow?',
                 'a' => 'Plots in Aliganj are priced at ₹22,000–42,000/sq.yd depending on sector, road width, and plot size. A 150 sq.yd plot costs ₹40–65 lakhs.'],
            ],
        ],

        'plots-in-rajajipuram' => [
            'title'            => 'Plots in Rajajipuram Lucknow | Affordable Land | DSD Properties',
            'meta_description' => 'Buy plots in Rajajipuram, Lucknow. Affordable residential plots in this established west Lucknow colony. DSD Properties.',
            'h1'               => 'Plots in Rajajipuram, Lucknow',
            'breadcrumb_label' => 'Plots in Rajajipuram',
            'canonical'        => '/plots-in-rajajipuram',
            'hero_color'       => '#064e3b',
            'intro'            => [
                "Plots in Rajajipuram offer one of Lucknow's best land values — an established colony with full civic infrastructure, reasonable prices, and the flexibility to self-build your ideal home. As an old LDA colony, Rajajipuram has well-defined plot layouts with clear titles, making land purchase here straightforward and low-risk.",
                "DSD Properties lists resale residential plots in Rajajipuram at competitive prices, covering a range of sizes from 100 sq.yd entry-level plots to larger 300+ sq.yd family plots. The area's stable property market and strong rental demand from the resident community support steady appreciation.",
            ],
            'filters'       => ['type' => 'plot', 'tag' => 'rajajipuram'],
            'related_links' => [
                ['url' => '/flats-in-rajajipuram',       'text' => 'Flats in Rajajipuram'],
                ['url' => '/property-in-rajajipuram',    'text' => 'All Property in Rajajipuram'],
                ['url' => '/residential-plots-lucknow',  'text' => 'Residential Plots Lucknow'],
                ['url' => '/plots-in-lucknow',           'text' => 'All Plots in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the plot rate in Rajajipuram, Lucknow?',
                 'a' => 'Plots in Rajajipuram are priced at ₹12,000–22,000/sq.yd — among Lucknow\'s most affordable in an established colony. A 150 sq.yd plot costs ₹20–35 lakhs.'],
            ],
        ],

        'plots-in-jankipuram' => [
            'title'            => 'Plots in Jankipuram Lucknow | Residential Land | DSD Properties',
            'meta_description' => 'Buy plots in Jankipuram, Lucknow. Affordable land in this growing north Lucknow colony. Build your own home. DSD Properties.',
            'h1'               => 'Plots in Jankipuram, Lucknow',
            'breadcrumb_label' => 'Plots in Jankipuram',
            'canonical'        => '/plots-in-jankipuram',
            'hero_color'       => '#064e3b',
            'intro'            => [
                "Plots in Jankipuram are a practical choice for buyers who want to build a custom home in north Lucknow at an affordable price. With plot sizes starting from 100 sq.yd and prices well below central Lucknow areas, Jankipuram allows buyers to design and build exactly the home they want — without paying a premium for someone else's construction choices.",
                "DSD Properties lists residential plots across Jankipuram's various sectors, verifying each plot's ownership documents, approved layout plan, and utility connections before listing. The area's improving connectivity via Sitapur Road and the Ring Road makes Jankipuram plots increasingly attractive for both self-construction and future resale.",
            ],
            'filters'       => ['type' => 'plot', 'tag' => 'jankipuram'],
            'related_links' => [
                ['url' => '/flats-in-jankipuram',        'text' => 'Flats in Jankipuram'],
                ['url' => '/property-in-jankipuram',     'text' => 'All Property in Jankipuram'],
                ['url' => '/residential-plots-lucknow',  'text' => 'Residential Plots Lucknow'],
                ['url' => '/plots-in-lucknow',           'text' => 'All Plots in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the plot price in Jankipuram, Lucknow?',
                 'a' => 'Residential plots in Jankipuram are priced at ₹10,000–18,000/sq.yd. A 150 sq.yd plot costs approximately ₹18–28 lakhs — very affordable for a north Lucknow location with good connectivity.'],
            ],
        ],

        'plots-in-vikas-nagar' => [
            'title'            => 'Plots in Vikas Nagar Lucknow | Affordable Land | DSD Properties',
            'meta_description' => 'Buy plots in Vikas Nagar, Lucknow. Affordable residential plots in established west Lucknow colony. DSD Properties.',
            'h1'               => 'Plots in Vikas Nagar, Lucknow',
            'breadcrumb_label' => 'Plots in Vikas Nagar',
            'canonical'        => '/plots-in-vikas-nagar',
            'hero_color'       => '#064e3b',
            'intro'            => [
                "Plots in Vikas Nagar offer affordable land ownership in an established west Lucknow colony with mature civic infrastructure. For buyers who want to build their own home in a settled neighbourhood — with schools, markets, and hospitals already in place — Vikas Nagar plots provide a practical solution at prices well below central Lucknow.",
                "DSD Properties lists resale plots in Vikas Nagar across various sizes and sectors. The area's established character means construction approvals from LDA/Nagar Nigam are straightforward, and finding experienced local contractors is easy — making the self-build process far less complicated than in newer developing areas.",
            ],
            'filters'       => ['type' => 'plot', 'locality' => 'Vikas Nagar'],
            'related_links' => [
                ['url' => '/property-in-vikas-nagar',    'text' => 'All Property in Vikas Nagar'],
                ['url' => '/residential-plots-lucknow',  'text' => 'Residential Plots Lucknow'],
                ['url' => '/affordable-flats-lucknow',   'text' => 'Affordable Flats in Lucknow'],
                ['url' => '/plots-in-lucknow',           'text' => 'All Plots in Lucknow'],
            ],
            'faq' => [
                ['q' => 'What is the plot price in Vikas Nagar, Lucknow?',
                 'a' => 'Plots in Vikas Nagar are priced at ₹10,000–18,000/sq.yd. A 150 sq.yd plot costs ₹18–28 lakhs — affordable for a self-build in an established colony with all civic amenities.'],
            ],
        ],

        // ─── Rent combos ───────────────────────────────────────────────────────

    ]; // end $manualPages

    // ════════════════════════════════════════════════════════════════════════
    // LOCALITY DATA  — compact metadata driving programmatic page generation
    // ════════════════════════════════════════════════════════════════════════
    private static array $loc = [
        'gomti-nagar' => [
            'n'=>'Gomti Nagar','lf'=>'Gomti Nagar','tf'=>null,
            'p1'=>'₹40–65L','p2'=>'₹65L–1.2Cr','p3'=>'₹95L–1.8Cr','p4'=>'₹1.5–2.5Cr','pp'=>'₹1–3Cr',
            'r1'=>'₹10k–18k/mo','r2'=>'₹18k–40k/mo','r3'=>'₹30k–65k/mo',
            'kf'=>"Lucknow's premier residential and commercial township",'lm'=>'Phoenix Palassio, Sahara Hospital, Lucknow Metro','ap'=>'10–15%',
        ],
        'gomti-nagar-extension' => [
            'n'=>'Gomti Nagar Extension','lf'=>null,'tf'=>'gomti-nagar-extension',
            'p1'=>'₹30–52L','p2'=>'₹50–90L','p3'=>'₹80L–1.4Cr','p4'=>'₹1.2–2Cr','pp'=>'₹60L–2Cr',
            'r1'=>'₹8k–14k/mo','r2'=>'₹14k–28k/mo','r3'=>'₹25k–50k/mo',
            'kf'=>"Lucknow's fastest-growing residential corridor with new high-rise projects",'lm'=>'Shaheed Path, GD Goenka School, Max Hospital','ap'=>'15–22%',
        ],
        'aliganj' => [
            'n'=>'Aliganj','lf'=>'Aliganj','tf'=>null,
            'p1'=>'₹25–45L','p2'=>'₹45–80L','p3'=>'₹70L–1.2Cr','p4'=>'₹1–1.8Cr','pp'=>'₹40L–1.5Cr',
            'r1'=>'₹8k–15k/mo','r2'=>'₹14k–28k/mo','r3'=>'₹22k–45k/mo',
            'kf'=>'established locality with top schools, markets, and metro connectivity','lm'=>'CMS Aliganj, Aliganj Market, Lucknow Metro','ap'=>'8–12%',
        ],
        'indiranagar' => [
            'n'=>'Indiranagar','lf'=>'Indiranagar','tf'=>null,
            'p1'=>'₹28–48L','p2'=>'₹48–85L','p3'=>'₹75L–1.3Cr','p4'=>'₹1.1–1.9Cr','pp'=>'₹45L–1.8Cr',
            'r1'=>'₹9k–16k/mo','r2'=>'₹15k–28k/mo','r3'=>'₹24k–42k/mo',
            'kf'=>'central residential area popular with professionals, KGMU faculty, and families','lm'=>'KGMU, Indiranagar Market, Lucknow Metro','ap'=>'8–12%',
        ],
        'alambagh' => [
            'n'=>'Alambagh','lf'=>'Alambagh','tf'=>null,
            'p1'=>'₹20–38L','p2'=>'₹35–65L','p3'=>'₹55–95L','p4'=>'₹80L–1.5Cr','pp'=>'₹30L–1.2Cr',
            'r1'=>'₹7k–13k/mo','r2'=>'₹11k–22k/mo','r3'=>'₹18k–35k/mo',
            'kf'=>'affordable residential hub near the railway station and Kanpur Road','lm'=>'Charbagh Railway Station, Alambagh Bus Terminal, Ring Road','ap'=>'7–11%',
        ],
        'hazratganj' => [
            'n'=>'Hazratganj','lf'=>'Hazratganj','tf'=>null,
            'p1'=>'₹35–60L','p2'=>'₹60L–1.1Cr','p3'=>'₹90L–1.6Cr','p4'=>'₹1.4–2.2Cr','pp'=>'₹80L–2.5Cr',
            'r1'=>'₹10k–18k/mo','r2'=>'₹18k–35k/mo','r3'=>'₹28k–55k/mo',
            'kf'=>"Lucknow's historic city centre and most prestigious commercial address",'lm'=>'Hazratganj Market, GPO, Raj Bhawan, Lucknow Metro','ap'=>'9–13%',
        ],
        'vikas-nagar' => [
            'n'=>'Vikas Nagar','lf'=>'Vikas Nagar','tf'=>null,
            'p1'=>'₹22–40L','p2'=>'₹38–68L','p3'=>'₹58–98L','p4'=>'₹85L–1.5Cr','pp'=>'₹35L–1Cr',
            'r1'=>'₹7k–13k/mo','r2'=>'₹12k–22k/mo','r3'=>'₹18k–35k/mo',
            'kf'=>'mid-segment residential area with strong connectivity to Kanpur Road and Ring Road','lm'=>'Vikas Nagar Market, Ring Road, Kanpur Road','ap'=>'7–10%',
        ],
        'rajajipuram' => [
            'n'=>'Rajajipuram','lf'=>null,'tf'=>'rajajipuram',
            'p1'=>'₹18–35L','p2'=>'₹32–58L','p3'=>'₹50–85L','p4'=>'₹75L–1.3Cr','pp'=>'₹25L–90L',
            'r1'=>'₹6k–11k/mo','r2'=>'₹10k–19k/mo','r3'=>'₹16k–30k/mo',
            'kf'=>'affordable locality popular with government employees and working professionals','lm'=>'Rajajipuram Market, Government Offices, Ring Road','ap'=>'6–10%',
        ],
        'jankipuram' => [
            'n'=>'Jankipuram','lf'=>null,'tf'=>'jankipuram',
            'p1'=>'₹20–38L','p2'=>'₹34–62L','p3'=>'₹52–90L','p4'=>'₹78L–1.4Cr','pp'=>'₹28L–95L',
            'r1'=>'₹7k–12k/mo','r2'=>'₹11k–20k/mo','r3'=>'₹17k–32k/mo',
            'kf'=>'growing LDA-approved locality with parks, schools, and good faizabad road access','lm'=>'Jankipuram Vistar, LDA Colonies, Faizabad Road','ap'=>'8–12%',
        ],
        'sultanpur-road' => [
            'n'=>'Sultanpur Road','lf'=>null,'tf'=>'sultanpur-road',
            'p1'=>'₹22–42L','p2'=>'₹38–72L','p3'=>'₹60L–1.1Cr','p4'=>'₹90L–1.6Cr','pp'=>'₹35L–1.5Cr',
            'r1'=>'₹7k–13k/mo','r2'=>'₹12k–24k/mo','r3'=>'₹20k–38k/mo',
            'kf'=>"Lucknow's hottest investment corridor near Lulu Mall and the international airport",'lm'=>'Lulu Mall, Airport Access Road, Shaheed Path Junction','ap'=>'15–25%',
        ],
        'mahanagar' => [
            'n'=>'Mahanagar','lf'=>'Mahanagar','tf'=>null,
            'p1'=>'₹28–48L','p2'=>'₹45–82L','p3'=>'₹70L–1.2Cr','p4'=>'₹1–1.8Cr','pp'=>'₹50L–1.5Cr',
            'r1'=>'₹9k–16k/mo','r2'=>'₹15k–27k/mo','r3'=>'₹23k–42k/mo',
            'kf'=>'well-established residential area with premium schools and Lucknow Metro access','lm'=>'CMS Mahanagar, Mahanagar Metro Station, Markets','ap'=>'8–12%',
        ],
        'kanpur-road' => [
            'n'=>'Kanpur Road','lf'=>null,'tf'=>'kanpur-road',
            'p1'=>'₹20–38L','p2'=>'₹36–65L','p3'=>'₹55–95L','p4'=>'₹80L–1.4Cr','pp'=>'₹30L–1.2Cr',
            'r1'=>'₹7k–13k/mo','r2'=>'₹12k–22k/mo','r3'=>'₹19k–35k/mo',
            'kf'=>'strategic corridor connecting Lucknow to Kanpur with industrial and residential zones','lm'=>'Charbagh Station, Ring Road, Industrial Areas','ap'=>'7–11%',
        ],
        'faizabad-road' => [
            'n'=>'Faizabad Road','lf'=>'Faizabad Road','tf'=>null,
            'p1'=>'₹18–35L','p2'=>'₹32–58L','p3'=>'₹50–85L','p4'=>'₹72L–1.3Cr','pp'=>'₹25L–90L',
            'r1'=>'₹6k–11k/mo','r2'=>'₹10k–19k/mo','r3'=>'₹16k–30k/mo',
            'kf'=>'developing NH corridor with affordable plots and rapidly expanding housing projects','lm'=>'Faizabad NH, Jankipuram Extension, Barabanki Border','ap'=>'8–13%',
        ],
        'sushant-golf-city' => [
            'n'=>'Sushant Golf City','lf'=>'Sushant Golf City','tf'=>null,
            'p1'=>'₹35–58L','p2'=>'₹58L–1.1Cr','p3'=>'₹85L–1.6Cr','p4'=>'₹1.3–2.2Cr','pp'=>'₹60L–2Cr',
            'r1'=>'₹10k–17k/mo','r2'=>'₹17k–32k/mo','r3'=>'₹28k–52k/mo',
            'kf'=>'integrated golf-course township with premium villas, apartments, and green landscapes','lm'=>'18-hole Golf Course, Club House, Shaheed Path','ap'=>'12–18%',
        ],
        'shaheed-path' => [
            'n'=>'Shaheed Path','lf'=>'Shaheed Path','tf'=>null,
            'p1'=>'₹30–52L','p2'=>'₹52–95L','p3'=>'₹80L–1.5Cr','p4'=>'₹1.2–2Cr','pp'=>'₹70L–2.5Cr',
            'r1'=>'₹9k–15k/mo','r2'=>'₹15k–30k/mo','r3'=>'₹25k–48k/mo',
            'kf'=>"Lucknow's premier urban expressway with flagship residential projects from top builders",'lm'=>'IT City, Eco City, GNE, Lucknow Airport area','ap'=>'12–18%',
        ],
    ];

    // ════════════════════════════════════════════════════════════════════════
    // TEMPLATE HELPERS
    // ════════════════════════════════════════════════════════════════════════

    /** Build the locality-filter sub-array for a page config */
    private static function lf(array $l): array
    {
        $f = [];
        if (!empty($l['lf'])) $f['locality'] = $l['lf'];
        if (!empty($l['tf'])) $f['tag']      = $l['tf'];
        return $f;
    }

    private static function hc(int $idx): string
    {
        $colors = ['#011f4b','#1e3a5f','#1a3a6b','#064e3b','#1e3a5f','#2d3748','#1a365d'];
        return $colors[$idx % count($colors)];
    }

    // ── Template: BHK × Locality SELL ────────────────────────────────────────
    private static function bhkSellPage(string $slug, string $ls, int $b, array $l): array
    {
        $price = $l["p{$b}"] ?? '₹30L–1.5Cr';
        return [
            'title'            => "{$b} BHK Flats in {$l['n']}, Lucknow | {$price} | DSD Properties",
            'meta_description' => "Buy verified {$b} BHK flats in {$l['n']}, Lucknow. Apartments priced {$price}. {$l['kf']}. Expert advisory by DSD Properties.",
            'h1'               => "{$b} BHK Flats in {$l['n']}, Lucknow",
            'breadcrumb_label' => "{$b} BHK in {$l['n']}",
            'canonical'        => "/{$slug}",
            'hero_color'       => '#1e3a5f',
            'intro' => [
                "A {$b} BHK flat in {$l['n']}, Lucknow is one of the most sought-after residential assets in the city. Priced between {$price}, these apartments combine a premium {$l['n']} address with practical living space. The locality is {$l['kf']}, making it ideal for families, professionals, and investors.",
                "DSD Properties maintains a verified inventory of {$b} BHK flats across {$l['n']}'s societies — covering ready-to-move resale units and new-construction apartments with lift, parking, security, and club access. Key landmarks nearby include {$l['lm']}.",
                "Property values in {$l['n']} have appreciated {$l['ap']} over recent years. Our advisors help buyers negotiate the best price, verify legal documents, and navigate the home-loan process end to end.",
            ],
            'filters'       => array_merge(['type'=>'flat','transaction'=>'sell','bedrooms'=>$b], self::lf($l)),
            'related_links' => [
                ['url'=>"/{$b}-bhk-flats-lucknow",         'text'=>"{$b} BHK Flats in Lucknow"],
                ['url'=>"/flats-in-{$ls}",                 'text'=>"All Flats in {$l['n']}"],
                ['url'=>"/property-in-{$ls}",              'text'=>"All Property in {$l['n']}"],
                ['url'=>"/new-projects-{$ls}",             'text'=>"New Projects in {$l['n']}"],
            ],
            'faq' => [
                ['q'=>"What is the price of a {$b} BHK flat in {$l['n']}, Lucknow?",
                 'a'=>"A {$b} BHK flat in {$l['n']} costs {$price} depending on the society, floor, and amenities. Newer projects with clubhouse and gym facilities command a premium over resale units in older societies."],
                ['q'=>"Is {$l['n']} a good area to buy a {$b} BHK flat?",
                 'a'=>"{$l['n']} is {$l['kf']}. Values have appreciated {$l['ap']} recently. Its proximity to {$l['lm']} ensures strong rental demand and lifestyle convenience."],
            ],
        ];
    }

    // ── Template: flats-in-{loc} ──────────────────────────────────────────────
    private static function flatsInPage(string $slug, string $ls, array $l): array
    {
        return [
            'title'            => "Flats in {$l['n']}, Lucknow | Buy Apartments | DSD Properties",
            'meta_description' => "Buy flats in {$l['n']}, Lucknow. 1, 2 & 3 BHK verified apartments {$l['p1']} to {$l['p3']}. {$l['kf']}. DSD Properties advisory.",
            'h1'               => "Flats in {$l['n']}, Lucknow",
            'breadcrumb_label' => "Flats in {$l['n']}",
            'canonical'        => "/{$slug}",
            'hero_color'       => '#011f4b',
            'intro' => [
                "{$l['n']} is {$l['kf']}. Buying a flat here gives you access to one of Lucknow's most well-connected residential neighbourhoods, with property prices ranging from {$l['p1']} for a 1 BHK to {$l['p3']} for a premium 3 BHK — depending on size, floor, age, and society amenities.",
                "DSD Properties lists verified flats for sale across {$l['n']}'s established societies and new projects. Our inventory covers 1, 2, and 3 BHK apartments — both resale units with immediate possession and new launches with RERA registration. Key nearby landmarks: {$l['lm']}.",
                "Whether you're buying your first home, upgrading to a larger flat, or investing for rental income, our advisory team helps you every step of the way — from site visits and legal checks to stamp duty guidance and home-loan introductions.",
            ],
            'filters'       => array_merge(['type'=>'flat','transaction'=>'sell'], self::lf($l)),
            'related_links' => [
                ['url'=>"/1-bhk-flats-{$ls}",              'text'=>"1 BHK Flats in {$l['n']}"],
                ['url'=>"/2-bhk-flats-{$ls}",              'text'=>"2 BHK Flats in {$l['n']}"],
                ['url'=>"/3-bhk-flats-{$ls}",              'text'=>"3 BHK Flats in {$l['n']}"],
                ['url'=>"/property-in-{$ls}",              'text'=>"All Property in {$l['n']}"],
            ],
            'faq' => [
                ['q'=>"What is the price of flats in {$l['n']}, Lucknow?",
                 'a'=>"Flats in {$l['n']} range from {$l['p1']} for a 1 BHK to {$l['p3']} for a 3 BHK. Prices depend on the society, floor, age, and amenities available."],
                ['q'=>"Which is the best society to buy a flat in {$l['n']}?",
                 'a'=>"{$l['n']} has several reputed housing societies with good amenities. DSD Properties recommends verified societies based on your budget, preferred BHK size, and possession timeline."],
            ],
        ];
    }

    // ── Template: plots-in-{loc} ──────────────────────────────────────────────
    private static function plotsInPage(string $slug, string $ls, array $l): array
    {
        return [
            'title'            => "Plots in {$l['n']}, Lucknow | Residential Land | DSD Properties",
            'meta_description' => "Buy plots in {$l['n']}, Lucknow. Verified residential and commercial plots {$l['pp']}. Clear titles, legal verification. DSD Properties.",
            'h1'               => "Plots in {$l['n']}, Lucknow",
            'breadcrumb_label' => "Plots in {$l['n']}",
            'canonical'        => "/{$slug}",
            'hero_color'       => '#064e3b',
            'intro' => [
                "A plot in {$l['n']}, Lucknow offers the unique advantage of self-construction flexibility in a locality that is {$l['kf']}. Plot prices range from {$l['pp']} depending on size, facing, and proximity to main roads — with values appreciating {$l['ap']} in recent years.",
                "DSD Properties lists verified plots in {$l['n']} — from compact 100 sq.yd residential plots in established colonies to larger 300–500 sq.yd plots suitable for independent houses or small commercial developments. We also have LDA-approved and RERA-compliant layout plots available.",
                "Before listing any plot, our team verifies ownership documents, land-use classification, and registry records. We guide you through the mutation, stamp duty, and registration process for a dispute-free purchase.",
            ],
            'filters'       => array_merge(['type'=>'plot','transaction'=>'sell'], self::lf($l)),
            'related_links' => [
                ['url'=>"/plots-for-sale-{$ls}",           'text'=>"Plots for Sale in {$l['n']}"],
                ['url'=>"/residential-plots-{$ls}",        'text'=>"Residential Plots in {$l['n']}"],
                ['url'=>"/property-in-{$ls}",              'text'=>"All Property in {$l['n']}"],
                ['url'=>"/plots-in-lucknow",               'text'=>"All Plots in Lucknow"],
            ],
            'faq' => [
                ['q'=>"What is the price of plots in {$l['n']}, Lucknow?",
                 'a'=>"Plot prices in {$l['n']} range from {$l['pp']} depending on size (sq.yd), facing, and road width. Corner plots and main-road-facing plots command a premium."],
                ['q'=>"Are LDA-approved plots available in {$l['n']}?",
                 'a'=>"DSD Properties lists both LDA-approved and privately developed RERA-registered plots in {$l['n']}. We verify land records, aakar patra, and registry documents before listing any plot."],
            ],
        ];
    }

    // ── Template: plots-for-sale-{loc} ───────────────────────────────────────
    private static function plotsForSalePage(string $slug, string $ls, array $l): array
    {
        return [
            'title'            => "Plots for Sale in {$l['n']}, Lucknow | Buy Land | DSD Properties",
            'meta_description' => "Buy plots for sale in {$l['n']}, Lucknow. Residential & commercial plots {$l['pp']}. LDA-approved options available. DSD Properties.",
            'h1'               => "Plots for Sale in {$l['n']}, Lucknow",
            'breadcrumb_label' => "Plots for Sale in {$l['n']}",
            'canonical'        => "/{$slug}",
            'hero_color'       => '#064e3b',
            'intro' => [
                "Buying a plot for sale in {$l['n']}, Lucknow is a strategic investment in one of the city's key corridors. {$l['n']} is {$l['kf']} — driving steady demand for plots among self-construction buyers, investors, and builders. Plot prices in the area range from {$l['pp']}.",
                "DSD Properties maintains a verified portfolio of plots for sale in {$l['n']}: residential plots in approved layouts, corner plots on wide roads, and commercial plots along high-traffic streets. Nearby landmarks include {$l['lm']}.",
                "Our team ensures every plot listing carries verified ownership documents, mutation records, and clear title. We assist buyers with the complete purchase process — from document due diligence to stamp duty payment and registry.",
            ],
            'filters'       => array_merge(['type'=>'plot','transaction'=>'sell'], self::lf($l)),
            'related_links' => [
                ['url'=>"/plots-in-{$ls}",                 'text'=>"Plots in {$l['n']}"],
                ['url'=>"/residential-plots-{$ls}",        'text'=>"Residential Plots in {$l['n']}"],
                ['url'=>"/lda-approved-plots-lucknow",     'text'=>"LDA Approved Plots in Lucknow"],
                ['url'=>"/property-in-{$ls}",              'text'=>"All Property in {$l['n']}"],
            ],
            'faq' => [
                ['q'=>"What size plots are available for sale in {$l['n']}, Lucknow?",
                 'a'=>"Plot sizes in {$l['n']} range from 100 sq.yd residential plots to large 1,000+ sq.yd commercial plots. The most popular sizes are 150–250 sq.yd, ideal for independent house construction."],
                ['q'=>"How do I verify a plot before buying in {$l['n']}?",
                 'a'=>"DSD Properties handles full legal verification — Khasra/Khatauni, Aakar Patra, registry/sale deed, and any LDA or development authority NOC. Never purchase a plot without a full title search."],
            ],
        ];
    }

    // ── Template: property-in-{loc} (new localities) ─────────────────────────
    private static function propertyInPage(string $slug, string $ls, array $l): array
    {
        return [
            'title'            => "Property in {$l['n']}, Lucknow | Buy & Rent | DSD Properties",
            'meta_description' => "Buy or rent property in {$l['n']}, Lucknow. Flats, plots, houses. Prices from {$l['p1']}. {$l['kf']}. DSD Properties advisory.",
            'h1'               => "Property in {$l['n']}, Lucknow",
            'breadcrumb_label' => "{$l['n']}",
            'canonical'        => "/{$slug}",
            'hero_color'       => '#1e3a5f',
            'intro' => [
                "{$l['n']} is {$l['kf']}. The locality has emerged as a significant residential destination in Lucknow, offering a mix of flats, plots, independent houses, and commercial spaces across multiple price points — from {$l['p1']} for a compact 1 BHK to {$l['pp']} for prime plots.",
                "DSD Properties lists verified properties in {$l['n']} across all categories — residential flats, plots for self-construction, villas, and commercial spaces. Our listings are near important landmarks including {$l['lm']}, ensuring connectivity and lifestyle convenience.",
                "Whether you're looking to buy your first home, invest for capital appreciation, or find a rental property in {$l['n']}, our advisory team provides end-to-end support including legal verification, price negotiation, and loan assistance.",
            ],
            'filters'       => self::lf($l),
            'related_links' => [
                ['url'=>"/flats-in-{$ls}",                 'text'=>"Flats in {$l['n']}"],
                ['url'=>"/plots-in-{$ls}",                 'text'=>"Plots in {$l['n']}"],
                ['url'=>"/2-bhk-flats-{$ls}",              'text'=>"2 BHK Flats in {$l['n']}"],
                ['url'=>"/buy-property-lucknow",           'text'=>"Buy Property in Lucknow"],
            ],
            'faq' => [
                ['q'=>"What types of property are available in {$l['n']}, Lucknow?",
                 'a'=>"{$l['n']} offers flats (1–4 BHK), residential plots, independent houses, villas, and commercial spaces. Flats are priced from {$l['p1']} and plots from {$l['pp']}."],
                ['q'=>"Is {$l['n']} a good area to invest in property in Lucknow?",
                 'a'=>"{$l['n']} is {$l['kf']} with property appreciation of {$l['ap']}. Its proximity to {$l['lm']} makes it attractive for both end-use buyers and investors seeking rental income."],
            ],
        ];
    }

    // ── Template: house-for-sale-{loc} ───────────────────────────────────────
    private static function houseForSalePage(string $slug, string $ls, array $l): array
    {
        return [
            'title'            => "House for Sale in {$l['n']}, Lucknow | Independent House | DSD Properties",
            'meta_description' => "Buy house for sale in {$l['n']}, Lucknow. Independent houses, row houses, and villas. Verified by DSD Properties. Expert advisory.",
            'h1'               => "House for Sale in {$l['n']}, Lucknow",
            'breadcrumb_label' => "House for Sale in {$l['n']}",
            'canonical'        => "/{$slug}",
            'hero_color'       => '#1a3a6b',
            'intro' => [
                "An independent house in {$l['n']}, Lucknow offers the privacy, space, and ownership pride that apartment living cannot match. {$l['n']} is {$l['kf']}, and independent houses here range from compact 2-bedroom homes ideal for small families to spacious 5-bedroom bungalows with large gardens.",
                "DSD Properties lists verified independent houses for sale in {$l['n']} — covering both older well-maintained properties and newly constructed houses in approved layouts. We focus on clear-title properties with verified registry documents and approved building plans. Key amenities nearby include {$l['lm']}.",
                "Our advisory team helps you assess the property's structural condition, verify legal documents (aakar patra, approved map, registry), and negotiate a fair price. We also connect buyers with renovation contractors and home-loan specialists if needed.",
            ],
            'filters'       => array_merge(['type'=>'house','transaction'=>'sell'], self::lf($l)),
            'related_links' => [
                ['url'=>"/villa-in-{$ls}",                 'text'=>"Villas in {$l['n']}"],
                ['url'=>"/flats-in-{$ls}",                 'text'=>"Flats in {$l['n']}"],
                ['url'=>"/property-in-{$ls}",              'text'=>"All Property in {$l['n']}"],
                ['url'=>"/house-for-sale-lucknow",         'text'=>"Houses for Sale in Lucknow"],
                ['url'=>"/plots-in-{$ls}",                 'text'=>"Plots in {$l['n']}"],
            ],
            'faq' => [
                ['q'=>"What is the price of an independent house in {$l['n']}, Lucknow?",
                 'a'=>"Independent houses in {$l['n']} are priced depending on plot size, built-up area, age, and condition. Typical 3-bedroom houses on a 200 sq.yd plot cost significantly more than flat alternatives of similar BHK count."],
                ['q'=>"What documents should I check when buying a house in {$l['n']}?",
                 'a'=>"Key documents: approved building plan from LDA/MC, aakar patra, all sale deeds in chain of title, latest property tax receipts, and no encumbrance certificate. DSD Properties assists with full legal due diligence."],
            ],
        ];
    }

    // ── Template: villa-in-{loc} ─────────────────────────────────────────────
    private static function villaInPage(string $slug, string $ls, array $l): array
    {
        return [
            'title'            => "Villas in {$l['n']}, Lucknow | Luxury Villa for Sale | DSD Properties",
            'meta_description' => "Buy luxury villas in {$l['n']}, Lucknow. Premium independent villas with modern amenities. Verified by DSD Properties. Expert advisory.",
            'h1'               => "Villas in {$l['n']}, Lucknow",
            'breadcrumb_label' => "Villas in {$l['n']}",
            'canonical'        => "/{$slug}",
            'hero_color'       => '#011f4b',
            'intro' => [
                "A villa in {$l['n']}, Lucknow represents the pinnacle of residential living — combining the exclusivity of an independent property with modern design, premium finishes, and gated community security. {$l['n']} is {$l['kf']}, making it one of the best addresses for villa ownership in the city.",
                "DSD Properties curates luxury villas in {$l['n']} — from duplex villas in gated township projects to standalone bungalows on large plots. Our villa listings feature premium specifications: modular kitchens, vitrified flooring, landscaped gardens, private car parks, and smart home features. Landmarks nearby: {$l['lm']}.",
                "Villa properties in {$l['n']} have shown appreciation of {$l['ap']} in recent years, driven by growing demand from high-net-worth buyers and NRI investors. Our advisors conduct comprehensive legal and structural due diligence before recommending any villa purchase.",
            ],
            'filters'       => array_merge(['type'=>'villa','transaction'=>'sell'], self::lf($l)),
            'related_links' => [
                ['url'=>"/house-for-sale-{$ls}",           'text'=>"Houses in {$l['n']}"],
                ['url'=>"/luxury-flats-{$ls}",             'text'=>"Luxury Flats in {$l['n']}"],
                ['url'=>"/property-in-{$ls}",              'text'=>"All Property in {$l['n']}"],
                ['url'=>"/villa-for-sale-lucknow",         'text'=>"Villas in Lucknow"],
            ],
            'faq' => [
                ['q'=>"Are luxury villas available in {$l['n']}, Lucknow?",
                 'a'=>"Yes, {$l['n']} has premium villa projects and independent bungalows available for sale. These properties offer more space, privacy, and luxury than standard apartments — ideal for large families and NRI buyers."],
                ['q'=>"What is the price range of villas in {$l['n']}, Lucknow?",
                 'a'=>"Villa prices in {$l['n']} vary widely based on plot size, built-up area, and project specifications. Contact DSD Properties for current inventory and pricing tailored to your requirements."],
            ],
        ];
    }

    // ── Template: builder-floor-{loc} ────────────────────────────────────────
    private static function builderFloorPage(string $slug, string $ls, array $l): array
    {
        return [
            'title'            => "Builder Floor in {$l['n']}, Lucknow | Independent Floor | DSD Properties",
            'meta_description' => "Buy builder floor in {$l['n']}, Lucknow. Independent floors with private entrance, terrace rights. Better than apartments. DSD Properties.",
            'h1'               => "Builder Floor in {$l['n']}, Lucknow",
            'breadcrumb_label' => "Builder Floor in {$l['n']}",
            'canonical'        => "/{$slug}",
            'hero_color'       => '#2d3748',
            'intro' => [
                "A builder floor in {$l['n']}, Lucknow offers the ideal middle ground between apartment living and an independent house — you get your own dedicated floor with a private entrance, often terrace rights, and no shared lobby. {$l['n']} is {$l['kf']}, and builder floors here are popular with families seeking more privacy at lower cost than a full independent house.",
                "DSD Properties lists verified builder floors in {$l['n']}: ground, first, and second floor units across newly constructed stilt-parking buildings and older well-maintained properties. Prices are typically 10–20% lower than comparable society flats, offering excellent value for buyers who prioritise privacy over amenities.",
                "Key things to verify for a builder floor: approved building plan with correct number of floors, separate electricity meters, clearly defined terrace/open area rights in the sale deed, and building completion certificate. Our legal team handles all due diligence.",
            ],
            'filters'       => array_merge(['type'=>'builder_floor','transaction'=>'sell'], self::lf($l)),
            'related_links' => [
                ['url'=>"/flats-in-{$ls}",                 'text'=>"Flats in {$l['n']}"],
                ['url'=>"/house-for-sale-{$ls}",           'text'=>"Houses in {$l['n']}"],
                ['url'=>"/builder-floor-lucknow",          'text'=>"Builder Floors in Lucknow"],
                ['url'=>"/property-in-{$ls}",              'text'=>"All Property in {$l['n']}"],
            ],
            'faq' => [
                ['q'=>"What is a builder floor and how is it different from an apartment in {$l['n']}?",
                 'a'=>"A builder floor is an independently owned floor of a low-rise building (2–4 floors) with its own entrance. Unlike apartments, builder floors have no maintenance society charges, no common area obligations, and often include terrace or open area rights on upper floors."],
                ['q'=>"Are builder floors cheaper than flats in {$l['n']}, Lucknow?",
                 'a'=>"Generally yes — builder floors in {$l['n']} are priced 10–20% lower than comparable society flats due to absence of amenities like gym, club, and swimming pool. They're ideal for buyers who prioritise space and privacy over facilities."],
            ],
        ];
    }

    // ── Template: commercial-property-{loc} ──────────────────────────────────
    private static function commercialPage(string $slug, string $ls, array $l): array
    {
        return [
            'title'            => "Commercial Property in {$l['n']}, Lucknow | Office & Shop | DSD Properties",
            'meta_description' => "Buy or rent commercial property in {$l['n']}, Lucknow. Shops, offices, showrooms. High-footfall location. DSD Properties expert advisory.",
            'h1'               => "Commercial Property in {$l['n']}, Lucknow",
            'breadcrumb_label' => "Commercial in {$l['n']}",
            'canonical'        => "/{$slug}",
            'hero_color'       => '#1a365d',
            'intro' => [
                "{$l['n']} is {$l['kf']}, making it a prime location for commercial property investment. The area sees consistent footfall from residents, professionals, and visitors — creating strong demand for retail shops, offices, and showrooms. Commercial properties here benefit from excellent visibility and easy customer access.",
                "DSD Properties lists verified commercial properties in {$l['n']}: ground-floor shops in residential colonies, office spaces in commercial complexes, showrooms on arterial roads, and co-working spaces. Key commercial landmarks include {$l['lm']}.",
                "Commercial real estate in {$l['n']} offers rental yields of 5–8% annually — significantly higher than residential properties. Our advisors help you identify properties with strong footfall, assess rental potential, and verify all commercial title documents.",
            ],
            'filters'       => array_merge(['type'=>'commercial','transaction'=>'sell'], self::lf($l)),
            'related_links' => [
                ['url'=>"/commercial-property-lucknow",    'text'=>"Commercial Property in Lucknow"],
                ['url'=>"/property-in-{$ls}",              'text'=>"All Property in {$l['n']}"],
                ['url'=>"/office-space-{$ls}",             'text'=>"Office Space in {$l['n']}"],
                ['url'=>"/investment-property-{$ls}",      'text'=>"Investment Property in {$l['n']}"],
            ],
            'faq' => [
                ['q'=>"What types of commercial property are available in {$l['n']}, Lucknow?",
                 'a'=>"Commercial properties in {$l['n']} include retail shops (ground floor), offices in commercial buildings, showrooms on main roads, and warehouse/storage spaces. Both purchase and rental options are available."],
                ['q'=>"What is the rental yield for commercial property in {$l['n']}?",
                 'a'=>"Commercial properties in {$l['n']} typically yield 5–8% annual rental return — higher than residential properties. High-footfall ground-floor shops on main roads command premium rentals and strong capital appreciation."],
            ],
        ];
    }

    // ── Template: new-projects-{loc} ─────────────────────────────────────────
    private static function newProjectsPage(string $slug, string $ls, array $l): array
    {
        return [
            'title'            => "New Projects in {$l['n']}, Lucknow | Under Construction | DSD Properties",
            'meta_description' => "Explore new residential projects in {$l['n']}, Lucknow. RERA-approved apartments, plots, townships. Pre-launch prices. DSD Properties advisory.",
            'h1'               => "New Projects in {$l['n']}, Lucknow",
            'breadcrumb_label' => "New Projects in {$l['n']}",
            'canonical'        => "/{$slug}",
            'hero_color'       => '#1e3a5f',
            'intro' => [
                "New residential and commercial projects in {$l['n']}, Lucknow offer buyers the best prices, modern specifications, and the ability to customise interiors before possession. {$l['n']} is {$l['kf']}, attracting top builders from Lucknow and other major cities to launch projects in this growing corridor.",
                "DSD Properties tracks all new launches in {$l['n']} — from affordable housing schemes to luxury high-rises. Our listings cover RERA-registered projects with verified builder credentials, approved building plans, and realistic possession timelines. Properties are priced from {$l['p1']} onwards.",
                "New project buyers benefit from pre-launch pricing (often 10–20% below post-possession prices), flexible payment plans, and the full RERA protection framework. Our advisors help you evaluate project credibility, construction progress, and payment milestone risks before booking.",
            ],
            'filters'       => array_merge(['type'=>'flat','transaction'=>'sell','age'=>'new_construction'], self::lf($l)),
            'related_links' => [
                ['url'=>"/ready-to-move-flats-{$ls}",      'text'=>"Ready to Move in {$l['n']}"],
                ['url'=>"/flats-in-{$ls}",                 'text'=>"All Flats in {$l['n']}"],
                ['url'=>"/new-projects-lucknow",           'text'=>"New Projects in Lucknow"],
                ['url'=>"/property-in-{$ls}",              'text'=>"All Property in {$l['n']}"],
            ],
            'faq' => [
                ['q'=>"Which new residential projects are available in {$l['n']}, Lucknow?",
                 'a'=>"DSD Properties tracks all active new launches in {$l['n']}, including RERA-registered projects from reputed builders. Contact us for the latest inventory, pricing, and possession timelines."],
                ['q'=>"Is it safe to buy an under-construction flat in {$l['n']}?",
                 'a'=>"Buying an under-construction flat is safe when the project is RERA-registered (verifiable at uprera.gov.in), the builder has a good track record, and the payment plan is linked to construction milestones. DSD Properties verifies all these before recommending any project."],
            ],
        ];
    }

    // ── Template: ready-to-move-flats-{loc} ──────────────────────────────────
    private static function readyToMovePage(string $slug, string $ls, array $l): array
    {
        return [
            'title'            => "Ready to Move Flats in {$l['n']}, Lucknow | Immediate Possession | DSD Properties",
            'meta_description' => "Buy ready-to-move flats in {$l['n']}, Lucknow. No wait, immediate possession. 1/2/3 BHK apartments {$l['p1']} to {$l['p3']}. DSD Properties.",
            'h1'               => "Ready to Move Flats in {$l['n']}, Lucknow",
            'breadcrumb_label' => "Ready to Move in {$l['n']}",
            'canonical'        => "/{$slug}",
            'hero_color'       => '#1a3a6b',
            'intro' => [
                "Ready-to-move flats in {$l['n']}, Lucknow are ideal for buyers who cannot afford to wait — you get immediate possession, pay stamp duty only on actual transfer, and start saving on rent from day one. {$l['n']} is {$l['kf']}, making these properties highly sought after with limited supply.",
                "DSD Properties specialises in ready-to-move inventory in {$l['n']}: both resale flats in established societies and newly completed builder units available for registration. Our listings cover 1, 2, and 3 BHK apartments priced from {$l['p1']} to {$l['p3']}, all with verified occupancy certificates.",
                "Advantages of ready-to-move over under-construction: no construction delay risk, GST exemption (no GST on completed flats), immediate rental income potential, and ability to inspect the actual unit before purchase. Our advisors ensure occupation certificate, completion certificate, and society approvals are all in order.",
            ],
            'filters'       => array_merge(['type'=>'flat','transaction'=>'sell'], self::lf($l)),
            'related_links' => [
                ['url'=>"/new-projects-{$ls}",             'text'=>"New Projects in {$l['n']}"],
                ['url'=>"/flats-in-{$ls}",                 'text'=>"All Flats in {$l['n']}"],
                ['url'=>"/2-bhk-flats-{$ls}",              'text'=>"2 BHK Flats in {$l['n']}"],
                ['url'=>"/property-in-{$ls}",              'text'=>"All Property in {$l['n']}"],
            ],
            'faq' => [
                ['q'=>"What are the advantages of buying a ready-to-move flat in {$l['n']}?",
                 'a'=>"Ready-to-move flats offer immediate possession, no GST (saving 5–12% vs under-construction), ability to physically inspect the flat, immediate rental income, and no construction delay risk. They're ideal for buyers with an urgent housing need."],
                ['q'=>"Are ready-to-move flats more expensive than under-construction in {$l['n']}?",
                 'a'=>"Ready-to-move flats in {$l['n']} are typically priced 5–15% higher than comparable under-construction units. However, factoring in no GST, no wait time, and no delay risk makes them excellent value for end-use buyers."],
            ],
        ];
    }

    // ── Template: investment-property-{loc} ──────────────────────────────────
    private static function investmentPage(string $slug, string $ls, array $l): array
    {
        return [
            'title'            => "Investment Property in {$l['n']}, Lucknow | High Returns | DSD Properties",
            'meta_description' => "Invest in property in {$l['n']}, Lucknow. {$l['ap']} appreciation. High rental yield. Expert investment advisory by DSD Properties.",
            'h1'               => "Investment Property in {$l['n']}, Lucknow",
            'breadcrumb_label' => "Investment in {$l['n']}",
            'canonical'        => "/{$slug}",
            'hero_color'       => '#064e3b',
            'intro' => [
                "{$l['n']}, Lucknow is delivering exceptional investment returns — property values have appreciated {$l['ap']} in recent years, driven by the locality's status as {$l['kf']}. For investors seeking high capital appreciation combined with consistent rental income, {$l['n']} is one of Lucknow's top choices.",
                "DSD Properties identifies the best investment properties in {$l['n']}: 2 BHK flats with strong rental demand, commercial shops with high footfall, and plots in approved layouts with rapid value growth. Our investment advisory service analyses rental yield, appreciation potential, and liquidity before recommending any asset.",
                "Key investment parameters for {$l['n']}: rental yield on 2 BHK flats averages {$l['r2']} per month, annual appreciation {$l['ap']}, high demand from {$l['lm']} proximity. NRI investors and first-time buyers both find strong value in this micro-market.",
            ],
            'filters'       => self::lf($l),
            'related_links' => [
                ['url'=>"/investment-property-lucknow",    'text'=>"Investment Property in Lucknow"],
                ['url'=>"/new-projects-{$ls}",             'text'=>"New Projects in {$l['n']}"],
                ['url'=>"/flats-in-{$ls}",                 'text'=>"Flats in {$l['n']}"],
                ['url'=>"/commercial-property-{$ls}",      'text'=>"Commercial Property in {$l['n']}"],
            ],
            'faq' => [
                ['q'=>"Is {$l['n']} a good area for property investment in Lucknow?",
                 'a'=>"{$l['n']} has shown {$l['ap']} property appreciation recently and offers strong rental demand. {$l['kf']}. Both residential flats and commercial spaces in {$l['n']} deliver solid investment returns."],
                ['q'=>"What type of property gives the best returns in {$l['n']}, Lucknow?",
                 'a'=>"2 BHK flats in {$l['n']} offer the best combination of rental yield (4–6% annually) and capital appreciation. Commercial ground-floor shops offer higher yield (6–9%) with strong demand from the area's high footfall near {$l['lm']}."],
            ],
        ];
    }

    // ── Template: flats-under-50-lakhs-{loc} ─────────────────────────────────
    private static function flatsUnder50LakhsPage(string $slug, string $ls, array $l): array
    {
        return [
            'title'            => "Flats Under 50 Lakhs in {$l['n']}, Lucknow | Affordable Apartments | DSD Properties",
            'meta_description' => "Buy affordable flats under 50 lakhs in {$l['n']}, Lucknow. Verified 1 & 2 BHK apartments. Best value homes. DSD Properties advisory.",
            'h1'               => "Flats Under ₹50 Lakhs in {$l['n']}, Lucknow",
            'breadcrumb_label' => "Flats Under 50L in {$l['n']}",
            'canonical'        => "/{$slug}",
            'hero_color'       => '#1e3a5f',
            'intro' => [
                "Finding a flat under ₹50 lakhs in {$l['n']}, Lucknow is possible — and DSD Properties has verified options to prove it. These are typically well-maintained 1 BHK units in established societies or compact 2 BHK apartments in older buildings, offering excellent value in a locality known for {$l['kf']}.",
                "Our budget-friendly listings in {$l['n']} cover resale flats with immediate possession, older construction with verified legal records, and occasionally newly launched 1 BHK units in emerging projects. All listings are physically visited by our team to assess condition and authenticity.",
                "Key benefits of buying a sub-₹50-lakh flat: lower home-loan EMI, stronger yield on rental income, and entry into {$l['n']}'s appreciating property market at a competitive price. Our advisors help you identify the best value options available in this budget.",
            ],
            'filters'       => array_merge(['type'=>'flat','transaction'=>'sell','max_price'=>5000000], self::lf($l)),
            'related_links' => [
                ['url'=>"/flats-under-50-lakhs-lucknow",  'text'=>"Flats Under 50L in Lucknow"],
                ['url'=>"/1-bhk-flats-{$ls}",             'text'=>"1 BHK Flats in {$l['n']}"],
                ['url'=>"/affordable-flats-{$ls}",        'text'=>"Affordable Flats in {$l['n']}"],
                ['url'=>"/flats-in-{$ls}",                'text'=>"All Flats in {$l['n']}"],
            ],
            'faq' => [
                ['q'=>"Are there flats under ₹50 lakhs in {$l['n']}, Lucknow?",
                 'a'=>"Yes, DSD Properties lists verified flats under ₹50 lakhs in {$l['n']} — typically 1 BHK or older 2 BHK units in established societies. These offer excellent value with the benefit of a well-known {$l['n']} address."],
                ['q'=>"What can I get for ₹50 lakhs in {$l['n']}, Lucknow?",
                 'a'=>"For ₹50 lakhs in {$l['n']}, you can typically find a 1 BHK flat (600–750 sq.ft) in a society with basic amenities, or an older 2 BHK in a smaller building. DSD Properties curates the best available options in this budget."],
            ],
        ];
    }

    // ── Template: luxury-flats-{loc} ─────────────────────────────────────────
    private static function luxuryFlatsPage(string $slug, string $ls, array $l): array
    {
        return [
            'title'            => "Luxury Flats in {$l['n']}, Lucknow | Premium Apartments | DSD Properties",
            'meta_description' => "Buy luxury flats in {$l['n']}, Lucknow. Premium 3 & 4 BHK apartments with club, gym, pool. {$l['p3']} to {$l['p4']}. DSD Properties.",
            'h1'               => "Luxury Flats in {$l['n']}, Lucknow",
            'breadcrumb_label' => "Luxury Flats in {$l['n']}",
            'canonical'        => "/{$slug}",
            'hero_color'       => '#011f4b',
            'intro' => [
                "Luxury flats in {$l['n']}, Lucknow represent the finest in apartment living — spacious layouts, premium finishes, and world-class amenities in a locality known for {$l['kf']}. Premium 3 BHK and 4 BHK apartments here are priced from {$l['p3']} to {$l['p4']}, attracting discerning buyers who demand the best.",
                "DSD Properties curates top-tier luxury flats in {$l['n']}: high-rise towers with panoramic views, gated communities with Olympic-size swimming pools, fully-equipped gyms, club houses, concierge services, and 24×7 security. Nearby lifestyle amenities include {$l['lm']}.",
                "Luxury properties in {$l['n']} have appreciated {$l['ap']} over recent years. Our luxury property advisors provide white-glove service — arranging private site visits, coordinating directly with premium builders, and handling all legal due diligence.",
            ],
            'filters'       => array_merge(['type'=>'flat','transaction'=>'sell','min_price'=>8000000], self::lf($l)),
            'related_links' => [
                ['url'=>"/3-bhk-flats-{$ls}",             'text'=>"3 BHK Flats in {$l['n']}"],
                ['url'=>"/4-bhk-flats-{$ls}",             'text'=>"4 BHK Flats in {$l['n']}"],
                ['url'=>"/villa-in-{$ls}",                'text'=>"Villas in {$l['n']}"],
                ['url'=>"/luxury-property-lucknow",       'text'=>"Luxury Property in Lucknow"],
            ],
            'faq' => [
                ['q'=>"What are the best luxury apartment projects in {$l['n']}, Lucknow?",
                 'a'=>"DSD Properties tracks all premium residential projects in {$l['n']}, including gated societies with club, pool, and gym. Contact us for current luxury inventory, pricing, and builder ratings in this locality."],
                ['q'=>"What amenities do luxury flats in {$l['n']} offer?",
                 'a'=>"Luxury flats in {$l['n']} typically include: swimming pool, fully-equipped gym, club house, children's play area, landscaped gardens, high-speed lifts, concierge, CCTV, and covered car parking — all within a gated, 24×7 secured campus."],
            ],
        ];
    }

    // ── Template: affordable-flats-{loc} ─────────────────────────────────────
    private static function affordableFlatsPage(string $slug, string $ls, array $l): array
    {
        return [
            'title'            => "Affordable Flats in {$l['n']}, Lucknow | Budget Apartments | DSD Properties",
            'meta_description' => "Find affordable flats in {$l['n']}, Lucknow. Budget 1 & 2 BHK apartments from {$l['p1']}. Best value homes verified by DSD Properties.",
            'h1'               => "Affordable Flats in {$l['n']}, Lucknow",
            'breadcrumb_label' => "Affordable Flats in {$l['n']}",
            'canonical'        => "/{$slug}",
            'hero_color'       => '#1e3a5f',
            'intro' => [
                "Affordable flats in {$l['n']}, Lucknow start from {$l['p1']} — giving budget-conscious buyers access to a well-connected locality that is {$l['kf']}. These are typically compact 1 BHK and 2 BHK units offering good value without compromising on location.",
                "DSD Properties specialises in finding the best affordable options in {$l['n']} — resale flats in established societies with verified legal records, LDA-scheme apartments, and affordable new launches from credible builders. All listings are vetted for fair pricing.",
                "Home loan eligibility for these properties is generally straightforward, with most banks and NBFCs approving loans up to 80–85% of the property value. Our advisors assist with loan applications and help buyers understand all costs including stamp duty and registration charges.",
            ],
            'filters'       => array_merge(['type'=>'flat','transaction'=>'sell','max_price'=>6000000], self::lf($l)),
            'related_links' => [
                ['url'=>"/flats-under-50-lakhs-{$ls}",    'text'=>"Flats Under 50L in {$l['n']}"],
                ['url'=>"/1-bhk-flats-{$ls}",             'text'=>"1 BHK Flats in {$l['n']}"],
                ['url'=>"/affordable-flats-lucknow",       'text'=>"Affordable Flats in Lucknow"],
                ['url'=>"/flats-in-{$ls}",                'text'=>"All Flats in {$l['n']}"],
            ],
            'faq' => [
                ['q'=>"What is the starting price of affordable flats in {$l['n']}, Lucknow?",
                 'a'=>"Affordable flats in {$l['n']} start from {$l['p1']} for a 1 BHK. These are typically older resale units or recently completed affordable projects with basic amenities like security and parking."],
                ['q'=>"Can I get a home loan for an affordable flat in {$l['n']}?",
                 'a'=>"Yes, most banks and housing finance companies offer home loans for affordable flats in {$l['n']}. Typical LTV is 80–85% with tenure up to 30 years. DSD Properties connects buyers with leading lenders for pre-approved loan offers."],
            ],
        ];
    }

    // ── Template: furnished-flats-{loc} ──────────────────────────────────────
    private static function furnishedFlatsPage(string $slug, string $ls, array $l): array
    {
        return [
            'title'            => "Furnished Flats in {$l['n']}, Lucknow | Fully Furnished Apartments | DSD Properties",
            'meta_description' => "Buy or rent furnished flats in {$l['n']}, Lucknow. Fully & semi-furnished 1/2/3 BHK apartments. Move-in ready. DSD Properties.",
            'h1'               => "Furnished Flats in {$l['n']}, Lucknow",
            'breadcrumb_label' => "Furnished Flats in {$l['n']}",
            'canonical'        => "/{$slug}",
            'hero_color'       => '#1a365d',
            'intro' => [
                "Furnished flats in {$l['n']}, Lucknow offer the convenience of move-in ready living — fully fitted kitchens, wardrobes, air conditioners, and sometimes complete furniture packages. {$l['n']} is {$l['kf']}, and furnished apartments here are popular with corporate employees, NRIs visiting Lucknow, and families relocating on short notice.",
                "DSD Properties lists both fully-furnished and semi-furnished flats in {$l['n']}: from apartments with complete furniture and appliances (fridge, washing machine, microwave) to semi-furnished units with built-in wardrobes and modular kitchen. Monthly rents range from {$l['r1']} to {$l['r3']} for furnished units.",
                "Whether you're looking to buy a furnished flat as a long-term investment with high rental appeal, or rent one immediately, our team matches you with the right property. We verify furnishing inventories and ensure lease agreements clearly list all included items.",
            ],
            'filters'       => array_merge(['type'=>'flat','furnishing'=>'fully_furnished'], self::lf($l)),
            'related_links' => [
                ['url'=>"/flats-in-{$ls}",                 'text'=>"Buy Flats in {$l['n']}"],
            ],
            'faq' => [
                ['q'=>"What is the rent for a furnished flat in {$l['n']}, Lucknow?",
                 'a'=>"Furnished flats in {$l['n']} rent for {$l['r1']} (1 BHK) to {$l['r3']} (3 BHK) per month. Fully furnished units command 20–35% higher rent than unfurnished equivalents due to the convenience factor."],
                ['q'=>"What is included in a furnished flat in {$l['n']}?",
                 'a'=>"A fully furnished flat typically includes: bed frames with mattress, sofa, dining table, wardrobes, modular kitchen with appliances (fridge, microwave, washing machine), air conditioners, geysers, and curtains. Semi-furnished includes wardrobes, modular kitchen, and fans only."],
            ],
        ];
    }

    // ── Template: semi-furnished-flats-{loc} ─────────────────────────────────
    private static function semiFurnishedFlatsPage(string $slug, string $ls, array $l): array
    {
        return [
            'title'            => "Semi Furnished Flats in {$l['n']}, Lucknow | DSD Properties",
            'meta_description' => "Find semi-furnished flats in {$l['n']}, Lucknow. Wardrobes, modular kitchen, fans included. Buy or rent. Verified by DSD Properties.",
            'h1'               => "Semi-Furnished Flats in {$l['n']}, Lucknow",
            'breadcrumb_label' => "Semi-Furnished in {$l['n']}",
            'canonical'        => "/{$slug}",
            'hero_color'       => '#2d3748',
            'intro' => [
                "Semi-furnished flats in {$l['n']}, Lucknow are the most popular rental choice — they come with wardrobes, modular kitchen, fans, and sometimes an air conditioner, allowing tenants to add their own furniture at lower rent than a fully-furnished unit. {$l['n']} is {$l['kf']}, with strong demand for semi-furnished rentals from working professionals.",
                "DSD Properties lists semi-furnished flats for rent and sale in {$l['n']}. Semi-furnished rentals range from {$l['r1']} (1 BHK) to {$l['r3']} (3 BHK), offering a middle ground between bare unfurnished units and costly fully-furnished apartments.",
                "When buying a semi-furnished flat for investment in {$l['n']}, these properties attract a wider pool of tenants than unfurnished units, resulting in lower vacancy periods. Our advisors can also guide you on cost-effective furnishing to maximise rental yield.",
            ],
            'filters'       => array_merge(['type'=>'flat','furnishing'=>'semi_furnished'], self::lf($l)),
            'related_links' => [
                ['url'=>"/furnished-flats-{$ls}",          'text'=>"Furnished Flats in {$l['n']}"],
                ['url'=>"/flats-in-{$ls}",                 'text'=>"Buy Flats in {$l['n']}"],
            ],
            'faq' => [
                ['q'=>"What does a semi-furnished flat include in {$l['n']}, Lucknow?",
                 'a'=>"A semi-furnished flat in {$l['n']} typically includes: built-in wardrobes, modular kitchen with chimney/hob, ceiling fans in all rooms, geysers, and sometimes one split AC. Major furniture items like sofa, bed, and dining table are not included."],
                ['q'=>"Is a semi-furnished flat a good investment in {$l['n']}?",
                 'a'=>"Yes — semi-furnished flats in {$l['n']} attract a broader tenant pool than unfurnished units and command 10–20% higher rent. The cost of semi-furnishing (₹2–5 lakh) is typically recovered within 2–3 years through higher rent."],
            ],
        ];
    }

    // ── Template: residential-plots-{loc} ────────────────────────────────────
    private static function residentialPlotsPage(string $slug, string $ls, array $l): array
    {
        return [
            'title'            => "Residential Plots in {$l['n']}, Lucknow | Build Your Home | DSD Properties",
            'meta_description' => "Buy residential plots in {$l['n']}, Lucknow. LDA-approved and freehold plots {$l['pp']}. Build your dream home. DSD Properties.",
            'h1'               => "Residential Plots in {$l['n']}, Lucknow",
            'breadcrumb_label' => "Residential Plots in {$l['n']}",
            'canonical'        => "/{$slug}",
            'hero_color'       => '#064e3b',
            'intro' => [
                "A residential plot in {$l['n']}, Lucknow gives you the freedom to build your dream home exactly the way you want it — the right floor plan, the preferred materials, and the layout that suits your family's lifestyle. Plots in {$l['n']} are priced from {$l['pp']}, and the locality is {$l['kf']}.",
                "DSD Properties lists approved residential plots in {$l['n']}: plots in LDA colonies, RERA-registered layout plots, and freehold plots with clear chain of title. All plots are vetted for residential land-use classification, approved layout status, and road width compliance.",
                "Building on your own plot in {$l['n']} allows you to maximise usable floor area within permissible FAR (Floor Area Ratio) rules, create basement parking, and design a home that reflects your personal taste. Our team assists with plot selection, legal verification, and connecting you with trusted architects and builders.",
            ],
            'filters'       => array_merge(['type'=>'plot','transaction'=>'sell'], self::lf($l)),
            'related_links' => [
                ['url'=>"/plots-in-{$ls}",                 'text'=>"All Plots in {$l['n']}"],
                ['url'=>"/plots-for-sale-{$ls}",           'text'=>"Plots for Sale in {$l['n']}"],
                ['url'=>"/residential-plots-lucknow",      'text'=>"Residential Plots in Lucknow"],
                ['url'=>"/lda-approved-plots-lucknow",     'text'=>"LDA Approved Plots"],
            ],
            'faq' => [
                ['q'=>"What size residential plots are available in {$l['n']}, Lucknow?",
                 'a'=>"Residential plots in {$l['n']} range from 100–500 sq.yd. The most popular sizes for self-construction are 150–250 sq.yd, which allow a comfortable G+2 house with adequate setbacks and parking."],
                ['q'=>"Can I build a G+3 house on a residential plot in {$l['n']}?",
                 'a'=>"Building height permissions depend on the plot size, road width, and LDA/MC building bylaws. In most {$l['n']} residential zones, G+2 is standard. G+3 requires a wider road frontage and may need special permissions. DSD Properties guides buyers on permissible construction."],
            ],
        ];
    }

    // ── Template: under-construction-flats-{loc} ─────────────────────────────
    private static function underConstructionPage(string $slug, string $ls, array $l): array
    {
        return [
            'title'            => "Under Construction Flats in {$l['n']}, Lucknow | Pre-Launch Deals | DSD Properties",
            'meta_description' => "Under construction flats in {$l['n']}, Lucknow at pre-launch prices. RERA-registered projects. 1/2/3 BHK from {$l['p1']}. DSD Properties.",
            'h1'               => "Under Construction Flats in {$l['n']}, Lucknow",
            'breadcrumb_label' => "Under Construction in {$l['n']}",
            'canonical'        => "/{$slug}",
            'hero_color'       => '#1a3a6b',
            'intro' => [
                "Under-construction flats in {$l['n']}, Lucknow allow buyers to secure a flat at today's price in tomorrow's premium location. {$l['n']} is {$l['kf']} — making pre-launch investments particularly attractive for buyers expecting {$l['ap']} appreciation by possession.",
                "DSD Properties tracks all active under-construction projects in {$l['n']}: RERA-registered residential towers, gated society developments, and affordable housing schemes from credible builders. Starting prices from {$l['p1']} with flexible milestone-based payment plans.",
                "When considering an under-construction flat in {$l['n']}, our advisors help you verify the RERA registration number (uprera.gov.in), assess builder track record, review construction progress, and structure a payment plan that minimises risk while maximising price advantage.",
            ],
            'filters'       => array_merge(['type'=>'flat','transaction'=>'sell','age'=>'new_construction'], self::lf($l)),
            'related_links' => [
                ['url'=>"/ready-to-move-flats-{$ls}",      'text'=>"Ready to Move in {$l['n']}"],
                ['url'=>"/new-projects-{$ls}",             'text'=>"New Projects in {$l['n']}"],
                ['url'=>"/flats-in-{$ls}",                 'text'=>"All Flats in {$l['n']}"],
                ['url'=>"/new-projects-lucknow",           'text'=>"All New Projects in Lucknow"],
            ],
            'faq' => [
                ['q'=>"Is it safe to buy an under-construction flat in {$l['n']}, Lucknow?",
                 'a'=>"It is safe when the project is RERA-registered with a clear possession date, the builder has a proven delivery record, and payments are milestone-linked. DSD Properties verifies all these factors and only recommends credible under-construction projects in {$l['n']}."],
                ['q'=>"What is the price advantage of buying under-construction vs ready-to-move in {$l['n']}?",
                 'a'=>"Under-construction flats in {$l['n']} are typically priced 10–20% lower than completed ready-to-move units. Combined with the locality's {$l['ap']} annual appreciation, early buyers often see significant value gain by possession time."],
            ],
        ];
    }

    // ── Template: office-space-{loc} ─────────────────────────────────────────
    private static function officeSpacePage(string $slug, string $ls, array $l): array
    {
        return [
            'title'            => "Office Space in {$l['n']}, Lucknow | Commercial Office for Sale/Rent | DSD Properties",
            'meta_description' => "Buy or rent office space in {$l['n']}, Lucknow. Well-located offices, co-working spaces, showrooms. Expert commercial advisory by DSD Properties.",
            'h1'               => "Office Space in {$l['n']}, Lucknow",
            'breadcrumb_label' => "Office Space in {$l['n']}",
            'canonical'        => "/{$slug}",
            'hero_color'       => '#1a365d',
            'intro' => [
                "{$l['n']}'s reputation as {$l['kf']} makes it a premium destination for business office space. Companies choosing {$l['n']} for their Lucknow office benefit from excellent visibility, strong talent pool access, and proximity to {$l['lm']} — all critical factors for business success.",
                "DSD Properties lists commercial office spaces in {$l['n']}: furnished plug-and-play offices in commercial complexes, bare-shell offices for custom fit-out, showrooms with high street visibility, and co-working memberships. Both purchase and rental options are available.",
                "Commercial properties in {$l['n']} offer rental yields of 6–9% annually — significantly higher than residential. Our commercial property advisors assess foot-traffic, parking availability, and infrastructure quality before recommending any office space.",
            ],
            'filters'       => array_merge(['type'=>'office','transaction'=>'sell'], self::lf($l)),
            'related_links' => [
                ['url'=>"/commercial-property-{$ls}",      'text'=>"All Commercial in {$l['n']}"],
                ['url'=>"/commercial-property-lucknow",    'text'=>"Commercial Property in Lucknow"],
                ['url'=>"/investment-property-{$ls}",      'text'=>"Investment Property in {$l['n']}"],
            ],
            'faq' => [
                ['q'=>"What is the rent for office space in {$l['n']}, Lucknow?",
                 'a'=>"Office rent in {$l['n']} depends on location, size, and furnishing. Ground-floor offices on main roads command premium rents, while upper-floor offices in commercial complexes are more affordable. Contact DSD Properties for current availability and pricing."],
                ['q'=>"Is it better to buy or rent office space in {$l['n']}, Lucknow?",
                 'a'=>"For established businesses with stable space requirements, buying office space in {$l['n']} builds equity and eliminates rent escalation risk. For startups and businesses in growth phase, renting provides flexibility. DSD Properties advises based on your business cashflow and long-term plans."],
            ],
        ];
    }

    // ── Template: lda-approved-plots-{loc} ───────────────────────────────────
    private static function ldaApprovedPlotsPage(string $slug, string $ls, array $l): array
    {
        return [
            'title'            => "LDA Approved Plots in {$l['n']}, Lucknow | Secure Investment | DSD Properties",
            'meta_description' => "Buy LDA approved plots in {$l['n']}, Lucknow. Government-authorized plots with clear titles. Verified by DSD Properties. Expert advisory.",
            'h1'               => "LDA Approved Plots in {$l['n']}, Lucknow",
            'breadcrumb_label' => "LDA Plots in {$l['n']}",
            'canonical'        => "/{$slug}",
            'hero_color'       => '#064e3b',
            'intro' => [
                "LDA-approved plots in {$l['n']}, Lucknow are the most secure form of land investment — authorised by the Lucknow Development Authority with verified land-use classification, approved layout plans, and guaranteed legal title. These plots are highly sought after due to their clarity and bank-loan eligibility.",
                "DSD Properties lists both original LDA allotment plots and resale LDA-approved plots in {$l['n']}. Our team verifies the LDA registration number, allotment letter, and any transfer history before listing. Key landmarks in the area: {$l['lm']}.",
                "Plot prices in {$l['n']} range from {$l['pp']}. LDA-approved plots command a slight premium over private layout plots but offer significantly lower legal risk and higher resale liquidity — essential for both end-use buyers and investors.",
            ],
            'filters'       => array_merge(['type'=>'plot','transaction'=>'sell'], self::lf($l)),
            'related_links' => [
                ['url'=>"/lda-approved-plots-lucknow",     'text'=>"LDA Plots in Lucknow"],
                ['url'=>"/plots-in-{$ls}",                 'text'=>"All Plots in {$l['n']}"],
                ['url'=>"/residential-plots-{$ls}",        'text'=>"Residential Plots in {$l['n']}"],
                ['url'=>"/lda-schemes",                    'text'=>"LDA Schemes 2025"],
            ],
            'faq' => [
                ['q'=>"What is an LDA-approved plot in {$l['n']}, Lucknow?",
                 'a'=>"An LDA-approved plot is a residential or commercial plot located in a layout that has been approved by the Lucknow Development Authority. These plots have verified land use, proper road access, and clear legal title — making them eligible for home loans and safer to purchase than private layouts."],
                ['q'=>"How do I verify if a plot in {$l['n']} is LDA-approved?",
                 'a'=>"You can verify LDA approval by checking the LDA approval number on lda.up.nic.in, matching the plot number with the approved layout map, and cross-referencing the mutation/registry records. DSD Properties handles all verification as part of our buying assistance service."],
            ],
        ];
    }

    // ════════════════════════════════════════════════════════════════════════
    // PAGE FACTORY — merges manual pages with all programmatic generations
    // ════════════════════════════════════════════════════════════════════════
    public static function buildPages(): array
    {
        static $cache = null;
        if ($cache !== null) return $cache;

        $cache = static::$manualPages;

        foreach (static::$loc as $ls => $l) {
            // BHK × Locality — sell
            foreach ([1, 2, 3, 4] as $b) {
                $s = "{$b}-bhk-flats-{$ls}";
                if (!isset($cache[$s])) $cache[$s] = self::bhkSellPage($s, $ls, $b, $l);
            }
            // Category × Locality
            foreach ([
                "flats-in-{$ls}"                  => [self::class, 'flatsInPage'],
                "plots-in-{$ls}"                  => [self::class, 'plotsInPage'],
                "plots-for-sale-{$ls}"            => [self::class, 'plotsForSalePage'],
                "property-in-{$ls}"               => [self::class, 'propertyInPage'],
                "house-for-sale-{$ls}"            => [self::class, 'houseForSalePage'],
                "villa-in-{$ls}"                  => [self::class, 'villaInPage'],
                "builder-floor-{$ls}"             => [self::class, 'builderFloorPage'],
                "commercial-property-{$ls}"       => [self::class, 'commercialPage'],
                "new-projects-{$ls}"              => [self::class, 'newProjectsPage'],
                "ready-to-move-flats-{$ls}"       => [self::class, 'readyToMovePage'],
                "investment-property-{$ls}"       => [self::class, 'investmentPage'],
                "flats-under-50-lakhs-{$ls}"      => [self::class, 'flatsUnder50LakhsPage'],
                "luxury-flats-{$ls}"              => [self::class, 'luxuryFlatsPage'],
                "affordable-flats-{$ls}"          => [self::class, 'affordableFlatsPage'],
                "furnished-flats-{$ls}"           => [self::class, 'furnishedFlatsPage'],
                "semi-furnished-flats-{$ls}"      => [self::class, 'semiFurnishedFlatsPage'],
                "residential-plots-{$ls}"         => [self::class, 'residentialPlotsPage'],
                "under-construction-flats-{$ls}"  => [self::class, 'underConstructionPage'],
                "office-space-{$ls}"              => [self::class, 'officeSpacePage'],
                "lda-approved-plots-{$ls}"        => [self::class, 'ldaApprovedPlotsPage'],
            ] as $s => $fn) {
                if (!isset($cache[$s])) $cache[$s] = $fn($s, $ls, $l);
            }
        }

        return $cache;
    }

    /** Returns every valid SEO landing slug — used by route regex and sitemap */
    public static function getSlugs(): array
    {
        return array_keys(static::buildPages());
    }

    /**
     * The rental landing pages were retired when letting was dropped from the site. Their
     * URLs were indexed, so each one is permanently redirected to the closest page that
     * still exists rather than being left to 404.
     *
     * @return array<string,string> old slug => new path
     */
    public static function retiredRedirects(): array
    {
        static $map = null;
        if ($map !== null) return $map;

        $map = [
            'flats-for-rent-lucknow'   => '/flats-in-lucknow',
            'rent-property-lucknow'    => '/properties',
            'flats-for-rent-gomti-nagar' => '/flats-in-gomti-nagar',
            'flats-for-rent-aliganj'     => '/flats-in-aliganj',
            'flats-for-rent-indiranagar' => '/flats-in-indiranagar',
        ];

        foreach (array_keys(static::$loc) as $ls) {
            // "2 BHK for rent in X" → the equivalent sale page for that configuration.
            foreach ([1, 2, 3, 4] as $b) {
                $map["{$b}-bhk-flat-for-rent-{$ls}"] = "/{$b}-bhk-flats-{$ls}";
            }
            $map["flats-for-rent-{$ls}"]          = "/flats-in-{$ls}";
            $map["furnished-flat-for-rent-{$ls}"] = "/furnished-flats-{$ls}";
        }

        // Never point at a page that no longer exists.
        $valid = array_flip(static::getSlugs());
        foreach ($map as $from => $to) {
            $target = ltrim($to, '/');
            if ($target !== 'properties' && ! isset($valid[$target])) {
                $map[$from] = '/properties';
            }
        }

        return $map;
    }

    // ════════════════════════════════════════════════════════════════════════
    // ROUTE HANDLER
    // ════════════════════════════════════════════════════════════════════════
    public function show(string $seoPage)
    {
        $pages  = static::buildPages();
        $config = $pages[$seoPage] ?? null;
        abort_unless($config, 404);

        if ($seoPage === 'property-in-saumitra-vihar') {
            return view('pages.saumitra-vihar-yojna');
        }

        $query   = PropertyListing::published()->with('images');
        $filters = $config['filters'] ?? [];

        if (!empty($filters['type']))        $query->where('property_type',    $filters['type']);
        if (!empty($filters['transaction'])) $query->where('transaction_type', $filters['transaction']);
        if (!empty($filters['locality']))    $query->where('locality', 'like', '%'.$filters['locality'].'%');
        if (isset($filters['min_price']))    $query->where('price', '>=', (int)$filters['min_price']);
        if (isset($filters['max_price']))    $query->where('price', '<=', (int)$filters['max_price']);
        if (isset($filters['bedrooms']))     $query->where('bedrooms', (int)$filters['bedrooms']);
        if (!empty($filters['age']))         $query->where('property_age', $filters['age']);
        if (!empty($filters['furnishing']))  $query->where('furnishing', $filters['furnishing']);

        if (!empty($filters['tag'])) {
            $query->whereHas('tags', fn($q) => $q->where('slug', $filters['tag']));
        }

        $listings = $query->latest()->paginate(12)->withQueryString();

        return view('pages.seo-landing', array_merge($config, [
            'listings' => $listings,
            'pageSlug' => $seoPage,
        ]));
    }
}
