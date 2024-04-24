<x-app-layout>
    <x-slot name="header">
    <div class="flex items-center space-x-2 text-md text-gray-500">
            <a href="{{ url('/') }}" class="hover:underline">Home</a>
            <span>/</span>
            <span class="text-gray-800">{{ $book['volumeInfo']['title'] ?? 'Book Details' }}</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Book Title -->
                    <div class="text-3xl mb-2">
                        {{ $book['volumeInfo']['title'] ?? 'Title Not Available' }}
                    </div>

                    <!-- Book Cover Image -->
                    <div class="mb-4">
                        @if (isset($book['volumeInfo']['imageLinks']['thumbnail']))
                            <img src="{{ $book['volumeInfo']['imageLinks']['thumbnail'] }}" alt="Book cover" class="shadow-xl">
                        @else
                            <div class="italic">No cover image available</div>
                        @endif
                    </div>

                    <!-- Book Author -->
                    <div class="mb-1 text-lg">
                        <strong>Author:</strong> {{ $book['volumeInfo']['authors'][0] ?? 'Author Not Available' }}
                    </div>

                    <!-- Published Date -->
                    <div class="mb-1 text-lg">
                        <strong>Published Date:</strong> {{ $book['volumeInfo']['publishedDate'] ?? 'Date Not Available' }}
                    </div>

                    <!-- Publisher -->
                    <div class="mb-1 text-lg">
                        <strong>Publisher:</strong> {{ $book['volumeInfo']['publisher'] ?? 'Publisher Not Available' }}
                    </div>

                    <!-- Description -->
                    <div class="text-gray-700 mt-4">
                        {!! $book['volumeInfo']['description'] ?? 'No description provided.' !!}
                    </div>

                    <!-- Categories -->
                    <div class="mt-4">
                        <strong>Categories:</strong>
                        @if (isset($book['volumeInfo']['categories']))
                            {{ implode(', ', $book['volumeInfo']['categories']) }}
                        @else
                            None listed
                        @endif
                    </div>

                    <!-- Page Count -->
                    <div class="mt-4">
                        <strong>Page Count:</strong> {{ $book['volumeInfo']['pageCount'] ?? 'Page count not available' }}
                    </div>

                    <!-- Link to Google Books -->
                    <div class="mt-4">
                        <a href="{{ $book['volumeInfo']['infoLink'] }}" target="_blank" class="text-blue-500 hover:text-blue-600">
                            View on Google Books
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
