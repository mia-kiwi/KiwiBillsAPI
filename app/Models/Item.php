<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'items';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'description',
        'reference',
        'unit_price',
        'currency_id',
    ];

    protected $casts = [
        'unit_price' => 'float'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function getShortFormattedPrice(): string
    {
        return $this->currency->getShortFormattedPrice(round($this->unit_price, 2));
    }

    public function getFormattedPrice(): string
    {
        return $this->currency->getFormattedPrice(round($this->unit_price, 2));
    }
}
