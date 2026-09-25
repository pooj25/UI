<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'lay_model_code',
        'lay_model_name',
        'fabric_group_id',
        'fabric_id',
        'lay_length',
        'lay_width',
        'number_of_plies',
        'garment_size',
        'marker_length',
        'marker_width',
        'description',
        'status',
    ];

    protected $casts = [
        'lay_length' => 'decimal:2',
        'lay_width' => 'decimal:2',
        'marker_length' => 'decimal:2',
        'marker_width' => 'decimal:2',
        'number_of_plies' => 'integer',
    ];

    /**
     * LayModel belongs to a FabricGroup
     */
    public function fabricGroup()
    {
        return $this->belongsTo(FabricGroup::class, 'fabric_group_id');
    }

    /**
     * LayModel belongs to a Fabric
     */
    public function fabric()
    {
        return $this->belongsTo(Fabric::class, 'fabric_id');
    }

    /**
     * Scope for active models
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
