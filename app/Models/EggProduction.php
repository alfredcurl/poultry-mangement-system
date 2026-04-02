<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EggProduction extends Model
{
    use HasFactory;

    protected $table = 'egg_production';

    protected $fillable = [
        'bird_id',
        'production_date',
        'eggs_collected',
        'damaged_eggs',
        'good_eggs',
        'notes'
    ];

    protected $casts = [
        'production_date' => 'date',
    ];

    public function bird()
    {
        return $this->belongsTo(Bird::class);
    }

    // Automatically calculate good eggs before saving
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($eggProduction) {
            $eggProduction->good_eggs = $eggProduction->eggs_collected - $eggProduction->damaged_eggs;
        });
    }
}
