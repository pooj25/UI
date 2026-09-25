<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GrnRoll extends Model
{
    use HasFactory;

    protected $table = 'grn_rolls';

    protected $fillable = [
        'grn_id',
        'roll_number',
        'roll_weight',
        'roll_length',
        'actual_width',
        'qr_code',
        'status',
    ];

    protected $casts = [
        'roll_weight'  => 'decimal:2',
        'roll_length'  => 'decimal:2',
        'actual_width' => 'decimal:2',
    ];

    /* ---------- Status helpers ---------- */

    public static array $statuses = [
        'pending_inspection' => 'Pending Inspection',
        'inspected'          => 'Inspected',
        'in_stock'           => 'In Stock',
        'reserved'           => 'Reserved',
        'issued'             => 'Issued',
        'returned'           => 'Returned',
        'rejected'           => 'Rejected',
    ];

    public static array $statusColors = [
        'pending_inspection' => '#f59e0b',
        'inspected'          => '#3b82f6',
        'in_stock'           => '#10b981',
        'reserved'           => '#8b5cf6',
        'issued'             => '#0891b2',
        'returned'           => '#6b7280',
        'rejected'           => '#ef4444',
    ];

    /**
     * Generate a unique QR payload string for a new roll.
     * Format: <GRN_NUMBER>:<ROLL_NUMBER>:<UUID_SUFFIX>
     */
    public static function generateQrCode(string $grnNumber, string $rollNumber): string
    {
        return strtoupper($grnNumber . ':' . $rollNumber . ':' . Str::random(6));
    }

    /* ---------- Relationships ---------- */

    public function grn()
    {
        return $this->belongsTo(Grn::class);
    }

    public function inspection()
    {
        return $this->hasOne(FabricInspection::class);
    }

    /* ---------- Helpers ---------- */

    public function isInspected(): bool
    {
        return $this->inspection()->exists();
    }

    public function statusLabel(): string
    {
        return static::$statuses[$this->status] ?? ucfirst($this->status);
    }

    public function statusColor(): string
    {
        return static::$statusColors[$this->status] ?? '#6b7280';
    }
}
