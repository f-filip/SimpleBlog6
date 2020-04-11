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
        if($this->restrictedCategory($category->id)){
            return redirect(route('admin.category'))->with('alert','Category cannot be changed');
        }
         
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

    public function restrictedCategory(string $category_id){
        if($category_id === '17'){
            return true;
        }

        return false;
        
    }

    public function delete(request $request)
    {   
        
        if($this->restrictedCategory($request->category_id)){
            return redirect(route('admin.category'))->with('alert','Category cannot be changed');
        }

        $post = Post::where('category_id', $request->category_id)->update(['category_id' => 12]);
        Category::destroy($request->category_id);
        return redirect(route('admin.category'))->with('status','Category deleted!');
        
    }
}
