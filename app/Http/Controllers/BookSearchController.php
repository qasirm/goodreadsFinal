<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;

class BookSearchController extends Controller
{
    public function search(Request $request)
{
    $query = $request->input('query', 'circe');
    $url = "https://www.googleapis.com/books/v1/volumes?q={$query}&maxResults=40";
    $response = Http::get($url);
    $books = $response->json()['items'] ?? [];

    // Retrieve only the IDs of the favorited books for the logged-in user
    $favoritedBookIds = Auth::user()->favorites()->pluck('book_id')->toArray();

    return view('dashboard', compact('books', 'favoritedBookIds'));
}




public function show($id)
{
    $apiKey = env('GOOGLE_BOOKS_API_KEY', '');
    $url = "https://www.googleapis.com/books/v1/volumes/{$id}?key={$apiKey}";

    $response = Http::get($url);
    $book = $response->json();

    // Attempt to retrieve the local book entry to get comments
    $localBook = Book::where('id', $id)->first();

    // Fetch comments only if the book is found locally
    $comments = $localBook ? $localBook->comments()->orderBy('created_at', 'desc')->get() : collect();

    return view('books.show', compact('book', 'comments'));
}
 

    public function index(Request $request)
{
    $startIndex = $request->input('startIndex', 0);
    $maxResults = 24; // Number of books to fetch per page

    // Assuming you are fetching books from an API or database
    $books = Book::skip($startIndex)->take($maxResults)->get(); 
    $favoritedBookIds = Auth::user()->favorites()->pluck('book_id')->toArray();

    if ($request->ajax()) {
        return view('partials.books_grid', compact('books'));
    }

    return view('dashboard', compact('books', 'favoritedBookIds'));
}

    
}
