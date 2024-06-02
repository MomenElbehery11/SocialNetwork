<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<div class="container">
    <h1>Posts</h1>
    <a href="{{route('post.create')}}" class="btn btn-info">Add New Post</a>
    @foreach($posts as $post)
    <div class="card mb-3">
        <div class="card-body">
            <p class="card-text" style="background: blue;color:white">{{ $post->body }}</p>
            @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" width="300" height="300" alt="Post Image" style="max-width: 300px;">
        @endif
            <p class="card-text">{{ Auth::user()->name }}</p>
            <p class="card-text">{{ $post->created_at }}</p>

            {{-- <p class="card-text"><small class="text-muted">By {{ $post->user()->name }}</small></p> --}}
            <img src="{{asset('storage/'. Auth::user()->image)}}" width="130" height="130" style="border-radius: 50%" alt="Profile Picture">

            <!-- Edit Button -->
        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-warning">Edit</a>
        <!-- Display the number of likes -->
        <p>Likes: {{ $post->likes->count() }}</p>
            <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
      </div>
    </div>
    {{-- Like------------- --}}
    @if ($post->likes->contains('user_id', Auth()->id()))
            <form action="{{ route('post.unlike', $post->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Unlike</button>
            </form>
        @else
            <form action="{{ route('post.like', $post->id) }}" method="POST">
                @csrf
                <button type="submit">Like</button>
            </form>
        @endif
{{-- view comments --}}
<h4>Comments:</h4>
                    @foreach ($post->comments as $comment)
                        <div class="mb-2">
                            <strong>{{ $comment->user->name }}</strong>
                            <p>{{ $comment->commentBody }}</p>
                        </div>
                    @endforeach
    <!-- Comment Form -->
    <form action="{{ route('comments.store', $post->id) }}" method="POST">
        @csrf
        <textarea name="commentBody" rows="3" required></textarea>
        <button type="submit">Add Comment</button>
    </form>
    {{-- end of comment form --}}
    <!-- post.blade.php -->
<form action="{{ route('post.liked-users', $post->id) }}" method="GET">
    <button type="submit">View Users Who Liked</button>
</form>

    {{-- view who liked --}}
    <a href="{{route('profile')}}" class="btn btn-warning" role="button">Profile Page</a>
    @endforeach
</div>
<style>
    body{
        background: green;
    }
</style>
