<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;
use Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return view ('user.user',[
            'users'=>User::where('id', Auth::Id())->get()
        ]);
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
        return redirect(route('user.details'))->with('status','User details updated!');
    }
}
