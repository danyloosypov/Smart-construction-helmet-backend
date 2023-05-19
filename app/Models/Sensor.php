<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sensor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];


    public function readings(): HasMany {
        return $this->hasMany(Reading::class);
    }
}
