@extends('layouts.app')

@section('content')
    <a href="{{ route('movies.index') }}" class="btn btn-outline-secondary mb-3">
        &larr; Back to All Reviews
    </a>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4 p-md-5">
            <div class="row g-5">
                
                {{-- Column 1: Poster --}}
                <div class="col-lg-4">
                    @if ($movie->poster_url)
                        <img src="{{ $movie->poster_url }}" 
                             class="poster-show-page shadow-sm" 
                             alt="{{ $movie->title }} Poster">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center h-100" style="min-height: 400px;">
                            <i class="bi bi-film fs-1 text-muted"></i>
                        </div>
                    @endif
                </div>

                {{-- Column 2: Details --}}
                <div class="col-lg-8">
                    
                    {{-- Header: Title, Year, Genre --}}
                    <h1 class="display-5 fw-bold mb-0 text-break">{{ $movie->title }}</h1>
                    <div class="fs-5 text-muted mb-3">
                        @if ($movie->release_year)
                            <span class="me-2">{{ $movie->release_year }}</span>
                            <span class="me-2">&bull;</span>
                        @endif
                        <span>{{ $movie->genre }}</span>
                    </div>

                    {{-- Star Rating --}}
                    <div class="star-rating fs-2 mb-4">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="bi {{ $i <= $movie->star_rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                        @endfor
                    </div>

                    {{-- Full Review Content --}}
                    <h4 class="fw-bold">Review</h4>
                    <p class="review-content mb-4">{{ $movie->review_content }}</p>

                    <hr class="my-4">

                    {{-- Action Buttons --}}
                    <div class="d-flex align-items-center">
                        <a href="{{ route('movies.edit', $movie->id) }}" class="btn btn-warning btn-lg me-2">Edit</a>
                        
                        <form action="{{ route('movies.destroy', $movie->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this review?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-lg">Delete</button>
                        </form>
                        
                        {{-- Timestamps --}}
                        <div class="ms-auto text-muted text-end">
                            <small>
                                Posted on: {{ $movie->created_at->format('M d, Y') }}<br>
                                @if ($movie->created_at != $movie->updated_at)
                                    Last updated: {{ $movie->updated_at->format('M d, Y') }}
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection