<script>
function toggleFavorite(event, element) {
    event.stopPropagation();

    const bookData = {
        id: element.getAttribute('data-id'),
        title: element.getAttribute('data-title'),
        author: element.getAttribute('data-author'),
        thumbnail: element.getAttribute('data-thumbnail'),
        isbn: element.getAttribute('data-isbn'),
        description: element.getAttribute('data-description')
    };

    fetch('/favorites/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(bookData)
    })
    .then(response => response.json())
    .then(data => {
        console.log(data.favorited ? 'Book favorited!' : 'Book unfavorited!');
        element.setAttribute('data-favorited', data.favorited ? 'true' : 'false');
        const iconElement = element.querySelector('i');
        iconElement.className = data.favorited ? 'fas fa-heart text-red-500' : 'far fa-heart';
    })
    .catch(error => console.error('Error:', error));
}

</script>

<x-app-layout>
<x-slot name="header">
    <div class="flex items-center space-x-2 text-lg font-medium text-gray-700"> Explore
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 text-gray-900">
                    <!-- Books Display -->
                    @if (!empty($books))
                        <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-2 gap-y-12">
                        @foreach ($books as $book)
                        <a href="{{ route('books.show', ['id' => $book['id']]) }}" class="text-gray-900 hover:text-gray-600 ">
                         
                        <div class="bg-white h-80 rounded-3xl text-neutral-500 duration-300 hover:duration-100 hover:bg-neutral-200/40 transition-colors relative">
                            <header class="p-4">
                                <div class="text-md mb-1 truncate">{{ $book['volumeInfo']['title'] ?? 'No Title' }}</div>
                                <div class="text-sm font-medium mb- text-gray-900 truncate">{{ $book['volumeInfo']['authors'][0] ?? 'No Author' }}</div>
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
                            <i class="far fa-heart"></i> <!-- Assume not favorited by default -->
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
</x-app-layout>