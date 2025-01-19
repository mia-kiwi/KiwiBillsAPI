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

    public function getShortFormattedPrice(string $price): string
    {
        return $this->symbol . $price;
    }

    public function getFormattedPrice(string $price): string
    {
        return $price . ' ' . $this->id;
    }
}
