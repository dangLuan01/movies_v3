<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps=false;
    use HasFactory;
    protected $table='comments';

    public function replies(){
        return $this->hasMany(Comment::class,'parent_id');
    }
    public function user(){
        return $this->belongsTo(Customer::class);
    }
    public function movie(){
        return $this->belongsTo(Movie::class);
    }
}
