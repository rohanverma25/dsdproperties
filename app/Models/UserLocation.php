<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
    use HasFactory;

    // Add 'ip' to allow mass assignment
    protected $fillable = [
            'ip', 'page', 'city', 'region', 'country', 'created_at', 'updated_at'
        ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
