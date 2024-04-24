<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    public function index()
    {
        $favorites = Favorite::with('book')->where('user_id', auth()->id())->get();

        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Book $book)
    {
        $user = Auth::user();
        $favorite = $user->favorites()->where('book_id', $book->id)->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['favorited' => false]);
        } else {
            $user->favorites()->create(['book_id' => $book->id]);
            return response()->json(['favorited' => true]);
        }
    }
}

