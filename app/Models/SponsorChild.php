<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SponsorChild extends Pivot
{
    protected $table = 'sponsor_children';
    use HasFactory;

    protected $fillable = [
        'sponsor_id',
        'child_id',
        'status'
    ];

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }

    public function child()
    {
        return $this->belongsTo(Children::class);
    }
}
