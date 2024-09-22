<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class MaintanceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin']);
    }
    
    public function index()
    {
        return view('admincp.maintance.form');
    }
    public function down()
    {
        Artisan::call('down',[
            '--refresh' => '59',
            '--secret'=> 'devmagic',
        ]);
        toastr()->info('Enable Maintenance Success!','Maintenance');
        return redirect()->back();
    }
    public function up()
    {
        Artisan::call('up');
        toastr()->info('Disable Maintenance Success!','Maintenance');
        return redirect()->back();
    }
}
