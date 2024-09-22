<?php

namespace App\Http\Controllers;

use App\Models\Movie_Package;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:viewer list', ['only' => 'index']);
        $this->middleware('permission:create package', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit package', ['only' => ['update', 'edit', 'movie_hot']]);
        $this->middleware('permission:delete package', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Movie_Package::get();
        return view('admincp.package.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admincp.package.form');
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
                    'title' => 'required|unique:movie_package|max:255',
                    'description' => 'required|unique:movie_package',
                    'time' => 'required',
                    'price' => 'required',
                    'status' => 'required',
                ],
                [
                    'title.required' => 'The title doesnt empty',
                    'title.unique' => 'The title is not duplicate',

                ]
            );

            $package = new Movie_Package();
            $package->title = $data['title'];
            $package->description = $data['description'];
            $package->time = $data['time'];
            $package->price = $data['price'];
            $package->status = $data['status'];
            $package->save();
            toastr()->success('package "' . $package->title . '" created successfully', 'Create');
            //return redirect()->back()->with('message_add', 'Add package successfully !');
            return redirect()->route('package.index');
        } catch (ModelNotFoundException $exception) {
            toastr()->error('package add error!', 'Error');
            return redirect()->back();
            //return redirect()->back()->with('error', 'Add package successfully !');
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
        $package = Movie_Package::find($id);
        return view('admincp.package.form', compact('package'));
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
                    'title' => 'required|max:255',
                    'description' => 'required',
                    'time' => 'required',
                    'price' => 'required',
                    'status' => 'required',
                   
                ],
                [
                    'title.required' => 'The title doesnt empty',
                    'title.unique' => 'The title is not duplicate',

                ]
            );
            $package = Movie_Package::find($id);
            $package->title = $data['title'];
            $package->description = $data['description'];
            $package->time = $data['time'];
            $package->price = $data['price'];
            $package->status = $data['status'];
            $package->save();

            toastr()->success("package '" . $package->title . "' updated successfully!", 'Update', ['timeOut' => 5000]);
            return redirect()->route('package.index');
            //return redirect()->back()->with('message_update', 'Up to date package successfully !');
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
        Movie_Package::find($id)->delete();
        return redirect()->route('package.index');
    }
}
