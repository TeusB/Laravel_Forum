<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function showPostIndex()
    {
        return view("postIndex");
    }

    public function showCreatePost()
    {
        return view("createPost");
    }
}
