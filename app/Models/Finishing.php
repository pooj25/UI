<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finishing extends Model
{
    protected $fillable = [
        'bundle_id',
        'po_number',
        'buyer',
        'style',
        'washing_status',
        'ironing_status',
        'folding_status',
        'qc_status',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];
}
