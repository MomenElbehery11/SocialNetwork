
<div class="container">
    <h1>Posts</h1>
    <a href="{{route('post.create')}}" class="btn btn-info">Add New Post</a>

    @foreach($posts as $post)
    <div class="card mb-3">
        <div class="card-body">
            <p class="card-text">{{ $post->body }}</p>

            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" width="300" height="300" alt="Post Image" style="max-width: 300px;">
            @endif

            {{-- عرض اسم وصورة صاحب البوست الحقيقي --}}
            <p class="card-text">By: {{ $post->user->name }}</p>
            <img src="{{ asset('storage/' . $post->user->image) }}" width="130" height="130" style="border-radius: 50%" alt="User Profile Picture" >

            <p class="card-text">{{ $post->created_at }}</p>

            <!-- Edit Button -->
            <a href="{{ route('post.edit', $post->id) }}" class="btn btn-warning">Edit</a>

            <!-- Display the number of likes -->
            <p>Likes: {{ $post->likes->count() }}</p>

            <!-- Delete Button -->
            <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: red">Delete</button>
            </form>
        </div>
    </div>

    <!-- Like / Unlike Button -->
    @if ($post->likes->contains('user_id', Auth()->id()))
        <form action="{{ route('post.unlike', $post->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="unlike">Unlike</button>
        </form>
    @else
        <form action="{{ route('post.like', $post->id) }}" method="POST">
            @csrf
            <button type="submit">Like</button>
        </form>
    @endif

    <!-- Comments Section -->
    <h4 style="color:rgb(204, 128, 65)">Comments:</h4>
    @foreach ($post->comments as $comment)
        <div class="mb-2 comment">
            <strong>{{ $comment->user->name }}</strong>
            <p>{{ $comment->commentBody }}</p>
        </div>
    @endforeach

    <!-- Add Comment Form -->
    <form action="{{ route('comments.store', $post->id) }}" method="POST">
        @csrf
        <textarea name="commentBody" rows="3" required></textarea>
        <button type="submit">Add Comment</button>
    </form>

    <!-- View Who Liked -->
    <form action="{{ route('post.liked-users', $post->id) }}" method="GET">
        <button type="submit" class="view-likes">View Users Who Liked</button>
    </form>

    <a href="{{route('profile')}}" class="btn btn-warning" role="button">Profile Page</a>

    @endforeach
</div>

<style>
/* Global Styles */
body {
    background: linear-gradient(135deg, #ff9a9e, #fad0c4, #fad0c4, #fbc2eb, #a18cd1, #fbc2eb);
    background-size: 400% 400%;
    animation: gradientBG 10s ease infinite;
    font-family: 'Poppins', sans-serif;
    color: #333;
    padding-top: 20px;
}

/* Gradient Animation */
@keyframes gradientBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Container */
.container {
    max-width: 900px;
    margin: auto;
    padding: 20px;
    background: rgba(255, 255, 255, 0.9);
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
    border-radius: 15px;
}

/* Title */
h1 {
    text-align: center;
    font-size: 30px;
    color: #fff;
    margin-bottom: 20px;
    font-weight: bold;
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
}

/* Buttons */
.btn {
    padding: 10px 15px;
    border-radius: 10px;
    font-weight: bold;
    transition: all 0.3s ease-in-out;
    box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.15);
}

.btn-info {
    background: linear-gradient(45deg, #17a2b8, #138496);
    border: none;
    color: #fff;
}

.btn-info:hover {
    background: linear-gradient(45deg, #138496, #0e6373);
    transform: scale(1.05);
}

.btn-warning {
    background: linear-gradient(45deg, #ffc107, #ff8c00);
    border: none;
    color: #fff;
}

.btn-warning:hover {
    background: linear-gradient(45deg, #ff8c00, #e07b00);
    transform: scale(1.05);
}

/* Post Cards */
.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.2);
    margin-bottom: 20px;
    overflow: hidden;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.25);
}

.card-body {
    padding: 20px;
}

/* Post Text */
.card-text {
    background: #ff4e50;
    color: white;
    padding: 12px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
}

/* Profile Image */
img {
    display: block;
    margin-top: 10px;
    border-radius: 10px;
    transition: transform 0.3s ease-in-out;
}

img:hover {
    transform: scale(1.05);
}

/* Like & Delete Buttons */
button {
    background: #28a745;
    color: white;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    border-radius: 8px;
    font-size: 14px;
    font-weight: bold;
    transition: all 0.3s ease-in-out;
    box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.15);
}

button:hover {
    background: #218838;
    transform: scale(1.05);
}

/* Unlike Button */
button.unlike {
    background: #dc3545;
}

button.unlike:hover {
    background: #c82333;
}

/* Comments Section */
h4 {
    margin-top: 15px;
    font-size: 22px;
    font-weight: bold;
    color: #fff;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
}

textarea {
    width: 100%;
    padding: 10px;
    border: 2px solid #ccc;
    border-radius: 8px;
    margin-top: 5px;
    font-size: 14px;
    transition: border 0.3s ease-in-out;
}

textarea:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0px 0px 8px rgba(0, 123, 255, 0.5);
}

/* Comment Section */
.comment {
    background: rgba(255, 255, 255, 0.9);
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 10px;
    box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.15);
}

.comment strong {
    color: #007bff;
}

/* View Likes Button */
.view-likes {
    background: #6c757d;
    color: white;
}

.view-likes:hover {
    background: #5a6268;
}

</style>
