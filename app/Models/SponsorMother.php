<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SponsorMother extends Pivot
{
    use HasFactory;

    protected  $table = 'sponsor_mother';

    protected $fillable = [
        'sponsor_id',
        'mother_id',
        'status'
    ];

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }

    public function mother()
    {
        return $this->belongsTo(Mother::class);
    }
}
