<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicationUsage extends Model
{
    use HasFactory;

    protected $table = 'medication_usage';

    protected $fillable = [
        'medication_id',
        'bird_id',
        'administration_date',
        'quantity_used',
        'administered_by',
        'reason',
        'notes'
    ];

    protected $casts = [
        'administration_date' => 'date',
        'quantity_used' => 'decimal:2',
    ];

    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }

    public function bird()
    {
        return $this->belongsTo(Bird::class);
    }
}
