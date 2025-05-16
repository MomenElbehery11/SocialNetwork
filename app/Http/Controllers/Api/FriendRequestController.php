<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FriendRequest;
use App\Models\Friend;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    public function sendRequest($receiverId)
    {
        $exists = FriendRequest::where('sender_id', auth()->id())
            ->where('receiver_id', $receiverId)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'friend request was already sent before '], 400);
        }

        FriendRequest::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $receiverId,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'friend request was sent successfully'], 200);
    }

    public function showRequests()
    {
        $requests = FriendRequest::where('receiver_id', auth()->id())
            ->where('status', 'pending')
            ->get();

        return response()->json(['requests' => $requests], 200);
    }

    public function acceptRequest($requestId)
    {
        $request = FriendRequest::where('id', $requestId)
            ->where('receiver_id', auth()->id())
            ->firstOrFail();

        $request->update(['status' => 'accepted']);

        Friend::create([
            'user_id' => $request->sender_id,
            'friend_id' => $request->receiver_id,
        ]);

        Friend::create([
            'user_id' => $request->receiver_id,
            'friend_id' => $request->sender_id,
        ]);

        return response()->json(['message' => 'friend request was accepted, you are now friends'], 200);
    }

    public function declineRequest($requestId)
    {
        $request = FriendRequest::where('id', $requestId)
            ->where('receiver_id', auth()->id())
            ->firstOrFail();

        $request->update(['status' => 'declined']);

        return response()->json(['message' => 'friend request was declined.'], 200);
    }

    public function showFriends()
    {
        $friends = auth()->user()->friends;

        return response()->json(['friends' => $friends], 200);
    }
}
