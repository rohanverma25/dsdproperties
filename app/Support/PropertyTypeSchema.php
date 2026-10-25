<?php

namespace App\Support;

/**
 * Single source of truth for which fields each property type actually needs.
 *
 * A plot has no bedrooms, agricultural land is measured in bigha and cares about
 * irrigation, a warehouse cares about ceiling height. Keeping that knowledge in one
 * place means the seller form, the validator and the public listing page can never
 * drift apart.
 *
 * Core fields (bedrooms, floor_no, furnishing …) live in their own columns on
 * property_listings. Everything type-specific lives in the `type_details` JSON column
 * and is described here by `extras`.
 */
class PropertyTypeSchema
{
    /* ── Option lists reused across types ── */

    public const FACINGS = ['North', 'South', 'East', 'West', 'North-East', 'North-West', 'South-East', 'South-West'];

    public const PARKING = ['None', 'Covered (1)', 'Covered (2)', 'Open (1)', 'Open (2)', '2-Wheeler Only', 'Both'];

    public const YES_NO = ['Yes', 'No'];

    /**
     * The three top-level categories the seller picks first. Order here is the order they
     * are shown in. A plot is listed under Residential and industrial land under
     * Commercial, because that is how a seller thinks about who will buy it.
     */
    public const GROUPS = [
        'residential'  => ['label' => 'Residential',              'icon' => '🏠'],
        'plot'         => ['label' => 'Residential Plot Projects', 'icon' => '📐'],
        'commercial'   => ['label' => 'Commercial',               'icon' => '🏢'],
        'agricultural' => ['label' => 'Agricultural Land',        'icon' => '🌾'],
    ];

    /** Area units, keyed as stored. */
    public const AREA_UNITS = [
        'sqft'    => 'sq.ft',
        'sqyard'  => 'sq.yd',
        'sqmtr'   => 'sq.m',
        'bigha'   => 'Bigha',
        'biswa'   => 'Biswa',
        'acre'    => 'Acre',
        'hectare' => 'Hectare',
    ];

    /** Amenity checkbox sets, referenced by type via `amenities`. */
    public const AMENITY_SETS = [
        'apartment' => [
            'Lift', 'Power Backup', 'Security / Guard', 'CCTV', 'Car Parking',
            '2-Wheeler Parking', 'Visitor Parking', 'Swimming Pool', 'Gym / Fitness',
            'Club House', 'Children Play Area', 'Garden / Park', 'Intercom',
            'Water Supply 24×7', 'Gas Pipeline', 'Modular Kitchen', 'Maintenance Staff',
            'Fire Safety', 'Rain Water Harvesting', 'Servant Room', 'Study Room',
            'Vastu Compliant',
        ],
        'house' => [
            'Car Parking', '2-Wheeler Parking', 'Power Backup', 'Security / Guard', 'CCTV',
            'Boundary Wall', 'Garden / Lawn', 'Terrace', 'Modular Kitchen',
            'Borewell / Submersible', 'Water Supply 24×7', 'Gas Pipeline',
            'Servant Room', 'Study Room', 'Puja Room', 'Solar Panels',
            'Rain Water Harvesting', 'Gated Colony', 'Vastu Compliant',
        ],
        'plot' => [
            'Boundary Wall', 'Gated Colony', 'Corner Plot', 'Park Facing',
            'Wide Approach Road', 'Street Lights', 'Sewer Line', 'Water Connection',
            'Electricity Connection', 'Security / Guard', 'Registry Ready',
            'Loan Available', 'Vastu Compliant',
        ],
        // Agricultural land is listed without a feature checklist — the description
        // carries whatever matters instead.
        'agricultural' => [],
        'commercial' => [
            'Lift', 'Power Backup', 'Central AC', 'Reception Area', 'Pantry / Cafeteria',
            'Washrooms', 'CCTV', 'Security / Guard', 'Fire Safety', 'Car Parking',
            'Visitor Parking', 'Conference Room', 'Internet / Leased Line',
            'Main Road Facing', 'Escalator', 'Furnished Cabins',
        ],
        'industrial' => [
            'Boundary Wall', 'Loading / Unloading Dock', 'Heavy Power Load',
            'Water Connection', '24×7 Access', 'Security / Guard', 'CCTV', 'Fire Safety',
            'Truck Accessible Road', 'Office Cabin', 'Washrooms', 'Weigh Bridge',
            'Highway Touch',
        ],
        'pg' => [
            'Wi-Fi', 'Meals Included', 'Laundry', 'Housekeeping', 'Power Backup',
            'Attached Washroom', 'AC Rooms', 'Study Table', 'Wardrobe',
            'Common TV Area', 'RO Water', 'Security / Guard', 'CCTV', 'Parking',
        ],
    ];

