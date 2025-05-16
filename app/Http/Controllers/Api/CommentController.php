<?php

namespace App\Http\Controllers\Api;
use App\Traits\ApiResponser;
use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
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
        // Validate the comment body
        $request->validate([
            'commentBody' => 'required|string|max:1000',
        ]);

        // Find the post
        $post = Post::findOrFail($postId);

        // Check if user is authenticated
        if (!Auth::check()) {
            return $this->error('Unauthorized', 401);
        }

        // Create the comment
        $comment = new Comment([
            'commentBody' => $request->input('commentBody'),
            'user_id' => Auth::id(),
        ]);

        // Save the comment to the post
        $post->comments()->save($comment);

        // Return success response
        return $this->success([
            'message' => 'Comment added successfully.',
            'comment' => $comment
        ]);
    }

}
