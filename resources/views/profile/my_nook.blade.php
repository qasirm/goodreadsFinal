
@extends('layouts.nook')
@section('title', 'User Profile - ' . $user->name)

@section('content')
<div class='pb-12'>
    <h1 class='text-5xl'>{{ $user->name }}'s Nook</h1>
</div>
        @if ($favorites->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-2 gap-y-12">
            @foreach ($favorites as $favorite)
            <x-book-card :book="$favorite->book" :isFavorited="true" />
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
                        <form method="POST" action="{{ route('friends.send') }}">
                            @csrf
                            <input type="hidden" name="friend_id" value="{{ $result->id }}">
                            <button type="submit" class="p-1 bg-green-500 text-white rounded">+</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class='p-4 bg-white rounded-xl'>
        <h3 class="text-xl font-semibold mb-3">Friends</h3>
        @if ($user->friends->isEmpty())
            <p>Add friends</p>
        @else
            <ul>
                @foreach ($user->friends as $friend)
                    <li>{{ $friend->name }}</li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class='p-4 bg-white rounded-xl'>
        <h3 class="text-xl font-semibold mb-3">Comments</h3>
        @if ($user->comments->isEmpty())
            <p>No comments yet.</p>
        @else
        <div class="max-h-72 overflow-y-auto"> <!-- Container for scrollable content -->
        @foreach ($user->comments()->orderBy('updated_at', 'desc')->get() as $comment)
        <div class="p-4 my-2 bg-gray-50 rounded-xl"> <!-- Styling for each comment -->
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


