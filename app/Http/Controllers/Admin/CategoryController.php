<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
 
    public function index()
    {
        return view ('admin.category',[
            'categories'=>Category::Where('name','!=','uncategorized')->get()
        ]);
    }

    public function store(request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|unique:category,name',
        ]);

        if($validator->fails())
        {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput($request->all());
        }

        $category = new category(request(['name']));
        $category->save();
        return redirect(route('admin.category'))->with('status', 'Category added!');

    }

    public function update(category $category, request $request)
    {
       
        $validator = Validator::make($request->all(),[
            'name' =>'required|unique:category,name'
        ]);

        if($validator->fails())
        {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput($request->all());
        }
   
        $category->update(request(['name']));

        return redirect(route('admin.category'))->with('status','Category updated!');
    }

    public function delete($category)
    {   
        $post = Post::where('category_id', $category)->update(['category_id' => 5]);
        Category::destroy($category);
        return redirect(route('admin.category'))->with('status','Category deleted!');
        
    }
}
