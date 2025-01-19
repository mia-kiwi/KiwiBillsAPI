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
        'is_multiplier',
    ];

    protected $casts = [
        'is_multiplier' => 'boolean',
        'value' => 'string',
    ];

    public function getModifiedPrice(string $base_price)
    {
        if ($this->is_multiplier) {
            return bcmul($base_price, $this->value, 2);
        }

        return bcadd($base_price, $this->value, 2);
    }
}
