<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index','show','all','archive']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $posts = Post::PostWithCommentsUserTags()->get();
       return view('posts.index',[
           'posts' => $posts,//Post::all()
           'tab' => 'list'
       ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function archive()
    {
       $posts = Post::onlyTrashed()->withCount('comments')->get();
       return view('posts.index',[
           'posts' => $posts,
           'tab' => 'archive'
       ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
       $posts = Post::withTrashed()->withCount('comments')->get();
       return view('posts.index',[
           'posts' => $posts,
           'tab' => 'all'
       ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(/*Request*/StorePostRequest $request)
    {
        $data = $request->only(['title','content']);
        $data['slug'] = Str::slug($data['title'],'-');
        $data['active'] = false;
        $data['user_id'] = $request->user()->id;
        $post = Post::create($data);

        if($request->hasFile('picture')){

            $path = $request->file('picture')->store('posts');
            $image = new Image(['path' => $path]);
            $post->image()->save($image);
        }
        $request->session()->flash('status','the post was created !');
       return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $postShow = Cache::remember("post-show-{$id}", 60, function () use ($id) {
            return Post::with(['comments','tags','comments.user'])->findOrFail($id);
        });
        return view('posts.show',[
            'post' => $postShow
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if(Gate::denies('update',$post)){
            abort(403,'you can\'t edit this post !');
        }
        return view('posts.edit',['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(/*Request*/StorePostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        if(Gate::denies('update',$post)){
            abort(403,'you can\'t edit this post !');
        }
        if($request->hasFile('picture')){
            $path = $request->file('picture')->store('posts');
            if($post->image){
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            }else{
                $post->image()->save(Image::create(['path' => $path]));
            }
        }

        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->slug = Str::slug($request->input('title'),'-');
        $post->save();
        $request->session()->flash('status','the post was updated !');
       return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
         $post = Post::findOrFail($id);
        $post->delete();
        $this->authorize('delete',$post);


        $request->session()->flash('status','the post was deleted !');
       return redirect()->route('posts.index');
    }

    public function restore($id){
        $post = Post::onlyTrashed()->where('id',$id)->first();
        $this->authorize('restore',$post);
        $post->restore();
        return redirect()->back();
    }

    public function forcedelete($id){
         $post = Post::onlyTrashed()->where('id',$id)->first();
         $this->authorize('forceDelete',$post);
         $post->forcedelete();
        return redirect()->back();
    }
}
