<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Sponsor extends Model
{
    use HasFactory;

    protected $fillable = [
        'sponsor_identifier',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'address',
        'city',
        'state',
        'country',
        'postal_code',

    ];

    public function sponsorChild()
    {
        return $this->hasMany(SponsorChild::class);
    }

    public function child()
    {
        return $this->belongsToMany(Children::class, 'sponsor_children');
    }

    public function mother()
    {
        return $this->belongsToMany(Mother::class, 'sponsor_mother');
    }
}
