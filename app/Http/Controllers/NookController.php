<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class NookController extends Controller
{
    public function show($userId)
    {
        $user = User::with(['friends', 'favorites' => function($query) {
            $query->orderBy('created_at', 'desc');  // Order favorites by creation time, descending
        }])->findOrFail($userId);

        $favorites = $user->favorites;  // Extract favorites after they have been ordered

        return view('profile.my_nook', compact('user', 'favorites'));
    }

}
