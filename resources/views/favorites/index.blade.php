<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Favorites
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 ">
                    @if ($favorites->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-2 gap-y-12">
                            @foreach ($favorites as $favorite)
                                <a href="{{ route('books.show', ['id' => $favorite->book->id]) }}" class="text-gray-900 hover:text-gray-600">
                                    <div class="bg-white h-80 rounded-3xl text-neutral-500 duration-300 hover:duration-100 hover:bg-neutral-200/40 transition-colors relative">
                                        <header class="p-4">
                                            <div class="text-md mb-1 truncate">{{ $favorite->book->title }}</div>
                                            <div class="text-sm font-medium text-gray-900 truncate">{{ $favorite->book->author }}</div>
                                        </header>
                                        <div class="flex-1 flex items-center justify-center">
                                            <img src="{{ $favorite->book->thumbnail }}" alt="Cover Image" style="width: 120px; height: 180px;" class="object-cover mx-auto rounded-xl shadow-2xl">
                                        </div>
                                        <button onclick="toggleFavorite(this)" class="absolute bottom-4 right-5 text-gray-400 hover:text-red-500"
                                                data-id="{{ $favorite->book->id }}"
                                                data-title="{{ $favorite->book->title }}"
                                                data-author="{{ $favorite->book->author }}"
                                                data-thumbnail="{{ $favorite->book->thumbnail }}"
                                                data-description="{{ $favorite->book->description }}">
                                            <i class="{{ $favorite ? 'fas fa-heart text-red-500' : 'far fa-heart' }}"></i>
                                        </button>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p>No favorite books found!</p>
                    @endif
                </div>
            </div>
    </div>
</x-app-layout>
