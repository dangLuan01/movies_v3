<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:assign permission');
    }
    public function assignPermissions()
    {

        $listRole = Role::all();

        return view('admincp.role.assignpermission', compact('listRole'));
    }
    public function select_role()
    {
        $id = $_GET['id'];
        $role = Role::find($id);
        $listPermission = Permission::all();
        $hasPermission = $role->permissions->pluck('name');
        $output = '';
        foreach ($listPermission as $permission) {
            $selected = $hasPermission->contains($permission->name) ? 'selected' : '';
            $output .= "<option value='{$permission->id}' {$selected}>{$permission->name}</option>";
        }
        // for ($i = 0; $i < count($hasPermission); $i++) {
        //     $output .= '<option selected>' . $hasPermission[$i] . '</option>';
        // }
        echo $output;
    }
    public function assignPermissionsToRole(Request $request)
    {

        $data = $request->all();
        $role = Role::find($data['role']);
        if (!isset($data['permissions'])) {
            toastr()->warning('Quyen khong duoc rong!');
            return redirect(route('role.index'));
        } else {
            $role->syncPermissions($data['permissions']);
            toastr()->success('Them quyen thanh cong');
            return redirect(route('role.index'));
        }
    }
}
