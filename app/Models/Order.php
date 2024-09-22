<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps=false;
    use HasFactory;
    protected $table='orders';
    protected $dates = ['date_end'];
    public function user(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function package(){
        return $this->belongsTo(Movie_Package::class);
    }
}
