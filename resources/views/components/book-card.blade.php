{{-- resources/views/components/book-card.blade.php --}}
<div class="bg-white h-80 rounded-3xl text-neutral-500 duration-300 hover:duration-100 hover:bg-neutral-200/40 transition-colors relative tooltip-container">
    <header class="p-4">
        <div class="text-md mb-1 truncate">{{ $book->title }}</div>
        <div class="text-sm font-medium text-gray-900 truncate">{{ $book->author }}</div>
    </header>
    <div class="flex-1 flex items-center justify-center">
        <img src="{{ $book->thumbnail }}" alt="Cover Image" style="width: 120px; height: 180px;" class="object-cover mx-auto rounded-xl shadow-2xl">
    </div>
    <button onclick="toggleFavorite(event, this)" class="absolute bottom-4 right-5 text-gray-400 hover:text-red-500 z-10"
            data-id="{{ $book->id }}"
            data-title="{{ $book->title }}"
            data-author="{{ $book->author }}"
            data-thumbnail="{{ $book->thumbnail }}"
            data-description="{{ $book->description }}">
        <i class="{{ $isFavorited ? 'fas fa-heart text-red-500' : 'far fa-heart' }}"></i>
    </button>
</div>
