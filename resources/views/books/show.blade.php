{{-- Extend the main layout --}}
@extends('layouts.app')

{{-- Set the page title --}}
@section('title', 'Explore Books')

{{-- Content section where you place your page content --}}
@section('content')
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
                    <div class="text-3xl mb-2">{{ $book['volumeInfo']['title'] ?? 'Title Not Available' }}</div>

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
                        <div><strong>Categories:</strong> {{ isset($book['volumeInfo']['categories']) ? implode(', ', $book['volumeInfo']['categories']) : 'None listed' }}</div>
                        <!-- Page Count -->
                        <div><strong>Page Count:</strong> {{ $book['volumeInfo']['pageCount'] ?? 'Page count not available' }}</div>
                    </div>

                    <!-- Link to Google Books -->
                    <div class="mt-4">
                        @if (isset($book['volumeInfo']['infoLink']))
                            <a href="{{ $book['volumeInfo']['infoLink'] }}" target="_blank" class="text-blue-500 hover:text-blue-600">More Info</a>
                        @else
                            <p>More information not available.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="md:col-span-3 mt-6">
                <div class="bg-white p-6 shadow-sm rounded-lg">
                    <h3 class="text-xl mb-4">Leave a Comment</h3>
                    <form action="{{ route('comments.store', $book['id']) }}" method="POST">
                        @csrf
                        <textarea name="body" class="w-full rounded border-gray-300" rows="4" placeholder="Your comment..." required></textarea>
                        <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Post Comment</button>
                    </form>
                </div>
                @if($comments->isNotEmpty())
                    @foreach($comments as $comment)
                        <div class="bg-white p-6 shadow-sm rounded-lg mt-2">
                            <div>{{ $comment->user->name }}: {{ $comment->body }} - {{$comment->updated_at->diffForHumans()}}</div>
                            @if (auth()->id() === $comment->user_id)
                                <!-- Edit Button (triggers modal or edit form) -->
                                <button onclick="document.getElementById('edit-comment-{{ $comment->id }}').style.display='block'">Edit</button>
                                <!-- Delete Button -->
                                <form action="{{ route('comments.delete', ['bookId' => $book['id'], 'commentId' => $comment->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                                </form>
                                
                                <div id="edit-comment-{{ $comment->id }}" style="display:none;">
                                <form action="{{ route('comments.update', ['bookId' => $book['id'], 'commentId' => $comment->id]) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <textarea name="body" class="w-full rounded border-gray-300" rows="3" required>{{ $comment->body }}</textarea>
                                    <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Update</button>
                                </form>

                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p>No comments available.</p>
                @endif
            </div>
        </div>
    </div>
    @endsection

