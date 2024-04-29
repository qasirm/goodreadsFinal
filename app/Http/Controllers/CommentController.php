<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $bookId)
    {
        $request->validate([
            'body' => 'required|string'
        ]);

        $comment = new Comment();
        $comment->body = $request->body;
        $comment->user_id = auth()->id();
        $comment->book_id = $bookId;
        $comment->save();

        return back()->with('success', 'Comment added successfully.');
    }

    public function index($bookId)
    {
        $book = Book::with(['comments.user'])->findOrFail($bookId);

        return view('books.show', ['book' => $book, 'comments' => $comments]);
    }

    public function update(Request $request, $bookId, $commentId)
    {
        $comment = Comment::where('book_id', $bookId)->findOrFail($commentId);

        if ($comment->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized to edit this comment.');
        }

        $request->validate([
            'body' => 'required|string'
        ]);

        $comment->body = $request->body;
        $comment->save();

        return back()->with('success', 'Comment updated successfully.');
    }

    public function destroy($bookId, $commentId)
    {
        
        $comment = Comment::where('book_id', $bookId)->findOrFail($commentId);

        if ($comment->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized to delete this comment.');
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}
