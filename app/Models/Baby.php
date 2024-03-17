<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baby extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'total_babies',
        'second_name',
        'story',
        'hobby',
        'profile_picture',
        'gender',
        'is_sponsored',
        'date_of_birth'
    ];

    protected $casts = [
        'story' => 'array',
        'hobby' => 'array',
        'gender' => 'array',
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        "created_at",
        "updated_at",
        "deleted_at",
    ];
    //fountainofpeaceo_donations



    public function sponsorBaby()
    {
        return $this->hasMany(SponsorBaby::class);
    }

    public function sponsors()
    {
        return $this->belongsToMany(Sponsor::class, 'sponsor_baby');
    }

    // Accessor to retrieve the full profile picture URL
    public function getProfilePictureAttribute()
    {
        $profilePicturePath = $this->attributes['profile_picture'];

        // Generate the full URL using the asset function
        return $profilePicturePath ? "https://dashboard.fountainofpeace.org.ug/storage/{$profilePicturePath}" : null;
    }
}
