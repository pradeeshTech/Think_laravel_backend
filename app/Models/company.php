<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\state;

class company extends Model
{
    use HasFactory;

    protected $table='company';

    public function state(){

        return $this->belongsTo(state::class,'state_id',"id");
   }
}
