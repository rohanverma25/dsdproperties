<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'comments',
        'segment',
        'company_name',
        'created_at',
        'is_valid_email',
        'enquiry_date',
        'is_email_sent',
    ];
}
