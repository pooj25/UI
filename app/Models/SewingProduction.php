<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SewingProduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'bundle_id',
        'line_number',
        'operator_name',
        'operation',
        'qty_passed',
        'qty_rejected',
        'scanned_at',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }
}
