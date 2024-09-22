<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\Cast;
use App\Models\Directors;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App;
use App\Models\Server;
use Illuminate\Support\Facades\URL;

class CreateSiteMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sitemap = App::make('sitemap');
        // add home pages mặc định
        $sitemap->add(URL::to('/'), Carbon::now('Asia/Ho_Chi_Minh'), '1.0', 'daily');

        //get all genres
        $genre = Genre::all();
        foreach ($genre as $gen) {
            $sitemap->add(URL::to('/') . "/genre/{$gen->slug}", Carbon::now('Asia/Ho_Chi_Minh'), '0.5', 'daily');
        }
        //get all categorys
        $category = Category::all();
        foreach ($category as $cate) {
            $sitemap->add(URL::to('/') . "/category/{$cate->slug}", Carbon::now('Asia/Ho_Chi_Minh'), '0.6', 'daily');
        }
        //get all countrys
        $country = Country::all();
        foreach ($country as $coun) {
            $sitemap->add(URL::to('/') . "/country/{$coun->slug}", Carbon::now('Asia/Ho_Chi_Minh'), '0.6', 'daily');
        }
        //get all movies
        $movies = Movie::all();
        foreach ($movies as $movie) {
            $sitemap->add(URL::to('/') . "/movie/{$movie->slug}", Carbon::now('Asia/Ho_Chi_Minh'), '0.9', 'daily');

            //get all tags

            $tagss = [];
            $tagss = explode(',', $movie->movie_tags->tags);

            foreach ($tagss as $key => $tag) {
                $sitemap->add(URL::to('/') . "/tag/{$tag}", Carbon::now('Asia/Ho_Chi_Minh'), '0.8', 'daily');
            }
        }
        //get all directors
        $directors = Directors::all();
        foreach ($directors as $director) {
            $sitemap->add(URL::to('/') . "/directors/{$director->slug}", Carbon::now('Asia/Ho_Chi_Minh'), '0.5', 'daily');
        }

        //get all cast
        $cast = Cast::all();
        foreach ($cast as $ca) {
            $sitemap->add(URL::to('/') . "/cast/{$ca->slug}", Carbon::now('Asia/Ho_Chi_Minh'), '0.5', 'daily');
        }
        //get years
        for ($year = 2000; $year <= now()->year; $year++) {
            $sitemap->add(URL::to('/') . "/nam/{$year}", Carbon::now('Asia/Ho_Chi_Minh'), '0.1', 'daily');
        }

        //get all episodes
        $server = Server::all();
        $movi = Movie::all();
        foreach ($movi as $mo) {
            foreach ($server as $key => $ser) {
                $episode_movie = Episode::where('movie_id', $mo->id)->get()->unique('server_id');
                foreach ($episode_movie as $key => $ser_mov) {
                    if ($ser_mov->server_id == $ser->id) {
                        $episode_list = Episode::where('movie_id', $mo->id)->get();
                        foreach ($episode_list as $key => $ep) {
                            if ($ep->server_id == $ser->id) {
                                $sitemap->add(URL::to('/') . "/xem-phim/{$mo->slug}/tap-{$ep->episode}/server-{$ep->server_id}", Carbon::now('Asia/Ho_Chi_Minh'), '0.9', 'daily');
                            }
                        }
                    }
                }
            }
        }

        $sitemap->store('xml', 'sitemap');
        if (File::exists(public_path() . '/sitemap.xml')) {
            File::copy(public_path('sitemap.xml'), base_path('sitemap.xml'));
        }
    }
}