    /* ── Extra-field groups reused across types ── */

    private static function plotDimensionExtras(): array
    {
        return [
            ['key' => 'plot_length',   'label' => 'Plot Length',         'type' => 'number', 'suffix' => 'ft', 'placeholder' => 'e.g. 60'],
            ['key' => 'plot_width',    'label' => 'Plot Width',          'type' => 'number', 'suffix' => 'ft', 'placeholder' => 'e.g. 30'],
            ['key' => 'road_width',    'label' => 'Approach Road Width', 'type' => 'number', 'suffix' => 'ft', 'placeholder' => 'e.g. 24'],
            ['key' => 'open_sides',    'label' => 'Open Sides',          'type' => 'select', 'options' => ['1', '2', '3', '4']],
            ['key' => 'boundary_wall', 'label' => 'Boundary Wall',       'type' => 'select', 'options' => self::YES_NO],
        ];
    }

    private static function approvalExtras(): array
    {
        return [
            ['key' => 'approval_authority', 'label' => 'Approval / Authority', 'type' => 'select',
             'options' => ['LDA Approved', 'Awas Vikas', 'Nagar Nigam', 'Gram Panchayat', 'RERA Registered', 'Freehold — Unapproved', 'Other'],
             'hint' => 'Buyers filter heavily on this — it builds trust.'],
            ['key' => 'ownership', 'label' => 'Ownership Type', 'type' => 'select',
             'options' => ['Freehold', 'Leasehold', 'Power of Attorney', 'Co-operative Society']],
            ['key' => 'khasra_no', 'label' => 'Khasra / Plot No.', 'type' => 'text', 'placeholder' => 'e.g. 214/3'],
        ];
    }

    /**
     * Approvals for a plot project. `show_if` keeps the RERA number hidden until the
     * seller says the project is RERA approved.
     */
    /**
     * Residential Plot Projects are listed by a developer for the whole project, not for
     * one plot, so everything here describes the site as a whole. Per-plot facts (exact
     * length, width, facing, open sides) belong to the individual plot segments instead,
     * which the seller adds in the plot configuration table.
     *
     * `show_if` keeps the RERA number hidden until the project is marked RERA approved.
     */
    private static function plotProjectExtras(): array
    {
        return [
            ['key' => 'developer_name', 'label' => 'Developer / Promoter Name', 'type' => 'text',
             'placeholder' => 'e.g. Omaxe Ltd.'],
            ['key' => 'project_status', 'label' => 'Project Status', 'type' => 'select',
             'options' => ['Pre-Launch', 'Open for Booking', 'Registry Ready', 'Possession Given', 'Sold Out']],

            // Approvals — a project can hold several at once, so these are separate questions.
            ['key' => 'rera_approved', 'label' => 'RERA Approved', 'type' => 'select', 'options' => self::YES_NO],
            ['key' => 'rera_number',   'label' => 'RERA Registration Number', 'type' => 'text',
             'placeholder' => 'e.g. UPRERAPRJ123456',
             'show_if' => ['key' => 'rera_approved', 'value' => 'Yes']],
            ['key' => 'zila_panchayat_approved', 'label' => 'Zila Panchayat Approved', 'type' => 'select', 'options' => self::YES_NO],
            ['key' => 'lda_approved', 'label' => 'LDA Approved', 'type' => 'select', 'options' => self::YES_NO],

            // Commercials the whole project is sold on.
            ['key' => 'rate_per_unit', 'label' => 'Rate (₹ per sq.ft)', 'type' => 'number',
             'placeholder' => 'e.g. 2500', 'hint' => 'Buyers compare projects on rate more than on total price.'],
            ['key' => 'booking_amount', 'label' => 'Booking Amount (₹)', 'type' => 'number', 'placeholder' => 'e.g. 51000'],

            // Site layout.
            ['key' => 'internal_road_width', 'label' => 'Internal Road Width', 'type' => 'number', 'suffix' => 'ft', 'placeholder' => 'e.g. 30'],
            ['key' => 'min_road_width',      'label' => 'Minimum Road Width', 'type' => 'number', 'suffix' => 'ft', 'placeholder' => 'e.g. 20'],
            ['key' => 'approach_road_width', 'label' => 'Main Approach Road Width', 'type' => 'number', 'suffix' => 'ft', 'placeholder' => 'e.g. 60'],
            ['key' => 'land_use', 'label' => 'Land Use Zone (LDA Master Plan 2031)', 'type' => 'select',
             'options' => ['Residential', 'Mixed Use', 'Commercial Permitted', 'Institutional']],
        ];
    }

