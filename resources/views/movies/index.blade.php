@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>All Movie Reviews</h1>

        <form action="{{ route('movies.index') }}" method="GET" class="d-flex">
            <select name="genre" class="form-select me-2" onchange="this.form.submit()">
                <option value="">All Genres</option>
                @foreach ($genres as $genre)
                    <option value="{{ $genre }}" @if ($selectedGenre == $genre) selected @endif>
                        {{ $genre }}
                    </option>
                @endforeach
            </select>

            @if ($selectedGenre)
                <a href="{{ route('movies.index') }}" class="btn btn-outline-secondary">Clear</a>
            @endif
        </form>

        <a href="{{ route('movies.create') }}" class="btn btn-primary">Add New Review</a>
    </div>

    @if ($movies->isEmpty())
        <div class="alert alert-info">
            No movie reviews found. Be the first to add one!
        </div>
    @else
        <div class="row">
            @foreach ($movies as $movie)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100">

                        @if ($movie->poster_url)
                            <img src="{{ $movie->poster_url }}" class="card-img-top index-poster-img"
                                alt="{{ $movie->title }} Poster">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">
                                {{ $movie->title }}
                                {{-- ADD THIS @if --}}
                                @if ($movie->release_year)
                                    <span class="text-muted fw-normal">({{ $movie->release_year }})</span>
                                @endif
                            </h5>
                            <div class="star-rating mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $movie->star_rating)
                                        <i class="bi bi-star-fill"></i>
                                    @else
                                        <i class="bi bi-star"></i>
                                    @endif
                                @endfor
                            </div>

                            <span class="badge bg-secondary mb-2">{{ $movie->genre }}</span>

                            <p class="card-text">
                                {{ Str::limit($movie->review_content, 100) }}
                            </p>

                        </div>
                        <div class="card-footer">
                            <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-info btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
