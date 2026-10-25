<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationEvidence extends Model
{
    protected $table = 'verification_evidences';

    protected $fillable = [
        'verification_report_id', 'verification_finding_id',
        'evidence_code', 'document_type', 'document_type_hindi',
        'source_office_hindi', 'extracted_by', 'extracted_on',
        'file_path', 'file_mime', 'file_name', 'file_size',
        'page_count', 'notes', 'order',
    ];

    protected $casts = [
        'extracted_on' => 'date',
        'file_size'    => 'integer',
        'page_count'   => 'integer',
    ];

    public function report()
    {
        return $this->belongsTo(VerificationReport::class, 'verification_report_id');
    }

    public function finding()
    {
        return $this->belongsTo(VerificationFinding::class, 'verification_finding_id');
    }

    public function isImage(): bool
    {
        return str_starts_with($this->file_mime, 'image/');
    }

    public function isPdf(): bool
    {
        return $this->file_mime === 'application/pdf';
    }

    public function getFileSizeHumanAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes < 1024)       return $bytes . ' B';
        if ($bytes < 1048576)    return round($bytes / 1024, 1) . ' KB';
        return round($bytes / 1048576, 1) . ' MB';
    }
}