    private static function builtUpExtras(): array
    {
        return [
            ['key' => 'carpet_area',   'label' => 'Carpet Area',   'type' => 'number', 'suffix' => 'sq.ft', 'placeholder' => 'e.g. 980'],
            ['key' => 'built_up_area', 'label' => 'Built-up Area', 'type' => 'number', 'suffix' => 'sq.ft', 'placeholder' => 'e.g. 1250'],
        ];
    }

    /**
     * The site sells only. Kept as an empty list so the rent-aware call sites stay valid
     * if letting ever has to come back.
     */
    public static function rentExtras(): array
    {
        return [];
    }

    /**
     * Every property type, with exactly the fields it needs.
     *
     * core       — own-column fields that apply to this type
     * required   — subset of core the seller must fill
     * units      — allowed area units, first one is the default
     * area_label — what "area" means for this type
     * extras     — type_details fields
     */
    public static function types(): array
    {
        $residentialCore = ['bedrooms', 'bathrooms', 'balconies', 'furnishing', 'property_age', 'facing', 'parking'];

        return [
            'flat' => [
                'label'      => 'Flat / Apartment',
                'icon'       => '🏢',
                'group'      => 'residential',
                'core'       => array_merge($residentialCore, ['floor_no', 'total_floors']),
                'required'   => ['bedrooms', 'bathrooms', 'furnishing'],
                'units'      => ['sqft', 'sqmtr', 'sqyard'],
                'title_label'       => 'Property Title',
                'title_placeholder' => 'e.g. 3 BHK Flat in Gomti Nagar',
                'area_label' => 'Super Built-up Area',
                'amenities'  => 'apartment',
                'allow_site' => false,
                'extras'     => array_merge(self::builtUpExtras(), [
                    ['key' => 'ownership', 'label' => 'Ownership Type', 'type' => 'select',
                     'options' => ['Freehold', 'Leasehold', 'Power of Attorney', 'Co-operative Society']],
                    ['key' => 'possession_status', 'label' => 'Possession Status', 'type' => 'select',
                     'options' => ['Ready to Move', 'Under Construction']],
                    ['key' => 'project_name', 'label' => 'Project / Society Name', 'type' => 'text', 'placeholder' => 'e.g. Eldeco Elegante'],
                    ['key' => 'rera_id', 'label' => 'RERA Registration No.', 'type' => 'text', 'placeholder' => 'UPRERAPRJ…'],
                ]),
            ],


            'house' => [
                'label'      => 'House / Kothi',
                'icon'       => '🏠',
                'group'      => 'residential',
                'core'       => array_merge($residentialCore, ['total_floors']),
                'required'   => ['bedrooms', 'bathrooms'],
                'units'      => ['sqyard', 'sqft', 'sqmtr'],
                'title_label'       => 'Property Title',
                'title_placeholder' => 'e.g. 4 BHK Kothi in Indira Nagar',
                'area_label' => 'Plot Area',
                'amenities'  => 'house',
                'allow_site' => false,
                'extras'     => array_merge(self::builtUpExtras(), self::approvalExtras(), [
                    ['key' => 'road_width', 'label' => 'Front Road Width', 'type' => 'number', 'suffix' => 'ft', 'placeholder' => 'e.g. 30'],
                ]),
            ],

            'villa' => [
                'label'      => 'Villa',
                'icon'       => '🏡',
                'group'      => 'residential',
                'core'       => array_merge($residentialCore, ['total_floors']),
                'required'   => ['bedrooms', 'bathrooms'],
                'units'      => ['sqft', 'sqyard', 'sqmtr'],
                'title_label'       => 'Property Title',
                'title_placeholder' => 'e.g. 4 BHK Villa in Sushant Golf City',
                'area_label' => 'Built-up Area',
                'amenities'  => 'apartment',
                'allow_site' => false,
                'extras'     => array_merge(self::builtUpExtras(), [
                    ['key' => 'plot_area',    'label' => 'Plot Area', 'type' => 'number', 'suffix' => 'sq.yd', 'placeholder' => 'e.g. 300'],
                    ['key' => 'project_name', 'label' => 'Project / Township Name', 'type' => 'text'],
                    ['key' => 'ownership',    'label' => 'Ownership Type', 'type' => 'select',
                     'options' => ['Freehold', 'Leasehold', 'Power of Attorney']],
                    ['key' => 'private_pool', 'label' => 'Private Pool', 'type' => 'select', 'options' => self::YES_NO],
                ]),
            ],


            'plot' => [
                'label'      => 'Residential Plot Projects',
                'icon'       => '📐',
                'group'      => 'plot',
                'core'       => [],
                'required'   => [],
                'units'      => ['acre', 'bigha', 'sqyard', 'sqmtr', 'sqft'],
                'title_min'         => 3,
                'title_label'       => 'Site Name',
                'title_placeholder' => 'e.g. Omaxe City',
                'area_label' => 'Total Project Area',
                'amenities'  => 'plot',
                'allow_site' => true,
                'extras'     => self::plotProjectExtras(),

            ],

            'farmhouse' => [
                'label'      => 'Farm House',
                'icon'       => '🌳',
                'group'      => 'residential',
                'core'       => ['bedrooms', 'bathrooms', 'furnishing', 'property_age', 'facing', 'parking', 'total_floors'],
                'required'   => [],
                'units'      => ['sqyard', 'bigha', 'acre', 'sqft'],
                'title_min'         => 3,
                'title_label'       => 'Farm House Name',
                'title_placeholder' => 'e.g. 2 Acre Farm House on Sitapur Road',
                'area_label' => 'Total Land Area',
                'amenities'  => 'house',
                'allow_site' => false,
                'extras'     => [
                    ['key' => 'built_up_area', 'label' => 'Constructed Area', 'type' => 'number', 'suffix' => 'sq.ft'],
                    ['key' => 'water_source',  'label' => 'Water Source', 'type' => 'select',
                     'options' => ['Borewell / Submersible', 'Municipal Supply', 'Canal', 'Well', 'None']],
                    ['key' => 'road_width',    'label' => 'Approach Road Width', 'type' => 'number', 'suffix' => 'ft'],
                    ['key' => 'ownership',     'label' => 'Ownership Type', 'type' => 'select',
                     'options' => ['Freehold', 'Leasehold', 'Power of Attorney']],
                ],
            ],
            'agricultural_land' => [
                'label'      => 'Agricultural Land',
                'icon'       => '🌾',
                'group'      => 'agricultural',
                'core'       => ['facing'],
                'required'   => [],
                'units'      => ['bigha', 'acre', 'hectare', 'biswa', 'sqyard'],
                'title_label'       => 'Land Title',
                'title_placeholder' => 'e.g. 12 Bigha Farmland near Nagram Road',
                'area_label' => 'Land Area',
                'amenities'  => 'agricultural',
                'allow_site' => false,
                'extras'     => [],
            ],


            'office' => [
                'label'      => 'Office Space',
                'icon'       => '🏛',
                'group'      => 'commercial',
                'core'       => ['bathrooms', 'floor_no', 'total_floors', 'furnishing', 'property_age', 'facing', 'parking'],
                'required'   => ['furnishing'],
                'units'      => ['sqft', 'sqmtr', 'sqyard'],
                'title_label'       => 'Property Title',
                'title_placeholder' => 'e.g. 2000 sq.ft Office in Vibhuti Khand',
                'area_label' => 'Built-up Area',
                'amenities'  => 'commercial',
                'allow_site' => false,
                'extras'     => array_merge(self::builtUpExtras(), [
                    ['key' => 'seats',         'label' => 'Seating Capacity', 'type' => 'number', 'placeholder' => 'e.g. 40'],
                    ['key' => 'cabins',        'label' => 'Cabins', 'type' => 'number'],
                    ['key' => 'meeting_rooms', 'label' => 'Meeting Rooms', 'type' => 'number'],
                    ['key' => 'pantry',        'label' => 'Pantry', 'type' => 'select', 'options' => self::YES_NO],
                    ['key' => 'project_name',  'label' => 'Building / Complex Name', 'type' => 'text'],
                    ['key' => 'ownership',     'label' => 'Ownership Type', 'type' => 'select', 'options' => ['Freehold', 'Leasehold']],
                ]),
            ],

            'shop' => [
                'label'      => 'Shop / Showroom',
                'icon'       => '🏪',
                'group'      => 'commercial',
                'core'       => ['floor_no', 'furnishing'],
                'required'   => [],
                'units'      => ['sqft', 'sqmtr', 'sqyard'],
                'title_label'       => 'Shop / Showroom Title',
                'title_placeholder' => 'e.g. Corner Shop in Aliganj Market',
                'area_label' => 'Carpet Area',
                'amenities'  => 'commercial',
                'allow_site' => false,
                // Carpet area is already the main Area field for a shop, so it is not
                // asked again here.
                'extras'     => [
                    ['key' => 'frontage',     'label' => 'Shop Frontage', 'type' => 'number', 'suffix' => 'ft', 'placeholder' => 'e.g. 15'],
                    ['key' => 'corner_unit',  'label' => 'Corner Unit', 'type' => 'select', 'options' => self::YES_NO],
                    ['key' => 'main_road',    'label' => 'Main Road Facing', 'type' => 'select', 'options' => self::YES_NO],
                    ['key' => 'suitable_for', 'label' => 'Ideally Suited For', 'type' => 'text', 'placeholder' => 'e.g. Restaurant, Showroom, Clinic'],
                    ['key' => 'ownership',    'label' => 'Ownership Type', 'type' => 'select', 'options' => ['Freehold', 'Leasehold']],
                ],

            ],

            'commercial' => [
                'label'      => 'Other Commercial Space',
                'icon'       => '🏢',
                'group'      => 'commercial',
                'core'       => ['bathrooms', 'floor_no', 'total_floors', 'furnishing', 'property_age', 'facing', 'parking'],
                'required'   => [],
                'units'      => ['sqft', 'sqmtr', 'sqyard'],
                'title_label'       => 'Property Title',
                'title_placeholder' => 'e.g. Commercial Building on Faizabad Road',
                'area_label' => 'Built-up Area',
                'amenities'  => 'commercial',
                'allow_site' => false,
                'extras'     => array_merge(self::builtUpExtras(), [
                    ['key' => 'suitable_for', 'label' => 'Ideally Suited For', 'type' => 'text', 'placeholder' => 'e.g. Hotel, School, Hospital'],
                    ['key' => 'project_name', 'label' => 'Building / Complex Name', 'type' => 'text'],
                    ['key' => 'ownership',    'label' => 'Ownership Type', 'type' => 'select', 'options' => ['Freehold', 'Leasehold']],
                ]),
            ],

            'warehouse' => [
                'label'      => 'Warehouse / Godown',
                'icon'       => '📦',
                'group'      => 'commercial',
                'core'       => ['bathrooms', 'property_age', 'facing'],
                'required'   => [],
                'units'      => ['sqft', 'sqyard', 'sqmtr', 'acre'],
                'title_label'       => 'Warehouse / Godown Title',
                'title_placeholder' => 'e.g. 8000 sq.ft Godown on Kanpur Road',
                'area_label' => 'Covered Area',
                'amenities'  => 'industrial',
                'allow_site' => false,
                'extras'     => [
                    ['key' => 'plot_area',      'label' => 'Total Plot Area', 'type' => 'number', 'suffix' => 'sq.yd'],
                    ['key' => 'ceiling_height', 'label' => 'Ceiling Height', 'type' => 'number', 'suffix' => 'ft', 'placeholder' => 'e.g. 24'],
                    ['key' => 'shutters',       'label' => 'Number of Shutters / Gates', 'type' => 'number'],
                    ['key' => 'loading_docks',  'label' => 'Loading Docks', 'type' => 'number'],
                    ['key' => 'power_load',     'label' => 'Sanctioned Power Load', 'type' => 'number', 'suffix' => 'KVA'],
                    ['key' => 'road_width',     'label' => 'Approach Road Width', 'type' => 'number', 'suffix' => 'ft'],
                    ['key' => 'office_cabin',   'label' => 'Office Cabin Inside', 'type' => 'select', 'options' => self::YES_NO],
                    ['key' => 'ownership',      'label' => 'Ownership Type', 'type' => 'select', 'options' => ['Freehold', 'Leasehold']],
                ],
            ],

            'industrial_land' => [
                'label'      => 'Industrial Land / Plot',
                'icon'       => '🏗',
                'group'      => 'commercial',
                'core'       => ['facing'],
                'required'   => [],
                'units'      => ['sqyard', 'sqft', 'acre', 'sqmtr'],
                'title_min'         => 3,
                'title_label'       => 'Site Name',
                'title_placeholder' => 'e.g. Industrial Plot in UPSIDA Amausi',
                'area_label' => 'Plot Area',
                'amenities'  => 'industrial',
                'allow_site' => true,
                'extras'     => array_merge(self::plotDimensionExtras(), [
                    ['key' => 'zoning', 'label' => 'Zoning / Authority', 'type' => 'select',
                     'options' => ['UPSIDA', 'LDA Industrial', 'Nagar Nigam', 'Gram Panchayat', 'Other']],
                    ['key' => 'power_load',    'label' => 'Sanctioned Power Load', 'type' => 'number', 'suffix' => 'KVA'],
                    ['key' => 'ownership',     'label' => 'Ownership Type', 'type' => 'select', 'options' => ['Freehold', 'Leasehold', 'Allotment']],
                    ['key' => 'permitted_use', 'label' => 'Permitted Industry Type', 'type' => 'text', 'placeholder' => 'e.g. Light manufacturing, warehousing'],
                ]),
            ],
            'pg' => [
                'label'      => 'PG / Co-living',
                'icon'       => '🛏',
                'group'      => 'residential',
                'core'       => ['bathrooms', 'floor_no', 'total_floors', 'furnishing', 'facing'],
                'required'   => ['furnishing'],
                'units'      => ['sqft', 'sqmtr'],
                'title_min'         => 3,
                'title_label'       => 'PG / Hostel Name',
                'title_placeholder' => 'e.g. Shanti Girls PG near Lucknow University',
                'area_label' => 'Room Area',
                'amenities'  => 'pg',
                'allow_site' => false,
                'extras'     => [
                    ['key' => 'gender',        'label' => 'Suitable For', 'type' => 'select', 'options' => ['Boys', 'Girls', 'Co-ed']],
                    ['key' => 'occupancy',     'label' => 'Room Occupancy', 'type' => 'select', 'options' => ['Single', 'Double Sharing', 'Triple Sharing', 'Dormitory']],
                    ['key' => 'total_beds',    'label' => 'Total Beds Available', 'type' => 'number'],
                    ['key' => 'meals',         'label' => 'Meals', 'type' => 'select', 'options' => ['Included', 'Available at Extra Cost', 'Not Provided']],
                    ['key' => 'notice_period', 'label' => 'Notice Period (days)', 'type' => 'number', 'placeholder' => 'e.g. 30'],
                    ['key' => 'gate_closing',  'label' => 'Gate Closing Time', 'type' => 'text', 'placeholder' => 'e.g. 11:00 PM'],
                ],
            ],
        ];
    }

