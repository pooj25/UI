<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spotwash extends Model
{
    use HasFactory;

    protected $fillable = [
        'bundle_id',
        'quantity_sent',
        'stain_type',
        'status',
    ];

    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }
}
