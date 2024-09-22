<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Stroage;

class ResumeController extends Controller
{
    public function __construct()
    {
        //$this->middleware(['role:admin']);
    }
    public function create()
    {
        return view('admincp.resume.form');
    }
    public function store(Request $request)
    {
        $data = new Resume();
        $file = $request->file;
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $request->file->move('assets', $filename);
        $data->name = $request->name;
        $data->file = $filename;
        $data->save();
        //dd($data);
        return redirect()->back();
    }
    public function show(Request $request)
    {
        $data = Resume::all();
        return view('admincp.resume.showresume',compact('data'));

    }
    public function download(Request $request, $file)
    {
        
        return response()->download(public_path('assets/'.$file));

    }
    public function view($id)
    {
        $data=Resume::find($id);
        
        return view('admincp.resume.view',compact('data'));

    }
    public function delete($id)
    {
        $data = Resume::find($id);
        if (!empty($data->file)) {
            unlink('assets/' . $data->file);
            $data->delete();
        }
        return redirect()->back();
    }
    
}