    /* ── Accessors ── */

    /** Every core field any type may use, so the controller knows what to blank out. */
    public const CORE_OPTIONAL_FIELDS = [
        'bedrooms', 'bathrooms', 'balconies', 'floor_no', 'total_floors',
        'furnishing', 'property_age', 'facing', 'parking',
    ];

    public static function keys(): array
    {
        return array_keys(self::types());
    }

    public static function labels(): array
    {
        return array_map(fn ($t) => $t['label'], self::types());
    }

    /** Types keyed by group, in GROUPS order, for rendering the picker. */
    public static function grouped(): array
    {
        $out = array_fill_keys(array_keys(self::GROUPS), []);

        foreach (self::types() as $key => $t) {
            $out[$t['group']][$key] = $t;
        }

        return array_filter($out);
    }

    public static function groupLabel(string $group): string
    {
        return self::GROUPS[$group]['label'] ?? ucfirst($group);
    }

    /** Which group a type belongs to, defaulting to the first group. */
    public static function groupOf(?string $type): string
    {
        return self::get($type)['group'] ?? array_key_first(self::GROUPS);
    }

    /** The first type in a group — what gets selected when the group is chosen. */
    public static function firstTypeIn(string $group): string
    {
        $types = self::grouped()[$group] ?? [];
        return (string) array_key_first($types);
    }

