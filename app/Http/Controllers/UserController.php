<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function __construct()
    {

        // $this->middleware(['role:admin']);
        $this->middleware('permission:viewer list',['only'=>'index']);
        $this->middleware('permission:create user',['only'=>['create','store']]);
        $this->middleware('permission:edit user',['only'=>['update','edit','assign','updatePermission']]);
        $this->middleware('permission:delete user',['only'=>['destroy']]);
        $this->middleware('permission:view customer',['only'=>['listcustomer']]);
        $this->middleware('permission:delete customer',['only'=>['destroy_customer']]);
        $this->middleware('permission:view order',['only'=>['listOrder']]);
    }
    public function index()
    {

        // $role = Role::find(4);
        // $permission = Permission::find(2);
        // $role->givePermissionTo($permission);
        //$role->revokePermissionTo($permission);

        // auth()->user()->assignRole('admin');
        
        $list = User::with('roles')->get();
        return view('admincp.user.index', compact('list'));
    }
    public function assign($id)
    {
        $user = User::find($id);
        $permission = Permission::all();
        $all_column_per = $user->permissions;

        return view('admincp.user.assignPermission', compact('permission', 'user', 'all_column_per'));
    }

    public function updatePermission(Request $request, $id)
    {

        $data = $request->all();
        $user = User::find($id);
        if (!isset($data['permission'])) {
            toastr()->warning('Warning permission not empty!');
            return redirect()->back();
        } else {
            $user->syncPermissions($data['permission']);
            toastr()->success('Update permission successfully');
            return redirect()->back();
        }
    }

    public function create(Request $request)
    {
        $role = Role::all();
        return view('admincp.user.form', compact('role'));
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        $assign = User::find($user->id);
        $assign->assignRole($data['role']);
        toastr()->success('Created account');
        return redirect(route('user.index'));
    }
    public function edit($id)
    {
        $user = User::find($id);
        $role = Role::all();
        $all_column_role = $user->roles->first();
        return view('admincp.user.form', compact('role', 'user', 'all_column_role'));
    }
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $user = User::find($id);
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->syncRoles($data['role']);
        //$user->status=$data['status'];
        $user->save();
        toastr()->success('Update successfully');
        return redirect(route('user.index'));
    }


    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        $user_data = User::all()->toArray();
        toastr()->success('Delete successfully');
        return redirect()->back();
    }

    public function listcustomer()
    {
        $list=Customer::get();
        return view('admincp.customer.index',compact('list'));
    }
    public function listOrder()
    {
        $list_order=Order::with('package:id,title', 'user:id,name,email')->get();
        return view('admincp.customer.listorder',compact('list_order'));
    }
    public function destroy_customer($id)
    {
        $customer = Customer::find($id);
        // $customer->delete();
        $customer->status=0;
        $customer->save();
        toastr()->success('Delete successfully');
        return redirect()->back();
    }
    public function customer_status(Request $request)
    {
        $data = $request->all();
        $customer = Customer::find($data['customer_id']);
        $customer->status = $data['customerstatus_val'];
        $customer->save();
    }
}
