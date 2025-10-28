@extends('layouts.app')

@section('content')
    <h1>Edit Movie Review: {{ $movie->title }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- CHANGED: Form action points to the 'update' route and includes the movie ID --}}
    <form action="{{ route('movies.update', $movie->id) }}" method="POST">
        @csrf
        @method('PUT')  {{-- CHANGED: Tells Laravel we are making a PUT request --}}

        <div class="mb-3">
            <label for="title" class="form-label">Movie Title</label>
            {{-- CHANGED: 'value' now checks old input first, then uses $movie->title --}}
            <input type="text" class="form-control" id="title" name="title" 
                   value="{{ old('title', $movie->title) }}">
        </div>

        <div class="mb-3">
            <label for="star_rating" class="form-label">Star Rating (1-5)</label>
            <select class="form-select" id="star_rating" name="star_rating">
                {{-- CHANGED: Logic now checks old input first, then $movie->star_rating --}}
                @php $rating = old('star_rating', $movie->star_rating); @endphp
                <option value="1" @if($rating == 1) selected @endif>1 Star</option>
                <option value="2" @if($rating == 2) selected @endif>2 Stars</option>
                <option value="3" @if($rating == 3) selected @endif>3 Stars</option>
                <option value="4" @if($rating == 4) selected @endif>4 Stars</option>
                <option value="5" @if($rating == 5) selected @endif>5 Stars</option>
            </select>
        </div>
        
        <div class="mb-3">
        <label for="poster_url" class="form-label">Poster Image URL (Optional)</label>
        <input type="url" class="form-control" id="poster_url" name="poster_url" 
               placeholder="https://example.com/image.jpg"
               value="{{ old('poster_url', $movie->poster_url) }}">
        <div class="form-text">Find an image online and paste the full URL here.</div>
    </div>

        <div class="mb-3">
            <label for="review_content" class="form-label">Review</label>
            {{-- CHANGED: Textarea content is old input or the existing review --}}
            <textarea class="form-control" id="review_content" name="review_content" 
                      rows="5">{{ old('review_content', $movie->review_content) }}</textarea>
        </div>

        {{-- CHANGED: Button text --}}
        <button type="submit" class="btn btn-primary">Update Review</button>
        <a href="{{ route('movies.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection