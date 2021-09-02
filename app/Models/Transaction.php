<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'sum_purchase',
        'sum_selling',
        'balance',
        'quantity',
        'state',
        'purchase_date',
        'selling_date',
        'purchase_price',
        'selling_price',
        'user_id',
        'cryptocurrency_id',
        'progression_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function cryptocurrency() {
        return $this->hasOne(Cryptocurrency::class);
    }

    public function progression() {
        return $this->hasOne(Progression::class);
    }


}
