<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperMarket extends Model
{
    use HasFactory;

    protected $fillable = [
        'bundle_id',
        'bin_location',
        'status',
        'issued_to_line',
    ];

    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }
}
