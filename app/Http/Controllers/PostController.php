<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function postStore(Request $request)
    {
        $post = new Post([
            'body' => $request->input('body'),
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
            $post->image = $imagePath;
        }

        // Use the relationship method to save the post
        $post->save();

        return redirect()->route('profile')->with('success', 'Post created successfully.');
   }

    public function postIndex()
    {
        $posts = Post::all();

        return view('posts.postIndex', compact('posts'));
    }
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.editPost', compact('post'));
    }

    // Method to handle the form submission
    public function update(Request $request, $id)
    {
        $post = Post::findorFail($id);
       $post->body=$request->body;

       if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('uploads', 'public');
        $post->image = $imagePath;
    }
       $post->save();
       return redirect()->route('postIndex');
    }
    public function destroy($id)
    {
        Post::destroy($id);
        return redirect()->route('postIndex');
    }
// Like--------------------------------------------------
    public function like(Post $post)
{
    $like = new Like();
    $like->user_id = Auth()->id();
    $like->post_id = $post->id;
    $like->save();

    return back();
}

public function unlike(Post $post)
{
    $like = Like::where('user_id', auth()->id())->where('post_id', $post->id)->first();
    if ($like) {
        $like->delete();
    }
    return back();
}
//view comments
public function index()
    {
        $posts = Post::with('comments.user')->get(); // Retrieve posts with comments and their users

        return view('posts.postIndex', compact('posts'));
    }
    public function likedUsers($id)
{
    $post = Post::findOrFail($id);
    $likedUsers = $post->likedBy()->get();

    return view('posts.showWhoLiked', compact('post', 'likedUsers'));
}
}
