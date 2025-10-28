@extends('layouts.app')
@section('content')

    <div class="row mb-3 align-items-end">
        <div class="col-md-4">
            <h1>All Movie Reviews</h1>
            <a href="{{ route('movies.create') }}" class="btn btn-primary">Add New Review</a>
        </div>

        {{-- Combined Filter/Search Form --}}
        <div class="col-md-8">
            <form action="{{ route('movies.index') }}" method="GET">
                <div class="row g-2">
                    {{-- Search Bar --}}
                    <div class="col-sm-6">
                        <label for="search" class="form-label">Search by Title</label>
                        <input type="text" class="form-control" id="search" name="search" placeholder="Search..."
                            value="{{ $currentSearch ?? '' }}">
                    </div>

                    {{-- Genre Filter --}}
                    <div class="col-sm-3">
                        <label for="genre" class="form-label">Genre</label>
                        <select name="genre" id="genre" class="form-select">
                            <option value="">All Genres</option>
                            @foreach ($genres as $genre)
                                <option value="{{ $genre }}" @if (isset($selectedGenre) && $selectedGenre == $genre) selected @endif>
                                    {{ $genre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Sort Dropdown --}}
                    <div class="col-sm-3">
                        <label for="sort" class="form-label">Sort by</label>
                        <select name="sort" id="sort" class="form-select">
                            <option value="date_desc" @if ($currentSort == 'date_desc') selected @endif>Newest</option>
                            <option value="date_asc" @if ($currentSort == 'date_asc') selected @endif>Oldest</option>
                            <option value="rating_desc" @if ($currentSort == 'rating_desc') selected @endif>Rating (High-Low)
                            </option>
                            <option value="rating_asc" @if ($currentSort == 'rating_asc') selected @endif>Rating (Low-High)
                            </option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-2">
                    <button type="submit" class="btn btn-info me-2">Apply Filters</button>
                    <a href="{{ route('movies.index') }}" class="btn btn-outline-secondary">Clear</a>
                </div>
            </form>
        </div>
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

                            {{-- Calculate and show average rating for this title --}}
                            @php
                                $average = \App\Models\Movie::where('title', $movie->title)->avg('star_rating');
                            @endphp
                            
                            <div class="mb-2">
                                <small class="text-muted">
                                    Avg. Rating for this title: {{ number_format($average, 1) }}
                                    <i class="bi bi-star-fill star-rating"></i>
                                </small>
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
