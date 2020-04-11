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

    public function countByrole(string $rolename)
    {
         return User::whereHas(
            'roles', function($q) use ($rolename){
                $q->where('name', $rolename);
            }
            )->count();

    }
    public function userRoleUpdate(user $user, request $request)
    {
       
        if($this->countByRole('admin') === 1 && $this->checkIfAdmin($user->id)) {
            return redirect(route('admin.user.role'))->with('alert','Last admin cannot be deleted');    
        }

        $user->roles()->sync($request->role);
        $status='Role updated';
        
        return redirect(route('admin.user.role'))->with('status',$status);
    }

    public function checkIfAdmin(string $user_id) :bool
    {

        $user = User::where('id', $user_id)->with('roles')->first();

        if($user->roles->first()->name === 'admin') {
            return true;
        }

        return false;
    }

    public function deleteUser(request $request)
    {   
        $user = User::where('id', $request->user_id)->with('roles')->first();

        if($this->countByRole('admin') === 1 && $this->checkIfAdmin($request->user_id)) {
            return redirect(route('admin.user'))->with('alert','Last admin cannot be deleted');    
        }

        foreach ($user->Posts as $post)
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
