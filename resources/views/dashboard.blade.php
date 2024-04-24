<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 text-gray-900">
                    <!-- Books Display -->
                    @if (!empty($books))
                        <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                            @foreach ($books as $book)
                                <div class="p-4">
                                    <a href="{{ route('books.show', ['id' => $book['id']]) }}" class="text-gray-900 hover:text-gray-600">
                                        <img src="{{ $book['volumeInfo']['imageLinks']['thumbnail'] ?? '' }}" alt="Cover Image" class="h-60 mb-2">
                                        <div class="text-lg font-bold mb-2">{{ $book['volumeInfo']['title'] ?? 'No Title' }}</div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
        </div>
    </div>
    <script src="{{ asset('js/bookScroll.js') }}"></script>
</x-app-layout>
