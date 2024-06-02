<?php

namespace App\Http\Controllers;
use App\Traits\ApiResponser;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use ApiResponser;
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $postId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $postId)
    {
        $request->validate([
            'commentBody' => 'required|string|max:1000',
        ]);

        $post = Post::findOrFail($postId);

        $comment = new Comment([
            'commentBody' => $request->input('commentBody'),
            'user_id' => Auth::id(),
        ]);

        $post->comments()->save($comment);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }
}
