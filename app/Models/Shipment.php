<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'shipment_number',
        'gate_pass_no',
        'buyer_name',
        'po_number',
        'container_no',
        'vehicle_no',
        'destination',
        'total_cartons',
        'total_pieces',
        'status',
        'dispatch_date'
    ];

    protected $casts = [
        'dispatch_date' => 'date',
    ];
}
