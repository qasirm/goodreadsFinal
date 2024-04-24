<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Favorites
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @forelse ($favorites as $favorite)
                            <div class="rounded-lg shadow-lg p-4">
                                <div class="text-lg font-bold">{{ $favorite->book->title }}</div>
                                <img src="{{ $favorite->book->thumbnail }}" alt="Cover Image" class="rounded-lg mb-2">
                                <div>{{ $favorite->book->author }}</div>
                            </div>
                        @empty
                            <p>No favorite books found!</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
