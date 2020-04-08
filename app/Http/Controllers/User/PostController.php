<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\Post;
use App\Models\User\Tag;
use App\Models\User\Category;
use Auth;

class PostController extends Controller
{
    public function index()
    {
        return view('user.posts', [
        'posts'=>Post::Where('user_id',Auth::Id())->get(),
        'categories'=>Category::All()
        ]  );

    }

 
    public function filterPost(request $request)
    {
        $post = (new Post)->newQuery();

        if($request->has('category_id')){
            $post->whereIn('category_id',$request->category_id);
        } 
        
      
        if($request->has('sort_by') &&  $request->sort_by === '0'){
            $post->orderBy('published_at','asc');
        }
       
        if($request->has('sort_by') && $request->sort_by === '1'){
            $post->orderBy('published_at','desc');
        }

        $post = $post->where('user_id',Auth::Id())->get();

        return view('user.posts',[ 
        'posts'=> $post,
        'categories'=>Category::ALl()    
        ]);

        }

    public function create()
    {
        return view('user.create_post',[
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
    $post->user_id=Auth::id();
    $post->save();
    $post->tags()->attach(request('tags'));

    return redirect(route('user.posts'))->with('status', 'Post added!');

    }

    public function edit(post $post)
    {
        return view('user.edit_post',[
            'post'=>$post,
            'postTags'=>$post->tags,
            'tags'=>Tag::ALl(),
            'categories'=>Category::All()
        ]);
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
        return redirect(route('user.posts'))->with('status','Post updated!');

        }

        public function delete(post $post)
        {
            $post->delete();
            return redirect(route('user.posts'))->with('status','Post deleted');
    
        }
}
