<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    use HasFactory;

    protected $fillable = [
        'helmet_id',
        'sensor_id',
        'sensor_value',
        'timestamp',
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }

    public function helmet()
    {
        return $this->belongsTo(Helmet::class);
    }

    
}
