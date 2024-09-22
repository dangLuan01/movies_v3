<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:viewer list',['only'=>'index']);
        $this->middleware('permission:create genre',['only'=>['create','store']]);
        $this->middleware('permission:edit genre',['only'=>['update','edit']]);
        $this->middleware('permission:delete genre',['only'=>['destroy']]);
    }
    public function index()
    {
        $list = Genre::all();
        return view('admincp.genre.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $list=Genre::all();
        return view('admincp.genre.form');
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
                    'title' => 'required|unique:genres|max:100',
                    'slug' => 'required|unique:genres|max:255',
                    'description' => 'required|max:255',
                    'status' => 'required',

                ],
                [
                    'title.required' => 'The title doesnt empty',
                    'slug.required' => 'The slug doesnt empty',
                    'title.unique' => 'The title is not duplicate',

                ]
            );
            $genre = new Genre();
            $genre->title = $data['title'];
            $genre->slug = $data['slug'];
            $genre->description = $data['description'];
            $genre->status = $data['status'];
            $genre->save();

            toastr()->success("Genre '" . $genre->title . "' created successfully!", 'Create');
            return redirect()->route('genre.index');
            //return redirect()->back()->with('message_add', 'Add genre successfully !');                
        } catch (ModelNotFoundException $th) {
            toastr()->error('Genre' . $genre->title . 'create error!', 'Error');
            return redirect()->back();
        }
    }

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
        $genre = Genre::find($id);
        $list = Genre::all();
        return view('admincp.genre.form', compact('list', 'genre'));
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
                    'title' => 'required|max:100',
                    'slug' => 'required|max:255',
                    'description' => 'required|max:255',
                    'status' => 'required',
                ],
                [
                    'title.required' => 'The title doesnt empty',
                    'slug.required' => 'The slug doesnt empty',

                ]
            );
            $genre = Genre::find($id);
            $genre->title = $data['title'];
            $genre->slug = $data['slug'];
            $genre->description = $data['description'];
            $genre->status = $data['status'];
            $genre->save();

            toastr()->success('Genre "' . $genre->title . '" updated successfully!', 'Update');
            
            return redirect()->route('genre.index');

        } catch (ModelNotFoundException $th) {
            toastr()->error('Genre "' . $genre->title . '" update error!', 'Error');
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
        try {
            $data = Genre::find($id);
            Genre::find($id)->delete();
            $genre_data = Genre::all()->toArray();

            toastr()->success('Genre "' . $data->title . '" deleted successfully!', 'Delete');
            return redirect()->back()->with('category_data', $genre_data);
            // return redirect()->back()->with('category_data',$genre_data)->with('success_del','Delete genre successfully!');
        } catch (\Throwable $th) {
            toastr()->error('Genre "' . $data->title . '" delete error!', 'Delete');
        }
    }
}
