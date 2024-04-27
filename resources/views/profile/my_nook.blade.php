@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $user->name }}'s Nook</h1>
    <p>{{ $user->bio }}</p>

    <h2>Friends</h2>
    <ul>
        @foreach ($user->friends as $friend)
            <li>{{ $friend->name }}</li>
        @endforeach
    </ul>

    <h2>Favorites</h2>
    <ul>
        @foreach ($user->favorites as $favorite)
            <li>{{ $favorite->name }}</li>  {{-- Adjust based on your favorite item attributes --}}
        @endforeach
    </ul>
</div>
@endsection
