<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\User;
use App\Models\Admin\Role;
use App\Models\Admin\Post;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function index()
    {
        return view('admin.user',[
            'users'=>User::All(),
            'roles'=> Role::All()
        ]);
    }

    public function userRole()
    {
        return view ('admin.user_role',[
            'users'=>User::All(),
            'roles'=>Role::ALl()
        ]);
    }
    public function userRoleUpdate(user $user, request $request)
    {
        $user->roles()->sync($request->role);
        return redirect(route('admin.user.role'))->with('status','Role updated!');
    }

    public function deleteUser(user $user)
    {   
        
        if(Role::with('users')->where('name', 'admin')->count() === 1 && $user->roles()->first()->name === 'admin'){
            return redirect(route('admin.user'))->with('alert','Last admin cannot be deleted');    
        }

        foreach ($user->posts as $post)
        {
            $post->update(['user_id'=>"0"]);
        }
        $user->delete();
        return redirect(route('admin.user'))->with('status','User deleted');    
    }

    public function userUpdate(request $request)
    {
    
        $validator = Validator::make($request->all(),[
            'name' =>'required|unique:category,name',
            'email'  =>  'required|email|unique:users,email,'.$request->user_id

        ]);

        if($validator->fails())
        {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput($request->all());
        }
        
        $user = User::findOrFail($request->user_id);
        $user->update(request(['name','email']));
        return redirect(route('admin.user'))->with('status','User details updated!');
    }
}
