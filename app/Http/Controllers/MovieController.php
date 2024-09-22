<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Movie_Genre;
use App\Models\Movie_Description;
use App\Models\Movie_Trailer;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Episode;
use App\Models\Movie_Tags;
use App\Models\Movie_Views;
use App\Models\Movie_Image;
use App\Models\Cast;
use App\Models\Directors;
use App\Models\Movie_Cast;
use App\Models\Movie_Directors;
use App\Models\Server;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use function PHPUnit\Framework\isNull;
use Illuminate\Support\Facades\Http;
use Image;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:viewer list', ['only' => 'index']);
        $this->middleware('permission:create movie', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit movie', ['only' => ['update', 'edit', 'movie_hot']]);
        $this->middleware('permission:delete movie', ['only' => ['destroy']]);
        $this->middleware('permission:viewer list|create movie|edit movie', ['update_season', 'update_year']);
    }
    public function index()
    {
        try {
            $category = Category::where('status', 1)->pluck('title', 'id');
            $genre = Genre::where('status', 1)->pluck('title', 'id');
            $list_genre = Genre::all()->where('status', 1);
            $country = Country::where('status', 1)->pluck('title', 'id');
            $list = Movie::with('category', 'movie_genre', 'country', 'genre', 'movie_description', 'movie_trailer', 'movie_tags', 'movie_image', 'movie_cast')->withCount(['episode' => function ($query) {
                $query->select(DB::raw('count(distinct(episode))'));
            }])->orderBy('id', 'DESC')->get();

            $path = public_path() . "/json/";
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            File::put($path . 'movie.json', json_encode($list));
            //return json_encode($list);

            return view('admincp.movie.index', compact('list', 'genre', 'category', 'country', 'list_genre'));
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $category = Category::where('status', 1)->pluck('title', 'id');
            $genre = Genre::where('status', 1)->pluck('title', 'id');
            $list_genre = Genre::all()->where('status', 1);
            $list_cast = Cast::all()->where('status', 1)->reverse();
            $list_directors = Directors::all()->where('status', 1)->reverse();
            $country = Country::where('status', 1)->pluck('title', 'id');
            $list = Movie::with('category', 'movie_genre', 'movie_cast', 'movie_directors', 'country', 'genre', 'movie_description', 'movie_trailer', 'movie_tags')->orderBy('id', 'DESC')->get();

            // $path = public_path() . "/json/";
            // if (!is_dir($path)) {
            //     mkdir($path, 0777, true);
            // }
            // File::put($path . 'movie.json', json_encode($list));

            //return json_encode($list);
            return view('admincp.movie.form', compact('genre', 'category', 'country', 'list_genre', 'list_cast', 'list_directors'));
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $datas = $request->thuocphim;
            if ($datas == 0) {
                $validator = Validator::make($data = $request->all(), [
                    'title' => 'unique:movies',
                    // 'name_english' => 'unique:movies',
                    'slug' => 'unique:movies',
                ]);
            } else {
                $validator = Validator::make($data = $request->all(), [
                    'title' => 'unique:movies',
                    //'name_english' => 'unique:movies',
                    'slug' => 'unique:movies',
                ]);
            }

            if ($validator->fails()) {
                toastr()->warning('Movie "' . $data['title'] . '" is existing!', 'Warning');
                return redirect()->back();
            }
            //$data = $request->all();
            // $data = $request->validate(
            //     [
            //         //'title' => 'unique:movies ',
            //         'name_english' => 'unique:movies ',
            //         'slug' => 'unique:movies ',
            //     ]

            // );

            $movie = new Movie();
            $movie->title = $data['title'];
            $movie->name_english = $data['name_english'];

            $randomletter = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"), 0, 6);
            $movie->slug = $data['slug'] . '-' . rand(1000, 9999) . $randomletter;
            $movie->year = $data['year'];
            $movie->type_movie = $data['thuocphim'];
            $movie->time = $data['time'];
            $movie->hot = $data['hot'];
            $movie->quality = $data['quality'];
            $movie->paid_movie = $data['paid_movie'];
            $movie->language = $data['language'];
            //$movie->phim_hot = $data['phim_hot'];
            $movie->status = $data['status'];
            $movie->sotap = $data['sotap'];

            $movie->category_id = $data['category_id'];

            $movie->country_id = $data['country_id'];
            $movie->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $movie->updated_at = Carbon::now('Asia/Ho_Chi_Minh');

            if (!isset($data['genre'])) {
                toastr()->warning('Genre not empty!', 'Warning');
                return redirect()->back();
            } else {
                foreach ($data['genre'] as $key => $gen) {
                    // $movie->genre_id = $gen['0'];
                    $movie->genre_id = $gen['0'];
                }
            }

            try {
                $path_omdb = 'http://www.omdbapi.com/?t=';
                //0 = movie
                if ($data['thuocphim'] == 0) {
                    $api_omdb = Http::get($path_omdb . $data['name_english'] . '&y=' . $data['year'] . '&type=movie&apikey=6c2f1ca1');
                }
                //1 = series
                else {
                    $api_omdb = Http::get($path_omdb . $data['name_english'] . '&y=' . $data['year'] . '&type=series&apikey=6c2f1ca1');
                }
                if ($api_omdb['Response'] != 'True' && $data['thuocphim'] == 1) {
                    $api_omdb = Http::get($path_omdb . $data['name_english'] . '&type=series&apikey=6c2f1ca1');
                } elseif ($api_omdb['Response'] != 'True') {
                    $api_omdb = Http::get($path_omdb . $data['name_english'] . '&apikey=6c2f1ca1');
                }

                // $imdb = new Movie_Rating();
                $movie->imdb = $api_omdb['imdbID'];
                // $imdb->movie_id = $movie->id;
                $movie->save();
            } catch (Exception $e) {
                //$imdb = new Movie_Rating();
                $movie->imdb  = "0";
                //$imdb->movie_id = $movie->id;
                $movie->save();
                toastr()->warning('Vui lòng cập nhật Id Imdb thủ công cho phim.', 'Warning', ['timeOut' => 10000]);
            }

            //dd($data['genre']);
            //$movie->save();
            $movie->movie_genre()->attach($data['genre']);

            $get_image = $request->file('image');
            $path = 'uploads/movie/';
            if ($get_image) {
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $new_image = $name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension();
                $get_image->move($path, $new_image);
                // $movie->image = $new_image;

                $movie_image = new Movie_Image();
                $movie_image->image = $new_image;
                $movie_image->movie_id = $movie->id;
                $movie_image->save();
            }

            $get_image_thumbnail = $request->file('image_thumbnail');

            //dd($get_image_thumbnail);
            if ($get_image_thumbnail) {
                $get_name_image_thumnail = $get_image_thumbnail->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image_thumnail));
                $new_image_thumbnail = $name_image . rand(0, 9999) . '.' . $get_image_thumbnail->getClientOriginalExtension();
                $get_image_thumbnail->move($path, $new_image_thumbnail);

                // $img_thumbnail = Image::make($get_image_thumbnail->path());
                // $img_thumbnail->resize(1200, 600, function ($constraint) {
                //     $constraint->aspectRatio();
                // })->save($path . '' . $new_image_thumbnail);

                $movie_image_thumbnail = new Movie_Image();
                $movie_image_thumbnail->movie_id = $movie->id;
                $movie_image_thumbnail->image = $new_image_thumbnail;
                $movie_image_thumbnail->is_thumbnail = 1;
                $movie_image_thumbnail->save();
            }


            // if (!is_null($movie)) {
            //     try {
            //         $path_omdb='http://www.omdbapi.com/?t=';
            //         //0 = movie
            //         if($data['thuocphim'] == 0){
            //             $api_omdb = Http::get($path_omdb . $data['name_english'] . '&y=' . $data['year'] .'&type=movie&apikey=6c2f1ca1');
            //         }
            //         //1 = series
            //         else{
            //             $api_omdb = Http::get($path_omdb . $data['name_english'] . '&y=' . $data['year'] .'&type=series&apikey=6c2f1ca1');
            //         }
            //         if ($api_omdb['Response'] != 'True' && $data['thuocphim'] == 1) {
            //             $api_omdb = Http::get($path_omdb . $data['name_english'] . '&type=series&apikey=6c2f1ca1');
            //         }
            //         elseif($api_omdb['Response'] != 'True'){
            //             $api_omdb = Http::get($path_omdb . $data['name_english'] . '&apikey=6c2f1ca1');
            //         }

            //         $imdb = new Movie_Rating();
            //         $imdb->imdb = $api_omdb['imdbID'];
            //         $imdb->movie_id = $movie->id;
            //         $imdb->save();
            //     } catch (Exception $e) {
            //         $imdb = new Movie_Rating();
            //         $imdb->imdb = "0";
            //         $imdb->movie_id = $movie->id;
            //         $imdb->save();
            //         toastr()->warning('Vui lòng cập nhật Id Imdb thủ công cho phim.', 'Warning',['timeOut' => 10000]);
            //     }

            // }
            if (!is_null($movie)) {
                $description = new Movie_Description();
                $description->description = $request->description;
                $description->movie_id = $movie->id;
                $description->save();
            }
            if (!is_null($movie)) {
                $trailer = new Movie_Trailer();
                $trailer->trailer = $request->trailer;
                $trailer->movie_id = $movie->id;
                $trailer->save();
            }
            // if (!is_null($movie)) {
            //     $hot = new Movie_Hot();
            //     $hot->hot = $request->hot;
            //     $hot->movie_id = $movie->id;
            //     $hot->save();
            // }

            if (!is_null($movie)) {
                $count_view = new Movie_Views();
                $count_view->count_views = '0';
                $count_view->movie_id = $movie->id;
                $count_view->date_views = Carbon::now('Asia/Ho_Chi_Minh')->format('Y:m:d');
                $count_view->save();
            }

            if (!is_null($movie)) {
                $tags = new Movie_Tags();
                $tags->tags = $request->tags;
                $tags->movie_id = $movie->id;
                $tags->save();
            }
            if ($request->logo != null && !is_null($movie)) {
                $logo = new Movie_Image();
                $logo->image = $request->logo;
                $logo->movie_id = $movie->id;
                $logo->is_logo = 1;
                $logo->save();
            }



            if (!isset($data['cast'])) {
                toastr()->warning('Cast of movie "' . $movie->title . '" empty!', 'Warning');
                //return redirect()->route('movie.index');
            } else {
                $movie->movie_cast()->attach($data['cast']);
            }

            if (!isset($data['directors'])) {
                toastr()->warning('Directors of movie "' . $movie->title . '" empty!', 'Warning');
                //return redirect()->route('movie.index');
            } else {
                $movie->movie_directors()->attach($data['directors']);
            }

            toastr()->success('Movie "' . $movie->title . '" created successfully!', 'Create');
            return redirect()->route('movie.index');
            //return redirect()->back()->with('message_add', 'Add film successfully !');
        } catch (Exception $e) {
            toastr()->error('Movie create error' . $e, 'Error');
            return redirect()->route('movie.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $category = Category::where('status', 1)->pluck('title', 'id');
        $genre = Genre::where('status', 1)->pluck('title', 'id');
        $list_genre = Genre::all()->where('status', 1);
        $list_cast = Cast::all()->where('status', 1);
        $list_directors = Directors::all()->where('status', 1);
        // $genre = Genre::pluck('title', 'id');
        // $list_genre = Genre::where('status')->all();
        $country = Country::where('status', 1)->pluck('title', 'id');
        $list = Movie::with('category', 'genre', 'country', 'movie_description', 'movie_trailer', 'movie_tags', 'movie_image')->orderBy('id', 'DESC')->get();
        $movie = Movie::find($id);
        $movie_thumbnail = Movie::select('id')->with(['movie_image' => function ($thumb) {
            $thumb->where('is_thumbnail', 1);
        }])->find($id);
        $movie_genre = $movie->movie_genre;
        $movie_cast = $movie->movie_cast;
        $movie_directors = $movie->movie_directors;
        $movie_description = $movie->movie_description;
        $movie_trailer = $movie->movie_trailer;
        $movie_tags = $movie->movie_tags;
        $movie_logo = $movie->movie_logo;
        $api_ophim = Http::get('https://ophim1.com/danh-sach/phim-moi-cap-nhat');
        $url_update = $api_ophim['pathImage'];

        //return json_encode($movie_rating);
        return view('admincp.movie.form', compact('list', 'genre', 'category', 'country', 'movie', 'list_genre', 'movie_genre', 'list_cast', 'movie_cast', 'list_directors', 'movie_directors', 'movie_thumbnail', 'url_update', 'movie_logo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        try {
            $movie = Movie::find($id);
            $validator = Validator::make($data = $request->all(), [
                'title' => Rule::unique('movies')->ignore($movie->id),
                // 'name_english' => Rule::unique('movies')->ignore($movie->id),
                'slug' => Rule::unique('movies')->ignore($movie->id),
            ]);
            if ($validator->fails()) {
                toastr()->warning('Movie is "' . $data['title'] . '" existing!', 'Warning');
                return redirect()->back();
            }
            //$data = $request->all();

            $movie->title = $data['title'];
            $movie->name_english = $data['name_english'];
            $movie->slug = $data['slug'];
            $movie->year = $data['year'];
            $movie->time = $data['time'];
            $movie->type_movie = $data['thuocphim'];
            $movie->quality = $data['quality'];
            $movie->language = $data['language'];
            $movie->imdb = $data['imdb'];
            $movie->paid_movie = $data['paid_movie'];
            $movie->hot = $data['hot'];
            $movie->status = $data['status'];
            $movie->sotap = $data['sotap'];
            $movie->category_id = $data['category_id'];
            $movie->country_id = $data['country_id'];

            $movie->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
            $episodes_count = Movie::withCount(['episode' => function ($query) {
                $query->select(DB::raw('count(distinct(episode))'));
            }])->find($id);

            if ($data['sotap'] < $episodes_count->episode_count) {
                toastr()->warning('Tổng tập phim không được nhỏ hơn số tập phim đã có! Vui lòng xem lại!', 'Warning');
                return redirect()->back();
            }
            if (!isset($data['genre'])) {
                toastr()->warning('Genre not empty!', 'Warning!');
                return redirect()->back();
            } else {
                foreach ($data['genre'] as $key => $gen) {
                    $movie->genre_id = $gen['0'];
                }
            }
            // try {
            //     $path_omdb = 'http://www.omdbapi.com/?t=';
            //     //0 = movie
            //     if ($data['thuocphim'] == 0) {
            //         $api_omdb = Http::get($path_omdb . $data['name_english'] . '&y=' . $data['year'] . '&type=movie&apikey=6c2f1ca1');
            //     }
            //     //1 = series
            //     else {
            //         $api_omdb = Http::get($path_omdb . $data['name_english'] . '&y=' . $data['year'] . '&type=series&apikey=6c2f1ca1');
            //     }
            //     if ($api_omdb['Response'] != 'True' && $data['thuocphim'] == 1) {
            //         $api_omdb = Http::get($path_omdb . $data['name_english'] . '&type=series&apikey=6c2f1ca1');
            //     } elseif ($api_omdb['Response'] != 'True') {
            //         $api_omdb = Http::get($path_omdb . $data['name_english'] . '&apikey=6c2f1ca1');
            //     }

            //     // $imdb = new Movie_Rating();
            //     $movie->imdb = $api_omdb['imdbID'];
            //     // $imdb->movie_id = $movie->id;
            //     $movie->save();
            // } catch (Exception $e) {
            //     //$imdb = new Movie_Rating();
            //     $movie->imdb  = "0";
            //     //$imdb->movie_id = $movie->id;
            //     $movie->save();
            //     toastr()->warning('Vui lòng cập nhật Id Imdb thủ công cho phim.', 'Warning', ['timeOut' => 10000]);
            // }
            $movie->save();
            $movie_image = Movie_Image::where('movie_id', $movie->id)->first();
            $get_image = $request->file('image');

            $path = 'uploads/movie/';

            if ($get_image) {
                if (file_exists($path . $movie_image->image)) {
                    unlink('uploads/movie/' . $movie_image->image);
                }
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $new_image = $name_image . rand(0, 9999) . '.' . $get_image->extension();
                $img = Image::make($get_image->path());
                $img->resize(300, 400, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path . '' . $new_image);

                // $get_image->move($path, $new_image);
                $movie_image->image = $new_image;
                $movie_image->save();
            }


            $get_image_thumbnail = $request->file('image_thumbnail');
            $path = 'uploads/movie/';
            //dd($get_image_thumbnail);
            if ($get_image_thumbnail) {
                $movie_image_thumbnail = Movie_Image::where('movie_id', $movie->id)->where('is_thumbnail', 1)->first();
                if (file_exists($path . $movie_image_thumbnail->image) && $movie_image_thumbnail->image != '') {
                    unlink('uploads/movie/' . $movie_image_thumbnail->image);
                }
                $get_name_image_thumnail = $get_image_thumbnail->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image_thumnail));
                $new_image_thumbnail = $name_image . rand(0, 9999) . '.' . $get_image_thumbnail->getClientOriginalExtension();
                $img_thumbnail = Image::make($get_image_thumbnail->path());
                $img_thumbnail->resize(1200, 600, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path . '' . $new_image_thumbnail);

                $movie_image_thumbnail->image = $new_image_thumbnail;
                $movie_image_thumbnail->save();
            }

            //return json_encode($movie);

            // $movie->save();

            // $imdb = Movie_Rating::where('movie_id', $movie->id)->first();

            // if (!$imdb) {
            //     $imdb = new Movie_Rating();
            //     $imdb->movie_id = $movie->id;
            // }
            // $imdb->imdb = $request->imdb;
            // $imdb->save();

            $description = Movie_Description::where('movie_id', $movie->id)->first();

            if (!$description) {
                $description = new Movie_Description();
                $description->movie_id = $movie->id;
            }
            $description->description = $request->description;
            $description->save();

            $trailer = Movie_Trailer::where('movie_id', $movie->id)->first();

            if (!$trailer) {
                $trailer = new Movie_Trailer();
                $trailer->movie_id = $movie->id;
            }
            $trailer->trailer = $request->trailer;
            $trailer->save();

            // $hot = Movie_Hot::where('movie_id', $movie->id)->first();

            // if (!$hot) {
            //     $hot = new Movie_Hot();
            //     $hot->movie_id = $movie->id;
            // }
            // $hot->hot = $request->hot;
            // $hot->save();

            $tags = Movie_Tags::where('movie_id', $movie->id)->first();

            if (!$tags) {
                $tags = new Movie_Tags();
                $tags->movie_id = $movie->id;
            }
            $tags->tags = $request->tags;
            $tags->save();

            if ($request->logo != null) {
                $logo = Movie_Image::where('movie_id', $movie->id)->where('is_logo', 1)->first();

                if (!$logo) {
                    $logo = new Movie_Image();
                    $logo->movie_id = $movie->id;
                    $logo->is_logo = 1;
                }
                $logo->image = $request->logo;
                $logo->save();
            }


            $movie->movie_genre()->sync($data['genre']);
            if (!isset($data['cast'])) {
                toastr()->warning('Cast empty! But updated changes', 'Warning!');
                Movie_Cast::whereIn('movie_id', [$movie->id])->delete();
                // return redirect()->back();
            } else {
                $movie->movie_cast()->sync($data['cast']);
            }

            if (!isset($data['directors'])) {
                toastr()->warning('Directors empty! But updated changes', 'Warning!');
                Movie_Directors::whereIn('movie_id', [$movie->id])->delete();
                // return redirect()->back();
            } else {
                $movie->movie_directors()->sync($data['directors']);
            }
            // return redirect()->back()->with('message_update', 'Update film successfully !');

            toastr()->success('Movie "' . $movie->title . '" updated successfully!', 'Update');
            return redirect()->back();
            // } 
            // catch (\Throwable $th) {
            //     toastr()->error('Movie update error!', 'Error');
            // }
        } catch (\Throwable $th) {
            toastr()->error('Movie update error!', 'Error');
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $movie = Movie::find($id);
            $movie_image = Movie_Image::where('movie_id', $movie->id)->first();
            //delete image

            if (!empty($movie_image->image)) {
                try {
                    unlink('uploads/movie/' . $movie_image->image);
                } catch (Exception $e) {
                }
            }
            $movie_image->delete();

            $movie_thumbnail = Movie_Image::where('movie_id', $movie->id)->where('is_thumbnail', 1)->first();
            //delete image

            if (!empty($movie_thumbnail->image)) {
                try {
                    unlink('uploads/movie/' . $movie_image->image);
                } catch (Exception $e) {
                }
            }
            $movie_thumbnail->delete();

            Movie_Image::where('is_logo', 1)->where('movie_id',$movie->id)->delete();
            //delete genre
            Movie_Genre::whereIn('movie_id', [$movie->id])->delete();
            Episode::whereIn('movie_id', [$movie->id])->delete();
            Movie_Cast::whereIn('movie_id', [$movie->id])->delete();
            Movie_Directors::whereIn('movie_id', [$movie->id])->delete();

            $movie->delete();
            $movie_data = Movie::all()->toArray();

            toastr()->success('Movie "' . $movie->title . '" deleted successfully!', 'Delete');
            return redirect()->route('movie.index')->with('movie_data', $movie_data);
            //return redirect()->back()->with('movie_data', $movie_data);
            // return redirect()->back()->with('movie_data', $movie_data)->with('message_del', 'Delete film successfully!');
        } catch (Exception $e) {
            toastr()->error('Movie "' . $movie->title . '" delete error!', 'Error');
            return redirect()->route('movie.index');
        }
    }

    public function update_season(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->season = $data['season'];
        $movie->save();
        //toastr()->info('Movie "'.$movie->title.'" updated season success!','Update');

    }
    public function update_year(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->year = $data['year'];
        $movie->save();
    }
    public function movie_hot(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        // $hot = Movie_Hot::where('movie_id', $movie->id)->first();

        // if (!$hot) {
        //     $hot = new Movie_Hot();
        //     $hot->movie_id = $movie->id;
        // }
        $movie->hot = $data['moviehot_val'];
        $movie->save();
    }

    public function movie_status(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->status = $data['moviestatus_val'];
        $movie->save();
    }
    public function update_imdb(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->imdb = $data['imdbcode'];
        $movie->save();
    }
    public function get_api_ophim()
    {
        $movies = Movie::pluck('title');

        $path_ophim = "https://ophim1.com/danh-sach/phim-moi-cap-nhat?page=1";
        $api_ophim = Http::get($path_ophim)->json();
        
        $link_image = $api_ophim['pathImage'];

        if (isset($_GET['next_page'])) {
            $path_ophim = "https://ophim1.com/danh-sach/phim-moi-cap-nhat?page=" . $_GET['next_page'];
            $api_ophim = Http::get($path_ophim)->json();
            return view('admincp.movie.api_ophim', compact('api_ophim', 'link_image', 'movies'));
        }
        if (isset($_GET['search_ophim'])) {

            $path_ophim_search = "https://ophim1.com/v1/api/tim-kiem?keyword=" . $_GET['search_ophim'];
            $api_ophims = Http::get($path_ophim_search)->json();
            
            $api_ophim = $api_ophims['data'];
            return view('admincp.movie.api_ophim', compact('api_ophim', 'link_image', 'movies'));
        }

        return view('admincp.movie.api_ophim', compact('api_ophim', 'link_image', 'movies'));
    }
    public function auto_create(Request $request)
    {

        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'unique:movies',
            // 'name_english' => 'unique:movies',
            'slug' => 'unique:movies',
        ]);
        if ($validator->fails()) {
            toastr()->warning('Movie "' . $data['title'] . '" is existing!', 'Warning');
            return redirect()->back();
        }
        $path_ophim = "https://ophim1.com/phim/" . $data['slug'];
        $api_ophim = Http::get($path_ophim)->json();
        //dd(count($api_ophim['episodes']['0']['server_data']));

        if (preg_match('/(\d+)/', $api_ophim['movie']['time'], $matches)) {
            $time = $matches[0];
        }
        if (preg_match('/(\d+)/', $api_ophim['movie']['episode_total'], $matchess)) {
            $episode_total = $matchess[0];
        }
        //dd($time);
        //dd($api_ophim['movie']['category']['0']);

        $movie = new Movie();
        $movie->title = $api_ophim['movie']['name'];
        $movie->name_english = $api_ophim['movie']['origin_name'];

        $randomletter = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"), 0, 6);
        $movie->slug = $api_ophim['movie']['slug'] . '-' . rand(1000, 9999) . $randomletter;
        $movie->year = $api_ophim['movie']['year'];
        if ($api_ophim['movie']['type'] == 'single') {
            $movie->type_movie = 0;
        } else {
            $movie->type_movie = 1;
        }


        if (!isset($time)) {
            $movie->time = 0;
        } else {
            $movie->time = $time;
        }
        $movie->hot = 0;
        if ($api_ophim['movie']['quality'] == 'FHD') {
            $movie->quality = 0;
        } else if ($api_ophim['movie']['quality'] == 'HD') {
            $movie->quality = 2;
        } else {
            $movie->quality = 1;
        }

        $movie->paid_movie = 0;
        if ($api_ophim['movie']['lang'] == 'Vietsub') {
            $movie->language = 1;
        } else {
            $movie->language = 0;
        }
        $movie->status = 1;
        if (!isset($episode_total)) {
            $movie->sotap = count($api_ophim['episodes']['0']['server_data']);
        } else {
            $movie->sotap = $episode_total;
        }

        $country = Country::where('title', 'LIKE', '%' . $api_ophim['movie']['country']['0']['name'] . '%')->where('status', 1)->first();
        if (!isset($country)) {
            $coun = new Country();
            $coun->title = $api_ophim['movie']['country']['0']['name'];
            $coun->slug = $this->changeToSlug($api_ophim['movie']['country']['0']['name']);
            $coun->description = $api_ophim['movie']['country']['0']['name'];
            $coun->status = 1;
            $coun->save();
            $movie->country_id = $coun->id;
        } else {
            $movie->country_id = $country->id;
        }


        if ($api_ophim['movie']['type'] == 'single') {
            $category = Category::where('title', 'LIKE', '%Movies%')->where('status', 1)->first();
            $movie->category_id = $category->id;
        } else {
            $category = Category::where('title', 'LIKE', '%TV Series%')->where('status', 1)->first();
            $movie->category_id = $category->id;
        }
        $movie->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $movie->updated_at = Carbon::now('Asia/Ho_Chi_Minh');

        $genre = Genre::where('title', 'LIKE', '%' . $api_ophim['movie']['category']['0']['name'] . '%')->where('status', 1)->first();
        if (!isset($genre)) {
            $gen = new Genre();
            $gen->title = $api_ophim['movie']['category']['0']['name'];
            $gen->slug = $this->changeToSlug($api_ophim['movie']['category']['0']['name']);
            $gen->description = $api_ophim['movie']['category']['0']['name'];
            $gen->status = 1;
            $gen->save();
            $movie->genre_id = $gen->id;
        } else {
            $movie->genre_id = $genre->id;
        }


        try {
            $path_omdb = 'http://www.omdbapi.com/?t=';
            //0 = movie
            if ($api_ophim['movie']['type'] == 'single') {
                $api_omdb = Http::get($path_omdb . $api_ophim['movie']['origin_name'] . '&y=' . $api_ophim['movie']['year'] . '&type=movie&apikey=6c2f1ca1');
            }
            //1 = series
            else {
                $api_omdb = Http::get($path_omdb . $api_ophim['movie']['origin_name'] . '&y=' . $api_ophim['movie']['year'] . '&type=series&apikey=6c2f1ca1');
            }
            if ($api_omdb['Response'] != 'True' && $api_ophim['movie']['type'] == 'series') {
                $api_omdb = Http::get($path_omdb . $api_ophim['movie']['origin_name'] . '&type=series&apikey=6c2f1ca1');
            } elseif ($api_omdb['Response'] != 'True') {
                $api_omdb = Http::get($path_omdb . $api_ophim['movie']['origin_name'] . '&apikey=6c2f1ca1');
            }

            $movie->imdb = $api_omdb['imdbID'];
            $movie->save();
        } catch (Exception $e) {

            $movie->imdb  = "0";

            $movie->save();
            toastr()->warning('Vui lòng cập nhật Id Imdb thủ công cho phim.', 'Warning', ['timeOut' => 10000]);
        }


        foreach ($api_ophim['movie']['category'] as $genr) {
            $list_genre = Genre::whereIn('title', $genr)->where('status', 1)->pluck('id');
            $check_genre = Genre::where('title', 'LIKE', '%' . $genr['name'] . '%')->first();
            if (!isset($check_genre)) {
                $gen = new Genre();
                $gen->title = $genr['name'];
                $gen->slug = $this->changeToSlug($genr['name']);
                $gen->description = $genr['name'];
                $gen->status = 1;
                $gen->save();
                $movie->movie_genre()->attach($gen->id);
            } else {
                $movie->movie_genre()->attach($list_genre);
            }
        }

        $movie_image = new Movie_Image();
        $movie_image->image = $api_ophim['movie']['thumb_url'];
        $movie_image->movie_id = $movie->id;
        $movie_image->save();
        //save thumbnail
        $movie_image = new Movie_Image();
        $movie_image->image = $api_ophim['movie']['poster_url'];
        $movie_image->movie_id = $movie->id;
        $movie_image->is_thumbnail = 1;
        $movie_image->save();

        if (!is_null($movie)) {
            $description = new Movie_Description();
            $description->description = $api_ophim['movie']['content'];
            $description->movie_id = $movie->id;
            $description->save();
        }
        if (!is_null($movie)) {
            $trailer = new Movie_Trailer();
            if ($api_ophim['movie']['trailer_url'] != '') {
                // URL đầu vào
                $url = $api_ophim['movie']['trailer_url'];
                // Phân tích URL để lấy tham số truy vấn
                $queryString = parse_url($url, PHP_URL_QUERY);
                // Phân tích tham số truy vấn để lấy giá trị sau ?v=
                parse_str($queryString, $queryParams);
                $valueAfterV = $queryParams['v'];
                $trailer->trailer = $valueAfterV;
            } else {
                $trailer->trailer = 0;
            }
            $trailer->movie_id = $movie->id;
            $trailer->save();
        }

        if (!is_null($movie)) {
            $count_view = new Movie_Views();
            $count_view->count_views = '0';
            $count_view->movie_id = $movie->id;
            $count_view->date_views = Carbon::now('Asia/Ho_Chi_Minh')->format('Y:m:d');
            $count_view->save();
        }

        if (!is_null($movie)) {
            $tags = new Movie_Tags();
            $tags->tags = $api_ophim['movie']['name'] . ',' . $api_ophim['movie']['origin_name'];
            $tags->movie_id = $movie->id;
            $tags->save();
        }
        if ($api_ophim['movie']['actor']['0'] == '') {
            toastr()->warning('Actor of movie "' . $movie->title . '" empty!', 'Warning');
        } else {
            //$list_cast = Cast::whereIn('title', $api_ophim['movie']['actor'])->where('status', 1)->pluck('id');
            foreach ($api_ophim['movie']['actor'] as $cas) {

                $check_cast = Cast::where('title', 'LIKE', '%' . $cas . '%')->first();
                if (!isset($check_cast)) {
                    $cast = new Cast();
                    $cast->title = $cas;
                    $cast->slug = $this->changeToSlug($cas);
                    $cast->description = $cas;
                    $cast->status = 1;
                    $cast->save();
                    $movie->movie_cast()->attach($cast->id);
                } else {
                    $movie->movie_cast()->attach($check_cast->id);
                }
            }
        }

        if ($api_ophim['movie']['director']['0'] == '') {
            toastr()->warning('Directors of movie "' . $movie->title . '" empty!', 'Warning');
        } else {
            //$list_directors = Directors::whereIn('name', $api_ophim['movie']['director'])->where('status', 1)->pluck('id');
            foreach ($api_ophim['movie']['director'] as $director) {

                $check_director = Directors::where('name', 'LIKE', '%' . $director . '%')->first();
                if (!isset($check_director)) {
                    $directors = new Directors();
                    $directors->name = $director;
                    $directors->slug = $this->changeToSlug($director);
                    $directors->description = $director;
                    $directors->status = 1;
                    $directors->save();
                    $movie->movie_directors()->attach($directors->id);
                } else {
                    $movie->movie_directors()->attach($check_director->id);
                }
            }
        }
        foreach ($api_ophim['episodes'] as $episodes) {
            foreach ($episodes['server_data'] as $episode) {
                $ep = new Episode();
                $ep->movie_id = $movie->id;
                $ep->linkphim = "/api/embed_vip?link=" . $episode['link_m3u8'];
                $ep->episode = $episode['name'];
                $check_server = Server::where('title', 'LIKE', '%' . $episodes['server_name'] . '%')->first();
                if (!isset($check_server)) {
                    $server = new Server();
                    $server->title = $episodes['server_name'];
                    $server->description = $episodes['server_name'];
                    $server->status = 1;
                    $server->save();
                    $ep->server_id = $server->id;
                } else {
                    $ep->server_id = $check_server->id;
                }
                $ep->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $ep->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
                $ep->save();
            }
        }

        toastr()->success('Movie "' . $movie->title . '" created successfully!', 'Create');
        return redirect()->route('movie.index');
    }
    private function changeToSlug($str)
    {
        // Chuyển đổi chuỗi thành chữ thường
        // Chuyển đổi chuỗi thành chữ thường
        $str = strtolower($str);
        // Thay thế các ký tự không mong muốn bằng khoảng trắng
        $str = preg_replace('/[é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ]/', 'e', $str);
        $str = preg_replace('/[á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ]/', 'a', $str);
        $str = preg_replace('/[i|í|ì|ỉ|ĩ|ị]/', 'i', $str);
        $str = preg_replace('/[ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ]/', 'o', $str);
        $str = preg_replace('/[ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự]/', 'u', $str);
        $str = preg_replace('/[ý|ỳ|ỷ|ỹ|ỵ]/', 'y', $str);
        $str = preg_replace('/[đ]/', 'd', $str);
        $str = preg_replace('/[^a-z0-9\s-]/', '', $str);
        // Loại bỏ khoảng trắng ở đầu và cuối chuỗi
        $str = trim($str);
        // Thay thế khoảng trắng bằng dấu gạch ngang
        $str = preg_replace('/\s+/', '-', $str);
        // Đổi ký tự có dấu thành không dấu
        return $str;
    }
    public function auto_update_episode(Request $request)
    {
        $data = $request->all();
        $movie = Movie::with('episode')->select('id','updated_at')->where('title', $data['title'])->first();

        $path_ophim = "https://ophim1.com/phim/" . $data['slug'];
        $api_ophim = Http::get($path_ophim)->json();

        foreach ($api_ophim['episodes'] as $episodes) {
            foreach ($episodes['server_data'] as $episode) {
                $existingEpisodeNames = $movie->episode->pluck('episode')->toArray();
                if (!in_array($episode['name'], $existingEpisodeNames)) {
                    $ep = new Episode();
                    $ep->movie_id = $movie->id;
                    $ep->linkphim = "/api/embed_vip?link=" . $episode['link_m3u8'];
                    $ep->episode = $episode['name'];
                    $check_server = Server::where('title', 'LIKE', '%' . $episodes['server_name'] . '%')->first();

                    if (!isset($check_server)) {
                        $server = new Server();
                        $server->title = $episodes['server_name'];
                        $server->description = $episodes['server_name'];
                        $server->status = 1;
                        $server->save();
                        $ep->server_id = $server->id;
                    } else {
                        $ep->server_id = $check_server->id;
                    }
                    $ep->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                    $ep->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
                    $ep->save();
                    $movie->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
                    $movie->save();
                }
            }
        }
        toastr()->success('Mình đã thêm các tập mới nhất', 'Cập nhật thành công');
        return redirect()->back();
    }
}
