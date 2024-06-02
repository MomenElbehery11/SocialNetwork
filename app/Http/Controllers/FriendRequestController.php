<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\FriendRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class FriendRequestController extends Controller
{

    public function send($id)
    {
        $recipient = User::findOrFail($id);
        $sender = Auth::user();

        if (FriendRequest::where('sender_id', $sender->id)->where('recipient_id', $recipient->id)->exists()) {
            return redirect()->back()->with('error', 'Friend request already sent.');
        }

        $friendRequest = new FriendRequest();
        $friendRequest->sender_id = $sender->id;
        $friendRequest->recipient_id = $recipient->id;
        $friendRequest->save();

        return redirect()->back()->with('success', 'Friend request sent.');
    }

    public function accept($id)
    {
        $friendRequest = FriendRequest::findOrFail($id);

        if ($friendRequest->recipient_id != Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $user = Auth::user();
        $user->friends()->attach($friendRequest->sender_id);
        $friendRequest->sender->friends()->attach($user->id);

        $friendRequest->delete();

        return redirect()->back()->with('success', 'Friend request accepted.');
    }

    public function reject($id)
    {
        $friendRequest = FriendRequest::findOrFail($id);

        if ($friendRequest->recipient_id != Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $friendRequest->delete();

        return redirect()->back()->with('success', 'Friend request rejected.');
    }
}
