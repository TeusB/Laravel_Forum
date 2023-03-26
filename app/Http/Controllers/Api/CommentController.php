<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Comment;
use App\Models\Post;

use App\Rules\ExistsCustom;

class CommentController extends Controller
{
    public function store(Request $request, $idPost)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|min:5|max:50',
                'content' => 'required|min:5|max:1000',
            ])->stopOnFirstFailure();

            $validatedData = $validator->validate();
        } catch (ValidationException $ex) {
            $error = $ex->validator->errors();
            return response()->json(
                [
                    'error' => $error,
                ],
                $ex->status
            );
        }
        Post::findorFail($idPost);

        $comment = new Comment();
        $comment->title = $validatedData["title"];
        $comment->content = $validatedData["content"];
        $comment->idPost = $idPost;
        $comment->idUser = $request->user()->id;

        if ($comment->save()) {
            return response()->json(
                [
                    'message' => 'your comment has been added',
                ],
                200
            );
        }

        return response()->json(
            [
                'error' => "could not add comment",
            ],
            500
        );
    }
}
