<?php

namespace App\Http\Controllers\core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use DataTables;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::where('id', '!=', 1)->get(); // As not to delete the Super Admin
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('name', function($row){
                        return $row->name;
                    })
                    ->addColumn('action', function($row){
                        $btn = '<div class="text-end">';
                        if(auth()->user()->can('assign_permissions')) {
                            $btn .= '<a title="'.transWord('assign role').'" href="'.route('users-roles-edit-assign-permissions', Crypt::encrypt($row->id)).'" class="btn btn-primary me-2">
                                        <i class="fa-solid fa-user-shield fa-fade fa-lg"></i>
                                    </a>';
                        }
                        if(auth()->user()->can('update_roles')) {
                            $btn .= '<a title="'.transWord('edit').'" href="'.route('users-roles-edit', $row->id).'" class="btn btn-info me-2">
                                        <i class="fas fa-edit"></i>
                                    </a>';
                        }
                        if(auth()->user()->can('delete_roles')) {
                            $btn .= '<a title="'.transWord('delete').'" id="delete" href="'.route('users-roles-delete', $row->id).'" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>';
                        }
                        $btn .= '</div>';
                        return $btn;
                    })->rawColumns(['action'])
                    ->make(true);
        }
        return view('pages.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ],[
            'name.required' => transWord('This field is required'),
            'name.unique' => transWord('This role already exists'),
        ]);

        $role = Role::create([
            'name' => $request->name,
        ]);

        $notification = array(
			'message' => transWord('Role created successfully !!'),
			'alert-type' => 'success'
		);

        return redirect()->route('users-roles-all')->with($notification);
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
        $role = Role::findOrFail($id);
        return view('pages.roles.edit', compact('role'));
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
        $request->validate([
            'name' => 'required|unique:roles,name,'.$id,
        ],[
            'name.required' => transWord('This field is required'),
            'name.unique' => transWord('This role already exists'),
        ]);

        $role = Role::findOrFail($id)->update([
            'name' => $request->name,
        ]);

        $notification = array(
			'message' => transWord('Role updated successfully !!'),
			'alert-type' => 'success'
		);

        return redirect()->route('users-roles-all')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        $notification = array(
			'message' => transWord('Role deleted successfully !!'),
			'alert-type' => 'success'
		);

        return redirect()->route('users-roles-all')->with($notification);
    }

    public function assignPermissions($id) {
        $role = Role::findOrFail(Crypt::decrypt($id));
        $permissions = Permission::all();

        $permssionsOfRole = Role::findByName($role->name)->permissions;
        $assignedPermissions = [];
        foreach ($permssionsOfRole as $permssion) {
            array_push($assignedPermissions,$permssion->id);
        }

        $permissionsName = [];
        foreach ($permissions as $p) {
            if (!in_array(explode('_',$p->name)[1],$permissionsName)) {
                array_push($permissionsName,explode('_',$p->name)[1]);
            }
        }

        return view('pages.roles.assign_permissions', compact('role', 'permissions', 'permissionsName', 'assignedPermissions'));
    }

    public function assignPermissionsUpdate(Request $request) {
        $role = Role::findOrfail($request->roleId);

        if(isset($request->permissions)){
            $role->syncPermissions();
            foreach ($request->permissions as $permission) {
                $role->givePermissionTo(Permission::findOrfail($permission)->name);
            }
        }
        if($request->permissions == null){
            $role = Role::findOrfail($request->role_id);
            $role->syncPermissions();
        }

        $notification = array(
			'message' => transWord('Permissions assigned successfully !!'),
			'alert-type' => 'success'
		);

        return redirect()->route('users-roles-all')->with($notification);
    }
}
