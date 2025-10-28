@extends('layouts.app')

@section('content')

    {{-- 1. Filter and Search Bar --}}
    <div class="card card-body shadow-sm mb-4">
        <form action="{{ route('movies.index') }}" method="GET">
            <input type="hidden" name="view" value="{{ $currentView }}">
            <div class="row g-3 align-items-end">
                
                {{-- Search Bar --}}
                <div class="col-lg-5 col-md-12">
                    <label for="search" class="form-label fw-bold">Search by Title</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="Search for a movie..." value="{{ $currentSearch ?? '' }}">
                </div>
                
                {{-- Genre Filter --}}
                <div class="col-lg-3 col-sm-6">
                    <label for="genre" class="form-label fw-bold">Genre</label>
                    <select name="genre" id="genre" class="form-select">
                        <option value="">All Genres</option>
                        @foreach ($genres as $genre)
                            <option value="{{ $genre }}" @if(isset($selectedGenre) && $selectedGenre == $genre) selected @endif>
                                {{ $genre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sort Dropdown --}}
                <div class="col-lg-2 col-sm-6">
                    <label for="sort" class="form-label fw-bold">Sort by</label>
                    <select name="sort" id="sort" class="form-select">
                        
                        {{-- Changed "Newest" --}}
                        <option value="date_desc" @if($currentSort == 'date_desc') selected @endif>Release (Newest)</option>
                        
                        {{-- Changed "Oldest" --}}
                        <option value="date_asc" @if($currentSort == 'date_asc') selected @endif>Release (Oldest)</option>
                        
                        <option value="rating_desc" @if($currentSort == 'rating_desc') selected @endif>Rating (High-Low)</option>
                        <option value="rating_asc" @if($currentSort == 'rating_asc') selected @endif>Rating (Low-High)</option>
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="col-lg-2 col-12 d-grid gap-2 d-lg-flex">
                    <button type="submit" class="btn btn-info">Apply</button>
                    <a href="{{ route('movies.index') }}" class="btn btn-outline-secondary">Clear</a>
                </div>
            </div>
            
            {{-- NEW: View Toggle Buttons --}}
            <hr class="my-3">
            <div class="d-flex justify-content-end align-items-center">
                <span class="text-muted me-2">View as:</span>
                <div class="btn-group" role="group">
                    {{-- Grid View Button --}}
                    <a href="{{ route('movies.index', array_merge(request()->query(), ['view' => 'grid'])) }}"
                       class="btn btn-sm {{ $currentView == 'grid' ? 'btn-primary' : 'btn-outline-secondary' }}">
                       <i class="bi bi-grid-fill"></i> Grid
                    </a>
                    {{-- List View Button --}}
                    <a href="{{ route('movies.index', array_merge(request()->query(), ['view' => 'list'])) }}" 
                       class="btn btn-sm {{ $currentView == 'list' ? 'btn-primary' : 'btn-outline-secondary' }}">
                       <i class="bi bi-list-ul"></i> List
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- 2. Movie List --}}
    @if ($movies->isEmpty())
        <div class="text-center p-5 bg-white rounded shadow-sm">
            <h3 class="text-muted">No movie reviews found.</h3>
            <p>Try adjusting your filters or be the first to <a href="{{ route('movies.create') }}">add one</a>!</p>
        </div>
    @else

        {{-- Start Conditional View Logic --}}
        
        @if ($currentView == 'grid')

            {{-- ########## START GRID VIEW ########## --}}
            <div class="row">
                @foreach ($movies as $movie)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-sm h-100">
                            {{-- Image --}}
                            @if ($movie->poster_url)
                                <img src="{{ $movie->poster_url }}" 
                                     class="card-img-top" 
                                     alt="{{ $movie->title }} Poster" 
                                     style="height: 300px; object-fit: cover; width: 100%;">
                            @else
                                 <div class="bg-light d-flex align-items-center justify-content-center" style="min-height: 300px;">
                                    <i class="bi bi-film fs-1 text-muted"></i>
                                </div>
                            @endif
                            
                            {{-- Card Body --}}
                            <div class="card-body d-flex flex-column">
                                <div>
                                    <h5 class="card-title fw-bold">{{ $movie->title }}</h5>
                                    <div class="mb-2">
                                        @if ($movie->release_year)
                                            <span class="text-muted me-2">{{ $movie->release_year }}</span>
                                        @endif
                                        <span class="badge bg-secondary">{{ $movie->genre }}</span>
                                    </div>
                                </div>
                                
                                {{-- Ratings --}}
                                <div class="d-flex align-items-center mb-2">
                                    <div class="star-rating fs-5 me-3">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="bi {{ $i <= $movie->star_rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                        @endfor
                                    </div>
                                    @php
                                        $average = \App\Models\Movie::where('title', $movie->title)->avg('star_rating');
                                    @endphp
                                    <small class="text-muted">
                                        (Avg: {{ number_format($average, 1) }}/5)
                                    </small>
                                </div>

                                {{-- Review Snippet --}}
                                <p class="card-text">
                                    {{ Str::limit($movie->review_content, 100) }}
                                </p>

                                {{-- Button --}}
                                <div class="mt-auto">
                                    <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-outline-primary">
                                        View Full Review
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- ########## END GRID VIEW ########## --}}

        @else

            {{-- ########## START LIST VIEW ########## --}}
            <div class="movie-list">
                @foreach ($movies as $movie)
                    <div class="card shadow-sm mb-4">
                        <div class="row g-0">
                            
                            {{-- Left Side: Image --}}
                            <div class="col-md-3">
                                @if ($movie->poster_url)
                                    <img src="{{ $movie->poster_url }}" 
                                         class="card-img-left rounded-start" 
                                         alt="{{ $movie->title }} Poster">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center h-100 rounded-start">
                                        <i class="bi bi-film fs-1 text-muted"></i>
                                    </div>
                                @endif
                            </div>

                            {{-- Right Side: Content --}}
                            <div class="col-md-9">
                                <div class="card-body d-flex flex-column h-100">
                                    
                                    <div>
                                        <h3 class="card-title fw-bold mb-0">{{ $movie->title }}</h3>
                                        <div class="mb-2">
                                            @if ($movie->release_year)
                                                <span class="text-muted me-2">{{ $movie->release_year }}</span>
                                            @endif
                                            <span class="badge bg-secondary">{{ $movie->genre }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="star-rating fs-5 me-3">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="bi {{ $i <= $movie->star_rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                            @endfor
                                        </div>
                                        @php
                                            $average = \App\Models\Movie::where('title', $movie->title)->avg('star_rating');
                                        @endphp
                                        <small class="text-muted">
                                            (Avg. for this title: {{ number_format($average, 1) }}/5)
                                        </small>
                                    </div>

                                    <p class="card-text">
                                        {{ Str::limit($movie->review_content, 200) }}
                                    </p>

                                    <div class="mt-auto">
                                        <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-outline-primary">
                                            View Full Review
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- ########## END LIST VIEW ########## --}}
        
        @endif
        {{-- End Conditional View Logic --}}

    @endif
@endsection