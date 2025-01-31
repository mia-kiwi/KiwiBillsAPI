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
        'unit_price' => 'string'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function getShortFormattedPrice(): string
    {
        return $this->currency->getShortFormattedPrice($this->unit_price);
    }

    public function getFormattedPrice(): string
    {
        return $this->currency->getFormattedPrice($this->unit_price);
    }
}
