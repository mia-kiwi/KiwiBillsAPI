<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'transactions';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
        'description',
        'amount',
        'currency_id',
        'invoice_id',
        'payment_date',
    ];

    protected $casts = [
        'amount' => 'string',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
