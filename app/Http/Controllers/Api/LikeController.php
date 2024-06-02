<?php
namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponser;
class LikeController extends Controller
{
    use ApiResponser;
    /**
     * Store a newly created like in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $postId = $request->input('post_id');
        $post = Post::findOrFail($postId);

        $like = new Like([
            'user_id' => Auth::id(),
        ]);

        $post->likes()->save($like);

        return response()->json(['message' => 'Post liked successfully.']);
    }

    /**
     * Remove the specified like from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        $like = $post->likes()->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
            return response()->json(['message' => 'Post unliked successfully.']);
        }

        return response()->json(['message' => 'Like not found.'], 404);
    }
}
