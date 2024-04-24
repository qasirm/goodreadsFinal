<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookSearchController extends Controller
{
    public function search(Request $request)
{
    $query = $request->input('query', 'popular'); // Use a default fallback query
    $startIndex = $request->input('startIndex', 0);
    $maxResults = $request->input('maxResults', 20);

    $url = "https://www.googleapis.com/books/v1/volumes?q={$query}&startIndex={$startIndex}&maxResults={$maxResults}";
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
    $apiKey = env('GOOGLE_BOOKS_API_KEY', ''); // Assuming you might reconsider using an API key
    $url = "https://www.googleapis.com/books/v1/volumes/{$id}?key={$apiKey}";

    $response = Http::get($url);
    $book = $response->json();

    return view('books.show', compact('book'));
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
