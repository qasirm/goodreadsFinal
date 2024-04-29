<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Book;

class BookSearchController extends Controller
{
    public function search(Request $request)
{
    $query = $request->input('query', 'circe'); // Use a default fallback query
    $startIndex = $request->input('startIndex', 0);
    $maxResults = $request->input('maxResults', 20);

    $url = "https://www.googleapis.com/books/v1/volumes?q={$query}&startIndex={$startIndex}&maxResults={$maxResults}&orderBy=relevance";
    $response = Http::get($url);
    $books = $response->json()['items'] ?? [];
    $totalItems = $response->json()['totalItems'] ?? 0;

    if ($request->ajax()) {
        return view('partials.books_grid', compact('books'));
    }

    return view('dashboard', compact('books', 'totalItems', 'startIndex', 'maxResults'));
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
    $books = Book::skip($startIndex)->take($maxResults)->get(); // Update this according to your data source

    if ($request->ajax()) {
        return view('partials.books_grid', compact('books'));
    }

    return view('dashboard', compact('books'));
}

    
}
