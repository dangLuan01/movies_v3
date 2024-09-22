<?php

namespace App\Http\Controllers;

use App\Models\Info;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class InfoWebController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:update info');

    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $info=Info::find(1);
        return view('admincp.info.form',compact('info'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            //$data=$request->all();

            $data = $request->validate(
                [
                    'title' => 'required|max:255',
                    'image' => 'mimes:jpg,png,jpeg,gif,svg,ico|max:2048',
                    'description' => 'required',
                ],
                [
                    'title.required' => 'The title doesnt empty',
                    'title.unique' => 'The title is not duplicate',

                ]
            );

            $info = Info::find(1);
            $info->title = $data['title'];
            $info->description = $data['description'];

            
            $get_image = $request->file('image');
            $path = 'uploads/logo/';
            if ($get_image) {
                if (file_exists($path . $info->logo)) {
                    unlink('uploads/logo/' . $info->logo);
                }
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $new_image = $name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension();
                $get_image->move($path, $new_image);
                $info->logo = $new_image;
            }
            $info->save();

            toastr()->success("info '" . $info->title . "' updated successfully!", 'Update', ['timeOut' => 5000]);
            return redirect()->route('info-web.create');
            //return redirect()->back()->with('message_update', 'Up to date info successfully !');
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
        //
    }
}
