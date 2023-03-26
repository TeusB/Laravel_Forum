<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\post;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostResourcePrivate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{

    public function getAll()
    {
        return response()->json(
            [
                'posts' => PostResource::collection(Post::all()),
            ],
            200,
        );
    }

    public function getPostById($idPost)
    {
        return response()->json(
            [
                'post' => new PostResource(Post::findorFail($idPost)),
            ],
            200,
        );
    }


    public function getPostByIdPrivate($idPost)
    {
        $this->authorize('view', $post = Post::findorFail($idPost));
        return response()->json(
            [
                'post' => new PostResourcePrivate($post),
            ],
            200,
        );
    }

    public function delete($idPost)
    {
        $this->authorize('delete', $post = Post::findorFail($idPost));
        $post->delete();
        return response()->json(
            [
                'message' => "post has been deleted",
            ],
            200,
        );
    }

    public function update(Request $request, $idPost)
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

        $this->authorize('update', $post = Post::findorFail($idPost));

        $post->title = $validatedData["title"];
        $post->content = $validatedData["content"];

        if ($post->save()) {
            return response()->json(
                [
                    'message' => "your post has been updated",
                ],
                200
            );
        }

        return response()->json(
            [
                'error' => "could not update post",
            ],
            500
        );
    }

    public function store(Request $request)
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

        $post = new Post();
        $post->title = $validatedData["title"];
        $post->content = $validatedData["content"];
        $post->idUser = $request->user()->id;

        if ($post->save()) {
            return response()->json(
                [
                    'message' => "your post has been added",
                ],
                200
            );
        }

        return response()->json(
            [
                'error' => "could not insert post",
            ],
            500
        );
    }
}
