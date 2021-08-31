<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cryptocurrency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'logo', 'current_value'
    ];
    public function progressions() {
        return $this->hasMany(Progression::class);
    }
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

}
