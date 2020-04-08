<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Models\Admin\Tag;
use App\Models\Admin\Post;
use App\Models\Admin\User;
use Auth;

use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        return view ('admin.posts',[
            'posts' => Post::All(),
            'categories'=>Category::ALl(),
            'users'=>User::All()
        ]);
    }

    public function create()
    {
        return view('admin.create_post',[
            'tags'=>Tag::ALl(),
            'categories'=>Category::All()
        ]);
    }

    public function edit(post $post)
    {
        return view('admin.edit_post',[
            'post'=>$post,
            'postTags'=>$post->tags,
            'tags'=>Tag::ALl(),
            'categories'=>Category::All()
        ]);
    }

    public function store(request $request)
    {
        $validator = Validator::make($request->all(), [
            'slug'        => 'required|unique:posts|max:255',
            'title'       => 'required|max:255',
            'excerpt'     => 'required|max:255',
            'category_id' => 'required|integer',
            'tags'        => 'required',
            'body'        => 'required',
        ]);

        if($validator->fails())
        {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput($request->all());
        }
        
        $post = new Post(request(['slug','title','excerpt','category_id','body']));
        $post->user_id=Auth::user()->id;
        $post->save();
        $post->tags()->attach(request('tags'));

        return redirect(route('admin.posts'))->with('status', 'Post added!');

    }

    public function update(post $post, request $request)
    {
        $validator = Validator::make($request->all(), [
            "slug"        => "required|unique:posts,slug,".$post->id,
            'title'       => 'required|max:255',
            'excerpt'     => 'required|max:255',
            'category_id' => 'required|integer',
            'tags'        => 'required',
            'body'        => 'required',
        ]); 
        
    

        if($validator->fails())
        {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput($request->all());
        }

        $post->update(request(['slug','title','excerpt','body','category_id']));
        $post->tags()->sync($request->tags);
        return redirect(route('admin.posts'))->with('status','Post updated!');

        }

    public function delete(post $post)
    {
        $post->delete();
        return redirect(route('admin.posts'))->with('status','Post deleted');

    }

    public function approvePost(post $post)
    {
        $post->update(['published_at'=> new \DateTime(now())]);
        return redirect(route('admin.posts'))->with('status','Post approved');
    }

    public function disapprovePost(post $post)
    {
        $post->update(['published_at'=> null]);
        return redirect(route('admin.posts'))->with('status','Post disapproved');
    }

    public function filterPost( request $request)
    {
        $post = (new Post)->newQuery();

        if($request->has('category_id')){
            $post->whereIn('category_id',$request->category_id);
        } 
        
        if($request->has('user_id')){
            $post->whereIn('user_id', $request->user_id);
        }
      
        if($request->has('sort_by') &&  $request->sort_by === '0'){
            $post->orderBy('published_at','asc');
        }
       
        if($request->has('sort_by') && $request->sort_by === '1'){
            $post->orderBy('published_at','desc');
        }

        $post = $post->get();

        return view('admin.posts',[ 
        'posts'=> $post,
        'categories'=>Category::ALl(),
        'users'=>User::All()]);  
    
    }
    public function showUserPost(user $user)
    {
        return view('admin.user_post',[
            'posts'=> $user->posts,

        ]);
    }

}
