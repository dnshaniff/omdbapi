@extends('layouts.main')

@section('title', __('messages.favorites.title'))

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold">{{ __('messages.favorites.title') }}</h1>
            <p class="lead text-muted">{{ __('messages.favorites.description') }}</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            @forelse($titles as $title)
                <div class="col-md-3 mb-4">
                    <div class="card movie-card shadow-sm h-100">
                        <img src="{{ $title['Poster'] }}" loading="lazy"
                            onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/2048px-No_image_available.svg.png';"
                            class="card-img-top poster-img" alt="{{ $title['Title'] }} poster">

                        <div class="card-body">
                            <h5 class="card-title">{{ $title['Title'] }}</h5>

                            @if (!empty($title['imdbRating']) && $title['imdbRating'] !== 'N/A')
                                <p class="mb-1"><strong>IMDb:</strong> ⭐ {{ $title['imdbRating'] }}/10</p>
                            @endif

                            @if (!empty($title['Genre']) && $title['Genre'] !== 'N/A')
                                <p class="mb-1"><strong>Genre:</strong> {{ $title['Genre'] }}</p>
                            @endif

                            @if (!empty($title['Runtime']) && $title['Runtime'] !== 'N/A')
                                <p class="mb-1"><strong>Runtime:</strong> {{ $title['Runtime'] }}</p>
                            @endif

                            <p class="mb-1"><strong>Year:</strong> {{ $title['Year'] }}</p>
                            <span class="badge bg-secondary text-capitalize">{{ $title['Type'] }}</span>

                            <a href="{{ route('titles.show', $title['imdbID']) }}"
                                class="btn btn-sm btn-outline-primary mt-2 w-100">
                                {{ __('messages.dashboard.view_details') }}
                            </a>

                            <form method="POST" action="{{ route('favorites.destroy', $title['imdbID']) }}"
                                class="mt-2 w-100">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger w-100">
                                    ❤️ {{ __('messages.dashboard.unfavorite') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">{{ __('messages.favorites.no_favorites') }}</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
