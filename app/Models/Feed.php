<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    use HasFactory;

    protected $fillable = [
        'feed_name',
        'feed_type',
        'supplier',
        'quantity_in_kg',
        'unit_price',
        'total_cost',
        'purchase_date',
        'expiry_date',
        'notes',
    ];

    protected $casts = [
        'quantity_in_kg' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'purchase_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function feedUsage()
    {
        return $this->hasMany(FeedUsage::class);
    }

    public function getRemainingQuantity()
    {
        $used = $this->feedUsage()->sum('quantity_used_kg');
        return $this->quantity_in_kg - $used;
    }
}
