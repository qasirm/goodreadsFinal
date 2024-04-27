<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Comment;
use Illuminate\Http\Request;

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
        $comments = $book->comments()->orderBy('created_at', 'desc')->get();

        return view('books.show', ['book' => $book, 'comments' => $comments]);
    }
}
