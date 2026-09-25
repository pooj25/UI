<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fabric extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fabric_code',
        'fabric_name',
        'fabric_type',
        'composition',
        'color',
        'gsm',
        'width',
        'unit',
        'description',
        'status',
    ];

    protected $casts = [
        'gsm' => 'decimal:2',
        'width' => 'decimal:2',
    ];

    /**
     * Fabric belongs to many FabricGroups
     */
    public function groups()
    {
        return $this->belongsToMany(FabricGroup::class, 'fabric_group_fabric', 'fabric_id', 'fabric_group_id')
                    ->withTimestamps();
    }

    /**
     * Fabric has many LayModels
     */
    public function layModels()
    {
        return $this->hasMany(LayModel::class);
    }

    /**
     * Check if fabric is in use by any lay model
     */
    public function isInUse(): bool
    {
        return $this->layModels()->exists();
    }

    /**
     * Scope for active fabrics
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
