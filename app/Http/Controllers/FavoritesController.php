<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FavoritesController extends Controller
{
    public function index()
    {
        $favorites = Favorite::with('book')->where('user_id', auth()->id())->get();
        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|string',
            'isbn' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        Log::info('Toggle favorite request:', $request->all());

        DB::beginTransaction();
        try {
            $book = Book::firstOrCreate(
                ['id' => $request->id],
                [
                    'title' => $request->title,
                    'author' => $request->author ?? null,
                    'thumbnail' => $request->thumbnail ?? null,
                    'isbn' => $request->isbn ?? null,
                    'description' => $request->description ?? null,
                ]
            );

            $favorite = $book->favorites()->where('user_id', Auth::id())->first();

            if ($favorite) {
                $favorite->delete();
                $actionResult = false;
                $message = 'Book unfavorited successfully.';
            } else {
                $book->favorites()->create(['user_id' => Auth::id(), 'book_id' => $book->id]);
                $actionResult = true;
                $message = 'Book favorited successfully.';
            }

            DB::commit();
            return response()->json([
                'favorited' => $actionResult,
                'bookId' => $book->id,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to toggle favorite: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
