<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InquiryForm extends Model
{
    use HasFactory;
    protected $fillable = [
        'form_name',
        'params',
    ];
    protected $table = "enquiry_form_submissions";
}
