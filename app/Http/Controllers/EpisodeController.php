<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\Server;
use Exception;
use Illuminate\Support\Carbon;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:viewer list',['only'=>'index']);
        $this->middleware('permission:create episode',['only'=>['create','store']]);
        $this->middleware('permission:edit episode',['only'=>['update','edit']]);
        $this->middleware('permission:delete episode',['only'=>['destroy']]);
    }
    public function index()
    {
        $list_servers=Server::orderBy('id', 'DESC')->get();
        $list_episode = Episode::with('movie')->orderBy('movie_id', 'DESC')->get();
        return view('admincp.episode.index',compact('list_episode','list_servers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $list_episode = Episode::with('movie')->orderBy('movie_id', 'DESC')->get();

        $list_movie = Movie::orderBy('id', 'DESC')->pluck('title', 'id')->toArray();

        $list_server=Server::orderBy('id', 'DESC')->pluck('title', 'id');
        return view('admincp.episode.form', compact('list_movie', 'list_episode','list_server'));
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
            $data = $request->all();
            $episode_check = Episode::where('episode', $data['episode'])->where('movie_id', $data['movie_id'])->where('server_id',$data['servermovie'])->count();
            if ($episode_check > 0) {
                toastr()->warning('Episode "'.$data['episode'].'" already existing in the system!', 'Warning');
                return redirect()->back();
            } else {
                //$data = $request->all();
                $ep = new Episode();
                $ep->movie_id = $data['movie_id'];
                $ep->linkphim = $data['link'];
                $ep->linkdownload = $data['linkdownload'];
                $ep->episode = $data['episode'];
                $ep->server_id = $data['servermovie'];
                $ep->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $ep->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
                $ep->save();
                $movie = Movie::find($data['movie_id']);
                $movie->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
                $movie->save();
                toastr()->success('Added episode susccessfully!', 'Success');
                return redirect()->back();
            }
        } catch (Exception $e) {
            toastr()->error('Add episode error!', 'Error');
            return redirect()->back();
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
        $list_episode = Episode::with('movie')->orderBy('movie_id', 'DESC')->get();
        $list_movie = Movie::orderBy('id', 'DESC')->pluck('title', 'id');
        $episode = Episode::find($id);
        $list_server=Server::orderBy('id', 'DESC')->pluck('title', 'id');
        return view('admincp.episode.form', compact('episode', 'list_movie', 'list_episode','list_server'));
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
        $data = $request->all();
        $ep = Episode::find($id);
        //$ep->movie_id = $data['movie_id'];
        $ep->linkphim = $data['link'];
        $ep->linkdownload = $data['linkdownload'];
        $ep->episode = $data['episode'];
        $ep->server_id = $data['servermovie'];
        //$ep->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $ep->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
        $ep->save();
        toastr()->success('Update episode susccessfully!', 'Success');
        return redirect()->route('episode.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $episode = Episode::find($id)->delete();
        toastr()->success('Delete episode susccessfully!', 'Success');
        return redirect()->route('episode.index');
    }
    public function select_movie()
    {
        $id = $_GET['id'];
        $movie = Movie::find($id);
        $output = '<option value="" >--Chon tap--</option>';
        if ($movie->type_movie == '1')
            for ($i = 1; $i <= $movie->sotap; $i++) {
                $output .= '<option value="' . $i . '">' . $i . '</option>';
            }
        else {
            $output .= '<option value="HD">HD</option>
            <option value="FHD">FHD</option>
            <option value="Bluray">Bluray</option>';
        }
        echo $output;
    }
}
