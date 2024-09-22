<?php

namespace App\Http\Controllers;

use App\Models\Cast;
use App\Models\Movie_Cast;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:viewer list',['only'=>'index']);
        $this->middleware('permission:create cast',['only'=>['create','store']]);
        $this->middleware('permission:edit cast',['only'=>['update','edit']]);
        $this->middleware('permission:delete cast',['only'=>['destroy']]);
    }
    public function index()
    {
        $list = Cast::orderBy('id','DESC')->get();
        return view('admincp.cast.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admincp.cast.form');

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
            //$data = $request->all();
            $data = $request->validate(
                [
                    'title' => 'required|unique:cast|max:255',
                    'slug' => 'required|unique:cast|max:255',
                    'description' => 'required|max:255',
                    'status' => 'required',

                ],
                [
                    'title.required' => 'The title doesnt empty',
                    'slug.required' => 'The slug doesnt empty',
                    'title.unique' => 'The title is not duplicate',

                ]
            );
            $cast = new Cast();
            $cast->title = $data['title'];
            $cast->slug = $data['slug'];
            $cast->description = $data['description'];
            $cast->status = $data['status'];
            $cast->save();

            toastr()->success("Actor '" . $cast->title . "' created successfully!", 'Create');
            return redirect()->route('cast.index');
            //return redirect()->back()->with('message_add', 'Add cast successfully !');                
        } catch (ModelNotFoundException $th) {
            toastr()->error('Actor' . $cast->title . 'create error!', 'Error');
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
        $cast = Cast::find($id);
        $list = Cast::all();
        return view('admincp.cast.form', compact('list', 'cast'));
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
            //$data = $request->all();
            $data = $request->validate(
                [
                    'title' => 'required|max:255',
                    'slug' => 'required|max:255',
                    'description' => 'required|max:255',
                    'status' => 'required',
                ],
                [
                    'title.required' => 'The title doesnt empty',
                    'slug.required' => 'The slug doesnt empty',

                ]
            );
            $cast = Cast::find($id);
            $cast->title = $data['title'];
            $cast->slug = $data['slug'];
            $cast->description = $data['description'];
            $cast->status = $data['status'];
            $cast->save();

            toastr()->success('Actor "' . $cast->title . '" updated successfully!', 'Update');
            
            return redirect()->route('cast.index');

        } catch (ModelNotFoundException $th) {
            toastr()->error('Actor "' . $cast->title . '" update error!', 'Error');
            return redirect()->back();
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
        // try {
            $datas = Cast::find($id);
            $data = Movie_Cast::with('movie')->where('cast_id',$id)->first();
            //dd($data);
            if (!isset($data->movie)) {

                Cast::find($id)->delete();

                $cast_data = Cast::all()->toArray();
                toastr()->success('Cast "' . $datas->title . '" deleted successfully!', 'Delete');
                return redirect()->back();

            } else {
               
                toastr()->error('Cast "' . $datas->title . '" already used in the movies "' . $data->movie->title . '"', 'Error');
                return redirect()->back();
            }

        // } catch (\Throwable $th) {
        //     toastr()->error('Cast delete error', 'Error');
        // }
    }
}
