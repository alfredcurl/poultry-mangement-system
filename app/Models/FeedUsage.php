<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedUsage extends Model
{
    use HasFactory;

    protected $table = 'feed_usage';

    protected $fillable = [
        'feed_id',
        'bird_id',
        'usage_date',
        'quantity_used_kg',
        'notes'
    ];

    protected $casts = [
        'usage_date' => 'date',
        'quantity_used_kg' => 'decimal:2',
    ];

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }

    public function bird()
    {
        return $this->belongsTo(Bird::class);
    }
}
