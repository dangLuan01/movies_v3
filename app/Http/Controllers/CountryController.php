<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:viewer list',['only'=>'index']);
        $this->middleware('permission:create country',['only'=>['create','store']]);
        $this->middleware('permission:edit country',['only'=>['update','edit']]);
        $this->middleware('permission:delete country',['only'=>['destroy']]);
    }
    public function index()
    {
        $list = Country::all();
        return view('admincp.country.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $list=Country::all();
        return view('admincp.country.form');
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
            // $data = $request->all();

            $data = $request->validate(
                [
                    'title' => 'required|unique:countries|max:100',
                    'slug' => 'required|unique:countries|max:255',
                    'description' => 'required|max:255',
                    'status' => 'required',

                ],
                [
                    'title.required' => 'The title doesnt empty',
                    'slug.required' => 'The slug doesnt empty',
                    'title.unique' => 'The title is not duplicate',

                ]
            );

            $country = new Country();
            $country->title = $data['title'];
            $country->slug = $data['slug'];
            $country->description = $data['description'];
            $country->status = $data['status'];
            $country->save();

            toastr()->success('Country "' . $country->title . '" created successfully!', 'Create');
            return redirect()->route('country.index');
            // return redirect()->back()->with('message_add', 'Add country successfully !');
        } catch (ModelNotFoundException $th) {
            toastr()->error('Country create error!', 'Error');
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
        $country = Country::find($id);
        $list = Country::all();
        return view('admincp.country.form', compact('list', 'country'));
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
            // $data = $request->all();
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
                    'title.unique' => 'The title is not duplicate',

                ]
            );

            $country = Country::find($id);
            $country->title = $data['title'];
            $country->slug = $data['slug'];
            $country->description = $data['description'];
            $country->status = $data['status'];
            $country->save();

            toastr()->success('Info Country "' . $country->title . '" updated successfully!', 'Update');
            return redirect()->route('country.index');
            //return redirect()->back()->with('message_update', 'Up to date country successfully !');
        } catch (ModelNotFoundException $th) {
            toastr()->error('Country update error!', 'Error');
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
            $data = Country::with('movie')->find($id);
           
            if (count($data->movie) == 0) {
                Country::find($id)->delete();
                $country_data = Country::all()->toArray();
                toastr()->success('Country "' . $data->title . '" deleted successfully!', 'Delete');
                return redirect()->back()->with('country_data', $country_data);
            } else {
                foreach ($data->movie as $value) {
                }
                toastr()->error('Country "' . $data->title . '" already used in the movies "' . $value->title . '"', 'Error');
                return redirect()->back();
            }


            //return redirect()->back()->with('country_data',$country_data)->with('success_del','Delete country successfully!');
        } catch (ModelNotFoundException $th) {
            toastr()->error('Country deleted error!', 'Error');
            return redirect()->back();
        }
    }
}
