<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\post;
use App\Models\comment;
use Illuminate\Support\Facades\Auth;



class PostController extends Controller
{

    public function showPost(Request $request)
    {
        $validate = $request->validate([
            'idPost' => 'required|integer',
        ]);
        $data = post::with('comments:idPost,title,id')->where('id', $validate["idPost"])->get();
        return view("post", ['data' => $data]);
    }

    public function showPostIndex()
    {
        $posts = Post::with('comments:idPost,title,id')->withCount('comments')->with('user:id,name,id')->get('title');
        return view("postIndex", ['posts' => $posts]);
    }

    public function showCreatePost()
    {
        return view("createPost");
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|min:5|max:50',
            'content' => 'required|min:5|max:1000',
            'rating' => 'required|integer|max:5',
        ]);

        $post = new Post();
        $post->title = $validate["title"];
        $post->content = $validate["content"];
        $post->rating = $validate["rating"];
        $post->idUser = auth()->user()->id;

        if ($post->save()) {
            return back()->withErrors('je post is toegevoegd');
        }
        return back()->withErrors('kon post niet toevoegen');
    }
}
