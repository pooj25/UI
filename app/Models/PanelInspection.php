<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelInspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'cut_order_id',
        'inspector_name',
        'total_panels_checked',
        'panels_passed',
        'panels_rejected',
        'defect_reason',
    ];

    public function cutOrder()
    {
        return $this->belongsTo(CutOrder::class);
    }
}
