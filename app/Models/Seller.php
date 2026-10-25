<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Seller extends Model
{
    protected $table = 'sellers';

    protected $fillable = [
        'name', 'email', 'phone', 'whatsapp', 'password',
        'profile_photo', 'city', 'about', 'status', 'registration_step',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function listings()
    {
        return $this->hasMany(PropertyListing::class, 'seller_id');
    }

    public function publishedListings()
    {
        return $this->hasMany(PropertyListing::class, 'seller_id')->where('status', 'published');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function verifyPassword(string $plain): bool
    {
        return Hash::check($plain, $this->password);
    }
}
