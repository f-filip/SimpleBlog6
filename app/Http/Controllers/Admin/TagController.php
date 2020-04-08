<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Tag;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function index()
    {
        return view('admin.tags',[
            'tags' => Tag::All()
        ]);
    }

    public function store(request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|unique:tags,name',
        ]);

        if($validator->fails())
        {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput($request->all());
        }
        $tag = new tag(request(['name']));
        $tag->save();
        return redirect(route('admin.tags'))->with('status', 'Tag added!');
    }

    public function update(tag $tag, request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' =>'required|unique:tags,name'
        ]);

        if($validator->fails())
        {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput($request->all());
        }
   
        $tag->update(request(['name']));

        return redirect(route('admin.tags'))->with('status','Tag updated!');
    }

    public function delete($tag)
    {
        Tag::destroy($tag);
        return redirect(route('admin.tags'))->with('status','Tag deleted!');
    }

}
