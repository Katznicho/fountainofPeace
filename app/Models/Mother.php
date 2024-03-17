<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Mother extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'first_name',
        'middle_name',
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

    protected $hidden = [
        "created_at",
        "updated_at",
        "deleted_at",

    ];


    // Accessor to retrieve the full profile picture URL
    public function getProfilePictureAttribute()
    {
        $profilePicturePath = $this->attributes['profile_picture'];

        // Generate the full URL using the asset function
        return $profilePicturePath ? asset("storage/{$profilePicturePath}") : null;
    }

    public function getAgeAttribute()
    {
        $dateOfBirth = $this->attributes['date_of_birth'];

        // Check if date_of_birth is set
        if ($dateOfBirth) {
            // Use Carbon to calculate the age
            return Carbon::parse($dateOfBirth)->age;
        }

        return null; // or handle accordingly if date_of_birth is not set
    }

    public function sponsorMother()
    {
        return $this->hasMany(SponsorMother::class);
    }

    public function sponsors()
    {
        return $this->belongsToMany(Sponsor::class, 'sponsor_mother');
    }
}
