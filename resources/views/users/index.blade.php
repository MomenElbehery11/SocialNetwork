<!DOCTYPE html>
<html>
<head>
    <title>All Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: rgb(106, 90, 205);">
    <div class="container py-4">
        <form action="{{ route('users.index') }}" method="GET" class="mb-4">
            <input type="text" name="query" placeholder="Search users..." class="form-control d-inline-block w-50">
            <button type="submit" class="btn btn-light">Search</button>
        </form>

        <h1 class="text-white">All Users</h1>

        @if ($users->isEmpty())
            <p class="text-white">No users found.</p>
        @else
            <table class="table table-striped bg-light">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Profile Picture</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $user->image) }}" width="60" height="60" style="border-radius: 50%;" alt="Profile Picture">
                            </td>
                            <td>
                                @php
                                    $friendRequest = \App\Models\FriendRequest::where(function($q) use ($authUser, $user) {
                                        $q->where('sender_id', $authUser->id)->where('receiver_id', $user->id);
                                    })->orWhere(function($q) use ($authUser, $user) {
                                        $q->where('sender_id', $user->id)->where('receiver_id', $authUser->id);
                                    })->first();
                                @endphp

                                @if (!$friendRequest)
                                    <form method="POST" action="{{ route('friend-request.send', $user->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Add Friend</button>
                                    </form>
                                @elseif ($friendRequest->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif ($friendRequest->status === 'accepted')
                                    <span class="badge bg-success">Friend</span>
                                @elseif ($friendRequest->status === 'declined')
                                    <span class="badge bg-danger">Declined</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('profile') }}" class="btn btn-warning mt-3">Profile Page</a>
    </div>
</body>
</html>
