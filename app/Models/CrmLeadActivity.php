<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrmLeadActivity extends Model
{
    public const TYPES    = ['call', 'whatsapp', 'visit', 'note'];
    public const OUTCOMES = ['no_answer', 'call_later', 'interested', 'site_visit_fixed', 'not_interested'];

    protected $fillable = ['crm_lead_id', 'type', 'outcome', 'note', 'happened_at'];

    protected $casts = ['happened_at' => 'datetime', 'crm_lead_id' => 'integer'];

    public function lead()
    {
        return $this->belongsTo(CrmLead::class, 'crm_lead_id');
    }
}
