<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\Movie_Genre;
use App\Models\Movie_Views;
use App\Models\Rating;
use App\Models\Cast;
use App\Models\Directors;
use App\Models\Movie_Directors;
use App\Models\Movie_Cast;
use App\Models\Info;
use App\Models\Server;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
class IndexController extends Controller
{
    public function search()
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        return view('pages.search', compact('category'));
    }


    public function timkiem()
    {
            $movie = Movie::where(function ($querys) {
                $search = $_GET['search'];
                $cast_slug = Cast::where('title', 'LIKE', '%' . $search . '%')->first();
                if (isset($cast_slug)) {
                    $movie_cast = Movie_Cast::where('cast_id', $cast_slug->id)->get();
                    $many_cast = [];
                    foreach ($movie_cast as $key => $movi) {
                        $many_cast[] = $movi->movie_id;
                    }
                } else {
                    $many_cast = [];
                }

                $querys->orWhere('name_english', 'LIKE', '%' . $search . '%')->orWhereIn('id', $many_cast)->orwhereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", [$search]);
            })->where('status', 1)->with(['episode' => function ($ep) {
                $ep->orderBy('episode', 'ASC');
            }])->with(['movie_image' => function ($thumb) {
                $thumb->where('is_thumbnail', 1);
            }])->orderBy('id', 'DESC')->get();
            
            $api_ophim = Http::get('http://ophim1.com/danh-sach/phim-moi-cap-nhat');
            $url_update = $api_ophim['pathImage'];
            
            return response()->json($movie);
    }
    public function home()
    {
        $category = Cache::remember('categories', 300, function () {
                return Category::orderBy('id', 'ASC')->where('status', 1)->get();
        });
        $genre = Cache::remember('genres', 300, function () {
                return Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        });
        
        // Cache cho danh sách quốc gia 
        $country_ids = Cache::remember('country_ids', 500, function () {
            return Country::whereIn('title', ['Au My', 'Phap', 'Anh', 'Y', 'Duc'])->pluck('id');
        });

        // HOT MOVIES
        $hot = Cache::remember('hot_movie', 300, function () {
            return Movie::where('hot', 1)
                ->where('status', 1)
                ->with(['episode' => function ($query) {
                    $query->orderBy('episode', 'ASC');
                }, 'movie_image' => function ($thumb) {
                    $thumb->where('is_thumbnail', 0);
                }])
                ->orderBy('updated_at', 'DESC')
                ->get(['id', 'title', 'updated_at', 'imdb','slug']);
        });
        $responses = Http::pool(function ($pool) use ($hot) {
            return collect($hot)->map(function ($movie) use ($pool) {
                return $pool->get('https://www.omdbapi.com/?i=' . $movie->imdb . '&apikey=6c2f1ca1');
            });
        });

        // Xử lý các phản hồi
        foreach ($responses as $key => $response) {
            if ($response->successful()) {
                $imdbRating_hot = $response['Response'] == "True" && $response['imdbRating'] != "N/A"
                    ? $response['imdbRating']
                    : "0.0";
            } else {
                $imdbRating_hot = "0.0";
            }
    
            $hot_with_ratings[] = [
                'movie' => $hot[$key],
                'imdbRating' => $imdbRating_hot,
            ];
        }
      
        // TOP VIEW MOVIES
        $topview = Cache::remember('topview', 300, function () {
            return Movie::select('title', 'slug', 'image', DB::raw('SUM(count_views) as count_views'))
                ->join('movie_views', 'movies.id', '=', 'movie_views.movie_id')
                ->join('movie_image', 'movie_views.movie_id', '=', 'movie_image.movie_id')
                ->where('is_thumbnail', 1)
                ->where('status', 1)
                ->groupBy('title', 'slug', 'image')
                ->orderBy('count_views', 'DESC')
                ->limit(5)
                ->get();
        });

        // HOAT HINH MOVIES
        $movie_animation = Cache::remember('movie_animation', 300, function () {
            $gen_slugs = Genre::where('title', 'LIKE', '%hoat hinh%')->first();
            if (!$gen_slugs) {
                return collect();  // Trả về bộ sưu tập rỗng nếu không tìm thấy genre
            }
            $movie_ids = Movie_Genre::where('genre_id', $gen_slugs->id)->pluck('movie_id');

            return Movie::whereIn('id', $movie_ids)
                ->where('status', 1)
                ->with(['episode', 'movie_image' => function ($thumb) {
                    $thumb->where('is_thumbnail', 0);
                }])
                ->orderBy('updated_at', 'DESC')
                ->limit(16)
                ->get(['id', 'title', 'updated_at', 'imdb','slug']);
        });
        $responses = Http::pool(function ($pool) use ($movie_animation) {
            return collect($movie_animation)->map(function ($movie) use ($pool) {
                return $pool->get('https://www.omdbapi.com/?i=' . $movie->imdb . '&apikey=6c2f1ca1');
            });
        });

        // Xử lý các phản hồi
        foreach ($responses as $key => $response) {
            if ($response->successful()) {
                $imdbRating_animation = $response['Response'] == "True" && $response['imdbRating'] != "N/A"
                    ? $response['imdbRating']
                    : "0.0";
            } else {
                $imdbRating_animation = "0.0";
            }
    
            $movie_animation_with_ratings[] = [
                'movie' => $movie_animation[$key],
                'imdbRating' => $imdbRating_animation,
            ];
        }
        

        // NETFLIX MOVIES
        $movie_netflix = Cache::remember('movie_netflix', 300, function () {
            $gen_netflix_slug = Genre::where('title', 'LIKE', '%netflix%')->first();
            if (!$gen_netflix_slug) {
                return collect();  // Trả về bộ sưu tập rỗng nếu không tìm thấy genre
            }
            $movie_ids = Movie_Genre::where('genre_id', $gen_netflix_slug->id)->pluck('movie_id');

            return Movie::whereIn('id', $movie_ids)
                ->where('status', 1)
                ->with(['episode', 'movie_image' => function ($thumb) {
                    $thumb->where('is_thumbnail', 0);
                }])
                ->orderBy('updated_at', 'DESC')
                ->limit(12)
                ->get(['id', 'title', 'updated_at', 'imdb','slug']);
        });
        $responses = Http::pool(function ($pool) use ($movie_netflix) {
            return collect($movie_netflix)->map(function ($movie) use ($pool) {
                return $pool->get('https://www.omdbapi.com/?i=' . $movie->imdb . '&apikey=6c2f1ca1');
            });
        });

        // Xử lý các phản hồi
        foreach ($responses as $key => $response) {
            if ($response->successful()) {
                $imdbRating_netflix = $response['Response'] == "True" && $response['imdbRating'] != "N/A"
                    ? $response['imdbRating']
                    : "0.0";
            } else {
                $imdbRating_netflix = "0.0";
            }
    
            $movie_netflix_with_ratings[] = [
                'movie' => $movie_netflix[$key],
                'imdbRating' => $imdbRating_netflix,
            ];
        }

        // OSCAR MOVIES
        $movies_oscar = Cache::remember('movies_oscar', 300, function () {
            $oscar_slug = Genre::where('title', 'LIKE', '%Oscar%')->first();
            if (!$oscar_slug) {
                return collect();  // Trả về bộ sưu tập rỗng nếu không tìm thấy genre
            }
            $movie_ids = Movie_Genre::where('genre_id', $oscar_slug->id)->pluck('movie_id');

            return Movie::whereIn('id', $movie_ids)
                ->where('status', 1)
                ->with(['episode', 'movie_image' => function ($thumb) {
                    $thumb->where('is_thumbnail', 0);
                }])
                ->orderBy('updated_at', 'DESC')
                ->limit(16)
                ->get(['id', 'title', 'updated_at', 'imdb','slug']);
        });
        $responses = Http::pool(function ($pool) use ($movies_oscar) {
            return collect($movies_oscar)->map(function ($movie) use ($pool) {
                return $pool->get('https://www.omdbapi.com/?i=' . $movie->imdb . '&apikey=6c2f1ca1');
            });
        });

        // Xử lý các phản hồi
        foreach ($responses as $key => $response) {
            if ($response->successful()) {
                $imdbRating_oscar = $response['Response'] == "True" && $response['imdbRating'] != "N/A"
                    ? $response['imdbRating']
                    : "0.0";
            } else {
                $imdbRating_oscar = "0.0";
            }
    
            $movie_oscar_with_ratings[] = [
                'movie' => $movies_oscar[$key],
                'imdbRating' => $imdbRating_oscar,
            ];
        }

        // MOVIE US
        $movie_us = Cache::remember('movie_us', 300, function () use ($country_ids) {
            return Movie::whereIn('country_id', $country_ids)
                ->where('type_movie', 0)
                ->where('status', 1)
                ->with(['episode', 'movie_image' => function ($thumb) {
                    $thumb->where('is_thumbnail', 0);
                }])
                ->orderBy('updated_at', 'DESC')
                ->limit(12)
                ->get(['id', 'title', 'updated_at', 'imdb','slug']);
        });
        $responses = Http::pool(function ($pool) use ($movie_us) {
            return collect($movie_us)->map(function ($movie) use ($pool) {
                return $pool->get('https://www.omdbapi.com/?i=' . $movie->imdb . '&apikey=6c2f1ca1');
            });
        });

        // Xử lý các phản hồi
        foreach ($responses as $key => $response) {
            if ($response->successful()) {
                $imdbRating_us = $response['Response'] == "True" && $response['imdbRating'] != "N/A"
                    ? $response['imdbRating']
                    : "0.0";
            } else {
                $imdbRating_us = "0.0";
            }
    
            $movie_us_with_ratings[] = [
                'movie' => $movie_us[$key],
                'imdbRating' => $imdbRating_us,
            ];
        }

        // MOVIE US COMING SOON
        $movie_us_coming = Cache::remember('movie_us_coming', 300, function () use ($country_ids) {
            return Movie::whereIn('country_id', $country_ids)
                ->where('status', 0)
                ->with(['movie_image' => function ($thumb) {
                    $thumb->where('is_thumbnail', 0);
                }])
                ->orderBy('updated_at', 'DESC')
                ->limit(4)
                ->get(['id', 'title', 'updated_at', 'imdb', 'status','slug']);
        });

        // TV SERIES THAILAND
        $tv_series = Cache::remember('tv_series', 300, function () {
            return Movie::where('type_movie', 1)
                ->where('status', 1)
                ->with(['episode', 'movie_image' => function ($thumb) {
                    $thumb->where('is_thumbnail', 0);
                }])
                ->orderBy('updated_at', 'DESC')
                ->limit(16)
                ->get(['id', 'title', 'updated_at', 'imdb','slug']);
        });
        
        $responses = Http::pool(function ($pool) use ($tv_series) {
            return collect($tv_series)->map(function ($movie) use ($pool) {
                return $pool->get('https://www.omdbapi.com/?i=' . $movie->imdb . '&apikey=6c2f1ca1');
            });
        });

        // Xử lý các phản hồi
        foreach ($responses as $key => $response) {
            if ($response->successful()) {
                $imdbRating = $response['Response'] == "True" && $response['imdbRating'] != "N/A"
                    ? $response['imdbRating']
                    : "0.0";
            } else {
                $imdbRating = "0.0";
            }
    
            $tv_series_with_ratings[] = [
                'movie' => $tv_series[$key],
                'imdbRating' => $imdbRating,
            ];
        }
       
       
        // HORROR MOVIES
        $movie_horror = Cache::remember('movie_horror', 300, function () {
            $gen_horror_slug = Genre::where('title', 'LIKE', '%kinh di%')->first();
            if (!$gen_horror_slug) {
                return collect();  // Trả về bộ sưu tập rỗng nếu không tìm thấy genre
            }
            $movie_ids = Movie_Genre::where('genre_id', $gen_horror_slug->id)->pluck('movie_id');

            return Movie::whereIn('id', $movie_ids)
                ->where('type_movie', 0)
                ->where('status', 1)
                ->with(['episode', 'movie_image' => function ($thumb) {
                    $thumb->where('is_thumbnail', 0);
                }])
                ->orderBy('updated_at', 'DESC')
                ->limit(12)
                ->get(['id', 'title', 'updated_at', 'imdb','slug']);
        });
        
        $responses = Http::pool(function ($pool) use ($movie_horror) {
            return collect($movie_horror)->map(function ($movie) use ($pool) {
                return $pool->get('https://www.omdbapi.com/?i=' . $movie->imdb . '&apikey=6c2f1ca1');
            });
        });

        // Xử lý các phản hồi
        foreach ($responses as $key => $response) {
            if ($response->successful()) {
                $imdbRating_horror = $response['Response'] == "True" && $response['imdbRating'] != "N/A"
                    ? $response['imdbRating']
                    : "0.0";
            } else {
                $imdbRating_horror = "0.0";
            }
    
            $movie_horror_with_ratings[] = [
                'movie' => $movie_horror[$key],
                'imdbRating' => $imdbRating_horror,
            ];
        }

        $api_ophim = Http::get('http://ophim1.com/danh-sach/phim-moi-cap-nhat');
        $url_update = $api_ophim['pathImage'];
        
        return view('pages.home', compact('category', 'genre', 'hot_with_ratings',  'movie_animation_with_ratings', 'movie_us_with_ratings', 'tv_series_with_ratings', 'movie_horror_with_ratings', 'url_update','movie_oscar_with_ratings','movie_netflix_with_ratings','movie_us_coming','topview'));
    }
    public function category($slug)
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
        //qua ba

        $cate_movie = Category::where('slug', $slug)->first();
        $category_page = Movie::with(['movie_image' => function ($thumb) {
            $thumb->where('is_thumbnail', 0);
        }])->with(['episode' => function ($ep) {
            $ep->orderBy('episode', 'ASC');
        }])->where('status', 1)->where('category_id', $cate_movie->id)->paginate(20);

        $movie_cate_with_ratings = [];

       
        $responses = Http::pool(function ($pool) use ($category_page) {
            return $category_page->map(function ($movie) use ($pool) {
                return $pool->get('https://www.omdbapi.com/?i=' . $movie->imdb . '&apikey=6c2f1ca1');
            });
        });
        foreach ($responses as $key => $response) {
            if ($response->successful()) {
                $imdbRating_country = ($response['Response'] == "True" && $response['imdbRating'] != "N/A")
                    ? $response['imdbRating']
                    : "0.0";
            } else {
                $imdbRating_country = "0.0";
            }

            $movie_cate_with_ratings[] = [
                'movie' => $category_page[$key],
                'imdbRating' => $imdbRating_country,
            ];
        }
       
        $api_ophim = Http::get('http://ophim1.com/danh-sach/phim-moi-cap-nhat');
        $url_update = $api_ophim['pathImage'];
        return view('pages.category', compact('category', 'genre', 'country', 'movie_cate_with_ratings', 'url_update','cate_movie','category_page'));
    }
    public function year($year)
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
        if ($year == 'more') {
            $movie = Movie::where('status', 1)->where('year', '<', 2000)->with(['episode' => function ($query) {
                $query->orderBy('episode', 'ASC');
            }])->with(['movie_image' => function ($thumb) {
                $thumb->where('is_thumbnail', 1);
            }])->orderBy('updated_at', 'DESC')->paginate(40);
        } else {

            $movie = Movie::where('status', 1)->where('year', $year)->with(['episode' => function ($query) {
                $query->orderBy('episode', 'ASC');
            }])->with(['movie_image' => function ($thumb) {
                $thumb->where('is_thumbnail', 1);
            }])->orderBy('updated_at', 'DESC')->paginate(20);
        }
        $api_ophim = Http::get('http://ophim1.com/danh-sach/phim-moi-cap-nhat');
        $url_update = $api_ophim['pathImage'];
        //dd($movie);
        return view('pages.year', compact('category', 'genre', 'country', 'year', 'movie', 'url_update'));
    }

    public function tag($tag)
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
        $tag = $tag;
        $movie = Movie::join('movie_tags', 'movies.id', '=', 'movie_tags.movie_id')->where('tags', 'LIKE', '%' . $tag . '%')->where('status', 1)->with(['episode' => function ($query) {
            $query->orderBy('episode', 'ASC');
        }])->with(['movie_image' => function ($thumb) {
            $thumb->where('is_thumbnail', 1);
        }])->orderBy('updated_at', 'DESC')->paginate(20);
        $api_ophim = Http::get('http://ophim1.com/danh-sach/phim-moi-cap-nhat');
        $url_update = $api_ophim['pathImage'];
        //dd($movie);
        return view('pages.tag', compact('category', 'genre', 'country', 'tag', 'movie', 'url_update'));
    }
    public function genre($slug)
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
        $gen_slug = Genre::where('slug', $slug)->first();
        if (!isset($gen_slug)) {
            return redirect()->back();
        }
        $movie_genre = Movie_Genre::where('genre_id', $gen_slug->id)->get();
        $many_genre = [];
        foreach ($movie_genre as $key => $movi) {
            $many_genre[] = $movi->movie_id;
        }
        $movie_genre = Movie::whereIn('id', $many_genre)->where('status', 1)->with(['episode' => function ($query) {
            $query->orderBy('episode', 'ASC');
        }])->with(['movie_image' => function ($thumb) {
            $thumb->where('is_thumbnail', 0);
        }])->orderBy('updated_at', 'DESC')->paginate(20);
        $movie_genre_with_ratings = [];

       
        $responses = Http::pool(function ($pool) use ($movie_genre) {
            return $movie_genre->map(function ($movie) use ($pool) {
                return $pool->get('https://www.omdbapi.com/?i=' . $movie->imdb . '&apikey=6c2f1ca1');
            });
        });
        foreach ($responses as $key => $response) {
            if ($response->successful()) {
                $imdbRating_genre = ($response['Response'] == "True" && $response['imdbRating'] != "N/A")
                    ? $response['imdbRating']
                    : "0.0";
            } else {
                $imdbRating_genre = "0.0";
            }

            $movie_genre_with_ratings[] = [
                'movie' => $movie_genre[$key],
                'imdbRating' => $imdbRating_genre,
            ];
        }
        $api_ophim = Http::get('http://ophim1.com/danh-sach/phim-moi-cap-nhat');
        $url_update = $api_ophim['pathImage'];
        //dd($many_genre);
        return view('pages.genre', compact('category', 'genre', 'country', 'gen_slug', 'movie_genre_with_ratings', 'url_update','movie_genre'));
    }
    public function country($slug)
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
        $count_slug = Country::where('slug', $slug)->first();
        if (!isset($count_slug)) {
            return redirect()->back();
        }
        $movie_country = Movie::where('country_id', $count_slug->id)->where('status', 1)->withCount(['episode' => function ($query) {
            $query->select(DB::raw('count(distinct(episode))'));
        }])->orderBy('updated_at', 'DESC')->paginate(20);
        
            
        $movie_country_with_ratings = [];

        $responses = Http::pool(function ($pool) use ($movie_country) {
            return $movie_country->map(function ($movie) use ($pool) {
                return $pool->get('https://www.omdbapi.com/?i=' . $movie->imdb . '&apikey=6c2f1ca1');
            });
        });
        foreach ($responses as $key => $response) {
            if ($response->successful()) {
                $imdbRating_country = ($response['Response'] == "True" && $response['imdbRating'] != "N/A")
                    ? $response['imdbRating']
                    : "0.0";
            } else {
                $imdbRating_country = "0.0";
            }

            $movie_country_with_ratings[] = [
                'movie' => $movie_country[$key],
                'imdbRating' => $imdbRating_country,
            ];
        }
        
        $api_ophim = Http::get('http://ophim1.com/danh-sach/phim-moi-cap-nhat');
        $url_update = $api_ophim['pathImage'];
        return view('pages.country', compact('category', 'genre', 'country', 'count_slug', 'movie_country_with_ratings', 'url_update','movie_country'));
    }
    public function all_movies()
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();

        $movie = Movie::where('status', 1)->withCount(['episode' => function ($query) {
            $query->select(DB::raw('count(distinct(episode))'));
        }])->orderBy('updated_at', 'DESC')->paginate(8);
        //dd($many_genre);
        return view('pages.allmovies', compact('category', 'genre', 'country', 'movie'));
    }
    public function directors($slug)
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
        $directors_slug = Directors::where('slug', $slug)->first();
        if (!isset($directors_slug)) {
            return redirect()->back();
        }
        $movie_directors = Movie_Directors::where('directors_id', $directors_slug->id)->get();
        $many_directors = [];
        foreach ($movie_directors as $key => $movi) {
            $many_directors[] = $movi->movie_id;
        }
        $movie = Movie::whereIn('id', $many_directors)->where('status', 1)->withCount(['episode' => function ($query) {
            $query->select(DB::raw('count(distinct(episode))'));
        }])->orderBy('updated_at', 'DESC')->paginate(20);
        $api_ophim = Http::get('http://ophim1.com/danh-sach/phim-moi-cap-nhat');
        $url_update = $api_ophim['pathImage'];
        //dd($many_genre);
        return view('pages.directors', compact('category', 'genre', 'country', 'directors_slug', 'movie', 'url_update'));
    }
    public function cast($slug)
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
        $cast_slug = Cast::where('slug', $slug)->first();
        if (!isset($cast_slug)) {
            return redirect()->back();
        }
        $movie_cast = Movie_Cast::where('cast_id', $cast_slug->id)->get();

        $many_cast = [];
        foreach ($movie_cast as $key => $movi) {
            $many_cast[] = $movi->movie_id;
        }
        $movie = Movie::whereIn('id', $many_cast)->where('status', 1)->withCount(['episode' => function ($query) {
            $query->select(DB::raw('count(distinct(episode))'));
        }])->orderBy('updated_at', 'DESC')->paginate(20);
        $api_ophim = Http::get('http://ophim1.com/danh-sach/phim-moi-cap-nhat');
        $url_update = $api_ophim['pathImage'];
        //dd($many_genre);
        return view('pages.cast', compact('category', 'genre', 'country', 'cast_slug', 'movie', 'url_update'));
    }
    public function movie(Request $request, $slug)
    {

        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        $movie_thumbnail = Movie::select('id')->with(['movie_image' => function ($thumb) {
            $thumb->where('is_thumbnail', 1);
        }])->where('slug', $slug)->where('status', 1)->first();

        $movie = Movie::with('category', 'genre', 'country', 'movie_genre', 'movie_cast', 'movie_directors', 'movie_tags', 'movie_views')->where('slug', $slug)->where('status', 1)->first();
        if (!isset($movie)) {
            return redirect()->back();
        }
        $minutes = Movie::select('time')->where('slug', $slug)->first();
        if (floor($minutes->time / 60) == 0) {
            $times = ($minutes->time - floor($minutes->time / 60) * 60) . 'm';
        } elseif (($minutes->time - floor($minutes->time / 60) * 60) == 0) {
            $times = floor($minutes->time / 60) . 'h';
        } else
            $times = floor($minutes->time / 60) . 'h ' . ($minutes->time - floor($minutes->time / 60) * 60) . 'm';

        $related = Movie::where('status', 1)->whereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", [$movie->title])->where('category_id', $movie->category->id)->whereNotIn('slug', [$slug])->with(['episode' => function ($query) {
            $query->orderBy('episode', 'ASC');
        }])->with(['movie_image' => function ($thumb) {
            $thumb->where('is_thumbnail', 1);
        }])->paginate(5);
        //dd($related);
        $episode_first = Episode::with('movie')->where('movie_id', $movie->id)->orderBy('episode', 'ASC')->take(1)->first();
        //lay tap phim
        $query = "CAST(episode AS SIGNED INTEGER) DESC";
        $episode = Episode::with('movie')->where('movie_id', $movie->id)->orderByRaw($query)->take(4)->get()->unique('episode');
        //dd($episode);
        //lay tap da them link
        $episode_current_list = Episode::with('movie')->where('movie_id', $movie->id)->get()->unique('episode');
        $episode_current_list_count = $episode_current_list->count();

        //xu ly api from imdb
        // if ($is_conn == true) {
        $api_imdb = Http::get('https://www.omdbapi.com/?i=' . $movie->imdb . '&apikey=6c2f1ca1');


        if ($api_imdb->status() == 200) {
            if ($api_imdb['Response'] == "True" && $api_imdb['imdbRating'] != "N/A") {
                $values = $api_imdb['imdbRating'];
            } elseif ($api_imdb['Response'] == "False") {
                $values = "N/A";
            } elseif ($api_imdb['Response'] == "True") {
                $values = $api_imdb['imdbRating'];
            }
        } else
            return $values = "N/A";
        // } else
        //     return $values = "Connection false!";

        //save views movie for day
        $day = Carbon::today('Asia/Ho_Chi_Minh')->subDays(0)->startOfDay();

        
        $count_view = Movie_Views::where('movie_id', $movie->id)->where('date_views', $day)->first();
        if ($count_view) {
            $count_views = $count_view->count_views + 1;
            $count_view->count_views = $count_views;
            //dd($count_view);
            $count_view->save();
        } else {
            $count_view = new Movie_Views();
            $count_view->count_views = '1';
            $count_view->movie_id = $movie->id;
            $count_view->date_views = Carbon::now('Asia/Ho_Chi_Minh')->format('Y:m:d');
            $count_view->save();
        }
        
        $api_ophim = Http::get('http://ophim1.com/danh-sach/phim-moi-cap-nhat');
        $url_update = $api_ophim['pathImage'];

        return view('pages.movie', compact('category', 'genre', 'movie', 'related', 'episode', 'episode_first', 'episode_current_list_count', 'times', 'values', 'movie_thumbnail', 'url_update'));
    }
    public function add_rating(Request $request)
    {
        $data = $request->all();
        $ip_address = $request->ip();

        //reviews get ip_address

        // $rating_count = Rating::where('movie_id', $data['movie_id'])->where('ip_address', $ip_address)->count();
        // if ($rating_count > 0) {
        //     echo 'exist';
        // } else {
        //     $rating = new Rating();
        //     $rating->movie_id = $data['movie_id'];
        //     $rating->rating = $data['index'];
        //     $rating->ip_address = $ip_address;
        //     $rating->save();
        //     echo 'done';
        // }

        //reviews free
        $rating = new Rating();
        $rating->movie_id = $data['movie_id'];
        $rating->rating = $data['index'];
        $rating->ip_address = $ip_address;
        $rating->save();
        echo 'done';
    }
    public function title($slug, $tap)
    {
        $movie = Movie::where('slug', $slug)->where('status', 1)->first();
        //dd($movie);
        $tapphim = $tap;
        return view('layout', compact('movie', 'tapphim'));
    }
    public function watch($slug, $tap, $server_active)
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        //$genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        //$country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
        $movie = Movie::with('category', 'genre', 'country', 'episode')->where('slug', $slug)->where('status', 1)->first();
        
        foreach($movie->movie_genre->take(2) as $gen){
            $genre[]=$gen->title;
        }
        $thumbnail = Movie::select('id')->with(['movie_image' => function ($thumb) {
            $thumb->where('is_thumbnail', 1);
        }])->where('slug', $slug)->first();
        
        $minutes = $movie->time;
        if (floor($minutes / 60) == 0) {
            $times = ($minutes - floor($minutes / 60) * 60) . 'm';
        } elseif (($minutes - floor($minutes / 60) * 60) == 0) {
            $times = floor($minutes / 60) . 'h';
        } else
            $times = floor($minutes / 60) . 'h ' . ($minutes - floor($minutes / 60) * 60) . 'm';
        //save views movie for day
        $day = Carbon::today('Asia/Ho_Chi_Minh')->subDays(0)->startOfDay();

        $count_view = Movie_Views::where('movie_id', $movie->id)->where('date_views', $day)->first();
        if ($count_view) {
            $count_views = $count_view->count_views + 1;
            $count_view->count_views = $count_views;
            //dd($count_view);
            $count_view->save();
        } else {
            $count_view = new Movie_Views();
            $count_view->count_views = '1';
            $count_view->movie_id = $movie->id;
            $count_view->date_views = Carbon::now('Asia/Ho_Chi_Minh')->format('Y:m:d');
            $count_view->save();
        }
        if (!isset($movie)) {
            return redirect()->back();
        }
        $related = Movie::with('category', 'genre', 'country')->where('status', 1)->whereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", [$movie->title])->where('category_id', $movie->category->id)->whereNotIn('slug', [$slug])->with(['episode' => function ($query) {
            $query->orderBy('episode', 'ASC');
        }])->with(['movie_image' => function ($thumb) {
            $thumb->where('is_thumbnail', 1);
        }])->take(20)->get();

        $ser = substr($server_active, 7, 10);

        try {
            if (isset($tap)) {
                $tapphim = $tap;
                $tapphim = substr($tap, 4, 10);
                
            } else {
                $tapphim = 1;
                
            }

            $server = Server::orderby('id', 'DESC')->get();
            // $views = Movie::select('title', DB::raw('SUM(count_views) as count_views'))->groupBy('title')->join('movie_views', 'movies.id', '=', 'movie_views.movie_id')
            //     ->where('movies.id', $movie->id)->orderBy('count_views', 'DESC')->first();

            $episode_movie = Episode::where('movie_id', $movie->id)->get()->unique('server_id');
            $query = "CAST(episode AS SIGNED INTEGER) ASC";
            $episode_list = Episode::where('movie_id', $movie->id)->orderByRaw($query)->get();

            $api_imdb = Http::get('https://www.omdbapi.com/?i=' . $movie->imdb . '&apikey=2233412b');
            
            if ($api_imdb->status() == 200) {
                if ($api_imdb['Response'] == "True" && $api_imdb['imdbRating'] != "N/A") {
                    $values = $api_imdb['imdbRating'] . ' /10';
                } elseif ($api_imdb['Response'] == "False") {
                    $values = "N/A";
                } elseif ($api_imdb['Response'] == "True") {
                    $values = $api_imdb['imdbRating'];
                }
            } else
                return $values = "N/A";
            $episode_current_list = Episode::with('movie')->where('movie_id', $movie->id)->get()->unique('episode');
            $episode_current_list_count = $episode_current_list->count();
            $api_ophim = Http::get('http://ophim1.com/danh-sach/phim-moi-cap-nhat');
            $url_update = $api_ophim['pathImage'];
            return view('pages.watch', compact('category', 'movie', 'related', 'tapphim', 'server', 'episode_movie', 'episode_list', 'server_active', 'times', 'values', 'episode_current_list_count', 'url_update','genre','thumbnail'));
        } catch (ModelNotFoundException $th) {
            return redirect()->back();
        }
        //}

        //return response()->json($movie);
    }
    public function episode()
    {
        return view('pages.episode');
    }
    //loc phim
    public function locphim()
    {

        //get
        $sort = $_GET['order'];
        $category_get = $_GET['category'];
        $genre_get = $_GET['genre'];
        $country_get = $_GET['country'];
        $year_get = $_GET['year'];

        if ($sort == "" && $category_get == "" && $genre_get == "" && $country_get == "" && $year_get == "") {

            return redirect()->back();
        } else {
            $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
            $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
            $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
            $movie_array = Movie::withCount(['episode' => function ($query) {
                $query->select(DB::raw('count(distinct(episode))'));
            }])->with(['movie_image' => function ($thumb) {
                $thumb->where('is_thumbnail', 1);
            }])->where('status', 1);

            if ($category_get) {
                $movie_array = $movie_array->where('category_id', $category_get);
            }
            if ($country_get) {
                $movie_array = $movie_array->where('country_id', $country_get);
            }
            if ($year_get) {
                $movie_array = $movie_array->where('year', $year_get);
            }
            if ($sort == 'count_views') {
                // $movie_array = $movie_array->join('movie_views', 'movies.id', '=', 'movie_views.movie_id')->orderBy($sort, 'DESC');
            }
            if ($sort == 'created_at') {
                $movie_array = $movie_array->orderBy('created_at', 'DESC');
            }
            if ($sort == 'title') {
                $movie_array = $movie_array->orderBy('title', 'ASC');
            }

            if ($genre_get) {
                $gen_slug = Genre::where('id', $genre_get)->first();
                $movie_genre = Movie_Genre::where('genre_id', $gen_slug->id)->get();
                $many_genre = [];
                foreach ($movie_genre as $key => $movi) {
                    $many_genre[] = $movi->movie_id;
                }
                $movie_array = $movie_array->whereIn('id', $many_genre);
            }


            // $movie_array = $movie_array->with('movie_genre');

            // $movie = array();
            // foreach ($movie_array as $mov) {
            //     dd($mov);
            //     foreach ($mov->movie_genre as $mov_gen) {
            //         $movie = $movie_array->whereIn('genre_id', [$mov_gen->genre_id]);
            //     }
            // }

            $movie = $movie_array->paginate(20);
            $api_ophim = Http::get('http://ophim1.com/danh-sach/phim-moi-cap-nhat');
            $url_update = $api_ophim['pathImage'];
            return view('pages.locphim', compact('category', 'genre', 'country', 'movie', 'url_update'));
        }
    }
    public function my_list()
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        // $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        // $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();


        return view('pages.my_list', compact('category'));
    }
    public function recent()
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        // $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        // $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();


        return view('pages.my_recent', compact('category'));
    }

    public function policy()
    {
        return view('pages.policy');
    }
    public function watches($slug)
    {
        return redirect()->back();
    }

    public function ajax_episode($slug, $tap, $server_active)
    {      
        $movie = Movie::with('episode')->where('slug', $slug)->where('status', 1)->first();
        if (!isset($movie)) {
            return response()->json([
                'success' => false,
            ]);
        }
        $ser = substr($server_active, 7, 10);

        try {
            if (isset($tap)) {
                $tapphim = $tap;
                $tapphim = substr($tap, 4, 10);
                $episode = Episode::where('movie_id', $movie->id)->where('episode', $tapphim)->where('server_id', $ser)->first();
                if (!isset($episode)) {
                    return response()->json([
                        'success' => false,
                    ]);
                }
            } else {
                $tapphim = 1;
                $episode = Episode::where('movie_id', $movie->id)->where('episode', $tapphim)->where('server_id', $ser)->first();
            }
            

            return response()->json([
                'success' => true,
                'data' => $episode->linkphim
            ]);
        } catch (ModelNotFoundException $th) {
            return response()->json([
                'success' => false,
            ]);
        }
    }
}
