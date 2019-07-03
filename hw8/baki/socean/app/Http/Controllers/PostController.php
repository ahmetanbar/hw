<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use DB;
use Auth;
use Illuminate\Support\Facades\Storage;
// use Intervention\Image\Facades\Image;
class PostController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $posts = Post::with('comments')->orderBy('created_at', 'desc')->get();
        // $posts    = Post::orderBy('created_at', 'desc')->get();
        // dd($comments);
        // $posts2 = Post::orderBy('created_at', 'desc')->get();
        // $posts = array();
        // foreach($posts2 as $post2){
        //     $comments = DB::table('posts_comments')->where('post_id',$post2->id)->get();
        //     $element = [$post2,$comments];
        //     array_push($posts,$element);
        // }

        // dd($posts);
        return view('posts/index',compact('posts'));


    }


    public function create(){
        return view('posts/create');
    }

    public function store(){
        if(!(Auth::user()->profile->image)){
            if(!(Auth::user()->describtion)){
                return redirect('profile/'.Auth::user()->id.'/edit')->withErrors('Please add a profile image and description to use interactive')->withInput();
            }
            return redirect('profile/'.Auth::user()->id.'/edit')->withErrors('Please add a profile image to use interactive')->withInput();
        }
        $data = request() -> validate([
            'caption' => 'required',
            'image' => 'required|image'
        ]);

        $imagePath = request('image')->store('storage/uploads','public');
        // dd($imagePath);
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

    public function delete(\App\Post $post){  //i want to done it w/o html form type.
        // dd($post['id']);
        $delete = DB::table('posts')->where('id',$post['id'])->get();
        $delete = json_decode($delete, true);
        // dd($delete[0]['user_id']);
        // dd(Auth::user()->id);
        if (Auth::user()->id == $delete[0]['user_id']){
            Post::destroy($post['id']);
            return back();
        }
        else{
            return back();
        }
      }


    public function edit($id){
        $post = Post::find($id);
        return view('posts.edit',compact('post'));
    }

    public function update(Request $request,$post){
        // dd($post);
        $request->validate([
            'caption'=>'required',
          ]);
        // dd($request);
        $share = Post::find($post);
        $share->caption = $request->get('caption'); 
        $share->save();
        // dd($share);
        return redirect('/')->with('success', 'Stock has been updated');
    }
}
