<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grn extends Model
{
    use HasFactory;

    protected $table = 'grns';

    protected $fillable = [
        'grn_number',
        'invoice_number',
        'supplier_name',
        'fabric_id',
        'received_date',
        'rack_location',
        'remarks',
        'status',
    ];

    protected $casts = [
        'received_date' => 'date',
    ];

    /**
     * Auto-generate the next GRN number: GRN-0001, GRN-0002 …
     */
    public static function nextNumber(): string
    {
        $last = static::orderByDesc('id')->value('grn_number');
        if (!$last) {
            return 'GRN-0001';
        }
        $num = (int) substr($last, 4);
        return 'GRN-' . str_pad($num + 1, 4, '0', STR_PAD_LEFT);
    }

    /* ---------- Relationships ---------- */

    public function fabric()
    {
        return $this->belongsTo(Fabric::class);
    }

    public function rolls()
    {
        return $this->hasMany(GrnRoll::class);
    }

    /* ---------- Computed ---------- */

    public function totalWeight(): float
    {
        return (float) $this->rolls()->sum('roll_weight');
    }

    public function totalLength(): float
    {
        return (float) $this->rolls()->sum('roll_length');
    }

    public function rollCount(): int
    {
        return $this->rolls()->count();
    }
}
