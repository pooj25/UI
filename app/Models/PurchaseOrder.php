<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'buyer_id',
        'po_number',
        'style_name',
        'style_code',
        'colour',
        'season',
        'order_qty',
        'delivery_date',
        'status'
    ];

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(Buyer::class);
    }
}
