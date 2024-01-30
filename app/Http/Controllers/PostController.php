<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Traits\ApiResponse;

class PostController extends Controller
{
    use ApiResponse;

    public function listPosts()
    {
        $posts = Post::all();
        return $this->ResponseSuccess(data: ["posts" => $posts], message: __('auth.list_successful'), statusCode: 200);

    }
}
