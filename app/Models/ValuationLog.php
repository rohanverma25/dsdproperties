<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValuationLog extends Model
{
    public $timestamps = false;

    protected $fillable = ['whatsapp_no', 'form_data'];

    protected $casts = [
        'form_data'  => 'array',
        'created_at' => 'datetime',
    ];
}