<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Store a new post
    public function postStore(Request $request)
    {
        $request->validate([
            'body'  => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $post = new Post([
            'body' => $request->input('body'),
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
            $post->image = $imagePath;
        }

        $post->user_id = Auth::id(); // Associate post with user
        $post->save();

        return redirect()->route('postIndex')->with('success', 'Post created successfully.');
    }

    // List all posts (basic)
    public function postIndex()
    {
        $posts = Post::all();
        return view('posts.postIndex', compact('posts'));
    }

    // Show edit form
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.editPost', compact('post'));
    }

    // Update a post
    public function update(Request $request, $id)
    {
        $request->validate([
            'body'  => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $post = Post::findOrFail($id);
        $post->body = $request->body;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
            $post->image = $imagePath;
        }

        $post->save();
        return redirect()->route('postIndex')->with('success', 'Post updated successfully.');
    }

    // Delete a post
    public function destroy($id)
    {
        Post::destroy($id);
        return redirect()->route('postIndex')->with('success', 'Post deleted.');
    }

    // Like a post
    public function like(Post $post)
    {
        $like = new Like();
        $like->user_id = Auth::id();
        $like->post_id = $post->id;
        $like->save();

        return back()->with('success', 'Post liked.');
    }

    // Unlike a post
    public function unlike(Post $post)
    {
        $like = Like::where('user_id', Auth::id())
                    ->where('post_id', $post->id)
                    ->first();

        if ($like) {
            $like->delete();
        }

        return back()->with('success', 'Post unliked.');
    }

    // Show posts with comments
    public function index()
    {
        $posts = Post::with(['user', 'comments.user', 'likes'])->latest()->get();

        return view('posts.postIndex', compact('posts'));
    }

    // Show who liked a post
    public function likedUsers($id)
    {
        $post = Post::findOrFail($id);
        $likedUsers = $post->likedBy()->get();

        return view('posts.showWhoLiked', compact('post', 'likedUsers'));
    }
}
