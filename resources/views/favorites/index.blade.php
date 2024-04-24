<x-app-layout>
<!-- <x-slot name="header">
    <div class="flex items-center space-x-2 text-lg font-medium text-gray-700"> My favs</div>
    </x-slot> -->
    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 text-gray-900">
                    <!-- Books Display -->
                    @if (!empty($books))
                        <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-2 gap-y-12">
                            @foreach ($books as $book)

                            <a href="{{ route('books.show', ['id' => $book['id']]) }}" class="text-gray-900 hover:text-gray-600 ">
                            <div class="bg-white h-80 rounded-3xl text-neutral-500 duration-300 hover:duration-100 hover:bg-neutral-200/40 transition-colors">
                                <header class="p-4">
                                <div class="text-md mb-1 truncate">{{$book['volumeInfo']['title'] ?? ''}}</div>
                                <div class="text-sm font-medium mb- text-gray-900 truncate">{{ $book['volumeInfo']['authors']['0'] ?? '' }}</div>
                                </header>
                            <div class="flex-1 flex items-center justify-center">
                                <div class=" p-4 2xl:max-h-80">
                                        <img src="{{ $book['volumeInfo']['imageLinks']['thumbnail'] ?? '' }}" alt="Cover Image" style="width: 120px; height: 180px;" class="object-cover mx-auto rounded-xl shadow-2xl">
                                </div>
                            </div>
                            </div>
                            </a>
                            @endforeach
                        </div>
                    @endif
                </div>
        </div>
    </div>
</x-app-layout>