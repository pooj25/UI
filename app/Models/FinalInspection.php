<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalInspection extends Model
{
    protected $fillable = [
        'lot_number',
        'po_number',
        'buyer_name',
        'style_code',
        'offer_qty',
        'sample_size',
        'major_defects',
        'minor_defects',
        'result',
        'inspector_name',
        'inspection_date'
    ];
    
    protected $casts = [
        'inspection_date' => 'date',
    ];
}
