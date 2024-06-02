<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<p>{{ $post->commentBody }}</p>

<h3>Liked By:</h3>
<ul>
    @foreach ($likedUsers as $user)
        <li>{{ $user->name }}</li>
    @endforeach
</ul>
<a href="{{route('postIndex')}}" role="button" class="btn btn-dark">All posts</a>
