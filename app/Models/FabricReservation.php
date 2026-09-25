<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FabricReservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_no',
        'lay_model_id',
        'request_date',
        'requested_by',
        'status',
        'remarks',
    ];

    protected $casts = [
        'request_date' => 'date',
    ];

    /**
     * Auto-generate the next Reservation number: RES-0001, RES-0002 …
     */
    public static function nextNumber(): string
    {
        $last = static::orderByDesc('id')->value('reservation_no');
        if (!$last) {
            return 'RES-0001';
        }
        $num = (int) substr($last, 4);
        return 'RES-' . str_pad($num + 1, 4, '0', STR_PAD_LEFT);
    }

    /* ---------- Relationships ---------- */

    public function layModel()
    {
        return $this->belongsTo(LayModel::class);
    }

    public function rolls()
    {
        return $this->belongsToMany(GrnRoll::class, 'fabric_reservation_rolls', 'fabric_reservation_id', 'grn_roll_id')
                    ->withTimestamps();
    }

    /* ---------- Helpers ---------- */

    public function statusColor(): string
    {
        return match($this->status) {
            'pending'   => '#f59e0b', // amber
            'approved'  => '#3b82f6', // blue
            'issued'    => '#10b981', // green
            'cancelled' => '#ef4444', // red
            default     => '#6b7280', // gray
        };
    }
}
