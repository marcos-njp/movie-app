@extends('layouts.app')

@section('content')
    <h1>Add a New Movie Review</h1>

    {{-- Display validation errors if they exist --}}
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

    <form action="{{ route('movies.store') }}" method="POST">
        @csrf {{-- CSRF Token - Very important for security --}}

        <div class="mb-3">
            <label for="title" class="form-label">Movie Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
        </div>

        <div class="mb-3">
            <label for="star_rating" class="form-label">Star Rating (1-5)</label>
            <select class="form-select" id="star_rating" name="star_rating">
                <option value="" disabled selected>Choose a rating</option>
                <option value="1" @if (old('star_rating') == '1') selected @endif>1 Star</option>
                <option value="2" @if (old('star_rating') == '2') selected @endif>2 Stars</option>
                <option value="3" @if (old('star_rating') == '3') selected @endif>3 Stars</option>
                <option value="4" @if (old('star_rating') == '4') selected @endif>4 Stars</option>
                <option value="5" @if (old('star_rating') == '5') selected @endif>5 Stars</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="poster_url" class="form-label">Poster Image URL (Optional)</label>
            <input type="url" class="form-control" id="poster_url" name="poster_url"
                placeholder="https://example.com/image.jpg" value="{{ old('poster_url') }}">
            <div class="form-text">Find an image online and paste the full URL here.</div>
        </div>

        <div class="mb-3">
            <label for="genre" class="form-label">Genre</label>
            <select class="form-select" id="genre" name="genre">
                <option value="" disabled selected>Choose a genre</option>
                @foreach ($genres as $genre)
                    <option value="{{ $genre }}" @if (old('genre') == $genre) selected @endif>
                        {{ $genre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
        <label for="release_year" class="form-label">Release Year (Optional)</label>
        <input type="number" class="form-control" id="release_year" name="release_year" 
               min="1888" max="{{ date('Y') }}" 
               value="{{ old('release_year') }}"
               placeholder="E.g., 2023">
    </div>

        <div class="mb-3">
            <label for="review_content" class="form-label">Review</label>
            <textarea class="form-control" id="review_content" name="review_content" rows="5">{{ old('review_content') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Review</button>
        <a href="{{ route('movies.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
