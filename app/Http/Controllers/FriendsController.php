<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{

    public function searchUsers(Request $request)
{
    $query = $request->input('search');
    $searchResults = User::where('name', 'LIKE', '%' . $query . '%')
                         ->where('id', '!=', Auth::id())  // Exclude the current user from search results
                         ->get();

    return redirect()->back()->with('search_results', $searchResults);
}


    public function friends()
{
    return $this->belongsToMany(User::class, 'friend_user', 'user_id', 'friend_id')
                ->wherePivot('is_confirmed', true); // Only confirmed friends
}

    public function sendRequest(Request $request)
    {
        $recipient = User::findOrFail($request->friend_id);
        Auth::user()->sentRequests()->attach($recipient);

        return back()->with('success', 'Friend request sent.');
    }

    public function acceptRequest($id)
    {
        $friendship = Auth::user()->friendRequests()->where('user_id', $id)->firstOrFail();
        $friendship->pivot->update(['is_confirmed' => true]);

        return back()->with('success', 'Friend request accepted.');
    }

    public function listFriends()
    {
        $friends = Auth::user()->friends();
        return view('friends.list', compact('friends'));
    }
}
