<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Post;
use Auth;
use App\Comment;

class PostController extends Controller
{
    //
    public function post() { 
        return view('posts.post'); 
    }

    public function addPost(Request $request, $post_id){
       $this->validate($request, [
           'post_title' => 'required',
           'post_body' => 'required',
           'post_image' => 'required',
       ]);
       $posts = new Post;
       $posts = DB::table('users')
            ->join('posts', 'users.id', '=', 'posts.user_id')

            ->select('users.name', 'posts.*')
            ->where(['posts.id' => $post_id])
            ->get();    
        return $posts;
       $posts->post_title = $request->input('post_title');
       $posts->user_id = Auth::user()->id;
       $posts->post_body = $request->input('post_body');
       $posts->post_title = $request->input('post_title');

       if(Input::hasFile('post_image')){
           $file = Input::file('post_image');
        $file->move(public_path(). '/posts/',
        $file->getClientOriginalName());
        $url = URL::to("/") . '/posts/' .
            $file->getClientOriginalName();
       }
       $posts->post_image = $url;
       $posts->save();
       return redirect('/home', ['posts' => $posts])->
       with('response', 'Post Published Succesfully');

    }

    public function view($post_id){
        $posts = Post::where('id', '=', $post_id)->get();
        $comments = DB::table('users')
            ->join('comments', 'users.id', '=', 'comments.user_id')
            ->join('posts', 'comments.post_id', '=', 'posts.id')
            ->select('users.name', 'comments.*')
            ->where(['posts.id' => $post_id])
            ->get();        
        return view('posts.view', ['posts' => $posts, 'comments' => $comments]);
        
    }

    public function edit($post_id){
        $posts = Post::find($post_id);        
        return view('posts.edit', ['posts' => $posts]);
    }

    public function editPost(Request $request, $post_id){
        $this->validate($request, [
            'post_title' => 'required',
            'post_body' => 'required',
            'post_image' => 'required',
        ]);
        $posts = new Post;
        $posts->post_title = $request->input('post_title');
        $posts->user_id = Auth::user()->id;
        $posts->post_body = $request->input('post_body');
        $posts->post_title = $request->input('post_title');
 
        if(Input::hasFile('post_image')){
            $file = Input::file('post_image');
 $file->move(public_path(). '/posts/',
 $file->getClientOriginalName());
 $url = URL::to("/") . '/posts/' .
             $file->getClientOriginalName();
 
 
        }
        $posts->post_image = $url;
        $data = array(
             'post_title' => $posts->post_title,
             'user_id' => $posts->user_id,
             'post_body' => $posts->post_body,
             'post_image' => $posts->post_image
        );
        Post::where('id', $post_id)
        ->update($data);
        $posts->update();
        return redirect('/home')->
        with('response', 'Post Updated Succesfully');
    }

    public function deletePost($post_id){
        Post::where('id', $post_id)
        ->delete();
        return redirect('/home')->
        with('response', 'Post Deleted Succesfully');
    }

    public function comment(Request $request, $post_id){
        $this->validate($request, ['comment' => 'required']);
        $comment = new Comment;
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $post_id;
        $comment->comment = $request->input('comment');
        $comment->save();
        return redirect("view/{$post_id}")->with('response', 'Comment Added Successfully');
    }
}
