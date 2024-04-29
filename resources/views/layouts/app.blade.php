<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <script>
        function toggleFavorite(event, element) {
            event.preventDefault(); 
            event.stopPropagation();
            const bookData = {
                id: element.getAttribute('data-id'),
                title: element.getAttribute('data-title'),
                author: element.getAttribute('data-author'),
                thumbnail: element.getAttribute('data-thumbnail'),
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

        @stack('scripts')
    </body>
</html>


