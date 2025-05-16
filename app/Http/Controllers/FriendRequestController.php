<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FriendRequest;
use App\Models\Friend;
class FriendRequestController extends Controller
{
    public function sendRequest($receiverId)
    {
        $exists = FriendRequest::where('sender_id', auth()->id())
            ->where('receiver_id', $receiverId)
            ->exists();

        if ($exists) {
            return back()->with('message', 'friend request already sent.');
        }

        FriendRequest::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $receiverId,
            'status' => 'pending',
        ]);

        return back()->with('message', 'friend request sent successfully.');
    }

    public function showRequests()
    {
        $requests = FriendRequest::where('receiver_id', auth()->id())
            ->where('status', 'pending')
            ->get();

        return view('friend_requests.index', compact('requests'));
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

    return back()->with('message', 'تم قبول الطلب وأصبحتم أصدقاء.');
}

    public function declineRequest($requestId)
    {
        $request = FriendRequest::where('id', $requestId)
            ->where('receiver_id', auth()->id())
            ->firstOrFail();

        $request->update(['status' => 'declined']);

        return back()->with('message', 'friend request declined');
    }
public function showFriends()
{
    $friends = auth()->user()->friends; 

    return view('users.friends', compact('friends')); 
}

}
