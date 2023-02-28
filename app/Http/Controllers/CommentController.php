<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //
    public function showCreateComment()
    {
        return view("createComment");
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|min:5|max:50',
            'content' => 'required|min:5|max:1000',
            'rating' => 'required|integer|max:5',
            'idPost' => 'required|integer',
        ]);

        $comment = new Comment();
        $comment->title = $validate["title"];
        $comment->content = $validate["content"];
        $comment->rating = $validate["rating"];
        $comment->idPost = $validate["idPost"];
        $comment->idUser = auth()->user()->id;

        if ($comment->save()) {
            return response()->json([
                'status' => 'succes',
                'msg' => 'succesfully inserted comment',
            ]);
        }
        return response()->json([
            'status' => 'error',
            'msg' => 'could not insert comment',
        ]);
    }
}
