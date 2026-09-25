<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'cut_order_no',
        'fabric_reservation_id',
        'lay_model_id',
        'planned_qty',
        'planned_date',
        'status',
        'remarks',
    ];

    protected $casts = [
        'planned_date' => 'date',
    ];

    /**
     * Auto-generate the next Cut Order number: CO-0001, CO-0002 …
     */
    public static function nextNumber(): string
    {
        $last = static::orderByDesc('id')->value('cut_order_no');
        if (!$last) {
            return 'CO-0001';
        }
        $num = (int) substr($last, 3);
        return 'CO-' . str_pad($num + 1, 4, '0', STR_PAD_LEFT);
    }

    /* ---------- Relationships ---------- */

    public function fabricReservation()
    {
        return $this->belongsTo(FabricReservation::class);
    }

    public function layModel()
    {
        return $this->belongsTo(LayModel::class);
    }

    public function rolls()
    {
        return $this->belongsToMany(GrnRoll::class, 'cut_order_rolls', 'cut_order_id', 'grn_roll_id')
                    ->withPivot('used_length', 'used_weight')
                    ->withTimestamps();
    }

    /* ---------- Helpers ---------- */

    public function statusColor(): string
    {
        return match($this->status) {
            'planned'   => '#3b82f6', // blue
            'cutting'   => '#f59e0b', // amber
            'completed' => '#10b981', // green
            default     => '#6b7280', // gray
        };
    }
}
