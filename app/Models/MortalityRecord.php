<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MortalityRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'bird_id',
        'death_date',
        'number_of_deaths',
        'cause_of_death',
        'notes'
    ];

    protected $casts = [
        'death_date' => 'date',
    ];

    public function bird()
    {
        return $this->belongsTo(Bird::class);
    }
}
