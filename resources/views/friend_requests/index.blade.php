<!-- resources/views/friend_requests/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friend Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: rgb(106, 90, 205);">

    <div class="container py-4">
        <h1 class="text-white">Friend Requests</h1>

        @if($requests->isEmpty())
            <p class="text-white">No pending friend requests.</p>
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
                    @foreach($requests as $request)
                        <tr>
                            <td>{{ $request->sender->name }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $request->sender->image) }}" width="60" height="60" style="border-radius: 50%;" alt="Profile Picture">
                            </td>
                            <td>
                                <!-- Accept / Decline Buttons -->
                                <form action="{{ route('friend-request.accept', $request->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm">Accept</button>
                                </form>
                                <form action="{{ route('friend-request.decline', $request->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Decline</button>
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
