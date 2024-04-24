<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query', 'programming'); // Default search keyword
        $startIndex = $request->input('startIndex', 0); // Start index for pagination
        $maxResults = 20; // Books per page

        $url = "https://www.googleapis.com/books/v1/volumes?q={$query}&startIndex={$startIndex}&maxResults={$maxResults}";

        $response = Http::get($url);
        $books = $response->json()['items'] ?? [];
        $totalItems = $response->json()['totalItems'] ?? 0;

        if ($request->ajax()) {
            return view('partials.books_grid', compact('books'));
        }

        return view('dashboard', compact('books', 'totalItems', 'startIndex', 'maxResults'));
    }

    public function index(Request $request)
{
    // Fetch initial data if necessary or handle the logic for the initial page load
    return view('dashboard', [
        'books' => [], // Initial data setup or fetch
        'startIndex' => 0,
        'maxResults' => 24,
        'totalItems' => 100 // Example static total, replace with actual dynamic count
    ]);
}

}
