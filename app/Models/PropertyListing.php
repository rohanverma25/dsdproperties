<?php

namespace App\Models;

use App\Support\PropertyTypeSchema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PropertyListing extends Model
{
    protected $table = 'property_listings';

    protected $fillable = [
        'seller_id', 'title', 'slug', 'property_type', 'transaction_type',
        'price', 'price_negotiable', 'price_on_request',
        'area', 'area_unit', 'bedrooms', 'bathrooms', 'balconies',
        'floor_no', 'total_floors', 'furnishing', 'property_age',
        'facing', 'parking', 'address', 'locality', 'landmark', 'pincode',
        'description', 'amenities', 'featured_image', 'video_path', 'youtube_url',
        'brochure_path', 'is_site', 'plot_segments', 'type_details',
        'lat', 'lng',
        'status', 'rejection_reason',
    ];

    protected $casts = [
        'amenities'        => 'array',
        'plot_segments'    => 'array',
        'type_details'     => 'array',
        'price_negotiable' => 'boolean',
        'price_on_request' => 'boolean',
        'is_site'          => 'boolean',
        'price'            => 'integer',
        'views'            => 'integer',
        'lat'              => 'float',
        'lng'              => 'float',
    ];


    /* ── Cleanup on delete ── */

    /**
     * Deleting a listing takes its files with it. The gallery images, featured image,
     * brochure and video all live under public/uploads/properties and nothing else
     * references them once the listing is gone. property_images has no foreign key, so
     * the child rows are cleared here rather than by the database.
     */
    protected static function booted(): void
    {
        static::deleting(function (PropertyListing $listing) {
            $paths = $listing->images()->pluck('image_path')->all();

            $paths[] = $listing->featured_image;
            $paths[] = $listing->brochure_path;
            $paths[] = $listing->video_path;

            foreach (array_unique(array_filter($paths)) as $path) {
                $listing->deleteUpload($path);
            }

            $listing->images()->delete();
            $listing->tags()->detach();
        });
    }

    /**
     * Only ever unlinks inside public/uploads — an absolute path or a "../" that somehow
     * reached the column must not let a delete escape the upload folder.
     */
    protected function deleteUpload(string $path): void
    {
        $path = ltrim(str_replace('\\', '/', $path), '/');

        if (! Str::startsWith($path, 'uploads/') || Str::contains($path, '..')) {
            return;
        }

        $full = public_path($path);

        if (is_file($full)) {
            @unlink($full);
        }
    }

    /* ── Labels ── */

    /**
     * Property types, area units and amenities now come from PropertyTypeSchema so the
     * form, the validator and the public page can never disagree about what a plot or a
     * piece of agricultural land is allowed to have.
     */
    public static function propertyTypes(): array
    {
        return PropertyTypeSchema::labels();
    }

    public static function areaUnits(): array
    {
        return PropertyTypeSchema::AREA_UNITS;
    }

    public static function amenitiesList(): array
    {
        return PropertyTypeSchema::allAmenities();
    }

    public static $furnishingLabels = [
        'unfurnished'    => 'Unfurnished',
        'semi_furnished' => 'Semi-Furnished',
        'fully_furnished'=> 'Fully Furnished',
    ];

    public static $ageLabels = [
        'new_construction' => 'New / Under Construction',
        'less_5'           => 'Less than 5 years',
        '5_10'             => '5 – 10 years',
        '10_20'            => '10 – 20 years',
        'above_20'         => 'Above 20 years',
    ];

    /* ── Relationships ── */
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class, 'listing_id')->orderBy('sort_order');
    }

    public function inquiries()
    {
        return $this->hasMany(PropertyInquiry::class, 'listing_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'listing_tag', 'listing_id', 'tag_id');
    }

    /* ── Helpers ── */
    public function getTypeLabel(): string
    {
        return PropertyTypeSchema::labels()[$this->property_type]
            ?? ucfirst(str_replace('_', ' ', (string) $this->property_type));
    }

    public function getFurnishingLabel(): ?string
    {
        return static::$furnishingLabels[$this->furnishing] ?? null;
    }

    public function getAgeLabel(): ?string
    {
        return static::$ageLabels[$this->property_age] ?? null;
    }

    public function getAreaUnitLabel(): string
    {
        return PropertyTypeSchema::AREA_UNITS[$this->area_unit] ?? $this->area_unit;
    }

    /** What "area" means for this type — "Plot Area" for a plot, "Land Area" for a farm. */
    public function getAreaLabel(): string
    {
        return PropertyTypeSchema::getOrDefault($this->property_type)['area_label'];
    }

    public function getPriceDisplay(): string
    {
        if ($this->price_on_request) return 'Price on Request';
        $p = $this->price;
        if ($p >= 10000000) return '₹ ' . number_format($p / 10000000, 2) . ' Cr';
        if ($p >= 100000)   return '₹ ' . number_format($p / 100000, 2) . ' Lakh';
        return '₹ ' . number_format($p);
    }

    public function getFeaturedImage(): string
    {
        if ($this->featured_image && file_exists(public_path($this->featured_image))) {
            return asset($this->featured_image);
        }
        $first = $this->images()->first();
        if ($first) return asset($first->image_path);
        return asset('images/property-placeholder.jpg');
    }

    /**
     * Deliberately keyed off the type itself, not the picker's groups — a residential plot
     * sits under "Residential" in the form but is still land, and regrouping the picker
     * must not silently change what these mean.
     */
    public function isResidential(): bool
    {
        return in_array($this->property_type, ['flat', 'builder_floor', 'house', 'villa', 'farmhouse', 'pg'], true);
    }

    public function isLand(): bool
    {
        return in_array($this->property_type, ['plot', 'agricultural_land', 'industrial_land'], true);
    }

    /**
     * Saved type_details as [label => value] pairs, ready to render. Keys the schema no
     * longer knows about are dropped so a type change never leaves stale rows on the page.
     */
    public function getDetailRows(): array
    {
        // Scoped to this listing's own type, so a field removed from a type stops showing
        // on its old listings even while another type still declares the same key.
        $valid = array_column(
            PropertyTypeSchema::extrasFor($this->property_type, $this->transaction_type),
            null,
            'key'
        );

        $rows = [];
        foreach ((array) $this->type_details as $key => $value) {
            if ($value === null || $value === '' || $value === []) continue;

            $spec = $valid[$key] ?? null;
            if (! $spec) continue;

            $label = $spec['label'];
            if (($spec['type'] ?? null) === 'number' && ! empty($spec['suffix'])) {
                $value = $value . ' ' . $spec['suffix'];
            }
            if (($spec['type'] ?? null) === 'date') {
                try {
                    $value = \Carbon\Carbon::parse($value)->format('d M Y');
                } catch (\Throwable $e) {
                    // Leave the raw value if it is not a parseable date.
                }
            }
            $rows[$label] = $value;
        }
        return $rows;
    }

    /**
     * Saved amenities, filtered to those this property type still offers. An amenity
     * removed from a type's set therefore stops appearing on its existing listings,
     * without having to rewrite rows.
     */
    public function getAmenityList(): array
    {
        $allowed = PropertyTypeSchema::amenitiesFor($this->property_type);

        return array_values(array_intersect((array) $this->amenities, $allowed));
    }

    /* ── Slug generation ── */
    public static function generateSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i    = 1;
        while (static::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    /* ── Scopes ── */
    public function scopePublished($q) { return $q->where('status', 'published'); }
    public function scopePending($q)   { return $q->where('status', 'pending'); }
}
