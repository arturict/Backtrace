<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Routing\Controller;
use App\Http\Resources\Post as PostResource;

class PostController extends Controller
{
    public function index()
    {
        return PostResource::collection(Post::all());
    }
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return new PostResource($post);
    }
}
