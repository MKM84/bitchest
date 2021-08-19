<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'sum',
        'quantity',
        'state',
        'purchase_date',
        'selling_date',
        'purchase_price',
        'selling_price'
    ];

    public function user() {
        return $this->hasOne(User::class);
    }

    public function cryptocurrency() {
        return $this->hasOne(Cryptocurrency::class);
    }

    public function progression() {
        return $this->hasOne(Progression::class);
    }
}
