@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-8 offset-lg-2">

            <a href="{{ route('movies.index') }}" class="btn btn-outline-secondary mb-3">
                &larr; Back to All Reviews
            </a>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h1 class="mb-0">{{ $movie->title }}</h1>

                    {{-- Visual Star Rating --}}
                    <div class="star-rating fs-4">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $movie->star_rating)
                                <i class="bi bi-star-fill"></i>
                            @else
                                <i class="bi bi-star"></i>
                            @endif
                        @endfor
                    </div>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $movie->review_content }}</p>
                </div>
                <div class="card-footer text-muted">
                    <div class="row">
                        <div class="col-sm-6">
                            Posted on: {{ $movie->created_at->format('M d, Y') }}
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            {{-- Action Buttons --}}
                            <a href="{{ route('movies.edit', $movie->id) }}" class="btn btn-warning">Edit</a>

                            <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Are you sure you want to delete this review? This action cannot be undone.');">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
