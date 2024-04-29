{{-- Extend the main layout --}}
@extends('layouts.app')

{{-- Set the page title --}}
@section('title', 'Explore Books')

{{-- Content section where you place your page content --}}
@section('content')
<div class="py-12">
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
        <div class="p-6 text-gray-900">
            <!-- Books Display -->
            @if (!empty($books))
                <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-2 gap-y-12">
                    @foreach ($books as $book)
                        <a href="{{ route('books.show', ['id' => $book['id']]) }}" class="text-gray-900 hover:text-gray-600">
                            <div class="bg-white h-80 rounded-3xl text-neutral-500 duration-300 hover:duration-100 hover:bg-neutral-200/40 transition-colors relative">
                                <header class="p-4">
                                    <div class="text-md mb-1 truncate">{{ $book['volumeInfo']['title'] ?? 'No Title' }}</div>
                                    <div class="text-sm font-medium text-gray-900 truncate">{{ $book['volumeInfo']['authors'][0] ?? 'No Author' }}</div>
                                </header>
                                <div class="flex-1 flex items-center justify-center">
                                    <img src="{{ $book['volumeInfo']['imageLinks']['thumbnail'] ?? '' }}" alt="Cover Image" style="width: 120px; height: 180px;" class="object-cover mx-auto rounded-xl shadow-2xl">
                                </div>
                                <button onclick="toggleFavorite(event, this)" class="absolute bottom-4 right-5 text-gray-400 hover:text-red-500 z-10"
                                        data-id="{{ $book['id'] }}"
                                        data-title="{{ $book['volumeInfo']['title'] }}"
                                        data-author="{{ $book['volumeInfo']['authors'][0] ?? '' }}"
                                        data-thumbnail="{{ $book['volumeInfo']['imageLinks']['thumbnail'] ?? '' }}"
                                        data-isbn="{{ $book['volumeInfo']['industryIdentifiers'][0]['identifier'] ?? '' }}"
                                        data-description="{{ $book['volumeInfo']['description'] ?? '' }}">
                                    <i class="{{ in_array($book['id'], $favoritedBookIds) ? 'fas fa-heart text-red-500' : 'far fa-heart' }}"></i>
                                </button>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p>No books found!</p>
            @endif
        </div>
    </div>
</div>
@endsection
