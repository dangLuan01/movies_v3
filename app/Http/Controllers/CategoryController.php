<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:viewer list',['only'=>'index']);
        $this->middleware('permission:create category',['only'=>['create','store']]);
        $this->middleware('permission:edit category',['only'=>['update','edit']]);
        $this->middleware('permission:delete category',['only'=>['destroy']]);
    }
    public function index()
    {
        $list = Category::orderBy('position', 'ASC')->get();
        return view('admincp.category.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $list=Category::orderBy('position','ASC')->get();
        // return view('admincp.category.form',compact('list'));
        return view('admincp.category.form');
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
                    'title' => 'required|unique:categories|max:100',
                    'slug' => 'required|unique:categories',
                    'description' => 'required|max:255',
                    'status' => 'required',
                    'position' => 'required|unique:categories',
                ],
                [
                    'title.required' => 'The title doesnt empty',
                    'slug.required' => 'The title doesnt empty',
                    'title.unique' => 'The title is not duplicate',

                ]
            );


            $category = new Category();
            $category->title = $data['title'];
            $category->slug = $data['slug'];
            $category->description = $data['description'];
            $category->status = $data['status'];
            $category->position = $data['position'];
            $category->save();
            toastr()->success('Category "' . $category->title . '" created successfully', 'Create');
            //return redirect()->back()->with('message_add', 'Add category successfully !');
            return redirect()->route('category.index');
        } catch (ModelNotFoundException $exception) {
            toastr()->error('Category add error!', 'Error');
            return redirect()->back();
            //return redirect()->back()->with('error', 'Add category successfully !');
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
        $category = Category::find($id);
        $list = Category::orderBy('position', 'ASC')->get();
        return view('admincp.category.form', compact('list', 'category'));
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
                    'title' => 'required|max:100',
                    'slug' => 'required',
                    'description' => 'required|max:255',
                    'status' => 'required',
                    'position' => 'required',
                    'nav'=>'',
                ],
                [
                    'title.required' => 'The title doesnt empty',
                    'slug.required' => 'The slug doesnt empty',
                    'title.unique' => 'The title is not duplicate',

                ]
            );

            $category = Category::find($id);
            $category->title = $data['title'];
            $category->slug = $data['slug'];
            $category->description = $data['description'];
            $category->status = $data['status'];
            $category->position = $data['position'];
            $category->nav = $data['nav'];
            $category->save();

            toastr()->success("Category '" . $category->title . "' updated successfully!", 'Update', ['timeOut' => 5000]);
            return redirect()->route('category.index');
            //return redirect()->back()->with('message_update', 'Up to date category successfully !');
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
            $data = Category::with('movie')->find($id);
            
    

            if (count($data->movie) == 0) {

                Category::find($id)->delete();

                $category_data = Category::all()->toArray();
                toastr()->success('Category "' . $data->title . '" deleted successfully!', 'Delete');
                return redirect()->back()->with('category_data', $category_data);

            } else {
                foreach($data->movie as $da){
                   
                }
                toastr()->error('Category "' . $data->title . '" already used in the movies "' . $da->title . '"', 'Error');
                return redirect()->back();
            }

            // $data = Category::find($id);
            // Category::find($id)->delete();

            // $category_data = Category::all()->toArray();
            // toastr()->success('Category "' . $data->title . '" deleted successfully!', 'Delete');
            // return redirect()->back()->with('category_data', $category_data);
            //return redirect()->back()->with('category_data',$category_data)->with('success_del','Delete category successfully!','error','Error');
        } catch (\Throwable $th) {
            toastr()->error('Category delete error', 'Error');
        }
    }
    public function resorting(Request $request)
    {
        $data = $request->all();
        foreach ($data['array_id'] as $key => $value) {
            $category = Category::find($value);
            $category->position = $key;
            $category->save();
        }
    }
}
