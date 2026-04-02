<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bird extends Model
{
    use HasFactory;

    protected $fillable = [
        'bird_type',
        'breed',
        'quantity',
        'acquisition_date',
        'acquisition_cost',
        'age_in_weeks',
        'status',
        'notes'
    ];

    protected $casts = [
        'acquisition_date' => 'date',
        'acquisition_cost' => 'decimal:2',
    ];

    public function mortalityRecords()
    {
        return $this->hasMany(MortalityRecord::class);
    }

    public function eggProduction()
    {
        return $this->hasMany(EggProduction::class);
    }

    public function feedUsage()
    {
        return $this->hasMany(FeedUsage::class);
    }

    public function medicationUsage()
    {
        return $this->hasMany(MedicationUsage::class);
    }

    public function getCurrentQuantity()
    {
        $deaths = $this->mortalityRecords()->sum('number_of_deaths');
        return $this->quantity - $deaths;
    }
}
