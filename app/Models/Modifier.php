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
        'is_relative',
    ];

    protected $casts = [
        'is_relative' => 'boolean',
        'value' => 'float',
    ];

    public function getModifiedPrice(float $base_price)
    {
        if ($this->is_relative) {
            return $base_price * $this->value;
        }

        return $base_price + $this->value;
    }
}
