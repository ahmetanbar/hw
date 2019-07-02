<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Storage;
// use Intervention\Image\Facades\Image;
class PostController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('posts/index',compact('posts'));
    }


    public function create(){
        return view('posts/create');
    }

    public function store(){
        $data = request() -> validate([
            'caption' => 'required',
            'image' => 'required|image'
        ]);

        $imagePath = request('image')->store('storage/uploads','public');
        dd($imagePath);
        // $image = Image::make(public_path("storage/{$imagePath}"))->fit(500,500);
        
        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);

        // \App\Post::create($data);

        return redirect('/profile/' . auth()->user()->id);
    }

    public function show(\App\Post $post){
        return view('posts/show',[
            'post' => $post
        ]);
    }
}
