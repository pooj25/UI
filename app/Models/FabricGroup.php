<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FabricGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_code',
        'group_name',
        'description',
        'status',
    ];

    /**
     * FabricGroup belongs to many Fabrics
     */
    public function fabrics()
    {
        return $this->belongsToMany(Fabric::class, 'fabric_group_fabric', 'fabric_group_id', 'fabric_id')
                    ->withTimestamps();
    }

    /**
     * FabricGroup has many LayModels
     */
    public function layModels()
    {
        return $this->hasMany(LayModel::class, 'fabric_group_id');
    }

    /**
     * Scope for active groups
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
