<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Progression extends Model
{
    use HasFactory;

    protected $fillable = [
        'progress_value',
        'rate',
        'progress_date'
    ];

    public function cryptocurrency() {
        return $this->belongsTo(Cryptocurrency::class);
    }
    public function transaction() {
        return $this->belongsTo(Transaction::class);
    }




}
