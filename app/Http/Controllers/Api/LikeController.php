<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponser;

class LikeController extends Controller
{
    use ApiResponser;

    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);

        $postId = $validated['post_id'];
        $post = Post::findOrFail($postId);

        // Check if the user already liked the post
        $existingLike = $post->likes()->where('user_id', Auth::id())->first();
        if ($existingLike) {
            return $this->error('You already liked this post.', null, 409);
        }

        // Save the like
        $like = new Like(['user_id' => Auth::id()]);
        $post->likes()->save($like);

        return $this->success(null, 'Post liked successfully.', 201);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        $like = $post->likes()->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
            return $this->success(null, 'Post unliked successfully.', 200);
        }

        return $this->error('Like not found.', null, 404);
    }
}
