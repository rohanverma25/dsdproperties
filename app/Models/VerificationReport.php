<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class VerificationReport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'report_id', 'customer_name', 'customer_phone', 'customer_email',
        'property_address', 'property_khasra', 'property_gata', 'property_area',
        'property_type', 'seller_name', 'asking_price', 'tehsil',
        'verifier_id', 'verifier_name', 'verifier_visit_date',
        'verdict', 'verdict_summary_hindi', 'status',
        'pdf_path', 'pdf_password', 'delivered_at', 'delivery_channel', 'notes',
    ];

    protected $casts = [
        'verifier_visit_date' => 'date',
        'delivered_at'        => 'datetime',
        'asking_price'        => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (VerificationReport $report) {
            $year = now()->year;

            DB::transaction(function () use ($report, $year) {
                $counter = DB::table('verification_counters')
                    ->where('year', $year)
                    ->lockForUpdate()
                    ->first();

                if ($counter) {
                    $seq = $counter->last_seq + 1;
                    DB::table('verification_counters')
                        ->where('year', $year)
                        ->update(['last_seq' => $seq]);
                } else {
                    $seq = 1;
                    DB::table('verification_counters')->insert([
                        'year'     => $year,
                        'last_seq' => $seq,
                    ]);
                }

                $report->report_id   = sprintf('DSD-VER-%d-%04d', $year, $seq);
                $report->pdf_password = substr($report->customer_phone, -4);
            });
        });
    }

    public function findings()
    {
        return $this->hasMany(VerificationFinding::class)->orderBy('order');
    }

    public function evidences()
    {
        return $this->hasMany(VerificationEvidence::class)->orderBy('order');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verifier_id');
    }

    public function getVerdictLabelAttribute(): string
    {
        return match($this->verdict) {
            'green' => '✅ सुरक्षित — आगे बढ़ें',
            'amber' => '⚠️ सावधानी — शर्तों के साथ आगे बढ़ें',
            'red'   => '❌ न खरीदें',
            default => 'निर्णय लंबित',
        };
    }

    public function getVerdictColorAttribute(): string
    {
        return match($this->verdict) {
            'green' => '#065f46',
            'amber' => '#92400e',
            'red'   => '#991b1b',
            default => '#374151',
        };
    }

    public function getVerdictBgAttribute(): string
    {
        return match($this->verdict) {
            'green' => '#d1fae5',
            'amber' => '#fef3c7',
            'red'   => '#fee2e2',
            default => '#f3f4f6',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft'             => 'ड्राफ्ट',
            'in_progress'       => 'प्रगति में',
            'ready_to_deliver'  => 'वितरण के लिए तैयार',
            'delivered'         => 'वितरित',
            default             => $this->status,
        };
    }

    public function allFindingsFilled(): bool
    {
        $filled = $this->findings()
            ->whereNotNull('findings_hindi')
            ->where('findings_hindi', '!=', '')
            ->count();

        return $filled >= 9;
    }

    public function getPropertyAddressShortAttribute(): string
    {
        return \Illuminate\Support\Str::limit($this->property_address, 60);
    }

    public function getCustomerFirstNameAttribute(): string
    {
        $parts = explode(' ', trim($this->customer_name));
        return $parts[0] ?? $this->customer_name;
    }
}
