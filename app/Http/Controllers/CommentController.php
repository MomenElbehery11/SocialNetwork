<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            'commentBody' => 'required|string|max:1000',
        ]);

        $post = Post::findorFail($postId);

        Comment::create([
            'commentBody' => $request->input('commentBody'),
            'user_id' => Auth::id(),
            'post_id' => $post->id,
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }
}
