<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $fillable = [
        'lead_id','email_template_id','status','error','sent_at'
    ];
}
