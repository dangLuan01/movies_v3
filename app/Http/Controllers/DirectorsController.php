<?php

namespace App\Http\Controllers;

use App\Models\Directors;
use App\Models\Movie_Directors;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DirectorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:viewer list',['only'=>'index']);
        $this->middleware('permission:create directors',['only'=>['create','store']]);
        $this->middleware('permission:edit directors',['only'=>['update','edit']]);
        $this->middleware('permission:delete directors',['only'=>['destroy']]);
    }
    public function index()
    {
       
        $list = Directors::orderBy('id','DESC')->get();
        
        return view('admincp.directors.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admincp.directors.form');
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
                    'name' => 'required|unique:directors|max:255',
                    'slug' => 'required|unique:directors|max:255',
                    'description' => 'required|max:500',
                    'status' => 'required',

                ],
                [
                    'name.required' => 'The title doesnt empty',
                    'slug.required' => 'The slug doesnt empty',
                    'name.unique' => 'The title is not duplicate',

                ]
            );
            $directors = new Directors();
            $directors->name = $data['name'];
            $directors->slug = $data['slug'];
            $directors->description = $data['description'];
            $directors->status = $data['status'];
            $directors->save();

            toastr()->success("Directors '" . $directors->name . "' created successfully!", 'Create');
            return redirect()->route('directors.index');
            //return redirect()->back()->with('message_add', 'Add directors successfully !');                
        } catch (ModelNotFoundException $th) {
            toastr()->error('Directors' . $directors->name . 'create error!', 'Error');
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
        
        $directors = Directors::find($id);
        $list = Directors::all();
        return view('admincp.directors.form', compact('list', 'directors'));
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
                    'name' => 'required|max:255',
                    'slug' => 'required|max:255',
                    'description' => 'required|max:255',
                    'status' => 'required',
                ],
                [
                    'name.required' => 'The title doesnt empty',
                    'slug.required' => 'The slug doesnt empty',

                ]
            );
            $directors = Directors::find($id);
            $directors->name = $data['name'];
            $directors->slug = $data['slug'];
            $directors->description = $data['description'];
            $directors->status = $data['status'];
            $directors->save();

            toastr()->success('Directors "' . $directors->name . '" updated successfully!', 'Update');
            
            return redirect()->route('directors.index');

        } catch (ModelNotFoundException $th) {
            toastr()->error('Directors "' . $directors->name . '" update error!', 'Error');
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
        $datas = Directors::find($id);
        $data = Movie_Directors::with('movie')->where('directors_id',$id)->first();
        //dd($data);
        if (!isset($data->movie)) {

            Directors::find($id)->delete();

            $cast_data = Directors::all()->toArray();
            toastr()->success('Directors "' . $datas->name . '" deleted successfully!', 'Delete');
            return redirect()->back();

        } else {
           
            toastr()->error('Directors "' . $datas->name . '" already used in the movies "' . $data->movie->title . '"', 'Error');
            return redirect()->back();
        }

    }
}
