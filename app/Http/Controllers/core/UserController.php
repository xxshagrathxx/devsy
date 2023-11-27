<?php

namespace App\Http\Controllers\core;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('id', '!=', 1)->latest()->get(); //As not to get admin in the list
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('image', function($row){
                        return '<img src="'.asset('uploads/users/'.$row->avatar).'" style="border-radius: 50%; width: 40px" />';
                    })
                    ->addColumn('name', function($row){
                        return $row->name;
                    })
                    ->addColumn('email', function($row){
                        return $row->email;
                    })
                    ->addColumn('role_id', function($row){
                        return $row->role->name;
                    })
                    ->addColumn('action', function($row){
                        $btn = '<div class="text-end">';
                        if(auth()->user()->can('show_users')) {
                            $btn .= '<a title="'.transWord('show').'" href="'.route('users-users-show', $row->id).'" class="btn btn-warning me-2">
                                        <i class="fas fa-eye"></i>
                                    </a>';
                        }
                        if(auth()->user()->can('update_users')) {
                            $btn .= '<a title="'.transWord('edit').'" href="'.route('users-users-edit', $row->id).'" class="btn btn-info me-2">
                                        <i class="fas fa-edit"></i>
                                    </a>';
                        }
                        if(auth()->user()->can('delete_users')) {
                            $btn .= '<a title="'.transWord('delete').'" id="delete" href="'.route('users-users-delete', $row->id).'" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>';
                        }
                        $btn .= '</div>';
                        return $btn;
                    })->rawColumns(['image', 'action'])
                    ->make(true);
        }
        return view('pages.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('pages.users.create', compact('roles'));
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'role_id' => 'required',
            'image' => 'mimes:jpeg,png,jpg,webp,gif,svg|max:2048',
        ],[
            'name.required' => transWord('This field is required'),
            'email.required' => transWord('This field is required'),
            'email.unique' => transWord('This email already exists'),
            'email.email' => transWord('This field must be in an email format'),
            'password.required' => transWord('This field is required'),
            'password.confirmed' => transWord('Passwords don\'t match'),
            'password.min' => transWord('Password must be 8 characters or more'),
            'role_id.required' => transWord('This field is required'),
            'image.mimes' => 'The image must be of type (jpeg,png,jpg,webp,gif,svg)',
            'image.max' => 'The image size cannot be larger than 2MB',
        ]);

        $save_url = 'default.png';

        if ($request->file('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('uploads/users/'.$name_gen);
            $save_url = $name_gen;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'avatar' => $save_url,
        ]);

        $role = Role::findOrFail($request->role_id);
        $user->assignRole($role->name);

        $notification = array(
			'message' => transWord('User created successfully !!'),
			'alert-type' => 'success'
		);

        return redirect()->route('users-users-all')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('pages.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('pages.users.edit', compact('user', 'roles'));
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|confirmed|min:8',
            'role_id' => 'required',
            'image' => 'mimes:jpeg,png,jpg,webp,gif,svg|max:2048',
        ],[
            'name.required' => transWord('This field is required'),
            'email.required' => transWord('This field is required'),
            'email.unique' => transWord('This email already exists'),
            'email.email' => transWord('This field must be in an email format'),
            'password.confirmed' => transWord('Passwords don\'t match'),
            'password.min' => transWord('Password must be 8 characters or more'),
            'role_id.required' => transWord('This field is required'),
            'image.mimes' => 'The image must be of type (jpeg,png,jpg,webp,gif,svg)',
            'image.max' => 'The image size cannot be larger than 2MB',
        ]);

        $old_img = $request->old_img;
        $save_url = $old_img;

        if ($request->file('image')) {
            if (!str_contains($old_img, 'default.png')) {
                unlink('uploads/users/'.$old_img);
            }
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('uploads/users/'.$name_gen);
            $save_url = $name_gen;
        }

        $user = User::findOrFail($id);

        if($request->password) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
                'avatar' => $save_url,
            ]);
        } else {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role_id' => $request->role_id,
                'avatar' => $save_url,
            ]);
        }

        $role = Role::findOrFail($request->role_id);
        $user->syncRoles($role->name);


        $notification = array(
			'message' => transWord('User updated successfully !!'),
			'alert-type' => 'success'
		);

        return redirect()->route('users-users-all')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->avatar != 'default.png') {
            unlink('uploads/users/'.$user->avatar);
        }

        $user->delete();
        
        $notification = array(
			'message' => transWord('User deleted successfully !!'),
			'alert-type' => 'success'
		);

        return redirect()->route('users-users-all')->with($notification);
    }
}
