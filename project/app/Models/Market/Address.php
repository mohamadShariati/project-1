<?php

namespace App\Models\Market;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory,SoftDeletes;

    public function orders(){
        return $this->hasmany(Order::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }
}

