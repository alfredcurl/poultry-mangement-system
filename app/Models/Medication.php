<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;

    protected $fillable = [
        'medication_name',
        'medication_type',
        'supplier',
        'quantity',
        'unit',
        'unit_price',
        'total_cost',
        'purchase_date',
        'expiry_date',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'purchase_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function medicationUsage()
    {
        return $this->hasMany(MedicationUsage::class);
    }

    public function getRemainingQuantity()
    {
        $used = $this->medicationUsage()->sum('quantity_used');
        return $this->quantity - $used;
    }
}
