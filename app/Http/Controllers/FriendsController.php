<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class FriendsController extends Controller
{

    public function searchUsers(Request $request)
{
    $query = $request->input('search');
    $userId = auth()->id();

    $searchResults = User::where('name', 'LIKE', '%' . $query . '%')
                         ->where('id', '!=', $userId)
                         ->whereDoesntHave('friends', function ($q) use ($userId) {
                             $q->where('user_id', $userId); 
                         })
                         ->whereDoesntHave('receivedRequests', function ($q) use ($userId) {
                             $q->where('user_id', $userId);
                         })
                         ->whereDoesntHave('sentRequests', function ($q) use ($userId) {
                             $q->where('friend_id', $userId); 
                         })
                         ->get();

    return redirect()->back()->with('search_results', $searchResults);
}



    public function friends()
{
    return $this->belongsToMany(User::class, 'friend_user', 'user_id', 'friend_id')
                ->wherePivot('is_confirmed', true); 
}

public function sendRequest(Request $request)
    {
        $recipientId = $request->friend_id;
        $userId = Auth::id();

        $exists = DB::table('friendships')
                    ->where(function ($query) use ($userId, $recipientId) {
                        $query->where('user_id', $userId)->where('friend_id', $recipientId);
                    })
                    ->orWhere(function ($query) use ($userId, $recipientId) {
                        $query->where('user_id', $recipientId)->where('friend_id', $userId);
                    })
                    ->exists();

        if ($exists) {
            return back()->with('info', 'Friendship or request already exists.');
        }

       
        DB::table('friendships')->insert([
            'user_id' => $userId,
            'friend_id' => $recipientId,
            'is_confirmed' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Friend request sent.');
    }

    public function acceptRequest(Request $request, $senderId)
    {
        DB::transaction(function () use ($senderId) {
            $userId = Auth::id();

            DB::table('friendships')
                ->where('user_id', $senderId)
                ->where('friend_id', $userId)
                ->update(['is_confirmed' => true, 'updated_at' => now()]);
\
            DB::table('friendships')->insert([
                'user_id' => $userId,
                'friend_id' => $senderId,
                'is_confirmed' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return back()->with('success', 'Friend request accepted.');
    }

    public function listFriends()
    {
        $friends = Auth::user()->friends();
        return view('friends.list', compact('friends'));
    }

    public function removeFriend(Request $request, $friendId)
{
    $user = Auth::user();
    $user->friends()->detach($friendId);
    $user->receivedRequests()->detach($friendId); 

    return back()->with('success', 'Friend removed successfully.');
}

public function show($userId)
{
    $user = User::with(['friends', 'receivedRequests', 'comments'])->findOrFail($userId);
    return view('profile', compact('user'));
}


}
