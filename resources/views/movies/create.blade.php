@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
            
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">

                    {{-- Form Header --}}
                    <h1 class="h2 fw-bold">Add a New Movie Review</h1>
                    <p class="text-muted mb-4">Share your thoughts on a recent movie.</p>

                    <form action="{{ route('movies.store') }}" method="POST">
                        @csrf 

                        {{-- Title --}}
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Movie Title *</label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="{{ old('title') }}" required>
                        </div>

                        <div class="row g-3">
                            {{-- Star Rating --}}
                            <div class="col-md-4">
                                <label for="star_rating" class="form-label fw-bold">Star Rating *</label>
                                <select class="form-select" id="star_rating" name="star_rating" required>
                                    <option value="" disabled selected>Choose a rating</option>
                                    <option value="1" @if(old('star_rating') == '1') selected @endif>1 Star</option>
                                    <option value="2" @if(old('star_rating') == '2') selected @endif>2 Stars</option>
                                    <option value="3" @if(old('star_rating') == '3') selected @endif>3 Stars</option>
                                    <option value="4" @if(old('star_rating') == '4') selected @endif>4 Stars</option>
                                    <option value="5" @if(old('star_rating') == '5') selected @endif>5 Stars</option>
                                </select>
                            </div>

                            {{-- Genre --}}
                            <div class="col-md-4">
                                <label for="genre" class="form-label fw-bold">Genre *</label>
                                <select class="form-select" id="genre" name="genre" required>
                                    <option value="" disabled selected>Choose a genre</option>
                                    @foreach ($genres as $genre)
                                        <option value="{{ $genre }}" @if(old('genre') == $genre) selected @endif>
                                            {{ $genre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Release Year --}}
                            <div class="col-md-4">
                                <label for="release_year" class="form-label fw-bold">Release Year</label>
                                <input type="number" class="form-control" id="release_year" name="release_year" 
                                       min="1888" max="{{ date('Y') }}" 
                                       value="{{ old('release_year') }}" placeholder="E.g., 2023">
                            </div>
                        </div>

                        {{-- Poster URL --}}
                        <div class="mb-3 mt-3">
                            <label for="poster_url" class="form-label fw-bold">Poster Image URL</label>
                            <input type="url" class="form-control" id="poster_url" name="poster_url" 
                                   placeholder="https://example.com/image.jpg"
                                   value="{{ old('poster_url') }}">
                            <div class="form-text">Find an image online and paste the full URL.</div>
                        </div>

                        {{-- Review Content --}}
                        <div class="mb-3">
                            <label for="review_content" class="form-label fw-bold">Review *</label>
                            <textarea class="form-control" id="review_content" name="review_content" 
                                      rows="6" data-maxlength="5000" required
                                      oninput="updateCharCount(this)">{{ old('review_content') }}</textarea>
                            <div id="char-counter" class="form-text text-end">0 / 5000</div>
                        </div>

                        {{-- Buttons --}}
                        <hr class="my-4">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Save Review</button>
                            <a href="{{ route('movies.index') }}" class="btn btn-outline-secondary btn-lg">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection