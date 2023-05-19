<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Helmet extends Model
{
    use HasFactory;

    protected $fillable = [
        'worker_id',
        'name',
        'description',
    ];

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    public function readings()
    {
        return $this->hasMany(Reading::class);
    }
}