    public static function get(?string $type): ?array
    {
        return self::types()[$type] ?? null;
    }

    /** Falls back to `flat` so a legacy/unknown type still renders something sane. */
    public static function getOrDefault(?string $type): array
    {
        return self::get($type) ?? self::types()['flat'];
    }

    public static function appliesTo(?string $type, string $field): bool
    {
        $schema = self::get($type);
        return $schema ? in_array($field, $schema['core'], true) : true;
    }

    public static function isRequired(?string $type, string $field): bool
    {
        $schema = self::get($type);
        return $schema ? in_array($field, $schema['required'], true) : false;
    }

    public static function amenitiesFor(?string $type): array
    {
        $schema = self::get($type);
        return self::AMENITY_SETS[$schema['amenities'] ?? 'apartment'] ?? self::AMENITY_SETS['apartment'];
    }

    /** Every amenity string the system accepts, across all sets. */
    public static function allAmenities(): array
    {
        $all = [];
        foreach (self::AMENITY_SETS as $set) {
            $all = array_merge($all, $set);
        }
        return array_values(array_unique($all));
    }

    public static function unitsFor(?string $type): array
    {
        $schema = self::get($type);
        $keys   = $schema['units'] ?? array_keys(self::AREA_UNITS);
        $units  = [];
        foreach ($keys as $k) {
            if (isset(self::AREA_UNITS[$k])) $units[$k] = self::AREA_UNITS[$k];
        }
        return $units;
    }

