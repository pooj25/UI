<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FabricInspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'grn_roll_id',
        'inspected_by',
        'inspection_date',
        'shade_result',
        'shade_notes',
        'shrinkage_warp',
        'shrinkage_weft',
        'width_result',
        'defects_found',
        'pieces_inspected',
        'dhu_percent',
        'overall_result',
        'remarks',
    ];

    protected $casts = [
        'inspection_date' => 'date',
        'shrinkage_warp'  => 'decimal:2',
        'shrinkage_weft'  => 'decimal:2',
        'width_result'    => 'decimal:2',
        'dhu_percent'     => 'decimal:2',
    ];

    /* ---------- Relationships ---------- */

    public function grnRoll()
    {
        return $this->belongsTo(GrnRoll::class);
    }

    /* ---------- DHU calculation ---------- */

    /**
     * DHU % = (Total defects ÷ Total pieces inspected) × 100
     */
    public static function calcDhu(int $defects, int $pieces): float
    {
        if ($pieces <= 0) return 0.0;
        return round(($defects / $pieces) * 100, 2);
    }
}
