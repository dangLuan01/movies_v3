<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    public $timestamps = false;
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }
    public function episode()
    {
        return $this->hasMany(Episode::class);
    }
    public function cast()
    {
        return $this->belongsTo(Cast::class);
    }

    public function movie_cast()
    {
        return $this->belongsToMany(Cast::class, 'movie_cast', 'movie_id', 'cast_id')->where('status', 1);
    }

    public function directors()
    {
        return $this->belongsTo(Directors::class);
    }
    public function movie_directors()
    {
        return $this->belongsToMany(Directors::class, 'movie_directors', 'movie_id', 'directors_id')->where('status', 1);
    }

    public function movie_genre()
    {
        return $this->belongsToMany(Genre::class, 'movie_genre', 'movie_id', 'genre_id')->where('status', 1);
    }
    // public function movie_rating()
    // {
    //     return $this->hasMany(Movie_Rating::class);
    // }
    // public function movie_description()
    // {
    //     return $this->hasMany(Movie_Description::class);
    // }
    public function movie_description()
    {
        return $this->hasOne(Movie_Description::class);
    }
    public function movie_trailer()
    {
        return $this->hasOne(Movie_Trailer::class);
    }
    // public function movie_hot()
    // {
    //     return $this->hasOne(Movie_Hot::class);
    // }
    public function movie_tags()
    {
        return $this->hasOne(Movie_Tags::class);
    }
    public function movie_image()
    {
        return $this->hasOne(Movie_Image::class);
    }
    public function movie_logo()
    {
        return $this->hasOne(Movie_Image::class)->where('is_logo', 1);
    }
    public function movie_views()
    {
        return $this->hasMany(Movie_Views::class);
    }

    public function movie_comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->orderBy('id','DESC')->where('status',1);
    }

}
