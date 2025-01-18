<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $table = 'currencies';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'symbol',
    ];

    public function getShortFormattedPrice(float $price): string
    {
        return $this->symbol . number_format($price, 2);
    }

    public function getFormattedPrice(float $price): string
    {
        return number_format($price, 2) . ' ' . $this->id;
    }
}
