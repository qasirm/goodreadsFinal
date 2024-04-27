<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2 text-md text-gray-500">
            <a href="{{ url('/') }}" class="hover:underline">Home</a>
            <span>/</span>
            <span class="text-gray-800">{{ $book['volumeInfo']['title'] ?? 'Book Details' }}</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Book Cover Image -->
            <div class="md:col-span-1">
                @if (isset($book['volumeInfo']['imageLinks']['thumbnail']))
                    <img src="{{ $book['volumeInfo']['imageLinks']['thumbnail'] }}" alt="Book cover" class="h-240 shadow-xl rounded-lg">
                @else
                    <div class="italic">No cover image available</div>
                @endif
            </div>

            <!-- Book Details -->
            <div class="md:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Book Title -->
                    <div class="text-3xl mb-2">
                        {{ $book['volumeInfo']['title'] ?? 'Title Not Available' }}
                    </div>

                    <!-- Book Metadata -->
                    <div class="flex space-x-3 mb-3 text-sm text-gray-600">
                        <div>{{ $book['volumeInfo']['authors'][0] ?? 'Author Not Available' }}</div>
                        <div>•</div>
                        <div>{{ $book['volumeInfo']['publishedDate'] ?? 'Date Not Available' }}</div>
                    </div>

                    <!-- Description -->
                    <div class="text-gray-700 mt-4 prose max-w-none">
                        {!! $book['volumeInfo']['description'] ?? 'No description provided.' !!}
                    </div>

                    <!-- More Details -->
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <!-- Categories -->
                        <div>
                            <strong>Categories:</strong>
                            @if (isset($book['volumeInfo']['categories']))
                                {{ implode(', ', $book['volumeInfo']['categories']) }}
                            @else
                                None listed
                            @endif
                        </div>

                        <!-- Page Count -->
                        <div>
                            <strong>Page Count:</strong> {{ $book['volumeInfo']['pageCount'] ?? 'Page count not available' }}
                        </div>
                    </div>

                    <!-- Link to Google Books -->
                    <div class="mt-4">
                    @if (isset($book['volumeInfo']) && isset($book['volumeInfo']['infoLink']))
    <a href="{{ $book['volumeInfo']['infoLink'] }}" target="_blank" class="text-blue-500 hover:text-blue-600">
        More Info
    </a>
@else
    <p>More information not available.</p>
@endif

                    </div>
                </div>
            </div>
            <!-- Comment Form -->
<div class="mt-6 bg-white p-6 shadow-sm rounded-lg">
    <h3 class="text-xl mb-4">Leave a Comment</h3>
    <form action="{{ route('comments.store', $book['id']) }}" method="POST">
        @csrf
        <textarea name="body" class="w-full rounded border-gray-300" rows="4" placeholder="Your comment..." required></textarea>
        <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Post Comment</button>
    </form>
</div>
@if($comments->isNotEmpty())
    @foreach($comments as $comment)
    <div class="mt-6 bg-white p-6 shadow-sm rounded-lg">{{ $comment->user->name }}: {{ $comment->body }}</div>
    @endforeach
@else
    <p>No comments available.</p>
@endif

        </div>
        



        
    </div>
</x-app-layout>
