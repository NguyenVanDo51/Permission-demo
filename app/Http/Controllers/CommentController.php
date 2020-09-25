<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Mockery\Exception;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'post' => 'required'
        ]);

        try {
            $post = Post::query()->findOrFail($data['post']);
            return $post->comments()->get();
        } catch (Exception $exception) {

        }
    }

    public function show(Comment $comment)
    {
        return $comment;
    }
}
