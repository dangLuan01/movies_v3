<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    /*

     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:viewer list',['only'=>'index']);
        $this->middleware('permission:create server',['only'=>['create','store']]);
        $this->middleware('permission:edit server',['only'=>['update','edit']]);
        $this->middleware('permission:delete server',['only'=>['destroy']]);
    }
    public function index()
    {
        $list = Server::get();
        return view('admincp.server_movie.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $list=server::orderBy('position','ASC')->get();
        // return view('admincp.server.form',compact('list'));
        return view('admincp.server_movie.form');
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

            //$data=$request->all();
            $data = $request->validate(
                [
                    'title' => 'required|unique:server_movies|max:255',
                    'description' => 'required|max:255',
                    'status' => 'required',
                ],
                [
                    'title.required' => 'The title doesnt empty',
                    'title.unique' => 'The title is not duplicate',

                ]
            );


            $server = new Server();
            $server->title = $data['title'];
            $server->description = $data['description'];
            $server->status = $data['status'];
            $server->save();
            toastr()->success('Server "' . $server->title . '" created successfully', 'Create');
            //return redirect()->back()->with('message_add', 'Add server successfully !');
            return redirect()->route('server-movie.index');
        } catch (ModelNotFoundException $exception) {
            toastr()->error('Server add error!', 'Error');
            return redirect()->back();
            //return redirect()->back()->with('error', 'Add server successfully !');
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
        $server = Server::find($id);
        return view('admincp.server_movie.form', compact('server'));
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
            //$data=$request->all();

            $data = $request->validate(
                [
                    'title' => 'required|unique:server_movies|max:255',
                    'description' => 'required|max:255',
                    'status' => 'required',
                ],
                [
                    'title.required' => 'The title doesnt empty',
                    'title.unique' => 'The title is not duplicate',

                ]
            );

            $server = Server::find($id);
            $server->title = $data['title'];
            $server->description = $data['description'];
            $server->status = $data['status'];
            $server->save();

            toastr()->success("Server '" . $server->title . "' updated successfully!", 'Update', ['timeOut' => 5000]);
            return redirect()->route('server-movie.index');
            //return redirect()->back()->with('message_update', 'Up to date server successfully !');
        } catch (ModelNotFoundException $exception) {
            toastr()->error("Update error!", 'Error');
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
            $data = Server::join('episodes','server_movies.id','=','episodes.server_id')->find($id);
            
            if ($data == null) {

                //Server::find($id)->delete();
                $server_data = Server::all()->toArray();
                toastr()->success('Server deleted successfully!', 'Delete');
                return redirect()->back()->with('server_data', $server_data);

            } else {
                // foreach($data as $da){
                   
                // }
                toastr()->error('Server already used in the episodes', 'Error');
                return redirect()->back();
            }

            // $data = Server::find($id);
            // Server::find($id)->delete();

            // $server_data = server::all()->toArray();
            // toastr()->success('Server "' . $data->title . '" deleted successfully!', 'Delete');
            // return redirect()->route('server-movie.index');
            // return redirect()->back()->with('server_data',$server_data)->with('success_del','Delete server successfully!','error','Error');
        } catch (ModelNotFoundException $th) {
            toastr()->error('Server delete error', 'Error');
        }
    }
}
