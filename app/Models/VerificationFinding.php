<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationFinding extends Model
{
    protected $table = 'verification_findings';

    protected $fillable = [
        'verification_report_id', 'check_slug', 'status',
        'what_checked_hindi', 'where_checked_hindi',
        'visit_date', 'visit_time',
        'findings_hindi', 'red_flags_hindi',
        'evidence_reference', 'order',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    public function report()
    {
        return $this->belongsTo(VerificationReport::class, 'verification_report_id');
    }

    public function evidences()
    {
        return $this->hasMany(VerificationEvidence::class, 'verification_finding_id');
    }

    public function getStatusIconAttribute(): string
    {
        return match($this->status) {
            'clear'          => '✅',
            'note'           => '⚠️',
            'issue'          => '❌',
            'not_applicable' => '➖',
            default          => '⏳',
        };
    }

    public function getStatusLabelHindiAttribute(): string
    {
        return match($this->status) {
            'clear'          => 'स्पष्ट',
            'note'           => 'ध्यान दें',
            'issue'          => 'समस्या',
            'not_applicable' => 'लागू नहीं',
            default          => 'अज्ञात',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'clear'          => '#065f46',
            'note'           => '#92400e',
            'issue'          => '#991b1b',
            'not_applicable' => '#374151',
            default          => '#374151',
        };
    }

    public function getStatusBgAttribute(): string
    {
        return match($this->status) {
            'clear'          => '#d1fae5',
            'note'           => '#fef3c7',
            'issue'          => '#fee2e2',
            'not_applicable' => '#f3f4f6',
            default          => '#f3f4f6',
        };
    }
}
