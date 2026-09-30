<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    use HasFactory;

    protected $fillable = [
        'bundle_no',
        'cut_order_id',
        'size',
        'quantity',
        'status',
    ];

    public function cutOrder()
    {
        return $this->belongsTo(CutOrder::class);
    }

    public function sewingProductions()
    {
        return $this->hasMany(SewingProduction::class);
    }
}
