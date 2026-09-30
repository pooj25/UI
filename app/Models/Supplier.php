<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'code',
        'category',
        'contact_person',
        'phone',
        'email',
        'city',
        'rating',
        'status'
    ];
}
