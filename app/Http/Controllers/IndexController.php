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
            })->where('status', 1)->with(['movie_image' => function ($thumb) {
                $thumb->where('is_thumbnail', 1);
            }])->orderBy('id', 'DESC')->get();
            
            return response()->json($movie);
    }
    public function home()
    {
       
        $category = Cache::remember('categories', 3600, function () {
            return Category::orderBy('id', 'ASC')->where('status', 1)->get();
        });
  
       
          // Cache cho danh sách quốc gia 
            $country_ids = Cache::remember('country_ids', 600, function () {
                return Country::whereIn('title', ['Au My', 'Phap', 'Anh', 'Y', 'Duc'])->pluck('id');
            });
            $movies_data = Cache::remember('movies_combined', 300, function () use ($country_ids) {
            // Tìm các thể loại
            $hoat_hinh_slug = Genre::where('title', 'LIKE', '%hoat hinh%')->first();
            $netflix_slug = Genre::where('title', 'LIKE', '%netflix%')->first();
            $oscar_slug = Genre::where('title', 'LIKE', '%Oscar%')->first();
            $horror_slug = Genre::where('title', 'LIKE', '%kinh di%')->first();
        
            $hoat_hinh_ids = $hoat_hinh_slug ? Movie_Genre::where('genre_id', $hoat_hinh_slug->id)->pluck('movie_id') : collect();
            $netflix_ids = $netflix_slug ? Movie_Genre::where('genre_id', $netflix_slug->id)->pluck('movie_id') : collect();
            $oscar_ids = $oscar_slug ? Movie_Genre::where('genre_id', $oscar_slug->id)->pluck('movie_id') : collect();
            $horror_ids = $horror_slug ? Movie_Genre::where('genre_id', $horror_slug->id)->pluck('movie_id') : collect();
        
            return [
                'hot_movies' => Movie::where('hot', 1)
                    ->where('status', 1)
                    ->with(['episode', 'movie_image' => function ($thumb) {
                        $thumb->where('is_thumbnail', 0);
                    }])
                    ->orderBy('updated_at', 'DESC')
                    ->limit(9)
                    ->get(),
        
                'hoat_hinh_movies' => Movie::whereIn('id', $hoat_hinh_ids)
                    ->where('status', 1)
                    ->with(['episode', 'movie_image' => function ($thumb) {
                        $thumb->where('is_thumbnail', 0);
                    }])
                    ->orderBy('updated_at', 'DESC')
                    ->limit(10)
                    ->get(['id', 'title', 'updated_at', 'imdb', 'slug']),
        
                'netflix_movies' => Movie::whereIn('id', $netflix_ids)
                    ->where('status', 1)
                    ->with(['episode', 'movie_image' => function ($thumb) {
                        $thumb->where('is_thumbnail', 0);
                    }])
                    ->orderBy('updated_at', 'DESC')
                    ->limit(1)
                    ->get(['id', 'title', 'updated_at', 'imdb', 'slug']),
        
                'oscar_movies' => Movie::whereIn('id', $oscar_ids)
                    ->where('status', 1)
                    ->with(['episode', 'movie_image' => function ($thumb) {
                        $thumb->where('is_thumbnail', 0);
                    }])
                    ->orderBy('updated_at', 'DESC')
                    ->limit(1)
                    ->get(['id', 'title', 'updated_at', 'imdb', 'slug']),
        
                'us_movies' => Movie::whereIn('country_id', $country_ids)
                    ->where('type_movie', 0)
                    ->where('status', 1)
                    ->with(['episode', 'movie_image' => function ($thumb) {
                        $thumb->where('is_thumbnail', 0);
                    }])
                    ->orderBy('updated_at', 'DESC')
                    ->limit(12)
                    ->get(['id', 'title', 'updated_at', 'imdb', 'slug']),
        
                'horror_movies' => Movie::whereIn('id', $horror_ids)
                    ->where('type_movie', 0)
                    ->where('status', 1)
                    ->with(['episode', 'movie_image' => function ($thumb) {
                        $thumb->where('is_thumbnail', 0);
                    }])
                    ->orderBy('updated_at', 'DESC')
                    ->limit(12)
                    ->get(['id', 'title', 'updated_at', 'imdb', 'slug']),
        
                // Thêm TV Series (Phim bộ)
                'tv_series' => Movie::where('type_movie', 1)
                    ->where('status', 1)
                    ->with(['episode', 'movie_image' => function ($thumb) {
                        $thumb->where('is_thumbnail', 0);
                    }])
                    ->orderBy('updated_at', 'DESC')
                    ->limit(16)
                    ->get(['id', 'title', 'updated_at', 'imdb', 'slug']),
        
                // Thêm Phim Mỹ Sắp Chiếu (us_coming)
                // 'us_coming' => Movie::where('type_movie', 0)
                //     ->where('country_id', $country_ids)
                //     ->where('status', 0) 
                //     ->with(['episode', 'movie_image' => function ($thumb) {
                //         $thumb->where('is_thumbnail', 0);
                //     }])
                //     ->orderBy('updated_at', 'ASC') 
                //     ->limit(1)
                //     ->get(['id', 'title', 'updated_at', 'imdb', 'slug']),
            ];
        });
        
        $hot_movies = $movies_data['hot_movies'];
        $hoat_hinh_movies = $movies_data['hoat_hinh_movies'];
        $netflix_movies = $movies_data['netflix_movies'];
        $oscar_movies = $movies_data['oscar_movies'];
        $us_movies = $movies_data['us_movies'];
        $horror_movies = $movies_data['horror_movies'];
        $tv_series = $movies_data['tv_series'];        
        // $us_coming = $movies_data['us_coming'];       
     

        $all_movies = $hot_movies->concat($hoat_hinh_movies)
        ->concat($netflix_movies)
        ->concat($oscar_movies)
        ->concat($us_movies)
        ->concat($horror_movies)
        ->concat($tv_series);
        // ->concat($us_coming); 

        $hot_count = count($hot_movies);
        $hoat_hinh_count = count($hoat_hinh_movies);
        $netflix_count = count($netflix_movies);
        $oscar_count = count($oscar_movies);
        $us_count = count($us_movies);
        $horror_count = count($horror_movies);
        $tv_series_count = count($tv_series);
        // $us_coming_count = count($us_coming);
        
        $cache_key = 'movies_with_ratings';
        $cachedMovies = Cache::store('important_cache')->get($cache_key, []);
        //dd($cachedMovies);
        // Lọc ra các phim chưa có trong cache
        $movies_to_request = $all_movies->filter(function ($movie) use ($cachedMovies) {
            return !isset($cachedMovies[$movie->imdb]);
        });
        
        // Nếu có phim chưa có trong cache, gửi request tới OMDB
        if ($movies_to_request->isNotEmpty()) {
            $responses = Http::pool(function ($pool) use ($movies_to_request) {
                return $movies_to_request->map(function ($movie) use ($pool) {
                    return $pool->get('https://www.omdbapi.com/?i=' . $movie->imdb . '&apikey=f9536f23');
                });
            });
           
            // Xử lý phản hồi và lưu vào cache
            foreach ($responses as $key => $response) {
                $imdbRating = $response->successful() && $response['Response'] == "True" && $response['imdbRating'] != "N/A"
                    ? $response['imdbRating']
                    : "0.0";
                
                $cachedMovies[$movies_to_request->values()->get($key)->imdb] = $imdbRating;
            }
            $newMovies=$cachedMovies;
            
            $mergedMovies = array_merge($cachedMovies, $newMovies);

            Cache::store('important_cache')->forever($cache_key, $mergedMovies);
        }

        // Danh sách phim với IMDb rating
        $hot_with_ratings = [];
        $movie_animation_with_ratings = [];
        $movie_netflix_with_ratings = [];
        $movie_oscar_with_ratings = [];
        $movie_us_with_ratings = [];
        $movie_horror_with_ratings = [];
        $tv_series_with_ratings = [];
        // $movie_us_coming = [];

        // Xử lý phản hồi cho tất cả các phim
        foreach ($all_movies as $key => $movie) {
            $imdbRating = $cachedMovies[$movie->imdb] ?? "0.0";

        // Dựa vào $key để phân loại phản hồi thành các danh sách phim
        if ($key < $hot_count) {
        // Phim hot
            $hot_with_ratings[] = [
            'movie' => $hot_movies[$key],
            'imdbRating' => $imdbRating,
            ];
        } 
        elseif ($key < $hot_count + $hoat_hinh_count) {
        // Phim hoạt hình
            $movie_animation_with_ratings[] = [
            'movie' => $hoat_hinh_movies[$key - $hot_count],
            'imdbRating' => $imdbRating,
            ];
        } elseif ($key < $hot_count + $hoat_hinh_count + $netflix_count) {
        // Phim Netflix
            $movie_netflix_with_ratings[] = [
            'movie' => $netflix_movies[$key - $hot_count - $hoat_hinh_count],
            'imdbRating' => $imdbRating,
            ];
        } elseif ($key < $hot_count + $hoat_hinh_count + $netflix_count + $oscar_count) {
        // Phim Oscar
            $movie_oscar_with_ratings[] = [
            'movie' => $oscar_movies[$key - $hot_count - $hoat_hinh_count - $netflix_count],
            'imdbRating' => $imdbRating,
            ];
        } elseif ($key < $hot_count + $hoat_hinh_count + $netflix_count + $oscar_count + $us_count) {
        // Phim Mỹ
            $movie_us_with_ratings[] = [
            'movie' => $us_movies[$key - $hot_count - $hoat_hinh_count - $netflix_count - $oscar_count],
            'imdbRating' => $imdbRating,
            ];
        } elseif ($key < $hot_count + $hoat_hinh_count + $netflix_count + $oscar_count + $us_count + $horror_count) {
        // Phim kinh dị
            $movie_horror_with_ratings[] = [
            'movie' => $horror_movies[$key - $hot_count - $hoat_hinh_count - $netflix_count - $oscar_count - $us_count],
            'imdbRating' => $imdbRating,
            ];
        } else {
        // Phim bộ
            $tv_series_with_ratings[] = [
            'movie' => $tv_series[$key - $hot_count - $hoat_hinh_count - $netflix_count - $oscar_count - $us_count - $horror_count],
            'imdbRating' => $imdbRating,
            ];
        } 
        // else {
        // // Phim Mỹ sắp chiếu
        //     $movie_us_coming[] = [
        //     'movie' => $us_coming[$key - $hot_count - $hoat_hinh_count - $netflix_count - $oscar_count - $us_count - $horror_count - $tv_series_count],
        //     'imdbRating' => $imdbRating,
        //     ];
        // }
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
        $api_ophim = Http::get('http://ophim1.com/danh-sach/phim-moi-cap-nhat');
        $url_update = $api_ophim['pathImage'];
      
        return view('pages.home', compact('category', 'hot_with_ratings',  'movie_animation_with_ratings', 'movie_us_with_ratings', 'tv_series_with_ratings', 'movie_horror_with_ratings', 'url_update','movie_oscar_with_ratings','movie_netflix_with_ratings','topview'));
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
        }])->where('status', 1)->where('category_id', $cate_movie->id)->orderBy('updated_at','DESC')->paginate(20);

        $cache_key = 'movies_with_rating';
        $cachedMovies= Cache::store('important_cache')->get($cache_key,[]);
        $movies_to_request = $category_page->filter(function ($movie) use ($cachedMovies) {
            return !isset($cachedMovies[$movie->imdb]);
        });
        
        if ($movies_to_request->isNotEmpty()) {
            $responses = Http::pool(function ($pool) use ($movies_to_request) {
                return $movies_to_request->map(function ($movie) use ($pool) {
                    return $pool->get('https://www.omdbapi.com/?i=' . $movie->imdb . '&apikey=f9536f23');
                });
            });
           
            // Xử lý phản hồi và lưu vào cache
            foreach ($responses as $key => $response) {
                $imdbRating = $response->successful() && $response['Response'] == "True" && $response['imdbRating'] != "N/A"
                    ? $response['imdbRating']
                    : "0.0";
                
                $cachedMovies[$movies_to_request->values()->get($key)->imdb] = $imdbRating;
            }
            $newMovies=$cachedMovies;
            
            $mergedMovies = array_merge($cachedMovies, $newMovies);

            Cache::store('important_cache')->forever($cache_key, $mergedMovies);
        }

        
        $movie_cate_with_ratings = [];

       
        foreach ($category_page as $key => $movie) {
            $imdbRating = $cachedMovies[$movie->imdb] ?? "0.0";
           
            $movie_cate_with_ratings[]=[
                'movie' => $category_page[$key],
                'imdbRating' => $imdbRating,
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
        //$tag = $tag;
        $movie_tag = Movie::join('movie_tags', 'movies.id', '=', 'movie_tags.movie_id')->where('tags', 'LIKE', '%' . $tag . '%')->where('status', 1)->with(['episode' => function ($query) {
            $query->orderBy('episode', 'ASC');
        }])->with(['movie_image' => function ($thumb) {
            $thumb->where('is_thumbnail', 0);
        }])->orderBy('updated_at', 'DESC')->paginate(20);

        $movie_tag_with_ratings = [];

       
        $responses = Http::pool(function ($pool) use ($movie_tag) {
            return $movie_tag->map(function ($movie) use ($pool) {
                return $pool->get('https://www.omdbapi.com/?i=' . $movie->imdb . '&apikey=6c2f1ca1');
            });
        });
        foreach ($responses as $key => $response) {
            if ($response->successful()) {
                $imdbRating_tag = ($response['Response'] == "True" && $response['imdbRating'] != "N/A")
                    ? $response['imdbRating']
                    : "0.0";
            } else {
                $imdbRating_tag = "0.0";
            }

            $movie_tag_with_ratings[] = [
                'movie' => $movie_tag[$key],
                'imdbRating' => $imdbRating_tag,
            ];
        }
        
        $api_ophim = Http::get('http://ophim1.com/danh-sach/phim-moi-cap-nhat');
        $url_update = $api_ophim['pathImage'];
        return view('pages.tag', compact('category', 'genre', 'country', 'tag', 'movie_tag', 'url_update','movie_tag_with_ratings'));
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
        $movie_directors = Movie::whereIn('id', $many_directors)->where('status', 1)->withCount(['episode' => function ($query) {
            $query->select(DB::raw('count(distinct(episode))'));
        }])->orderBy('updated_at', 'DESC')->paginate(20);

        $movie_directors_with_ratings = [];

       
        $responses = Http::pool(function ($pool) use ($movie_directors) {
            return $movie_directors->map(function ($movie) use ($pool) {
                return $pool->get('https://www.omdbapi.com/?i=' . $movie->imdb . '&apikey=6c2f1ca1');
            });
        });
        foreach ($responses as $key => $response) {
            if ($response->successful()) {
                $imdbRating = ($response['Response'] == "True" && $response['imdbRating'] != "N/A")
                    ? $response['imdbRating']
                    : "0.0";
            } else {
                $imdbRating = "0.0";
            }

            $movie_directors_with_ratings[] = [
                'movie' => $movie_directors[$key],
                'imdbRating' => $imdbRating,
            ];
        }

        $api_ophim = Http::get('http://ophim1.com/danh-sach/phim-moi-cap-nhat');
        $url_update = $api_ophim['pathImage'];
        //dd($many_genre);
        return view('pages.directors', compact('category', 'genre', 'country', 'directors_slug', 'movie_directors', 'url_update','movie_directors_with_ratings'));
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
        $movies_cast = Movie::whereIn('id', $many_cast)->where('status', 1)->withCount(['episode' => function ($query) {
            $query->select(DB::raw('count(distinct(episode))'));
        }])->orderBy('updated_at', 'DESC')->paginate(20);

        $movie_cate_with_ratings = [];

        $responses = Http::pool(function ($pool) use ($movies_cast) {
            return $movies_cast->map(function ($movie) use ($pool) {
                return $pool->get('https://www.omdbapi.com/?i=' . $movie->imdb . '&apikey=6c2f1ca1');
            });
        });
        foreach ($responses as $key => $response) {
            if ($response->successful()) {
                $imdbRating = ($response['Response'] == "True" && $response['imdbRating'] != "N/A")
                    ? $response['imdbRating']
                    : "0.0";
            } else {
                $imdbRating = "0.0";
            }

            $movie_cate_with_ratings[] = [
                'movie' => $movies_cast[$key],
                'imdbRating' => $imdbRating,
            ];
        }
        $api_ophim = Http::get('http://ophim1.com/danh-sach/phim-moi-cap-nhat');
        $url_update = $api_ophim['pathImage'];

        return view('pages.cast', compact('category', 'genre', 'country', 'cast_slug', 'movies_cast', 'url_update','movie_cate_with_ratings'));
    }
    public function movie(Request $request, $slug)
    {

        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
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
        }])->paginate(15);
        //dd($related);
        // $episode_first = Episode::with('movie')->where('movie_id', $movie->id)->orderBy('episode', 'ASC')->take(1)->first();
        //lay tap phim
        $query = "CAST(episode AS SIGNED INTEGER) DESC";
        $episode = Episode::with('movie')->where('movie_id', $movie->id)->orderByRaw($query)->get()->unique('episode');
        
        //lay tap da them link
        // $episode_current_list = Episode::with('movie')->where('movie_id', $movie->id)->get()->unique('episode');
        // $episode_current_list_count = $episode_current_list->count();
        // dd($episode_current_list_count);
        //xu ly api from imdb

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
            $values = "N/A";

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

        return view('pages.movie', compact('category', 'movie', 'related', 'episode', 'times', 'values', 'url_update'));
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
        $movie = Movie::with('category', 'episode')->where('slug', $slug)->where('status', 1)->first();
        
        
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
            $thumb->where('is_thumbnail', 0);
        }])->take(20)->get();
      
        $cache_key = 'movies_with_rating';
        $cachedMovies= Cache::store('important_cache')->get($cache_key,[]);
        $movies_to_request = $related->filter(function ($movies) use ($cachedMovies) {
            return !isset($cachedMovies[$movies->imdb]);
        });
        
        if ($movies_to_request->isNotEmpty()) {
            $responses = Http::pool(function ($pool) use ($movies_to_request) {
                return $movies_to_request->map(function ($movies) use ($pool) {
                    return $pool->get('https://www.omdbapi.com/?i=' . $movies->imdb . '&apikey=f9536f23');
                });
            });
           
            // Xử lý phản hồi và lưu vào cache
            foreach ($responses as $key => $response) {
                $imdbRating = $response->successful() && $response['Response'] == "True" && $response['imdbRating'] != "N/A"
                    ? $response['imdbRating']
                    : "0.0";
                
                $cachedMovies[$movies_to_request->values()->get($key)->imdb] = $imdbRating;
            }
            $newMovies=$cachedMovies;
            
            $mergedMovies = array_merge($cachedMovies, $newMovies);

            Cache::store('important_cache')->forever($cache_key, $mergedMovies);

        }

        
        $movie_relate_with_ratings = [];

       
        foreach ($related as $key => $mov) {
            $imdbRating = $cachedMovies[$mov->imdb] ?? "0.0";
           
            $movie_relate_with_ratings[]=[
                'movie' => $related[$key],
                'imdbRating' => $imdbRating,
            ];
        }
        $ser = substr($server_active, 7, 10);

        try {
            if (isset($tap)) {
                $tapphim = $tap;
                $tapphim = substr($tap, 4, 10);
                
            } else {
                $tapphim = 1;
                
            }

            $server = Server::orderby('id', 'DESC')->get();

            $episode_movie = Episode::where('movie_id', $movie->id)->get()->unique('server_id');
            $query = "CAST(episode AS SIGNED INTEGER) ASC";
            $episode_list = Episode::where('movie_id', $movie->id)->orderByRaw($query)->get();

            $episode_current_list = Episode::with('movie')->where('movie_id', $movie->id)->get()->unique('episode');
            $episode_current_list_count = $episode_current_list->count();
            $api_ophim = Http::get('http://ophim1.com/danh-sach/phim-moi-cap-nhat');
            $url_update = $api_ophim['pathImage'];

            return view('pages.watch', compact('category', 'movie', 'movie_relate_with_ratings', 'tapphim', 'server', 'episode_movie', 'episode_list', 'server_active', 'episode_current_list_count','url_update'));
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
        $name_get = $_GET['movie'];
        $category_get = $_GET['category'];
        $genre_get = $_GET['genre'];
        $country_get = $_GET['country'];
        $year_get = $_GET['year'];

        if ($name_get == "" && $category_get == "" && $genre_get == [''] && $country_get == "" && $year_get == "") {

            return redirect()->back();
        } else {
            $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
            $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
            $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
            $movie_array = Movie::withCount(['episode' => function ($query) {
                $query->select(DB::raw('count(distinct(episode))'));
            }])->with(['movie_image' => function ($thumb) {
                $thumb->where('is_thumbnail', 0);
            }])->where('status', 1);

            if($name_get) {
                $movie_array = $movie_array->whereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", [$name_get]);
            }
            if ($category_get) {
                $movie_array = $movie_array->where('category_id', $category_get);
            }
            if ($country_get) {
                $movie_array = $movie_array->where('country_id', $country_get);
            }
            if ($year_get) {
                $movie_array = $movie_array->where('year', $year_get);
            }

            if ($genre_get != ['']) {
               
                $gen_slug = Genre::whereIn('slug', $genre_get)->get();
                $gen_slug_arr=[];
                foreach ($gen_slug as $key => $gen_arr) {
                    $gen_slug_arr[] = $gen_arr->id;
                }
                $movie_genre = Movie_Genre::whereIn('genre_id', $gen_slug_arr)->get();

                $many_genre = [];
                foreach ($movie_genre as $key => $movi) {
                    $many_genre[] = $movi->movie_id;
                }
                $movie_array = $movie_array->whereIn('id', $many_genre);
            }

            $movie_filter = $movie_array->paginate(20);

            $cache_key = 'movies_with_rating';
            $cachedMovies= Cache::store('important_cache')->get($cache_key,[]);
            $movies_to_request = $movie_filter->filter(function ($movie) use ($cachedMovies) {
                return !isset($cachedMovies[$movie->imdb]);
            });
            
            if ($movies_to_request->isNotEmpty()) {
                $responses = Http::pool(function ($pool) use ($movies_to_request) {
                    return $movies_to_request->map(function ($movie) use ($pool) {
                        return $pool->get('https://www.omdbapi.com/?i=' . $movie->imdb . '&apikey=f9536f23');
                    });
                });
               
                // Xử lý phản hồi và lưu vào cache
                foreach ($responses as $key => $response) {
                    $imdbRating = $response->successful() && $response['Response'] == "True" && $response['imdbRating'] != "N/A"
                        ? $response['imdbRating']
                        : "0.0";
                    
                    $cachedMovies[$movies_to_request->values()->get($key)->imdb] = $imdbRating;
                }
                $newMovies=$cachedMovies;
                
                $mergedMovies = array_merge($cachedMovies, $newMovies);
    
                Cache::store('important_cache')->forever($cache_key, $mergedMovies);
            }

            $movie_filter_with_ratings = [];

            foreach ($movie_filter as $key => $movie) {
                $imdbRating = $cachedMovies[$movie->imdb] ?? "0.0";
               
                $movie_filter_with_ratings[]=[
                    'movie' => $movie_filter[$key],
                    'imdbRating' => $imdbRating,
                ];
            }
            $api_ophim = Http::get('http://ophim1.com/danh-sach/phim-moi-cap-nhat');
            $url_update = $api_ophim['pathImage'];
            return view('pages.locphim', compact('category', 'genre', 'country', 'movie_filter', 'url_update','movie_filter_with_ratings'));
        }
    }
    public function my_list()
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();

        return view('pages.my_list', compact('category'));
    }
    public function recent()
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();

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
