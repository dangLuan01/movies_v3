<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Genre;
use App\Models\Movie;
use Carbon\Carbon;
use DateTime;
use Google_Client;
use Illuminate\Http\Request;
use PragmaRX\Tracker\Support\Minutes;
use Spatie\Analytics\AnalyticsFacade as Analytics;
use PragmaRX\Tracker\Vendor\Laravel\Facade as Tracker;
use PragmaRX\Tracker\Vendor\Laravel\Support\Session;
use PragmaRX\Tracker\Vendor\Laravel\Models\Session as Browser;
use Illuminate\Support\Facades\DB;
//use Analytics;
use Spatie\Analytics\Period;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $range = new Minutes();

        $range->setStart(Carbon::now()->subDays(365));

        $range->setEnd(Carbon::now()->subDay(0));

        //$onlineusers = Tracker::onlineUsers()->count();
        $pageViews = Tracker::pageViews($range);
        //dd($pageViews);
        // foreach ($pageViews as $key => $value) {
        //     $totalView = $value->total;
        // }
        $day = Carbon::today('Asia/Ho_Chi_Minh')->subDays(0)->startOfDay();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $week = Carbon::today('Asia/Ho_Chi_Minh')->subDays(7)->startOfDay();

        $total_movie_home = Movie::count();
        $total_category_home = Category::count();
        $total_genre_home = Genre::count();
        $total_country_home = Country::count();
        $total_user_home = Customer::count();

        $top_browser = Browser::join('tracker_agents', 'tracker_sessions.agent_id', '=', 'tracker_agents.id')
            ->select('browser', DB::raw('count(*) as total'))->groupBy('browser')->orderBy('total', 'DESC')->take(5)->get();


        $topview_week = Movie::select('title', DB::raw('SUM(count_views) as count_views'))->groupBy('title')->join('movie_views', 'movies.id', '=', 'movie_views.movie_id')->whereBetween('date_views', [$week, $day])->where('status', 1)->orderBy('count_views', 'DESC')->paginate(20)->unique('title');

        $topview_month = Movie::select('title', DB::raw('SUM(count_views) as count_views'))->groupBy('title')->join('movie_views', 'movies.id', '=', 'movie_views.movie_id')->whereBetween('date_views', [$startOfMonth, $endOfMonth])->where('status', 1)->orderBy('count_views', 'DESC')->paginate(20)->unique('title');

        $topview = Movie::select('title', DB::raw('SUM(count_views) as count_views'))->groupBy('title')->join('movie_views', 'movies.id', '=', 'movie_views.movie_id')->where('status', 1)->orderBy('count_views', 'DESC')->paginate(20)->unique('title');


        return view('home', compact('total_movie_home', 'total_category_home', 'total_genre_home', 'total_country_home', 'total_user_home', 'pageViews', 'top_browser', 'topview_week', 'topview_month', 'topview'));
    }
    public function online()
    {
        $onlineUsers = Tracker::onlineUsers()->count();
        echo $onlineUsers;
    }
}
