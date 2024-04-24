@foreach ($books as $book)
    <div class="p-4">
        <img src="{{ $book['volumeInfo']['imageLinks']['thumbnail'] ?? '' }}" alt="Cover Image" class="h-60 mb-2">
        <div class="text-lg font-bold mb-2">{{ $book['volumeInfo']['title'] ?? 'No Title' }}</div>
    </div>
@endforeach
