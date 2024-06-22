<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\state;

class country extends Model
{
    use HasFactory;

    protected $table="country";

    public function state(){
        return $this->hasMany(state::class,'country_id','id');

    }
}
