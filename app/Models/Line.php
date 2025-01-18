<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'lines';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
        'index',
        'description',
        'quantity',
        'vat',
        'item_id',
        'invoice_id',
    ];

    protected $casts = [
        'quantity' => 'int',
        'vat' => 'float',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function modifiers()
    {
        return $this->belongsToMany(Modifier::class, 'lines_modifiers', 'line_id', 'modifier_id');
    }

    public function getLineTotal()
    {
        // Get the total without modifiers
        $total = $this->item->unit_price * $this->quantity;

        // Apply each modifier to the total
        foreach ($this->modifiers as $modifier) {
            $total = $modifier->getModifiedPrice($total);
        }

        return round($total, 2);
    }

    public function getShortFormattedTotal()
    {
        return $this->item->currency->getShortFormattedPrice($this->getLineTotal());
    }

    public function getFormattedTotal()
    {
        return $this->item->currency->getFormattedPrice($this->getLineTotal());
    }
}
