{{-- Extend the main layout --}}
@extends('layouts.app')

{{-- Set the page title --}}
@section('title', 'Favorites')

{{-- Content section where you place your page content --}}
@section('content')
    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6">
                @if ($favorites->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-2 gap-y-12">
                        @foreach ($favorites as $favorite)
                            <div class="bg-white h-80 rounded-3xl text-neutral-500 duration-300 hover:duration-100 hover:bg-neutral-200/40 transition-colors relative group">
                                <a href="{{ route('books.show', ['id' => $favorite->book->id]) }}" class="text-gray-900 hover:text-gray-600">
                                    <header class="p-4">
                                        <div class="text-md mb-1 truncate">{{ $favorite->book->title }}</div>
                                        <div class="text-sm font-medium text-gray-900 truncate">{{ $favorite->book->author }}</div>
                                        
                                    </header>
                                    <div class="flex-1 flex items-center justify-center">
                                        <img src="{{ $favorite->book->thumbnail }}" alt="Cover Image" class="object-cover mx-auto rounded-xl shadow-2xl" style="width: 120px; height: 180px;">
                                    </div>
                                    
                                </a>
                                <div class='flex justify-between p-5 align-middle'>
                                <span class="text-xs font-medium text-gray-400 pt-1">Favorited {{ $favorite->created_at->diffForHumans() }}</span> 
                                <button onclick="toggleFavorite(event, this)" class="text-gray-400 hover:text-red-500"
                                        data-id="{{ $favorite->book->id }}"
                                        data-title="{{ $favorite->book->title }}"
                                        data-author="{{ $favorite->book->author }}"
                                        data-thumbnail="{{ $favorite->book->thumbnail }}"
                                        data-description="{{ $favorite->book->description }}"
                                        
        data-favorited="{{ $favorite->book->favorites->contains('user_id', Auth::id()) ? 'true' : 'false' }}">
    <i class="{{ $favorite->book->favorites->contains('user_id', Auth::id()) ? 'fas fa-heart text-red-500' : 'far fa-heart' }}"></i>
                                        
                                </button>
                                </div>
                                
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No favorite books found!</p>
                @endif
            </div>
        </div>
    </div>
@endsection
