<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Friends</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: rgb(141, 132, 197);">

    <div class="container py-4">
        <h1 class="text-white">Your Friends</h1>

        @if($friends->isEmpty())
            <p class="text-white">You don't have any friends yet.</p>
        @else
            <table class="table table-striped bg-light">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Profile Picture</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($friends as $friend)
                        <tr>
                            <td>{{ $friend->name }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $friend->image) }}" width="60" height="60" style="border-radius: 50%;" alt="Profile Picture">
                            </td>
                            <td>
                                <form action="{{ route('users.removeFriend', $friend->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Remove Friend</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('profile') }}" class="btn btn-warning mt-3">Back to Profile</a>
    </div>

</body>
</html>
