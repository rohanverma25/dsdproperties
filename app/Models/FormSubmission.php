<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * A single submission from any public form on the site.
 *
 * This is an inbox, not a CRM: rows land here raw and are promoted into
 * `crm_leads` by hand from the admin panel. See the `convert` action on
 * Admin\FormSubmissionController.
 */
class FormSubmission extends Model
{
    /** Contact-us page. */
    public const FORM_CONTACT_US = 'contact_us';
    /** Inquiry form in the blog sidebar. */
    public const FORM_BLOG_SIDEBAR = 'blog_sidebar';
    /** Exit-intent popup on blog pages. */
    public const FORM_EXIT_INTENT = 'exit_intent';
    /** Newsletter subscribe box — email only, never convertible. */
    public const FORM_NEWSLETTER = 'newsletter';
    /**
     * Rows backfilled from `enquiry_form_submissions`. Contact-us and the blog
     * sidebar posted through the same endpoint with the same label, so historical
     * rows genuinely cannot be told apart — they are not guessed at.
     */
    public const FORM_LEGACY = 'legacy_inquiry';

    public const FORMS = [
        self::FORM_CONTACT_US   => 'Contact Us',
        self::FORM_BLOG_SIDEBAR => 'Blog Sidebar',
        self::FORM_EXIT_INTENT  => 'Exit-Intent Popup',
        self::FORM_NEWSLETTER   => 'Newsletter',
        self::FORM_LEGACY       => 'Legacy Enquiry',
    ];

    /** Forms the public may name in a request. Newsletter posts its own route. */
    public const PUBLIC_FORMS = [
        self::FORM_CONTACT_US,
        self::FORM_BLOG_SIDEBAR,
        self::FORM_EXIT_INTENT,
    ];

    public const STATUSES = ['new', 'converted', 'spam', 'archived'];

    /** Newsletter rows have no phone or name, so there is nothing to convert. */
    public const NON_CONVERTIBLE_FORMS = [self::FORM_NEWSLETTER];

    /**
     * How far back "Not handled" looks. The 600-odd backfilled rows are all
     * still 'new', so without a cut-off the count would never mean anything.
     */
    public const UNHANDLED_DAYS = 30;

    protected $fillable = [
        'name', 'phone', 'email', 'message',
        'source_form', 'source_page', 'referrer_url', 'ip_address',
        'status', 'crm_lead_id', 'converted_at',
    ];

    protected $casts = [
        'converted_at' => 'datetime',
        'crm_lead_id'  => 'integer',
    ];

    public function crmLead()
    {
        return $this->belongsTo(CrmLead::class);
    }

    public function getFormLabelAttribute(): string
    {
        return self::FORMS[$this->source_form] ?? $this->source_form;
    }

    /** A row can be promoted once, and only if it carries a phone number. */
    public function getIsConvertibleAttribute(): bool
    {
        return $this->crm_lead_id === null
            && $this->phone !== null
            && ! in_array($this->source_form, self::NON_CONVERTIBLE_FORMS, true);
    }

    /** Ready for tel: and wa.me links — shared with the CRM module. */
    public function getDialAttribute(): string
    {
        return CrmLead::normalisePhone($this->phone);
    }

    /**
     * Recent enquiries nobody has acted on yet — not converted, not marked
     * spam, not filed away. Newsletter sign-ups are never work, so never count.
     */
    public function scopeUnhandled(Builder $q): Builder
    {
        return $q->where('status', 'new')
                 ->where('source_form', '!=', self::FORM_NEWSLETTER)
                 ->where('created_at', '>=', now()->subDays(self::UNHANDLED_DAYS));
    }

    /** Free-text search across the columns an operator would actually recall. */
    public function scopeSearch(Builder $q, ?string $term): Builder
    {
        $term = trim((string) $term);

        if ($term === '') {
            return $q;
        }

        $digits = preg_replace('/\D+/', '', $term);

        return $q->where(function ($w) use ($term, $digits) {
            $w->where('name', 'like', "%{$term}%")
              ->orWhere('email', 'like', "%{$term}%")
              ->orWhere('message', 'like', "%{$term}%");

            if ($digits !== '') {
                $w->orWhere('phone', 'like', "%{$digits}%");
            }
        });
    }
}
