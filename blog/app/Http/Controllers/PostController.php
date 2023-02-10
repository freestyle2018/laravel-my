<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;


class PostController extends Controller
{

    //
    public function getPost(Request $request)
    {
        $posts = new Post;
        $slug = $request->slug;
        $post = $posts->where('slug', $slug)->first();

        return view('post')->with('post', $post);
    }
}
