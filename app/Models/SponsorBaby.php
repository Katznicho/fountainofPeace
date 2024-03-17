<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorBaby extends Model
{
    use HasFactory;

    protected $table = 'sponsor_baby';
    use HasFactory;

    protected $fillable = [
        'sponsor_id',
        'baby_id',
        'status'
    ];

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }

    public function baby()
    {
        return $this->belongsTo(Baby::class);
    }
}
