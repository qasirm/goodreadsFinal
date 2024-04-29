@extends('layouts.nook')

@section('title', 'User Profile - ' . $user->name)

@section('content')
<div class='pb-12'>
    <h1 class='text-5xl'>{{ $user->name }}'s Nook</h1>
</div>
@if ($favorites->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-2 gap-y-12">
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
@endsection

@section('sidebar')
<div class="sticky top-0 max-h-screen overflow-auto flex flex-col pt-16 gap-10">
    <div class='p-4 bg-white rounded-xl center'>
        <form method="POST" action="{{ route('user.search') }}">
            @csrf
            <input type="text" name="search" placeholder="Search users..." class="border p-2 rounded">
            <button type="submit" class="p-2 bg-blue-500 text-white rounded">Search</button>
        </form>
        @if (session('search_results'))
        <ul class="mt-4">
        @foreach (session('search_results') as $result)
<li class="flex justify-between items-center p-2">
    <a href="{{ route('nook.show', $result->id) }}">{{ $result->name }}</a>
    @if ($result->receivedRequests->contains('id', auth()->id()) || $result->sentRequests->contains('id', auth()->id()))
        <span class="text-gray-500">Pending</span>
    @else
        <form method="POST" action="{{ route('friends.send') }}">
            @csrf
            <input type="hidden" name="friend_id" value="{{ $result->id }}">
            <button type="submit" class="p-1 bg-green-500 text-white rounded">+</button>
        </form>
    @endif
</li>
@endforeach

        </ul>
        @endif
    </div>
    <div class='p-4 bg-white rounded-xl'>
        <h3 class="text-xl font-semibold mb-3">Friends</h3>
        <ul>
            @forelse ($user->friends as $friend)
            <li>{{ $friend->name }}
                <form method="POST" action="{{ route('friends.remove', $friend->id) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white rounded p-1 ml-2">Remove</button>
                </form>
            </li>
            @empty
            <p>No friends yet.</p>
            @endforelse

            @if ($user->receivedRequests && $user->receivedRequests->isNotEmpty())
                @foreach ($user->receivedRequests as $request)
                <li>{{ $request->name }} (Pending)
                    <form method="POST" action="{{ route('friends.accept', $request->id) }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-blue-500 text-white rounded p-1">Accept</button>
                    </form>
                </li>
                @endforeach
            @endif
        </ul>
    </div>
    <div class='p-4 bg-white rounded-xl'>
        <h3 class="text-xl font-semibold mb-3">Comments</h3>
        @if ($user->comments->isEmpty())
            <p>No comments yet.</p>
        @else
            <div class="max-h-72 overflow-y-auto">
            @foreach ($user->comments()->orderBy('updated_at', 'desc')->get() as $comment)
            <div class="p-4 my-2 bg-gray-50 rounded-xl">
                <p class="text-sm font-semibold">{{ $user->name }}</p>
                <p>{{ $comment->body }}</p>
                <p class="text-xs">
                    @if ($comment->book)
                        {{ $comment->book->title }}
                    @else
                        <p>Book title not available.</p>
                    @endif
                </p>
            </div>
            @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