    /** Minimum title length. Name-style titles are allowed to be short. */
    public static function titleMin(?string $type): int
    {
        return self::get($type)['title_min'] ?? 10;
    }

    public static function defaultUnit(?string $type): string
    {
        return array_key_first(self::unitsFor($type)) ?: 'sqft';
    }

    /** Extras for a type, including the rent block when relevant. */
    public static function extrasFor(?string $type, ?string $transactionType = null): array
    {
        $schema = self::get($type);
        $extras = $schema['extras'] ?? [];

        if ($transactionType === 'rent') {
            $extras = array_merge($extras, self::rentExtras());
        }

        return $extras;
    }

    /** Every extras key across all types + rent, used to whitelist details[]. */
    public static function allExtraKeys(): array
    {
        $keys = array_column(self::rentExtras(), 'key');
        foreach (self::types() as $t) {
            $keys = array_merge($keys, array_column($t['extras'], 'key'));
        }
        return array_values(array_unique($keys));
    }

    /** Extras keys valid for one type (rent block included), for stripping stale data. */
    public static function extraKeysFor(?string $type): array
    {
        $keys = array_column(self::extrasFor($type), 'key');
        return array_values(array_unique(array_merge($keys, array_column(self::rentExtras(), 'key'))));
    }

    /**
     * Find an extra field's spec by key, searching every type. Used when rendering
     * saved details on the public page so labels stay consistent.
     */
    public static function findExtra(string $key): ?array
    {
        foreach (self::rentExtras() as $f) {
            if ($f['key'] === $key) return $f;
        }
        foreach (self::types() as $t) {
            foreach ($t['extras'] as $f) {
                if ($f['key'] === $key) return $f;
            }
        }
        return null;
    }

    /**
     * Compact payload handed to Alpine so the browser can show/hide fields without
     * a round trip. Mirrors exactly what the server will validate.
     */
    public static function forJs(): array
    {
        $out = [];
        foreach (self::types() as $key => $t) {
            $out[$key] = [
                'label'     => $t['label'],
                'core'      => $t['core'],
                'required'  => $t['required'],
                'units'     => $t['units'],
                'areaLabel' => $t['area_label'],
                'titleLabel'       => $t['title_label'],
                'titleMin'         => $t['title_min'] ?? 10,
                'titlePlaceholder' => $t['title_placeholder'],
                'amenities' => self::AMENITY_SETS[$t['amenities']],
                'allowSite' => $t['allow_site'],
                'group'     => $t['group'],
                'extras'    => $t['extras'],
            ];
        }

        $groups = [];
        foreach (self::grouped() as $group => $types) {
            $groups[$group] = [
                'label' => self::GROUPS[$group]['label'],
                'icon'  => self::GROUPS[$group]['icon'],
                'types' => array_keys($types),
            ];
        }

        return [
            'types'      => $out,
            'groups'     => $groups,
            'rentExtras' => self::rentExtras(),
            'unitLabels' => self::AREA_UNITS,
        ];
    }
}
