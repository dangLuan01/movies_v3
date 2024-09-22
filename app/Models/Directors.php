<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Directors extends Model
{
    public $timestamps=false;
    use HasFactory;
    protected $table='directors';

    public function movie(){
        return $this->belongsTo(Movie::class);
    }
}
