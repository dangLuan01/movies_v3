<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:update role');
    }
    public function index()
    {
        $rolesWithPermissions = Role::with('permissions')->get();
        // for ($i = 0; $i < count($hasPermission); $i++) {
        //      $hasPermission[$i];
        // }

        return view('admincp.role.index', compact('rolesWithPermissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listPermission = Permission::all();
        return view('admincp.role.form',compact('listPermission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // $data = $request->all();
        $data = $request->validate(
            [
                'name' => 'required|unique:roles|max:255',
                'permissions'=>'required'
            ],
            [
                'name.unique' => 'Vai trò đã tồn tại.',
                'permissions.required'=>'Quyền không được rỗng có ít nhất 1 quyền.'
            ]
        );
        $role = Role::create(['name' => $data['name']]);
        
        $role->syncPermissions($data['permissions']);
        toastr()->success('Them vai tro thanh cong');
        return redirect()->back();
    }

    public function storePermissions(Request $request)
    {
        $data = $request->all();
        Permission::create(['name' => $data['name']]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $listPermission = Permission::all();
        $role = Role::find($id);
        return view('admincp.role.form', compact('role','listPermission'));
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
        // $data = $request->all();
        $data = $request->validate(
            [
                'name' => 'required|unique:roles|max:255',  
            ],
            [
                'name.unique' => 'Vai trò đã tồn tại.',
            ]
        );
        $user = Role::find($id);
        $user->name = $data['name'];
        $user->save();
        toastr()->success('Updated role form "'.$user->name.'" become "'.$data['name']. '" success.');
        return redirect(route('role.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        // $user_data = User::all()->toArray();
        // $user->hasRole('writer');
        Role::find($id)->delete();
        toastr()->success('Deleted role success.');
        return redirect(route('role.index'));
    }
}
