<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmbedController extends Controller
{
    public function embed_vip()
    {

        return view('admincp.embed_video.index');
    }
    public function embed_ads()
    {
        return view('admincp.embed_video.embed');
    }
    public function embed_m3u8()
    {
        return view('admincp.embed_video.m3u8');
    }
}
