<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>User Profile</title>
</head>
<body>
    <h1>Welcome, {{ Auth::user()->name }}</h1>
    <div class="p1">
        <img src="{{ asset('storage/' . Auth::user()->image) }}" width="130" height="130" style="border-radius: 50%" alt="Profile Picture">
        <br><br>

        <a href="{{ route('image') }}" class="btn btn-primary" role="button">Add Or Edit Profile Picture</a>
        <a href="{{ route('name') }}" class="btn btn-primary" role="button">Edit Name</a>
        <p>Email: {{ Auth::user()->email }}</p>
        <a href="{{ route('email') }}" class="btn btn-primary" role="button">Edit Email</a>
        <p>Bio: {{ Auth::user()->bio }}</p>
        
        {{-- ----------------- --}}
        <a href="{{ route('bio') }}" class="btn btn-primary" role="button">Add Or Edit Bio</a>
        {{-- ------------------------ --}}
        <br>
        
        {{-- show all users section --}}
        <br>
        <a href="{{ route('index') }}" role="button" class="btn btn-info">All Users</a>
        <a href="{{ route('dashboard') }}" role="button" class="btn btn-dark">Dashboard</a>
        <a href="{{ route('post.create') }}" role="button" class="btn btn-dark">Create New Post</a>
        <a href="{{ route('postIndex') }}" role="button" class="btn btn-dark">All Posts</a>

        {{-- Buttons for friends and friend requests --}}
        <br><br>
        <a href="{{ route('friends') }}" role="button" class="btn btn-success">My Friends</a>
        <a href="{{ route('friendRequests') }}" role="button" class="btn btn-warning">Friend Requests</a>

    </div>
    <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn btn-danger">
        Logout
    </button>
</form>

</body>
<style>
    body {
        background: Orange;
    }

    .p1 {
        text-align: center;
    }
</style>
</html>
