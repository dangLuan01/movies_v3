<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PragmaRX\Tracker\Support\Minutes;
use PragmaRX\Tracker\Vendor\Laravel\Facade as Tracker;
use PragmaRX\Tracker\Vendor\Laravel\Support\Session;


class TrackingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view log');
    }
    public function index()
    {

        // select('devices', DB::raw('count(*) as total'))
        //     ->groupBy('devices')->orderBy('total', 'DESC')->get();
        if (isset(($_GET['date_start'])) && isset(($_GET['date_end']))) {
            $range = new Minutes();

            $range->setStart($_GET['date_start']);

            $range->setEnd($_GET['date_end']);

            $sessions = Tracker::sessions($range);

            return view('admincp.tracker.index', compact('sessions'));
        };

        $range = new Minutes();

        $range->setStart(Carbon::now()->subDays(2));

        $range->setEnd(Carbon::now()->subDay(0));

        $sessions = Tracker::sessions($range);

        return view('admincp.tracker.index', compact('sessions'));
    }
    public function tracking_error()
    {

        $range = new Minutes();

        $range->setStart(Carbon::now()->subDays(30));

        $range->setEnd(Carbon::now()->subDay(0));

        $errors = Tracker::errors($range);
        //dd($errors);
        return view('admincp.tracker.error', compact('errors'));
    }
}
