<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Children extends Model
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

    protected $dates = ['deleted_at'];

    protected $hidden = [
        "created_at",
        "updated_at",
        "deleted_at",
    ];
    //fountainofpeaceo_donations

    public function mother()
    {
        return $this->belongsTo(Mother::class);
    }

    public function sponsorChild()
    {
        return $this->hasMany(SponsorChild::class);
    }

    public function sponsors()
    {
        return $this->belongsToMany(Sponsor::class, 'sponsor_children');
    }

    // Accessor to retrieve the full profile picture URL
    public function getProfilePictureAttribute()
    {
        $profilePicturePath = $this->attributes['profile_picture'];

        // Generate the full URL using the asset function
        return $profilePicturePath ? asset("storage/{$profilePicturePath}") : null;
    }
}
