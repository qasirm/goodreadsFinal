<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class NookController extends Controller
{
    public function show($userId)
{
    $user = User::with(['friends', 'favorites'])->findOrFail($userId);
    $favorites = $user->favorites;  // Extract favorites for clarity and potential additional processing

    return view('profile.my_nook', compact('user', 'favorites'));
}

}
