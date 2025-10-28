<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Http\RedirectResponse;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = Movie::latest()->get();

        // Load the view and pass the $movies variable
        return view('movies.index', compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('movies.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming data
        $validated = $request->validate([
            'title' => 'required|string|max:191',
            'star_rating' => 'required|integer|min:1|max:5',
            'review_content' => 'required|string',
        ]);

        // 2. Create the new movie in the database
        // This works because we set $fillable in the Movie model
        Movie::create($validated);

        // 3. Redirect back to the index page with a success message
        return redirect()->route('movies.index')
            ->with('success', 'Movie review added successfully!');
    }

    /**
     * Display the specified resource.
     * We use Route Model Binding (Movie $movie) to automatically
     * find the movie by its ID or fail with a 404 error.
     */
    public function show(Movie $movie)
    {
        return view('movies.show', compact('movie'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        // Pass the specific movie data to the edit view
        return view('movies.edit', compact('movie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie): RedirectResponse
    {
        // 1. Validate the incoming data
        $validated = $request->validate([
            'title' => 'required|string|max:191',
            'star_rating' => 'required|integer|min:1|max:5',
            'review_content' => 'required|string',
        ]);

        // 2. Update the existing movie record
        $movie->update($validated);

        // 3. Redirect back to the movie's 'show' page with a success message
        return redirect()->route('movies.show', $movie->id)
            ->with('success', 'Movie review updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie): RedirectResponse
    {
        // Delete the movie record from the database
        $movie->delete();

        // Redirect back to the index page with a success message
        return redirect()->route('movies.index')
            ->with('success', 'Movie review deleted successfully.');
    }
}
