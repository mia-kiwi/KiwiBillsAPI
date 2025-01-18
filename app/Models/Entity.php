<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    use HasFactory;

    protected $table = 'entities';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'description',
        'address',
        'phone',
        'email',
        'website',
        'type',
    ];

    protected $casts = [
        'type' => 'string',
    ];

    public function getEmailString(): string
    {
        return $this->name . ($this->email ? " <" . $this->email . ">" : '');
    }
}
