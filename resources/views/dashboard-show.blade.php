@extends('layouts.main')

@section('title', $title['Title'])

@section('content')
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mb-4">{{ __('messages.show.back') }}</a>

    <div class="row">
        <div class="col-md-4">
            <img src="{{ $title['Poster'] !== 'N/A' ? $title['Poster'] : 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/2048px-No_image_available.svg.png' }}"
                class="img-fluid rounded shadow-sm" alt="{{ $title['Title'] }}">
        </div>

        <div class="col-md-8">
            <h2 class="fw-bold">{{ $title['Title'] }} ({{ $title['Year'] }})</h2>
            <p class="text-muted">{{ $title['Genre'] }} • {{ $title['Runtime'] }} • Rated: {{ $title['Rated'] }}</p>

            <p><strong>{{ __('messages.show.plot') }}</strong> {{ $title['Plot'] }}</p>

            <ul class="list-unstyled">
                <li><strong>{{ __('messages.show.director') }}:</strong> {{ $title['Director'] }}</li>
                <li><strong>{{ __('messages.show.writer') }}:</strong> {{ $title['Writer'] }}</li>
                <li><strong>{{ __('messages.show.actors') }}:</strong> {{ $title['Actors'] }}</li>
                <li><strong>{{ __('messages.show.language') }}:</strong> {{ $title['Language'] }}</li>
                <li><strong>{{ __('messages.show.country') }}:</strong> {{ $title['Country'] }}</li>
                <li><strong>{{ __('messages.show.released') }}:</strong> {{ $title['Released'] }}</li>
                <li><strong>{{ __('messages.show.awards') }}:</strong> {{ $title['Awards'] }}</li>
                <li><strong>{{ __('messages.show.box_office') }}:</strong> {{ $title['BoxOffice'] }}</li>
                <li><strong>{{ __('messages.show.website') }}:</strong>
                    @if ($title['Website'] !== 'N/A')
                        <a href="{{ $title['Website'] }}" target="_blank">{{ $title['Website'] }}</a>
                    @else
                        <span class="text-muted">{{ __('messages.show.not_available') }}</span>
                    @endif
                </li>
            </ul>

            <h5 class="mt-4">{{ __('messages.show.ratings') }}:</h5>
            <ul>
                @foreach ($title['Ratings'] as $rating)
                    <li>{{ $rating['Source'] }}: {{ $rating['Value'] }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
