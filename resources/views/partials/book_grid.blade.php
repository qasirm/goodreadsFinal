@foreach ($books as $book)
    <a href="{{ route('books.show', ['id' => $book->id]) }}" class="text-gray-900 hover:text-gray-600">
        <div class="bg-white h-80 rounded-3xl text-neutral-500 duration-300 hover:duration-100 hover:bg-neutral-200/40 transition-colors">
            <header class="p-4">
                <div class="text-md mb-1 truncate">{{ $book->title }}</div>
                <div class="text-sm font-medium mb-1 text-gray-900">{{ $book->author }}</div>
            </header>
            <div class="flex-1 flex items-center justify-center">
                <div class="p-4 2xl:max-h-80">
                    <img src="{{ $book->thumbnail }}" alt="Cover Image" style="width: 120px; height: 180px;" class="object-cover mx-auto rounded-xl shadow-2xl">
                </div>
            </div>
        </div>
    </a>
@endforeach
