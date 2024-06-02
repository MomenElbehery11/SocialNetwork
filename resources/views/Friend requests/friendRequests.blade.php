<!-- Blade view to display friend requests -->
@if ($friendRequests->isNotEmpty())
    <h2>Friend Requests</h2>
    <ul>
        @foreach ($friendRequests as $request)
            <li>
                <strong>{{ $request->sender->name }}</strong> sent you a friend request.
                <form method="POST" action="{{ route('friendrequests.accept', $request->id) }}">
                    @csrf
                    <button type="submit">Accept</button>
                </form>
                <form method="POST" action="{{ route('friendrequests.reject', $request->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Reject</button>
                </form>
            </li>
        @endforeach
    </ul>
@else
    <p>No friend requests</p>
@endif
