<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'invoices';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'title',
        'info',
        'reference',
        'recieved_at',
        'due_at',
        'issued_by',
        'issued_at',
        'payable_to',
        'payable_by',
    ];

    protected $casts = [
        'recieved_at' => 'datetime',
        'due_at' => 'datetime',
        'issued_at' => 'datetime'
    ];

    public function lines()
    {
        return $this->hasMany(Line::class, 'invoice_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'invoice_id');
    }

    public function payableTo()
    {
        return $this->belongsTo(Entity::class, 'payable_to');
    }

    public function issuedBy()
    {
        return $this->belongsTo(Entity::class, 'issued_by');
    }

    public function payableBy()
    {
        return $this->belongsTo(Entity::class, 'payable_by');
    }

    public function getTotal()
    {
        // Sum up the total of all lines
        $total = "0";

        foreach ($this->lines as $line) {
            $total = bcadd($total, $line->getLineTotal(), 2);
        }

        return $total;
    }

    function getCurrency()
    {
        // If all the items have the same currency, return it
        // Otherwise, return null
        $currency = null;

        foreach ($this->lines as $line) {
            if ($currency === null) {
                $currency = $line->item->currency;
            } else if ($currency->id !== $line->item->currency->id) {
                return null;
            }
        }

        return $currency;
    }

    function getOwed()
    {
        return bcsub($this->getTotal(), $this->getPaid(), 2);
    }

    function getPaid()
    {
        // Sum up the total of all payments
        $total = "0";

        foreach ($this->transactions as $transaction) {
            $total = bcadd($total, $transaction->amount, 2);
        }

        return $total;
    }

    function getStatus()
    {
        $total = $this->getTotal();
        $paid = $this->getPaid();

        switch (bccomp($total, $paid, 2)) {
            case 0:
                return 'paid';
            case 1:
                return 'unpaid';
            case -1:
                return 'overpaid';
        }
    }
}
