<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packing extends Model
{
    use HasFactory;

    protected $fillable = [
        'carton_number',
        'bundle_id',
        'size',
        'quantity_packed',
        'packed_by',
        'status',
    ];

    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }
}
