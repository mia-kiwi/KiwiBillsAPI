<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modifier extends Model
{
    use HasFactory;

    protected $table = 'modifiers';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'description',
        'value',
        'is_percentage',
    ];

    protected $casts = [
        'is_percentage' => 'boolean',
        'value' => 'float',
    ];

    public function calculateModifier(float $base_price): float
    {
        return $this->is_percentage ? $base_price * $this->value / 100 : $this->value;
    }

    public function getModifiedPrice(float $base_price): float
    {
        return $base_price + $this->calculateModifier($base_price);
    }
}
