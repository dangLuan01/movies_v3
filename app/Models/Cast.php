<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    public $timestamps=false;
    use HasFactory;
    protected $table='cast';

    public function movie(){
        return $this->belongsTo(Movie::class);
    }
}
