<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TraceabilityLog extends Model
{
    protected $fillable = [
        'trace_code',
        'po_number',
        'roll_id',
        'cut_no',
        'bundle_id',
        'pack_id',
        'carton_id',
        'current_stage',
        'status'
    ];
}
