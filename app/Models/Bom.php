<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bom extends Model
{
    protected $fillable = [
        'bom_code',
        'style_code',
        'buyer_name',
        'season',
        'garment_type',
        'status'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(BomItem::class);
    }
}
