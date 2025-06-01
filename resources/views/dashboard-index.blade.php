@extends('layouts.main')

@section('title', __('messages.title'))

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold">{{ __('messages.title') }}</h1>
            <p class="lead text-muted">{{ __('messages.description') }}</p>
        </div>

        @php
            $currentYear = now()->year;
        @endphp

        <form method="GET" action="{{ route('titles.index') }}" class="mb-4">
            <div class="row g-2">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control form-control-lg"
                        placeholder="{{ __('messages.search_placeholder') }}" value="{{ $keyword }}">
                </div>
                <div class="col-md-3">
                    <select name="year" class="form-select form-select-lg">
                        <option value="">All Years</option>
                        @for ($y = $currentYear; $y >= 1900; $y--)
                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button class="btn btn-primary btn-lg" type="submit">{{ __('messages.search') }}</button>
                </div>
                <div class="col-md-2 d-grid">
                    <a href="{{ route('titles.index') }}"
                        class="btn btn-outline-secondary btn-lg">{{ __('messages.reset') }}</a>
                </div>
            </div>
        </form>

        @if ($error)
            <div class="alert alert-danger text-center">{{ $error }}</div>
        @endif

        @if ($totalResults > 0)
            @php
                $start = ($page - 1) * 10 + 1;
                $end = $start + count($titles) - 1;
            @endphp
            <div id="result-info" class="mb-3 text-muted">
                {{ __('messages.showing') }} <strong>{{ $end }}</strong> {{ __('messages.of') }}
                <strong>{{ $totalResults }}</strong> {{ __('messages.results') }}
            </div>
        @endif

        <div class="row" id="title-list">
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
                                class="btn btn-sm btn-outline-primary mt-2 w-100">{{ __('messages.view_details') }}</a>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">{{ __('messages.no_results') }}</p>
                </div>
            @endforelse
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        const localeStrings = {
            showing: "{{ __('messages.showing') }}",
            of: "{{ __('messages.of') }}",
            results: "{{ __('messages.results') }}"
        };
    </script>

    <script>
        let page = {{ $page + 1 }};
        let isLoading = false;
        const totalResults = {{ $totalResults }};
        const keyword = "{{ $keyword }}";
        const year = "{{ $year }}";

        window.addEventListener('scroll', () => {
            const scrollBottom = window.innerHeight + window.scrollY >= document.body.offsetHeight - 300;

            if (scrollBottom && !isLoading && (page - 1) * 10 < totalResults) {
                isLoading = true;

                fetch(`{{ route('titles.loadMore') }}?search=${keyword}&page=${page}&year=${year}`)
                    .then(res => res.json())
                    .then(data => {
                        const list = document.getElementById('title-list');

                        data.forEach(title => {
                            const col = document.createElement('div');
                            col.className = 'col-md-3 mb-4';

                            const poster = title.Poster !== 'N/A' ? title.Poster :
                                'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/2048px-No_image_available.svg.png';

                            col.innerHTML = `
                            <div class="card movie-card shadow-sm h-100">
                                <img src="${poster}" loading="lazy" class="card-img-top" alt="${title.Title} poster">
                                <div class="card-body">
                                    <h5 class="card-title">${title.Title}</h5>
                                    ${title.imdbRating && title.imdbRating !== 'N/A' ? `<p><strong>IMDb:</strong> ⭐ ${title.imdbRating}/10</p>` : ''}
                                    ${title.Genre && title.Genre !== 'N/A' ? `<p><strong>Genre:</strong> ${title.Genre}</p>` : ''}
                                    ${title.Runtime && title.Runtime !== 'N/A' ? `<p><strong>Runtime:</strong> ${title.Runtime}</p>` : ''}
                                    <p><strong>Year:</strong> ${title.Year}</p>
                                    <span class="badge bg-secondary text-capitalize">${title.Type}</span>
                                    <a href="/titles/${title.imdbID}" class="btn btn-sm btn-outline-primary mt-2 w-100">View Details</a>
                                </div>
                            </div>
                        `;

                            list.appendChild(col);

                            const info = document.getElementById('result-info');
                            if (info) {
                                const newEnd = (page) * 10;
                                const maxShown = Math.min(newEnd, totalResults);
                                info.innerHTML =
                                    `${localeStrings.showing} <strong>${maxShown}</strong> ${localeStrings.of} <strong>${totalResults}</strong> ${localeStrings.results}`;
                            }
                        });

                        page++;
                        isLoading = false;
                    })
                    .catch(() => isLoading = false);
            }
        });
    </script>
@endpush
