@extends('layouts.main')

@section('title', $title['Title'])

@section('content')
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mb-4">← Back</a>

    <div class="row">
        <div class="col-md-4">
            <img src="{{ $title['Poster'] !== 'N/A' ? $title['Poster'] : 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/2048px-No_image_available.svg.png' }}"
                class="img-fluid rounded shadow-sm" alt="{{ $title['Title'] }}">
        </div>

        <div class="col-md-8">
            <h2 class="fw-bold">{{ $title['Title'] }} ({{ $title['Year'] }})</h2>
            <p class="text-muted">{{ $title['Genre'] }} • {{ $title['Runtime'] }} • Rated: {{ $title['Rated'] }}</p>

            <p><strong>Plot:</strong> {{ $title['Plot'] }}</p>

            <ul class="list-unstyled">
                <li><strong>Director:</strong> {{ $title['Director'] }}</li>
                <li><strong>Writer:</strong> {{ $title['Writer'] }}</li>
                <li><strong>Actors:</strong> {{ $title['Actors'] }}</li>
                <li><strong>Language:</strong> {{ $title['Language'] }}</li>
                <li><strong>Country:</strong> {{ $title['Country'] }}</li>
                <li><strong>Released:</strong> {{ $title['Released'] }}</li>
                <li><strong>Awards:</strong> {{ $title['Awards'] }}</li>
                <li><strong>Box Office:</strong> {{ $title['BoxOffice'] }}</li>
                <li><strong>Website:</strong>
                    @if ($title['Website'] !== 'N/A')
                        <a href="{{ $title['Website'] }}" target="_blank">{{ $title['Website'] }}</a>
                    @else
                        <span class="text-muted">Not available</span>
                    @endif
                </li>
            </ul>

            <h5 class="mt-4">Ratings:</h5>
            <ul>
                @foreach ($title['Ratings'] as $rating)
                    <li>{{ $rating['Source'] }}: {{ $rating['Value'] }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
